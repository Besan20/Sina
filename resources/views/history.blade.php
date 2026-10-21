{{-- resources/views/history.blade.php --}}
<!DOCTYPE html>
<html class="light" dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SINA - My Case History</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        /* نفس الـ CSS القديم بدون تغيير */
        .history-page {
            margin-top: 64px;
            padding: 32px 0 64px;
            min-height: calc(100vh - 64px);
            background: var(--color-bg-light);
            transition: background 0.3s;
        }
        .dark .history-page { background: var(--color-primary-navy); }

        .history-breadcrumb {
            display: flex; align-items: center; gap: 6px;
            font-size: 0.8rem; color: var(--color-text-secondary);
            margin-bottom: 16px; flex-wrap: wrap;
        }
        .dark .history-breadcrumb { color: rgba(255, 255, 255, 0.4); }
        .history-breadcrumb a { color: var(--color-primary-teal); text-decoration: none; font-weight: 500; }
        .history-breadcrumb a:hover { text-decoration: underline; }
        .history-breadcrumb .material-symbols-outlined { font-size: 1rem; }

        .history-header {
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 16px; margin-bottom: 24px;
        }
        .history-header__title h1 {
            font-size: 1.6rem; font-weight: 800; margin: 0;
            display: flex; align-items: center; gap: 10px;
        }
        .history-header__title h1 .material-symbols-outlined {
            color: var(--color-primary-teal); font-size: 1.8rem;
        }
        .history-header__title p {
            color: var(--color-text-secondary); margin: 0; font-size: 0.9rem;
        }
        .dark .history-header__title p { color: rgba(255, 255, 255, 0.5); }

        .history-header__actions { display: flex; gap: 10px; flex-wrap: wrap; }
        .btn--review-all {
            background: linear-gradient(135deg, var(--color-brand-pink), #e74c8b) !important;
            color: #fff !important; border: none !important;
            padding: 10px 22px; font-weight: 700; font-size: 0.85rem;
            gap: 6px; border-radius: var(--radius-full);
        }
        .btn--review-all:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 32px rgba(253, 121, 168, 0.3);
        }

        .history-stats {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 14px; margin-bottom: 24px;
        }
        @media (max-width: 768px) { .history-stats { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 480px) { .history-stats { grid-template-columns: 1fr; } }

        .history-stat-card {
            background: var(--color-white); border-radius: var(--radius-xl);
            padding: 14px 16px; border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low); transition: all 0.3s ease;
            text-align: center;
        }
        .dark .history-stat-card {
            background: rgba(10, 22, 40, 0.4);
            border-color: rgba(255, 255, 255, 0.04);
        }
        .history-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-card-hover);
        }
        .history-stat-card__number {
            font-size: 1.8rem; font-weight: 800; line-height: 1.2;
        }
        .history-stat-card__number--teal { color: var(--color-primary-teal); }
        .history-stat-card__number--green { color: var(--color-brand-green); }
        .history-stat-card__number--orange { color: #e67e22; }
        .history-stat-card__number--pink { color: var(--color-brand-pink); }
        .history-stat-card__label {
            font-size: 0.75rem; color: var(--color-text-secondary); margin: 0;
        }
        .dark .history-stat-card__label { color: rgba(255, 255, 255, 0.4); }

        .history-controls {
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 12px; margin-bottom: 20px;
            padding: 12px 18px; background: var(--color-white);
            border-radius: var(--radius-xl); border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low);
        }
        .dark .history-controls {
            background: rgba(10, 22, 40, 0.4);
            border-color: rgba(255, 255, 255, 0.04);
        }

        .history-controls__filters { display: flex; gap: 8px; flex-wrap: wrap; }
        .history-controls__filters .filter-btn {
            padding: 6px 16px; border-radius: var(--radius-full);
            border: 1px solid rgba(0, 0, 0, 0.08); background: transparent;
            font-size: 0.75rem; font-weight: 600; cursor: pointer;
            transition: all 0.25s ease; color: var(--color-text-secondary);
            display: flex; align-items: center; gap: 6px; white-space: nowrap;
        }
        .dark .history-controls__filters .filter-btn {
            border-color: rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.5);
        }
        .history-controls__filters .filter-btn:hover {
            background: rgba(0, 180, 216, 0.08);
            transform: translateY(-1px);
        }
        .history-controls__filters .filter-btn.active {
            background: var(--color-primary-teal); color: #fff;
            border-color: var(--color-primary-teal);
            box-shadow: 0 4px 12px rgba(0, 180, 216, 0.25);
        }
        .history-controls__filters .filter-btn .material-symbols-outlined { font-size: 1rem; }

        .history-controls__search {
            display: flex; align-items: center; gap: 6px;
            background: var(--color-bg-light); border-radius: var(--radius-full);
            padding: 4px 14px; border: 1px solid rgba(0, 0, 0, 0.04);
        }
        .dark .history-controls__search {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.06);
        }
        .history-controls__search .material-symbols-outlined {
            color: var(--color-text-muted); font-size: 1.1rem;
        }
        .history-controls__search input {
            border: none; background: transparent; padding: 6px 0;
            font-size: 0.85rem; outline: none;
            color: var(--color-text-primary); width: 160px;
        }
        .dark .history-controls__search input { color: var(--color-text-white); }
        .history-controls__search input::placeholder { color: var(--color-text-muted); }

        .history-list { display: flex; flex-direction: column; gap: 10px; }

        .history-item {
            background: var(--color-white); border-radius: var(--radius-xl);
            padding: 14px 20px; border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low); transition: all 0.3s ease;
            display: grid; grid-template-columns: auto 1fr auto auto;
            align-items: center; gap: 12px; position: relative;
        }
        .dark .history-item {
            background: rgba(10, 22, 40, 0.4);
            border-color: rgba(255, 255, 255, 0.04);
        }
        .history-item:hover {
            box-shadow: var(--shadow-card-hover);
            transform: translateX(3px);
        }
        .history-item.hidden { display: none; }
        .history-item--needs-review { border-left: 3px solid var(--color-brand-pink); }
        .history-item--needs-review::before {
            content: "Needs Review";
            position: absolute; top: -9px; right: 16px;
            background: var(--color-brand-pink); color: #fff;
            font-size: 0.55rem; font-weight: 700; padding: 2px 12px;
            border-radius: var(--radius-full); text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .history-item__module {
            font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.04em; color: var(--color-primary-teal);
            background: rgba(0, 180, 216, 0.08); padding: 2px 12px;
            border-radius: var(--radius-full); white-space: nowrap;
            width: fit-content;
        }
        .dark .history-item__module { background: rgba(0, 180, 216, 0.12); }

        .history-item__content { display: flex; flex-direction: column; gap: 4px; }
        .history-item__title {
            font-weight: 700; font-size: 0.95rem; display: flex;
            align-items: center; gap: 8px; flex-wrap: wrap;
        }
        .history-item__title .case-number {
            font-weight: 400; color: var(--color-text-muted); font-size: 0.7rem;
        }
        .history-item__details {
            display: flex; flex-wrap: wrap; gap: 10px 16px;
            font-size: 0.78rem; color: var(--color-text-secondary);
        }
        .dark .history-item__details { color: rgba(255, 255, 255, 0.4); }
        .history-item__details .detail-item {
            display: flex; align-items: center; gap: 4px;
        }
        .history-item__details .detail-item .material-symbols-outlined {
            font-size: 0.9rem; color: var(--color-text-muted);
        }

        .history-item__diagnosis {
            padding: 3px 12px; border-radius: var(--radius-full);
            font-size: 0.7rem; font-weight: 600;
            display: inline-flex; align-items: center; gap: 4px;
            white-space: nowrap;
        }
        .diagnosis--correct {
            background: rgba(46, 204, 113, 0.12);
            color: var(--color-brand-green);
        }
        .diagnosis--wrong {
            background: rgba(253, 121, 168, 0.12);
            color: var(--color-brand-pink);
        }

        .history-item__score {
            font-weight: 700; font-size: 0.85rem;
            color: var(--color-primary-teal); white-space: nowrap;
            display: flex; align-items: center; gap: 2px;
        }
        .history-item__score .star-icon { font-size: 1rem; color: #f1c40f; }
        .history-item__score .points {
            font-weight: 400; color: var(--color-text-muted); font-size: 0.65rem;
        }
        .dark .history-item__score { color: #5dd0e8; }

        .history-item__actions {
            display: flex; gap: 6px; flex-wrap: wrap; align-items: center;
        }
        .history-item__actions .btn {
            padding: 4px 14px; font-size: 0.7rem;
            font-weight: 600; border-radius: var(--radius-full);
        }
        .btn--view-details {
            border-color: var(--color-primary-teal) !important;
            color: var(--color-primary-teal) !important;
            display: inline-flex; align-items: center; gap: 4px;
        }
        .btn--view-details:hover {
            background: var(--color-primary-teal) !important;
            color: #fff !important;
        }

        .history-item__status-score {
            display: flex; align-items: center; gap: 12px;
            white-space: nowrap; flex-shrink: 0;
        }

        .pagination-wrapper {
            display: flex; justify-content: center; margin-top: 24px;
            padding-top: 20px; border-top: 1px solid rgba(0, 0, 0, 0.04);
        }
        .dark .pagination-wrapper { border-top-color: rgba(255, 255, 255, 0.04); }

        .custom-pagination {
            display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
            justify-content: center;
        }
        .page-btn {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 38px; height: 38px; padding: 0 10px;
            border-radius: var(--radius-full); border: 1px solid rgba(0, 0, 0, 0.06);
            background: var(--color-white); color: var(--color-text-secondary);
            font-size: 0.85rem; font-weight: 600; text-decoration: none;
            transition: all 0.2s ease; cursor: pointer;
        }
        .dark .page-btn {
            background: rgba(10, 22, 40, 0.4);
            border-color: rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, 0.6);
        }
        .page-btn .material-symbols-outlined { font-size: 1.2rem; }
        .page-btn:hover:not(.page-btn--disabled):not(.page-btn--active) {
            border-color: var(--color-primary-teal);
            color: var(--color-primary-teal);
            background: rgba(0, 180, 216, 0.05);
        }
        .page-btn--active {
            background: linear-gradient(135deg, var(--color-primary-teal), #0a8ba8);
            color: #fff; border-color: transparent;
            box-shadow: 0 4px 12px rgba(0, 180, 216, 0.25);
        }
        .page-btn--disabled { opacity: 0.35; cursor: not-allowed; pointer-events: none; }

        .empty-state {
            text-align: center; padding: 60px 20px;
            color: var(--color-text-muted);
        }
        .empty-state .material-symbols-outlined {
            font-size: 4rem; opacity: 0.3;
            display: block; margin-bottom: 12px;
        }
        .empty-state h3 { font-size: 1.2rem; margin: 0 0 8px; }
        .empty-state p { margin: 0 0 16px; }

        @media (max-width: 768px) {
            .history-item { grid-template-columns: 1fr; gap: 8px; padding: 12px 16px; }
            .history-item__actions { width: 100%; }
            .history-item__actions .btn { flex: 1; justify-content: center; }
            .history-controls { flex-direction: column; align-items: stretch; padding: 12px 16px; }
            .history-controls__search input { width: 100%; }
            .history-controls__search { width: 100%; }
            .history-header { flex-direction: column; align-items: stretch; }
            .history-header__actions .btn { width: 100%; justify-content: center; }
        }
        @media (max-width: 480px) {
            .history-stats { grid-template-columns: 1fr 1fr; }
            .history-header__title h1 { font-size: 1.3rem; }
            .history-item__title { font-size: 0.85rem; }
            .history-item__details { font-size: 0.72rem; gap: 6px 12px; }
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
                    <li><a href="{{ route('history.index') }}" class="header__nav-link" style="color: var(--color-primary-teal);">My History</a></li>
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

    {{-- MAIN --}}
    <main class="history-page">
        <div class="container">

            {{-- Breadcrumb --}}
            <div class="history-breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <span class="material-symbols-outlined">chevron_right</span>
                <span style="color: var(--color-text-primary); font-weight: 600;">My Case History</span>
            </div>

            {{-- Header --}}
            <div class="history-header">
                <div class="history-header__title">
                    <h1>
                        <span class="material-symbols-outlined">history</span>
                        My Case History
                    </h1>
                    <p>Review all the cases you've solved, track your progress, and revisit challenging cases.</p>
                </div>
                <div class="history-header__actions">
                    <a href="{{ route('reviews.index') }}" class="btn btn--review-all">
                        <span class="material-symbols-outlined">autorenew</span>
                        Review All ({{ $stats['needs_review'] }})
                    </a>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="history-stats">
                <div class="history-stat-card">
                    <div class="history-stat-card__number history-stat-card__number--teal">{{ $stats['total'] }}</div>
                    <p class="history-stat-card__label">Total Cases Solved</p>
                </div>
                <div class="history-stat-card">
                    <div class="history-stat-card__number history-stat-card__number--green">{{ $stats['correct'] }}</div>
                    <p class="history-stat-card__label">Correct</p>
                </div>
                <div class="history-stat-card">
                    <div class="history-stat-card__number history-stat-card__number--orange">{{ $stats['incorrect'] }}</div>
                    <p class="history-stat-card__label">Incorrect</p>
                </div>
                <div class="history-stat-card">
                    <div class="history-stat-card__number history-stat-card__number--pink">{{ $stats['needs_review'] }}</div>
                    <p class="history-stat-card__label">Needs Review</p>
                </div>
            </div>

            {{-- Filters & Search --}}
            <div class="history-controls">
                <div class="history-controls__filters">
                    <button class="filter-btn active" data-filter="all">
                        <span class="material-symbols-outlined">list</span>
                        All
                    </button>
                    <button class="filter-btn" data-filter="correct">
                        <span class="material-symbols-outlined">check_circle</span>
                        Correct
                    </button>
                    <button class="filter-btn" data-filter="incorrect">
                        <span class="material-symbols-outlined">error</span>
                        Incorrect
                    </button>
                    <button class="filter-btn" data-filter="review">
                        <span class="material-symbols-outlined">autorenew</span>
                        Needs Review
                    </button>
                    <button class="filter-btn" data-filter="highscore">
                        <span class="material-symbols-outlined">star</span>
                        High Score
                    </button>
                </div>

                <div class="history-controls__search">
                    <span class="material-symbols-outlined">search</span>
                    <input type="text" placeholder="Search cases..." id="searchInput" />
                </div>
            </div>

            {{-- History List --}}
            <div class="history-list" id="historyList">

                @forelse($attempts as $attempt)
                    @php
                        $case = $attempt->medpixCase;
                        $needsReview = !$attempt->is_correct && $attempt->next_review_date && $attempt->next_review_date->isPast();
                        $status = $attempt->is_correct ? 'correct' : 'incorrect';
                        $score = $attempt->points_earned ?? 0;
                    @endphp

                    @if($case)
                        <div class="history-item {{ $needsReview ? 'history-item--needs-review' : '' }}"
                             data-status="{{ $status }}"
                             data-needs-review="{{ $needsReview ? 'true' : 'false' }}"
                             data-score="{{ $score }}">

                            <div>
                                <span class="history-item__module">{{ $case->module->name ?? 'General' }}</span>
                            </div>

                            <div class="history-item__content">
                                <div class="history-item__title">
                                    {{ $case->uid }} · {{ Str::limit($case->title, 50) }}
                                    <span class="case-number">· Solved {{ $attempt->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="history-item__details">
                                    <span class="detail-item">
                                        <span class="material-symbols-outlined">{{ $attempt->is_correct ? 'check_circle' : 'error' }}</span>
                                        Your Diagnosis: {{ $attempt->diagnosis ?? 'Not provided' }}
                                    </span>
                                    @if($attempt->orders && count($attempt->orders) > 0)
                                        <span class="detail-item">
                                            <span class="material-symbols-outlined">science</span>
                                            Tests Ordered: {{ implode(', ', array_slice($attempt->orders, 0, 3)) }}
                                        </span>
                                    @endif
                                    <span class="detail-item">
                                        <span class="material-symbols-outlined">star</span>
                                        +{{ $attempt->points_earned ?? 0 }} points
                                    </span>
                                    @if(!$attempt->is_correct && $case->case_diagnosis)
                                        <span class="detail-item" style="color: var(--color-brand-pink);">
                                            <span class="material-symbols-outlined">info</span>
                                            Correct: {{ Str::limit($case->case_diagnosis, 40) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="history-item__status-score">
                                <span class="history-item__diagnosis {{ $attempt->is_correct ? 'diagnosis--correct' : 'diagnosis--wrong' }}">
                                    <span class="material-symbols-outlined">{{ $attempt->is_correct ? 'check' : 'close' }}</span>
                                    {{ $attempt->is_correct ? 'Correct' : 'Incorrect' }}
                                </span>
                                <span class="history-item__score" style="{{ !$attempt->is_correct ? 'color: var(--color-brand-pink);' : '' }}">
                                    <span class="star-icon">★</span> {{ $attempt->points_earned ?? 0 }} <span class="points">pts</span>
                                </span>
                            </div>

                            <div class="history-item__actions">
                                <a href="{{ route('history.show', $attempt->id) }}" class="btn btn--outline btn--view-details">
                                    <span class="material-symbols-outlined">visibility</span>
                                    Details
                                </a>
                            </div>

                        </div>
                    @endif
                @empty
                    <div class="empty-state">
                        <span class="material-symbols-outlined">history</span>
                        <h3>No Cases Yet</h3>
                        <p>You haven't solved any cases yet. Start with a random case!</p>
                        <a href="{{ route('random.case') }}" class="btn btn--primary">
                            <span class="material-symbols-outlined">shuffle</span>
                            Start Random Case
                        </a>
                    </div>
                @endforelse

            </div>

            {{-- Pagination --}}
            @if($attempts->hasPages())
                <div class="pagination-wrapper">
                    <div class="custom-pagination">
                        @if ($attempts->onFirstPage())
                            <span class="page-btn page-btn--disabled">
                                <span class="material-symbols-outlined">chevron_left</span>
                            </span>
                        @else
                            <a href="{{ $attempts->previousPageUrl() }}" class="page-btn">
                                <span class="material-symbols-outlined">chevron_left</span>
                            </a>
                        @endif

                        @foreach ($attempts->getUrlRange(1, $attempts->lastPage()) as $page => $url)
                            @if ($page == $attempts->currentPage())
                                <span class="page-btn page-btn--active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($attempts->hasMorePages())
                            <a href="{{ $attempts->nextPageUrl() }}" class="page-btn">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </a>
                        @else
                            <span class="page-btn page-btn--disabled">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </span>
                        @endif
                    </div>
                </div>
            @endif

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
        // Theme Toggle
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

        // Mobile Menu
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const nav = document.querySelector('.header__nav');
        mobileMenuToggle.addEventListener('click', () => nav.classList.toggle('open'));

        // Filter Buttons
        const filterButtons = document.querySelectorAll('.filter-btn');
        const historyItems = document.querySelectorAll('.history-item');
        const searchInput = document.getElementById('searchInput');

        function filterCases() {
            const activeFilter = document.querySelector('.filter-btn.active');
            const filterValue = activeFilter ? activeFilter.dataset.filter : 'all';
            const searchTerm = searchInput.value.toLowerCase().trim();

            historyItems.forEach(item => {
                const status = item.dataset.status;
                const needsReview = item.dataset.needsReview === 'true';
                const score = parseInt(item.dataset.score) || 0;
                const title = item.querySelector('.history-item__title').textContent.toLowerCase();
                const module = item.querySelector('.history-item__module').textContent.toLowerCase();

                let show = true;
                if (filterValue === 'correct') show = status === 'correct';
                else if (filterValue === 'incorrect') show = status === 'incorrect';
                else if (filterValue === 'review') show = needsReview === true;
                else if (filterValue === 'highscore') show = score >= 30;
                else show = true;

                if (show && searchTerm) {
                    show = title.includes(searchTerm) || module.includes(searchTerm);
                }

                item.classList.toggle('hidden', !show);
            });
        }

        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                filterCases();
            });
        });

        searchInput.addEventListener('input', filterCases);
    </script>

</body>
</html>