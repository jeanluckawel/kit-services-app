@extends('layoutsddd.app')

@section('title','Invoice Statement - KIT SERVICES')

@section('content')

    <div class="card mb-4 m-5">
        <!-- Invoice Statement Header -->
        <div class="card-header d-flex align-items-center"
             style="background-color: #FF6600; color: #fff; border-radius:0;">
            <h3 class="card-title mb-0">Statement</h3>

            <nav aria-label="breadcrumb" class="ms-auto">
                <ol class="breadcrumb mb-0 bg-transparent">

                    @can('dashboard')
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-white">Home</a>
                        </li>
                    @endcan

                    @can('customer_list')
                        <li class="breadcrumb-item">
                            <a href="{{ route('customer.index') }}" class="text-white">Customers</a>
                        </li>
                    @endcan

                    <li class="breadcrumb-item active text-white" aria-current="page">Statement</li>
                </ol>
            </nav>

        </div>


        <!-- BODY -->
        <div class="card-body">

            <!-- FILTERS -->
            <div class="row mb-3">

                <!-- SELECT CUSTOMER -->
                <div class="col-md-4">
                    <select id="customer_id" class="form-control">
                        <option value="">-- Select Client --</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}"
                                {{ request('customer_id')==$c->id?'selected':'' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- INVOICE NUMBER -->
                <div class="col-md-4">
                    <input type="text"
                           id="numero_invoice"
                           class="form-control"
                           placeholder="Invoice Number"
                           value="{{ request('numero_invoice') }}">
                </div>

            </div>

            <!-- TABLE -->
            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Invoice No</th>
                        <th>PO</th>
                        <th>Total Amount</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>

                    <tbody>

                    @forelse($invoices as $inv)

                        <tr>
                            <td>
                                {{ $loop->iteration + ($invoices->currentPage()-1)*$invoices->perPage() }}
                            </td>
                            <td>{{ $inv->customer->name ?? '' }}</td>
                            <td>{{ $inv->numero_invoice ?? '' }}</td>
                            <td>{{ $inv->po ?? '' }}</td>
                            <td>{{ number_format($inv->total_amount ?? 0,2) }}</td>
                            <td class="text-center">
                                @can('invoice_view')
                                    <a href="{{ route('invoices.showByNumber', $inv->numero_invoice) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="View Invoice">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                @endcan
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                No invoice found
                            </td>
                        </tr>
                    @endforelse

                    </tbody>

                </table>

            </div>

            <!-- PAGINATION -->
            <div class="card-footer clearfix">
                {{ $invoices->links() }}
            </div>

        </div>

    </div>

    <!-- JS FILTER -->
    <script>

        const filters = ['customer_id','numero_invoice'];

        filters.forEach(id=>{
            const element = document.getElementById(id);
            if(element){
                element.addEventListener('change', applyFilters);
                element.addEventListener('keyup', applyFilters);
            }
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
