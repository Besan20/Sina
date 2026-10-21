{{-- resources/views/medpix/case.blade.php --}}
<!DOCTYPE html>
<html class="light" dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SINA - {{ $case->title }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        body { font-size: 18px; }
        .case-page {
            margin-top: 64px;
            padding: 20px 0 40px;
            min-height: calc(100vh - 64px);
            background: var(--color-bg-light);
            transition: background 0.3s;
        }
        .dark .case-page { background: var(--color-primary-navy); }

        .case-breadcrumb {
            display: flex; align-items: center; gap: 8px;
            font-size: 0.95rem; color: var(--color-text-secondary);
            margin-bottom: 18px; flex-wrap: wrap;
        }
        .dark .case-breadcrumb { color: rgba(255, 255, 255, 0.4); }
        .case-breadcrumb a { color: var(--color-primary-teal); text-decoration: none; font-weight: 500; }
        .case-breadcrumb a:hover { text-decoration: underline; }
        .case-breadcrumb .material-symbols-outlined { font-size: 1.1rem; }

        .case-header {
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 16px; margin-bottom: 22px;
            background: var(--color-white); border-radius: var(--radius-xl);
            padding: 16px 28px; border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low);
        }
        .dark .case-header { background: rgba(10, 22, 40, 0.4); border-color: rgba(255, 255, 255, 0.04); }
        .case-header__info h2 { font-size: 1.4rem; font-weight: 700; margin: 0 0 4px; }
        .case-header__info p { color: var(--color-text-secondary); font-size: 0.9rem; margin: 0; }
        .dark .case-header__info p { color: rgba(255, 255, 255, 0.5); }

        .case-timer {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 20px 8px 16px; border-radius: var(--radius-full);
            background: rgba(0, 180, 216, 0.05); border: 1px solid rgba(0, 180, 216, 0.1);
        }
        .case-timer.warning {
            background: rgba(253, 121, 168, 0.1);
            border-color: var(--color-brand-pink);
            animation: pulse-timer 1s infinite;
        }
        @keyframes pulse-timer { 0%, 100% { opacity: 1; } 50% { opacity: 0.6; } }
        .case-timer .material-symbols-outlined { font-size: 1.5rem; color: var(--color-primary-teal); }
        .case-timer.warning .material-symbols-outlined { color: var(--color-brand-pink); }
        .case-timer__time {
            font-size: 1.7rem; font-weight: 800; color: var(--color-primary-teal);
            font-variant-numeric: tabular-nums; min-width: 60px;
            text-align: center; letter-spacing: 0.5px;
        }
        .case-timer.warning .case-timer__time { color: var(--color-brand-pink); }
        .case-timer__label {
            font-size: 0.7rem; color: var(--color-text-muted);
            text-transform: uppercase; letter-spacing: 0.04em; font-weight: 600;
        }

        .timer-warning-overlay {
            position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
            background: rgba(253, 121, 168, 0.95); color: #fff;
            padding: 24px 48px; border-radius: var(--radius-xl);
            font-size: 1.3rem; font-weight: 700; z-index: 9999;
            text-align: center; animation: fadeIn 0.3s ease;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3); backdrop-filter: blur(4px);
        }
        .timer-warning-overlay small { font-weight: 400; font-size: 0.9rem; display: block; margin-top: 6px; opacity: 0.8; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translate(-50%, -50%) scale(0.9); }
            to { opacity: 1; transform: translate(-50%, -50%) scale(1); }
        }

        .case-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .case-info { order: 1; }
        .work-area { order: 2; }
        @media (max-width: 1024px) {
            .case-grid { grid-template-columns: 1fr; }
            .case-info { order: 1; }
            .work-area { order: 2; }
        }

        .case-info { display: flex; flex-direction: column; gap: 16px; }
        .info-card {
            background: var(--color-white); border-radius: var(--radius-xl);
            padding: 18px 22px; border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low); transition: all 0.3s ease;
        }
        .dark .info-card { background: rgba(10, 22, 40, 0.4); border-color: rgba(255, 255, 255, 0.04); }
        .info-card:hover { box-shadow: var(--shadow-card-hover); }
        .info-card__header {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 12px;
        }
        .info-card__title {
            font-weight: 700; font-size: 1rem; display: flex;
            align-items: center; gap: 8px; color: var(--color-text-primary);
        }
        .info-card__title .material-symbols-outlined { color: var(--color-primary-teal); font-size: 1.3rem; }
        .info-card__avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: linear-gradient(135deg, var(--color-primary-teal), #0a8ba8);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1rem; font-weight: 700; flex-shrink: 0;
        }
        .info-card__details { display: grid; grid-template-columns: 1fr 1fr; gap: 10px 16px; }
        .info-card__detail { display: flex; flex-direction: column; }
        .info-card__detail .label {
            font-size: 0.65rem; text-transform: uppercase;
            letter-spacing: 0.04em; color: var(--color-text-muted);
            font-weight: 600; margin-bottom: 2px;
        }
        .info-card__detail .value {
            font-weight: 600; font-size: 0.95rem; color: var(--color-text-primary);
        }
        .dark .info-card__detail .value { color: var(--color-text-white); }
        .info-card__detail .value .highlight { color: var(--color-brand-pink); }

        .hpi-content {
            background: rgba(0, 180, 216, 0.03); border-radius: var(--radius-lg);
            padding: 14px 18px; border-left: 3px solid var(--color-primary-teal);
            max-height: 200px; overflow-y: auto;
        }
        .hpi-content::-webkit-scrollbar { width: 4px; }
        .hpi-content::-webkit-scrollbar-thumb { background: var(--color-primary-teal); border-radius: 4px; }
        .hpi-content .hpi-text {
            margin: 0; line-height: 1.9; font-size: 1rem;
            white-space: pre-wrap; word-wrap: break-word;
            color: var(--color-text-primary);
        }
        .dark .hpi-content .hpi-text { color: rgba(255, 255, 255, 0.85); }

        .attachments-card {
            background: var(--color-white); border-radius: var(--radius-xl);
            padding: 18px 22px; border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low); transition: all 0.3s ease;
            display: none;
        }
        .attachments-card.show { display: block; }
        .dark .attachments-card { background: rgba(10, 22, 40, 0.4); border-color: rgba(255, 255, 255, 0.04); }
        .attachments-card__header {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 10px;
        }
        .attachments-card__title {
            font-weight: 700; font-size: 1rem; display: flex;
            align-items: center; gap: 8px; color: var(--color-text-primary);
        }
        .attachments-card__title .material-symbols-outlined { color: var(--color-primary-teal); font-size: 1.3rem; }
        .attachments-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
        }
        .attachment-item {
            background: rgba(0, 0, 0, 0.02); border-radius: var(--radius-lg);
            padding: 6px; text-align: center;
            border: 1px solid rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease; cursor: pointer;
        }
        .dark .attachment-item { background: rgba(255, 255, 255, 0.03); border-color: rgba(255, 255, 255, 0.04); }
        .attachment-item:hover { transform: translateY(-2px); box-shadow: var(--shadow-card-hover); border-color: var(--color-primary-teal); }
        .attachment-item img { width: 100%; height: 100px; object-fit: cover; border-radius: var(--radius-sm); background: var(--color-bg-light); }
        .attachment-item__label { font-size: 0.7rem; color: var(--color-text-muted); margin-top: 4px; }

        .image-modal {
            display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.85); z-index: 9999;
            align-items: center; justify-content: center;
            padding: 20px; backdrop-filter: blur(4px);
        }
        .image-modal.open { display: flex; }
        .image-modal__content { position: relative; max-width: 90%; max-height: 90%; }
        .image-modal__close {
            position: absolute; top: -36px; right: 0;
            background: none; border: none; color: #fff;
            font-size: 1.8rem; cursor: pointer; padding: 0 8px;
            transition: transform 0.2s;
        }
        .image-modal__close:hover { transform: scale(1.2); }
        .image-modal__image { max-width: 100%; max-height: 85vh; border-radius: var(--radius-lg); box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5); }
        .image-modal__caption { color: rgba(255, 255, 255, 0.5); text-align: center; margin-top: 8px; font-size: 0.85rem; }

        .work-area { display: flex; flex-direction: column; gap: 16px; }
        .diagnosis-area {
            background: var(--color-white); border-radius: var(--radius-xl);
            padding: 18px 22px; border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low);
        }
        .dark .diagnosis-area { background: rgba(10, 22, 40, 0.4); border-color: rgba(255, 255, 255, 0.04); }
        .diagnosis-area__label {
            font-weight: 700; font-size: 1rem; display: flex;
            align-items: center; gap: 8px; margin-bottom: 10px;
        }
        .diagnosis-area__label .material-symbols-outlined { color: var(--color-primary-teal); font-size: 1.3rem; }
        .diagnosis-area input {
            width: 100%; padding: 14px 18px;
            border: 1px solid rgba(0, 0, 0, 0.08); border-radius: var(--radius-lg);
            font-size: 1rem; background: var(--color-bg-light);
            transition: all 0.3s ease; color: var(--color-text-primary);
        }
        .dark .diagnosis-area input {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.06);
            color: var(--color-text-white);
        }
        .diagnosis-area input:focus {
            outline: none; border-color: var(--color-primary-teal);
            box-shadow: 0 0 0 3px rgba(0, 180, 216, 0.1);
        }
        .diagnosis-area input::placeholder { color: var(--color-text-muted); font-size: 0.95rem; }

        .orders-tabs {
            background: var(--color-white); border-radius: var(--radius-xl);
            border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low); overflow: hidden;
        }
        .dark .orders-tabs { background: rgba(10, 22, 40, 0.4); border-color: rgba(255, 255, 255, 0.04); }
        .orders-tabs__header-label {
            padding: 12px 20px 4px; font-size: 0.8rem;
            font-weight: 600; color: var(--color-text-muted);
            text-transform: uppercase; letter-spacing: 0.04em;
        }
        .orders-tabs__headers {
            display: grid; grid-template-columns: repeat(4, 1fr);
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            background: rgba(0, 0, 0, 0.01);
        }
        .dark .orders-tabs__headers { border-bottom-color: rgba(255, 255, 255, 0.04); background: rgba(255, 255, 255, 0.01); }
        .orders-tabs__header {
            padding: 12px 6px; text-align: center;
            font-size: 0.85rem; font-weight: 600; cursor: pointer;
            transition: all 0.2s ease; color: var(--color-text-secondary);
            border-bottom: 2px solid transparent;
            display: flex; align-items: center; justify-content: center; gap: 6px;
        }
        .dark .orders-tabs__header { color: rgba(255, 255, 255, 0.4); }
        .orders-tabs__header:hover { background: rgba(0, 180, 216, 0.04); }
        .orders-tabs__header.active {
            color: var(--color-primary-teal);
            border-bottom-color: var(--color-primary-teal);
            background: rgba(0, 180, 216, 0.02);
        }
        .orders-tabs__header .material-symbols-outlined { font-size: 1.1rem; }
        .orders-tabs__body { padding: 12px 16px; max-height: 220px; overflow-y: auto; }
        .orders-tabs__body::-webkit-scrollbar { width: 4px; }
        .orders-tabs__body::-webkit-scrollbar-thumb { background: var(--color-primary-teal); border-radius: 4px; }
        .orders-tabs__panel { display: none; }
        .orders-tabs__panel.active { display: block; }

        .order-item {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 10px; border-radius: var(--radius-lg);
            transition: all 0.2s ease; cursor: pointer;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
        }
        .dark .order-item { border-bottom-color: rgba(255, 255, 255, 0.03); }
        .order-item:last-child { border-bottom: none; }
        .order-item:hover { background: rgba(0, 180, 216, 0.04); }
        .order-item input[type="checkbox"] {
            width: 18px; height: 18px;
            accent-color: var(--color-primary-teal);
            cursor: pointer; flex-shrink: 0;
        }
        .order-item__label { font-size: 0.95rem; font-weight: 500; flex: 1; }
        .order-item__category {
            font-size: 0.65rem; color: var(--color-text-muted);
            text-transform: uppercase; letter-spacing: 0.04em;
            padding: 3px 10px; border-radius: var(--radius-full);
            background: rgba(0, 0, 0, 0.04); font-weight: 600; white-space: nowrap;
        }
        .dark .order-item__category { background: rgba(255, 255, 255, 0.04); }
        .order-item--selected { background: rgba(0, 180, 216, 0.06); }

        .order-basket {
            background: var(--color-white); border-radius: var(--radius-xl);
            padding: 14px 18px; border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--shadow-ambient-low);
        }
        .dark .order-basket { background: rgba(10, 22, 40, 0.4); border-color: rgba(255, 255, 255, 0.04); }
        .order-basket__header {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 8px;
        }
        .order-basket__title {
            font-weight: 700; font-size: 0.95rem;
            display: flex; align-items: center; gap: 8px;
        }
        .order-basket__title .material-symbols-outlined { color: var(--color-primary-teal); font-size: 1.2rem; }
        .order-basket__count {
            font-size: 0.75rem; padding: 3px 12px;
            border-radius: var(--radius-full);
            background: var(--color-primary-teal);
            color: #fff; font-weight: 700;
        }
        .order-basket__items { display: flex; flex-wrap: wrap; gap: 6px; min-height: 24px; }
        .order-basket__item {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 4px 10px 4px 6px; border-radius: var(--radius-full);
            font-size: 0.8rem; font-weight: 500;
            background: rgba(0, 180, 216, 0.08); color: var(--color-primary-teal);
        }
        .order-basket__item .remove-btn {
            cursor: pointer; font-size: 0.85rem; line-height: 1;
            opacity: 0.4; transition: opacity 0.2s;
            background: none; border: none; color: inherit; padding: 0 4px;
        }
        .order-basket__item .remove-btn:hover { opacity: 1; }
        .order-basket__empty { color: var(--color-text-muted); font-size: 0.9rem; }

        .notes-area textarea {
            width: 100%; padding: 10px 16px;
            border: 1px solid rgba(0, 0, 0, 0.08); border-radius: var(--radius-lg);
            font-size: 0.95rem; font-family: inherit;
            resize: vertical; min-height: 60px;
            background: var(--color-bg-light);
            transition: all 0.3s ease; color: var(--color-text-primary);
        }
        .dark .notes-area textarea {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.06);
            color: var(--color-text-white);
        }
        .notes-area textarea:focus {
            outline: none; border-color: var(--color-primary-teal);
            box-shadow: 0 0 0 3px rgba(0, 180, 216, 0.1);
        }
        .notes-area textarea::placeholder { color: var(--color-text-muted); font-size: 0.9rem; }

        .submit-area { display: flex; gap: 10px; flex-wrap: wrap; }
        .btn--submit {
            background: linear-gradient(135deg, var(--color-primary-teal), #0a8ba8) !important;
            color: #fff !important; border: none !important;
            padding: 12px 28px; font-weight: 700; font-size: 0.95rem;
            gap: 8px; flex: 1; min-width: 140px;
            border-radius: var(--radius-full); transition: all 0.3s ease;
            cursor: pointer;
        }
        .btn--submit:hover { transform: scale(1.02); box-shadow: var(--shadow-glow-teal); }
        .btn--submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .btn--reset {
            border-color: var(--color-text-muted) !important;
            color: var(--color-text-secondary) !important;
            border-radius: var(--radius-full); padding: 12px 22px; font-size: 0.9rem;
        }
        .btn--reset:hover { background: rgba(0, 0, 0, 0.04); }

        /* Loading Overlay (بسيط) */
        .loading-overlay {
            position: fixed; inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            display: none; flex-direction: column;
            align-items: center; justify-content: center;
            z-index: 9998; gap: 20px;
        }
        .loading-overlay.show { display: flex; }
        .loading-spinner {
            width: 64px; height: 64px;
            border: 5px solid rgba(255, 255, 255, 0.2);
            border-top-color: var(--color-primary-teal);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .loading-text {
            color: #fff; font-size: 1.1rem; font-weight: 600; text-align: center;
        }

        @media (max-width: 992px) {
            .case-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            body { font-size: 16px; }
            .case-header { flex-direction: column; align-items: stretch; padding: 14px 18px; }
            .case-header__info h2 { font-size: 1.2rem; }
            .case-timer { justify-content: center; padding: 6px 14px; }
            .case-timer__time { font-size: 1.4rem; min-width: 50px; }
            .case-timer .material-symbols-outlined { font-size: 1.2rem; }
            .info-card__details { grid-template-columns: 1fr; }
            .orders-tabs__headers { grid-template-columns: 1fr 1fr; }
            .diagnosis-area input { padding: 10px 14px; font-size: 0.95rem; }
            .attachments-grid { grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); }
            .attachment-item img { height: 80px; }
        }
        @media (max-width: 480px) {
            .orders-tabs__headers { grid-template-columns: 1fr 1fr; }
            .btn--submit { min-width: 100%; }
            .btn--reset { width: 100%; justify-content: center; }
            .submit-area { flex-direction: column; }
            .case-timer__time { font-size: 1.1rem; min-width: 42px; }
            .case-timer { padding: 4px 10px; gap: 6px; }
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
            <button class="header__menu-btn" id="mobileMenuToggle" aria-label="Toggle menu">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </header>

    {{-- MAIN --}}
    <main class="case-page">
        <div class="container">

            {{-- BREADCRUMB --}}
            <div class="case-breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <span class="material-symbols-outlined">chevron_right</span>
                <a href="{{ route('modules.index') }}">Modules</a>
                <span class="material-symbols-outlined">chevron_right</span>
                @if($case->module)
                    <a href="{{ route('modules.show', ['slug' => $case->module->slug]) }}">{{ $case->module->name }}</a>
                    <span class="material-symbols-outlined">chevron_right</span>
                @endif
                <span style="color: var(--color-text-primary); font-weight: 600;">{{ Str::limit($case->title, 30) }}</span>
            </div>

            {{-- CASE HEADER --}}
            <div class="case-header">
                <div class="case-header__info">
                    <h2>{{ Str::limit($case->title, 40) }}</h2>
                    <p>{{ $case->module->name ?? 'General' }} · UID: {{ $case->uid }} · ⏱️ 120s</p>
                </div>
                <div class="case-timer" id="timerContainer">
                    <span class="material-symbols-outlined">timer</span>
                    <span class="case-timer__time" id="timerDisplay">02:00</span>
                    <span class="case-timer__label">Remaining</span>
                </div>
            </div>

            {{-- MAIN GRID --}}
            <div class="case-grid">

                {{-- LEFT COLUMN - Case Info --}}
                <div class="case-info">

                    {{-- Patient Information --}}
                    <div class="info-card">
                        <div class="info-card__header">
                            <div class="info-card__title">
                                <span class="material-symbols-outlined">person</span>
                                Patient Information
                            </div>
                            <div class="info-card__avatar">P</div>
                        </div>
                        <div class="info-card__details">
                            <div class="info-card__detail">
                                <span class="label">Age & Gender</span>
                                <span class="value">{{ $case->patient_age ?? 'N/A' }} years · {{ ucfirst($case->patient_gender ?? 'N/A') }}</span>
                            </div>
                            <div class="info-card__detail">
                                <span class="label">UID</span>
                                <span class="value"><span class="highlight">{{ $case->uid }}</span></span>
                            </div>
                            <div class="info-card__detail">
                                <span class="label">Category</span>
                                <span class="value">{{ $case->category ?? 'Not specified' }}</span>
                            </div>
                            <div class="info-card__detail">
                                <span class="label">Module</span>
                                <span class="value">{{ $case->module->name ?? 'General' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- History --}}
                    @if($case->history)
                        <div class="info-card">
                            <div class="info-card__header">
                                <div class="info-card__title">
                                    <span class="material-symbols-outlined">history</span>
                                    History
                                </div>
                            </div>
                            <div class="hpi-content">
                                <p class="hpi-text">{!! nl2br(e($case->history)) !!}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Exam --}}
                    @if($case->exam)
                        <div class="info-card">
                            <div class="info-card__header">
                                <div class="info-card__title">
                                    <span class="material-symbols-outlined">stethoscope</span>
                                    Exam
                                </div>
                            </div>
                            <div class="hpi-content">
                                <p class="hpi-text">{!! nl2br(e($case->exam)) !!}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Findings --}}
                    @if($case->findings)
                        <div class="info-card">
                            <div class="info-card__header">
                                <div class="info-card__title">
                                    <span class="material-symbols-outlined">radiology</span>
                                    Findings
                                </div>
                            </div>
                            <div class="hpi-content">
                                <p class="hpi-text">{!! nl2br(e($case->findings)) !!}</p>
                            </div>
                        </div>
                    @endif

                    {{-- IMAGES --}}
                    @if($case->images->count() > 0)
                        <div class="attachments-card" id="attachmentsCard">
                            <div class="attachments-card__header">
                                <div class="attachments-card__title">
                                    <span class="material-symbols-outlined">image</span>
                                    Medical Images
                                    <span style="font-size:0.75rem;font-weight:400;color:var(--color-text-muted);">
                                        ({{ $case->images->count() }})
                                    </span>
                                </div>
                            </div>
                            <div class="attachments-grid">
                                @foreach($case->images->take(6) as $image)
                                    @php
                                        $extensions = ['.png', '.jpg', '.jpeg', '.gif'];
                                        $imagePath = null;
                                        foreach ($extensions as $ext) {
                                            $path = 'assets/img/cases/' . $image->image_name . $ext;
                                            if (file_exists(public_path($path))) {
                                                $imagePath = $path;
                                                break;
                                            }
                                        }
                                    @endphp

                                    @if($imagePath)
                                        <div class="attachment-item" onclick="openImageModal('{{ asset($imagePath) }}')">
                                            <img src="{{ asset($imagePath) }}" alt="{{ $image->image_name }}">
                                            <div class="attachment-item__label">{{ $image->image_type ?? 'Image' }}</div>
                                        </div>
                                    @else
                                        <div class="attachment-item" style="opacity:0.4;cursor:default;">
                                            <div style="height:100px;display:flex;align-items:center;justify-content:center;background:var(--color-bg-light);border-radius:var(--radius-sm);">
                                                <span class="material-symbols-outlined" style="font-size:2rem;color:var(--color-text-muted);">image_not_supported</span>
                                            </div>
                                            <div class="attachment-item__label">{{ $image->image_type ?? 'Image' }}</div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="info-card" id="noImagesMessage" style="text-align:center;padding:16px;color:var(--color-text-muted);display:block;">
                        <span class="material-symbols-outlined" style="font-size:2.2rem;display:block;margin-bottom:6px;">image_search</span>
                        <p style="margin:0;font-size:0.9rem;">Order imaging studies from the <strong>Imaging</strong> tab to view images</p>
                    </div>

                </div>

                {{-- RIGHT COLUMN - Work Area --}}
                <div class="work-area">

                    {{-- Diagnosis Input --}}
                    <div class="diagnosis-area">
                        <div class="diagnosis-area__label">
                            <span class="material-symbols-outlined">diagnosis</span>
                            Final Diagnosis
                        </div>
                        <input type="text" id="diagnosisInput" placeholder="Type your final diagnosis here..." />
                    </div>

                    {{-- Orders Tabs --}}
                    <div class="orders-tabs">
                        <div class="orders-tabs__header-label">📋 Orders & Investigations</div>
                        <div class="orders-tabs__headers">
                            <div class="orders-tabs__header active" data-tab="medications">
                                <span class="material-symbols-outlined">medication</span>
                                Meds
                            </div>
                            <div class="orders-tabs__header" data-tab="labs">
                                <span class="material-symbols-outlined">science</span>
                                Labs
                            </div>
                            <div class="orders-tabs__header" data-tab="imaging">
                                <span class="material-symbols-outlined">image</span>
                                Imaging
                            </div>
                            <div class="orders-tabs__header" data-tab="procedures">
                                <span class="material-symbols-outlined">emergency</span>
                                Procedures
                            </div>
                        </div>

                        <div class="orders-tabs__body">
                            <div class="orders-tabs__panel active" id="panel-medications">
                                <div class="order-item" data-order="Aspirin 300mg chewed">
                                    <input type="checkbox" class="order-checkbox" />
                                    <span class="order-item__label">Aspirin 300mg (chewed)</span>
                                    <span class="order-item__category">Antiplatelet</span>
                                </div>
                                <div class="order-item" data-order="Morphine 2-5mg IV">
                                    <input type="checkbox" class="order-checkbox" />
                                    <span class="order-item__label">Morphine 2-5mg IV</span>
                                    <span class="order-item__category">Analgesic</span>
                                </div>
                                <div class="order-item" data-order="Nitroglycerin SL 0.4mg">
                                    <input type="checkbox" class="order-checkbox" />
                                    <span class="order-item__label">Nitroglycerin SL 0.4mg</span>
                                    <span class="order-item__category">Vasodilator</span>
                                </div>
                                <div class="order-item" data-order="Oxygen 4L/min via nasal cannula">
                                    <input type="checkbox" class="order-checkbox" />
                                    <span class="order-item__label">Oxygen 4L/min</span>
                                    <span class="order-item__category">Support</span>
                                </div>
                            </div>

                            <div class="orders-tabs__panel" id="panel-labs">
                                <div class="order-item" data-order="Troponin I">
                                    <input type="checkbox" class="order-checkbox" />
                                    <span class="order-item__label">Troponin I</span>
                                    <span class="order-item__category">Cardiac</span>
                                </div>
                                <div class="order-item" data-order="Complete Blood Count (CBC)">
                                    <input type="checkbox" class="order-checkbox" />
                                    <span class="order-item__label">Complete Blood Count</span>
                                    <span class="order-item__category">Hematology</span>
                                </div>
                                <div class="order-item" data-order="Basic Metabolic Panel (BMP)">
                                    <input type="checkbox" class="order-checkbox" />
                                    <span class="order-item__label">Basic Metabolic Panel</span>
                                    <span class="order-item__category">Chemistry</span>
                                </div>
                            </div>

                            <div class="orders-tabs__panel" id="panel-imaging">
                                <div class="order-item" data-order="CT Scan Image">
                                    <input type="checkbox" class="order-checkbox" />
                                    <span class="order-item__label">📷 CT Scan</span>
                                    <span class="order-item__category">Advanced</span>
                                </div>
                                <div class="order-item" data-order="MRI Image">
                                    <input type="checkbox" class="order-checkbox" />
                                    <span class="order-item__label">📷 MRI</span>
                                    <span class="order-item__category">Advanced</span>
                                </div>
                                <div class="order-item" data-order="Chest X-Ray Image">
                                    <input type="checkbox" class="order-checkbox" />
                                    <span class="order-item__label">📷 Chest X-Ray</span>
                                    <span class="order-item__category">Radiology</span>
                                </div>
                            </div>

                            <div class="orders-tabs__panel" id="panel-procedures">
                                <div class="order-item" data-order="NPO (Nothing by mouth)">
                                    <input type="checkbox" class="order-checkbox" />
                                    <span class="order-item__label">NPO</span>
                                    <span class="order-item__category">Prep</span>
                                </div>
                                <div class="order-item" data-order="Insertion of arterial line">
                                    <input type="checkbox" class="order-checkbox" />
                                    <span class="order-item__label">Arterial Line</span>
                                    <span class="order-item__category">Monitoring</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Order Basket --}}
                    <div class="order-basket">
                        <div class="order-basket__header">
                            <div class="order-basket__title">
                                <span class="material-symbols-outlined">shopping_cart</span>
                                Order Basket
                            </div>
                            <span class="order-basket__count" id="orderCount">0</span>
                        </div>
                        <div class="order-basket__items" id="orderBasket">
                            <span class="order-basket__empty">No orders selected</span>
                        </div>
                    </div>

                    {{-- Treatment Plan --}}
                    <div class="diagnosis-area notes-area">
                        <div class="diagnosis-area__label">
                            <span class="material-symbols-outlined">note</span>
                            Treatment Plan & Notes
                        </div>
                        <textarea id="notesInput" placeholder="Write your treatment plan and observations..."></textarea>
                    </div>

                    {{-- Submit --}}
                    <div class="submit-area">
                        <button class="btn btn--submit" id="submitCase">
                            <span class="material-symbols-outlined">send</span>
                            Submit
                        </button>
                        <button class="btn btn--outline btn--reset" id="resetOrders">
                            <span class="material-symbols-outlined">refresh</span>
                            Reset
                        </button>
                    </div>

                </div>

            </div>

        </div>
    </main>

    {{-- IMAGE MODAL --}}
    <div class="image-modal" id="imageModal" onclick="closeImageModal(event)">
        <div class="image-modal__content" onclick="event.stopPropagation()">
            <button class="image-modal__close" onclick="closeImageModal()">✕</button>
            <img class="image-modal__image" id="modalImage" src="" alt="Medical Image">
            <div class="image-modal__caption">Click outside to close</div>
        </div>
    </div>

    {{-- LOADING OVERLAY --}}
    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    {{-- FOOTER --}}
    <footer class="footer">
        {{-- ... نفس ما هو ... --}}
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
        mobileMenuToggle.addEventListener('click', () => nav.classList.toggle('open'));

        // TIMER
        let timerSeconds = 120;
        const timerDisplay = document.getElementById('timerDisplay');
        const timerContainer = document.getElementById('timerContainer');
        let timerInterval;
        let warningShown = false;

        function updateTimerDisplay() {
            const mins = Math.floor(timerSeconds / 60);
            const secs = timerSeconds % 60;
            timerDisplay.textContent = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
            if (timerSeconds <= 30) timerContainer.classList.add('warning');
            if (timerSeconds <= 10 && timerSeconds > 0 && !warningShown) {
                warningShown = true;
                showTimerWarning(timerSeconds);
            }
            if (timerSeconds <= 0) {
                clearInterval(timerInterval);
                timerDisplay.textContent = '00:00';
                submitCase();
            }
        }

        function showTimerWarning(seconds) {
            const overlay = document.createElement('div');
            overlay.className = 'timer-warning-overlay';
            overlay.innerHTML = `⏰ <strong>${seconds} seconds left!</strong><small>Please submit your diagnosis before time runs out.</small>`;
            document.body.appendChild(overlay);
            setTimeout(() => { overlay.remove(); warningShown = false; }, 2500);
        }

        function startTimer() {
            updateTimerDisplay();
            timerInterval = setInterval(() => { timerSeconds--; updateTimerDisplay(); }, 1000);
        }

        // TABS
        document.querySelectorAll('.orders-tabs__header').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.orders-tabs__header').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                document.querySelectorAll('.orders-tabs__panel').forEach(p => p.classList.remove('active'));
                document.getElementById(`panel-${this.dataset.tab}`).classList.add('active');
            });
        });

        // ORDER BASKET
        const orderBasket = document.getElementById('orderBasket');
        const orderCount = document.getElementById('orderCount');
        const selectedOrders = new Set();
        const imageOrderTypes = ['CT Scan Image', 'MRI Image', 'Chest X-Ray Image', 'ECG Image'];

        document.querySelectorAll('.order-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const orderItem = this.closest('.order-item');
                const orderText = orderItem.dataset.order;
                if (this.checked) {
                    selectedOrders.add(orderText);
                    orderItem.classList.add('order-item--selected');
                } else {
                    selectedOrders.delete(orderText);
                    orderItem.classList.remove('order-item--selected');
                }
                updateBasket();
                checkImageOrders();
            });
        });

        function updateBasket() {
            orderBasket.innerHTML = '';
            orderCount.textContent = selectedOrders.size;
            if (selectedOrders.size === 0) {
                orderBasket.innerHTML = '<span class="order-basket__empty">No orders selected</span>';
                return;
            }
            selectedOrders.forEach(order => {
                const item = document.createElement('span');
                item.className = 'order-basket__item';
                item.innerHTML = `${order}<button class="remove-btn" onclick="removeOrder('${order}')">✕</button>`;
                orderBasket.appendChild(item);
            });
        }

        function removeOrder(orderText) {
            selectedOrders.delete(orderText);
            document.querySelectorAll('.order-checkbox').forEach(cb => {
                const item = cb.closest('.order-item');
                if (item.dataset.order === orderText) {
                    cb.checked = false;
                    item.classList.remove('order-item--selected');
                }
            });
            updateBasket();
            checkImageOrders();
        }

        function checkImageOrders() {
            const attachmentsCard = document.getElementById('attachmentsCard');
            const noImagesMessage = document.getElementById('noImagesMessage');
            const hasImageOrder = Array.from(selectedOrders).some(order => imageOrderTypes.includes(order));
            if (attachmentsCard) {
                if (hasImageOrder) {
                    attachmentsCard.classList.add('show');
                    if (noImagesMessage) noImagesMessage.style.display = 'none';
                } else {
                    attachmentsCard.classList.remove('show');
                    if (noImagesMessage) noImagesMessage.style.display = 'block';
                }
            }
        }

        // RESET
        document.getElementById('resetOrders').addEventListener('click', function() {
            document.querySelectorAll('.order-checkbox').forEach(cb => {
                cb.checked = false;
                cb.closest('.order-item').classList.remove('order-item--selected');
            });
            selectedOrders.clear();
            updateBasket();
            checkImageOrders();
            document.getElementById('diagnosisInput').value = '';
            document.getElementById('notesInput').value = '';
            clearInterval(timerInterval);
            timerSeconds = 120;
            warningShown = false;
            timerContainer.classList.remove('warning');
            startTimer();
        });

        // IMAGE MODAL
        function openImageModal(url) {
            document.getElementById('modalImage').src = url;
            document.getElementById('imageModal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeImageModal(event) {
            if (event && event.target !== event.currentTarget) return;
            document.getElementById('imageModal').classList.remove('open');
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeImageModal({ target: document.getElementById('imageModal') });
        });

        // ============================================
        // SUBMIT (Form Submit → Result Page)
        // ============================================
        function submitCase() {
            const diagnosis = document.getElementById('diagnosisInput').value.trim();
            const notes = document.getElementById('notesInput').value.trim();
            const orders = Array.from(selectedOrders);
            const timeTaken = 120 - Math.max(0, timerSeconds);

            if (timerInterval) clearInterval(timerInterval);

            // Show loading overlay
            document.getElementById('loadingOverlay').classList.add('show');

            // Create hidden form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('medpix.cases.submit', $case->uid) }}';

            // CSRF
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);

            // Basic fields
            const fields = {
                diagnosis: diagnosis,
                notes: notes,
                time_taken: timeTaken,
            };

            for (const [key, value] of Object.entries(fields)) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = value;
                form.appendChild(input);
            }

            // Orders (array)
            orders.forEach((order, i) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `orders[${i}]`;
                input.value = order;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        }

        // ============================================
        // ✅ SUBMIT BUTTON EVENT LISTENER
        // ============================================
        document.getElementById('submitCase').addEventListener('click', function(e) {
            e.preventDefault();
            submitCase();
        });

        // INIT
        startTimer();
        updateBasket();
        checkImageOrders();
    </script>

</body>
</html>