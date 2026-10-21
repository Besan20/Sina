<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Module;
use App\Models\CaseAttempt;
use App\Models\MedpixCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // ============================================
    // عرض الملف الشخصي
    // ============================================
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        // ============================================
        // 1. إحصائيات المستخدم (من case_attempts)
        // ============================================
        $totalAttempts = CaseAttempt::where('user_id', $userId)->count();
        $completedAttempts = CaseAttempt::where('user_id', $userId)->whereNotNull('completed_at')->count();
        $correctAttempts = CaseAttempt::where('user_id', $userId)->where('is_correct', true)->count();
        $incorrectAttempts = CaseAttempt::where('user_id', $userId)->where('is_correct', false)->count();
        $totalPoints = CaseAttempt::where('user_id', $userId)->sum('points_earned');
        $pendingReviews = CaseAttempt::where('user_id', $userId)
            ->where('is_correct', false)
            ->whereNotNull('next_review_date')
            ->where('next_review_date', '<=', now())
            ->count();

        // حساب المستوى
        $level = max(1, floor($totalPoints / 100) + 1);
        $levelTitles = [
            1 => 'Beginner',
            2 => 'Student',
            3 => 'Intern',
            4 => 'Resident',
            5 => 'Senior Resident',
            6 => 'Fellow',
            7 => 'Clinical Scholar',
            8 => 'Consultant',
            9 => 'Professor',
            10 => 'Expert',
        ];
        $levelTitle = $levelTitles[min($level, 10)] ?? 'Expert';

        // حساب الدقة
        $accuracy = $completedAttempts > 0
            ? round(($correctAttempts / $completedAttempts) * 100)
            : 0;

        // ============================================
        // 2. Streak (مؤقتاً - نحسبها لاحقاً بشكل دقيق)
        // ============================================
        $lastAttemptDate = CaseAttempt::where('user_id', $userId)->latest()->value('created_at');
        $streak = 0;
        $bestStreak = 0;
        if ($lastAttemptDate) {
            $daysDiff = \Carbon\Carbon::parse($lastAttemptDate)->diffInDays(now());
            $streak = $daysDiff <= 1 ? 1 : 0;
            $bestStreak = $streak;
        }

        $stats = [
            'total_cases' => $completedAttempts,
            'correct' => $correctAttempts,
            'incorrect' => $incorrectAttempts,
            'points' => $totalPoints,
            'accuracy' => $accuracy,
            'streak' => $streak,
            'best_streak' => $bestStreak,
            'pending_reviews' => $pendingReviews,
            'level' => $level,
            'level_title' => $levelTitle,
        ];

        // ============================================
        // 3. أداء الموديولات
        // ============================================
        $modules = Module::where('is_active', true)
            ->orderBy('order')
            ->get();

        $modulePerformance = [];

        foreach ($modules as $module) {
            $solved = CaseAttempt::where('user_id', $userId)
                ->where('module_id', $module->id)
                ->whereNotNull('completed_at')
                ->count();

            $total = $module->medpixCases()->count();
            $percentage = $total > 0 ? round(($solved / $total) * 100) : 0;

            $modulePerformance[] = [
                'module' => $module,
                'solved' => $solved,
                'total' => $total,
                'percentage' => $percentage,
            ];
        }

        // ترتيب حسب النسبة (الأعلى أولاً)
        usort($modulePerformance, function ($a, $b) {
            return $b['percentage'] <=> $a['percentage'];
        });

        // خذ أعلى 5 موديولات فقط
        $modulePerformance = array_slice($modulePerformance, 0, 5);

        // ============================================
        // 4. النشاط الأخير
        // ============================================
        $recentActivity = CaseAttempt::where('user_id', $userId)
            ->with('medpixCase')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ============================================
        // 5. Badges (مؤقتاً - نحسبها من الإحصائيات)
        // ============================================
        $badges = $this->getUserBadges($stats);

        return view('profile', compact(
            'user',
            'stats',
            'modulePerformance',
            'badges',
            'recentActivity'
        ));
    }

    // ============================================
    // تحديث الملف الشخصي
    // ============================================
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only(['name', 'email']));

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    // ============================================
    // حساب الشارات (Badges) من الإحصائيات
    // ============================================
    private function getUserBadges(array $stats): array
    {
        $allBadges = [
            [
                'id' => 'first_case',
                'icon' => 'school',
                'label' => 'First Case',
                'unlocked' => $stats['total_cases'] >= 1,
            ],
            [
                'id' => 'ten_cases',
                'icon' => 'menu_book',
                'label' => '10 Cases',
                'unlocked' => $stats['total_cases'] >= 10,
            ],
            [
                'id' => 'fifty_cases',
                'icon' => 'auto_stories',
                'label' => '50 Cases',
                'unlocked' => $stats['total_cases'] >= 50,
            ],
            [
                'id' => 'hundred_cases',
                'icon' => 'library_books',
                'label' => '100 Cases',
                'unlocked' => $stats['total_cases'] >= 100,
            ],
            [
                'id' => 'sharp_shooter',
                'icon' => 'my_location',
                'label' => 'Sharp Shooter',
                'unlocked' => $stats['accuracy'] >= 90 && $stats['total_cases'] >= 10,
            ],
            [
                'id' => 'expert',
                'icon' => 'workspace_premium',
                'label' => 'Expert',
                'unlocked' => $stats['accuracy'] >= 80 && $stats['total_cases'] >= 20,
            ],
            [
                'id' => 'scholar',
                'icon' => 'psychology',
                'label' => 'Scholar',
                'unlocked' => $stats['points'] >= 1000,
            ],
            [
                'id' => 'top_performer',
                'icon' => 'star',
                'label' => 'Top Performer',
                'unlocked' => $stats['points'] >= 2500,
            ],
            [
                'id' => 'streak_3',
                'icon' => 'local_fire_department',
                'label' => 'Streak 3',
                'unlocked' => $stats['streak'] >= 3,
            ],
            [
                'id' => 'streak_7',
                'icon' => 'whatshot',
                'label' => 'Streak 7',
                'unlocked' => $stats['streak'] >= 7,
            ],
            [
                'id' => 'streak_30',
                'icon' => 'bolt',
                'label' => 'Streak 30',
                'unlocked' => $stats['streak'] >= 30,
            ],
            [
                'id' => 'level_5',
                'icon' => 'military_tech',
                'label' => 'Level 5',
                'unlocked' => $stats['level'] >= 5,
            ],
        ];

        return $allBadges;
    }
}