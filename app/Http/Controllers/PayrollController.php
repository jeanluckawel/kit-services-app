<?php

namespace App\Http\Controllers;

use App\Exports\PayrollExport;
use App\Models\Employee\Employee;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $employees = Employee::where('status', 1)
            ->paginate(5);

        return view('Payroll.list', compact('employees'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Employee $employee)
    {
        return view('Payroll.create', compact('employee'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $employeeId)
    {
        // Validation
        $validated = $request->validate([
            'worked_days'   => 'required|numeric|min:0|max:31',
            'exchange_rate' => 'required|numeric|min:0',
            'sick_days'     => 'nullable|numeric|min:0|max:31',
            'overtime_30'   => 'nullable|numeric|min:0',
            'overtime_60'   => 'nullable|numeric|min:0',
            'overtime_100'  => 'nullable|numeric|min:0',
        ]);


        $employee = Employee::findOrFail($employeeId);

// baremic salary
        $baremic_salary = round(
            ($employee->salaries->base_salary ?? 0) * $validated['exchange_rate'] / 22 * $validated['worked_days']
        );

// sick days salary
        $sick_days = round(
            ($employee->salaries->base_salary ?? 0) * $validated['exchange_rate'] * 2/3 / 22 * ($validated['sick_days'] ?? 0)
        );

// logement
        $accommodation_allowance = round(($baremic_salary + $sick_days) * 0.3);

// ot 30%
        $ot_hours_30 = isset($validated['overtime_30'])
            ? round(($employee->salaries->base_salary ?? 0) * $validated['exchange_rate'] / 22 / 9 * $validated['overtime_30'] * 1.3)
            : 0;

// ot 60%
        $ot_hours_60 = isset($validated['overtime_60'])
            ? round(($employee->salaries->base_salary ?? 0) * $validated['exchange_rate'] / 22 / 9 * $validated['overtime_60'] * 1.6)
            : 0;

// ot 100%
        $ot_hours_100 = isset($validated['overtime_100'])
            ? round(($employee->salaries->base_salary ?? 0) * $validated['exchange_rate'] / 22 / 9 * $validated['overtime_100'] * 2)
            : 0;

// total earnings
        $total_earnings = round(
            $baremic_salary + $sick_days + $accommodation_allowance + $ot_hours_30 + $ot_hours_60 + $ot_hours_100
        );

// INSS 5%
        $inss_5 = round(($total_earnings - $accommodation_allowance) * 0.05);

// base INSS
        $inss_tax_base = round($total_earnings - $accommodation_allowance);

// base IPR
        $ipr_tax_base = round($inss_tax_base - $inss_5);

// annuel
        $annual_ipr_tax_base = round($ipr_tax_base * 12);

// tranche 2
        $tranche2 = 0;
        if ($annual_ipr_tax_base > 1944001) {
            $tranche2 = min($annual_ipr_tax_base - 1944001, 21600000 - 1944001);
        }
        $ipr_tranche2 = round($tranche2 * 0.15);

// tranche 3
        $tranche3 = 0;
        if ($annual_ipr_tax_base > 21600001 && $annual_ipr_tax_base <= 43200000) {
            $tranche3 = round(2948400 + ($annual_ipr_tax_base - 21600001) * 0.3);
        }

// tranche sup
        $tranche_gt3 = 0;
        if ($annual_ipr_tax_base > 43200000) {
            $tranche_gt3 = round(9428400 + ($annual_ipr_tax_base - 43200000) * 0.4);
        }

// deduction enfants
        $tax_dependants = $employee->children()->count();
        $deduction = round(($tax_dependants * 0.02) * $ipr_tranche2);

// total tranches
        $sum_tranches = round($ipr_tranche2 + $tranche3 + $tranche_gt3);

// ipr monthly
        if ($annual_ipr_tax_base > 0) {

            if (($sum_tranches / $annual_ipr_tax_base) < 0.3) {
                $ipr_monthly = round(($sum_tranches - $deduction) / 12);
            } else {
                $ipr_monthly = round((($annual_ipr_tax_base * 0.3) - $deduction) / 12);
            }

        } else {
            $ipr_monthly = 0;
        }

// taux ipr %
        $ipr_rate = $ipr_tax_base > 0
            ? round(($ipr_monthly / $ipr_tax_base) * 100)
            : 0;

// net
        $net = round($total_earnings - $inss_5 - $ipr_monthly);

// net usd
        $net_usd = round($net / $validated['exchange_rate']);

// CNSS 13%
        $cnss_13 = round($inss_tax_base * 0.13);

// INPP 2%
        $inpp = round($inss_tax_base * 0.02);

// ONEM 0.02%
        $onem = round($inss_tax_base * 0.002);

// total taxes
        $total_tax_cdf = round($inss_5 + $ipr_monthly + $cnss_13 + $inpp + $onem);

// kit service
        $kit = round(
            ($net_usd + ($total_tax_cdf / $validated['exchange_rate'])) * 0.1
        );
//  reference payroll

        $reference = 'kit-'. date('YmdHis');
//  year payroll
        $year = date('Y');

        $period = payrollPeriod();
        $start_date = $period['start'];
        $end_date   = $period['end'];

        $exist = Payroll::where('employee_id', $employee->employee_id)
            ->where('start_date',$start_date )
            ->where('end_date',$end_date)
            ->exists();

        if($exist) {
            return redirect()->back()->with('error', 'Payroll already exists for this period');
        }







        Payroll::create([
            'employee_id'      => $employee->employee_id,
            'worked_days'      => $validated['worked_days'],
            'exchange_rate'    => $validated['exchange_rate'],
            'basic_usd'         => $employee->salaries->base_salary,
            'baremic_salary' => $baremic_salary,
            'sick_days' => $sick_days,
            'accommodation_allowance' => $accommodation_allowance,

            'ot_hours_30' => $ot_hours_30,
            'ot_hours_60' => $ot_hours_60,
            'ot_hours_100' => $ot_hours_100,

            'total_earnings' => $total_earnings,

            'inss_tax_base' => $inss_tax_base,
            'inss_5' => $inss_5,

            'ipr_tax_base' => $ipr_tax_base,
            'annual_ipr_tax_base' => $annual_ipr_tax_base,

            'tranche2' => $ipr_tranche2,
            'tranche3' => $tranche3,
            'tranche_gt3' => $tranche_gt3,


//            '' => $deduction,

            'monthly_ipr' => $ipr_monthly,
            'ipr_rate' => $ipr_rate,

            'net' => $net,
            'net_usd' => $net_usd,

            'cnss_13' => $cnss_13,
            'inpp_2' => $inpp,
            'onem_02' => $onem,

            'total_taxes_cdf' => $total_tax_cdf,
            'kitservice_royalties' => $kit,
            'reference' => $reference,
            'status' => 'pending',
            'period' => '1',
            'year' => $year,
            'start_date' => $start_date,
            'end_date' => $end_date,

        ]);

        return redirect()
            ->route('payroll.index')
            ->with('success', 'Payroll created successfully!');

    }


    /**
     * Display the specified resource.
     */
    public function show($employeeId, $payrollReference)
    {
        $payroll = Payroll::with('employee.company')
            ->where('employee_id', $employeeId)
            ->where('reference', $payrollReference)
            ->firstOrFail();

        return view('payroll.show', compact('payroll'));
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payroll $payroll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payroll $payroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payroll $payroll)
    {
        //
    }

// PayrollController.php

    public function search(Request $request) {
        $payrolls = Payroll::where('employee_id','like','%'.$request->search.'%')
            ->orWhere('name','like','%'.$request->search.'%')
            ->latest()
            ->paginate(10);

        return view('Payroll.partials.search-result', compact('payrolls'));
    }

//    public function history(Request $request)
//    {
//        // Toutes les périodes possibles (exemple simple)
//        $periods = [
//            payrollPeriod(), // la période actuelle
//            // tu peux ajouter d'autres périodes si nécessaire
//        ];
//
//        $selectedStart = $request->has('period')
//            ? explode('|', $request->period)[0]
//            : payrollPeriod()['start'];
//
//        $selectedEnd = $request->has('period')
//            ? explode('|', $request->period)[1]
//            : payrollPeriod()['end'];
//
//        $payrolls = Payroll::with('employee')
//            ->where('start_date', $selectedStart)
//            ->where('end_date', $selectedEnd)
//            ->latest()
//            ->paginate(10);
//
//        return view('Payroll.history', compact('payrolls', 'periods', 'selectedStart', 'selectedEnd'));
//    }

//    public function history(Request $request)
//    {
//        // Période sélectionnée depuis le select
//        $selectedStart = $request->query('start') ?? Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
//        $selectedEnd   = $request->query('end') ?? Carbon::now()->endOfMonth()->format('Y-m-d');
//
//        // Récupérer toutes les périodes disponibles pour le select
//        $periods = Payroll::select('start_date','end_date')
//            ->groupBy('start_date','end_date')
//            ->orderByDesc('start_date')
//            ->get()
//            ->map(fn($p) => ['start'=>$p->start_date,'end'=>$p->end_date])
//            ->toArray();
//
//        // Récupérer les payes pour la période sélectionnée
//        $payrolls = Payroll::with('employee')
//            ->where('start_date', $selectedStart)
//            ->where('end_date', $selectedEnd)
//            ->latest()
//            ->paginate(10);
//
//        return view('payroll.history', compact('payrolls','periods','selectedStart','selectedEnd'));
//    }

    public function history(Request $request)
    {
        $query = Payroll::with('employee.company');


        if ($request->filled('employee')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->employee.'%')
                    ->orWhere('last_name', 'like', '%'.$request->employee.'%')
                    ->orWhere('employee_id', 'like', '%'.$request->employee.'%');
            });
        }


        if ($request->filled('reference')) {
            $query->where('reference','like','%'.$request->reference.'%');
        }


        if ($request->filled('period')) {
            $query->where('period',$request->period);
        }


        if ($request->filled('year')) {
            $query->whereYear('created_at',$request->year);
        }


        if ($request->filled('status')) {
            $query->where('status',$request->status);
        }

        $payrolls = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('Payroll.history', compact('payrolls'));
    }


    public function exportview()
    {
        $employees = Employee::all();

        return view('payroll.export', compact('employees'));
    }



    public function export(Request $request)
    {
        $filters = $request->only(['year', 'period', 'employee_id']);

        return Excel::download(new PayrollExport($filters), 'payroll.xlsx');
    }




}
