{{-- resources/views/profile.blade.php --}}
<!DOCTYPE html>
<html class="light" dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SINA - My Profile</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        .profile-page {
            margin-top: 64px; padding: 32px 0 64px;
            min-height: calc(100vh - 64px);
            background: var(--color-bg-light); transition: background 0.3s;
        }
        .dark .profile-page { background: var(--color-primary-navy); }

        .profile-breadcrumb {
            display: flex; align-items: center; gap: 6px;
            font-size: 0.8rem; color: var(--color-text-secondary);
            margin-bottom: 20px; flex-wrap: wrap;
        }
        .dark .profile-breadcrumb { color: rgba(255, 255, 255, 0.4); }
        .profile-breadcrumb a { color: var(--color-primary-teal); text-decoration: none; font-weight: 500; }
        .profile-breadcrumb a:hover { text-decoration: underline; }
        .profile-breadcrumb .material-symbols-outlined { font-size: 1rem; }

        /* ============================================
           XP BAR SECTION (فقط في Profile)
           ============================================ */
        .profile-xp-section {
            background: linear-gradient(135deg, rgba(0, 180, 216, 0.08), rgba(46, 204, 113, 0.08));
            border-radius: var(--radius-xl);
            padding: 20px 28px;
            border: 1px solid rgba(0, 180, 216, 0.15);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
        }
        .dark .profile-xp-section {
            background: linear-gradient(135deg, rgba(0, 180, 216, 0.05), rgba(46, 204, 113, 0.05));
            border-color: rgba(0, 180, 216, 0.1);
        }

        .profile-xp-section__level {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .profile-xp-section__level-circle {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--color-primary-teal), #0a8ba8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.5rem;
            font-weight: 800;
            box-shadow: 0 4px 16px rgba(0, 180, 216, 0.3);
        }

        .profile-xp-section__level-info {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .profile-xp-section__level-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--color-primary-teal);
        }
        .dark .profile-xp-section__level-title { color: #5dd0e8; }

        .profile-xp-section__level-sub {
            font-size: 0.8rem;
            color: var(--color-text-secondary);
            font-weight: 600;
        }
        .dark .profile-xp-section__level-sub { color: rgba(255, 255, 255, 0.5); }

        .profile-xp-section__progress {
            flex: 1;
            min-width: 200px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .profile-xp-section__progress-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .profile-xp-section__progress-label {
            color: var(--color-text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-size: 0.75rem;
        }
        .dark .profile-xp-section__progress-label { color: rgba(255, 255, 255, 0.5); }

        .profile-xp-section__progress-value {
            color: var(--color-primary-teal);
        }
        .dark .profile-xp-section__progress-value { color: #5dd0e8; }

        .profile-xp-section__progress-track {
            height: 10px;
            background: rgba(0, 0, 0, 0.06);
            border-radius: var(--radius-full);
            overflow: hidden;
        }
        .dark .profile-xp-section__progress-track { background: rgba(255, 255, 255, 0.08); }

        .profile-xp-section__progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--color-primary-teal), #0a8ba8);
            border-radius: var(--radius-full);
            transition: width 1s ease;
            box-shadow: 0 0 12px rgba(0, 180, 216, 0.5);
        }

        .profile-xp-section__streak {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: linear-gradient(135deg, rgba(253, 203, 110, 0.2), rgba(230, 126, 34, 0.2));
            border-radius: var(--radius-full);
            border: 1px solid rgba(230, 126, 34, 0.3);
            flex-shrink: 0;
        }
        .profile-xp-section__streak .material-symbols-outlined {
            font-size: 1.4rem;
            color: #e67e22;
        }
        .profile-xp-section__streak-info {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }
        .profile-xp-section__streak-value {
            font-size: 1.1rem;
            font-weight: 800;
            color: #e67e22;
        }
        .profile-xp-section__streak-label {
            font-size: 0.65rem;
            font-weight: 600;
            color: #e67e22;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        @media (max-width: 640px) {
            .profile-xp-section {
                flex-direction: column;
                align-items: stretch;
                padding: 18px 20px;
                gap: 16px;
            }
            .profile-xp-section__streak {
                justify-content: center;
            }
        }

        /* Profile Header */
        .profile-header {
            background: var(--color-white); border-radius: var(--radius-xl);
            padding: 28px 32px; border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low);
            display: flex; align-items: center; gap: 28px;
            flex-wrap: wrap; margin-bottom: 28px;
        }
        .dark .profile-header {
            background: rgba(10, 22, 40, 0.4);
            border-color: rgba(255, 255, 255, 0.04);
        }
        .profile-header__avatar {
            width: 80px; height: 80px; border-radius: 50%;
            background: linear-gradient(135deg, var(--color-primary-teal), #0a8ba8);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 2.2rem; font-weight: 700;
            flex-shrink: 0; box-shadow: 0 4px 16px rgba(0, 180, 216, 0.2);
        }
        .profile-header__info h1 { font-size: 1.6rem; font-weight: 800; margin: 0; }
        .profile-header__info .title {
            color: var(--color-text-secondary); font-size: 0.95rem;
            margin: 2px 0 6px;
        }
        .dark .profile-header__info .title { color: rgba(255, 255, 255, 0.4); }
        .profile-header__info .badge-row { display: flex; gap: 8px; flex-wrap: wrap; }
        .profile-header__info .badge-row .badge {
            padding: 3px 14px; border-radius: var(--radius-full);
            font-size: 0.65rem; font-weight: 600;
            background: rgba(0, 180, 216, 0.08);
            color: var(--color-primary-teal);
        }
        .dark .profile-header__info .badge-row .badge { background: rgba(0, 180, 216, 0.12); }
        .profile-header__info .badge-row .badge--gold {
            background: rgba(241, 196, 15, 0.15); color: #d4a017;
        }

        .profile-header__actions {
            margin-left: auto; display: flex; gap: 10px; flex-wrap: wrap;
        }
        .btn--edit {
            border-color: var(--color-primary-teal) !important;
            color: var(--color-primary-teal) !important;
        }
        .btn--edit:hover {
            background: var(--color-primary-teal) !important; color: #fff !important;
        }
        .btn--settings {
            border-color: var(--color-text-muted) !important;
            color: var(--color-text-secondary) !important;
        }
        .btn--settings:hover { background: rgba(0, 0, 0, 0.04); }

        .profile-stats {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px; margin-bottom: 28px;
        }
        .profile-stat-card {
            background: var(--color-white); border-radius: var(--radius-xl);
            padding: 18px 22px; border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low);
            transition: all 0.3s ease; text-align: center;
        }
        .dark .profile-stat-card {
            background: rgba(10, 22, 40, 0.4);
            border-color: rgba(255, 255, 255, 0.04);
        }
        .profile-stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-card-hover); }
        .profile-stat-card__number { font-size: 2.2rem; font-weight: 800; line-height: 1.2; }
        .profile-stat-card__number--teal { color: var(--color-primary-teal); }
        .profile-stat-card__number--green { color: var(--color-brand-green); }
        .profile-stat-card__number--orange { color: #e67e22; }
        .profile-stat-card__number--pink { color: var(--color-brand-pink); }
        .profile-stat-card__number--purple { color: var(--color-brand-purple); }
        .profile-stat-card__label {
            font-size: 0.8rem; color: var(--color-text-secondary); margin: 0;
        }
        .dark .profile-stat-card__label { color: rgba(255, 255, 255, 0.4); }
        .profile-stat-card__sub { font-size: 0.7rem; color: var(--color-text-muted); }

        .profile-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width: 992px) { .profile-grid { grid-template-columns: 1fr; } }

        .profile-card {
            background: var(--color-white); border-radius: var(--radius-xl);
            padding: 20px 24px; border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low); transition: all 0.3s ease;
        }
        .dark .profile-card {
            background: rgba(10, 22, 40, 0.4);
            border-color: rgba(255, 255, 255, 0.04);
        }
        .profile-card:hover { box-shadow: var(--shadow-card-hover); }
        .profile-card__title {
            font-weight: 700; font-size: 1rem;
            display: flex; align-items: center; gap: 8px; margin-bottom: 14px;
        }
        .profile-card__title .material-symbols-outlined {
            color: var(--color-primary-teal); font-size: 1.2rem;
        }

        .module-performance { display: flex; flex-direction: column; gap: 12px; }
        .module-performance__item {
            display: flex; align-items: center; gap: 14px;
            padding: 6px 10px; border-radius: var(--radius-lg);
            transition: all 0.3s ease; cursor: default;
        }
        .module-performance__item:hover {
            background: rgba(0, 180, 216, 0.04); transform: scale(1.01);
        }
        .module-performance__item .icon-circle {
            width: 38px; height: 38px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; transition: all 0.3s ease;
        }
        .module-performance__item:hover .icon-circle {
            transform: scale(1.15); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .module-performance__item .icon-circle .material-symbols-outlined {
            font-size: 1.2rem; color: #fff;
        }
        .icon-circle--red { background: linear-gradient(135deg, #e74c3c, #c0392b); }
        .icon-circle--blue { background: linear-gradient(135deg, #3498db, #2980b9); }
        .icon-circle--purple { background: linear-gradient(135deg, #9b59b6, #8e44ad); }
        .icon-circle--teal { background: linear-gradient(135deg, #1abc9c, #16a085); }
        .icon-circle--orange { background: linear-gradient(135deg, #f39c12, #e67e22); }
        .module-performance__item .name {
            font-weight: 600; font-size: 0.85rem; min-width: 100px;
        }
        .module-performance__item .bar-wrapper {
            flex: 1; height: 6px; background: rgba(0, 0, 0, 0.06);
            border-radius: var(--radius-full); overflow: hidden;
        }
        .dark .module-performance__item .bar-wrapper { background: rgba(255, 255, 255, 0.06); }
        .module-performance__item .bar-fill {
            height: 100%; border-radius: var(--radius-full); transition: width 1s ease;
        }
        .module-performance__item .bar-fill--high {
            background: linear-gradient(90deg, var(--color-brand-green), #27ae60);
        }
        .module-performance__item .bar-fill--medium {
            background: linear-gradient(90deg, #f39c12, #e67e22);
        }
        .module-performance__item .bar-fill--low {
            background: linear-gradient(90deg, var(--color-brand-pink), #e74c3c);
        }
        .module-performance__item .percentage {
            font-weight: 700; font-size: 0.8rem; min-width: 40px; text-align: right;
        }

        .badges-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 10px;
        }
        .badge-item {
            text-align: center; padding: 10px 6px;
            border-radius: var(--radius-lg); background: rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(0, 0, 0, 0.04); transition: all 0.3s ease;
        }
        .dark .badge-item {
            background: rgba(255, 255, 255, 0.03);
            border-color: rgba(255, 255, 255, 0.04);
        }
        .badge-item:hover { transform: translateY(-3px); box-shadow: var(--shadow-card-hover); }
        .badge-item .material-symbols-outlined {
            font-size: 2.2rem; display: block; color: var(--color-primary-teal);
        }
        .badge-item.locked .material-symbols-outlined {
            color: var(--color-text-muted); opacity: 0.3;
        }
        .badge-item .label {
            font-size: 0.55rem; font-weight: 600;
            color: var(--color-text-secondary); margin-top: 4px;
        }
        .dark .badge-item .label { color: rgba(255, 255, 255, 0.4); }
        .badge-item.locked { opacity: 0.4; }

        .activity-list { display: flex; flex-direction: column; gap: 8px; }
        .activity-item {
            display: flex; align-items: center; gap: 12px;
            padding: 8px 12px; border-radius: var(--radius-lg);
            background: rgba(0, 0, 0, 0.02); transition: all 0.2s ease;
        }
        .dark .activity-item { background: rgba(255, 255, 255, 0.02); }
        .activity-item:hover { background: rgba(0, 180, 216, 0.04); }
        .activity-item__icon .material-symbols-outlined {
            font-size: 1.4rem; flex-shrink: 0;
        }
        .activity-item__icon .check { color: var(--color-brand-green); }
        .activity-item__icon .sync { color: var(--color-primary-teal); }
        .activity-item__icon .close { color: var(--color-brand-pink); }
        .activity-item__icon .trophy { color: #f1c40f; }
        .activity-item__icon .star { color: #f1c40f; }
        .activity-item__content { flex: 1; }
        .activity-item__content .title { font-weight: 600; font-size: 0.85rem; }
        .activity-item__content .desc { font-size: 0.75rem; color: var(--color-text-secondary); }
        .dark .activity-item__content .desc { color: rgba(255, 255, 255, 0.4); }
        .activity-item__time {
            font-size: 0.65rem; color: var(--color-text-muted); white-space: nowrap;
        }

        .settings-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .settings-item {
            display: flex; align-items: center; justify-content: space-between;
            padding: 8px 12px; border-radius: var(--radius-lg);
            background: rgba(0, 0, 0, 0.02);
        }
        .dark .settings-item { background: rgba(255, 255, 255, 0.02); }
        .settings-item__label { font-size: 0.85rem; font-weight: 500; }
        .settings-item__value { font-size: 0.8rem; color: var(--color-text-secondary); }
        .dark .settings-item__value { color: rgba(255, 255, 255, 0.4); }

        .toggle-switch {
            width: 40px; height: 22px; background: #ccc;
            border-radius: 12px; cursor: pointer; transition: background 0.3s;
            position: relative; flex-shrink: 0;
        }
        .dark .toggle-switch { background: #555; }
        .toggle-switch.active { background: var(--color-primary-teal); }
        .toggle-switch::after {
            content: ''; position: absolute; top: 2px; left: 2px;
            width: 18px; height: 18px; background: #fff;
            border-radius: 50%; transition: transform 0.3s;
        }
        .toggle-switch.active::after { transform: translateX(18px); }

        @media (max-width: 768px) {
            .profile-header { flex-direction: column; text-align: center; padding: 20px; }
            .profile-header__actions {
                margin-left: 0; width: 100%; justify-content: center;
            }
            .profile-header__actions .btn { flex: 1; justify-content: center; }
            .profile-stats { grid-template-columns: 1fr 1fr; }
            .settings-grid { grid-template-columns: 1fr; }
            .badges-grid { grid-template-columns: repeat(auto-fill, minmax(70px, 1fr)); }
        }
        @media (max-width: 480px) {
            .profile-stats { grid-template-columns: 1fr; }
            .profile-header__avatar { width: 60px; height: 60px; font-size: 1.6rem; }
            .profile-header__info h1 { font-size: 1.3rem; }
            .profile-card { padding: 16px; }
            .module-performance__item { flex-wrap: wrap; gap: 6px; }
            .module-performance__item .name { min-width: 80px; font-size: 0.8rem; }
            .module-performance__item .icon-circle { width: 32px; height: 32px; }
            .module-performance__item .icon-circle .material-symbols-outlined { font-size: 1rem; }
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
                    <span style="font-weight: 600; font-size: 0.85rem; color: var(--color-primary-teal);">Dr. {{ Auth::user()->name }}</span>
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
    <main class="profile-page">
        <div class="container">

            @php
                $userProgress = Auth::user()->getOrCreateProgress();
                $xpNeeded = \App\Models\UserProgress::xpForLevel($userProgress->level);
            @endphp

            {{-- BREADCRUMB --}}
            <div class="profile-breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <span class="material-symbols-outlined">chevron_right</span>
                <span style="color: var(--color-text-primary); font-weight: 600;">My Profile</span>
            </div>

            {{-- XP BAR SECTION --}}
            <div class="profile-xp-section">
                {{-- Level --}}
                <div class="profile-xp-section__level">
                    <div class="profile-xp-section__level-circle">{{ $userProgress->level }}</div>
                    <div class="profile-xp-section__level-info">
                        <span class="profile-xp-section__level-title">{{ $userProgress->level_title }}</span>
                        <span class="profile-xp-section__level-sub">{{ number_format($userProgress->total_points) }} pts total</span>
                    </div>
                </div>

                {{-- Progress --}}
                <div class="profile-xp-section__progress">
                    <div class="profile-xp-section__progress-info">
                        <span class="profile-xp-section__progress-label">Level Progress</span>
                        <span class="profile-xp-section__progress-value">
                            {{ $userProgress->xp_in_level }} / {{ $xpNeeded }} XP
                        </span>
                    </div>
                    <div class="profile-xp-section__progress-track">
                        <div class="profile-xp-section__progress-fill" style="width: {{ $userProgress->level_progress_percentage }}%;"></div>
                    </div>
                </div>

                {{-- Streak --}}
                @if($userProgress->streak_days > 0)
                    <div class="profile-xp-section__streak">
                        <span class="material-symbols-outlined">local_fire_department</span>
                        <div class="profile-xp-section__streak-info">
                            <span class="profile-xp-section__streak-value">{{ $userProgress->streak_days }}</span>
                            <span class="profile-xp-section__streak-label">Day Streak</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- PROFILE HEADER --}}
            <div class="profile-header">
                <div class="profile-header__avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <div class="profile-header__info">
                    <h1>Dr. {{ $user->name }}</h1>
                    <div class="title">Medical Student</div>
                    <div class="badge-row">
                        <span class="badge badge--gold">⭐ Level {{ $stats['level'] }} · {{ $stats['level_title'] }}</span>
                        <span class="badge">📚 {{ $stats['total_cases'] }} Cases Solved</span>
                        <span class="badge">🔥 {{ $stats['streak'] }} Day Streak</span>
                    </div>
                </div>
                <div class="profile-header__actions">
                    <a href="#" class="btn btn--outline btn--edit">
                        <span class="material-symbols-outlined">edit</span>
                        Edit Profile
                    </a>
                    <a href="#" class="btn btn--outline btn--settings">
                        <span class="material-symbols-outlined">settings</span>
                        Settings
                    </a>
                </div>
            </div>

            {{-- QUICK STATS --}}
            <div class="profile-stats">
                <div class="profile-stat-card">
                    <div class="profile-stat-card__number profile-stat-card__number--teal">{{ $stats['total_cases'] }}</div>
                    <p class="profile-stat-card__label">Cases Solved</p>
                    <span class="profile-stat-card__sub">{{ $stats['correct'] }} ✅ · {{ $stats['incorrect'] }} ❌</span>
                </div>

                <div class="profile-stat-card">
                    <div class="profile-stat-card__number profile-stat-card__number--green">{{ number_format($stats['points']) }}</div>
                    <p class="profile-stat-card__label">Total Points</p>
                    <span class="profile-stat-card__sub">{{ $stats['total_cases'] > 0 ? round($stats['points'] / max($stats['total_cases'], 1)) : 0 }} avg per case</span>
                </div>

                <div class="profile-stat-card">
                    <div class="profile-stat-card__number profile-stat-card__number--purple">{{ $stats['accuracy'] }}%</div>
                    <p class="profile-stat-card__label">Accuracy Rate</p>
                    <span class="profile-stat-card__sub">{{ $stats['accuracy'] >= 80 ? '⬆️ Excellent' : ($stats['accuracy'] >= 50 ? '➡️ Good' : '⬇️ Needs work') }}</span>
                </div>

                <div class="profile-stat-card">
                    <div class="profile-stat-card__number profile-stat-card__number--orange">{{ $stats['streak'] }}</div>
                    <p class="profile-stat-card__label">Day Streak</p>
                    <span class="profile-stat-card__sub">Best: {{ $stats['best_streak'] }} days</span>
                </div>

                <div class="profile-stat-card">
                    <div class="profile-stat-card__number profile-stat-card__number--pink">{{ $stats['pending_reviews'] }}</div>
                    <p class="profile-stat-card__label">Pending Reviews</p>
                    <span class="profile-stat-card__sub">Cases to review</span>
                </div>
            </div>

            {{-- MAIN GRID --}}
            <div class="profile-grid">

                {{-- LEFT COLUMN --}}
                <div style="display: flex; flex-direction: column; gap: 20px;">

                    {{-- Module Performance --}}
                    <div class="profile-card">
                        <div class="profile-card__title">
                            <span class="material-symbols-outlined">trending_up</span>
                            Performance by Module
                        </div>
                        <div class="module-performance">
                            @forelse($modulePerformance as $perf)
                                @php
                                    $colors = ['red', 'blue', 'purple', 'teal', 'orange'];
                                    $color = $colors[$loop->index % count($colors)];
                                    $barClass = $perf['percentage'] >= 60 ? 'high' : ($perf['percentage'] >= 30 ? 'medium' : 'low');
                                @endphp
                                <div class="module-performance__item">
                                    <div class="icon-circle icon-circle--{{ $color }}">
                                        <span class="material-symbols-outlined">{{ $perf['module']->icon ?? 'medical_services' }}</span>
                                    </div>
                                    <span class="name">{{ $perf['module']->name }}</span>
                                    <div class="bar-wrapper">
                                        <div class="bar-fill bar-fill--{{ $barClass }}" style="width: {{ $perf['percentage'] }}%;"></div>
                                    </div>
                                    <span class="percentage">{{ $perf['percentage'] }}%</span>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 20px; color: var(--color-text-muted);">
                                    <p>No module data yet. Start solving cases!</p>
                                </div>
                            @endforelse

                            @if(count($modulePerformance) > 0)
                                @php
                                    $strongest = $modulePerformance[0];
                                    $weakest = end($modulePerformance);
                                @endphp
                                <div class="module-performance__item" style="margin-top: 4px; padding-top: 10px; border-top: 1px solid rgba(0,0,0,0.04); justify-content: center;">
                                    <span style="font-size: 0.75rem; color: var(--color-text-muted);">
                                        💡 <strong>Strongest:</strong> {{ $strongest['module']->name }} · <strong>Weakest:</strong> {{ $weakest['module']->name }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Badges --}}
                    <div class="profile-card">
                        <div class="profile-card__title">
                            <span class="material-symbols-outlined">emoji_events</span>
                            Badges & Achievements
                            @php
                                $unlockedCount = collect($badges)->where('unlocked', true)->count();
                                $totalBadgesCount = count($badges);
                            @endphp
                            <span style="font-size: 0.7rem; font-weight: 400; color: var(--color-text-muted); margin-left: auto;">
                                {{ $unlockedCount }} / {{ $totalBadgesCount }}
                            </span>
                        </div>
                        <div class="badges-grid">
                            @foreach($badges as $badge)
                                <div class="badge-item {{ $badge['unlocked'] ? '' : 'locked' }}">
                                    <span class="material-symbols-outlined">{{ $badge['icon'] }}</span>
                                    <span class="label">{{ $badge['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                {{-- RIGHT COLUMN --}}
                <div style="display: flex; flex-direction: column; gap: 20px;">

                    {{-- Recent Activity --}}
                    <div class="profile-card">
                        <div class="profile-card__title">
                            <span class="material-symbols-outlined">history</span>
                            Recent Activity
                        </div>
                        <div class="activity-list">
                            @forelse($recentActivity as $activity)
                                @php
                                    $icon = $activity->is_correct ? 'check_circle' : 'close';
                                    $iconClass = $activity->is_correct ? 'check' : 'close';
                                    $title = $activity->medpixCase->uid ?? 'Case';
                                    $caseTitle = $activity->medpixCase->title ?? 'Unknown';
                                    $desc = $activity->is_correct
                                        ? 'Correct diagnosis · +' . $activity->points_earned . ' points'
                                        : 'Incorrect · ' . $activity->points_earned . ' points';
                                @endphp
                                <div class="activity-item">
                                    <div class="activity-item__icon">
                                        <span class="material-symbols-outlined {{ $iconClass }}">{{ $icon }}</span>
                                    </div>
                                    <div class="activity-item__content">
                                        <div class="title">{{ $title }} · {{ Str::limit($caseTitle, 30) }}</div>
                                        <div class="desc">{{ $desc }}</div>
                                    </div>
                                    <span class="activity-item__time">{{ $activity->created_at->diffForHumans() }}</span>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 20px; color: var(--color-text-muted);">
                                    <p>No activity yet. Start solving cases!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Settings --}}
                    <div class="profile-card">
                        <div class="profile-card__title">
                            <span class="material-symbols-outlined">settings</span>
                            Settings & Preferences
                        </div>
                        <div class="settings-grid">
                            <div class="settings-item">
                                <span class="settings-item__label">Email Notifications</span>
                                <div class="toggle-switch active" onclick="toggleSwitch(this)"></div>
                            </div>
                            <div class="settings-item">
                                <span class="settings-item__label">Reminders</span>
                                <div class="toggle-switch active" onclick="toggleSwitch(this)"></div>
                            </div>
                            <div class="settings-item">
                                <span class="settings-item__label">Dark Mode</span>
                                <div class="toggle-switch active" onclick="toggleSwitch(this)"></div>
                            </div>
                            <div class="settings-item">
                                <span class="settings-item__label">Daily Goals</span>
                                <div class="toggle-switch" onclick="toggleSwitch(this)"></div>
                            </div>
                            <div class="settings-item" style="grid-column: 1 / -1;">
                                <span class="settings-item__label">Language</span>
                                <span class="settings-item__value">English</span>
                            </div>
                            <div class="settings-item" style="grid-column: 1 / -1;">
                                <span class="settings-item__label">Report Frequency</span>
                                <span class="settings-item__value">Weekly</span>
                            </div>
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
        // THEME TOGGLE
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

        // MOBILE MENU
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const nav = document.querySelector('.header__nav');

        mobileMenuToggle.addEventListener('click', () => {
            nav.classList.toggle('open');
        });

        // TOGGLE SWITCH
        function toggleSwitch(element) {
            element.classList.toggle('active');
        }
    </script>

</body>
</html>