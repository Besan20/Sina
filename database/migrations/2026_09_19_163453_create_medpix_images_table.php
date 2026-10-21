<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medpix_images', function (Blueprint $table) {
            $table->id();
            
            $table->string('uid', 20)->index();       // MPX1009
            $table->string('image_name', 100)->index(); // MPX1009_synpic46283
            $table->string('image_type', 20)->default('Other');
            
            // مسار الصورة الفعلي (إذا كانت موجودة في storage)
            $table->string('image_path', 500)->nullable();
            
            // بيانات من Descriptions.json
            $table->text('caption')->nullable();
            $table->string('modality', 100)->nullable();  // "CT - noncontrast"
            $table->string('plane', 50)->nullable();      // "Axial", "Coronal"
            $table->string('location', 200)->nullable();
            $table->string('location_category', 200)->nullable();
            $table->string('acr_codes', 50)->nullable();
            
            // ترتيب العرض
            $table->integer('display_order')->default(0);
            
            $table->timestamps();
            
            // فهرس مركب للبحث السريع
            $table->index(['uid', 'image_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medpix_images');
    }
};