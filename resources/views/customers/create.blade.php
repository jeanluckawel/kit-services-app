@extends('layoutsddd.app')

@section('title','Create Customer - KIT SERVICES')

@section('content')

    <div class="container  p-5">

        <div class="card shadow" style="border-radius:0;">

            <!-- HEADER -->
            <div class="card-header text-white"
                 style="background-color:#FF6600;border-radius:0;">
                <h5 class="mb-0">Create Customer</h5>
            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                    <form action="{{ route('customer.store') }}" method="POST">
                        @csrf

                        <!-- BASIC INFO -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    Customer Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" class="form-control"
                                       placeholder="Company Name"
                                       required
                                       style="border-radius:0;"
                                       pattern="[A-Za-z0-9\s]{3,}"
                                       title="Name must be at least 3 characters"
                                       oninvalid="this.setCustomValidity('Please enter a valid customer name (min 3 chars)')"
                                       oninput="this.setCustomValidity('')"
                                       autocomplete="new-company">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">National ID</label>
                                <input type="text" name="id_nat" class="form-control"
                                       placeholder="National ID"
                                       style="border-radius:0;"
                                       autocomplete="off">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">RCCM</label>
                                <input type="text" name="rccm" class="form-control"
                                       placeholder="RCCM"
                                       style="border-radius:0;"
                                       autocomplete="off">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">NIF</label>
                                <input type="text" name="nif" class="form-control"
                                       placeholder="NIF"
                                       style="border-radius:0;"
                                       autocomplete="off">
                            </div>
                        </div>

                        <hr>

                        <!-- ADDRESS -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Province</label>
                                <input type="text" name="province" class="form-control"
                                       placeholder="Province"
                                       style="border-radius:0;"
                                       autocomplete="off">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">City</label>
                                <input type="text" name="ville" class="form-control"
                                       placeholder="City"
                                       style="border-radius:0;"
                                       autocomplete="new-off">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Commune</label>
                                <input type="text" name="commune" class="form-control"
                                       placeholder="Commune"
                                       style="border-radius:0;"
                                       autocomplete="new-c-off">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">District</label>
                                <input type="text" name="quartier" class="form-control"
                                       placeholder="District"
                                       style="border-radius:0;"
                                       autocomplete="off">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Avenue</label>
                                <input type="text" name="avenue" class="form-control"
                                       placeholder="Avenue"
                                       style="border-radius:0;"
                                       autocomplete="off">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Number</label>
                                <input type="text" name="numero" class="form-control"
                                       placeholder="Number"
                                       style="border-radius:0;"
                                       autocomplete="new-n-off">
                            </div>
                        </div>

                        <hr>

                        <!-- CONTACT -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Phone</label>
                                <input type="text" name="telephone" class="form-control"
                                       placeholder="Phone"
                                       style="border-radius:0;"
                                       autocomplete="new-p-off">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email" class="form-control"
                                       placeholder="Email"
                                       style="border-radius:0;"
                                       autocomplete="new-m-off">
                            </div>
                        </div>

                        <!-- ACTION -->
                        <div class="text-end mt-4">
                            <button type="submit"
                                    class="btn text-white"
                                    style="background-color:#FF6600;border-color:#FF6600;">
                                Save
                            </button>
                            <a href="{{ route('customer.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>

            </div>
        </div>

    </div>

@endsection
