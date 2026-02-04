@extends('layoutsddd.app')

@section('title', 'Export Payroll - KIT SERVICES')

@section('content')

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <div class="card mb-4 m-5 border-0" style="border-radius:0;">
        <div class="card-header d-flex align-items-center"
             style="background-color: #FF6600; color: #fff; border-radius:0;">
            <h3 class="card-title mb-0">Export Payroll to Excel</h3>
            <nav aria-label="breadcrumb" class="ms-auto">
                <ol class="breadcrumb mb-0 bg-transparent">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-white">Home</a></li>
                    @can('dashboard')
                        <li class="breadcrumb-item active text-white" aria-current="page">Export</li>

                    @endcan
                </ol>
            </nav>
        </div>

        <div class="card-body">
            <form action="{{ route('payroll.export') }}" method="GET" autocomplete="off">
                <div class="row g-3">

                    <!-- Year -->
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Year</label>
                        <select name="year" class="form-select" style="border-radius:0;">
                            @php
                                $currentYear = date('Y');
                            @endphp
                            @for($y = 2025; $y <= 2026; $y++)
                                <option value="{{ $y }}" {{ request('year', $currentYear) == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <!-- Period -->
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Period</label>
                        <select name="period" class="form-select" style="border-radius:0;">
                            @php
                                $currentMonth = date('n'); // 1-12
                            @endphp
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ request('period', $currentMonth) == $m ? 'selected' : '' }}>
                                    {{ $m }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <!-- Employee -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Employee</label>
                        <select name="employee_id" class="form-select select2" style="border-radius:0;">
                            <option value="">All</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->employee_id }}" {{ request('employee_id') == $employee->employee_id ? 'selected' : '' }}>
                                    {{ $employee->employee_id }} - {{ $employee->first_name }} {{ $employee->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Export</button>
                    <a href="{{ route('payroll.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('.select2').select2({
                placeholder: "Select Employee",
                allowClear: true,
                width: '100%'
            });
        });
    </script>

@endsection
