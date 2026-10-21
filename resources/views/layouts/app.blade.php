<!DOCTYPE html>
<html class="light" dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SINA - @yield('title', 'Medical Education')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Main Stylesheet -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>

    <!-- ============================================
    HEADER - Navigation Bar (مرة واحدة فقط)
    ============================================ -->
    <header class="header" id="header">
        <div class="container header__container">
            <a href="{{ route('dashboard') }}" class="header__logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="SINA Logo" class="header__logo-img header__logo-img--light">
                <img src="{{ asset('assets/img/logo1.png') }}" alt="SINA Logo" class="header__logo-img header__logo-img--dark">
                <span class="header__logo-text">SINA</span>
            </a>

            <nav class="header__nav">
                <ul class="header__nav-list">
                    <li><a href="{{ route('dashboard') }}" class="header__nav-link @yield('active-dashboard')">Dashboard</a></li>
                    <li><a href="{{ route('modules.index') }}" class="header__nav-link @yield('active-modules')">Modules</a></li>
                    <li><a href="{{ route('history.index') }}" class="header__nav-link @yield('active-history')">My History</a></li>
                    <li><a href="{{ route('leaderboard.index') }}" class="header__nav-link @yield('active-leaderboard')">Leaderboard</a></li>
                </ul>
            </nav>

            <div class="header__actions">
                <button class="header__theme-btn" id="themeToggle">
                    <span class="material-symbols-outlined">dark_mode</span>
                </button>
                <a href="{{ route('profile') }}" class="header__nav-link" style="display: flex; align-items: center; gap: 6px;">
                    <span class="material-symbols-outlined" style="font-size: 1.4rem;">account_circle</span>
                    <span style="font-weight: 600; font-size: 0.85rem; color: var(--color-primary-teal);">
                        {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                    </span>
                </a>
            </div>

            <button class="header__menu-btn" id="mobileMenuToggle" aria-label="Toggle menu">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </header>

    <!-- ============================================
    MAIN CONTENT
    ============================================ -->
    <main>
        @yield('content')
    </main>

    <!-- ============================================
    FOOTER
    ============================================ -->
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

    <!-- ============================================
    SCRIPTS
    ============================================ -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        // ============================================
        // THEME TOGGLE
        // ============================================
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;

        if (themeToggle) {
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
        }

        // ============================================
        // MOBILE MENU
        // ============================================
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const nav = document.querySelector('.header__nav');

        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', () => {
                nav.classList.toggle('open');
            });
        }
    </script>

    @stack('scripts')
</body>
</html>