<?php

namespace App\Http\Controllers;

use App\Models\CaseAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    // ============================================
    // عرض جميع الحالات التي تم حلها
    // ============================================
    public function index()
    {
        $userId = Auth::id();

        // جلب جميع محاولات المستخدم
        $attempts = CaseAttempt::where('user_id', $userId)
            ->with(['medpixCase', 'module'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // الإحصائيات
        $stats = [
            'total' => CaseAttempt::where('user_id', $userId)->count(),
            'correct' => CaseAttempt::where('user_id', $userId)->where('is_correct', true)->count(),
            'incorrect' => CaseAttempt::where('user_id', $userId)->where('is_correct', false)->count(),
            'needs_review' => CaseAttempt::where('user_id', $userId)
                ->where('is_correct', false)
                ->whereNotNull('next_review_date')
                ->where('next_review_date', '<=', now())
                ->count(),
        ];

        return view('history', compact('attempts', 'stats'));
    }

    // ============================================
    // عرض تفاصيل محاولة معينة
    // ============================================
    public function show($id)
    {
        $attempt = CaseAttempt::where('user_id', Auth::id())
            ->with(['medpixCase', 'medpixCase.images', 'medpixCase.module', 'module'])
            ->findOrFail($id);

        return view('history-detail', compact('attempt'));
    }
}