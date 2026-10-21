<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('medpix_uid', 50)->index();
            $table->foreignId('module_id')->nullable()->constrained('modules')->nullOnDelete();
            $table->text('diagnosis')->nullable();
            $table->text('differential_diagnosis')->nullable();
            $table->text('treatment_plan')->nullable();
            $table->json('orders')->nullable();
            $table->json('investigations_ordered')->nullable();
            $table->json('investigations_feedback')->nullable();
            $table->text('notes')->nullable();
            $table->integer('time_taken')->default(0);
            $table->boolean('is_correct')->default(false);
            $table->integer('points_earned')->default(0);
            $table->integer('accuracy_score')->default(0);
            $table->text('ai_feedback')->nullable();
            $table->json('ai_analysis')->nullable();
            $table->timestamp('next_review_date')->nullable();
            $table->integer('review_count')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_attempts');
    }
};