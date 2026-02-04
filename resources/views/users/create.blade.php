@extends('layoutsddd.app')

@section('title','Create User - KIT SERVICES')

@section('content')

    <div class="container p-5">

        <div class="card shadow" style="border-radius:0;">

            <!-- HEADER -->
            <div class="card-header d-flex flex-column flex-md-row align-items-start align-items-md-center"
                 style="background-color: #FF6600; color: #fff; border-radius:0;">

                <!-- Title -->
                <h5 class="mb-2 mb-md-0">Create User</h5>

                <!-- Breadcrumb + optional actions -->
                <div class="ms-auto d-flex align-items-center">

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="me-3">
                        <ol class="breadcrumb mb-0 bg-transparent">
                            @can('dashboard')
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard') }}" class="text-white">Home</a>
                                </li>
                            @endcan
                            @can('user_list')
                                <li class="breadcrumb-item">
                                    <a href="{{ route('users.index') }}" class="text-white">Users</a>
                                </li>
                            @endcan
                            <li class="breadcrumb-item active text-white" aria-current="page">Create</li>
                        </ol>
                    </nav>

                </div>
            </div>


            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                    <form action="{{ route('users.store') }}" method="POST" autocomplete="off">
                        @csrf

                        <!-- BASIC INFO -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="fw-bold">Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       style="border-radius:0;"
                                       required
                                       autocomplete="off">
                            </div>

                            <div class="col-md-6">
                                <label class="fw-bold">Email <span class="text-danger">*</span></label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       style="border-radius:0;"
                                       required
                                       autocomplete="ame-d-fe-off">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="fw-bold">Password <span class="text-danger">*</span></label>
                                <input type="password"
                                       name="password"
                                       class="form-control"
                                       style="border-radius:0;"
                                       required
                                       autocomplete="new-pass">
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- ROLE -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="fw-bold">Role</label>
                                <select name="role" class="form-select" style="border-radius:0;">
                                    <option value="">-- Select Role --</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- ACTION BUTTON -->
                        <div class="text-end">
                            <button type="submit"
                                    class="btn text-white"
                                    style="background-color:#FF6600; border-color:#FF6600;">
                                Save
                            </button>
                        </div>
                    </form>


            </div>
        </div>

    </div>

@endsection
