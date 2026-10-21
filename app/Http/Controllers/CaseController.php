<?php

namespace App\Http\Controllers;

use App\Models\MedpixCase;
use App\Models\CaseAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaseController extends Controller
{
    // ============================================
    // عرض حالة MedPix
    // ============================================
    public function showMedpix($uid)
    {
        $case = MedpixCase::where('uid', $uid)
            ->with(['module', 'images'])
            ->firstOrFail();

        $prevCase = MedpixCase::where('module_id', $case->module_id)
            ->where('id', '<', $case->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextCase = MedpixCase::where('module_id', $case->module_id)
            ->where('id', '>', $case->id)
            ->orderBy('id')
            ->first();

        return view('medpix.case', compact('case', 'prevCase', 'nextCase'));
    }

    public function submitMedpix(Request $request, $uid)
    {
        $case = MedpixCase::where('uid', $uid)->firstOrFail();

        $validated = $request->validate([
            'diagnosis' => 'nullable|string|max:1000',
            'ddx' => 'nullable|string|max:2000',
            'notes' => 'nullable|string|max:5000',
            'orders' => 'nullable|array',
            'time_taken' => 'nullable|integer|min:0',
        ]);

        $userDiagnosis = trim($validated['diagnosis'] ?? '');
        $correctDiagnosis = trim($case->case_diagnosis ?? '');

        // AI Evaluation
        $aiService = new \App\Services\AIGradingService();
        $evaluation = $aiService->evaluateDiagnosis($userDiagnosis, $correctDiagnosis, [
            'history' => $case->history ?? '',
            'findings' => $case->findings ?? '',
        ]);

        $isCorrect = $evaluation['is_correct'] ?? false;
        $aiFeedback = $evaluation['feedback'] ?? '';
        $confidence = $evaluation['confidence'] ?? 0;

        // Points
        $points = 0;
        $timeBonus = 0;
        if ($isCorrect) $points += 20;

        $timeTaken = $validated['time_taken'] ?? 0;
        $timeLimit = 120;
        if ($timeTaken > 0 && $timeTaken < $timeLimit) {
            $timeBonus = (int) round((($timeLimit - $timeTaken) / $timeLimit) * 10);
            $points += $timeBonus;
        }
        $points = max(0, $points);

        // Create Attempt
        $attempt = CaseAttempt::create([
            'user_id' => Auth::id(),
            'medpix_uid' => $case->uid,
            'module_id' => $case->module_id,
            'diagnosis' => $userDiagnosis ?: 'Not provided',
            'correct_diagnosis_text' => $correctDiagnosis,
            'orders' => $validated['orders'] ?? [],
            'notes' => $validated['notes'] ?? null,
            'time_taken' => $timeTaken,
            'is_correct' => $isCorrect,
            'points_earned' => $points,
            'accuracy_score' => $isCorrect ? 100 : 0,
            'ai_feedback_text' => $aiFeedback,
            'completed_at' => now(),
        ]);

        // Progress
        $progress = Auth::user()->getOrCreateProgress();
        $progress->addPoints($points);
        $progress->increment('cases_completed');
        if ($isCorrect) $progress->increment('cases_correct');
        else $progress->increment('cases_incorrect');
        if ($timeTaken > 0) $progress->increment('total_time_spent', $timeTaken);
        $progress->updateStreak();
        $progress->refresh();

        // Redirect to result page
        return redirect()->route('medpix.cases.result', ['attempt' => $attempt->id]);
    }

    public function showResult($attemptId)
    {
        $attempt = CaseAttempt::where('user_id', Auth::id())
            ->with(['medpixCase', 'medpixCase.module', 'medpixCase.images'])
            ->findOrFail($attemptId);

        $case = $attempt->medpixCase;

        $prevCase = MedpixCase::where('module_id', $case->module_id)
            ->where('id', '<', $case->id)->orderBy('id', 'desc')->first();
        $nextCase = MedpixCase::where('module_id', $case->module_id)
            ->where('id', '>', $case->id)->orderBy('id')->first();

        $progress = Auth::user()->getOrCreateProgress();

        return view('medpix.result', compact('attempt', 'case', 'prevCase', 'nextCase', 'progress'));
    }

    public function random()
    {
        $case = MedpixCase::inRandomOrder()->first();

        if (!$case) {
            return redirect()->route('modules.index')
                ->with('error', 'No cases available.');
        }

        return redirect()->route('medpix.cases.show', ['uid' => $case->uid]);
    }

    public function reviews()
    {
        $reviews = CaseAttempt::where('user_id', Auth::id())
            ->where('is_correct', false)
            ->whereNotNull('next_review_date')
            ->where('next_review_date', '<=', now())
            ->with('medpixCase')
            ->orderBy('next_review_date', 'asc')
            ->get();

        return view('reviews', compact('reviews'));
    }

    public function reviewCase($attemptId)
    {
        $attempt = CaseAttempt::where('id', $attemptId)
            ->where('user_id', Auth::id())
            ->with(['medpixCase', 'medpixCase.images', 'medpixCase.module'])
            ->firstOrFail();

        return view('reviews.show', compact('attempt'));
    }
}