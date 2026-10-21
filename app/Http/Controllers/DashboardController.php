<?php

namespace App\Http\Controllers;

use App\Models\CaseAttempt;
use App\Models\Module;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        // ============================================
        // Progress (مع حماية)
        // ============================================
        $progress = $user->getOrCreateProgress();

        // ضمان إنه level مش NULL
        if ($progress->level === null || $progress->level < 1) {
            $progress->level = 1;
            $progress->save();
        }

        // ============================================
        // Stats
        // ============================================
        $stats = [
            'level' => $progress->level ?? 1,
            'level_title' => $progress->level_title,
            'total_points' => $progress->total_points ?? 0,
            'xp_in_level' => $progress->xp_in_level ?? 0,
            'xp_needed' => UserProgress::xpForLevel($progress->level ?? 1),
            'level_percentage' => $progress->level_progress_percentage,
            'cases_completed' => $progress->cases_completed ?? 0,
            'cases_correct' => $progress->cases_correct ?? 0,
            'cases_incorrect' => $progress->cases_incorrect ?? 0,
            'accuracy' => $progress->accuracy,
            'streak' => $progress->streak_days ?? 0,
            'best_streak' => $progress->best_streak ?? 0,
            'xp_to_next' => $progress->xp_to_next_level,
            'pending_reviews' => CaseAttempt::where('user_id', $userId)
                ->where('is_correct', false)
                ->whereNotNull('next_review_date')
                ->where('next_review_date', '<=', now())
                ->count(),
        ];

        // ============================================
        // Latest Attempt
        // ============================================
        $latestAttempt = CaseAttempt::where('user_id', $userId)
            ->with('medpixCase')
            ->latest()
            ->first();

        // ============================================
        // Reviews
        // ============================================
        $reviews = CaseAttempt::where('user_id', $userId)
            ->where('is_correct', false)
            ->whereNotNull('next_review_date')
            ->where('next_review_date', '<=', now())
            ->with('medpixCase')
            ->orderBy('next_review_date', 'asc')
            ->limit(4)
            ->get();

        // ============================================
        // Active Modules
        // ============================================
        $modules = Module::where('is_active', true)
            ->orderBy('order')
            ->limit(6)
            ->get();

        foreach ($modules as $module) {
            $solvedCount = CaseAttempt::where('user_id', $userId)
                ->where('module_id', $module->id)
                ->whereNotNull('completed_at')
                ->count();

            $total = $module->medpixCases()->count();
            $module->solved_count = $solvedCount;
            $module->medpix_cases_count = $total;
            $module->progress_percentage = $total > 0 ? round(($solvedCount / $total) * 100) : 0;
        }

        return view('dashboard', compact(
            'user',
            'progress',
            'stats',
            'latestAttempt',
            'reviews',
            'modules'
        ));
    }
}