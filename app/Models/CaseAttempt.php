<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'medpix_uid',
        'module_id',
        'diagnosis',
        'user_ddx',
        'correct_diagnosis_text',
        'differential_diagnosis',
        'treatment_plan',
        'orders',
        'investigations_ordered',
        'investigations_feedback',
        'notes',
        'time_taken',
        'is_correct',
        'points_earned',
        'accuracy_score',
        'ai_feedback',
        'ai_feedback_text',
        'ai_analysis',
        'next_review_date',
        'review_count',
        'completed_at',
    ];

    protected $casts = [
        'orders' => 'array',
        'investigations_ordered' => 'array',
        'investigations_feedback' => 'array',
        'ai_analysis' => 'array',
        'next_review_date' => 'datetime',
        'completed_at' => 'datetime',
        'is_correct' => 'boolean',
    ];

    // ============================================
    // العلاقات
    // ============================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medpixCase()
    {
        return $this->belongsTo(MedpixCase::class, 'medpix_uid', 'uid');
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    // ============================================
    // Scopes
    // ============================================

    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completed_at');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeCorrect($query)
    {
        return $query->where('is_correct', true);
    }

    // ============================================
    // Accessors
    // ============================================

    public function getIsCompletedAttribute(): bool
    {
        return $this->completed_at !== null;
    }

    public function getScorePercentageAttribute(): float
    {
        if (!$this->is_correct) {
            return 0;
        }
        return min(100, $this->accuracy_score);
    }

    // ============================================
    // Complete Method
    // ============================================
    public function complete(array $data = []): array
    {
        // 1. حفظ بيانات المحاولة
        $this->fill(array_merge($data, [
            'completed_at' => now(),
        ]));
        $this->save();

        // 2. إضافة النقاط للمستخدم
        $progress = $this->user->getOrCreateProgress();
        $result = $progress->addPoints($this->points_earned);

        // 3. تحديث الإحصائيات
        $progress->increment('cases_completed');

        if ($this->is_correct) {
            $progress->increment('cases_correct');
        } else {
            $progress->increment('cases_incorrect');
        }

        // 4. تحديث Streak
        $progress->updateStreak();

        // 5. تحديث الوقت
        if ($this->time_taken > 0) {
            $progress->increment('total_time_spent', $this->time_taken);
        }

        return [
            'level_up' => $result['leveled_up'],
            'old_level' => $result['old_level'] ?? null,
            'new_level' => $result['new_level'] ?? null,
            'total_points' => $result['total_points'] ?? $this->points_earned,
            'level_title' => $progress->level_title,
        ];
    }
}