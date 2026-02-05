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
        <tbody>
        @foreach($employees as $employee)
            <tr>
                <td>{{ $loop->iteration + ($employees->currentPage()-1) * $employees->perPage() }}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        @php
                            $initials = strtoupper(substr($employee->first_name,0,1) . substr($employee->last_name,0,1));
                            $bgColor = '#ff7f00';
                        @endphp

                        @if($employee->photo)
                            <img src="{{ asset('storage/'.$employee->photo) }}" alt="Photo" class="rounded-circle" width="45" height="45">
                        @else
                            <div class="rounded-circle d-flex justify-content-center align-items-center"
                                 style="width:45px; height:45px; background-color: {{ $bgColor }}; color:white; font-weight:bold; font-size:16px;">
                                {{ $initials }}
                            </div>
                        @endif

                        <div>
                            <strong>{{ $employee->first_name }}</strong><br>
                            <small>{{ $employee->employee_id }}</small>
                        </div>
                    </div>
                </td>

                <td>{{ $employee->company->department ?? 'N/A' }}</td>
                <td>{{ $employee->age >= 1 ? $employee->age . ' ' . ($employee->age > 1 ? 'ans' : 'an') : '-' }}</td>
                <td><strong>{{ number_format($employee->salaries->base_salary ?? 0,2) }}</strong></td>
                <td>{{ $employee->company->hire_date ?? 'N/A' }}</td>

                <td>
                    @php
                        $type = $employee->company->contract_type ?? '';
                        $endDate = $employee->company->end_contract_date ?? null;
                    @endphp

                    @if(strtoupper($type) === 'CDD')
                        <span class="badge" style="background-color: #ff7f00; color:white;">
                            {{ $type }}
                            @if($endDate)
                                ({{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }})
                            @endif
                        </span>
                    @elseif(strtoupper($type) === 'CDI')
                        <span class="badge" style="background-color: #dc3545; color:white;">{{ $type }}</span>
                    @else
                        <span>{{ $type }}</span>
                    @endif
                </td>

                <td class="text-center">
                    <div class="d-inline-flex gap-1">

                        @can('employee_view')
                            <a href="{{ route('employee.view', $employee->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                View
                            </a>
                        @endcan

                        @can('employee_edit')
                            <a href="{{ route('employee.edit', $employee->id) }}"
                               class="btn btn-sm btn-outline-warning">
                                Edit
                            </a>
                        @endcan

                        @can('employee_disable')
                            <button class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#disableEmployeeModal"
                                    data-employee-id="{{ $employee->id }}">
                                Delete
                            </button>
                        @endcan

                    </div>
                </td>


            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-end">
            @if($employees->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $employees->previousPageUrl() }}">&laquo;</a></li>
            @endif

            @foreach($employees->getUrlRange(1, $employees->lastPage()) as $page => $url)
                <li class="page-item {{ $employees->currentPage() == $page ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            @if($employees->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $employees->nextPageUrl() }}">&raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            @endif
        </ul>
    </div>
</div>
