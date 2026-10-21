<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('case_attempts', function (Blueprint $table) {
            // الحقول الجديدة
            if (!Schema::hasColumn('case_attempts', 'user_ddx')) {
                $table->text('user_ddx')->nullable()->after('diagnosis');
            }
            if (!Schema::hasColumn('case_attempts', 'correct_diagnosis_text')) {
                $table->text('correct_diagnosis_text')->nullable()->after('user_ddx');
            }
            if (!Schema::hasColumn('case_attempts', 'ai_feedback_text')) {
                $table->text('ai_feedback_text')->nullable()->after('accuracy_score');
            }
        });
    }

    public function down(): void
    {
        Schema::table('case_attempts', function (Blueprint $table) {
            $table->dropColumn(['user_ddx', 'correct_diagnosis_text', 'ai_feedback_text']);
        });
    }
};