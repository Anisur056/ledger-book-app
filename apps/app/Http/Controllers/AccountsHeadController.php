<?php

namespace App\Http\Controllers;

use App\Models\AccountsHead;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountsHeadController extends Controller
{
    public function index(Business $business)
    {
        $this->authorize('view', $business);
        $accountsHeads = $business->accountsHeads;
        return view('accounts-heads.index', compact('business', 'accountsHeads'));
    }

    public function create(Business $business)
    {
        $this->authorize('update', $business);
        return view('accounts-heads.create', compact('business'));
    }

    public function store(Request $request, Business $business)
    {
        $this->authorize('update', $business);
        
        $request->validate([
            'code' => 'required|string|unique:accounts_heads,code',
            'name' => 'required|string|max:255',
            'type' => 'required|in:asset,liability,equity,income,expense',
            'description' => 'nullable|string',
        ]);

        $business->accountsHeads()->create($request->all());

        return redirect()->route('businesses.accounts-heads.index', $business)->with('success', 'Account head created successfully.');
    }

    public function show(Business $business, AccountsHead $accountsHead)
    {
        $this->authorize('view', $business);
        $this->authorize('view', $accountsHead);
        
        return view('accounts-heads.show', compact('business', 'accountsHead'));
    }

    public function edit(Business $business, AccountsHead $accountsHead)
    {
        $this->authorize('update', $business);
        $this->authorize('update', $accountsHead);
        
        return view('accounts-heads.edit', compact('business', 'accountsHead'));
    }

    public function update(Request $request, Business $business, AccountsHead $accountsHead)
    {
        $this->authorize('update', $business);
        $this->authorize('update', $accountsHead);
        
        $request->validate([
            'code' => 'required|string|unique:accounts_heads,code,' . $accountsHead->id,
            'name' => 'required|string|max:255',
            'type' => 'required|in:asset,liability,equity,income,expense',
            'description' => 'nullable|string',
        ]);

        $accountsHead->update($request->all());

        return redirect()->route('businesses.accounts-heads.index', $business)->with('success', 'Account head updated successfully.');
    }

    public function destroy(Business $business, AccountsHead $accountsHead)
    {
        $this->authorize('update', $business);
        $this->authorize('delete', $accountsHead);
        
        $accountsHead->delete();
        return redirect()->route('businesses.accounts-heads.index', $business)->with('success', 'Account head deleted successfully.');
    }
}