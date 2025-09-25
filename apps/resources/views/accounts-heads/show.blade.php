@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="fas fa-chart-pie"></i> {{ $accountsHead->name }}
        <small class="text-muted">- {{ $business->name }}</small>
    </h2>
    <div>
        <a href="{{ route('businesses.accounts-heads.edit', [$business, $accountsHead]) }}" class="btn btn-outline-secondary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('businesses.accounts-heads.index', $business) }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Back to Accounts Heads
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Account Head Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Code:</strong> {{ $accountsHead->code }}</p>
                        <p><strong>Name:</strong> {{ $accountsHead->name }}</p>
                        <p><strong>Type:</strong> 
                            <span class="badge bg-{{ $accountsHead->type === 'income' ? 'success' : ($accountsHead->type === 'expense' ? 'danger' : 'info') }}">
                                {{ ucfirst($accountsHead->type) }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status:</strong> 
                            <span class="badge bg-{{ $accountsHead->is_active ? 'success' : 'secondary' }}">
                                {{ $accountsHead->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                        <p><strong>Created:</strong> {{ $accountsHead->created_at->format('M d, Y') }}</p>
                        <p><strong>Last Updated:</strong> {{ $accountsHead->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p><strong>Description:</strong></p>
                        <p>{{ $accountsHead->description ?: 'No description provided.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Transaction Summary</h5>
            </div>
            <div class="card-body">
                @php
                    $transactions = $accountsHead->voucherTransections;
                    $debitTotal = $transactions->where('transaction_type', 'debit')->sum('amount');
                    $creditTotal = $transactions->where('transaction_type', 'credit')->sum('amount');
                @endphp
                <div class="text-center">
                    <div class="mb-3">
                        <h4 class="text-danger">${{ number_format($debitTotal, 2) }}</h4>
                        <p class="text-muted">Total Debit</p>
                    </div>
                    <div class="mb-3">
                        <h4 class="text-success">${{ number_format($creditTotal, 2) }}</h4>
                        <p class="text-muted">Total Credit</p>
                    </div>
                    <div class="mb-3">
                        <h4>{{ $transactions->count() }}</h4>
                        <p class="text-muted">Total Transactions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection