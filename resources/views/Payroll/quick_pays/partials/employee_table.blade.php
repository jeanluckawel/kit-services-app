{{-- resources/views/Payroll/quick_pays/partials/employee_table.blade.php --}}

<table class="table table-bordered align-middle text-center">
    <thead style="background:#FFF3E6;">
    <tr>
        <th>Employee ID</th>
        <th>Full Name</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    {{-- EMPLOYES PAYES --}}
    @foreach($paidEmployees as $emp)
        @php
            $fullName = $emp->first_name.' '.$emp->last_name.' '.$emp->middle_name;
            $latestPay = $emp->quickPays->first(); // le dernier paiement
        @endphp
        <tr>
            <td>{{ $emp->employee_id }}</td>
            <td>{{ $fullName }}</td>
            <td>
                <span class="badge bg-success">Paid</span>
            </td>
            <td>
                <a href="{{ route('quick_pay.show', $latestPay->id) }}" class="btn btn-sm btn-info">
                    <i class="bi bi-file-earmark-text"></i> View Pay
                </a>
            </td>
        </tr>
    @endforeach

    {{-- EMPLOYES NON PAYES --}}
    @foreach($unpaidEmployees as $emp)
        @php
            $fullName = $emp->first_name.' '.$emp->last_name.' '.$emp->middle_name;
        @endphp
        <tr>
            <td>{{ $emp->employee_id }}</td>
            <td>{{ $fullName }}</td>
            <td>
                <span class="badge bg-secondary">Pending</span>
            </td>
            <td>
                <span class="text-muted">No Pay Yet</span>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
