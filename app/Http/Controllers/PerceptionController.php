<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Perception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerceptionController extends Controller
{
    public function index()
    {
        $perceptions = Perception::orderBy('id','desc')->paginate(10);
        return view('perceptions.index', compact('perceptions'));
    }

    public function create()
    {
        return view('perceptions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'file' => 'nullable|file|max:10240',
            'currency' => 'required|in:USD,CDF',
        ]);

        $data = [
            'name' => strtoupper($request->name),
            'amount' => $request->amount,
            'currency' => $request->currency,
        ];

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('perceptions');
        }

        Perception::create($data);

        return redirect()->route('perceptions.index')->with('success','Perception added successfully');
    }

    public function destroy(Perception $perception)
    {
        $perception->delete();
        return redirect()->route('perceptions.index')->with('success','Perception deleted successfully');
    }

    public function search(Request $request)
    {
        $query = $request->search;
        $perceptions = Perception::where('name', 'like', "%$query%")
            ->orWhere('amount', 'like', "%$query%")
            ->orderBy('id','desc')
            ->paginate(10);

        return view('perceptions.partials.table', compact('perceptions'))->render();
    }



    public function history(Request $request)
    {
        $query = Expense::with('type');

        if ($request->filled('type')) {
            $query->where('expense_type_id', $request->type);
        }

        if ($request->filled('period')) {
            $today = now();

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


        $perceptions = $query->orderBy('created_at','desc')->paginate(7);
        $perceptions->appends($request->all());



        $totalPerceptionUSD = \App\Models\Perception::where('currency','USD')->sum('amount');
        $totalPerceptionCDF = \App\Models\Perception::where('currency','CDF')->sum('amount');

        $expenseUSD = Expense::where('currency','USD')->sum('amount');
        $expenseCDF = Expense::where('currency','CDF')->sum('amount');

        $balanceUSD = $totalPerceptionUSD - $expenseUSD;
        $balanceCDF = $totalPerceptionCDF - $expenseCDF;


        $totalUSD = $balanceUSD;
        $totalCDF = $balanceCDF;

        return view('perceptions.history', compact(
            'perceptions',
            'totalUSD',
            'totalCDF',
            'balanceUSD',
            'balanceCDF'
        ));
    }




}
