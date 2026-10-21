<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'icon', 'image',
        'total_cases', 'difficulty', 'order', 'is_active'
    ];


    // حالات MedPix
    public function medpixCases()
    {
        return $this->hasMany(MedpixCase::class, 'module_id');
    }

    // محاولات المستخدمين في هذا الموديول
    public function caseAttempts()
    {
        return $this->hasMany(CaseAttempt::class, 'module_id');
    }
}
