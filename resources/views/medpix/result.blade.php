{{-- resources/views/medpix/result.blade.php --}}
<!DOCTYPE html>
<html class="light" dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SINA - Result · {{ $case->title }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        body { font-size: 18px; }
        .result-page {
            margin-top: 64px; padding: 32px 0 64px;
            min-height: calc(100vh - 64px);
            background: var(--color-bg-light);
        }
        .dark .result-page { background: var(--color-primary-navy); }

        .result-breadcrumb {
            display: flex; align-items: center; gap: 8px;
            font-size: 0.95rem; color: var(--color-text-secondary);
            margin-bottom: 20px;
        }
        .result-breadcrumb a { color: var(--color-primary-teal); text-decoration: none; }

        /* ============================================
           RESULT HERO
           ============================================ */
        .result-hero {
            background: var(--color-white);
            border-radius: var(--radius-xl);
            padding: 40px 32px;
            margin-bottom: 24px;
            text-align: center;
            box-shadow: var(--shadow-ambient-low);
            border: 1px solid rgba(0, 0, 0, 0.04);
            position: relative;
            overflow: hidden;
        }
        .dark .result-hero {
            background: rgba(10, 22, 40, 0.4);
            border-color: rgba(255, 255, 255, 0.04);
        }
        .result-hero::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 6px;
        }
        .result-hero--correct::before { background: linear-gradient(90deg, var(--color-brand-green), #27ae60); }
        .result-hero--wrong::before { background: linear-gradient(90deg, var(--color-brand-pink), #e74c3c); }

        .result-hero__icon {
            width: 96px; height: 96px;
            border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            margin-bottom: 16px;
        }
        .result-hero--correct .result-hero__icon {
            background: rgba(46, 204, 113, 0.12);
            color: var(--color-brand-green);
        }
        .result-hero--wrong .result-hero__icon {
            background: rgba(253, 121, 168, 0.12);
            color: var(--color-brand-pink);
        }
        .result-hero__icon .material-symbols-outlined { font-size: 4rem; }

        .result-hero__title {
            font-size: 2rem; font-weight: 800; margin: 0 0 8px;
        }
        .result-hero--correct .result-hero__title { color: var(--color-brand-green); }
        .result-hero--wrong .result-hero__title { color: var(--color-brand-pink); }

        .result-hero__subtitle {
            font-size: 1rem; color: var(--color-text-secondary); margin: 0;
        }
        .dark .result-hero__subtitle { color: rgba(255, 255, 255, 0.5); }

        /* ============================================
           SCORE CARDS
           ============================================ */
        .result-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .result-stat {
            background: var(--color-white); border-radius: var(--radius-xl);
            padding: 20px 24px; border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low); text-align: center;
        }
        .dark .result-stat {
            background: rgba(10, 22, 40, 0.4);
            border-color: rgba(255, 255, 255, 0.04);
        }
        .result-stat__icon {
            width: 48px; height: 48px; border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            margin-bottom: 8px;
        }
        .result-stat__icon .material-symbols-outlined { font-size: 1.8rem; }
        .result-stat__number {
            font-size: 2rem; font-weight: 800;
            line-height: 1.2; display: block;
        }
        .result-stat__label {
            font-size: 0.75rem; color: var(--color-text-secondary);
            text-transform: uppercase; letter-spacing: 0.04em;
            font-weight: 600;
        }
        .dark .result-stat__label { color: rgba(255, 255, 255, 0.4); }

        /* ============================================
           DIAGNOSIS COMPARISON
           ============================================ */
        .result-diagnosis {
            display: grid; grid-template-columns: 1fr 1fr; gap: 16px;
            margin-bottom: 24px;
        }
        @media (max-width: 768px) { .result-diagnosis { grid-template-columns: 1fr; } }

        .result-diag-box {
            background: var(--color-white); border-radius: var(--radius-xl);
            padding: 24px 28px;
            border: 2px solid;
            box-shadow: var(--shadow-ambient-low);
        }
        .dark .result-diag-box { background: rgba(10, 22, 40, 0.4); }
        .result-diag-box--user { border-color: rgba(0, 180, 216, 0.3); }
        .result-diag-box--correct { border-color: rgba(46, 204, 113, 0.3); }

        .result-diag-box__label {
            display: flex; align-items: center; gap: 8px;
            font-size: 0.85rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.04em;
            margin-bottom: 12px;
        }
        .result-diag-box--user .result-diag-box__label { color: var(--color-primary-teal); }
        .result-diag-box--correct .result-diag-box__label { color: var(--color-brand-green); }
        .result-diag-box__label .material-symbols-outlined { font-size: 1.3rem; }

        .result-diag-box__value {
            font-size: 1.15rem; font-weight: 700;
            line-height: 1.5; word-break: break-word;
        }
        .result-diag-box--user .result-diag-box__value { color: var(--color-brand-pink); }
        .result-diag-box--correct .result-diag-box__value { color: var(--color-brand-green); }

        /* ============================================
           AI FEEDBACK BOX
           ============================================ */
        .result-ai {
            background: linear-gradient(135deg, rgba(0, 180, 216, 0.06), rgba(46, 204, 113, 0.06));
            border-radius: var(--radius-xl);
            padding: 24px 28px;
            margin-bottom: 24px;
            border-left: 5px solid var(--color-primary-teal);
            box-shadow: var(--shadow-ambient-low);
        }
        .dark .result-ai {
            background: linear-gradient(135deg, rgba(0, 180, 216, 0.08), rgba(46, 204, 113, 0.08));
        }
        .result-ai__header {
            display: flex; align-items: center; gap: 10px;
            font-size: 1.05rem; font-weight: 800;
            color: var(--color-primary-teal);
            margin-bottom: 12px;
        }
        .result-ai__header .material-symbols-outlined { font-size: 1.5rem; }
        .result-ai__meta {
            font-size: 0.7rem; color: var(--color-text-muted);
            font-weight: 500; margin-left: auto;
            background: rgba(0, 0, 0, 0.04); padding: 3px 10px;
            border-radius: var(--radius-full);
        }
        .dark .result-ai__meta { background: rgba(255, 255, 255, 0.06); }
        .result-ai__content {
            font-size: 1rem; line-height: 1.8;
            color: var(--color-text-primary);
        }
        .dark .result-ai__content { color: rgba(255, 255, 255, 0.85); }
        .result-ai__reason {
            margin-top: 12px; padding-top: 12px;
            border-top: 1px dashed rgba(0, 0, 0, 0.08);
            font-size: 0.9rem; color: var(--color-text-secondary);
            font-style: italic;
        }
        .dark .result-ai__reason {
            border-top-color: rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.5);
        }

        /* ============================================
           LEARN MORE CARDS
           ============================================ */
        .result-content {
            background: var(--color-white); border-radius: var(--radius-xl);
            padding: 28px 32px;
            border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low);
            margin-bottom: 24px;
        }
        .dark .result-content {
            background: rgba(10, 22, 40, 0.4);
            border-color: rgba(255, 255, 255, 0.04);
        }
        .result-content__section {
            margin-bottom: 24px; padding-bottom: 24px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        .result-content__section:last-child {
            margin-bottom: 0; padding-bottom: 0; border-bottom: none;
        }
        .dark .result-content__section { border-bottom-color: rgba(255, 255, 255, 0.05); }

        .result-content__title {
            display: flex; align-items: center; gap: 10px;
            font-size: 1.1rem; font-weight: 700;
            color: var(--color-primary-teal);
            margin: 0 0 12px;
        }
        .result-content__title .material-symbols-outlined { font-size: 1.4rem; }

        .result-content__text {
            font-size: 0.95rem; line-height: 1.9;
            white-space: pre-wrap; word-wrap: break-word;
            color: var(--color-text-primary);
        }
        .dark .result-content__text { color: rgba(255, 255, 255, 0.85); }

        .result-content__list {
            margin: 6px 0 0 20px; padding-left: 14px;
            font-size: 0.95rem; line-height: 1.8;
        }

        /* ============================================
           ACTIONS
           ============================================ */
        .result-actions {
            display: flex; gap: 12px; flex-wrap: wrap;
            justify-content: center;
            padding: 24px 0;
        }
        .result-actions .btn {
            padding: 14px 28px;
            font-weight: 700; font-size: 0.95rem;
            border-radius: var(--radius-full);
            text-decoration: none;
            display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.3s ease;
        }
        .result-actions .btn--primary {
            background: linear-gradient(135deg, var(--color-primary-teal), #0a8ba8);
            color: #fff;
            box-shadow: 0 4px 16px rgba(0, 180, 216, 0.3);
        }
        .result-actions .btn--primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 180, 216, 0.4);
        }
        .result-actions .btn--outline {
            border: 2px solid rgba(0, 0, 0, 0.1);
            color: var(--color-text-secondary);
            background: var(--color-white);
        }
        .dark .result-actions .btn--outline {
            background: rgba(10, 22, 40, 0.4);
            border-color: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
        }
        .result-actions .btn--outline:hover {
            border-color: var(--color-primary-teal);
            color: var(--color-primary-teal);
        }

        @media (max-width: 768px) {
            .result-hero { padding: 28px 20px; }
            .result-hero__title { font-size: 1.5rem; }
            .result-hero__icon { width: 72px; height: 72px; }
            .result-hero__icon .material-symbols-outlined { font-size: 3rem; }
            .result-content { padding: 20px 22px; }
            .result-actions .btn { width: 100%; justify-content: center; }
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
                    <li><a href="{{ route('dashboard') }}" class="header__nav-link">Dashboard</a></li>
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
        </div>
    </header>

    {{-- MAIN --}}
    <main class="result-page">
        <div class="container">

            {{-- BREADCRUMB --}}
            <div class="result-breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <span class="material-symbols-outlined">chevron_right</span>
                <a href="{{ route('modules.index') }}">Modules</a>
                <span class="material-symbols-outlined">chevron_right</span>
                @if($case->module)
                    <a href="{{ route('modules.show', ['slug' => $case->module->slug]) }}">{{ $case->module->name }}</a>
                    <span class="material-symbols-outlined">chevron_right</span>
                @endif
                <span style="color: var(--color-text-primary); font-weight: 600;">Result</span>
            </div>

            {{-- HERO: CORRECT / INCORRECT --}}
            <div class="result-hero result-hero--{{ $attempt->is_correct ? 'correct' : 'wrong' }}">
                <div class="result-hero__icon">
                    <span class="material-symbols-outlined">
                        {{ $attempt->is_correct ? 'check_circle' : 'cancel' }}
                    </span>
                </div>
                <h1 class="result-hero__title">
                    {{ $attempt->is_correct ? 'Correct Diagnosis!' : 'Not Quite Right' }}
                </h1>
                <p class="result-hero__subtitle">
                    {{ $attempt->is_correct
                        ? 'Great work! You correctly identified the diagnosis.'
                        : 'Keep learning! Review the correct diagnosis and the AI feedback below.' }}
                </p>
            </div>

            {{-- STATS --}}
            <div class="result-stats">
                <div class="result-stat">
                    <div class="result-stat__icon" style="background: rgba(241, 196, 15, 0.15); color: #f39c12;">
                        <span class="material-symbols-outlined">star</span>
                    </div>
                    <span class="result-stat__number" style="color: #f39c12;">{{ $attempt->points_earned }}</span>
                    <span class="result-stat__label">Points Earned</span>
                </div>
                <div class="result-stat">
                    <div class="result-stat__icon" style="background: rgba(0, 180, 216, 0.12); color: var(--color-primary-teal);">
                        <span class="material-symbols-outlined">timer</span>
                    </div>
                    <span class="result-stat__number" style="color: var(--color-primary-teal);">{{ $attempt->time_taken }}s</span>
                    <span class="result-stat__label">Time Taken</span>
                </div>
                <div class="result-stat">
                    <div class="result-stat__icon" style="background: rgba(46, 204, 113, 0.12); color: var(--color-brand-green);">
                        <span class="material-symbols-outlined">trending_up</span>
                    </div>
                    <span class="result-stat__number" style="color: var(--color-brand-green);">Lvl {{ $progress->level }}</span>
                    <span class="result-stat__label">{{ $progress->level_title }}</span>
                </div>
                <div class="result-stat">
                    <div class="result-stat__icon" style="background: rgba(253, 121, 168, 0.12); color: var(--color-brand-pink);">
                        <span class="material-symbols-outlined">local_fire_department</span>
                    </div>
                    <span class="result-stat__number" style="color: var(--color-brand-pink);">{{ $progress->streak_days }}</span>
                    <span class="result-stat__label">Day Streak</span>
                </div>
            </div>

            {{-- DIAGNOSIS COMPARISON --}}
            <div class="result-diagnosis">
                <div class="result-diag-box result-diag-box--user">
                    <div class="result-diag-box__label">
                        <span class="material-symbols-outlined">person</span>
                        Your Diagnosis
                    </div>
                    <div class="result-diag-box__value">
                        {{ $attempt->diagnosis ?: 'Not provided' }}
                    </div>
                </div>
                <div class="result-diag-box result-diag-box--correct">
                    <div class="result-diag-box__label">
                        <span class="material-symbols-outlined">verified</span>
                        Correct Diagnosis
                    </div>
                    <div class="result-diag-box__value">
                        {{ $attempt->correct_diagnosis_text ?: $case->case_diagnosis ?? 'N/A' }}
                    </div>
                </div>
            </div>

            {{-- AI FEEDBACK --}}
            @if($attempt->ai_feedback_text)
                <div class="result-ai">
                    <div class="result-ai__header">
                        <span class="material-symbols-outlined">smart_toy</span>
                        AI Feedback
                        <span class="result-ai__meta">AI Generated</span>
                    </div>
                    <div class="result-ai__content">
                        {{ $attempt->ai_feedback_text }}
                    </div>
                </div>
            @endif

            {{-- LEARN MORE --}}
            <div class="result-content">
                @if($case->findings)
                    <div class="result-content__section">
                        <h2 class="result-content__title">
                            <span class="material-symbols-outlined">radiology</span>
                            Findings
                        </h2>
                        <div class="result-content__text">{{ $case->findings }}</div>
                    </div>
                @endif

                @if($case->disease_discussion)
                    <div class="result-content__section">
                        <h2 class="result-content__title">
                            <span class="material-symbols-outlined">menu_book</span>
                            Disease Discussion
                        </h2>
                        <div class="result-content__text">{{ $case->disease_discussion }}</div>
                    </div>
                @endif

                @if($case->differential_diagnosis)
                    <div class="result-content__section">
                        <h2 class="result-content__title">
                            <span class="material-symbols-outlined">help_center</span>
                            Differential Diagnosis
                        </h2>
                        <ul class="result-content__list">
                            @foreach(explode(',', $case->differential_diagnosis) as $item)
                                <li>{{ trim($item) }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($case->discussion)
                    <div class="result-content__section">
                        <h2 class="result-content__title">
                            <span class="material-symbols-outlined">forum</span>
                            Discussion
                        </h2>
                        <div class="result-content__text">{{ $case->discussion }}</div>
                    </div>
                @endif
            </div>

            {{-- ACTIONS --}}
            <div class="result-actions">
                <a href="{{ route('medpix.cases.show', $case->uid) }}" class="btn btn--outline">
                    <span class="material-symbols-outlined">refresh</span>
                    Try Again
                </a>
                <a href="{{ route('modules.show', ['slug' => $case->module->slug ?? '']) }}" class="btn btn--outline">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Back to Module
                </a>
                @if($nextCase)
                    <a href="{{ route('medpix.cases.show', $nextCase->uid) }}" class="btn btn--primary">
                        Next Case
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                @else
                    <a href="{{ route('random.case') }}" class="btn btn--primary">
                        <span class="material-symbols-outlined">shuffle</span>
                        Random Case
                    </a>
                @endif
            </div>

        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="footer">
        <div class="container footer__container">
            <div class="footer__brand">
                <div class="footer__logo">
                    <img src="{{ asset('assets/img/logo1.png') }}" alt="SINA Logo" class="footer__logo-img">
                    <span class="footer__logo-text">SINA</span>
                </div>
                <p class="footer__desc">
                    Empowering the next generation of healthcare professionals through intelligent, case-based medical education.
                </p>
            </div>
        </div>
        <div class="footer__bottom">
            <span>Version v2.1.0 © 2026 SINA Medical Education. All rights reserved.</span>
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
    </script>

</body>
</html>