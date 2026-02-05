@extends('layoutsddd.app')

@section('title','Add Expense')

@section('content')

    <div class="card m-5">
        <div class="card-header" style="background:#FF6600;color:white">
            <h4>Ajouter une dépense</h4>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data" id="expenseForm">
                @csrf

                <div class="row g-3">

                    <!-- TYPE -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Type Dépense <span class="text-danger">*</span></label>
                        <select name="expense_type_id" class="form-control" required style="border-radius:0;">
                            <option value="">-- Choisir --</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ old('expense_type_id')==$type->id?'selected':'' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('expense_type_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- DESCRIPTION -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                        <input type="text" name="description" class="form-control" required
                               style="border-radius:0;"
                               pattern=".{3,}"
                               title="Description must be at least 3 characters"
                               value="{{ old('description') }}">
                        @error('description')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- CURRENCY -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Devise <span class="text-danger">*</span></label>
                        <select name="currency" id="currency" class="form-control" required style="border-radius:0;">
                            <option value="">-- Choisir --</option>
                            <option value="USD" data-balance="{{ $balanceUSD }}" {{ old('currency')=='USD'?'selected':'' }}>USD</option>
                            <option value="CDF" data-balance="{{ $balanceCDF }}" {{ old('currency')=='CDF'?'selected':'' }}>CDF</option>
                        </select>
                        @error('currency')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- AMOUNT -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Montant <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" class="form-control" required
                               style="border-radius:0;"
                               min="0"
                               value="{{ old('amount') }}"
                               id="amountInput">
                        <small id="amountError" class="text-danger d-none">Le montant dépasse le solde disponible !</small>
                        @error('amount')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <!-- FILE -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fichier (optionnel)</label>
                        <input type="file" name="file" class="form-control" style="border-radius:0;">
                        @error('file')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <!-- Solde affiché côté frontend -->
                <div class="row mt-3 g-3">
                    <div class="col-md-6 col-lg-3">
                        <div class="info-box shadow-sm">
                        <span class="info-box-icon text-bg-success">
                            <i class="bi bi-currency-dollar"></i>
                        </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Balance USD</span>
                                <span class="info-box-number">{{ number_format($balanceUSD,2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="info-box shadow-sm">
                        <span class="info-box-icon text-bg-primary">
                            <i class="bi bi-cash-stack"></i>
                        </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Balance CDF</span>
                                <span class="info-box-number">{{ number_format($balanceCDF,2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" id="submitBtn" class="btn btn-success">Enregistrer</button>
                    <a href="{{ route('expenses.create') }}" class="btn btn-secondary">Annuler</a>
                </div>

            </form>

        </div>
    </div>

    <script>
        const currency = document.getElementById('currency');
        const amount = document.getElementById('amountInput');
        const amountError = document.getElementById('amountError');
        const submitBtn = document.getElementById('submitBtn');

        function checkAmount() {
            const selected = currency.selectedOptions[0];
            const max = parseFloat(selected.dataset.balance) || 0;
            const value = parseFloat(amount.value) || 0;

            if(value > max){
                amountError.classList.remove('d-none');
                submitBtn.disabled = true;
            } else {
                amountError.classList.add('d-none');
                submitBtn.disabled = false;
            }
        }

        currency.addEventListener('change', checkAmount);
        amount.addEventListener('input', checkAmount);
    </script>

@endsection
