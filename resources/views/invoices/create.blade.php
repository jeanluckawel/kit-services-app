@extends('layoutsddd.app')

@section('title', 'Create Invoice - KIT SERVICES')

@section('content')

    <div class="card mb-4 m-5 border-0" style="border-radius:0;">
        <div class="card-header d-flex align-items-center"
             style="background-color:#FF6600;color:#fff;border-radius:0;">
            <h3 class="card-title mb-0">
                Create Invoice – {{ $customer->name }}
            </h3>
            <nav aria-label="breadcrumb" class="ms-auto">
                <ol class="breadcrumb mb-0 bg-transparent">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-white">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customer.index') }}" class="text-white">Customers</a></li>
                    <li class="breadcrumb-item active text-white">Invoice</li>
                </ol>
            </nav>
        </div>

        <div class="card-body">


            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('invoices.store', $customer->id) }}" method="POST">
                @csrf
                <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">PO Number</label>
                        <input type="text" name="po" class="form-control" style="border-radius:0;" placeholder="Enter PO number" value="{{ old('po') }}">
                    </div>
                </div>

                {{-- Ligne de facture --}}
                <div id="invoice-items">
                    <div class="item-row mb-4 border p-3 bg-light position-relative">

                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 remove-btn d-none" onclick="removeRow(this)">➖</button>

                        <div class="row g-3 mb-2">
                            <div class="col-md-3">
                                <input type="text" name="description[]" class="form-control" style="border-radius:0;" placeholder="Description" value="{{ old('description.0') }}" required>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="unite[]" class="form-control" style="border-radius:0;" placeholder="Unit" value="{{ old('unite.0') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="quantity[]" class="form-control qty" style="border-radius:0;" value="{{ old('quantity.0',1) }}" min="1" placeholder="Quantity">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="pu[]" class="form-control pu" style="border-radius:0;" value="{{ old('pu.0',0) }}" step="0.01" placeholder="Unit Price">
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-3">
                                <input type="number" name="pt_jours[]" class="form-control pt_jours" style="border-radius:0;" readonly placeholder="Total / Day" value="{{ old('pt_jours.0',0) }}">
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="nb_jours[]" class="form-control nb_jours" style="border-radius:0;" value="{{ old('nb_jours.0',1) }}" min="1" placeholder="Number of Days">
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="pt_mois[]" class="form-control pt_mois" style="border-radius:0;" readonly placeholder="Total / Month" value="{{ old('pt_mois.0',0) }}">
                            </div>
                        </div>

                    </div>
                </div>

                <button type="button" class="btn btn-warning text-white btn-sm mb-4" style="background-color:#FF6600;border-color:#FF6600;" onclick="addRow()">➕</button>


                <div class="card mt-4" style="border-radius:0;">
                    <div class="card-header fw-bold" style="background:#f8f9fa;">Proforma Invoice Preview</div>
                    <div class="card-body p-0">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>Unit</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Total / Day</th>
                                <th>Days</th>
                                <th>Total / Month</th>
                            </tr>
                            </thead>
                            <tbody id="proforma-items"></tbody>
                        </table>
                    </div>
                    <div class="card-footer text-end">
                        <p>Sub Total : $ <span id="subtotal">0.00</span></p>
                        <p>VAT (16%) : $ <span id="tva">0.00</span></p>
                        <h5 class="fw-bold" style="color:#FF6600;">Grand Total : $ <span id="total">0.00</span></h5>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn text-white" style="background-color:#FF6600;border-color:#FF6600;">Save</button>
                    <a href="#" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>
    </div>

    <script>
        function attachEvents(row) {
            const qty = row.querySelector('.qty');
            const pu = row.querySelector('.pu');
            const ptJours = row.querySelector('.pt_jours');
            const nbJours = row.querySelector('.nb_jours');
            const ptMois = row.querySelector('.pt_mois');

            function calcPT() {
                ptJours.value = (qty.value * pu.value).toFixed(2);
                ptMois.value = (ptJours.value * nbJours.value).toFixed(2);
                updateProforma();
            }

            qty.addEventListener('input', calcPT);
            pu.addEventListener('input', calcPT);
            nbJours.addEventListener('input', calcPT);
        }

        function addRow() {
            const container = document.getElementById('invoice-items');
            const newRow = container.children[0].cloneNode(true);

            newRow.querySelectorAll('input').forEach(i => {
                i.value = (i.classList.contains('qty') || i.classList.contains('nb_jours')) ? 1 : '';
            });

            newRow.querySelector('.remove-btn').classList.remove('d-none');
            container.appendChild(newRow);
            attachEvents(newRow);
            updateProforma();
        }

        function removeRow(btn) {
            const container = document.getElementById('invoice-items');
            if (container.children.length > 1) {
                btn.closest('.item-row').remove();
                updateProforma();
            } else {
                alert("You cannot remove the last row.");
            }
        }

        function updateProforma() {
            const tbody = document.getElementById('proforma-items');
            tbody.innerHTML = '';
            let subtotal = 0;

            document.querySelectorAll('.item-row').forEach((row, i) => {
                const ptm = parseFloat(row.querySelector('.pt_mois').value) || 0;
                subtotal += ptm;

                tbody.innerHTML += `
        <tr>
            <td>${i + 1}</td>
            <td>${row.querySelector('[name="description[]"]').value}</td>
            <td>${row.querySelector('[name="unite[]"]').value}</td>
            <td>${row.querySelector('.qty').value}</td>
            <td>$${row.querySelector('.pu').value}</td>
            <td>$${row.querySelector('.pt_jours').value}</td>
            <td>${row.querySelector('.nb_jours').value}</td>
            <td>$${ptm.toFixed(2)}</td>
        </tr>`;
            });

            const tva = subtotal * 0.16;
            document.getElementById('subtotal').textContent = subtotal.toFixed(2);
            document.getElementById('tva').textContent = tva.toFixed(2);
            document.getElementById('total').textContent = (subtotal + tva).toFixed(2);
        }

        document.addEventListener('DOMContentLoaded', () => {
            attachEvents(document.querySelector('.item-row'));
            updateProforma();
        });
    </script>

@endsection
