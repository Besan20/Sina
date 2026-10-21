<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CaseAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    // ============================================
    // عرض لوحة المتصدرين
    // ============================================
    public function index()
    {
        // جلب المستخدمين مع إحصائياتهم
        $users = User::select('users.id', 'users.name', 'users.email', 'users.created_at')
            ->selectRaw('COALESCE(SUM(case_attempts.points_earned), 0) as total_points')
            ->selectRaw('COUNT(case_attempts.id) as total_attempts')
            ->selectRaw('SUM(CASE WHEN case_attempts.is_correct = 1 THEN 1 ELSE 0 END) as correct_attempts')
            ->selectRaw('COUNT(DISTINCT case_attempts.medpix_uid) as unique_cases')
            ->leftJoin('case_attempts', 'users.id', '=', 'case_attempts.user_id')
            ->groupBy('users.id', 'users.name', 'users.email', 'users.created_at')
            ->orderBy('total_points', 'desc')
            ->orderBy('correct_attempts', 'desc')
            ->limit(50)
            ->get();

        // إضافة الترتيب لكل مستخدم
        $rank = 1;
        foreach ($users as $user) {
            $user->rank = $rank++;
            $user->accuracy = $user->total_attempts > 0
                ? round(($user->correct_attempts / $user->total_attempts) * 100)
                : 0;
            $user->level = max(1, floor($user->total_points / 100) + 1);
        }

        // إحصائيات عامة
        $stats = [
            'total_students' => User::count(),
            'total_cases_solved' => CaseAttempt::whereNotNull('completed_at')->count(),
            'avg_accuracy' => round(
                CaseAttempt::whereNotNull('completed_at')
                    ->selectRaw('AVG(CASE WHEN is_correct = 1 THEN 100 ELSE 0 END) as avg_acc')
                    ->value('avg_acc') ?? 0
            ),
        ];

        // المستخدم الحالي وترتيبه
        $currentUser = Auth::user();
        $currentUserRank = null;
        $currentUserStats = null;

        if ($currentUser) {
            // احسب نقاط المستخدم الحالي
            $userPoints = CaseAttempt::where('user_id', $currentUser->id)->sum('points_earned');

            // احسب ترتيبه (كم مستخدم عنده نقاط أكثر)
            $currentUserRank = User::select('users.id')
                ->selectRaw('COALESCE(SUM(case_attempts.points_earned), 0) as total_points')
                ->leftJoin('case_attempts', 'users.id', '=', 'case_attempts.user_id')
                ->groupBy('users.id')
                ->havingRaw('COALESCE(SUM(case_attempts.points_earned), 0) > ?', [$userPoints])
                ->get()
                ->count() + 1;

            // إحصائيات المستخدم الحالي
            $userAttempts = CaseAttempt::where('user_id', $currentUser->id)->count();
            $userCorrect = CaseAttempt::where('user_id', $currentUser->id)->where('is_correct', true)->count();

            $currentUserStats = [
                'points' => $userPoints,
                'total_attempts' => $userAttempts,
                'correct_attempts' => $userCorrect,
                'accuracy' => $userAttempts > 0 ? round(($userCorrect / $userAttempts) * 100) : 0,
                'level' => max(1, floor($userPoints / 100) + 1),
            ];
        }

        return view('leaderboard', compact('users', 'stats', 'currentUserRank', 'currentUserStats'));
    }
}