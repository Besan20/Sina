<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

            // النقاط والمستويات
            $table->integer('total_points')->default(0);
            $table->integer('level')->default(1);
            $table->integer('xp_in_level')->default(0);

            // الحالات
            $table->integer('cases_completed')->default(0);
            $table->integer('cases_correct')->default(0);
            $table->integer('cases_incorrect')->default(0);

            // Streak
            $table->integer('streak_days')->default(0);
            $table->integer('best_streak')->default(0);
            $table->date('last_activity_date')->nullable();

            // إحصائيات إضافية
            $table->integer('total_time_spent')->default(0); // بالثواني
            $table->integer('reviews_completed')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_progress');
    }
};