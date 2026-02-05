@extends('layoutsddd.app')

@section('title','Expense History')

@section('content')

    <div class="card m-5">

        <div class="card-header" style="background:#FF6600;color:white">
            <h4>Expense History</h4>
        </div>

        <div class="card-body">

            <!-- FILTER + BALANCE -->
            <div class="row g-3 mb-4 align-items-center">

                <div class="col-md-2">
                    <select id="type" class="form-control">
                        <option value="">All Types</option>
                        @foreach(\App\Models\Expense_Type::all() as $type)
                            <option value="{{ $type->id }}" {{ request('type')==$type->id?'selected':'' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="period" class="form-control">
                        <option value="">Period</option>
                        <option value="day" {{ request('period')=='day'?'selected':'' }}>Today</option>
                        <option value="week" {{ request('period')=='week'?'selected':'' }}>Week</option>
                        <option value="month" {{ request('period')=='month'?'selected':'' }}>Month</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="date" id="start_date" class="form-control"
                           value="{{ request('start_date') }}">
                </div>

                <div class="col-md-2">
                    <input type="date" id="end_date" class="form-control"
                           value="{{ request('end_date') }}">
                </div>

                <!-- BALANCE USD -->
                <div class="col-md-2">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon text-bg-success">
                        <i class="bi bi-currency-dollar"></i>
                        </span>
                                                <div class="info-box-content">
                            <span class="info-box-text">Balance USD</span>
                            <span class="info-box-number">{{ number_format($balanceUSD,2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- BALANCE CDF -->
                <div class="col-md-2">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon text-bg-primary">
                        <i class="bi bi-cash-stack"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Balance CDF</span>
                            <span class="info-box-number">{{ number_format($balanceCDF,2) }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- TABLE --><div class="table-responsive">
                <table class="table table-bordered table-hover">

                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Currency</th>
                        <th>Code</th>
                        <th>Date</th>
                        <th>Action</th> <!-- Nouvelle colonne -->
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($expenses as $expense)
                        <tr>
                            <td>{{ $loop->iteration + ($expenses->currentPage()-1)*$expenses->perPage() }}</td>
                            <td>{{ $expense->type->name ?? '' }}</td>
                            <td>{{ $expense->description }}</td>
                            <td>{{ number_format($expense->amount,2) }}</td>
                            <td>{{ $expense->currency }}</td>
                            <td>{{ $expense->code }}</td>
                            <td>{{ $expense->created_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('expenses.bon', $expense->id) }}" class="btn btn-sm btn-primary">
                                    Voir Bon
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No expenses</td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>


            </div>


            <!-- PAGINATION -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-end">

                    @if($expenses->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $expenses->previousPageUrl() }}">&laquo;</a>
                        </li>
                    @endif

                    @foreach($expenses->getUrlRange(1,$expenses->lastPage()) as $page=>$url)
                        <li class="page-item {{ $expenses->currentPage()==$page?'active':'' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    @if($expenses->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $expenses->nextPageUrl() }}">&raquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                    @endif

                </ul>
            </div>

        </div>
    </div>

    <!-- FILTER JS -->
    <script>
        const filters = ['type','period','start_date','end_date'];

        filters.forEach(id=>{
            document.getElementById(id).addEventListener('change',()=>{
                let url = new URL(window.location.href);

                filters.forEach(f=>{
                    let v = document.getElementById(f).value;
                    if(v) url.searchParams.set(f,v);
                    else url.searchParams.delete(f);
                });

                window.location.href = url.toString();
            });
        });
    </script>

@endsection
