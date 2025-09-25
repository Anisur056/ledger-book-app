@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-building"></i> My Businesses</h2>
    <a href="{{ route('businesses.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Business
    </a>
</div>

<div class="row">
    @foreach($businesses as $business)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">{{ $business->name }}</h5>
                <p class="card-text text-muted">{{ $business->description ?: 'No description provided.' }}</p>
                <div class="mb-2">
                    <small class="text-muted">
                        <i class="fas fa-book"></i> {{ $business->ledgerBooks->count() }} Ledger Books
                    </small>
                </div>
                <div class="mb-2">
                    <small class="text-muted">
                        <i class="fas fa-chart-pie"></i> {{ $business->accountsHeads->count() }} Accounts Heads
                    </small>
                </div>
            </div>
            <div class="card-footer">
                <div class="btn-group w-100">
                    <a href="{{ route('businesses.show', $business) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye"></i> View
                    </a>
                    <a href="{{ route('businesses.edit', $business) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('businesses.destroy', $business) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" 
                                onclick="return confirm('Are you sure you want to delete this business?')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @if($businesses->isEmpty())
    <div class="col-12">
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> No businesses found. 
            <a href="{{ route('businesses.create') }}">Create your first business</a> to get started.
        </div>
    </div>
    @endif
</div>
@endsection