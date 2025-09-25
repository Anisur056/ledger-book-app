@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="fas fa-chart-pie"></i> Accounts Heads - {{ $business->name }}
    </h2>
    <div>
        <a href="{{ route('businesses.accounts-heads.create', $business) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Account Head
        </a>
        <a href="{{ route('businesses.show', $business) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Business
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($accountsHeads->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accountsHeads as $accountHead)
                    <tr>
                        <td><strong>{{ $accountHead->code }}</strong></td>
                        <td>{{ $accountHead->name }}</td>
                        <td>
                            <span class="badge bg-{{ $accountHead->type === 'income' ? 'success' : ($accountHead->type === 'expense' ? 'danger' : 'info') }}">
                                {{ ucfirst($accountHead->type) }}
                            </span>
                        </td>
                        <td>{{ $accountHead->description ?: 'No description' }}</td>
                        <td>
                            <span class="badge bg-{{ $accountHead->is_active ? 'success' : 'secondary' }}">
                                {{ $accountHead->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="table-actions">
                            <a href="{{ route('businesses.accounts-heads.edit', [$business, $accountHead]) }}" 
                               class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('businesses.accounts-heads.destroy', [$business, $accountHead]) }}" 
                                  method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> No accounts heads found. 
            <a href="{{ route('businesses.accounts-heads.create', $business) }}">Create your first account head</a> to organize your transactions.
        </div>
        @endif
    </div>
</div>
@endsection