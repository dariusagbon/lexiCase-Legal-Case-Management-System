<?php

namespace App\Http\Controllers;

use App\Models\LegalCase;
use App\Models\Lawyer;
use Illuminate\View\View;

class LawyerCaseController extends Controller
{
    /**
     * Display available cases for the lawyer to claim.
     */
    public function available(): View
    {
        $lawyerId = auth()->user()?->lawyer_id;

        if (!$lawyerId) {
            abort(403, 'Unauthorized');
        }

        $lawyer = Lawyer::findOrFail($lawyerId);

        $availableCases = LegalCase::where('lawyer_id', null)
            ->where('status', '!=', 'closed')
            ->orderByDesc('filing_date')
            ->paginate(10);

        $myCases = LegalCase::where('lawyer_id', $lawyerId)
            ->where('status', '!=', 'closed')
            ->count();

        return view('lawyer.available-cases', compact('availableCases', 'lawyer', 'myCases'));
    }

    /**
     * Claim a case for the lawyer.
     */
    public function claim(LegalCase $case)
    {
        $lawyerId = auth()->user()?->lawyer_id;

        if (!$lawyerId) {
            abort(403, 'Unauthorized');
        }

        if ($case->lawyer_id !== null) {
            return redirect()->back()->with('error', 'This case is already assigned to another lawyer.');
        }

        $case->update([
            'lawyer_id' => $lawyerId,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('my-cases.index')->with('success', 'Case claimed successfully!');
    }

    /**
     * Unclaim a case (release it back).
     */
    public function release(LegalCase $case)
    {
        $lawyerId = auth()->user()?->lawyer_id;

        if (!$lawyerId || $case->lawyer_id != $lawyerId) {
            abort(403, 'Unauthorized');
        }

        if ($case->status === 'closed') {
            return redirect()->back()->with('error', 'Cannot release a closed case.');
        }

        $case->update([
            'lawyer_id' => null,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Case released successfully!');
    }

    public function index(): View
    {
        $lawyerId = auth()->user()?->lawyer_id;

        if (! $lawyerId) {
            abort(403, 'Unauthorized');
        }

        $lawyer = Lawyer::findOrFail($lawyerId);

        $myCases = LegalCase::where('lawyer_id', $lawyerId)
            ->orderByDesc('filing_date')
            ->paginate(10);

        $openCases = LegalCase::where('lawyer_id', $lawyerId)->where('status', 'open')->count();
        $pendingCases = LegalCase::where('lawyer_id', $lawyerId)->where('status', 'pending')->count();
        $closedCases = LegalCase::where('lawyer_id', $lawyerId)->where('status', 'closed')->count();

        return view('lawyer.my-cases', compact('lawyer', 'myCases', 'openCases', 'pendingCases', 'closedCases'));
    }

    public function show(LegalCase $case): View
    {
        $lawyerId = auth()->user()?->lawyer_id;

        if (! $lawyerId || $case->lawyer_id !== $lawyerId) {
            abort(403, 'Unauthorized');
        }

        $case->load('lawyer');

        return view('lawyer.cases.show', [
            'case' => $case,
            'lawyer' => $case->lawyer,
        ]);
    }
}

