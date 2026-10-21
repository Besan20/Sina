    {{-- resources/views/dashboard.blade.php --}}
    <!DOCTYPE html>
    <html class="light" dir="ltr" lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title>SINA - Dashboard</title>

        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

        <style>
            .dashboard {
                margin-top: 64px;
                padding: 32px 0 64px;
                min-height: calc(100vh - 64px);
                background: var(--color-bg-light);
                transition: background 0.3s;
            }
            .dark .dashboard { background: var(--color-primary-navy); }

            .dashboard__welcome {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                flex-wrap: wrap;
                gap: 16px;
                margin-bottom: 32px;
            }

            .dashboard__greeting h1 {
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 4px;
                display: flex;
                align-items: center;
                gap: 10px;
            }
            .dashboard__greeting h1 .material-symbols-outlined {
                font-size: 2rem;
                color: var(--color-primary-teal);
            }
            .dashboard__greeting p {
                color: var(--color-text-secondary);
                font-size: 1rem;
            }
            .dark .dashboard__greeting p { color: rgba(255, 255, 255, 0.6); }

            .dashboard__badge {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 8px 20px;
                background: linear-gradient(135deg, var(--color-primary-teal), var(--color-brand-green));
                border-radius: var(--radius-full);
                color: #fff;
                font-weight: 600;
                font-size: 0.85rem;
                box-shadow: var(--shadow-glow-teal);
                transition: transform 0.3s ease;
            }
            .dashboard__badge:hover { transform: scale(1.05); }
            .dashboard__badge .material-symbols-outlined { font-size: 1.2rem; }

            .dashboard__stats {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
                margin-bottom: 32px;
            }

            .stat-card {
                background: var(--color-white);
                border-radius: var(--radius-xl);
                padding: 20px 24px;
                border: 1px solid rgba(0, 0, 0, 0.04);
                box-shadow: var(--shadow-ambient-low);
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                gap: 16px;
            }
            .dark .stat-card {
                background: rgba(10, 22, 40, 0.4);
                border-color: rgba(255, 255, 255, 0.04);
            }
            .stat-card:hover {
                transform: translateY(-4px);
                box-shadow: var(--shadow-card-hover);
            }

            .stat-card__icon {
                width: 52px;
                height: 52px;
                border-radius: var(--radius-lg);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 26px;
                flex-shrink: 0;
            }
            .stat-card__icon--teal { background: rgba(0, 180, 216, 0.12); color: var(--color-primary-teal); }
            .stat-card__icon--green { background: rgba(46, 204, 113, 0.12); color: var(--color-brand-green); }
            .stat-card__icon--purple { background: rgba(108, 92, 231, 0.12); color: var(--color-brand-purple); }
            .stat-card__icon--orange { background: rgba(253, 203, 110, 0.15); color: #e67e22; }
            .stat-card__icon--pink { background: rgba(253, 121, 168, 0.12); color: var(--color-brand-pink); }

            .stat-card__info h3 { font-size: 1.75rem; font-weight: 800; line-height: 1.2; }
            .stat-card__info p {
                font-size: 0.85rem;
                color: var(--color-text-secondary);
                margin: 0;
            }
            .dark .stat-card__info p { color: rgba(255, 255, 255, 0.5); }

            .dashboard__grid {
                display: grid;
                grid-template-columns: 1fr;
                gap: 24px;
            }
            @media (min-width: 1024px) {
                .dashboard__grid { grid-template-columns: 2fr 1fr; }
            }

            .dash-card {
                background: var(--color-white);
                border-radius: var(--radius-xl);
                padding: 24px;
                border: 1px solid rgba(0, 0, 0, 0.04);
                box-shadow: var(--shadow-ambient-low);
                transition: all 0.3s ease;
            }
            .dark .dash-card {
                background: rgba(10, 22, 40, 0.4);
                border-color: rgba(255, 255, 255, 0.04);
            }
            .dash-card:hover { box-shadow: var(--shadow-card-hover); }

            .dash-card__header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 16px;
            }

            .dash-card__title {
                font-size: 1.1rem;
                font-weight: 700;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .dash-card__title .material-symbols-outlined {
                font-size: 1.3rem;
                color: var(--color-primary-teal);
            }

            .dash-card__link {
                color: var(--color-primary-teal);
                font-size: 0.85rem;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 4px;
                transition: gap 0.3s;
                text-decoration: none;
            }
            .dash-card__link:hover { gap: 8px; }

            .latest-case {
                display: flex;
                gap: 16px;
                padding: 16px;
                background: rgba(0, 180, 216, 0.04);
                border-radius: var(--radius-lg);
                border-left: 4px solid var(--color-primary-teal);
                transition: all 0.3s ease;
                cursor: pointer;
            }
            .latest-case:hover {
                background: rgba(0, 180, 216, 0.08);
                transform: translateX(4px);
            }

            .latest-case__badge {
                flex-shrink: 0;
                padding: 4px 12px;
                background: var(--color-primary-teal);
                color: #fff;
                border-radius: var(--radius-full);
                font-size: 0.7rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.04em;
                height: fit-content;
            }

            .latest-case__content h4 { font-weight: 700; margin-bottom: 2px; }
            .latest-case__content p {
                font-size: 0.9rem;
                color: var(--color-text-secondary);
                margin: 0;
            }
            .dark .latest-case__content p { color: rgba(255, 255, 255, 0.5); }

            .latest-case__meta {
                display: flex;
                gap: 16px;
                margin-top: 6px;
                font-size: 0.8rem;
                color: var(--color-text-muted);
            }
            .dark .latest-case__meta { color: rgba(255, 255, 255, 0.3); }

            .review-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px 0;
                border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            }
            .dark .review-item { border-bottom-color: rgba(255, 255, 255, 0.04); }
            .review-item:last-child { border-bottom: none; }

            .review-item__info h4 { font-weight: 600; font-size: 0.95rem; }
            .review-item__info p {
                font-size: 0.8rem;
                color: var(--color-text-secondary);
                margin: 0;
            }
            .dark .review-item__info p { color: rgba(255, 255, 255, 0.4); }

            .review-item__tag {
                padding: 4px 14px;
                border-radius: var(--radius-full);
                font-size: 0.7rem;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 4px;
            }
            .review-item__tag .material-symbols-outlined { font-size: 0.9rem; }
            .review-item__tag--urgent { background: rgba(253, 121, 168, 0.15); color: var(--color-brand-pink); }
            .review-item__tag--soon { background: rgba(253, 203, 110, 0.15); color: #e67e22; }
            .review-item__tag--later { background: rgba(0, 180, 216, 0.12); color: var(--color-primary-teal); }

            .module-chip {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 10px 18px;
                background: rgba(0, 0, 0, 0.03);
                border-radius: var(--radius-full);
                border: 1px solid rgba(0, 0, 0, 0.06);
                font-weight: 600;
                font-size: 0.85rem;
                transition: all 0.3s ease;
                cursor: pointer;
                color: var(--color-text-primary);
                text-decoration: none;
            }
            .dark .module-chip {
                background: rgba(255, 255, 255, 0.04);
                border-color: rgba(255, 255, 255, 0.06);
                color: var(--color-text-white);
            }
            .module-chip:hover {
                background: var(--color-primary-teal);
                color: #fff;
                border-color: var(--color-primary-teal);
                transform: translateY(-2px);
                box-shadow: var(--shadow-glow-teal);
            }
            .module-chip .material-symbols-outlined { font-size: 1.2rem; }

            .module-chip__progress {
                font-size: 0.7rem;
                color: var(--color-text-muted);
                font-weight: 400;
            }
            .dark .module-chip__progress { color: rgba(255, 255, 255, 0.3); }
            .module-chip:hover .module-chip__progress { color: rgba(255, 255, 255, 0.7); }

            .dashboard__modules {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 8px;
            }

            .motivation {
                background: linear-gradient(135deg, rgba(0, 180, 216, 0.08), rgba(46, 204, 113, 0.08));
                border-radius: var(--radius-xl);
                padding: 18px 24px;
                border: 1px solid rgba(0, 180, 216, 0.1);
                display: flex;
                align-items: center;
                gap: 16px;
                margin-bottom: 24px;
            }
            .dark .motivation {
                background: linear-gradient(135deg, rgba(0, 180, 216, 0.05), rgba(46, 204, 113, 0.05));
                border-color: rgba(0, 180, 216, 0.06);
            }

            .motivation__icon {
                font-size: 2rem;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 48px;
                height: 48px;
                background: rgba(0, 180, 216, 0.1);
                border-radius: var(--radius-lg);
                color: var(--color-primary-teal);
            }
            .motivation__icon .material-symbols-outlined { font-size: 2rem; }

            .motivation__content p { margin: 0; font-weight: 600; font-size: 1rem; }
            .motivation__content small {
                color: var(--color-text-secondary);
                font-size: 0.85rem;
            }
            .dark .motivation__content small { color: rgba(255, 255, 255, 0.4); }

            .quick-actions {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }
            .quick-actions .btn {
                width: 100%;
                justify-content: center;
                padding: 14px;
                font-size: 0.95rem;
            }

            .btn--choose-module {
                background: linear-gradient(135deg, var(--color-brand-purple), var(--color-brand-pink)) !important;
                color: #fff !important;
                border: none !important;
            }
            .btn--choose-module:hover {
                transform: scale(1.02);
                box-shadow: 0 8px 32px rgba(108, 92, 231, 0.3);
            }

            @media (max-width: 640px) {
                .dashboard__welcome { flex-direction: column; }
                .dashboard__stats { grid-template-columns: 1fr 1fr; gap: 12px; }
                .stat-card {
                    padding: 16px;
                    flex-direction: column;
                    text-align: center;
                    gap: 8px;
                }
                .stat-card__icon { width: 44px; height: 44px; font-size: 20px; }
                .stat-card__info h3 { font-size: 1.5rem; }
                .dash-card { padding: 16px; }
                .latest-case { flex-direction: column; align-items: flex-start; }
                .motivation { flex-direction: column; text-align: center; }
                .dashboard__greeting h1 { font-size: 1.5rem; }
            }
            @media (max-width: 400px) {
                .dashboard__stats { grid-template-columns: 1fr; }
            }
        </style>
    </head>
    <body>

        {{-- HEADER --}}
        <header class="header" id="header">
            <div class="container header__container">
                <a href="{{ route('dashboard') }}" class="header__logo">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="SINA Logo" class="header__logo-img header__logo-img--light">
                    <img src="{{ asset('assets/img/logo1.png') }}" alt="SINA Logo" class="header__logo-img header__logo-img--dark">
                    <span class="header__logo-text">SINA</span>
                </a>

                <nav class="header__nav">
                    <ul class="header__nav-list">
                        <li><a href="{{ route('dashboard') }}" class="header__nav-link" style="color: var(--color-primary-teal);">Dashboard</a></li>
                        <li><a href="{{ route('modules.index') }}" class="header__nav-link">Modules</a></li>
                        <li><a href="{{ route('history.index') }}" class="header__nav-link">My History</a></li>
                        <li><a href="{{ route('leaderboard.index') }}" class="header__nav-link">Leaderboard</a></li>
                    </ul>
                </nav>

                <div class="header__actions">
                    <button class="header__theme-btn" id="themeToggle">
                        <span class="material-symbols-outlined">dark_mode</span>
                    </button>
                    <a href="{{ route('profile') }}" class="header__nav-link" style="display: flex; align-items: center; gap: 6px;">
                        <span class="material-symbols-outlined" style="font-size: 1.4rem;">account_circle</span>
                        <span style="font-weight: 600; font-size: 0.85rem;">Dr. {{ Auth::user()->name }}</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline; margin-left: 4px;">
                        @csrf
                        <button type="submit" class="btn--logout">
                            <span class="material-symbols-outlined">logout</span>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>

                <button class="header__menu-btn" id="mobileMenuToggle" aria-label="Toggle menu">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
        </header>

        {{-- DASHBOARD MAIN --}}
        <main class="dashboard">
            <div class="container">

                @php
                    $userId = Auth::id();

                    // إحصائيات المستخدم
                    $totalAttempts = \App\Models\CaseAttempt::where('user_id', $userId)->count();
                    $completedAttempts = \App\Models\CaseAttempt::where('user_id', $userId)->whereNotNull('completed_at')->count();
                    $correctAttempts = \App\Models\CaseAttempt::where('user_id', $userId)->where('is_correct', true)->count();
                    $totalPoints = \App\Models\CaseAttempt::where('user_id', $userId)->sum('points_earned');
                    $accuracy = $completedAttempts > 0 ? round(($correctAttempts / $completedAttempts) * 100) : 0;

                    // المستوى (بناءً على النقاط: كل 100 نقطة = مستوى)
                    $level = max(1, floor($totalPoints / 100) + 1);
                    $xpInLevel = $totalPoints % 100;
                    $xpNeeded = 100;

                    // عنوان المستوى
                    $levelTitles = [
                        1 => 'Beginner',
                        2 => 'Student',
                        3 => 'Intern',
                        4 => 'Resident',
                        5 => 'Senior Resident',
                        6 => 'Fellow',
                        7 => 'Specialist',
                        8 => 'Consultant',
                        9 => 'Professor',
                        10 => 'Expert',
                    ];
                    $levelTitle = $levelTitles[min($level, 10)] ?? 'Expert';

                    // Streak (نحسبها من created_at)
                    $lastAttemptDate = \App\Models\CaseAttempt::where('user_id', $userId)
                        ->latest()
                        ->value('created_at');
                    $streak = 0;
                    if ($lastAttemptDate) {
                        $daysDiff = \Carbon\Carbon::parse($lastAttemptDate)->diffInDays(now());
                        $streak = $daysDiff <= 1 ? 1 : 0; // مؤقتاً
                    }

                    // Pending Reviews
                    $pendingReviews = \App\Models\CaseAttempt::where('user_id', $userId)
                        ->where('is_correct', false)
                        ->whereNotNull('next_review_date')
                        ->where('next_review_date', '<=', now())
                        ->count();
                @endphp

                {{-- WELCOME --}}
                <div class="dashboard__welcome">
                    <div class="dashboard__greeting">
                        <h1>
                            <span class="material-symbols-outlined">handshake</span>
                            Welcome back, {{ Auth::user()->name }}
                        </h1>
                        <p>You're making great progress. Let's continue your clinical journey.</p>
                    </div>
                    <div class="dashboard__badge">
                        <span class="material-symbols-outlined">stars</span>
                        Level {{ $level }} · {{ $levelTitle }}
                    </div>
                </div>

                {{-- MOTIVATION --}}
                @php
                    $nextLevel = $level + 1;
                    $pointsNeeded = $xpNeeded - $xpInLevel;
                @endphp
                <div class="motivation">
                    <div class="motivation__icon">
                        <span class="material-symbols-outlined">track_changes</span>
                    </div>
                    <div class="motivation__content">
                        <p>You're only <strong>{{ $pointsNeeded }} points away</strong> from Level {{ $nextLevel }}!</p>
                        <small>Keep solving cases to reach the next level</small>
                    </div>
                </div>

                {{-- QUICK STATS --}}
                <div class="dashboard__stats">

                    <div class="stat-card">
                        <div class="stat-card__icon stat-card__icon--teal">
                            <span class="material-symbols-outlined">assignment</span>
                        </div>
                        <div class="stat-card__info">
                            <h3>{{ $completedAttempts }}</h3>
                            <p>Cases Solved</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card__icon stat-card__icon--green">
                            <span class="material-symbols-outlined">stars</span>
                        </div>
                        <div class="stat-card__info">
                            <h3>{{ number_format($totalPoints) }}</h3>
                            <p>Total Points</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card__icon stat-card__icon--purple">
                            <span class="material-symbols-outlined">trending_up</span>
                        </div>
                        <div class="stat-card__info">
                            <h3>{{ $accuracy }}%</h3>
                            <p>Accuracy Rate</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card__icon stat-card__icon--orange">
                            <span class="material-symbols-outlined">local_fire_department</span>
                        </div>
                        <div class="stat-card__info">
                            <h3>{{ $streak }}</h3>
                            <p>Day Streak</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card__icon stat-card__icon--pink">
                            <span class="material-symbols-outlined">schedule</span>
                        </div>
                        <div class="stat-card__info">
                            <h3>{{ $pendingReviews }}</h3>
                            <p>Pending Reviews</p>
                        </div>
                    </div>

                </div>

                {{-- MAIN GRID --}}
                <div class="dashboard__grid">

                    {{-- LEFT COLUMN --}}
                    <div class="dashboard__left" style="display: flex; flex-direction: column; gap: 24px;">

                        {{-- Latest Case --}}
                        <div class="dash-card">
                            <div class="dash-card__header">
                                <h3 class="dash-card__title">
                                    <span class="material-symbols-outlined">description</span>
                                    Latest Case
                                </h3>
                                <a href="{{ route('history.index') }}" class="dash-card__link">
                                    View All
                                    <span class="material-symbols-outlined">arrow_forward</span>
                                </a>
                            </div>

                            @php
                                $latestAttempt = \App\Models\CaseAttempt::where('user_id', $userId)
                                    ->with('medpixCase')
                                    ->latest()
                                    ->first();
                            @endphp

                            @if($latestAttempt && $latestAttempt->medpixCase)
                                <a href="{{ route('medpix.cases.show', $latestAttempt->medpix_uid) }}" style="text-decoration: none; color: inherit;">
                                    <div class="latest-case">
                                        <div class="latest-case__badge">{{ $latestAttempt->medpixCase->module->name ?? 'General' }}</div>
                                        <div class="latest-case__content">
                                            <h4>{{ $latestAttempt->medpixCase->uid }} · {{ $latestAttempt->medpixCase->title }}</h4>
                                            <p>{{ Str::limit($latestAttempt->medpixCase->history ?? 'No description', 80) }}</p>
                                            <div class="latest-case__meta">
                                                <span>🕐 {{ $latestAttempt->created_at->diffForHumans() }}</span>
                                                <span>✅ Diagnosis: {{ $latestAttempt->diagnosis ?? 'Pending' }}</span>
                                                <span>⭐ +{{ $latestAttempt->points_earned }} points</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @else
                                <div style="text-align: center; padding: 30px 0; color: var(--color-text-muted);">
                                    <p>You haven't solved any cases yet.</p>
                                    <a href="{{ route('random.case') }}" class="btn btn--primary" style="margin-top: 12px;">Start Your First Case</a>
                                </div>
                            @endif
                        </div>

                        {{-- Spaced Repetition --}}
                        <div class="dash-card">
                            <div class="dash-card__header">
                                <h3 class="dash-card__title">
                                    <span class="material-symbols-outlined">autorenew</span>
                                    Spaced Repetition
                                </h3>
                                <a href="{{ route('reviews.index') }}" class="dash-card__link">
                                    Review All
                                    <span class="material-symbols-outlined">arrow_forward</span>
                                </a>
                            </div>

                            @php
                                $reviews = \App\Models\CaseAttempt::where('user_id', $userId)
                                    ->where('is_correct', false)
                                    ->whereNotNull('next_review_date')
                                    ->where('next_review_date', '<=', now())
                                    ->with('medpixCase')
                                    ->orderBy('next_review_date', 'asc')
                                    ->limit(4)
                                    ->get();
                            @endphp

                            @if($reviews->isNotEmpty())
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    @foreach($reviews as $review)
                                        @if($review->medpixCase)
                                            <a href="{{ route('medpix.cases.show', $review->medpix_uid) }}" style="text-decoration: none; color: inherit;">
                                                <div class="review-item">
                                                    <div class="review-item__info">
                                                        <h4>{{ $review->medpixCase->uid }} · {{ $review->medpixCase->title ?? 'Unknown Case' }}</h4>
                                                        <p>Review due: {{ $review->next_review_date->diffForHumans() }}</p>
                                                    </div>
                                                    @php
                                                        $hours = now()->diffInHours($review->next_review_date);
                                                        $tagClass = $hours <= 2 ? 'review-item__tag--urgent' : ($hours <= 24 ? 'review-item__tag--soon' : 'review-item__tag--later');
                                                        $tagIcon = $hours <= 2 ? 'error' : ($hours <= 24 ? 'schedule' : 'event_note');
                                                        $tagText = $hours <= 2 ? 'Urgent' : ($hours <= 24 ? 'Soon' : 'Later');
                                                    @endphp
                                                    <span class="review-item__tag {{ $tagClass }}">
                                                        <span class="material-symbols-outlined">{{ $tagIcon }}</span>
                                                        {{ $tagText }}
                                                    </span>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div style="text-align: center; padding: 20px 0; color: var(--color-text-muted);">
                                    <p>No cases need review right now. Great job!</p>
                                </div>
                            @endif
                        </div>

                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div class="dashboard__right" style="display: flex; flex-direction: column; gap: 24px;">

                        {{-- Quick Actions --}}
                        <div class="dash-card">
                            <h3 class="dash-card__title" style="margin-bottom: 16px;">
                                <span class="material-symbols-outlined">bolt</span>
                                Quick Actions
                            </h3>

                            <div class="quick-actions">
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; width: 100%;">
                                    <a href="{{ route('random.case') }}" class="btn btn--primary btn--lg" style="justify-content: center; width: 100%;">
                                        <span class="material-symbols-outlined">shuffle</span>
                                        Random Case
                                    </a>
                                    <a href="{{ route('modules.index') }}" class="btn btn--choose-module" style="justify-content: center; width: 100%;">
                                        <span class="material-symbols-outlined">view_list</span>
                                        Choose Module
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Active Modules --}}
                        <div class="dash-card">
                            <div class="dash-card__header">
                                <h3 class="dash-card__title">
                                    <span class="material-symbols-outlined">menu_book</span>
                                    Active Modules
                                </h3>
                                <a href="{{ route('modules.index') }}" class="dash-card__link">
                                    View All
                                    <span class="material-symbols-outlined">arrow_forward</span>
                                </a>
                            </div>

                            @php
                                $modules = \App\Models\Module::where('is_active', true)
                                    ->orderBy('order')
                                    ->limit(6)
                                    ->get();
                            @endphp

                            <div class="dashboard__modules">
                                @foreach($modules as $module)
                                    <a href="{{ route('modules.show', ['slug' => $module->slug]) }}" class="module-chip">
                                        <span class="material-symbols-outlined">{{ $module->icon }}</span>
                                        {{ $module->name }}
                                        @php
                                            $moduleProgress = \App\Models\CaseAttempt::where('user_id', $userId)
                                                ->where('module_id', $module->id)
                                                ->count();
                                            $moduleTotal = $module->total_cases;
                                            $modulePercentage = $moduleTotal > 0 ? round(($moduleProgress / $moduleTotal) * 100) : 0;
                                        @endphp
                                        <span class="module-chip__progress">· {{ $modulePercentage }}%</span>
                                    </a>
                                @endforeach

                                @if($modules->count() > 0)
                                    <a href="{{ route('modules.index') }}" class="module-chip" style="opacity: 0.6;">
                                        <span class="material-symbols-outlined">add</span>
                                        More Modules
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </main>

        {{-- FOOTER --}}
        <footer class="footer">
            <div class="container footer__container">
                <div class="footer__brand">
                    <div class="footer__logo">
                        <img src="{{ asset('assets/img/logo1.png') }}" alt="SINA Logo" class="footer__logo-img footer__logo-img--light">
                        <img src="{{ asset('assets/img/logo1.png') }}" alt="SINA Logo" class="footer__logo-img footer__logo-img--dark">
                        <span class="footer__logo-text">SINA</span>
                    </div>
                    <p class="footer__desc">
                        Empowering the next generation of healthcare professionals through intelligent, case-based medical education.
                    </p>
                </div>
                <div class="footer__links">
                    <h4 class="footer__links-title">Product</h4>
                    <ul class="footer__links-list">
                        <li><a href="#">Features</a></li>
                        <li><a href="{{ route('modules.index') }}">Modules</a></li>
                        <li><a href="#">Updates</a></li>
                    </ul>
                </div>
                <div class="footer__links">
                    <h4 class="footer__links-title">Company</h4>
                    <ul class="footer__links-list">
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer__bottom">
                <span>Version v2.1.0 © 2026 SINA Medical Education. All rights reserved.</span>
                <div class="footer__bottom-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </footer>

        <script>
            const themeToggle = document.getElementById('themeToggle');
            const html = document.documentElement;
            themeToggle.addEventListener('click', () => {
                if (html.classList.contains('light')) {
                    html.classList.remove('light');
                    html.classList.add('dark');
                    themeToggle.innerHTML = '<span class="material-symbols-outlined">light_mode</span>';
                } else {
                    html.classList.remove('dark');
                    html.classList.add('light');
                    themeToggle.innerHTML = '<span class="material-symbols-outlined">dark_mode</span>';
                }
            });

            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const nav = document.querySelector('.header__nav');
            mobileMenuToggle.addEventListener('click', () => nav.classList.toggle('open'));
        </script>

    </body>
    </html>