@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Voucher Transaction</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('ledger-books.voucher-transections.update', [$ledgerBook, $voucherTransection]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <label for="accounts_head_id" class="col-md-4 col-form-label">Account Head</label>
                        <div class="col-md-8">
                            <select class="form-select @error('accounts_head_id') is-invalid @enderror" id="accounts_head_id" name="accounts_head_id" required>
                                <option value="">Select Account Head</option>
                                @foreach($accountsHeads as $accountHead)
                                    <option value="{{ $accountHead->id }}" 
                                        {{ old('accounts_head_id', $voucherTransection->accounts_head_id) == $accountHead->id ? 'selected' : '' }}>
                                        {{ $accountHead->code }} - {{ $accountHead->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('accounts_head_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="transaction_type" class="col-md-4 col-form-label">Transaction Type</label>
                        <div class="col-md-8">
                            <select class="form-select @error('transaction_type') is-invalid @enderror" id="transaction_type" name="transaction_type" required>
                                <option value="debit" {{ old('transaction_type', $voucherTransection->transaction_type) == 'debit' ? 'selected' : '' }}>Debit</option>
                                <option value="credit" {{ old('transaction_type', $voucherTransection->transaction_type) == 'credit' ? 'selected' : '' }}>Credit</option>
                            </select>
                            @error('transaction_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="transaction_date" class="col-md-4 col-form-label">Date</label>
                        <div class="col-md-8">
                            <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" 
                                   id="transaction_date" name="transaction_date" 
                                   value="{{ old('transaction_date', $voucherTransection->transaction_date->format('Y-m-d')) }}" required>
                            @error('transaction_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="transaction_time" class="col-md-4 col-form-label">Time</label>
                        <div class="col-md-8">
                            <input type="time" class="form-control @error('transaction_time') is-invalid @enderror" 
                                   id="transaction_time" name="transaction_time" 
                                   value="{{ old('transaction_time', $voucherTransection->transaction_time) }}" required>
                            @error('transaction_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="amount" class="col-md-4 col-form-label">Amount</label>
                        <div class="col-md-8">
                            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                                   id="amount" name="amount" value="{{ old('amount', $voucherTransection->amount) }}" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="description" class="col-md-4 col-form-label">Description</label>
                        <div class="col-md-8">
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" required>{{ old('description', $voucherTransection->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="voucher_files" class="col-md-4 col-form-label">Additional Documents</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control @error('voucher_files') is-invalid @enderror" 
                                   id="voucher_files" name="voucher_files[]" multiple>
                            <small class="form-text text-muted">You can select multiple files (Max 10MB each)</small>
                            @error('voucher_files')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            @if($voucherTransection->voucherUploads->count() > 0)
                            <div class="mt-3">
                                <h6>Current Documents:</h6>
                                @foreach($voucherTransection->voucherUploads as $upload)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>{{ $upload->original_name }}</span>
                                    <a href="{{ Storage::disk('public')->url($upload->file_path) }}" 
                                       target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">Update Voucher</button>
                            <a href="{{ route('ledger-books.voucher-transections.show', [$ledgerBook, $voucherTransection]) }}" 
                               class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection