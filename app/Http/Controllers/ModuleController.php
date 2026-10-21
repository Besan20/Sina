<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\MedpixCase;
use App\Models\CaseAttempt;

class ModuleController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // جلب الموديولات مع عدد الحالات
        $modules = Module::where('is_active', true)
            ->withCount('medpixCases')
            ->orderBy('order')
            ->get();

        // إضافة progress لكل موديول
        foreach ($modules as $module) {
            // عدد الحالات المحلولة في هذا الموديول
            $solvedCount = CaseAttempt::where('user_id', $userId)
                ->where('module_id', $module->id)
                ->count();

            // إجمالي الحالات
            $total = $module->medpix_cases_count;
            $percentage = $total > 0 ? round(($solvedCount / $total) * 100) : 0;

            // خصائص إضافية
            $module->solved_count = $solvedCount;
            $module->progress_percentage = $percentage;
            $module->status = $percentage >= 100 ? 'completed' : ($percentage > 0 ? 'in-progress' : 'not-started');
        }

        // إحصائيات عامة
        $totalModules = $modules->count();
        $completedModules = $modules->where('status', 'completed')->count();
        $inProgressModules = $modules->where('status', 'in-progress')->count();

        // نسبة التقدم الإجمالية
        $totalCases = $modules->sum('medpix_cases_count');
        $totalSolved = CaseAttempt::where('user_id', $userId)->count();
        $overallProgress = $totalCases > 0 ? round(($totalSolved / $totalCases) * 100) : 0;

        $stats = [
            'total' => $totalModules,
            'completed' => $completedModules,
            'in_progress' => $inProgressModules,
            'progress' => $overallProgress,
        ];

        return view('modules', compact('modules', 'stats'));
    }

    public function show($slug)
    {
        $module = Module::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $userId = auth()->id();

        // جلب محاولات المستخدم في هذا الموديول
        $userAttempts = CaseAttempt::where('user_id', $userId)
            ->where('module_id', $module->id)
            ->get()
            ->keyBy('medpix_uid');

        // جلب الحالات
        $cases = MedpixCase::where('module_id', $module->id)
            ->with('images')
            ->paginate(12);

        // إضافة userAttempt لكل حالة
        foreach ($cases as $case) {
            $case->userAttempt = $userAttempts->get($case->uid);
        }

        // إحصائيات الموديول
        $totalCases = $module->medpixCases()->count();
        $completedCases = $userAttempts->where('is_correct', true)->count();
        $inProgressCases = $userAttempts->where('is_correct', false)->count();
        $notStartedCases = $totalCases - $userAttempts->count();

        $stats = [
            'total' => $totalCases,
            'completed' => $completedCases,
            'in_progress' => $inProgressCases,
            'not_started' => $notStartedCases,
            'progress' => $totalCases > 0 ? round(($completedCases / $totalCases) * 100) : 0,
        ];

        return view('module', compact('module', 'cases', 'stats'));
    }

    public function randomCase($slug)
    {
        $module = Module::where('slug', $slug)->firstOrFail();

        $case = MedpixCase::where('module_id', $module->id)
            ->inRandomOrder()
            ->first();

        if (!$case) {
            return redirect()->route('modules.show', $slug)
                ->with('error', 'No cases available in this module.');
        }

        return redirect()->route('medpix.cases.show', ['uid' => $case->uid]);
    }
}