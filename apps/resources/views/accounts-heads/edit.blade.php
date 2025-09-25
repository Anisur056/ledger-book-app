@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Account Head</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('businesses.accounts-heads.update', [$business, $accountsHead]) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="code" class="form-label">Account Code *</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" 
                               id="code" name="code" value="{{ old('code', $accountsHead->code) }}" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Account Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $accountsHead->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Account Type *</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="asset" {{ old('type', $accountsHead->type) == 'asset' ? 'selected' : '' }}>Asset</option>
                            <option value="liability" {{ old('type', $accountsHead->type) == 'liability' ? 'selected' : '' }}>Liability</option>
                            <option value="equity" {{ old('type', $accountsHead->type) == 'equity' ? 'selected' : '' }}>Equity</option>
                            <option value="income" {{ old('type', $accountsHead->type) == 'income' ? 'selected' : '' }}>Income</option>
                            <option value="expense" {{ old('type', $accountsHead->type) == 'expense' ? 'selected' : '' }}>Expense</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $accountsHead->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" 
                               {{ old('is_active', $accountsHead->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active Account Head</label>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('businesses.accounts-heads.index', $business) }}" class="btn btn-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Account Head</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection