@extends('layoutsddd.app')

@section('title', 'Customers - KIT SERVICES')

@section('content')

    <div class="card mb-4 m-5">

        <!-- Customers List Header -->
        <div class="card-header d-flex align-items-center"
             style="background-color: #FF6600; color: #fff; border-radius:0;">
            <h3 class="card-title mb-0">Customers List</h3>

            <nav aria-label="breadcrumb" class="ms-auto">
                <ol class="breadcrumb mb-0 bg-transparent">

                    @can('dashboard')
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-white">Home</a>
                        </li>
                    @endcan


                    <li class="breadcrumb-item active text-white" aria-current="page">List</li>
                </ol>
            </nav>

            @can('customer_create')
                <div class="card-tools ms-3">
                    <a href="{{ route('customer.create') }}"
                       class="btn btn-tool"
                       title="Add new customer"
                       style="background:#fff; color:#FF6600; width:40px; height:40px; border-radius:4px; display:flex; align-items:center; justify-content:center;">
                        <i class="bi bi-plus-lg" style="font-size:20px;"></i>
                    </a>
                </div>
            @endcan
        </div>


        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="searchCustomer" class="form-control" placeholder="Search by name or city">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-nowrap">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>RCCM</th>
                        <th>NIF</th>
                        <th>City</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="customerTable">
                    @foreach($customers as $customer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->rccm ?? '-' }}</td>
                            <td>{{ $customer->nif ?? '-' }}</td>
                            <td>{{ $customer->ville ?? '-' }}</td>
                            <td>{{ $customer->telephone ?? '-' }}</td>
                            <td>{{ $customer->email ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-1">

                                    @can('invoice_create')
                                        <a href="{{ route('invoices.create', $customer->id) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Create Invoice">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </a>
                                    @endcan

                                    @can('customer_edit')
                                        <a href="{{ route('customer.edit', $customer->id) }}"
                                           class="btn btn-sm btn-outline-warning"
                                           title="Edit Customer">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan

                                    @can('customer_delete')
                                        <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Delete this customer?')"
                                                    title="Delete Customer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endcan

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
                {{ $customers->links() }}
            </ul>
        </div>

    </div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('#searchCustomer').on('keyup', function () {
            let search = $(this).val();
            $.ajax({
                url: "{{ route('customer.search') }}",
                type: "GET",
                data: {search: search},
                success: function (data) {
                    $('#customerTable').html(data);
                }
            });
        });
    });
</script>
