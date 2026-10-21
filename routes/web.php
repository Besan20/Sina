<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ============================================
// PUBLIC ROUTES
// ============================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ============================================
// AUTH ROUTES
// ============================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================
// PROTECTED ROUTES
// ============================================
Route::middleware(['auth'])->group(function () {

    // 1. DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. MODULES
    Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
    Route::get('/modules/{slug}', [ModuleController::class, 'show'])->name('modules.show');
    Route::get('/modules/{slug}/random', [ModuleController::class, 'randomCase'])->name('modules.random');

    // 3. MEDPIX CASES
    Route::get('/medpix/cases/{uid}', [CaseController::class, 'showMedpix'])->name('medpix.cases.show');
    Route::post('/medpix/cases/{uid}/submit', [CaseController::class, 'submitMedpix'])->name('medpix.cases.submit');
    Route::get('/medpix/result/{attempt}', [CaseController::class, 'showResult'])->name('medpix.cases.result');

    // 4. RANDOM CASE
    Route::get('/random-case', [CaseController::class, 'random'])->name('random.case');

    // 5. PROFILE
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // 6. HISTORY
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('/history/{attempt}', [HistoryController::class, 'show'])->name('history.show');

    // 7. LEADERBOARD
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

    // 8. SPACED REPETITION
    Route::get('/reviews', [CaseController::class, 'reviews'])->name('reviews.index');
    Route::get('/reviews/{attempt}', [CaseController::class, 'reviewCase'])->name('reviews.show');
});