<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LawyerCaseController;
use App\Models\Lawyer;
use App\Models\LegalCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $totalLawyers = Lawyer::count();
    $resolvedCasesCount = LegalCase::where('status', 'closed')->count();
    $totalClients = LegalCase::distinct('client_name')->count('client_name');
    $firstRecord = LegalCase::orderBy('created_at')->first();
    $yearsActive = $firstRecord ? max(1, Carbon::now()->diffInYears($firstRecord->created_at) + 1) : 1;

    $publicLawyers = Lawyer::orderByDesc('experience_years')->limit(6)->get();
    $publicCases = LegalCase::with('lawyer')
        ->where('status', 'closed')
        ->orderByDesc('filing_date')
        ->limit(6)
        ->get();

    return view('welcome', compact(
        'totalLawyers',
        'resolvedCasesCount',
        'totalClients',
        'yearsActive',
        'publicLawyers',
        'publicCases'
    ));
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('lawyers', LawyerController::class);
    Route::resource('cases', CaseController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:lawyer'])->group(function () {
    Route::get('/my-cases', [LawyerCaseController::class, 'index'])->name('my-cases.index');
    Route::get('/my-cases/{case}', [LawyerCaseController::class, 'show'])->name('my-cases.show');
    Route::get('/available-cases', [LawyerCaseController::class, 'available'])->name('available-cases.index');
    Route::post('/cases/{case}/claim', [LawyerCaseController::class, 'claim'])->name('cases.claim');
    Route::post('/cases/{case}/release', [LawyerCaseController::class, 'release'])->name('cases.release');
});

require __DIR__.'/auth.php';
