{{-- resources/views/module.blade.php --}}
<!DOCTYPE html>
<html class="light" dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SINA - {{ $module->name ?? 'Module' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        .module-page {
            margin-top: 64px;
            padding: 32px 0 64px;
            min-height: calc(100vh - 64px);
            background: var(--color-bg-light);
            transition: background 0.3s;
        }
        .dark .module-page { background: var(--color-primary-navy); }

        /* Breadcrumb */
        .module-breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            color: var(--color-text-secondary);
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .dark .module-breadcrumb { color: rgba(255, 255, 255, 0.4); }
        .module-breadcrumb a {
            color: var(--color-primary-teal);
            text-decoration: none;
            font-weight: 500;
        }
        .module-breadcrumb a:hover { text-decoration: underline; }
        .module-breadcrumb .material-symbols-outlined { font-size: 1rem; }

        /* Module Header */
        .module-header {
            display: flex;
            gap: 24px;
            background: var(--color-white);
            border-radius: var(--radius-xl);
            padding: 24px;
            border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low);
            margin-bottom: 24px;
            align-items: flex-start;
            flex-wrap: wrap;
        }
        .dark .module-header {
            background: rgba(10, 22, 40, 0.4);
            border-color: rgba(255, 255, 255, 0.04);
        }

        .module-header__image {
            width: 200px;
            height: 200px;
            border-radius: var(--radius-lg);
            overflow: hidden;
            flex-shrink: 0;
            background: var(--color-bg-light);
        }
        .module-header__image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .dark .module-header__image { background: rgba(255, 255, 255, 0.02); }

        .module-header__image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--color-primary-teal), #0a8ba8);
            color: #fff;
        }
        .module-header__image-placeholder .material-symbols-outlined { font-size: 4rem; }

        .module-header__info { flex: 1; min-width: 250px; }

        .module-header__title {
            font-size: 1.6rem;
            font-weight: 800;
            margin: 0 0 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .module-header__title .material-symbols-outlined {
            color: var(--color-primary-teal);
            font-size: 1.8rem;
        }

        .module-header__desc {
            color: var(--color-text-secondary);
            font-size: 0.95rem;
            margin: 0 0 12px;
        }
        .dark .module-header__desc { color: rgba(255, 255, 255, 0.4); }

        .module-header__stats {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }
        .module-header__stat {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: var(--color-text-secondary);
        }
        .dark .module-header__stat { color: rgba(255, 255, 255, 0.4); }
        .module-header__stat .material-symbols-outlined {
            color: var(--color-primary-teal);
            font-size: 1.2rem;
        }
        .module-header__stat strong { color: var(--color-text-primary); }
        .dark .module-header__stat strong { color: var(--color-text-white); }

        /* Module Actions */
        .module-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 4px;
        }

        .module-actions .btn {
            padding: 10px 22px;
            font-weight: 600;
            font-size: 0.85rem;
            border-radius: var(--radius-full);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            line-height: 1;
            white-space: nowrap;
        }

        .module-actions .btn .material-symbols-outlined {
            font-size: 1.1rem;
        }

        .btn--random {
            background: linear-gradient(135deg, var(--color-primary-teal), #0a8ba8);
            color: #fff;
            box-shadow: 0 2px 8px rgba(0, 180, 216, 0.25);
        }
        .btn--random:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 180, 216, 0.35);
        }

        .btn--outline {
            border: 1.5px solid rgba(0, 0, 0, 0.1);
            color: var(--color-text-secondary);
            background: transparent;
        }
        .dark .btn--outline {
            border-color: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
        }
        .btn--outline:hover {
            border-color: var(--color-primary-teal);
            color: var(--color-primary-teal);
            background: rgba(0, 180, 216, 0.05);
        }

        /* Stats Row */
        .module-stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 14px;
            margin-bottom: 24px;
        }
        .module-stat-card {
            background: var(--color-white);
            border-radius: var(--radius-xl);
            padding: 16px 20px;
            border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low);
            text-align: center;
            transition: all 0.3s ease;
        }
        .dark .module-stat-card {
            background: rgba(10, 22, 40, 0.4);
            border-color: rgba(255, 255, 255, 0.04);
        }
        .module-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-card-hover);
        }
        .module-stat-card__number {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--color-primary-teal);
        }
        .dark .module-stat-card__number { color: #5dd0e8; }
        .module-stat-card__label {
            font-size: 0.75rem;
            color: var(--color-text-secondary);
            margin: 0;
        }
        .dark .module-stat-card__label { color: rgba(255, 255, 255, 0.4); }

        /* Cases Section */
        .cases-section {
            background: var(--color-white);
            border-radius: var(--radius-xl);
            padding: 20px 24px;
            border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low);
        }
        .dark .cases-section {
            background: rgba(10, 22, 40, 0.4);
            border-color: rgba(255, 255, 255, 0.04);
        }
        .cases-section__header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 16px;
        }
        .cases-section__title {
            font-weight: 700;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .cases-section__title .material-symbols-outlined { color: var(--color-primary-teal); }

        .cases-filter { display: flex; gap: 6px; flex-wrap: wrap; }
        .cases-filter__btn {
            padding: 5px 14px;
            border-radius: var(--radius-full);
            border: 1px solid rgba(0, 0, 0, 0.06);
            background: transparent;
            font-size: 0.7rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            color: var(--color-text-secondary);
        }
        .dark .cases-filter__btn {
            border-color: rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, 0.4);
        }
        .cases-filter__btn:hover { background: rgba(0, 180, 216, 0.06); }
        .cases-filter__btn.active {
            background: var(--color-primary-teal);
            color: #fff;
            border-color: var(--color-primary-teal);
        }

        /* Case Item */
        .case-item {
            display: grid;
            grid-template-columns: auto 1fr auto auto;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            border-radius: var(--radius-lg);
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            transition: all 0.2s ease;
            text-decoration: none;
            color: inherit;
        }
        .dark .case-item { border-bottom-color: rgba(255, 255, 255, 0.04); }
        .case-item:last-child { border-bottom: none; }
        .case-item:hover { background: rgba(0, 180, 216, 0.05); }
        .dark .case-item:hover { background: rgba(0, 180, 216, 0.08); }

        .case-item__uid {
            font-weight: 700;
            font-size: 0.7rem;
            color: var(--color-primary-teal);
            background: rgba(0, 180, 216, 0.1);
            padding: 5px 12px;
            border-radius: var(--radius-full);
            white-space: nowrap;
            letter-spacing: 0.03em;
        }
        .dark .case-item__uid {
            background: rgba(93, 208, 232, 0.12);
            color: #5dd0e8;
        }

        .case-item__title {
            font-weight: 600;
            font-size: 0.9rem;
            line-height: 1.4;
        }
        .case-item__title small {
            font-weight: 400;
            color: var(--color-text-secondary);
            font-size: 0.75rem;
            display: block;
            margin-top: 3px;
        }
        .dark .case-item__title small { color: rgba(255, 255, 255, 0.4); }

        .case-item__meta {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.7rem;
            color: var(--color-text-muted);
            white-space: nowrap;
        }
        .dark .case-item__meta { color: rgba(255, 255, 255, 0.4); }

        .case-item__meta-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .case-item__meta-item .material-symbols-outlined { font-size: 0.9rem; }

        .case-item__action {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .case-item__action .btn-view {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 18px;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: var(--radius-full);
            text-decoration: none;
            background: linear-gradient(135deg, var(--color-primary-teal), #0a8ba8);
            color: #fff;
            transition: all 0.3s ease;
            white-space: nowrap;
            min-width: 90px;
        }
        .case-item__action .btn-view .material-symbols-outlined {
            font-size: 1rem;
            transition: transform 0.2s ease;
        }
        .case-item__action .btn-view:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 180, 216, 0.3);
        }
        .case-item__action .btn-view:hover .material-symbols-outlined {
            transform: translateX(3px);
        }

        /* Empty */
        .no-cases {
            text-align: center;
            padding: 40px 20px;
            color: var(--color-text-muted);
        }
        .no-cases .material-symbols-outlined {
            font-size: 3rem;
            opacity: 0.3;
            display: block;
            margin-bottom: 8px;
        }

        /* Pagination */
        .pagination-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        .dark .pagination-wrapper { border-top-color: rgba(255, 255, 255, 0.05); }

        .custom-pagination {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .page-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 10px;
            border-radius: var(--radius-full);
            border: 1px solid rgba(0, 0, 0, 0.06);
            background: var(--color-white);
            color: var(--color-text-secondary);
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
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
            color: #fff;
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(0, 180, 216, 0.25);
        }
        .page-btn--active:hover { transform: translateY(-1px); }

        .page-btn--disabled {
            opacity: 0.35;
            cursor: not-allowed;
            pointer-events: none;
        }

        .pagination-info {
            font-size: 0.75rem;
            color: var(--color-text-muted);
            text-align: center;
        }
        .dark .pagination-info { color: rgba(255, 255, 255, 0.4); }

        /* Responsive */
        @media (max-width: 768px) {
            .module-header { flex-direction: column; align-items: center; text-align: center; }
            .module-header__image { width: 150px; height: 150px; }
            .module-header__stats { justify-content: center; }
            .module-actions { justify-content: center; width: 100%; }
            .module-actions .btn { flex: 1; min-width: 140px; }

            .case-item { grid-template-columns: 1fr; gap: 8px; padding: 14px 16px; }
            .case-item__uid { width: fit-content; }
            .case-item__action { width: 100%; justify-content: stretch; }
            .case-item__action .btn-view { width: 100%; min-width: auto; }
            .case-item__meta { justify-content: flex-start; }

            .cases-section__header { flex-direction: column; align-items: stretch; }
        }
        @media (max-width: 480px) {
            .module-header__image { width: 120px; height: 120px; }
            .module-header__title { font-size: 1.3rem; }
            .module-stats-row { grid-template-columns: 1fr 1fr; }
            .module-stat-card__number { font-size: 1.4rem; }
            .module-actions { flex-direction: column; }
            .module-actions .btn { width: 100%; }
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
                    <li><a href="{{ route('modules.index') }}" class="header__nav-link" style="color: var(--color-primary-teal);">Modules</a></li>
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

    {{-- MAIN --}}
    <main class="module-page">
        <div class="container">

            {{-- BREADCRUMB --}}
            <div class="module-breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <span class="material-symbols-outlined">chevron_right</span>
                <a href="{{ route('modules.index') }}">Modules</a>
                <span class="material-symbols-outlined">chevron_right</span>
                <span style="color: var(--color-text-primary); font-weight: 600;">{{ $module->name }}</span>
            </div>

            {{-- MODULE HEADER --}}
            <div class="module-header">

                <div class="module-header__image">
                    @if($module->image && file_exists(public_path('assets/img/modules/' . $module->image)))
                        <img src="{{ asset('assets/img/modules/' . $module->image) }}" alt="{{ $module->name }}">
                    @else
                        <div class="module-header__image-placeholder">
                            <span class="material-symbols-outlined">{{ $module->icon ?? 'medical_services' }}</span>
                        </div>
                    @endif
                </div>

                <div class="module-header__info">
                    <h1 class="module-header__title">
                        <span class="material-symbols-outlined">{{ $module->icon ?? 'medical_services' }}</span>
                        {{ $module->name }}
                    </h1>
                    <p class="module-header__desc">{{ $module->description }}</p>

                    <div class="module-header__stats">
                        <span class="module-header__stat">
                            <span class="material-symbols-outlined">description</span>
                            <strong>{{ $stats['total'] }}</strong> cases
                        </span>
                        <span class="module-header__stat">
                            <span class="material-symbols-outlined">trending_up</span>
                            Difficulty: <strong>{{ ucfirst($module->difficulty) }}</strong>
                        </span>
                    </div>

                    <div class="module-actions">
                        <a href="{{ route('modules.random', $module->slug) }}" class="btn btn--random">
                            <span class="material-symbols-outlined">shuffle</span>
                            Random Case
                        </a>
                        <a href="{{ route('modules.index') }}" class="btn btn--outline">
                            <span class="material-symbols-outlined">arrow_back</span>
                            Back to Modules
                        </a>
                    </div>
                </div>

            </div>

            {{-- STATS ROW --}}
            <div class="module-stats-row">
                <div class="module-stat-card">
                    <div class="module-stat-card__number">{{ $stats['total'] }}</div>
                    <p class="module-stat-card__label">Total Cases</p>
                </div>
                <div class="module-stat-card">
                    <div class="module-stat-card__number">{{ $stats['completed'] }}</div>
                    <p class="module-stat-card__label">✅ Completed</p>
                </div>
                <div class="module-stat-card">
                    <div class="module-stat-card__number">{{ $stats['in_progress'] }}</div>
                    <p class="module-stat-card__label">⏳ In Progress</p>
                </div>
                <div class="module-stat-card">
                    <div class="module-stat-card__number">{{ $stats['progress'] }}%</div>
                    <p class="module-stat-card__label">📊 Progress</p>
                </div>
            </div>

            {{-- CASES LIST --}}
            <div class="cases-section">

                <div class="cases-section__header">
                    <h3 class="cases-section__title">
                        <span class="material-symbols-outlined">list</span>
                        Clinical Cases
                        <span style="font-weight:400;font-size:0.85rem;color:var(--color-text-muted);">
                            · {{ $cases->total() }} available
                        </span>
                    </h3>
                    <div class="cases-filter">
                        <button class="cases-filter__btn active" data-filter="all">All</button>
                        <button class="cases-filter__btn" data-filter="ct">CT Only</button>
                        <button class="cases-filter__btn" data-filter="mri">MRI Only</button>
                        <button class="cases-filter__btn" data-filter="completed">✅ Completed</button>
                        <button class="cases-filter__btn" data-filter="in-progress">⏳ In Progress</button>
                        <button class="cases-filter__btn" data-filter="not-started">Not Started</button>
                    </div>
                </div>

                @if($cases->count() > 0)
                    <div class="cases-list">
                        @foreach($cases as $case)
                            @php
                                $attempt = $case->userAttempt ?? null;
                                $status = $attempt ? ($attempt->is_correct ? 'completed' : 'in-progress') : 'not-started';
                            @endphp
                            <a href="{{ route('medpix.cases.show', $case->uid) }}"
                               class="case-item"
                               data-has-ct="{{ $case->ct_images_count > 0 ? '1' : '0' }}"
                               data-has-mri="{{ $case->mri_images_count > 0 ? '1' : '0' }}"
                               data-status="{{ $status }}">

                                <span class="case-item__uid">{{ $case->uid }}</span>

                                <span class="case-item__title">
                                    {{ $case->title ?? 'Untitled Case' }}
                                    <small>
                                        @if($case->patient_age)
                                            {{ $case->patient_age }}yo
                                        @endif
                                        @if($case->patient_gender && $case->patient_gender !== 'unknown')
                                            · {{ ucfirst($case->patient_gender) }}
                                        @endif
                                        @if($case->category)
                                            · {{ $case->category }}
                                        @endif
                                    </small>
                                </span>

                                <span class="case-item__meta">
                                    @if($status === 'completed')
                                        <span class="case-item__meta-item" style="color: var(--color-brand-green); font-weight: 600;">
                                            <span class="material-symbols-outlined">check_circle</span>
                                            Completed
                                        </span>
                                    @elseif($status === 'in-progress')
                                        <span class="case-item__meta-item" style="color: #e67e22; font-weight: 600;">
                                            <span class="material-symbols-outlined">pending</span>
                                            In Progress
                                        </span>
                                    @endif

                                    @if($case->ct_images_count > 0)
                                        <span class="case-item__meta-item">
                                            <span class="material-symbols-outlined">radiology</span>
                                            {{ $case->ct_images_count }} CT
                                        </span>
                                    @endif
                                    @if($case->mri_images_count > 0)
                                        <span class="case-item__meta-item">
                                            <span class="material-symbols-outlined">neurology</span>
                                            {{ $case->mri_images_count }} MRI
                                        </span>
                                    @endif
                                </span>

                                <span class="case-item__action">
                                    <span class="btn-view">
                                        View
                                        <span class="material-symbols-outlined">arrow_forward</span>
                                    </span>
                                </span>
                            </a>
                        @endforeach
                    </div>

                    {{-- PAGINATION --}}
                    @if($cases->hasPages())
                        <div class="pagination-wrapper">
                            <div class="custom-pagination">
                                @if ($cases->onFirstPage())
                                    <span class="page-btn page-btn--disabled">
                                        <span class="material-symbols-outlined">chevron_left</span>
                                    </span>
                                @else
                                    <a href="{{ $cases->previousPageUrl() }}" class="page-btn">
                                        <span class="material-symbols-outlined">chevron_left</span>
                                    </a>
                                @endif

                                @foreach ($cases->getUrlRange(1, $cases->lastPage()) as $page => $url)
                                    @if ($page == $cases->currentPage())
                                        <span class="page-btn page-btn--active">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if ($cases->hasMorePages())
                                    <a href="{{ $cases->nextPageUrl() }}" class="page-btn">
                                        <span class="material-symbols-outlined">chevron_right</span>
                                    </a>
                                @else
                                    <span class="page-btn page-btn--disabled">
                                        <span class="material-symbols-outlined">chevron_right</span>
                                    </span>
                                @endif
                            </div>

                            <div class="pagination-info">
                                Showing {{ $cases->firstItem() }} to {{ $cases->lastItem() }} of {{ $cases->total() }} results
                            </div>
                        </div>
                    @endif

                @else
                    <div class="no-cases">
                        <span class="material-symbols-outlined">description</span>
                        <h3>No Cases Available</h3>
                        <p>This module doesn't have any cases yet. Check back later!</p>
                    </div>
                @endif

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

        // FILTER CASES (CT / MRI / Status)
        document.querySelectorAll('.cases-filter__btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.cases-filter__btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filter = this.dataset.filter;
                const items = document.querySelectorAll('.case-item');

                items.forEach(item => {
                    const hasCT = item.dataset.hasCt === '1';
                    const hasMRI = item.dataset.hasMri === '1';
                    const status = item.dataset.status;

                    let show = false;
                    if (filter === 'all') show = true;
                    else if (filter === 'ct') show = hasCT;
                    else if (filter === 'mri') show = hasMRI;
                    else if (filter === 'completed') show = status === 'completed';
                    else if (filter === 'in-progress') show = status === 'in-progress';
                    else if (filter === 'not-started') show = status === 'not-started';

                    item.style.display = show ? 'grid' : 'none';
                });
            });
        });
    </script>

</body>
</html>