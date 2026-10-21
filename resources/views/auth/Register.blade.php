{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html class="light" dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SINA - Create Account</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">

    <!-- Main Stylesheet -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
<body>

    <!-- HEADER - Navigation Bar -->
    <header class="header" id="header">
        <div class="container header__container">
            <a href="{{ route('home') }}" class="header__logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="SINA Logo" class="header__logo-img header__logo-img--light">
                <img src="{{ asset('assets/img/logo1.png') }}" alt="SINA Logo" class="header__logo-img header__logo-img--dark">
                <span class="header__logo-text">SINA</span>
            </a>

            <div class="header__actions">
                <button class="header__theme-btn" id="themeToggle">
                    <span class="material-symbols-outlined">dark_mode</span>
                </button>
                <a href="{{ route('login') }}" class="btn btn--outline">Log In</a>
            </div>

            <!-- Mobile Menu Button -->
            <button class="header__menu-btn" id="mobileMenuToggle" aria-label="Toggle menu">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </header>

    <!-- MAIN -->
    <main class="main--signin">

        <!-- ============================================
        VISUAL SECTION (Real Heart Video)
        ============================================ -->
        <section class="visual visual--heart" aria-hidden="true">

            <!-- توهج أحمر -->
            <div class="visual__glow-red"></div>

            <!-- تراكب داكن -->
            <div class="visual__overlay"></div>

            <!-- فيديو القلب الحقيقي -->
            <video class="visual__video" autoplay muted loop playsinline>
                <source src="{{ asset('assets/videos/1.mp4') }}" type="video/mp4">
                <!-- لو ما شغل الفيديو، يظهر صورة بديلة -->
                <img src="{{ asset('assets/img/heart-fallback.jpg') }}" alt="Real Heart" style="width:100%; height:100%; object-fit:cover;">
            </video>

        </section>

        <!-- ============================================
        REGISTER FORM SECTION (Right Side)
        ============================================ -->
        <section class="signin">
            <div class="signin__container">
                <div class="signin__card">

                    <!-- Brand (Mobile) -->
                    <div class="signin__brand-mobile">
                        <div class="signin__brand-icon">S</div>
                        <span class="signin__brand-title">SINA</span>
                    </div>

                    <!-- Header -->
                    <div class="signin__header">
                        <h1 class="signin__title">Create Account</h1>
                        <p style="color: var(--color-text-secondary); font-size: 0.95rem; margin-top: 4px;">
                            Start your clinical journey with SINA
                        </p>
                    </div>

                    <!-- ============================================
                    ✅ REGISTER FORM - تم الإصلاح
                    ============================================ -->
                    <form class="signin__form" method="POST" action="{{ route('register') }}">
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

                        <!-- Full Name -->
                        <div class="form-group">
                            <label class="form-group__label" for="name">Full Name</label>
                            <div class="input-wrapper">
                                <span class="input-wrapper__icon material-symbols-outlined">person</span>
                                <input class="input-wrapper__field" type="text" id="name" name="name" placeholder="Dr. Ahmed Al-Mansouri" value="{{ old('name') }}" required>
                            </div>
                            @error('name')
                                <small style="color: #e74c3c; font-size: 0.75rem; margin-top: 4px; display: block;">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label class="form-group__label" for="email">Email Address</label>
                            <div class="input-wrapper">
                                <span class="input-wrapper__icon material-symbols-outlined">mail</span>
                                <input class="input-wrapper__field" type="email" id="email" name="email" placeholder="ahmed@example.com" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                                <small style="color: #e74c3c; font-size: 0.75rem; margin-top: 4px; display: block;">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label class="form-group__label" for="password">Password</label>
                            <div class="input-wrapper">
                                <span class="input-wrapper__icon material-symbols-outlined">lock</span>
                                <input class="input-wrapper__field" type="password" id="password" name="password" placeholder="••••••••" required minlength="8">
                                <button class="input-wrapper__toggle" type="button" id="togglePassword" aria-label="Toggle password visibility">
                                    <span class="material-symbols-outlined">visibility</span>
                                </button>
                            </div>
                            <small style="color: var(--color-text-muted); font-size: 0.75rem;">Minimum 8 characters</small>
                            @error('password')
                                <small style="color: #e74c3c; font-size: 0.75rem; margin-top: 4px; display: block;">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label class="form-group__label" for="password_confirmation">Confirm Password</label>
                            <div class="input-wrapper">
                                <span class="input-wrapper__icon material-symbols-outlined">lock</span>
                                <input class="input-wrapper__field" type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                            </div>
                        </div>

                        <!-- Specialization -->
                        <div class="form-group">
                            <label class="form-group__label" for="specialty">Specialization</label>
                            <div class="input-wrapper">
                                <span class="input-wrapper__icon material-symbols-outlined">school</span>
                                <select class="input-wrapper__field" id="specialty" name="specialty" style="appearance: auto; padding-right: 16px;">
                                    <option value="">Select your level</option>
                                    <option value="medical_student" {{ old('specialty') == 'medical_student' ? 'selected' : '' }}>Medical Student</option>
                                    <option value="intern" {{ old('specialty') == 'intern' ? 'selected' : '' }}>Intern</option>
                                    <option value="resident" {{ old('specialty') == 'resident' ? 'selected' : '' }}>Resident</option>
                                    <option value="dentistry_student" {{ old('specialty') == 'dentistry_student' ? 'selected' : '' }}>Dentistry Student</option>
                                    <option value="pharmacy_student" {{ old('specialty') == 'pharmacy_student' ? 'selected' : '' }}>Pharmacy Student</option>
                                    <option value="other" {{ old('specialty') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            @error('specialty')
                                <small style="color: #e74c3c; font-size: 0.75rem; margin-top: 4px; display: block;">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Terms & Conditions -->
                        <div class="form-group">
                            <label class="checkbox">
                                <input class="checkbox__input" type="checkbox" id="terms" name="terms" {{ old('terms') ? 'checked' : '' }} required>
                                <span class="checkbox__label">
                                    I agree to the <a href="#" style="color: var(--color-primary-teal);">Terms of Service</a> and <a href="#" style="color: var(--color-primary-teal);">Privacy Policy</a>
                                </span>
                            </label>
                            @error('terms')
                                <small style="color: #e74c3c; font-size: 0.75rem; margin-top: 4px; display: block;">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button class="btn btn--primary btn--lg" type="submit" style="width: 100%;">
                            <span>Create Account</span>
                            <span class="material-symbols-outlined">arrow_forward</span>
                            <span class="btn__overlay"></span>
                        </button>

                        <!-- OR Divider -->
                        <div class="divider">
                            <span class="divider__line"></span>
                            <span class="divider__text">or continue with</span>
                            <span class="divider__line"></span>
                        </div>

                        <!-- Google Sign-Up -->
                        <button class="btn btn--google" type="button">
                            <svg class="btn__google-icon" viewBox="0 0 48 48">
                                <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
                                <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
                                <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
                                <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
                            </svg>
                            Sign up with Google
                        </button>

                        <!-- Footer -->
                        <div class="signin__footer">
                            Already have an account?
                            <a href="{{ route('login') }}" class="signin__footer-link">
                                Log In
                                <span class="material-symbols-outlined" style="font-size: 1rem;">arrow_forward</span>
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
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
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const icon = this.querySelector('.material-symbols-outlined');
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.textContent = 'visibility_off';
                } else {
                    passwordInput.type = 'password';
                    icon.textContent = 'visibility';
                }
            });
        }
    </script>

</body>
</html>