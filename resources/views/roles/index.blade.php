@extends('layoutsddd.app')

@section('title', 'Users, Roles & Permissions - KIT SERVICES')

@section('content')
    <div class="d-flex justify-content-center mt-4 mb-4">
        <div class="card shadow-sm border-0" style="width: 95%; max-width: 1300px; border-radius: 0;">

            <div class="card-header d-flex align-items-center"
                 style="background-color:#FF6600; color:#fff; border-radius:0;">
                <h5 class="mb-0 fw-bold">Users, Roles & Permissions</h5>

                <div class="ms-auto">
                    @can('role_create')
                        <a href="{{ route('roles.create') }}"
                           class="btn btn-sm text-white"
                           style="background:#fff; color:black;">
                            <i class="bi bi-plus-lg"></i>
                            <span style="color: black"> Add Role</span>

                        </a>
                    @endcan
                </div>
            </div>


            <div class="card-body p-2">
                <table class="table table-bordered table-hover" style="font-size: 0.8rem;">
                    <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th >
                        <th>Roles</th>
                        <th>Permissions</th>
                        <th>Actions</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $key => $user)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td>{{ $user->name }}</td>

                            <td>{{ $user->email }}</td>

                            <!-- Roles -->
                            <td>
                                @if($user->getRoleNames()->isEmpty())
                                    <span class="text-muted">No Role</span>
                                @else
                                    {{ $user->getRoleNames()->join(', ') }}
                                @endif
                            </td>

                            <!-- Permissions -->
                            <td>
                                @php
                                    $permissions = $user->getAllPermissions()->pluck('name');
                                @endphp

                                @if($permissions->isEmpty())
                                    <span class="text-muted">No Permission</span>
                                @else
                                    <div class="d-flex flex-wrap">
                                        @foreach($permissions as $perm)
                                            <span class="badge-perm">
                                                {{ $perm }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </td>


                            @can('role_edit')


                            <td class="text-center">

                                <a href="{{ route('users.editPermissions', $user->id) }}"
                                   class="btn btn-sm btn-outline-warning"
                                   title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                            </td>
                                @endcan


                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <style>
        .bg-orange-600 { background-color: #FF6600 !important; }
        .badge.bg-orange-600 {
            padding: 3px 7px;
            border-radius: 0;
            font-size: 0.7rem;
        }
        .badge.bg-secondary {
            background-color: #6c757d;
            padding: 3px 7px;
            border-radius: 0;
            font-size: 0.7rem;
        }


         .badge-perm{
             background:#FF6600;
             color:white;
             font-size:0.7rem;
             padding:3px 8px;
             border-radius:0;
             margin-right:4px;
             margin-bottom:4px;
             display:inline-block;
         }


    </style>
@endsection
