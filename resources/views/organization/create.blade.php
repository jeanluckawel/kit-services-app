@extends('layoutsddd.app')

@section('title', 'Create Department / Section / Job Title')

@section('content')

    <div class="card m-5">
        <div class="card-header" style="background:#FF6600;color:white">
            <h4>Create Organization Entry</h4>
        </div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('org.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    <!-- DEPARTMENT -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Department <span class="text-danger">*</span></label>
                        <input type="text" name="department" class="form-control" required
                               list="departments" placeholder="Select or type new">
                        <datalist id="departments">
                            @foreach($departments as $dept)
                                <option value="{{ $dept->name }}"></option>
                            @endforeach
                        </datalist>
                        @error('department')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- SECTION -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Section <span class="text-danger">*</span></label>
                        <input type="text" name="section" class="form-control" required
                               list="sections" placeholder="Select or type new">
                        <datalist id="sections">
                            @foreach($sections as $sec)
                                <option value="{{ $sec->name }}"></option>
                            @endforeach
                        </datalist>
                        @error('section')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- JOB TITLE -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Job Title <span class="text-danger">*</span></label>
                        <input type="text" name="jobtitle" class="form-control" required placeholder="Enter job title">
                        @error('jobtitle')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button class="btn btn-success">Save</button>
                    <a href="{{ route('org.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>

@endsection
