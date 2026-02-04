<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
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
    public function create(Customer $customer)
    {
        return view('invoices.create', compact('customer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Customer $customer)
    {
        $request->validate([
            'description.*' => 'required|string',
            'unite.*'       => 'nullable|string',
            'quantity.*'    => 'required|integer|min:1',
            'nb_jours.*'    => 'nullable|integer|min:1',
            'pu.*'          => 'required|numeric|min:0',
            'po'            => 'nullable|string',
        ]);

        // On prépare la variable pour récupérer le numéro
        $numero_invoice = null;

        DB::transaction(function () use ($request, $customer, &$numero_invoice) {

            $existingInvoice = Invoice::where('po', $request->po)->first();

            if ($existingInvoice) {
                $numero_invoice = $existingInvoice->numero_invoice;
            } else {
                $numero_invoice = 'KIT_INV' . date('YmdHis') . rand(1000,9999);
            }

            foreach ($request->description as $index => $description) {

                $quantity = $request->quantity[$index] ?? 1;
                $pu       = $request->pu[$index] ?? 0;
                $nbJours  = $request->nb_jours[$index] ?? 1;

                Invoice::create([
                    'customer_id'    => $customer->id,
                    'po'             => $request->po,
                    'numero_invoice' => $numero_invoice,
                    'description'    => $description,
                    'unite'          => $request->unite[$index] ?? null,
                    'quantity'       => $quantity,
                    'nb_jours'       => $nbJours,
                    'pu'             => $pu,
                    'pt_jours'       => $quantity * $pu,
                    'pt_mois'        => $quantity * $pu * $nbJours,
                ]);
            }
        });


        return redirect()
            ->route('invoices.showByNumber', $numero_invoice)
            ->with('success', 'Invoice saved successfully!');
    }



    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {

        $customer = $invoice->customer;

        $invoices = Invoice::where('numero_invoice', $invoice->numero_invoice)
            ->get();

        return view('invoices.show', compact(
            'invoice',
            'customer',
            'invoices'
        ));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    public function statement(Request $request)
    {
        $customers = Customer::orderBy('name')->get();

        $invoices = Invoice::select(
            'customer_id',
            'numero_invoice',
            'po',
            DB::raw('SUM(pt_mois) as total_amount')
        )
            ->with('customer')

            ->when($request->customer_id, function ($q) use ($request) {
                $q->where('customer_id', $request->customer_id);
            })

            ->when($request->numero_invoice, function ($q) use ($request) {
                $q->where('numero_invoice','like','%'.$request->numero_invoice.'%');
            })

            ->groupBy('numero_invoice','po','customer_id')
            ->orderBy('numero_invoice','desc')
            ->paginate(20)
            ->withQueryString();

        return view('invoices.statement', compact('customers','invoices'));
    }

    public function showByNumber($numero)
    {
        $invoices = Invoice::where('numero_invoice', $numero)->get();
        $customer = $invoices->first()->customer ?? null;

        return view('invoices.show', compact('invoices', 'customer'));
    }

}
