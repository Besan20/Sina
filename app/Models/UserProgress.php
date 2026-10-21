<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    protected $table = 'user_progress';

    protected $fillable = [
        'user_id',
        'total_points',
        'level',
        'xp_in_level',
        'cases_completed',
        'cases_correct',
        'cases_incorrect',
        'streak_days',
        'best_streak',
        'last_activity_date',
        'total_time_spent',
        'reviews_completed',
    ];

    protected $casts = [
        'last_activity_date' => 'date',
        'total_points' => 'integer',
        'level' => 'integer',
        'xp_in_level' => 'integer',
        'cases_completed' => 'integer',
        'cases_correct' => 'integer',
        'cases_incorrect' => 'integer',
        'streak_days' => 'integer',
        'best_streak' => 'integer',
    ];

    // ============================================
    // إنشاء UserProgress مع القيم الافتراضية
    // ============================================
    protected static function booted()
    {
        static::creating(function ($progress) {
            // ضمان القيم الافتراضية
            $progress->total_points = $progress->total_points ?? 0;
            $progress->level = $progress->level ?? 1;
            $progress->xp_in_level = $progress->xp_in_level ?? 0;
            $progress->cases_completed = $progress->cases_completed ?? 0;
            $progress->cases_correct = $progress->cases_correct ?? 0;
            $progress->cases_incorrect = $progress->cases_incorrect ?? 0;
            $progress->streak_days = $progress->streak_days ?? 0;
            $progress->best_streak = $progress->best_streak ?? 0;
        });
    }

    // ============================================
    // العلاقات
    // ============================================
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ============================================
    // دوال المستويات
    // ============================================

    /**
     * الـ XP المطلوب للمستوى التالي
     * ⚠️ مع حماية ضد NULL
     */
    public static function xpForLevel($level): int
    {
        $level = max(1, (int) ($level ?? 1));
        return 100 * $level;
    }

    /**
     * إضافة نقاط للمستخدم
     */
    public function addPoints(int $points): array
    {
        // ضمان إنه القيم مش NULL
        $this->total_points = ($this->total_points ?? 0) + $points;
        $this->xp_in_level = ($this->xp_in_level ?? 0) + $points;
        $this->level = $this->level ?? 1;

        if ($points <= 0) {
            $this->save();
            return ['leveled_up' => false, 'new_level' => $this->level];
        }

        $leveledUp = false;
        $oldLevel = $this->level;

        // التحقق من Level Up (ممكن يرتفع أكثر من مستوى)
        while ($this->xp_in_level >= self::xpForLevel($this->level)) {
            $this->xp_in_level -= self::xpForLevel($this->level);
            $this->level++;
            $leveledUp = true;
        }

        $this->save();

        return [
            'leveled_up' => $leveledUp,
            'old_level' => $oldLevel,
            'new_level' => $this->level,
            'points_added' => $points,
            'total_points' => $this->total_points,
        ];
    }

    /**
     * إضافة XP بدون level up check
     */
    public function addXpOnly(int $points): void
    {
        $this->increment('total_points', $points);
        $this->increment('xp_in_level', $points);

        $this->refresh();
        $this->level = $this->level ?? 1;

        while ($this->xp_in_level >= self::xpForLevel($this->level)) {
            $this->decrement('xp_in_level', self::xpForLevel($this->level));
            $this->increment('level');
            $this->refresh();
        }
    }

    // ============================================
    // Streak
    // ============================================

    public function updateStreak(): void
    {
        $today = Carbon::today();
        $this->streak_days = $this->streak_days ?? 0;
        $this->best_streak = $this->best_streak ?? 0;

        if (!$this->last_activity_date) {
            $this->streak_days = 1;
            $this->last_activity_date = $today;
        } else {
            $lastDate = Carbon::parse($this->last_activity_date);
            $daysDiff = $lastDate->diffInDays($today);

            if ($daysDiff === 0) {
                return;
            } elseif ($daysDiff === 1) {
                $this->streak_days++;
                $this->last_activity_date = $today;
            } else {
                $this->streak_days = 1;
                $this->last_activity_date = $today;
            }
        }

        if ($this->streak_days > $this->best_streak) {
            $this->best_streak = $this->streak_days;
        }

        $this->save();
    }

    // ============================================
    // Accessors (مع حماية)
    // ============================================

    public function getLevelProgressPercentageAttribute(): float
    {
        $level = $this->level ?? 1;
        $xpNeeded = self::xpForLevel($level);
        if ($xpNeeded === 0) return 0;
        $xp = $this->xp_in_level ?? 0;
        return round(($xp / $xpNeeded) * 100, 1);
    }

    public function getXpToNextLevelAttribute(): int
    {
        $level = $this->level ?? 1;
        $xp = $this->xp_in_level ?? 0;
        return max(0, self::xpForLevel($level) - $xp);
    }

    public function getLevelTitleAttribute(): string
    {
        $titles = [
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

        $level = $this->level ?? 1;
        return $titles[min($level, 10)] ?? 'Expert';
    }

    public function getAccuracyAttribute(): float
    {
        $completed = $this->cases_completed ?? 0;
        if ($completed === 0) return 0;
        $correct = $this->cases_correct ?? 0;
        return round(($correct / $completed) * 100, 1);
    }

    // ============================================
    // Scopes
    // ============================================
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}