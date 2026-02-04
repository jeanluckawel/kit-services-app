@extends('layoutsddd.app')

@section('title', 'Add Perception - KIT SERVICES')

@section('content')
    <div class="card mb-4 m-5">
        <div class="card-header" style="background-color:#FF6600;color:#fff;">
            <h3 class="card-title mb-0">Add Perception</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('perceptions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Amount</label>
                        <input type="number" name="amount" step="0.01" class="form-control @error('amount') is-invalid @enderror" required>
                        @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Currency</label>
                        <select name="currency" class="form-select @error('currency') is-invalid @enderror" required>
                            <option value="">Select</option>
                            <option value="USD">USD</option>
                            <option value="CDF">CDF</option>
                        </select>
                        @error('currency')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">File (optional)</label>
                        <input type="file" name="file" class="form-control">
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Add</button>
                    <a href="{{ route('perceptions.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
