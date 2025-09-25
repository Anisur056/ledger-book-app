@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="fas fa-book"></i> {{ $ledgerBook->name }}
        <small class="text-muted">- {{ $business->name }}</small>
    </h2>
    <div>
        <a href="{{ route('ledger-books.voucher-transections.create', $ledgerBook) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Transaction
        </a>
        <a href="{{ route('businesses.ledger-books.index', $business) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Ledger Books
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Ledger Book Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Financial Year:</strong> {{ $ledgerBook->financial_year }}</p>
                        <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($ledgerBook->start_date)->format('M d, Y') }}</p>
                        <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($ledgerBook->end_date)->format('M d, Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status:</strong> 
                            <span class="badge bg-{{ $ledgerBook->is_active ? 'success' : 'secondary' }}">
                                {{ $ledgerBook->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                        <p><strong>Total Transactions:</strong> {{ $ledgerBook->voucherTransections->count() }}</p>
                        <p><strong>Created:</strong> {{ $ledgerBook->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p><strong>Description:</strong></p>
                        <p>{{ $ledgerBook->description ?: 'No description provided.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Transactions</h5>
                <a href="{{ route('ledger-books.voucher-transections.index', $ledgerBook) }}" class="btn btn-sm btn-outline-primary">
                    View All
                </a>
            </div>
            <div class="card-body">
                @if($ledgerBook->voucherTransections->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Voucher No.</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ledgerBook->voucherTransections->sortByDesc('created_at')->take(5) as $transaction)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y') }}</td>
                                <td>{{ $transaction->voucher_number }}</td>
                                <td>
                                    <span class="badge bg-{{ $transaction->transaction_type === 'debit' ? 'danger' : 'success' }}">
                                        {{ ucfirst($transaction->transaction_type) }}
                                    </span>
                                </td>
                                <td class="text-end">${{ number_format($transaction->amount, 2) }}</td>
                                <td>
                                    <a href="{{ route('ledger-books.voucher-transections.show', [$ledgerBook, $transaction]) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center">No transactions recorded yet.</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('ledger-books.voucher-transections.create', $ledgerBook) }}" 
                       class="btn btn-primary">
                        <i class="fas fa-plus"></i> New Transaction
                    </a>
                    <a href="{{ route('ledger-books.voucher-transections.index', $ledgerBook) }}" 
                       class="btn btn-outline-primary">
                        <i class="fas fa-list"></i> View Transactions
                    </a>
                    <a href="{{ route('ledger-books.monthly-statement', $ledgerBook) }}" 
                       class="btn btn-outline-info">
                        <i class="fas fa-print"></i> Monthly Statement
                    </a>
                    <a href="{{ route('businesses.ledger-books.edit', [$business, $ledgerBook]) }}" 
                       class="btn btn-outline-secondary">
                        <i class="fas fa-edit"></i> Edit Ledger Book
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Financial Summary</h5>
            </div>
            <div class="card-body">
                @php
                    $debitTotal = $ledgerBook->voucherTransections->where('transaction_type', 'debit')->sum('amount');
                    $creditTotal = $ledgerBook->voucherTransections->where('transaction_type', 'credit')->sum('amount');
                    $balance = $debitTotal - $creditTotal;
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
                        <h4 class="text-{{ $balance >= 0 ? 'danger' : 'success' }}">
                            ${{ number_format(abs($balance), 2) }}
                        </h4>
                        <p class="text-muted">{{ $balance >= 0 ? 'Debit' : 'Credit' }} Balance</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection