<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Statement - {{ $ledgerBook->name }} - {{ $month }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #333; font-size: 18px; }
        .header .subtitle { color: #666; font-size: 14px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 11px; }
        .table th, .table td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        .table th { background-color: #f5f5f5; font-weight: bold; }
        .table tfoot { background-color: #f8f9fa; font-weight: bold; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .summary { margin-top: 30px; padding: 15px; background-color: #f8f9fa; border-radius: 5px; font-size: 12px; }
        .no-print { display: none; }
        .table-warning { background-color: #fff3cd; }
        .table-active { background-color: #e9ecef; }
        .table-info { background-color: #d1ecf1; }
        .table-secondary { background-color: #f8f9fa; }
        .dr { color: #dc3545; }
        .cr { color: #28a745; }
        @media print {
            .no-print { display: none; }
            body { margin: 10px; font-size: 10px; }
            .header { margin-bottom: 15px; }
            .table { font-size: 9px; }
            .table th, .table td { padding: 4px; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $ledgerBook->business->name }}</h1>
        <div class="subtitle">Monthly Ledger Statement</div>
        <div class="subtitle">Ledger Book: {{ $ledgerBook->name }}</div>
        <div class="subtitle">Period: {{ date('F Y', strtotime($month)) }}</div>
        <div class="subtitle">Generated on: {{ date('M d, Y') }}</div>
    </div>

    <div class="table-responsive">
        <table class="table">
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
                    <td class="text-end {{ $runningBalance >= 0 ? 'dr' : 'cr' }}">
                        <strong>{{ number_format(abs($runningBalance), 2) }}</strong>
                        <br>
                        <small>({{ $runningBalance >= 0 ? 'Dr' : 'Cr' }})</small>
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
                        <strong class="{{ $runningBalance >= 0 ? 'dr' : 'cr' }}">
                            {{ number_format(abs($runningBalance), 2) }}
                            ({{ $runningBalance >= 0 ? 'Debit' : 'Credit' }})
                        </strong>
                    </td>
                </tr>
                <tr class="table-secondary">
                    <td colspan="7" class="text-center">
                        <strong>
                            Net Movement: 
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

    <div class="summary">
        <div class="row">
            <div class="col-3 text-center">
                <strong>Opening Balance:</strong><br>
                {{ number_format($openingBalance, 2) }}<br>
                <small>{{ $openingBalance >= 0 ? 'Debit' : 'Credit' }}</small>
            </div>
            <div class="col-3 text-center">
                <strong>Total Debit:</strong><br>
                {{ number_format($debitTotal, 2) }}
            </div>
            <div class="col-3 text-center">
                <strong>Total Credit:</strong><br>
                {{ number_format($creditTotal, 2) }}
            </div>
            <div class="col-3 text-center">
                <strong>Closing Balance:</strong><br>
                {{ number_format(abs($runningBalance), 2) }}<br>
                <small>{{ $runningBalance >= 0 ? 'Debit' : 'Credit' }}</small>
            </div>
        </div>
    </div>

    <div class="no-print text-center mt-4">
        <button onclick="window.print()" class="btn btn-primary">Print</button>
        <button onclick="window.close()" class="btn btn-secondary">Close</button>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>