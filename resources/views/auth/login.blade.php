{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html class="light" dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Sign In - SINA</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">

    <!-- Main Stylesheet -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />

    <style>
        /* ============================================
        FIX: VISUAL CENTER IMAGE POSITION
        ============================================ */
        .visual__center {
            position: absolute;
            top: 15%;
            left: 12%;
            transform: translate(-50%, -50%);
            width: 80%;
            height: 86%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            animation: float 6s ease-in-out infinite;
            pointer-events: none;
        }

        .visual__center-img {
            max-height: 100%;
            max-width: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            filter: drop-shadow(0 0 60px rgba(88, 188, 253, 0.2));
            opacity: 0.95;
        }

        @media (max-width: 1024px) {
            .visual__center {
                width: 70%;
                height: 70%;
                top: 28%;
                left: 45%;
            }
        }

        @media (max-width: 640px) {
            .visual__center {
                width: 60%;
                height: 60%;
                top: 25%;
                left: 50%;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <header class="header" id="header">
        <div class="container header__container">
            <a href="{{ route('home') }}" class="header__logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="SINA Logo" class="header__logo-img header__logo-img--light" />
                <img src="{{ asset('assets/img/logo1.png') }}" alt="SINA Logo" class="header__logo-img header__logo-img--dark" />
                <span class="header__logo-text">SINA</span>
            </a>

            <div class="header__actions">
                <button class="header__theme-btn" id="themeToggle">
                    <span class="material-symbols-outlined">dark_mode</span>
                </button>
                <a href="{{ route('register') }}" class="btn btn--register">Register</a>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="main main--signin">

        <!-- SIGNIN SECTION (right side - form) -->
        <section class="signin">
            <div class="container signin__container">
                <div class="signin__card">

                    <!-- Brand (mobile only) -->
                    <div class="signin__brand-mobile">
                        <span class="signin__brand-icon">S</span>
                        <h1 class="signin__brand-title">SINA</h1>
                    </div>

                    <!-- Header -->
                    <div class="signin__header">
                        <h2 class="signin__title">Welcome Back</h2>
                    </div>

                    <!-- ============================================
                    ✅ FORM - تم إزالة onsubmit وإضافة action و method
                    ============================================ -->
                    <form class="signin__form" method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- عرض رسائل الخطأ العامة -->
                        @if ($errors->any())
                            <div style="background: rgba(253, 121, 168, 0.12); color: #e74c3c; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; border-left: 3px solid #e74c3c;">
                                @foreach ($errors->all() as $error)
                                    <div style="margin-bottom: 4px;">• {{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <!-- عرض رسائل النجاح -->
                        @if(session('success'))
                            <div style="background: rgba(46, 204, 113, 0.12); color: #27ae60; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; border-left: 3px solid #27ae60;">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Email -->
                        <div class="form-group">
                            <label class="form-group__label" for="email">Email Address</label>
                            <div class="input-wrapper">
                                <span class="input-wrapper__icon material-symbols-outlined">mail</span>
                                <input class="input-wrapper__field" id="email" type="email" name="email" placeholder="doctor@hospital.edu" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                                <small style="color: #e74c3c; font-size: 0.75rem; margin-top: 4px; display: block;">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <div class="form-group__row">
                                <label class="form-group__label" for="password">Password</label>
                                <a href="#" class="form-group__forgot">Forgot Password?</a>
                            </div>
                            <div class="input-wrapper">
                                <span class="input-wrapper__icon material-symbols-outlined">lock</span>
                                <input class="input-wrapper__field" id="password" type="password" name="password" placeholder="••••••••" required>
                                <button class="input-wrapper__toggle" type="button" id="togglePassword" onclick="togglePassword()">
                                    <span class="material-symbols-outlined" id="visibility-icon">visibility_off</span>
                                </button>
                            </div>
                            @error('password')
                                <small style="color: #e74c3c; font-size: 0.75rem; margin-top: 4px; display: block;">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="form-group form-group--row">
                            <label class="checkbox">
                                <input class="checkbox__input" type="checkbox" id="remember-me" name="remember">
                                <span class="checkbox__label">Remember me</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button class="btn btn--primary btn--full" type="submit">
                            <span>Log In</span>
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </button>

                        <!-- Divider -->
                        <div class="divider">
                            <span class="divider__line"></span>
                            <span class="divider__text">Or continue with</span>
                            <span class="divider__line"></span>
                        </div>

                        <!-- Google Sign In -->
                        <button class="btn btn--google btn--full" type="button">
                            <svg class="btn__google-icon" viewBox="0 0 24 24">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                            </svg>
                            <span>Continue with Google</span>
                        </button>

                    </form>

                    <!-- Signup Link -->
                    <p class="signin__footer">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="signin__footer-link">
                            Join us now
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </p>

                </div>
            </div>
        </section>

        <!-- VISUAL SECTION (left side - rings & image) -->
        <aside class="visual">
            <div class="visual__bg"></div>
            <div class="visual__glow"></div>

            <div class="visual__rings">
                <!-- Outer Ring -->
                <div class="ring ring--outer">
                    <div class="ring__orbit ring__orbit--top">
                        <img src="{{ asset('assets/img/login1.png') }}" alt="Medical icon">
                    </div>
                    <div class="ring__orbit ring__orbit--right">
                        <img src="{{ asset('assets/img/login2.png') }}" alt="Medical icon">
                    </div>
                    <div class="ring__orbit ring__orbit--bottom">
                        <img src="{{ asset('assets/img/login3.png') }}" alt="Medical icon">
                    </div>
                    <div class="ring__orbit ring__orbit--left">
                        <img src="{{ asset('assets/img/login1.png') }}" alt="Medical icon">
                    </div>
                </div>

                <!-- Middle Ring -->
                <div class="ring ring--middle">
                    <div class="ring__orbit ring__orbit--top">
                        <img src="{{ asset('assets/img/login2.png') }}" alt="Medical icon">
                    </div>
                    <div class="ring__orbit ring__orbit--right">
                        <img src="{{ asset('assets/img/login3.png') }}" alt="Medical icon">
                    </div>
                    <div class="ring__orbit ring__orbit--bottom">
                        <img src="{{ asset('assets/img/login1.png') }}" alt="Medical icon">
                    </div>
                    <div class="ring__orbit ring__orbit--left">
                        <img src="{{ asset('assets/img/login2.png') }}" alt="Medical icon">
                    </div>
                </div>
            </div>

            <!-- Center Image -->
            <div class="visual__center">
                <img src="{{ asset('assets/img/login.png') }}" alt="Medical AI Head" class="visual__center-img">
            </div>
        </aside>

    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container footer__container">

            <div class="footer__brand">
                <div class="footer__logo">
                    <img src="{{ asset('assets/img/logo1.png') }}" alt="SINA Logo" class="footer__logo-img footer__logo-img--light" />
                    <img src="{{ asset('assets/img/logo1.png') }}" alt="SINA Logo" class="footer__logo-img footer__logo-img--dark" />
                    <span class="footer__logo-text">SINA</span>
                </div>
                <p class="footer__desc">
                    Empowering the next generation of healthcare professionals through intelligent, case-based medical education.
                </p>
                <div class="footer__social">
                    <a href="#" class="footer__social-link">📘</a>
                    <a href="#" class="footer__social-link">🐦</a>
                    <a href="#" class="footer__social-link">📸</a>
                    <a href="#" class="footer__social-link">▶️</a>
                </div>
            </div>

            <div class="footer__links">
                <h4 class="footer__links-title">Product</h4>
                <ul class="footer__links-list">
                    <li><a href="#">Features</a></li>
                    <li><a href="#">Pricing</a></li>
                    <li><a href="#">Modules</a></li>
                    <li><a href="#">Updates</a></li>
                </ul>
            </div>

            <div class="footer__links">
                <h4 class="footer__links-title">Company</h4>
                <ul class="footer__links-list">
                    <li><a href="#">About</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

        </div>

        <div class="footer__bottom">
            <span>Version v2.1.0 © 2026 SINA Medical Education. All rights reserved.</span>
            <div class="footer__bottom-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Cookie Policy</a>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // --- Theme Toggle ---
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

        // --- Toggle Password Visibility ---
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const visibilityIcon = document.getElementById('visibility-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                visibilityIcon.textContent = 'visibility';
            } else {
                passwordInput.type = 'password';
                visibilityIcon.textContent = 'visibility_off';
            }
        }
    </script>

</body>
</html>