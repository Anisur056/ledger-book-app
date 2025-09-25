@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-building"></i> {{ $business->name }}</h2>
    <div>
        <a href="{{ route('businesses.edit', $business) }}" class="btn btn-outline-secondary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('businesses.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Back to Businesses
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Business Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Email:</strong> {{ $business->email ?: 'Not provided' }}</p>
                        <p><strong>Phone:</strong> {{ $business->phone ?: 'Not provided' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Address:</strong></p>
                        <p>{{ $business->address ?: 'Not provided' }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p><strong>Description:</strong></p>
                        <p>{{ $business->description ?: 'No description provided.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Quick Stats</h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-book fa-2x text-primary"></i>
                        <h4>{{ $business->ledgerBooks->count() }}</h4>
                        <p class="text-muted">Ledger Books</p>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-chart-pie fa-2x text-success"></i>
                        <h4>{{ $business->accountsHeads->count() }}</h4>
                        <p class="text-muted">Accounts Heads</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Ledger Books</h5>
                <a href="{{ route('businesses.ledger-books.create', $business) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Add New
                </a>
            </div>
            <div class="card-body">
                @if($business->ledgerBooks->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($business->ledgerBooks->take(5) as $ledgerBook)
                        <a href="{{ route('businesses.ledger-books.show', [$business, $ledgerBook]) }}" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $ledgerBook->name }}</h6>
                                <small class="text-muted">{{ $ledgerBook->financial_year }}</small>
                            </div>
                            <p class="mb-1 small text-muted">{{ $ledgerBook->description ?: 'No description' }}</p>
                            <small class="text-muted">{{ $ledgerBook->voucherTransections->count() }} transactions</small>
                        </a>
                        @endforeach
                    </div>
                    @if($business->ledgerBooks->count() > 5)
                    <div class="text-center mt-3">
                        <a href="{{ route('businesses.ledger-books.index', $business) }}" class="btn btn-sm btn-outline-primary">
                            View All Ledger Books
                        </a>
                    </div>
                    @endif
                @else
                    <p class="text-muted text-center">No ledger books created yet.</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Accounts Heads</h5>
                <a href="{{ route('businesses.accounts-heads.create', $business) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Add New
                </a>
            </div>
            <div class="card-body">
                @if($business->accountsHeads->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($business->accountsHeads->take(5) as $accountHead)
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $accountHead->code }} - {{ $accountHead->name }}</h6>
                                <span class="badge bg-{{ $accountHead->type === 'income' ? 'success' : ($accountHead->type === 'expense' ? 'danger' : 'info') }}">
                                    {{ ucfirst($accountHead->type) }}
                                </span>
                            </div>
                            <p class="mb-1 small text-muted">{{ $accountHead->description ?: 'No description' }}</p>
                        </div>
                        @endforeach
                    </div>
                    @if($business->accountsHeads->count() > 5)
                    <div class="text-center mt-3">
                        <a href="{{ route('businesses.accounts-heads.index', $business) }}" class="btn btn-sm btn-outline-primary">
                            View All Accounts Heads
                        </a>
                    </div>
                    @endif
                @else
                    <p class="text-muted text-center">No accounts heads created yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection