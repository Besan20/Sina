<?php

namespace App\View\Components;

use App\Models\UserProgress;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class XpBar extends Component
{
    public $progress;
    public $level;
    public $levelTitle;
    public $xpInLevel;
    public $xpNeeded;
    public $percentage;
    public $streak;
    public $totalPoints;

    public function __construct()
    {
        $user = Auth::user();

        if ($user) {
            $this->progress = $user->getOrCreateProgress();
            $this->level = $this->progress->level;
            $this->levelTitle = $this->progress->level_title;
            $this->xpInLevel = $this->progress->xp_in_level;
            $this->xpNeeded = UserProgress::xpForLevel($this->progress->level);
            $this->percentage = $this->progress->level_progress_percentage;
            $this->streak = $this->progress->streak_days;
            $this->totalPoints = $this->progress->total_points;
        } else {
            $this->level = 1;
            $this->levelTitle = 'Beginner';
            $this->xpInLevel = 0;
            $this->xpNeeded = 100;
            $this->percentage = 0;
            $this->streak = 0;
            $this->totalPoints = 0;
        }
    }

    public function render()
    {
        return view('components.xp-bar');
    }
}