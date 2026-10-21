{{-- resources/views/modules.blade.php --}}
<!DOCTYPE html>
<html class="light" dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SINA - Modules</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        .modules-page {
            margin-top: 64px;
            padding: 32px 0 64px;
            min-height: calc(100vh - 64px);
            background: var(--color-bg-light);
            transition: background 0.3s;
        }
        .dark .modules-page { background: var(--color-primary-navy); }

        .modules-page__header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }

        .modules-page__title h1 {
            font-size: 1.8rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
        }
        .modules-page__title h1 .material-symbols-outlined {
            color: var(--color-primary-teal);
            font-size: 2rem;
        }
        .modules-page__title p {
            color: var(--color-text-secondary);
            margin: 4px 0 0;
            font-size: 0.95rem;
        }
        .dark .modules-page__title p { color: rgba(255, 255, 255, 0.5); }

        .modules-page__stats-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 14px;
            margin-bottom: 24px;
            padding: 16px 20px;
            background: var(--color-white);
            border-radius: var(--radius-xl);
            border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low);
        }
        .dark .modules-page__stats-bar {
            background: rgba(10, 22, 40, 0.4);
            border-color: rgba(255, 255, 255, 0.04);
        }

        .stat-item { display: flex; align-items: center; gap: 10px; }
        .stat-item .material-symbols-outlined {
            font-size: 1.6rem;
            color: var(--color-primary-teal);
        }
        .stat-item .stat-value {
            font-size: 1.3rem;
            font-weight: 800;
            display: block;
            line-height: 1.2;
        }
        .stat-item .stat-label {
            font-size: 0.7rem;
            color: var(--color-text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .dark .stat-item .stat-label { color: rgba(255, 255, 255, 0.4); }

        .modules-page__controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 24px;
            padding: 14px 18px;
            background: var(--color-white);
            border-radius: var(--radius-xl);
            border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low);
        }
        .dark .modules-page__controls {
            background: rgba(10, 22, 40, 0.4);
            border-color: rgba(255, 255, 255, 0.04);
        }

        .search-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--color-bg-light);
            border-radius: var(--radius-full);
            padding: 4px 16px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            flex: 1;
            min-width: 180px;
        }
        .dark .search-wrapper {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.06);
        }
        .search-wrapper .material-symbols-outlined {
            color: var(--color-text-muted);
            font-size: 1.2rem;
        }
        .search-wrapper input {
            border: none;
            background: transparent;
            padding: 8px 0;
            font-size: 0.9rem;
            outline: none;
            color: var(--color-text-primary);
            width: 100%;
        }
        .dark .search-wrapper input { color: var(--color-text-white); }
        .search-wrapper input::placeholder { color: var(--color-text-muted); }

        .control-group { display: flex; align-items: center; gap: 6px; }
        .control-group label {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--color-text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .dark .control-group label { color: rgba(255, 255, 255, 0.4); }
        .control-group select {
            padding: 6px 12px;
            border-radius: var(--radius-full);
            border: 1px solid rgba(0, 0, 0, 0.06);
            background: var(--color-bg-light);
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--color-text-primary);
            cursor: pointer;
            outline: none;
        }
        .dark .control-group select {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.06);
            color: var(--color-text-white);
        }

        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .module-card {
            background: var(--color-white);
            border-radius: var(--radius-xl);
            border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low);
            overflow: hidden;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            cursor: pointer;
            display: block;
        }
        .dark .module-card {
            background: rgba(10, 22, 40, 0.4);
            border-color: rgba(255, 255, 255, 0.04);
        }
        .module-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-card-hover);
        }

        .module-card__image-wrapper {
            position: relative;
            height: 160px;
            overflow: hidden;
            background: var(--color-bg-light);
        }
        .dark .module-card__image-wrapper { background: rgba(255, 255, 255, 0.02); }
        .module-card__image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .module-card:hover .module-card__image-wrapper img { transform: scale(1.03); }

        .module-card__image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--color-primary-teal), #0a8ba8);
            color: #fff;
        }
        .module-card__image-placeholder .material-symbols-outlined { font-size: 3rem; }

        .module-card__badge-overlay {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 3px 14px;
            border-radius: var(--radius-full);
            font-size: 0.6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #fff;
        }
        .module-card__badge-overlay--in-progress { background: #f39c12; }
        .module-card__badge-overlay--complete { background: var(--color-brand-green); }
        .module-card__badge-overlay--not-started { background: var(--color-text-muted); }

        .module-card__progress-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
        }
        .module-card__progress-overlay .progress-fill {
            height: 100%;
            background: var(--color-primary-teal);
            transition: width 0.5s ease;
        }

        .module-card__body { padding: 16px 20px 20px; }
        .module-card__title {
            font-size: 1rem;
            font-weight: 700;
            margin: 0 0 4px;
        }
        .module-card__desc {
            font-size: 0.8rem;
            color: var(--color-text-secondary);
            margin: 0 0 12px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .dark .module-card__desc { color: rgba(255, 255, 255, 0.4); }

        .module-card__progress-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            margin-bottom: 6px;
        }
        .module-card__progress-info .cases-count {
            display: flex;
            align-items: center;
            gap: 4px;
            color: var(--color-text-secondary);
        }
        .module-card__progress-info .cases-count .material-symbols-outlined { font-size: 1rem; }
        .module-card__progress-info .percentage {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--color-primary-teal);
        }
        .dark .module-card__progress-info .percentage { color: #5dd0e8; }

        .module-card__progress-bar {
            height: 4px;
            background: rgba(0, 0, 0, 0.06);
            border-radius: var(--radius-full);
            overflow: hidden;
            margin-bottom: 14px;
        }
        .dark .module-card__progress-bar { background: rgba(255, 255, 255, 0.06); }
        .module-card__progress-bar .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--color-primary-teal), #0a8ba8);
            border-radius: var(--radius-full);
            transition: width 0.5s ease;
        }

        .module-card__actions { display: flex; gap: 8px; }
        .module-card__actions .btn {
            flex: 1;
            justify-content: center;
            padding: 6px 12px;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: var(--radius-full);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            position: relative;
            z-index: 2;
        }
        .module-card__actions .btn--primary {
            background: linear-gradient(135deg, var(--color-primary-teal), #0a8ba8) !important;
            color: #fff !important;
        }
        .module-card__actions .btn--primary:hover {
            transform: scale(1.02);
            box-shadow: var(--shadow-glow-teal);
        }
        .module-card__actions .btn--outline {
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            color: var(--color-text-secondary) !important;
            background: transparent !important;
        }
        .module-card__actions .btn--outline:hover {
            border-color: var(--color-primary-teal) !important;
            color: var(--color-primary-teal) !important;
        }

        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            color: var(--color-text-muted);
        }
        .empty-state .material-symbols-outlined {
            font-size: 4rem;
            display: block;
            margin-bottom: 12px;
        }

        @media (max-width: 768px) {
            .modules-page__header { flex-direction: column; align-items: stretch; }
            .modules-page__controls { flex-direction: column; align-items: stretch; }
            .search-wrapper { min-width: auto; }
            .control-group select { width: 100%; }
            .modules-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 480px) {
            .modules-grid { grid-template-columns: 1fr; }
            .modules-page__title h1 { font-size: 1.4rem; }
            .modules-page__stats-bar { grid-template-columns: 1fr 1fr; }
            .stat-item .stat-value { font-size: 1.1rem; }
        }
    </style>
</head>
<body>

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

    <main class="modules-page">
        <div class="container">

            <div class="modules-page__header">
                <div class="modules-page__title">
                    <h1>
                        <span class="material-symbols-outlined">menu_book</span>
                        Clinical Modules
                    </h1>
                    <p>Master each body system through interactive clinical cases</p>
                </div>
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="{{ route('random.case') }}" class="btn btn--primary" style="gap: 8px;">
                        <span class="material-symbols-outlined">shuffle</span>
                        Random Case
                    </a>
                </div>
            </div>

            <div class="modules-page__stats-bar">
                <div class="stat-item">
                    <span class="material-symbols-outlined">assignment</span>
                    <div>
                        <span class="stat-value">{{ $stats['total'] }}</span>
                        <span class="stat-label">Total Modules</span>
                    </div>
                </div>
                <div class="stat-item">
                    <span class="material-symbols-outlined">check_circle</span>
                    <div>
                        <span class="stat-value">{{ $stats['completed'] }}</span>
                        <span class="stat-label">Completed</span>
                    </div>
                </div>
                <div class="stat-item">
                    <span class="material-symbols-outlined">pending</span>
                    <div>
                        <span class="stat-value">{{ $stats['in_progress'] }}</span>
                        <span class="stat-label">In Progress</span>
                    </div>
                </div>
                <div class="stat-item">
                    <span class="material-symbols-outlined">trending_up</span>
                    <div>
                        <span class="stat-value">{{ $stats['progress'] }}%</span>
                        <span class="stat-label">Overall Progress</span>
                    </div>
                </div>
            </div>

            <div class="modules-page__controls">
                <div class="search-wrapper">
                    <span class="material-symbols-outlined">search</span>
                    <input type="text" placeholder="Search modules..." id="searchModules">
                </div>

                <div class="control-group">
                    <label for="filterStatus">Status</label>
                    <select id="filterStatus">
                        <option value="all">All Modules</option>
                        <option value="completed">Completed</option>
                        <option value="in-progress">In Progress</option>
                        <option value="not-started">Not Started</option>
                    </select>
                </div>

                <div class="control-group">
                    <label for="sortBy">Sort By</label>
                    <select id="sortBy">
                        <option value="progress">Progress (Low to High)</option>
                        <option value="progress-desc">Progress (High to Low)</option>
                        <option value="name">Name A-Z</option>
                        <option value="cases">Cases Count</option>
                    </select>
                </div>
            </div>

            <div class="modules-grid" id="modulesGrid">
                @forelse ($modules as $module)
                    <div class="module-card"
                         data-name="{{ strtolower($module->name) }}"
                         data-cases="{{ $module->medpix_cases_count }}"
                         data-progress="{{ $module->progress_percentage }}"
                         data-status="{{ $module->status }}">

                        <a href="{{ route('modules.show', ['slug' => $module->slug]) }}" style="text-decoration: none; color: inherit; display: block;">
                            <div class="module-card__image-wrapper">
                                @if ($module->image && file_exists(public_path('assets/img/modules/' . $module->image)))
                                    <img src="{{ asset('assets/img/modules/' . $module->image) }}" alt="{{ $module->name }}">
                                @else
                                    <div class="module-card__image-placeholder">
                                        <span class="material-symbols-outlined">{{ $module->icon ?? 'medical_services' }}</span>
                                    </div>
                                @endif

                                {{-- Badge حسب الحالة --}}
                                @if($module->status === 'completed')
                                    <span class="module-card__badge-overlay module-card__badge-overlay--complete">✅ Completed</span>
                                @elseif($module->status === 'in-progress')
                                    <span class="module-card__badge-overlay module-card__badge-overlay--in-progress">⏳ In Progress</span>
                                @else
                                    <span class="module-card__badge-overlay module-card__badge-overlay--not-started">Not Started</span>
                                @endif

                                <div class="module-card__progress-overlay">
                                    <div class="progress-fill" style="width: {{ $module->progress_percentage }}%;"></div>
                                </div>
                            </div>
                            <div class="module-card__body">
                                <h3 class="module-card__title">{{ $module->name }}</h3>
                                <p class="module-card__desc">{{ $module->description }}</p>
                                <div class="module-card__progress-info">
                                    <span class="cases-count">
                                        <span class="material-symbols-outlined">description</span>
                                        {{ $module->solved_count }} / {{ $module->medpix_cases_count }} cases
                                    </span>
                                    <span class="percentage">{{ $module->progress_percentage }}%</span>
                                </div>
                                <div class="module-card__progress-bar">
                                    <div class="progress-fill" style="width: {{ $module->progress_percentage }}%;"></div>
                                </div>
                            </div>
                        </a>
                        <div class="module-card__body" style="padding-top: 0;">
                            <div class="module-card__actions">
                                <a href="{{ route('modules.show', ['slug' => $module->slug]) }}" class="btn btn--primary btn--sm">Start</a>
                                <a href="{{ route('modules.show', ['slug' => $module->slug]) }}" class="btn btn--outline btn--sm">Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <span class="material-symbols-outlined">inbox</span>
                        <p>No modules available yet.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </main>

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

        // SEARCH + FILTER + SORT
        const searchInput = document.getElementById('searchModules');
        const filterStatus = document.getElementById('filterStatus');
        const sortBy = document.getElementById('sortBy');
        const modulesGrid = document.getElementById('modulesGrid');

        function applyFiltersAndSort() {
            const searchValue = searchInput.value.toLowerCase().trim();
            const statusValue = filterStatus.value;
            const sortValue = sortBy.value;

            let cards = Array.from(modulesGrid.querySelectorAll('.module-card'));

            // 1. Filter by search + status
            cards.forEach(card => {
                const name = card.dataset.name;
                const status = card.dataset.status;

                let matchesSearch = !searchValue || name.includes(searchValue);
                let matchesStatus = statusValue === 'all' || status === statusValue;

                card.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
            });

            // 2. Sort visible cards
            const visibleCards = cards.filter(c => c.style.display !== 'none');

            visibleCards.sort((a, b) => {
                if (sortValue === 'name') {
                    return a.dataset.name.localeCompare(b.dataset.name);
                } else if (sortValue === 'cases') {
                    return parseInt(b.dataset.cases) - parseInt(a.dataset.cases);
                } else if (sortValue === 'progress') {
                    return parseInt(a.dataset.progress) - parseInt(b.dataset.progress);
                } else if (sortValue === 'progress-desc') {
                    return parseInt(b.dataset.progress) - parseInt(a.dataset.progress);
                }
                return 0;
            });

            visibleCards.forEach(card => modulesGrid.appendChild(card));
        }

        searchInput.addEventListener('input', applyFiltersAndSort);
        filterStatus.addEventListener('change', applyFiltersAndSort);
        sortBy.addEventListener('change', applyFiltersAndSort);
    </script>

</body>
</html>