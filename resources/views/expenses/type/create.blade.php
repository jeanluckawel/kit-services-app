@extends('layoutsddd.app')

@section('title', 'Create Expense Type - KIT SERVICES')

@section('content')

    <div class="card mb-4 m-5 border-0" style="border-radius:0;">

        <!-- Header -->
        <div class="card-header d-flex align-items-center"
             style="background-color:#FF6600;color:#fff;border-radius:0;">
            <h3 class="card-title mb-0">Create Expense Type</h3>

            <nav aria-label="breadcrumb" class="ms-auto">
                <ol class="breadcrumb mb-0 bg-transparent">

                    @can('dashboard')
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-white">Home</a>
                        </li>
                    @endcan

                    <li class="breadcrumb-item active text-white">
                        Expense Types
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Body -->
        <div class="card-body">

            <form action="{{ route('expense-types.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    <!-- Name -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            Name
                            <sup>
                                <span class="text-danger">*</span>
                            </sup>

                        </label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               style="border-radius:0;"
                               autocomplete="off"
                               required>
                    </div>


                    <!-- Description -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Description</label>
                        <input type="text"
                               name="description"
                               class="form-control"
                               autocomplete="off"
                               style="border-radius:0;">
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">
                        Save
                    </button>

                    <a href="{{ route('expense-types.index') }}"
                       class="btn btn-secondary">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

@endsection
