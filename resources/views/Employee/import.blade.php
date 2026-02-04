@extends('layoutsddd.app')

@section('title', 'Import Employees - KIT SERVICES')

@section('content')

    <div class="card mb-4 m-5 border-0" style="border-radius:0;">
        <!-- Header -->
        <!-- Import Employees Header -->
        <div class="card-header d-flex align-items-center"
             style="background-color: #FF6600; color: #fff; border-radius:0;">
            <h3 class="card-title mb-0">Import Employees from Excel</h3>

            <nav aria-label="breadcrumb" class="ms-auto">
                <ol class="breadcrumb mb-0 bg-transparent">

                    @can('dashboard')
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-white">Home</a>
                        </li>
                    @endcan

                    @can('employee_list')
                        <li class="breadcrumb-item">
                            <a href="{{ route('employee.list') }}" class="text-white">Employees</a>
                        </li>
                    @endcan

                    <li class="breadcrumb-item active text-white" aria-current="page">Import</li>
                </ol>
            </nav>
        </div>

        <!-- Form -->
        <div class="card-body">
            <form action="{{ route('employee.import.store') }}" method="POST" enctype="multipart/form-data"
                  autocomplete="off">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="file" class="form-label fw-bold">Choose Excel File <span
                                    class="text-danger">*</span></label>
                        <input type="file" name="file" id="file" class="form-control" required style="border-radius:0;">
                        @error('file')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Import</button>
                    <a href="{{ route('employee.list') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

@endsection
