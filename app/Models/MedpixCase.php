<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedpixCase extends Model
{
    use HasFactory;

    protected $table = 'medpix_cases';

    protected $fillable = [
        'uid',
        'module_id',        // ← مهم: أضفناه
        'split',
        'title',
        'history',
        'exam',
        'findings',
        'differential_diagnosis',
        'case_diagnosis',
        'diagnosis_by',
        'treatment_followup',
        'discussion',
        'topic_title',
        'disease_discussion',
        'acr_code',
        'category',
        'keywords',
        'reference_text',
        'patient_age',
        'patient_gender',
        'ct_images_count',
        'mri_images_count',
        'is_published',
    ];

    protected $casts = [
        'patient_age' => 'integer',
        'ct_images_count' => 'integer',
        'mri_images_count' => 'integer',
        'is_published' => 'boolean',
    ];

    // ============================================
    // العلاقات (Relationships)
    // ============================================

    /**
     * علاقة: الحالة تنتمي لموديول واحد
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    /**
     * علاقة: حالة واحدة لها صور كثيرة
     */
    public function images(): HasMany
    {
        return $this->hasMany(MedpixImage::class, 'uid', 'uid')
                    ->orderBy('display_order');
    }

    /**
     * صور CT فقط
     */
    public function ctImages(): HasMany
    {
        return $this->hasMany(MedpixImage::class, 'uid', 'uid')
                    ->where('image_type', 'CT')
                    ->orderBy('display_order');
    }

    /**
     * صور MRI فقط
     */
    public function mriImages(): HasMany
    {
        return $this->hasMany(MedpixImage::class, 'uid', 'uid')
                    ->where('image_type', 'MRI')
                    ->orderBy('display_order');
    }

    // ============================================
    // Scopes (للفلترة)
    // ============================================

    /**
     * حالات مجموعة معينة (train/dev/test)
     */
    public function scopeSplit($query, string $split)
    {
        return $query->where('split', $split);
    }

    /**
     * الحالات المنشورة فقط
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * حالات موديول معين
     */
    public function scopeForModule($query, int $moduleId)
    {
        return $query->where('module_id', $moduleId);
    }

    /**
     * فلترة حسب الجنس
     */
    public function scopeGender($query, string $gender)
    {
        return $query->where('patient_gender', $gender);
    }

    /**
     * فلترة حسب الفئة المرضية
     */
    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * بحث نصي في العنوان والتشخيص
     */
    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('case_diagnosis', 'like', "%{$term}%")
              ->orWhere('topic_title', 'like', "%{$term}%");
        });
    }

    // ============================================
    // Accessors (خصائص محسوبة)
    // ============================================

    /**
     * عدد الصور الكلي
     */
    public function getTotalImagesCountAttribute(): int
    {
        return ($this->ct_images_count ?? 0) + ($this->mri_images_count ?? 0);
    }

    /**
     * هل الحالة عندها صور؟
     */
    public function getHasImagesAttribute(): bool
    {
        return $this->total_images_count > 0;
    }

    /**
     * رابط الحالة (يُستخدم في الـ Views)
     */
    public function getRouteAttribute(): string
    {
        return route('medpix.cases.show', ['uid' => $this->uid]);
    }

    /**
     * وصف مختصر للجنس
     */
    public function getGenderLabelAttribute(): string
    {
        return match ($this->patient_gender) {
            'male' => 'Male',
            'female' => 'Female',
            default => 'Unknown',
        };
    }

    /**
     * وصف مختصر للعمر
     */
    public function getAgeLabelAttribute(): string
    {
        return $this->patient_age
            ? "{$this->patient_age} years"
            : 'Age N/A';
    }
    public function attempts()
    {
        return $this->hasMany(CaseAttempt::class, 'medpix_uid', 'uid');
    }
}
