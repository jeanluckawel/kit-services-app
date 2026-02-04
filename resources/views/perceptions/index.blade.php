@extends('layoutsddd.app')

@section('title', 'Perceptions - KIT SERVICES')

@section('content')
    <div class="card mb-4 m-5">
        <div class="card-header" style="background-color:#FF6600;color:#fff;">
            <h3 class="card-title mb-0">Perceptions List</h3>
            @can('perception_create')
                <div class="card-tools ms-auto">
                    <a href="{{ route('perceptions.create') }}" class="btn btn-tool" title="Add Perception"
                       style="background:#fff;color:#FF6600;width:40px;height:40px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-plus-lg" style="font-size:20px;"></i>
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="searchPerception" class="form-control" placeholder="Search by name or amount">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-nowrap">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Currency</th>
                        <th>File</th>
                        <th>Date</th>
                        @can('perception_delete')
                            <th>Action</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody id="perceptionTable">
                    @foreach($perceptions as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ number_format($p->amount,2) }}</td>
                            <td>{{ $p->currency }}</td>
                            <td>
                                @if($p->file)
                                    <a href="{{ Storage::url($p->file) }}" target="_blank">View</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                            @can('perception_delete')
                                <td>
                                    <button class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deletePerceptionModal"
                                            data-perception-id="{{ $p->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{ $perceptions->links() }}
            </div>
        </div>
    </div>

    @include('perceptions.partials.deleteModal')

    <script>
        $(document).ready(function() {
            $('#searchPerception').on('keyup', function() {
                let search = $(this).val();
                $.ajax({
                    url: "{{ route('perceptions.search') }}",
                    type: "GET",
                    data: { search: search },
                    success: function(data) {
                        $('#perceptionTable').html(data);
                    }
                });
            });
        });
    </script>
@endsection
