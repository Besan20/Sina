<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // SINA specific fields
            $table->enum('role', ['student', 'admin'])->default('student');
            $table->enum('specialty', [
                'medical_student', 
                'intern', 
                'resident', 
                'dentistry_student', 
                'pharmacy_student', 
                'other'
            ])->nullable();
            $table->integer('level')->default(1);
            $table->integer('points')->default(0);
            $table->integer('streak')->default(0);
            $table->integer('best_streak')->default(0);
            $table->integer('accuracy')->default(0);
            $table->integer('total_cases_solved')->default(0);
            $table->integer('correct_cases')->default(0);
            $table->integer('wrong_cases')->default(0);
            $table->integer('pending_reviews_count')->default(0);
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};