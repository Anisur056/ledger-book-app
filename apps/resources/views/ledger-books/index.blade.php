@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="fas fa-book"></i> Ledger Books - {{ $business->name }}
    </h2>
    <div>
        <a href="{{ route('businesses.ledger-books.create', $business) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Ledger Book
        </a>
        <a href="{{ route('businesses.show', $business) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Business
        </a>
    </div>
</div>

<div class="row">
    @foreach($ledgerBooks as $ledgerBook)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">{{ $ledgerBook->name }}</h5>
                <p class="card-text text-muted">{{ $ledgerBook->description ?: 'No description provided.' }}</p>
                <div class="mb-2">
                    <small class="text-muted">
                        <i class="fas fa-calendar"></i> {{ $ledgerBook->financial_year }}
                    </small>
                </div>
                <div class="mb-2">
                    <small class="text-muted">
                        <i class="fas fa-exchange-alt"></i> {{ $ledgerBook->voucherTransections->count() }} Transactions
                    </small>
                </div>
                <div class="mb-2">
                    <small class="text-muted">
                        <i class="fas fa-calendar-day"></i> 
                        {{ $ledgerBook->start_date->format('M d, Y') }} to {{ $ledgerBook->end_date->format('M d, Y') }}
                    </small>
                </div>
                <div class="mb-2">
                    <span class="badge bg-{{ $ledgerBook->is_active ? 'success' : 'secondary' }}">
                        {{ $ledgerBook->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
            <div class="card-footer">
                <div class="btn-group w-100">
                    <a href="{{ route('businesses.ledger-books.show', [$business, $ledgerBook]) }}" 
                       class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye"></i> View
                    </a>
                    <a href="{{ route('ledger-books.voucher-transections.index', $ledgerBook) }}" 
                       class="btn btn-outline-info btn-sm">
                        <i class="fas fa-list"></i> Transactions
                    </a>
                    <a href="{{ route('businesses.ledger-books.edit', [$business, $ledgerBook]) }}" 
                       class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @if($ledgerBooks->isEmpty())
    <div class="col-12">
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> No ledger books found for this business. 
            <a href="{{ route('businesses.ledger-books.create', $business) }}">Create your first ledger book</a> to start recording transactions.
        </div>
    </div>
    @endif
</div>
@endsection