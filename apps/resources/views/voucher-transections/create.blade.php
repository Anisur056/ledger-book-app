@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Voucher Transaction</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ledger-books.voucher-transections.store', $ledgerBook) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="accounts_head_id" class="col-md-4 col-form-label text-md-end">Account Head</label>
                            <div class="col-md-6">
                                <select class="form-select" id="accounts_head_id" name="accounts_head_id" required>
                                    <option value="">Select Account Head</option>
                                    @foreach($accountsHeads as $accountHead)
                                        <option value="{{ $accountHead->id }}">{{ $accountHead->code }} - {{ $accountHead->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="transaction_type" class="col-md-4 col-form-label text-md-end">Transaction Type</label>
                            <div class="col-md-6">
                                <select class="form-select" id="transaction_type" name="transaction_type" required>
                                    <option value="debit">Debit</option>
                                    <option value="credit">Credit</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="transaction_date" class="col-md-4 col-form-label text-md-end">Date</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control" id="transaction_date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="transaction_time" class="col-md-4 col-form-label text-md-end">Time</label>
                            <div class="col-md-6">
                                <input type="time" class="form-control" id="transaction_time" name="transaction_time" value="{{ old('transaction_time', date('H:i')) }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="amount" class="col-md-4 col-form-label text-md-end">Amount</label>
                            <div class="col-md-6">
                                <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">Description</label>
                            <div class="col-md-6">
                                <textarea class="form-control" id="description" name="description" required>{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="voucher_files" class="col-md-4 col-form-label text-md-end">Voucher Documents</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control" id="voucher_files" name="voucher_files[]" multiple>
                                <small class="form-text text-muted">You can select multiple files (Max 10MB each)</small>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Create Voucher</button>
                                <a href="{{ route('ledger-books.voucher-transections.index', $ledgerBook) }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection