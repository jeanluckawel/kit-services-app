<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $customers = Customer::latest()->paginate(15);
        return view('customers.index', compact('customers'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_nat' => 'nullable|string|max:255',
            'rccm' => 'nullable|string|max:255',
            'nif' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
            'commune' => 'nullable|string|max:255',
            'quartier' => 'nullable|string|max:255',
            'avenue' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:254',
        ]);

        Customer::create($validated);

        return redirect()->route('customer.index')->with('success', 'Customer created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_nat' => 'nullable|string|max:255',
            'rccm' => 'nullable|string|max:255',
            'nif' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
            'commune' => 'nullable|string|max:255',
            'quartier' => 'nullable|string|max:255',
            'avenue' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:254',
        ]);

        $customer->update($validated);

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customer.index')->with('success', 'Customer deleted successfully!');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $customers = Customer::where('name', 'like', "%{$search}%")
            ->orWhere('ville', 'like', "%{$search}%")
            ->orderBy('id', 'desc')
            ->get();

        return view('customer.partials.table', compact('customers'));
    }
}
