<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Expense_Type;
use App\Models\Perception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */

//    public function create()
//    {
//        $types = Expense_Type::orderBy('name')->get();
//        return view('expenses.create', compact('types'));
//    }



    public function create()
    {
        $types = Expense_Type::all();


        $balanceUSD = Perception::where('currency','USD')->sum('amount') - Expense::where('currency','USD')->sum('amount');
        $balanceCDF = Perception::where('currency','CDF')->sum('amount') - Expense::where('currency','CDF')->sum('amount');

        return view('expenses.create', compact('types','balanceUSD','balanceCDF'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'expense_type_id' => 'required|exists:expense__types,id',
            'description' => 'required|string|min:3',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'required|in:USD,CDF',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf'
        ]);


        $currency = $request->currency;
        $totalPerception = Perception::where('currency', $currency)->sum('amount');
        $totalExpenses = Expense::where('currency', $currency)->sum('amount');
        $balance = $totalPerception - $totalExpenses;

        if ($request->amount > $balance) {
            return back()->withInput()->withErrors([
                'amount' => "Impossible de dépenser plus que le solde disponible ({$balance} $currency)"
            ]);
        }


        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('expenses_files', 'public');
        }


        $last = Expense::latest()->first();
        $next = $last ? $last->id + 1 : 1;
        $code = 'EXP' . date('Y') . str_pad($next, 5, '0', STR_PAD_LEFT);


        Expense::create([
            'user' => Auth::user()->name ?? 'System',
            'expense_type_id' => $request->expense_type_id,
            'description' => $request->description,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'file' => $filePath,
            'code' => $code,
        ]);

        return redirect()->route('expenses.bon', Expense::latest()->first())
            ->with('success', 'Dépense enregistrée avec succès !');
    }
/**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        //
    }





    public function history(Request $request)
    {


        $query = Expense::with('type');


        if ($request->filled('type')) {
            $query->where('expense_type_id', $request->type);
        }


        if ($request->filled('period')) {

            if ($request->period == 'day') {
                $query->whereDate('created_at', today());
            }

            if ($request->period == 'week') {
                $query->whereBetween('created_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]);
            }

            if ($request->period == 'month') {
                $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
            }
        }


        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date,
                $request->end_date
            ]);
        }



        $expenses = $query
            ->orderBy('created_at','desc')
            ->paginate(7);

        $expenses->appends($request->all());



        $expenseUSD = Expense::where('currency','USD')->sum('amount');
        $expenseCDF = Expense::where('currency','CDF')->sum('amount');

        $perceptionUSD = Perception::where('currency','USD')->sum('amount');
        $perceptionCDF = Perception::where('currency','CDF')->sum('amount');



        $balanceUSD = $perceptionUSD - $expenseUSD;
        $balanceCDF = $perceptionCDF - $expenseCDF;


        return view('expenses.history', compact(
            'expenses',
            'balanceUSD',
            'balanceCDF'
        ));
    }

    public function bon(Expense $expense)
    {

        $expense->load('type');

        return view('expenses.bon', compact('expense'));
    }


}
