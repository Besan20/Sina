<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'specialty',
        'role',
        'level',
        'points',
        'streak',
        'best_streak',
        'accuracy',
        'total_cases_solved',
        'correct_cases',
        'wrong_cases',
        'pending_reviews_count',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ============================================
    // إنشاء UserProgress تلقائياً عند التسجيل
    // ============================================
    protected static function booted()
    {
        static::created(function ($user) {
            UserProgress::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'total_points' => 0,
                    'level' => 1,
                    'xp_in_level' => 0,
                    'cases_completed' => 0,
                    'cases_correct' => 0,
                    'cases_incorrect' => 0,
                    'streak_days' => 0,
                    'best_streak' => 0,
                ]
            );
        });
    }

    // ============================================
    // العلاقات
    // ============================================
    public function attempts()
    {
        return $this->hasMany(CaseAttempt::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
                    ->withPivot('earned_at')
                    ->withTimestamps();
    }

    public function progress()
    {
        return $this->hasOne(UserProgress::class);
    }

    // ============================================
    // دوال مساعدة
    // ============================================
    public function getLevelTitle()
    {
        $levels = [
            1 => 'Novice',
            2 => 'Beginner',
            3 => 'Learner',
            4 => 'Intermediate',
            5 => 'Advanced',
            6 => 'Proficient',
            7 => 'Clinical Scholar',
            8 => 'Clinical Expert',
            9 => 'Master Clinician',
            10 => 'Clinical Professor',
        ];

        return $levels[$this->level] ?? 'Learner';
    }

    public function getAccuracyRate()
    {
        if ($this->total_cases_solved === 0) {
            return 0;
        }
        return round(($this->correct_cases / $this->total_cases_solved) * 100);
    }

    // ⚠️ Helper: احصل على progress أو أنشئه مع القيم الافتراضية
    public function getOrCreateProgress(): UserProgress
    {
        if ($this->progress) {
            // إذا موجود، تأكد إنه القيم صحيحة
            if ($this->progress->level === null || $this->progress->level < 1) {
                $this->progress->level = 1;
                $this->progress->save();
            }
            return $this->progress;
        }

        return UserProgress::create([
            'user_id' => $this->id,
            'total_points' => 0,
            'level' => 1,
            'xp_in_level' => 0,
            'cases_completed' => 0,
            'cases_correct' => 0,
            'cases_incorrect' => 0,
            'streak_days' => 0,
            'best_streak' => 0,
        ]);
    }
}