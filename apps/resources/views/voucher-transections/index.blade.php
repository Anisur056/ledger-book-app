@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="fas fa-exchange-alt"></i> Voucher Transactions
        <small class="text-muted">- {{ $ledgerBook->name }}</small>
    </h2>
    <div>
        <a href="{{ route('ledger-books.voucher-transections.create', $ledgerBook) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Transaction
        </a>
        <a href="{{ route('ledger-books.monthly-statement', $ledgerBook) }}" class="btn btn-info">
            <i class="fas fa-print"></i> Monthly Statement
        </a>
        <a href="{{ route('businesses.ledger-books.show', [$ledgerBook->business, $ledgerBook]) }}" 
           class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Ledger Book
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($voucherTransections->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Voucher No.</th>
                        <th>Account Head</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th class="text-end">Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($voucherTransections as $transaction)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y') }}</td>
                        <td>{{ $transaction->voucher_number }}</td>
                        <td>{{ $transaction->accountsHead->name }}</td>
                        <td>{{ Str::limit($transaction->description, 50) }}</td>
                        <td>
                            <span class="badge bg-{{ $transaction->transaction_type === 'debit' ? 'danger' : 'success' }}">
                                {{ ucfirst($transaction->transaction_type) }}
                            </span>
                        </td>
                        <td class="text-end">${{ number_format($transaction->amount, 2) }}</td>
                        <td class="table-actions">
                            <a href="{{ route('ledger-books.voucher-transections.show', [$ledgerBook, $transaction]) }}" 
                               class="btn btn-sm btn-outline-primary" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('ledger-books.voucher-transections.edit', [$ledgerBook, $transaction]) }}" 
                               class="btn btn-sm btn-outline-secondary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('ledger-books.voucher-transections.destroy', [$ledgerBook, $transaction]) }}" 
                                  method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-active">
                        <td colspan="5" class="text-end"><strong>Total:</strong></td>
                        <td class="text-end">
                            <strong>
                                Debit: ${{ number_format($voucherTransections->where('transaction_type', 'debit')->sum('amount'), 2) }}<br>
                                Credit: ${{ number_format($voucherTransections->where('transaction_type', 'credit')->sum('amount'), 2) }}
                            </strong>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> No voucher transactions found. 
            <a href="{{ route('ledger-books.voucher-transections.create', $ledgerBook) }}">Create your first transaction</a> to get started.
        </div>
        @endif
    </div>
</div>
@endsection