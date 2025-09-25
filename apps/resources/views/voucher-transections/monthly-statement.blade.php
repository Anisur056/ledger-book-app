@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Monthly Statement - {{ $ledgerBook->name }}
                    <div class="float-end">
                        <a href="{{ route('ledger-books.monthly-statement', ['ledgerBook' => $ledgerBook, 'month' => $month, 'print' => true]) }}" 
                           target="_blank" class="btn btn-sm btn-primary">Print</a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('ledger-books.monthly-statement', $ledgerBook) }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="month" class="form-control" name="month" value="{{ $month }}" onchange="this.form.submit()">
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Voucher No.</th>
                                    <th>Account Head</th>
                                    <th>Description</th>
                                    <th class="text-end">Debit</th>
                                    <th class="text-end">Credit</th>
                                    <th class="text-end">Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $runningBalance = 0;
                                    $openingBalance = $openingBalance ?? 0;
                                    $runningBalance = $openingBalance;
                                @endphp
                                
                                <!-- Opening Balance Row -->
                                <tr class="table-warning">
                                    <td colspan="4" class="text-end"><strong>Opening Balance</strong></td>
                                    <td class="text-end"></td>
                                    <td class="text-end"></td>
                                    <td class="text-end"><strong>{{ number_format($openingBalance, 2) }}</strong></td>
                                </tr>
                                
                                @foreach($transactions as $transaction)
                                @php
                                    if ($transaction->transaction_type === 'debit') {
                                        $runningBalance += $transaction->amount;
                                    } else {
                                        $runningBalance -= $transaction->amount;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y') }}</td>
                                    <td>{{ $transaction->voucher_number }}</td>
                                    <td>{{ $transaction->accountsHead->name }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td class="text-end">
                                        {{ $transaction->transaction_type === 'debit' ? number_format($transaction->amount, 2) : '-' }}
                                    </td>
                                    <td class="text-end">
                                        {{ $transaction->transaction_type === 'credit' ? number_format($transaction->amount, 2) : '-' }}
                                    </td>
                                    <td class="text-end {{ $runningBalance >= 0 ? 'text-danger' : 'text-success' }}">
                                        <strong>{{ number_format(abs($runningBalance), 2) }}</strong>
                                        <br>
                                        <small class="text-muted">({{ $runningBalance >= 0 ? 'Dr' : 'Cr' }})</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-active">
                                    <td colspan="4" class="text-end"><strong>Total for {{ date('F Y', strtotime($month)) }}:</strong></td>
                                    <td class="text-end"><strong>{{ number_format($debitTotal, 2) }}</strong></td>
                                    <td class="text-end"><strong>{{ number_format($creditTotal, 2) }}</strong></td>
                                    <td class="text-end"></td>
                                </tr>
                                <tr class="table-info">
                                    <td colspan="4" class="text-end"><strong>Closing Balance:</strong></td>
                                    <td class="text-end"></td>
                                    <td class="text-end"></td>
                                    <td class="text-end">
                                        <strong class="{{ $runningBalance >= 0 ? 'text-danger' : 'text-success' }}">
                                            {{ number_format(abs($runningBalance), 2) }}
                                            ({{ $runningBalance >= 0 ? 'Debit' : 'Credit' }})
                                        </strong>
                                    </td>
                                </tr>
                                <tr class="table-secondary">
                                    <td colspan="4" class="text-end"><strong>Net Movement:</strong></td>
                                    <td colspan="3" class="text-end">
                                        <strong>
                                            Debit: {{ number_format($debitTotal, 2) }} | 
                                            Credit: {{ number_format($creditTotal, 2) }} | 
                                            Net: {{ number_format($debitTotal - $creditTotal, 2) }}
                                            ({{ $debitTotal > $creditTotal ? 'Dr' : 'Cr' }})
                                        </strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Summary Cards -->
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card text-white bg-primary">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Opening Balance</h5>
                                    <h3>{{ number_format($openingBalance, 2) }}</h3>
                                    <p class="card-text">{{ $openingBalance >= 0 ? 'Debit' : 'Credit' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-success">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Total Credit</h5>
                                    <h3>{{ number_format($creditTotal, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-danger">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Total Debit</h5>
                                    <h3>{{ number_format($debitTotal, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-info">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Closing Balance</h5>
                                    <h3>{{ number_format(abs($runningBalance), 2) }}</h3>
                                    <p class="card-text">{{ $runningBalance >= 0 ? 'Debit' : 'Credit' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection