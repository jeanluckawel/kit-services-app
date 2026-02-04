@extends('layoutsddd.app')

@section('title', 'Edit Expense Type - KIT SERVICES')

@section('content')

    <div class="card mb-4 m-5 border-0" style="border-radius:0;">

        <!-- Header -->
        <div class="card-header d-flex align-items-center"
             style="background-color:#FF6600;color:#fff;border-radius:0;">
            <h3 class="card-title mb-0">Edit Expense Type</h3>

            <nav aria-label="breadcrumb" class="ms-auto">
                <ol class="breadcrumb mb-0 bg-transparent">

                    @can('dashboard')
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-white">Home</a>
                        </li>
                    @endcan

                    @can('expense_type_list')
                        <li class="breadcrumb-item">
                            <a href="{{ route('expense-types.index') }}" class="text-white">Expense Types</a>
                        </li>
                    @endcan

                    <li class="breadcrumb-item active text-white" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>

        <!-- Body -->
        <div class="card-body">

            <form action="{{ route('expense-types.update', $type->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <!-- Name -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Name</label>
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $type->name) }}"
                               style="border-radius:0;"
                               required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Code (readonly) -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Code</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $type->code }}"
                               style="border-radius:0;"
                               disabled
                               readonly>
                    </div>

                    <!-- Description -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Description</label>
                        <input type="text"
                               name="description"
                               class="form-control"
                               value="{{ old('description', $type->description) }}"
                               style="border-radius:0;">
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('expense-types.index') }}" class="btn btn-secondary">Cancel</a>
                </div>

            </form>

        </div>
    </div>

@endsection
