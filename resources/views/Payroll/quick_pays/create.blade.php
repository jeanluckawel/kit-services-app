@extends('layoutsddd.app')

@section('title', 'Pay - KIT SERVICES')

@section('content')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @php
        $months = [
            1 => 'January', 2 => 'February', 3 => 'March',
            4 => 'April', 5 => 'May', 6 => 'June',
            7 => 'July', 8 => 'August', 9 => 'September',
            10 => 'October', 11 => 'November', 12 => 'December'
        ];
        $currentMonth = now()->month;
    @endphp

    <form method="POST" action="{{ route('quick-pay.store') }}">
        @csrf

        <div class="card m-5 border-0" style="border-radius:0;">

            <!-- Header -->
            <div class="card-header d-flex align-items-center"
                 style="background-color:#FF6600;color:#fff;border-radius:0;">
                <h3 class="mb-0">
                    <i class="bi bi-cash-stack me-2"></i>  Payroll
                </h3>
            </div>

            <div class="card-body">

                <div class="row mb-4">

                    <!-- Employee ID -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            Employee ID <span class="text-danger">*</span>
                        </label>
                        <select id="employee_id" name="employee_id" class="form-select" style="border-radius:0;" required>
                            <option value="">Select Employee</option>
                            @foreach($employee as $emp)
                                @php
                                    $fullName = trim($emp->first_name.' '.$emp->last_name.' '.$emp->middle_name);
                                @endphp
                                <option value="{{ $emp->employee_id }}">
                                    {{ $emp->employee_id }} - {{ $fullName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Period (Month) -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Period (Month)</label>
                        <select name="period" id="period" class="form-select" style="border-radius:0;">
                            @foreach($months as $key => $month)
                                <option value="{{ $key }}" {{ $key == $currentMonth ? 'selected' : '' }}>
                                    {{ $month }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Year -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Year</label>
                        <select name="year" id="year" class="form-select" style="border-radius:0;">
                            @for($y = now()->year - 2; $y <= now()->year + 1; $y++)
                                <option value="{{ $y }}" {{ $y == $currentYear ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>

                </div>

                <!-- Employee Info Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle text-center">
                        <thead style="background:#FFF3E6;">
                        <tr>
                            <th>Full Name</th>
                            <th>Department</th>
                            <th>Function</th>
                            <th>Category</th>
                            <th>Base Salary (USD)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td id="emp_full_name">-</td>
                            <td id="emp_department">-</td>
                            <td id="emp_function">-</td>
                            <td id="emp_category">-</td>
                            <td id="emp_salary" class="fw-bold text-success">-</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Quick Pay Inputs -->
                <div class="row g-3">

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Days Worked</label>
                        <select name="day_work" class="form-select" style="border-radius:0;">
                            @for($i = 0; $i <= 31; $i++)
                                <option value="{{ $i }}">{{ $i }} days</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Sick Days</label>
                        <input type="number" name="day_sick" class="form-control"
                               min="0" value="0" style="border-radius:0;">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Overtime (days)</label>
                        <input type="number" name="day_overtime" class="form-control"
                               min="0" value="0" style="border-radius:0;">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Exchange Rate</label>
                        <input type="number" name="exchange_rate" step="0.01"
                               class="form-control" value="2500" style="border-radius:0;">
                    </div>

                </div>

                <!-- Actions -->
                <div class="mt-4 text-end">
                    <button class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Save
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                </div>

            </div>
        </div>
    </form>

    <!-- AJAX SCRIPT -->
    <script>
        document.getElementById('employee_id').addEventListener('change', function () {

            let employeeId = this.value;

            if (!employeeId) {
                resetEmployeeTable();
                return;
            }

            fetch(`/ajax/employee/${employeeId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        resetEmployeeTable();
                        return;
                    }

                    document.getElementById('emp_full_name').innerText  = data.full_name;
                    document.getElementById('emp_department').innerText = data.department;
                    document.getElementById('emp_function').innerText   = data.function;
                    document.getElementById('emp_category').innerText   = data.category;
                    document.getElementById('emp_salary').innerText     = data.base_salary;
                })
                .catch(() => resetEmployeeTable());
        });

        function resetEmployeeTable() {
            document.getElementById('emp_full_name').innerText  = '-';
            document.getElementById('emp_department').innerText = '-';
            document.getElementById('emp_function').innerText   = '-';
            document.getElementById('emp_category').innerText   = '-';
            document.getElementById('emp_salary').innerText     = '-';
        }


        document.addEventListener('DOMContentLoaded', function() {
            const employeeSelect = document.getElementById('employee_id');
            const periodSelect   = document.getElementById('period');
            const yearSelect     = document.getElementById('year');

            function updateEmployees() {
                const month = periodSelect.value;
                const year  = yearSelect.value;

                fetch(`/ajax/employees-not-paid?month=${month}&year=${year}`)
                    .then(res => res.json())
                    .then(data => {
                        // vider le select
                        employeeSelect.innerHTML = '<option value="">Select Employee</option>';

                        // ajouter les employés
                        data.forEach(emp => {
                            const fullName = [emp.first_name, emp.last_name, emp.middle_name].filter(Boolean).join(' ');
                            const option = document.createElement('option');
                            option.value = emp.employee_id;
                            option.textContent = `${emp.employee_id} - ${fullName}`;
                            employeeSelect.appendChild(option);
                        });
                    });
            }

            // écouteur changement
            periodSelect.addEventListener('change', updateEmployees);
            yearSelect.addEventListener('change', updateEmployees);
        });

    </script>

@endsection
