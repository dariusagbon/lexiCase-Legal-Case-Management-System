<?php

namespace App\Http\Controllers;

use App\Models\LegalCase;
use App\Models\Lawyer;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    /**
     * Display a listing of all cases.
     */
    public function index(Request $request)
    {
        $query = LegalCase::with('lawyer');

        if ($search = $request->query('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('case_number', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%");
            });
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($type = $request->query('type')) {
            $query->where('case_type', 'like', "%{$type}%");
        }

        $cases = $query->orderByDesc('filing_date')->paginate(10)->withQueryString();

        return view('case.index', compact('cases'));
    }

    /**
     * Show the form for creating a new case.
     */
    public function create()
    {
        return view('case.create');
    }

    /**
     * Store a newly created case in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'case_number' => 'required|string|unique:cases|max:255',
            'description' => 'required|string',
            'status' => 'required|in:open,closed,pending',
            'case_type' => 'required|string|max:255',
            'filing_date' => 'required|date',
        ]);

        $validated['created_by'] = auth()->id();
        // Since lawyer_id is nullable in your migration, null is acceptable here.
        $validated['lawyer_id'] = null; 

        LegalCase::create($validated);

        // We redirect to index. The error happens in the index view because lawyer is null.
        return redirect()->route('cases.index')->with('success', 'Case created successfully.');
    }

    /**
     * Display the specified case.
     */
    public function show(LegalCase $case)
    {
        $case->load('lawyer', 'creator', 'updater');

        return view('case.show', compact('case'));
    }

    /**
     * Show the form for editing the specified case.
     */
    public function edit(LegalCase $case)
    {
        $lawyers = Lawyer::all();
        return view('case.edit', compact('case', 'lawyers'));
    }

    /**
     * Update the specified case in storage.
     */
    public function update(Request $request, LegalCase $case)
    {
        $validated = $request->validate([
            'lawyer_id' => 'required|exists:lawyers,id',
            'client_name' => 'required|string|max:255',
            'case_number' => 'required|string|unique:cases,case_number,' . $case->id . '|max:255',
            'description' => 'required|string',
            'status' => 'required|in:open,closed,pending',
            'case_type' => 'required|string|max:255',
            'filing_date' => 'required|date',
        ]);

        $validated['updated_by'] = auth()->id();

        $case->update($validated);

        return redirect()->route('cases.show', $case)->with('success', 'Case updated successfully.');
    }

    /**
     * Remove the specified case from storage.
     */
    public function destroy(LegalCase $case)
    {
        $case->delete();

        return redirect()->route('cases.index')->with('success', 'Case deleted successfully.');
    }
}
