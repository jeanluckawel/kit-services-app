@extends('layoutsddd.app')

@section('title', 'Edit Customer - KIT SERVICES')

@section('content')

    <div class="card mb-4 m-5 border-0" style="border-radius:0;">
        <!-- Header -->
        <div class="card-header d-flex align-items-center"
                            style="background-color: #FF6600; color: #fff; border-radius:0;">
            <h3 class="card-title mb-0">Edit Customer</h3>
            <nav aria-label="breadcrumb" class="ms-auto">
                <ol class="breadcrumb mb-0 bg-transparent">

                    @can('dashboard')
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-white">Home</a>
                        </li>
                    @endcan

                    @can('customer_list')
                        <li class="breadcrumb-item">
                            <a href="{{ route('customer.index') }}" class="text-white">Customers</a>
                        </li>
                    @endcan

                    <li class="breadcrumb-item active text-white" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>

        <div class="card-body">
            <form action="{{ route('customer.update', $customer->id) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name', $customer->name) }}"
                               required style="border-radius:0;"
                               autocomplete="kit-services-sarl">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">National ID</label>
                        <input type="text" name="id_nat" class="form-control"
                               value="{{ old('id_nat', $customer->id_nat) }}"
                               style="border-radius:0;"
                               autocomplete="kit-services-sarl">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">RCCM</label>
                        <input type="text" name="rccm" class="form-control"
                               value="{{ old('rccm', $customer->rccm) }}"
                               style="border-radius:0;"
                               autocomplete="kit-services-sarl">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">NIF</label>
                        <input type="text" name="nif" class="form-control"
                               value="{{ old('nif', $customer->nif) }}"
                               style="border-radius:0;"
                               autocomplete="kit-services-sarl">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Province</label>
                        <input type="text" name="province" class="form-control"
                               value="{{ old('province', $customer->province) }}"
                               style="border-radius:0;"
                               autocomplete="kit-services-sarl">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">City</label>
                        <input type="text" name="ville" class="form-control"
                               value="{{ old('ville', $customer->ville) }}"
                               style="border-radius:0;"
                               autocomplete="kit-services-sarl">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Commune</label>
                        <input type="text" name="commune" class="form-control"
                               value="{{ old('commune', $customer->commune) }}"
                               style="border-radius:0;"
                               autocomplete="kit-services-sarl">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Quartier</label>
                        <input type="text" name="quartier" class="form-control"
                               value="{{ old('quartier', $customer->quartier) }}"
                               style="border-radius:0;"
                               autocomplete="kit-services-sarl">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Avenue</label>
                        <input type="text" name="avenue" class="form-control"
                               value="{{ old('avenue', $customer->avenue) }}"
                               style="border-radius:0;"
                               autocomplete="kit-services-sarl">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Number</label>
                        <input type="text" name="numero" class="form-control"
                               value="{{ old('numero', $customer->numero) }}"
                               style="border-radius:0;"
                               autocomplete="kit-services-sarl">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Telephone</label>
                        <input type="text" name="telephone" class="form-control"
                               value="{{ old('telephone', $customer->telephone) }}"
                               style="border-radius:0;"
                               autocomplete="kit-services-sarl">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $customer->email) }}"
                               style="border-radius:0;"
                               autocomplete="kit-services-sarl">
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('customer.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>

    </div>

@endsection
