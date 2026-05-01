<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LawyerController extends Controller
{
    /**
     * Display a listing of all lawyers.
     */
    public function index()
    {
        $lawyers = Lawyer::paginate(10);
        return view('lawyers.index', compact('lawyers'));
    }

    /**
     * Show the form for creating a new lawyer.
     */
    public function create()
    {
        return view('lawyers.create');
    }

    /**
     * Store a newly created lawyer in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:lawyers|unique:users',
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $lawyer = Lawyer::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'specialization' => $validated['specialization'],
            'experience_years' => $validated['experience_years'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'lawyer',
            'lawyer_id' => $lawyer->id,
        ]);

        return redirect()->route('lawyers.index')->with('success', 'Lawyer created successfully.');
    }

    /**
     * Display the specified lawyer.
     */
    public function show(Lawyer $lawyer)
    {
        return view('lawyers.show', compact('lawyer'));
    }

    /**
     * Show the form for editing the specified lawyer.
     */
    public function edit(Lawyer $lawyer)
    {
        return view('lawyers.edit', compact('lawyer'));
    }

    /**
     * Update the specified lawyer in storage.
     */
    public function update(Request $request, Lawyer $lawyer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:lawyers,email,' . $lawyer->id,
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
        ]);

        $lawyer->update($validated);

        return redirect()->route('lawyers.show', $lawyer)->with('success', 'Lawyer updated successfully.');
    }

    /**
     * Remove the specified lawyer from storage.
     */
    public function destroy(Lawyer $lawyer)
    {
        $lawyer->delete();

        return redirect()->route('lawyers.index')->with('success', 'Lawyer deleted successfully.');
    }
}
