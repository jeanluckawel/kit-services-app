@extends('layoutsddd.app')

@section('title', 'Export Employees - KIT SERVICES')

@section('content')

    <div class="card mb-4 m-5 border-0" style="border-radius:0;">
        <!-- Export Employees Header -->
        <div class="card-header d-flex align-items-center"
             style="background-color: #FF6600; color: #fff; border-radius:0;">
            <h3 class="card-title mb-0">Export Employees to Excel</h3>

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

                    <li class="breadcrumb-item active text-white" aria-current="page">Export</li>
                </ol>
            </nav>
        </div>


        <div class="card-body">
            <form action="{{ route('employee.export') }}" method="GET" autocomplete="off">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Gender</label>
                        <select name="gender" class="form-select" style="border-radius:0;">
                            <option value="">All</option>
                            <option value="M" {{ request('gender') == 'M' ? 'selected' : '' }}>Male</option>
                            <option value="F" {{ request('gender') == 'F' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Contract Type</label>
                        <select name="contract_type" class="form-select" style="border-radius:0;">
                            <option value="">All</option>
                            <option value="CDD" {{ request('contract_type') == 'CDD' ? 'selected' : '' }}>CDD</option>
                            <option value="CDI" {{ request('contract_type') == 'CDI' ? 'selected' : '' }}>CDI</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Actif</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Inactif</option>
                        </select>
                    </div>


                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Export</button>
                    <a href="{{ route('employee.list') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

@endsection
