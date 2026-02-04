@extends('layoutsddd.app')

@section('title','Users List - KIT SERVICES')

@section('content')

    <div class="card mb-4 m-5">

        <div class="card-header d-flex flex-column flex-md-row align-items-start align-items-md-center"
             style="background-color: #FF6600; color: #fff; border-radius:0;">


            <h3 class="card-title mb-2 mb-md-0">Users List</h3>


            <div class="ms-auto d-flex align-items-center">


                <nav aria-label="breadcrumb" class="me-3">
                    <ol class="breadcrumb mb-0 bg-transparent">
                        @can('dashboard')
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-white">Home</a>
                            </li>
                        @endcan
                        <li class="breadcrumb-item active text-white" aria-current="page">Users</li>
                    </ol>
                </nav>


                @can('user_create')
                    <a href="{{ route('users.create') }}"
                       class="btn btn-tool"
                       style="background:#fff; color:#FF6600; width:40px; height:40px;"
                       title="Add New User">
                        <i class="bi bi-plus-lg" style="font-size: 20px;"></i>
                    </a>
                @endcan

            </div>
        </div>


        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="searchUser" class="form-control" placeholder="Search by Name or Email">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-nowrap">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>

                    <tbody id="userTable">
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role ?? 'User') }}</td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-1">

                                    <a href="#"
                                       class="btn btn-sm btn-outline-primary"
                                       title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('users.edit', $user->id) }}"
                                       class="btn btn-sm btn-outline-warning"
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this user?');"
                                                title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>


        </div>

    </div>

@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {

            $('#searchUser').on('keyup', function () {

                let search = $(this).val();

                $.ajax({
                    url: "{{ route('users.search') }}",
                    type: "GET",
                    data: {search: search},
                    success: function (data) {
                        $('#userTable').html(data);
                    }
                });

            });

        });
    </script>
@endsection
