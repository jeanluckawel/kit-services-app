@extends('layoutsddd.app')

@section('title','Organization List')

@section('content')

    <div class="card m-5">

        <div class="card-header" style="background:#FF6600;color:white">
            <h4>Organization Structure</h4>
            <a href="{{ route('org.create') }}" class="btn btn-light btn-sm float-end">+ Add New</a>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Department</th>
                        <th>Section</th>
                        <th>Job Title</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($departments as $deptKey => $department)
                        @forelse($department->sections as $secKey => $section)
                            @forelse($section->jobTitles as $jobKey => $job)
                                <tr>
                                    <td>{{ $loop->iteration + ($departments->currentPage()-1)*$departments->perPage() }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td>{{ $section->name }}</td>
                                    <td>{{ $job->name }}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm">Edit</a>
{{--                                        <a href="{{ route('job.edit', $job->id) }}" class="btn btn-primary btn-sm">Edit</a>--}}
                                        <form action="#" method="POST" style="display:inline-block">
{{--                                        <form action="{{ route('job.destroy', $job->id) }}" method="POST" style="display:inline-block">--}}
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this job title?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No Job Titles in {{ $section->name }}</td>
                                </tr>
                            @endforelse
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No Sections in {{ $department->name }}</td>
                            </tr>
                        @endforelse
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No Departments found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-end">
                    @if($departments->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $departments->previousPageUrl() }}">&laquo;</a></li>
                    @endif

                    @foreach($departments->getUrlRange(1,$departments->lastPage()) as $page => $url)
                        <li class="page-item {{ $departments->currentPage()==$page?'active':'' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    @if($departments->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $departments->nextPageUrl() }}">&raquo;</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                    @endif
                </ul>
            </div>

        </div>
    </div>

@endsection
