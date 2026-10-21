<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Database\Seeder;

class UserProgressSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        $created = 0;
        foreach ($users as $user) {
            $progress = UserProgress::firstOrCreate(
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

            if ($progress->wasRecentlyCreated) {
                $created++;
            }
        }

        $this->command->info("✅ Created progress for {$created} users");
    }
}