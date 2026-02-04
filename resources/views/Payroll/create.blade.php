@extends('layoutsddd.app')

@section('title', 'Create Payroll - KIT SERVICES')

@section('content')
    <div class="card mb-4 m-5">

        <!-- Header -->
        <div class="card-header d-flex align-items-center"
             style="background-color: #FF6600; color: #fff; border-radius:0;">
            <h3 class="card-title mb-0">
                Create Payroll for {{ $employee->first_name }} {{ $employee->last_name }}
            </h3>
            <nav aria-label="breadcrumb" class="ms-auto">
                <ol class="breadcrumb mb-0 bg-transparent">
                    @can('dashboard')
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-white">Home</a>
                        </li>
                    @endcan

                    @can('payroll_index')
                        <li class="breadcrumb-item">
                            <a href="{{ route('payroll.index') }}" class="text-white">Payrolls</a>
                        </li>
                    @endcan

                    <li class="breadcrumb-item active text-white" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>


        <!-- Employee Info Table -->
        <div class="card-body mb-4">
            <table class="table table-bordered text-center mb-0" style="background-color: #fff;">
                <thead style="background-color: #FF6600; color: #fff;">
                <tr>
                    <th>Photo</th>
                    <th>Full Name</th>
                    <th>Employee ID</th>
                    <th>Department</th>
                    <th>Basic USD Salary</th>
                    <th>Tax Dependants</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        @if($employee->photo)
                            <img src="{{ asset('storage/'.$employee->photo) }}" alt="Photo" class="rounded-circle"
                                 width="50" height="50">
                        @else
                            <div class="rounded-circle d-flex justify-content-center align-items-center"
                                 style="width:50px; height:50px; background-color:#FF6600; color:white; font-weight:bold;">
                                {{ strtoupper(substr($employee->first_name,0,1).substr($employee->last_name,0,1)) }}
                            </div>
                        @endif
                    </td>
                    <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                    <td>{{ $employee->employee_id }}</td>
                    <td>{{ $employee->company->department ?? 'N/A' }}</td>
                    <td>{{ number_format($employee->salaries->base_salary ?? 0, 2) }} {{ $employee->salaries->currency ?? 'USD' }}</td>
                    <td>{{ $employee->children->count() ?? 0 }}</td>
                </tr>
                </tbody>
            </table>
        </div>


        <!-- Payroll Form -->
        <div class="card-body">
            <form action="{{ route('payroll.store', $employee->id) }}" method="POST">
                @csrf

                <input type="hidden" name="start_date" value="{{ payrollPeriod()['start'] }}">
                <input type="hidden" name="end_date" value="{{ payrollPeriod()['end'] }}">


                <!-- Tabs -->
                <ul class="nav nav-tabs mb-4" id="payrollTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="salary-tab" data-bs-toggle="tab" data-bs-target="#salary"
                                type="button" role="tab" aria-controls="salary" aria-selected="true">
                            Salary Info
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tax-tab" data-bs-toggle="tab" data-bs-target="#tax" type="button"
                                role="tab" aria-controls="tax" aria-selected="false">
                            Taxes & Deductions
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="overtime-tab" data-bs-toggle="tab" data-bs-target="#overtime"
                                type="button" role="tab" aria-controls="overtime" aria-selected="false">
                            Overtime
                        </button>
                    </li>
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content" id="payrollTabContent">

                    <!-- Salary Info -->
                    <div class="tab-pane fade show active" id="salary" role="tabpanel" aria-labelledby="salary-tab">
                        <div class="row g-3">


                            <!-- Exchange Rate -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Exchange Rate (CDF/USD) <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="exchange_rate" class="form-control"
                                       placeholder="2.000"
                                       value="{{ old('exchange_rate', 2800) }}" required
                                       style="border-radius:0;" min="0">
                            </div>

                            <!-- Worked Days -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Worked Days (0-31) <span class="text-danger">*</span></label>
                                <select name="worked_days" class="form-select" style="border-radius:0;" required>
                                    <option value="26">26</option>
{{--                                    <option value="">Select Days</option>--}}
                                    @for($i = 0; $i <= 31; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>

                                    @endfor
                                </select>
                            </div>

                            <!-- Payroll Month -->
                            <p class="mb-2">Du {{ payrollPeriod()['start'] }} au {{ payrollPeriod()['end'] }}</p>

                            @php
                                $months = [
                                    1  => 'January',
                                    2  => 'February',
                                    3  => 'March',
                                    4  => 'April',
                                    5  => 'May',
                                    6  => 'June',
                                    7  => 'July',
                                    8  => 'August',
                                    9  => 'September',
                                    10 => 'October',
                                    11 => 'November',
                                    12 => 'December',
                                ];

                                $currentPayrollMonth = payrollMonth();
                            @endphp

                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    Payroll Month <span class="text-danger">*</span>
                                </label>

                                <select name="period" class="form-select border border-orange-500 rounded-sm focus:border-orange-600 focus:ring-1 focus:ring-orange-300" required>
                                    @foreach($months as $value => $label)
                                        <option value="{{ $value }}" {{ $currentPayrollMonth == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>






                        </div>
                    </div>

                    <!-- Taxes & Deductions -->
                    <div class="tab-pane fade" id="tax" role="tabpanel" aria-labelledby="tax-tab">
                        <div class="row g-3">

                            <!-- Sick Days -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Sick Days (0-31) <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="sick_days" class="form-control" placeholder="0" min="0"
                                       max="31" style="border-radius:0;">
                            </div>

                        </div>
                    </div>

                    <!-- Overtime -->
                    <div class="tab-pane fade" id="overtime" role="tabpanel" aria-labelledby="overtime-tab">
                        <div class="row g-3">

                            <!-- Overtime 30% -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Overtime 30% (Hours)</label>
                                <input type="number" step="0.01" name="overtime_30" class="form-control" placeholder="0"
                                       min="0" style="border-radius:0;">
                            </div>

                            <!-- Overtime 60% -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Overtime 60% (Hours)</label>
                                <input type="number" step="0.01" name="overtime_60" class="form-control" placeholder="0"
                                       min="0" style="border-radius:0;">
                            </div>

                            <!-- Overtime 100% -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Overtime 100% (Hours)</label>
                                <input type="number" step="0.01" name="overtime_100" class="form-control"
                                       placeholder="0" min="0" style="border-radius:0;">
                            </div>

                        </div>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-warning"
                            style="border-radius:0; background-color:#FF6600; border:none;"> Pay salary
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
