@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="fas fa-receipt"></i> Voucher Details
        <small class="text-muted">- {{ $voucherTransection->voucher_number }}</small>
    </h2>
    <div>
        <a href="{{ route('ledger-books.voucher-transections.edit', [$ledgerBook, $voucherTransection]) }}" 
           class="btn btn-outline-secondary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('ledger-books.voucher-transections.index', $ledgerBook) }}" 
           class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Back to Transactions
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Transaction Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Voucher Number:</strong> {{ $voucherTransection->voucher_number }}</p>
                        <p><strong>Transaction Date:</strong> {{ \Carbon\Carbon::parse($voucherTransection->transaction_date)->format('M d, Y') }}</p>
                        <p><strong>Transaction Time:</strong> {{ $voucherTransection->transaction_time }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Account Head:</strong> {{ $voucherTransection->accountsHead->name }}</p>
                        <p><strong>Transaction Type:</strong> 
                            <span class="badge bg-{{ $voucherTransection->transaction_type === 'debit' ? 'danger' : 'success' }}">
                                {{ ucfirst($voucherTransection->transaction_type) }}
                            </span>
                        </p>
                        <p><strong>Amount:</strong> <span class="h5">${{ number_format($voucherTransection->amount, 2) }}</span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p><strong>Description:</strong></p>
                        <p>{{ $voucherTransection->description }}</p>
                    </div>
                </div>
                @if($voucherTransection->reference_number)
                <div class="row">
                    <div class="col-12">
                        <p><strong>Reference Number:</strong> {{ $voucherTransection->reference_number }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Attached Documents</h5>
            </div>
            <div class="card-body">
                @if($voucherTransection->voucherUploads->count() > 0)
                    <div class="list-group">
                        @foreach($voucherTransection->voucherUploads as $upload)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-file"></i> 
                                    <small>{{ $upload->original_name }}</small>
                                </div>
                                <a href="{{ Storage::disk('public')->url($upload->file_path) }}" 
                                   target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center">No documents attached.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection