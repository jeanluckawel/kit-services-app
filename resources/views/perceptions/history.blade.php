@extends('layoutsddd.app')

@section('title','Perception History')

@section('content')

    <div class="card mb-4 m-5">
        <div class="card-header" style="background-color: #FF6600; color: #fff; border-radius:0;">
            <h3 class="card-title mb-0">Perception History</h3>
        </div>

        <div class="card-body">

            <!-- FILTER + TOTALS ROW -->
            <div class="row g-2 mb-4 align-items-center">

                <!-- PERIOD -->
                <div class="col-md-2">
                    <select id="period" class="form-control">
                        <option value="">All Periods</option>
                        <option value="day" {{ request('period')=='day'?'selected':'' }}>Today</option>
                        <option value="week" {{ request('period')=='week'?'selected':'' }}>This Week</option>
                        <option value="month" {{ request('period')=='month'?'selected':'' }}>This Month</option>
                    </select>
                </div>

                <!-- START DATE -->
                <div class="col-md-2">
                    <input type="date" id="start_date"
                           value="{{ request('start_date') }}"
                           class="form-control">
                </div>

                <!-- END DATE -->
                <div class="col-md-2">
                    <input type="date" id="end_date"
                           value="{{ request('end_date') }}"
                           class="form-control">
                </div>

                <!-- TOTAL USD -->
                <div class="col-md-2">
                    <div class="info-box shadow-sm" style="min-height:60px;">
                    <span class="info-box-icon text-bg-success">
                        <i class="bi bi-currency-dollar"></i>
                    </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total USD</span>
                            <span class="info-box-number">
{{--                            {{ number_format($totalPerceptionUSD,2) }}--}}
                        </span>
                        </div>
                    </div>
                </div>

                <!-- TOTAL CDF -->
                <div class="col-md-2">
                    <div class="info-box shadow-sm" style="min-height:60px;">
                    <span class="info-box-icon text-bg-primary">
                        <i class="bi bi-cash-stack"></i>
                    </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total CDF</span>
                            <span class="info-box-number">
{{--                            {{ number_format($totalPerceptionCDF,2) }}--}}
                        </span>
                        </div>
                    </div>
                </div>

                <!-- BALANCE -->
                <div class="col-md-2">
                    <div class="info-box shadow-sm" style="min-height:60px;">
                    <span class="info-box-icon text-bg-warning">
                        <i class="bi bi-wallet2"></i>
                    </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Balance</span>
                            <span class="info-box-number">
                            {{ number_format($balanceUSD,2) }} USD |
                            {{ number_format($balanceCDF,2) }} CDF
                        </span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Currency</th>
                        <th>File</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($perceptions as $perc)
                        <tr>
                            <td>{{ $loop->iteration + ($perceptions->currentPage()-1) * $perceptions->perPage() }}</td>
                            <td>{{ $perc->name }}</td>
                            <td>{{ number_format($perc->amount,2) }}</td>
                            <td>{{ $perc->currency }}</td>
                            <td>
                                @if($perc->file)
                                    <a href="{{ asset('storage/'.$perc->file) }}" target="_blank">View</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $perc->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No perceptions found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="card-footer clearfix mt-3">
                <ul class="pagination pagination-sm m-0 float-end">
                    @if($perceptions->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $perceptions->previousPageUrl() }}">&laquo;</a></li>
                    @endif

                    @foreach($perceptions->getUrlRange(1, $perceptions->lastPage()) as $page => $url)
                        <li class="page-item {{ $perceptions->currentPage() == $page ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    @if($perceptions->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $perceptions->nextPageUrl() }}">&raquo;</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                    @endif
                </ul>
            </div>

        </div>
    </div>

    <script>
        const filters = ['period','start_date','end_date'];
        filters.forEach(id=>{
            document.getElementById(id).addEventListener('change', ()=>{
                let url = new URL(window.location.href);
                filters.forEach(f=>{
                    let v = document.getElementById(f).value;
                    if(v){
                        url.searchParams.set(f,v);
                    }else{
                        url.searchParams.delete(f);
                    }
                });
                window.location.href = url.toString();
            });
        });
    </script>

@endsection
