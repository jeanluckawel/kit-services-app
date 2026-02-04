@extends('layoutsddd.app')

@section('title','Payroll History - KIT SERVICES')

@section('content')

    <div class="card mb-4 m-5">

        <!-- HEADER -->
        <div class="card-header d-flex align-items-center"
             style="background-color: #FF6600; color: #fff; border-radius:0;">
            <h3 class="card-title mb-0">Payroll History</h3>

            <nav aria-label="breadcrumb" class="ms-auto d-flex align-items-center">
                <ol class="breadcrumb mb-0 bg-transparent me-3">
                    @can('dashboard')
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-white">Home</a>
                        </li>
                    @endcan
                    <li class="breadcrumb-item active text-white" aria-current="page">History</li>
                </ol>
            </nav>
        </div>



        <!-- BODY -->
        <div class="card-body">

            <!-- FILTERS -->
            <div class="row mb-3">

                <div class="col-md-3">
                    <input type="text" id="employee" class="form-control"
                           placeholder="Employee name or ID"
                           value="{{ request('employee') }}">
                </div>

                <div class="col-md-2">
                    <input type="text" id="reference" class="form-control"
                           placeholder="Reference"
                           value="{{ request('reference') }}">
                </div>

                <div class="col-md-2">
                    <select id="period" class="form-control">
                        <option value="">Period</option>
                        @for($i=1;$i<=12;$i++)
                            <option value="{{ $i }}" {{ request('period')==$i?'selected':'' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="year" class="form-control">
                        <option value="">Year</option>
                        @for($y=2024;$y<=2026;$y++)
                            <option value="{{ $y }}" {{ request('year')==$y?'selected':'' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="status" class="form-control">
                        <option value="">Status</option>
                        <option value="paid" {{ request('status')=='paid'?'selected':'' }}>Paid</option>
                        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                    </select>
                </div>

            </div>

            <!-- TABLE -->
            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Period</th>
                        <th>Basic USD</th>
                        <th>Net USD</th>
                        <th>Reference</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($payrolls as $payroll)
                        <tr>

                            <td>
                                {{ $loop->iteration + ($payrolls->currentPage()-1) * $payrolls->perPage() }}
                            </td>

                            <td>
                                <strong>
                                    {{ $payroll->employee->first_name ?? '' }}
                                    {{ $payroll->employee->last_name ?? '' }}
                                </strong><br>
                                <small>{{ $payroll->employee_id }}</small>
                            </td>

                            <td>{{ $payroll->employee->company->department ?? 'N/A' }}</td>

                            <td>{{ $payroll->period }}</td>

                            <td>{{ number_format($payroll->basic_usd,2) }}</td>

                            <td><strong>{{ number_format($payroll->net_salary,2) }}</strong></td>

                            <td>{{ $payroll->reference }}</td>



                            <td class="text-center">
                                @can('payroll_view')
                                    <a href="{{ route('payroll.show', [$payroll->employee_id, $payroll->reference]) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="View Payroll">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                @endcan
                            </td>





                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No payroll found</td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>

            </div>

            <!-- PAGINATION -->
            <div class="card-footer clearfix">
                {{ $payrolls->links() }}
            </div>

        </div>
    </div>

    <!-- JS -->
    <script>
        const filters = ['employee','reference','period','year','status'];

        filters.forEach(id=>{
            document.getElementById(id).addEventListener('change', applyFilters);
        });

        function applyFilters(){
            let url = new URL(window.location.href);

            filters.forEach(id=>{
                let v = document.getElementById(id).value;
                if(v){
                    url.searchParams.set(id,v);
                }else{
                    url.searchParams.delete(id);
                }
            });

            window.location.href = url.toString();
        }
    </script>

@endsection
