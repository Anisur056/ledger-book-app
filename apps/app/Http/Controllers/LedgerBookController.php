<?php

namespace App\Http\Controllers;

use App\Models\LedgerBook;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LedgerBookController extends Controller
{
    public function index(Business $business)
    {
        $this->authorize('view', $business);
        $ledgerBooks = $business->ledgerBooks;
        return view('ledger-books.index', compact('business', 'ledgerBooks'));
    }

    public function create(Business $business)
    {
        $this->authorize('update', $business);
        return view('ledger-books.create', compact('business'));
    }

    public function store(Request $request, Business $business)
    {
        $this->authorize('update', $business);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'financial_year' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string',
        ]);

        $business->ledgerBooks()->create($request->all());

        return redirect()->route('businesses.ledger-books.index', $business)->with('success', 'Ledger book created successfully.');
    }

    public function show(Business $business, LedgerBook $ledgerBook)
    {
        $this->authorize('view', $business);
        $this->authorize('view', $ledgerBook);
        
        return view('ledger-books.show', compact('business', 'ledgerBook'));
    }

    public function edit(Business $business, LedgerBook $ledgerBook)
    {
        $this->authorize('update', $business);
        $this->authorize('update', $ledgerBook);
        
        return view('ledger-books.edit', compact('business', 'ledgerBook'));
    }

    public function update(Request $request, Business $business, LedgerBook $ledgerBook)
    {
        $this->authorize('update', $business);
        $this->authorize('update', $ledgerBook);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'financial_year' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string',
        ]);

        $ledgerBook->update($request->all());

        return redirect()->route('businesses.ledger-books.index', $business)->with('success', 'Ledger book updated successfully.');
    }

    public function destroy(Business $business, LedgerBook $ledgerBook)
    {
        $this->authorize('update', $business);
        $this->authorize('delete', $ledgerBook);
        
        $ledgerBook->delete();
        return redirect()->route('businesses.ledger-books.index', $business)->with('success', 'Ledger book deleted successfully.');
    }
}