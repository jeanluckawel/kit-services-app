<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle text-nowrap">
        <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Employee number</th>
            <th>Department</th>
            <th>Basic USD</th>
            <th>Tax Dependants</th>
            <th>Worked Days</th>
            <th>Total Earnings</th>
            <th>INSS 5%</th>
            <th>Monthly IPR</th>
            <th>IPR Rate</th>
            <th>NET USD</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ $loop->iteration + ($employees->currentPage()-1) * $employees->perPage() }}</td>
                    <td>{{ $employee->employee_id }}</td>
                    <td>{{ $employee->company->department ?? 'N/A' }}</td>
                    <td><strong>{{ number_format($employee->salaries->base_salary_usd ?? 0,2) }}</strong></td>
                    <td>{{ $employee->tax_dependants ?? 0 }}</td>
                    <td>{{ $employee->worked_days ?? 0 }}</td>
                    <td><strong>{{ number_format($employee->total_earnings_usd ?? 0,2) }}</strong></td>
                    <td><strong>{{ number_format($employee->inss_usd ?? 0,2) }}</strong></td>
                    <td><strong>{{ number_format($employee->monthly_ipr_usd ?? 0,2) }}</strong></td>
                    <td>{{ $employee->ipr_rate ?? 'N/A' }}</td>
                    <td><strong>{{ number_format($employee->net_usd ?? 0,2) }}</strong></td>
                    <td>
                        @if($employee->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

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
