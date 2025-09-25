<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    public function index()
    {
        $businesses = Auth::user()->businesses;
        return view('businesses.index', compact('businesses'));
    }

    public function create()
    {
        return view('businesses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'description' => 'nullable|string',
        ]);

        Auth::user()->businesses()->create($request->all());

        return redirect()->route('businesses.index')->with('success', 'Business created successfully.');
    }

    public function show(Business $business)
    {
        $this->authorize('view', $business);
        return view('businesses.show', compact('business'));
    }

    public function edit(Business $business)
    {
        $this->authorize('update', $business);
        return view('businesses.edit', compact('business'));
    }

    public function update(Request $request, Business $business)
    {
        $this->authorize('update', $business);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'description' => 'nullable|string',
        ]);

        $business->update($request->all());

        return redirect()->route('businesses.index')->with('success', 'Business updated successfully.');
    }

    public function destroy(Business $business)
    {
        $this->authorize('delete', $business);
        $business->delete();
        return redirect()->route('businesses.index')->with('success', 'Business deleted successfully.');
    }
}