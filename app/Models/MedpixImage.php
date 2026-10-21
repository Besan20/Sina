<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedpixImage extends Model
{
    use HasFactory;

    protected $table = 'medpix_images';

    protected $fillable = [
        'uid', 'image_name', 'image_type', 'image_path',
        'caption', 'modality', 'plane',
        'location', 'location_category', 'acr_codes',
        'display_order',
    ];

    public function case(): BelongsTo
    {
        return $this->belongsTo(MedpixCase::class, 'uid', 'uid');
    }
}