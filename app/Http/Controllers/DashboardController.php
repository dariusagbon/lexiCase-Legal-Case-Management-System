<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use App\Models\LegalCase;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();

        // Ensure user has a role set
        if (!$user || empty($user->role)) {
            abort(403, 'User role not configured');
        }

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        if ($user->isLawyer()) {
            return $this->lawyerDashboard();
        }

        abort(403, 'Invalid user role');
    }

    private function adminDashboard(): View
    {
        $totalCases = LegalCase::count();
        $totalLawyers = Lawyer::count();
        $activeCases = LegalCase::where('status', 'open')->count();
        $pendingCases = LegalCase::where('status', 'pending')->count();
        $closedCases = LegalCase::where('status', 'closed')->count();
        $upcomingDeadlines = LegalCase::where('filing_date', '>=', now())->count();

        $recentCases = LegalCase::with('lawyer')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $activeLawyers = Lawyer::withCount('cases')
            ->orderBy('cases_count', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'totalCases' => $totalCases,
            'totalLawyers' => $totalLawyers,
            'activeCases' => $activeCases,
            'pendingCases' => $pendingCases,
            'closedCases' => $closedCases,
            'upcomingDeadlines' => $upcomingDeadlines,
            'recentCases' => $recentCases,
            'activeLawyers' => $activeLawyers,
        ]);
    }

    private function lawyerDashboard(): View
    {
        $user = auth()->user();
        $lawyerId = $user?->lawyer_id;

        // If lawyer doesn't have a lawyer_id, find or create one
        if (! $lawyerId) {
            // Try to find existing lawyer by email
            $lawyer = Lawyer::where('email', $user->email)->first();
            
            // If not found, create a new lawyer record
            if (! $lawyer) {
                $lawyer = Lawyer::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => '',
                    'specialization' => '',
                    'experience_years' => 0,
                ]);
            }
            
            $user->update(['lawyer_id' => $lawyer->id]);
            $lawyerId = $lawyer->id;
        }

        $myCases = LegalCase::where('lawyer_id', $lawyerId)
            ->orderByDesc('filing_date')
            ->get();

        return view('lawyer.dashboard', [
            'myCases' => $myCases,
            'myOpenCases' => $myCases->where('status', 'open')->count(),
            'myPendingCases' => $myCases->where('status', 'pending')->count(),
            'myClosedCases' => $myCases->where('status', 'closed')->count(),
            'myLawyer' => Lawyer::findOrFail($lawyerId),
        ]);
    }
}
