<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medpix_cases', function (Blueprint $table) {
            $table->id();
            
            // ===== المعرّفات =====
            $table->string('uid', 20)->unique()->index(); // MPX1009
            $table->enum('split', ['train', 'train_1', 'train_2', 'dev', 'test'])
                  ->default('train')->index();
            
            // ===== بيانات الحالة السريرية =====
            $table->string('title', 500)->nullable();
            $table->text('history')->nullable();
            $table->text('exam')->nullable();
            $table->text('findings')->nullable();
            $table->text('differential_diagnosis')->nullable();
            $table->text('case_diagnosis')->nullable();
            $table->text('diagnosis_by')->nullable();
            $table->text('treatment_followup')->nullable();
            $table->text('discussion')->nullable();
            
            // ===== معلومات الموضوع العلمي =====
            $table->string('topic_title', 500)->nullable();
            $table->text('disease_discussion')->nullable();
            $table->string('acr_code', 50)->nullable();
            $table->string('category', 200)->nullable();
            $table->string('keywords', 500)->nullable();
            $table->text('reference_text')->nullable();
            
            // ===== بيانات مستخرجة =====
            $table->integer('patient_age')->nullable();
            $table->enum('patient_gender', ['male', 'female', 'unknown'])
                  ->default('unknown');
            $table->string('location', 200)->nullable();
            $table->string('location_category', 200)->nullable();
            
            // ===== إحصائيات =====
            $table->integer('ct_images_count')->default(0);
            $table->integer('mri_images_count')->default(0);
            
            // ===== إدارة =====
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            
            // فهارس للبحث
            $table->index('category');
            $table->index('patient_gender');
            $table->index('patient_age');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medpix_cases');
    }
};