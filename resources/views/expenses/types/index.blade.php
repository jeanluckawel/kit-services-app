@extends('layoutsddd.app')

@section('title', 'Expense Types - KIT SERVICES')

@section('content')

    <div class="card mb-4 m-5">

        <!-- Header -->
        <div class="card-header d-flex align-items-center"
             style="background-color: #FF6600; color: #fff; border-radius:0;">
            <h3 class="card-title mb-0">Expense Types List</h3>

            <nav aria-label="breadcrumb" class="ms-auto">
                <ol class="breadcrumb mb-0 bg-transparent">

                    @can('dashboard')
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-white">Home</a>
                        </li>
                    @endcan

                    <li class="breadcrumb-item active text-white" aria-current="page">Expense Types</li>
                </ol>
            </nav>

            @can('expense_type')
                <div class="card-tools ms-3">
                    <a href="{{ route('expense-types.create') }}"
                       class="btn btn-tool"
                       title="Add new Expense Type"
                       style="background:#fff; color:#FF6600; width:40px; height:40px; border-radius:4px; display:flex; align-items:center; justify-content:center;">
                        <i class="bi bi-plus-lg" style="font-size:20px;"></i>
                    </a>
                </div>
            @endcan
        </div>

        <!-- Body -->
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="searchExpenseType" class="form-control" placeholder="Search by name or code">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-nowrap">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="expenseTypeTable">
                    @foreach($expenseTypes as $type)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $type->name }}</td>
                            <td>{{ $type->code }}</td>
                            <td>{{ $type->description ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-1">

                                    @can('expense_type')
                                        <a href="{{ route('expense-types.edit', $type->id) }}"
                                           class="btn btn-sm btn-outline-warning"
                                           title="Edit Expense Type">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan

                                    @can('expense_type')
                                        <form action="{{ route('expense-types.destroy', $type->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Delete this Expense Type?')"
                                                    title="Delete Expense Type">
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
                {{ $expenseTypes->links() }}
            </ul>
        </div>

    </div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('#searchExpenseType').on('keyup', function () {
            let search = $(this).val();
            $.ajax({
                url: "{{ route('expense-types.search') }}",
                type: "GET",
                data: { search: search },
                success: function(data) {
                    $('#expenseTypeTable').html(data);
                }
            });
        });
    });
</script>
