@extends('layoutsddd.app')

@section('title','Edit User - KIT SERVICES')

@section('content')

    <div class="container p-5">

        <div class="card shadow" style="border-radius:0;">

            <!-- HEADER -->
            <div class="card-header text-white" style="background-color:#FF6600;border-radius:0;">
                <h5 class="mb-0">Edit User</h5>
            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- BASIC INFO -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold">Name <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   class="form-control"
                                   style="border-radius:0;"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="form-control"
                                   style="border-radius:0;"
                                   disabled
                                   required>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- PASSWORD -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="fw-bold">New Password (leave blank if not changing)</label>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   style="border-radius:0;">
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit"
                                class="btn text-white"
                                style="background-color:#FF6600;border-color:#FF6600;">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection
