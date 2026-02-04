<?php

namespace App\Http\Controllers;

use App\Models\Expense_Type;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{
    public function index()
    {

        $expenseTypes = Expense_Type::orderBy('id', 'desc')->paginate(10);
        return view('expenses.types.index', compact('expenseTypes'));
    }

    // Show create form
    public function create()
    {
        return view('expenses.type.create');
    }

    // Store new type
    public function store(Request $request)
    {


        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $name = strtoupper($request->name);


        if (Expense_Type::whereRaw('UPPER(name) = ?', [$name])->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['name' => 'This Expense Type already exists.']);
        }

        $code = 'EXP' . date('YmdHis');

        Expense_Type::create([
            'name' => $name,
            'description' => $request->description,
            'code' => $code,
        ]);

        return redirect()->route('expense-types.index')
            ->with('success', 'Expense Type created successfully');
    }

    // Show edit form
    public function edit($id)
    {


        $type = Expense_Type::findOrFail($id);
        return view('expenses.types.edit', compact('type'));
    }

    // Update
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $type = Expense_Type::findOrFail($id);
        $name = strtoupper($request->name);


        if (Expense_Type::whereRaw('UPPER(name) = ?', [$name])->where('id','!=',$id)->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['name' => 'This Expense Type already exists.']);
        }

        $type->update([
            'name' => $name,
            'description' => $request->description,
        ]);

        return redirect()->route('expense-types.index')
            ->with('success', 'Expense Type updated successfully');
    }


    public function destroy($id)
    {

        $type = Expense_Type::findOrFail($id);
        $type->delete();

        return redirect()->route('expense-types.index')
            ->with('success', 'Expense Type deleted successfully');
    }

    // AJAX Search
    public function search(Request $request)
    {


        $query = $request->search;
        $expenseTypes = Expense_Type::where('name','like',"%{$query}%")
            ->orWhere('code','like',"%{$query}%")
            ->paginate(10);

        return view('expenses.types.partials.table', compact('expenseTypes'))->render();
    }
}
