@extends('layoutsddd.app')

@section('title', 'Create employee - KIT SERVICES')

@section('content')

    <div class="card mb-4 m-5">
        <!-- CDI Contracts Header -->
        <div class="card-header d-flex align-items-center"
             style="background-color: #FF6600; color: #fff; border-radius:0;">
            <h3 class="card-title mb-0">CDI Contracts</h3>

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

                    <li class="breadcrumb-item active text-white" aria-current="page">CDI Contracts</li>
                </ol>
            </nav>
        </div>


        <div class="card-body">


            <div class="row mb-3">
                <div class="col-md-4">
                    <input
                        type="text"
                        id="searchEmployee"
                        class="form-control"
                        placeholder="Search by Employee and full name"
                    >
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-nowrap">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Age</th>
                        <th>Salary</th>
                        <th>Hire Date</th>

                        <th>Contract</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>


                    <tbody id="employeeTable">

                    @foreach($employees as $employee)
                        <tr>
                            <td>{{ $loop->iteration}}</td>

                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img
                                        src="{{ asset('storage/', $employee->photo) }}"
                                        alt="Employee Photo"
                                        class="rounded-circle"
                                        width="45"
                                        height="45"
                                    >
                                    <div>
                                        <strong>{{ $employee->first_name }}</strong><br>
                                        <small class="text-muted">{{ $employee->employee_id }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>{{ $employee->company->department ?? 'N/A' }}</td>

                            <td>
                                {{ $employee->age }}ans
                            </td>

                            <td><strong>{{ number_format($employee->salaries->base_salary,2 ?? 'N/A' ) }}</strong></td>

                            <td>{{ $employee->company->hire_date ?? 'N/A'}}</td>

                            <td>{{$employee->company->contract_type}}</td>

                            <td class="text-center">
                                <div class="d-inline-flex gap-1">


                                    <a href="{{ route('employee.view', $employee->id) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>


                                    <a href="{{ route('employee.edit', $employee->id) }}"
                                       class="btn btn-sm btn-outline-warning"
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>


                                    <button
                                        class="btn btn-sm btn-outline-danger"
                                        title="Disable"
                                        data-bs-toggle="modal"
                                        data-bs-target="#disableEmployeeModal"
                                        data-employee-id="{{ $employee->id }}"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </div>
                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

        </div>

        <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-end">
                <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
            </ul>
        </div>

    </div>

    @include('Employee.Modal.disable')

@endsection



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {

        $('#searchEmployee').on('keyup', function () {

            let search = $(this).val();

            $.ajax({
                url: "{{ route('employee.search') }}",
                type: "GET",
                data: {search: search},
                success: function (data) {
                    $('#employeeTable').html(data);
                }
            });

        });

    });
</script>


