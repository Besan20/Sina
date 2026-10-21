{{-- resources/views/leaderboard.blade.php --}}
<!DOCTYPE html>
<html class="light" dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SINA - Leaderboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        .leaderboard-page {
            margin-top: 64px; padding: 32px 0 64px;
            min-height: calc(100vh - 64px);
            background: var(--color-bg-light); transition: background 0.3s;
        }
        .dark .leaderboard-page { background: var(--color-primary-navy); }

        .leaderboard-breadcrumb {
            display: flex; align-items: center; gap: 8px;
            font-size: 0.85rem; color: var(--color-text-secondary);
            margin-bottom: 16px;
        }
        .dark .leaderboard-breadcrumb { color: rgba(255, 255, 255, 0.4); }
        .leaderboard-breadcrumb a { color: var(--color-primary-teal); text-decoration: none; font-weight: 500; }
        .leaderboard-breadcrumb a:hover { text-decoration: underline; }
        .leaderboard-breadcrumb .material-symbols-outlined { font-size: 1rem; }

        .leaderboard-header {
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 16px; margin-bottom: 24px;
        }
        .leaderboard-header__title h1 {
            font-size: 1.8rem; font-weight: 800; margin: 0;
            display: flex; align-items: center; gap: 10px;
        }
        .leaderboard-header__title h1 .material-symbols-outlined { color: #f1c40f; }
        .leaderboard-header__title p { color: var(--color-text-secondary); margin: 0; font-size: 0.95rem; }
        .dark .leaderboard-header__title p { color: rgba(255, 255, 255, 0.5); }

        .leaderboard-header__stats { display: flex; gap: 20px; align-items: center; flex-wrap: wrap; }
        .leaderboard-header__stat { text-align: center; }
        .leaderboard-header__stat .number { font-size: 1.5rem; font-weight: 800; color: var(--color-primary-teal); }
        .dark .leaderboard-header__stat .number { color: #5dd0e8; }
        .leaderboard-header__stat .label {
            font-size: 0.7rem; color: var(--color-text-secondary);
            text-transform: uppercase; letter-spacing: 0.04em;
        }
        .dark .leaderboard-header__stat .label { color: rgba(255, 255, 255, 0.4); }

        .podium {
            display: flex; justify-content: center; align-items: flex-end;
            gap: 20px; padding: 32px 0 24px; margin-bottom: 28px;
            background: linear-gradient(180deg, rgba(0, 180, 216, 0.04) 0%, transparent 100%);
            border-radius: var(--radius-xl);
        }
        .podium__item {
            display: flex; flex-direction: column; align-items: center;
            gap: 8px; transition: all 0.3s ease; cursor: default;
        }
        .podium__item:hover { transform: translateY(-4px); }

        .podium__avatar {
            width: 72px; height: 72px; border-radius: 50%;
            background: var(--color-primary-teal);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 2rem; font-weight: 700;
            position: relative; box-shadow: 0 4px 16px rgba(0, 180, 216, 0.2);
        }
        .podium__avatar .rank-badge {
            position: absolute; top: -8px; right: -8px;
            width: 28px; height: 28px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem; font-weight: 800; color: #fff;
            border: 2px solid var(--color-white);
        }
        .dark .podium__avatar .rank-badge { border-color: var(--color-primary-navy); }
        .rank-badge--1 { background: linear-gradient(135deg, #f1c40f, #f39c12); }
        .rank-badge--2 { background: linear-gradient(135deg, #bdc3c7, #95a5a6); }
        .rank-badge--3 { background: linear-gradient(135deg, #e67e22, #d35400); }

        .podium__avatar--1 {
            width: 88px; height: 88px; font-size: 2.4rem;
            background: linear-gradient(135deg, #f1c40f, #f39c12);
            box-shadow: 0 8px 32px rgba(241, 196, 15, 0.3);
        }
        .podium__avatar--2 {
            width: 76px; height: 76px; font-size: 2rem;
            background: linear-gradient(135deg, #bdc3c7, #95a5a6);
            box-shadow: 0 8px 32px rgba(149, 165, 166, 0.2);
        }
        .podium__avatar--3 {
            width: 76px; height: 76px; font-size: 2rem;
            background: linear-gradient(135deg, #e67e22, #d35400);
            box-shadow: 0 8px 32px rgba(230, 126, 34, 0.2);
        }
        .podium__name { font-weight: 700; font-size: 1rem; }
        .podium__points { font-size: 0.85rem; font-weight: 600; color: var(--color-primary-teal); }
        .dark .podium__points { color: #5dd0e8; }
        .podium__trophy { font-size: 2rem; }
        .podium__position { font-size: 0.7rem; color: var(--color-text-muted); }

        .leaderboard-controls {
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 12px; margin-bottom: 20px;
            padding: 16px 20px; background: var(--color-white);
            border-radius: var(--radius-xl); border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low);
        }
        .dark .leaderboard-controls {
            background: rgba(10, 22, 40, 0.4);
            border-color: rgba(255, 255, 255, 0.04);
        }
        .leaderboard-controls__filters { display: flex; gap: 8px; flex-wrap: wrap; }
        .leaderboard-controls__filters .filter-btn {
            padding: 4px 16px; border-radius: var(--radius-full);
            border: 1px solid rgba(0, 0, 0, 0.08); background: transparent;
            font-size: 0.75rem; font-weight: 600; cursor: pointer;
            transition: all 0.2s ease; color: var(--color-text-secondary);
        }
        .dark .leaderboard-controls__filters .filter-btn {
            border-color: rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.4);
        }
        .leaderboard-controls__filters .filter-btn:hover { background: rgba(0, 180, 216, 0.08); }
        .leaderboard-controls__filters .filter-btn.active {
            background: var(--color-primary-teal); color: #fff;
            border-color: var(--color-primary-teal);
        }
        .leaderboard-controls__search {
            display: flex; align-items: center; gap: 8px;
            background: var(--color-bg-light); border-radius: var(--radius-full);
            padding: 4px 16px; border: 1px solid rgba(0, 0, 0, 0.06);
        }
        .dark .leaderboard-controls__search {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.06);
        }
        .leaderboard-controls__search .material-symbols-outlined {
            color: var(--color-text-muted); font-size: 1.2rem;
        }
        .leaderboard-controls__search input {
            border: none; background: transparent; padding: 8px 0;
            font-size: 0.9rem; outline: none; color: var(--color-text-primary);
            width: 180px;
        }
        .dark .leaderboard-controls__search input { color: var(--color-text-white); }
        .leaderboard-controls__search input::placeholder { color: var(--color-text-muted); }

        .leaderboard-table {
            background: var(--color-white); border-radius: var(--radius-xl);
            border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low); overflow: hidden;
        }
        .dark .leaderboard-table {
            background: rgba(10, 22, 40, 0.4);
            border-color: rgba(255, 255, 255, 0.04);
        }
        .leaderboard-table__header {
            display: grid; grid-template-columns: 60px 1fr 120px 100px 80px;
            gap: 12px; padding: 14px 20px; background: rgba(0, 0, 0, 0.02);
            font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.04em; color: var(--color-text-muted);
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
        }
        .dark .leaderboard-table__header {
            background: rgba(255, 255, 255, 0.02);
            border-bottom-color: rgba(255, 255, 255, 0.04);
            color: rgba(255, 255, 255, 0.3);
        }
        .leaderboard-table__row {
            display: grid; grid-template-columns: 60px 1fr 120px 100px 80px;
            gap: 12px; padding: 12px 20px; align-items: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }
        .dark .leaderboard-table__row { border-bottom-color: rgba(255, 255, 255, 0.03); }
        .leaderboard-table__row:last-child { border-bottom: none; }
        .leaderboard-table__row:hover { background: rgba(0, 180, 216, 0.04); }
        .dark .leaderboard-table__row:hover { background: rgba(0, 180, 216, 0.06); }

        .leaderboard-table__row--highlight {
            background: rgba(0, 180, 216, 0.06);
            border-left: 3px solid var(--color-primary-teal);
        }
        .dark .leaderboard-table__row--highlight { background: rgba(0, 180, 216, 0.08); }
        .leaderboard-table__row--highlight:hover { background: rgba(0, 180, 216, 0.1); }

        .leaderboard-table__rank { font-weight: 800; font-size: 1rem; text-align: center; }
        .leaderboard-table__rank--1 { color: #f1c40f; }
        .leaderboard-table__rank--2 { color: #bdc3c7; }
        .leaderboard-table__rank--3 { color: #e67e22; }

        .leaderboard-table__user { display: flex; align-items: center; gap: 12px; }
        .leaderboard-table__avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: var(--color-primary-teal);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1rem; font-weight: 700; flex-shrink: 0;
        }
        .leaderboard-table__avatar--gold { background: linear-gradient(135deg, #f1c40f, #f39c12); }
        .leaderboard-table__avatar--silver { background: linear-gradient(135deg, #bdc3c7, #95a5a6); }
        .leaderboard-table__avatar--bronze { background: linear-gradient(135deg, #e67e22, #d35400); }

        .leaderboard-table__name { font-weight: 600; font-size: 0.95rem; }
        .leaderboard-table__name small {
            font-weight: 400; color: var(--color-text-secondary);
            font-size: 0.75rem;
        }
        .dark .leaderboard-table__name small { color: rgba(255, 255, 255, 0.3); }

        .leaderboard-table__badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 2px 10px; border-radius: var(--radius-full);
            font-size: 0.6rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .badge--expert { background: linear-gradient(135deg, #f1c40f, #f39c12); color: #fff; }
        .badge--scholar { background: linear-gradient(135deg, #3498db, #2980b9); color: #fff; }
        .badge--rising { background: linear-gradient(135deg, #2ecc71, #27ae60); color: #fff; }
        .badge--learner { background: linear-gradient(135deg, #95a5a6, #7f8c8d); color: #fff; }

        .leaderboard-table__points { font-weight: 700; font-size: 1rem; color: var(--color-primary-teal); }
        .dark .leaderboard-table__points { color: #5dd0e8; }

        .leaderboard-table__streak {
            display: flex; align-items: center; gap: 4px;
            font-weight: 600; font-size: 0.9rem;
        }
        .leaderboard-table__streak .material-symbols-outlined {
            color: #e67e22; font-size: 1.2rem;
        }

        .you-indicator {
            background: var(--color-primary-teal); color: #fff;
            font-size: 0.55rem; font-weight: 700; text-transform: uppercase;
            padding: 1px 10px; border-radius: var(--radius-full);
            margin-left: 8px; letter-spacing: 0.04em;
        }

        .empty-state {
            text-align: center; padding: 60px 20px;
            color: var(--color-text-muted);
        }
        .empty-state .material-symbols-outlined {
            font-size: 4rem; opacity: 0.3; display: block; margin-bottom: 12px;
        }

        @media (max-width: 992px) {
            .leaderboard-table__header, .leaderboard-table__row {
                grid-template-columns: 50px 1fr 100px 80px 70px;
                gap: 8px; padding: 10px 16px;
            }
        }
        @media (max-width: 768px) {
            .leaderboard-header { flex-direction: column; align-items: stretch; }
            .leaderboard-header__stats { justify-content: space-around; }
            .podium { gap: 12px; padding: 20px 0 16px; }
            .podium__avatar--1 { width: 64px; height: 64px; font-size: 1.8rem; }
            .podium__avatar--2, .podium__avatar--3 { width: 56px; height: 56px; font-size: 1.5rem; }
            .podium__avatar { width: 56px; height: 56px; font-size: 1.5rem; }
            .podium__name { font-size: 0.8rem; }
            .podium__points { font-size: 0.7rem; }
            .podium__trophy { font-size: 1.4rem; }
            .leaderboard-table__header, .leaderboard-table__row {
                grid-template-columns: 40px 1fr 70px 60px 50px;
                gap: 6px; padding: 8px 12px; font-size: 0.8rem;
            }
            .leaderboard-table__avatar { width: 28px; height: 28px; font-size: 0.7rem; }
            .leaderboard-table__name { font-size: 0.8rem; }
            .leaderboard-table__points { font-size: 0.8rem; }
            .leaderboard-table__streak { font-size: 0.7rem; }
            .leaderboard-table__streak .material-symbols-outlined { font-size: 1rem; }
            .leaderboard-table__badge { font-size: 0.5rem; padding: 1px 6px; }
            .leaderboard-controls { flex-direction: column; align-items: stretch; }
            .leaderboard-controls__search input { width: 100%; }
            .leaderboard-controls__search { width: 100%; }
        }
        @media (max-width: 480px) {
            .leaderboard-table__header { display: none; }
            .leaderboard-table__row {
                grid-template-columns: 1fr; gap: 4px;
                padding: 12px 16px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            }
            .dark .leaderboard-table__row { border-bottom-color: rgba(255, 255, 255, 0.06); }
            .leaderboard-table__row .leaderboard-table__rank { text-align: left; font-size: 0.8rem; }
            .leaderboard-table__user { gap: 8px; }
            .leaderboard-table__points { font-size: 0.9rem; }
            .leaderboard-table__row .leaderboard-table__streak { font-size: 0.8rem; }
            .podium { flex-direction: row; gap: 8px; padding: 12px 0; }
            .podium__item { flex: 1; }
            .podium__avatar--1 { width: 56px; height: 56px; font-size: 1.4rem; }
            .podium__avatar--2, .podium__avatar--3 { width: 48px; height: 48px; font-size: 1.2rem; }
            .podium__name { font-size: 0.7rem; }
            .podium__points { font-size: 0.6rem; }
            .podium__trophy { font-size: 1.2rem; }
            .podium__position { font-size: 0.6rem; }
            .leaderboard-header__stat .number { font-size: 1.2rem; }
            .leaderboard-header__stat .label { font-size: 0.6rem; }
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
                    <li><a href="{{ route('leaderboard.index') }}" class="header__nav-link" style="color: var(--color-primary-teal);">Leaderboard</a></li>
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
    <main class="leaderboard-page">
        <div class="container">

            {{-- BREADCRUMB --}}
            <div class="leaderboard-breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <span class="material-symbols-outlined">chevron_right</span>
                <span style="color: var(--color-text-primary); font-weight: 600;">Leaderboard</span>
            </div>

            {{-- HEADER --}}
            <div class="leaderboard-header">
                <div class="leaderboard-header__title">
                    <h1>
                        <span class="material-symbols-outlined">emoji_events</span>
                        Leaderboard
                    </h1>
                    <p>See how you rank among your peers. Keep learning and climb the ranks!</p>
                </div>
                <div class="leaderboard-header__stats">
                    <div class="leaderboard-header__stat">
                        <div class="number">{{ number_format($stats['total_students']) }}</div>
                        <div class="label">Total Students</div>
                    </div>
                    <div class="leaderboard-header__stat">
                        <div class="number">{{ number_format($stats['total_cases_solved']) }}</div>
                        <div class="label">Total Cases Solved</div>
                    </div>
                    <div class="leaderboard-header__stat">
                        <div class="number">{{ $stats['avg_accuracy'] }}%</div>
                        <div class="label">Average Accuracy</div>
                    </div>
                </div>
            </div>

            {{-- PODIUM --}}
            @if($users->count() >= 3)
                <div class="podium">
                    @php $second = $users[1]; @endphp
                    <div class="podium__item">
                        <div class="podium__trophy">🥈</div>
                        <div class="podium__avatar podium__avatar--2">
                            {{ strtoupper(substr($second->name, 0, 1)) }}
                            <span class="rank-badge rank-badge--2">2</span>
                        </div>
                        <div class="podium__name">{{ $second->name }}</div>
                        <div class="podium__points">{{ number_format($second->total_points) }} pts</div>
                    </div>

                    @php $first = $users[0]; @endphp
                    <div class="podium__item">
                        <div class="podium__trophy">🏆</div>
                        <div class="podium__avatar podium__avatar--1">
                            {{ strtoupper(substr($first->name, 0, 1)) }}
                            <span class="rank-badge rank-badge--1">1</span>
                        </div>
                        <div class="podium__name">{{ $first->name }}</div>
                        <div class="podium__points">{{ number_format($first->total_points) }} pts</div>
                    </div>

                    @php $third = $users[2]; @endphp
                    <div class="podium__item">
                        <div class="podium__trophy">🥉</div>
                        <div class="podium__avatar podium__avatar--3">
                            {{ strtoupper(substr($third->name, 0, 1)) }}
                            <span class="rank-badge rank-badge--3">3</span>
                        </div>
                        <div class="podium__name">{{ $third->name }}</div>
                        <div class="podium__points">{{ number_format($third->total_points) }} pts</div>
                    </div>
                </div>
            @endif

            {{-- CONTROLS --}}
            <div class="leaderboard-controls">
                <div class="leaderboard-controls__filters">
                    <button class="filter-btn active">🏆 All</button>
                    <button class="filter-btn">🔥 This Month</button>
                    <button class="filter-btn">📈 This Week</button>
                    <button class="filter-btn">⭐ Top Performers</button>
                </div>
                <div class="leaderboard-controls__search">
                    <span class="material-symbols-outlined">search</span>
                    <input type="text" placeholder="Search students..." id="searchInput" />
                </div>
            </div>

            {{-- TABLE --}}
            <div class="leaderboard-table">
                <div class="leaderboard-table__header">
                    <span>#</span>
                    <span>Student</span>
                    <span>Badge</span>
                    <span>Points</span>
                    <span>Cases</span>
                </div>

                @forelse($users as $user)
                    @php
                        $isCurrentUser = Auth::id() === $user->id;
                        $rankClass = $user->rank <= 3 ? 'leaderboard-table__rank--' . $user->rank : '';
                        $medals = [1 => '🥇', 2 => '🥈', 3 => '🥉'];
                        $rankDisplay = $medals[$user->rank] ?? $user->rank;

                        if ($user->level >= 10) {
                            $badge = ['class' => 'badge--expert', 'text' => '🏅 Expert'];
                            $avatarClass = 'leaderboard-table__avatar--gold';
                        } elseif ($user->level >= 5) {
                            $badge = ['class' => 'badge--scholar', 'text' => '📚 Scholar'];
                            $avatarClass = 'leaderboard-table__avatar--silver';
                        } elseif ($user->level >= 3) {
                            $badge = ['class' => 'badge--rising', 'text' => '📈 Rising'];
                            $avatarClass = '';
                        } else {
                            $badge = ['class' => 'badge--learner', 'text' => '🌱 Learner'];
                            $avatarClass = '';
                        }
                    @endphp

                    <div class="leaderboard-table__row {{ $isCurrentUser ? 'leaderboard-table__row--highlight' : '' }}">
                        <div class="leaderboard-table__rank {{ $rankClass }}">{{ $rankDisplay }}</div>
                        <div class="leaderboard-table__user">
                            <div class="leaderboard-table__avatar {{ $avatarClass }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="leaderboard-table__name">
                                {{ $user->name }}
                                @if($isCurrentUser)
                                    <span class="you-indicator">You</span>
                                @endif
                            </span>
                        </div>
                        <div>
                            <span class="leaderboard-table__badge {{ $badge['class'] }}">{{ $badge['text'] }}</span>
                        </div>
                        <div class="leaderboard-table__points">{{ number_format($user->total_points) }}</div>
                        <div class="leaderboard-table__streak">
                            <span class="material-symbols-outlined">assignment</span>
                            {{ $user->total_attempts }}
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <span class="material-symbols-outlined">leaderboard</span>
                        <p>No users on the leaderboard yet.</p>
                    </div>
                @endforelse
            </div>

            {{-- MOTIVATIONAL FOOTER --}}
            @if($currentUserRank && $currentUserStats)
                <div style="margin-top: 28px; text-align: center; padding: 16px 24px; background: linear-gradient(135deg, rgba(0,180,216,0.04), rgba(46,204,113,0.04)); border-radius: var(--radius-xl); border: 1px solid rgba(0,180,216,0.06);">
                    <p style="margin: 0; font-weight: 600; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 8px; flex-wrap: wrap;">
                        <span class="material-symbols-outlined" style="color: var(--color-primary-teal);">trending_up</span>
                        Your Rank: #{{ $currentUserRank }} · {{ number_format($currentUserStats['points']) }} pts · {{ $currentUserStats['accuracy'] }}% accuracy
                        @if($currentUserRank > 1)
                            <span style="font-weight: 400; color: var(--color-text-secondary); font-size: 0.85rem;">
                                Keep going to climb the ranks!
                            </span>
                        @else
                            <span style="font-weight: 400; color: var(--color-brand-green); font-size: 0.85rem;">
                                You're #1! 🎉
                            </span>
                        @endif
                    </p>
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

        // Search filter
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const term = this.value.toLowerCase().trim();
                document.querySelectorAll('.leaderboard-table__row').forEach(row => {
                    const name = row.querySelector('.leaderboard-table__name')?.textContent.toLowerCase() || '';
                    row.style.display = name.includes(term) ? '' : 'none';
                });
            });
        }

        // Filter buttons (visual only)
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>

</body>
</html>