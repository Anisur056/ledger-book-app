<?php

namespace App\Http\Controllers;

use App\Models\VoucherTransection;
use App\Models\LedgerBook;
use App\Models\AccountsHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VoucherTransectionController extends Controller
{
    public function index(LedgerBook $ledgerBook)
    {
        $this->authorize('view', $ledgerBook);
        $voucherTransections = $ledgerBook->voucherTransections()->with('accountsHead')->latest()->get();
        return view('voucher-transections.index', compact('ledgerBook', 'voucherTransections'));
    }

    public function create(LedgerBook $ledgerBook)
    {
        $this->authorize('update', $ledgerBook);
        $accountsHeads = $ledgerBook->business->accountsHeads()->where('is_active', true)->get();
        return view('voucher-transections.create', compact('ledgerBook', 'accountsHeads'));
    }

    public function store(Request $request, LedgerBook $ledgerBook)
    {
        $this->authorize('update', $ledgerBook);
        
        $request->validate([
            'accounts_head_id' => 'required|exists:accounts_heads,id',
            'transaction_type' => 'required|in:debit,credit',
            'transaction_date' => 'required|date',
            'transaction_time' => 'required',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'reference_number' => 'nullable|string',
            'voucher_files.*' => 'nullable|file|max:10240', // 10MB max
        ]);

        // Generate voucher number
        $voucherNumber = 'VCH-' . date('YmdHis') . '-' . str_pad($ledgerBook->voucherTransections()->count() + 1, 4, '0', STR_PAD_LEFT);

        $voucherTransection = $ledgerBook->voucherTransections()->create([
            'accounts_head_id' => $request->accounts_head_id,
            'transaction_type' => $request->transaction_type,
            'transaction_date' => $request->transaction_date, // This will be automatically cast to date
            'transaction_time' => $request->transaction_time,
            'amount' => $request->amount,
            'description' => $request->description,
            'voucher_number' => $voucherNumber,
            'reference_number' => $request->reference_number,
        ]);

        // Handle file uploads
        if ($request->hasFile('voucher_files')) {
            foreach ($request->file('voucher_files') as $file) {
                $path = $file->store('voucher-documents/' . $ledgerBook->id, 'public');
                
                $voucherTransection->voucherUploads()->create([
                    'file_path' => $path,
                    'file_name' => $file->hashName(),
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('ledger-books.voucher-transections.index', $ledgerBook)->with('success', 'Voucher transaction created successfully.');
    }

    public function show(LedgerBook $ledgerBook, VoucherTransection $voucherTransection)
    {
        $this->authorize('view', $ledgerBook);
        $this->authorize('view', $voucherTransection);
        
        return view('voucher-transections.show', compact('ledgerBook', 'voucherTransection'));
    }

    public function edit(LedgerBook $ledgerBook, VoucherTransection $voucherTransection)
    {
        $this->authorize('update', $ledgerBook);
        $this->authorize('update', $voucherTransection);
        
        $accountsHeads = $ledgerBook->business->accountsHeads()->where('is_active', true)->get();
        return view('voucher-transections.edit', compact('ledgerBook', 'voucherTransection', 'accountsHeads'));
    }

    public function update(Request $request, LedgerBook $ledgerBook, VoucherTransection $voucherTransection)
    {
        $this->authorize('update', $ledgerBook);
        $this->authorize('update', $voucherTransection);
        
        $request->validate([
            'accounts_head_id' => 'required|exists:accounts_heads,id',
            'transaction_type' => 'required|in:debit,credit',
            'transaction_date' => 'required|date',
            'transaction_time' => 'required',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'reference_number' => 'nullable|string',
            'voucher_files.*' => 'nullable|file|max:10240',
        ]);

        $voucherTransection->update($request->all());

        // Handle new file uploads
        if ($request->hasFile('voucher_files')) {
            foreach ($request->file('voucher_files') as $file) {
                $path = $file->store('voucher-documents/' . $ledgerBook->id, 'public');
                
                $voucherTransection->voucherUploads()->create([
                    'file_path' => $path,
                    'file_name' => $file->hashName(),
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('ledger-books.voucher-transections.index', $ledgerBook)->with('success', 'Voucher transaction updated successfully.');
    }

    public function destroy(LedgerBook $ledgerBook, VoucherTransection $voucherTransection)
    {
        $this->authorize('update', $ledgerBook);
        $this->authorize('delete', $voucherTransection);
        
        // Delete associated files
        foreach ($voucherTransection->voucherUploads as $upload) {
            Storage::disk('public')->delete($upload->file_path);
        }
        
        $voucherTransection->delete();
        return redirect()->route('ledger-books.voucher-transections.index', $ledgerBook)->with('success', 'Voucher transaction deleted successfully.');
    }

    public function monthlyStatement(LedgerBook $ledgerBook, Request $request)
    {
        $this->authorize('view', $ledgerBook);
        
        $month = $request->input('month', date('Y-m'));
        $startDate = date('Y-m-01', strtotime($month));
        $endDate = date('Y-m-t', strtotime($month));
        
        // Get transactions for the selected month
        $transactions = $ledgerBook->voucherTransections()
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->with('accountsHead')
            ->orderBy('transaction_date')
            ->orderBy('transaction_time')
            ->get();
            
        // Calculate opening balance (all transactions before the start of the month)
        $openingBalance = $ledgerBook->voucherTransections()
            ->where('transaction_date', '<', $startDate)
            ->get()
            ->reduce(function ($carry, $transaction) {
                if ($transaction->transaction_type === 'debit') {
                    return $carry + $transaction->amount;
                } else {
                    return $carry - $transaction->amount;
                }
            }, 0);
        
        $debitTotal = $transactions->where('transaction_type', 'debit')->sum('amount');
        $creditTotal = $transactions->where('transaction_type', 'credit')->sum('amount');
        
        if ($request->has('print')) {
            return view('voucher-transections.monthly-statement-print', compact(
                'ledgerBook', 
                'transactions', 
                'debitTotal', 
                'creditTotal', 
                'month',
                'openingBalance'
            ));
        }
        
        return view('voucher-transections.monthly-statement', compact(
            'ledgerBook', 
            'transactions', 
            'debitTotal', 
            'creditTotal', 
            'month',
            'openingBalance'
        ));
    }
}