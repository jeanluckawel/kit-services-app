<?php

namespace App\Http\Controllers;

use App\Mail\QuickPayMail;
use App\Models\Employee\Employee;
use App\Models\Payroll;
use App\Models\QuickPay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class QuickPayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $currentMonth = now()->month;
        $currentYear  = now()->year;


        $paidEmployeeIds = QuickPay::where('period', $currentMonth)
            ->where('year', $currentYear)
            ->pluck('employee_id')
            ->toArray();


        $employee = Employee::where('status', 1)
            ->whereNotIn('employee_id', $paidEmployeeIds)
            ->get();


        return view('Payroll.quick_pays.create', compact('employee', 'currentMonth', 'currentYear'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1️⃣ Validation
        $validated = $request->validate([
            'employee_id'   => 'required|exists:employees,employee_id',
            'exchange_rate' => 'required|numeric|min:1',

            'period'        => 'required|integer|between:1,12',
            'year'          => 'required|integer|min:2000|max:2100',

            'day_work'      => 'required|integer|min:0|max:31',
            'day_sick'      => 'nullable|integer|min:0|max:31',
            'day_overtime'  => 'nullable|integer|min:0',
        ]);


        $alreadyPaid = QuickPay::where('employee_id', $validated['employee_id'])
            ->where('period', $validated['period'])
            ->where('year', $validated['year'])
            ->exists();

        if ($alreadyPaid) {
            return back()
                ->withInput()
                ->with('error', 'This employee has already been paid for this period.');
        }


        $employee = Employee::with(['salaries', 'children', 'address'])
            ->where('employee_id', $validated['employee_id'])
            ->firstOrFail();

        $baseSalary = $employee->salaries->base_salary ?? 0;
        $rate       = $validated['exchange_rate'];


        $barenic_salary = round(
            ($baseSalary * $rate / 22) * $validated['day_work']
        );

        $sick_salary = round(
            ($baseSalary * $rate * 2 / 3 / 22) * ($validated['day_sick'] ?? 0)
        );

        $accommodation = round(
            ($barenic_salary + $sick_salary) * 0.30
        );


        $overtime_salary = round(
            ($validated['day_overtime'] ?? 0) * 10 * $rate
        );


        $total_earnings = round(
            $barenic_salary + $sick_salary + $accommodation + $overtime_salary
        );


        $inss_tax_base = round($total_earnings - $accommodation);
        $inss_5        = round($inss_tax_base * 0.05);


        $ipr_tax_base = round($inss_tax_base - $inss_5);
        $annual_ipr   = round($ipr_tax_base * 12);

        $tranche2 = $annual_ipr > 1944001
            ? min($annual_ipr - 1944001, 21600000 - 1944001)
            : 0;

        $ipr_tranche2 = round($tranche2 * 0.15);

        $tranche3 = 0;
        if ($annual_ipr > 21600001 && $annual_ipr <= 43200000) {
            $tranche3 = round(2948400 + ($annual_ipr - 21600001) * 0.30);
        }

        $tranche_gt3 = $annual_ipr > 43200000
            ? round(9428400 + ($annual_ipr - 43200000) * 0.40)
            : 0;

        $tax_dependants = $employee->children->count();
        $deduction = round(($tax_dependants * 0.02) * $ipr_tranche2);

        $sum_tranches = $ipr_tranche2 + $tranche3 + $tranche_gt3;

        if ($annual_ipr > 0) {
            $ipr_monthly = (($sum_tranches / $annual_ipr) < 0.30)
                ? round(($sum_tranches - $deduction) / 12)
                : round((($annual_ipr * 0.30) - $deduction) / 12);
        } else {
            $ipr_monthly = 0;
        }


        $net = round($total_earnings - $inss_5 - $ipr_monthly);
        $net_usd = round($net / $rate);




        $quickPay = QuickPay::create([
            'employee_id'   => $employee->employee_id,
            'exchange_rate' => $rate,

            'period'        => $validated['period'],
            'year'          => $validated['year'],

            'day_work'      => $validated['day_work'],
            'work'          => $net_usd,

            'day_sick'      => $validated['day_sick'] ?? 0,
            'sick'          => $sick_salary,

            'day_overtime'  => $validated['day_overtime'] ?? 0,
            'overtime'      => $overtime_salary,
        ]);


        $email = $employee->address->email ?? 'jeanluckawel45@gmail.com';

        Mail::to($email)->send(new QuickPayMail($quickPay));


        return redirect()
            ->route('quick-pay.bulletin', $quickPay->id)
            ->with('success', 'Quick Pay saved and email sent successfully.');
    }
    public function bulletin($id)
    {
        $payroll = QuickPay::with([
            'employee.company',
            'employee.children'
        ])->findOrFail($id);


        $total_brut = $payroll->work + $payroll->sick + $payroll->overtime;


        $inss  = round($total_brut * 0.05, 2);
        $ipr   = round($total_brut * 0.10, 2);
        $total_deductions = $inss + $ipr;

        $net_usd = round($total_brut - $total_deductions, 2);
        $net_cdf = round($net_usd * $payroll->exchange_rate, 2);

        return view('Payroll.quick_pays.bulletin', compact(
            'payroll', 'total_brut', 'total_deductions', 'net_usd', 'net_cdf', 'inss', 'ipr'
        ));
    }
    /**
     * Display the specified resource.
     */
    public function show(QuickPay $quickPay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuickPay $quickPay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuickPay $quickPay)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuickPay $quickPay)
    {
        //
    }

    public function getEmployee($employee_id)
    {
        $employee = Employee::where('employee_id', $employee_id)->first();

        if (!$employee) {
            return response()->json(['error' => 'Employee not found']);
        }

        return response()->json([
            'full_name'   => $employee->first_name.' '.$employee->last_name.' '.$employee->middle_name,
            'department'  => $employee->company?->DepartmentRelation?->name  ?? 'N/A',
            'function'    => $employee->company?->jobTitleRelation?->name ??  'N/A',
            'category'    => $employee->salaries->category ?? 'N/A',
            'base_salary' => number_format($employee->salaries->base_salary ?? 0, 2).' USD',
        ]);
    }

    public function list(Request $request)
    {
        $search = $request->get('search', '');
        $filterPeriod = $request->get('period', now()->month);
        $filterYear = $request->get('year', now()->year);

        $employees = Employee::query()
            ->when($search, function ($q, $search) {
                $q->where('employee_id', 'like', "%$search%")
                    ->orWhereRaw("first_name || ' ' || last_name || ' ' || middle_name LIKE ?", ["%$search%"]);
            })
            ->with(['quickPays' => function ($q) use ($filterPeriod, $filterYear) {
                $q->where('period', $filterPeriod)
                    ->where('year', $filterYear)
                    ->latest();
            }])
            ->get();

        $paidEmployees = $employees->filter(fn($emp) => $emp->quickPays->isNotEmpty());
        $unpaidEmployees = $employees->filter(fn($emp) => $emp->quickPays->isEmpty());


        if ($request->ajax()) {
            return view('Payroll.quick_pays.partials.employee_table', compact('paidEmployees','unpaidEmployees'))->render();
        }

        return view('Payroll.quick_pays.list', compact('paidEmployees', 'unpaidEmployees', 'filterPeriod', 'filterYear'));
    }

    public function search(Request $request)
    {
        $search = $request->get('search', '');
        $filterPeriod = $request->get('period', null);

        $employees = Employee::query()
            ->when($search, function($q) use ($search){
                $q->where('employee_id','like',"%$search%")
                    ->orWhereRaw("first_name || ' ' || last_name || ' ' || middle_name LIKE ?", ["%$search%"]);
            })
            ->with(['quickPays' => function($q) use ($filterPeriod){
                if($filterPeriod){
                    $q->where('period', $filterPeriod);
                }
                $q->latest();
            }])
            ->paginate(10);


        return view('Payroll.quick_pays.partials.table', compact('employees', 'filterPeriod'))->render();
    }

    public function getEmployeesNotPaid(Request $request)
    {
        $month = $request->month ?? now()->month;
        $year  = $request->year ?? now()->year;


        $paidEmployeeIds = QuickPay::where('period', $month)
            ->where('year', $year)
            ->pluck('employee_id')
            ->toArray();


        $employees = Employee::where('status', 1)
            ->whereNotIn('employee_id', $paidEmployeeIds)
            ->get();


        return response()->json($employees);
    }

    public function listAjax(Request $request)
    {
        $search = $request->get('search', '');
        $filterPeriod = $request->get('period', null);
        $filterYear = $request->get('year', now()->year); // année par défaut

        // Récupérer tous les employés avec leurs paiements pour le filtre mois+année
        $employees = Employee::query()
            ->when($search, function ($q, $search) {
                $q->where('employee_id', 'like', "%$search%")
                    ->orWhereRaw("first_name || ' ' || last_name || ' ' || middle_name LIKE ?", ["%$search%"]);
            })
            ->with(['quickPays' => function ($q) use ($filterPeriod, $filterYear) {
                if ($filterPeriod) {
                    $q->where('period', $filterPeriod);
                }
                $q->where('year', $filterYear)->latest();
            }])
            ->get();

        // Filtrer employés payés et non payés
        $paidEmployees = $employees->filter(fn($emp) => $emp->quickPays->isNotEmpty());
        $unpaidEmployees = $employees->filter(fn($emp) => $emp->quickPays->isEmpty());

        // Retourner la partial Blade
        return view('Payroll.quick_pays.partials.employee_table', compact('paidEmployees', 'unpaidEmployees'))->render();
    }
}
