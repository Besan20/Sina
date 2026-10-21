<!DOCTYPE html>
<html class="light" dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SINA - Medical Learning Platform</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">

    <!-- Main Stylesheet -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

    <!-- ===== HEADER - Navigation Bar ===== -->
    <header class="header" id="header">
        <div class="container header__container">
            <a href="#home" class="header__logo">
                <img src="assets/img/logo.png" alt="SINA Logo" class="header__logo-img header__logo-img--light">
                <img src="assets/img/logo1.png" alt="SINA Logo" class="header__logo-img header__logo-img--dark">
                <span class="header__logo-text">SINA</span>
            </a>

            <nav class="header__nav">
                <ul class="header__nav-list">
                    <li><a href="#about" class="header__nav-link">About</a></li>
                    <li><a href="#how-it-works" class="header__nav-link">How It Works</a></li>
                    <li><a href="#features" class="header__nav-link">Features</a></li>
                    <li><a href="#testimonials" class="header__nav-link">Testimonials</a></li>
                    <li><a href="#contact" class="header__nav-link">Contact</a></li>
                </ul>
            </nav>

            <div class="header__actions">
                <button class="header__theme-btn" id="themeToggle">
                    <span class="material-symbols-outlined">dark_mode</span>
                </button>
                <a href="{{ route('login') }}" class="btn btn--outline">Log In</a>
                <a href="{{ route('register') }}" class="btn btn--register">Register</a>

            </div>

            <button class="header__menu-btn" id="mobileMenuToggle" aria-label="Toggle menu">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </header>

    <!-- ===== MAIN CONTENT ===== -->
    <main>

        <!-- ===== HERO SECTION ===== -->
        <section class="hero" id="home">
            <div class="hero__bg">
                <canvas id="hero-shader" class="hero__canvas"></canvas>
            </div>
            <div class="hero__bg hero__bg--ecg">
                <canvas id="ecg-shader" class="hero__canvas"></canvas>
            </div>

            <div class="hero__decorations">
                <div class="hero__blob hero__blob--top-right"></div>
                <div class="hero__blob hero__blob--bottom-left"></div>
            </div>

            <div class="container hero__container">
                <div class="hero__content">
                    <div class="hero__logo-wrapper">
                        <img src="assets/img/logo.png" alt="SINA Logo" class="hero__logo hero__logo--light">
                        <img src="assets/img/logo1.png" alt="SINA Logo" class="hero__logo hero__logo--dark">
                    </div>

                    <h1 class="hero__title">
                        Master Clinical
                        <span class="hero__title-gradient">Medicine</span>
                    </h1>

                    <h2 class="hero__subtitle">SINA — Case-Based Medical Learning Platform</h2>

                    <p class="hero__description">
                        Practice with 500+ real-world clinical cases. Master diagnosis, treatment planning, and clinical reasoning in a safe, interactive environment.
                    </p>

                    <div class="hero__actions">
                        <a href="#" class="btn btn--primary btn--lg">
                            <span>Start Your Journey</span>
                            <span class="material-symbols-outlined">arrow_forward</span>
                            <span class="btn__overlay"></span>
                        </a>
                        <a href="#" class="btn btn--secondary btn--lg">
                            <span>Explore Modules</span>
                            <span class="material-symbols-outlined">play_circle</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== ABOUT SECTION ===== -->
        <section class="about" id="about">
            <div class="container">
                <div class="section-header">
                    <span class="section-header__badge">About SINA</span>
                    <h2 class="section-header__title">Mission &amp; Vision</h2>
                    <div class="divider"></div>
                    <p class="section-header__desc">Discover how SINA is transforming medical education worldwide.</p>
                </div>

                <div class="about__grid">
                    <div class="about__card card card--lift">
                        <div class="card__icon card__icon--teal">
                            <span class="material-symbols-outlined">visibility</span>
                        </div>
                        <h3 class="card__title">Our Vision</h3>
                        <p class="card__desc">To train the next generation of clinically competent physicians who can diagnose and treat with confidence before facing real patients.</p>
                        <a href="#" class="card__link">
                            <span>Learn more</span>
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </div>

                    <div class="about__card card card--lift">
                        <div class="card__icon card__icon--purple">
                            <span class="material-symbols-outlined">rocket_launch</span>
                        </div>
                        <h3 class="card__title">Our Mission</h3>
                        <p class="card__desc">To provide an interactive, safe, and intelligent learning experience that bridges the gap between medical theory and clinical practice using cutting-edge technology.</p>
                        <a href="#" class="card__link card__link--purple">
                            <span>Learn more</span>
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== HOW IT WORKS SECTION ===== -->
        <section class="how-it-works" id="how-it-works">
            <div class="container">
                <div class="section-header">
                    <span class="section-header__badge">Process</span>
                    <h2 class="section-header__title">How SINA Works</h2>
                    <div class="divider"></div>
                    <p class="section-header__desc">Four simple steps to master clinical medicine.</p>
                </div>

                <div class="how-it-works__grid">
                    <div class="step">
                        <div class="step__number step__number--teal">
                            <span>1</span>
                            <div class="step__pulse"></div>
                        </div>
                        <h3 class="step__title">Choose Your Module</h3>
                        <p class="step__desc">Select from 12 body systems — Cardiology, Respiratory, Neurology, and more.</p>
                    </div>

                    <div class="step">
                        <div class="step__number step__number--green">
                            <span>2</span>
                        </div>
                        <h3 class="step__title">Explore Clinical Cases</h3>
                        <p class="step__desc">30-50 interactive scenarios with symptoms, labs, and imaging per module.</p>
                    </div>

                    <div class="step">
                        <div class="step__number step__number--purple">
                            <span>3</span>
                        </div>
                        <h3 class="step__title">Order Tests &amp; Diagnose</h3>
                        <p class="step__desc">Request investigations, view results, and make your diagnosis.</p>
                    </div>

                    <div class="step">
                        <div class="step__number step__number--pink">
                            <span>4</span>
                        </div>
                        <h3 class="step__title">Get Instant Feedback</h3>
                        <p class="step__desc">Detailed explanations, performance analysis, and points for correct answers.</p>
                    </div>
                </div>

                <div class="how-it-works__line"></div>
            </div>
        </section>

        <!-- ===== STATISTICS SECTION ===== -->
        <section class="stats">
            <div class="stats__bg"></div>
            <div class="stats__pattern"></div>

            <div class="container stats__container">
                <h2 class="stats__title">SINA by the Numbers</h2>

                <div class="stats__grid">
                    <div class="stat">
                        <div class="stat__number" data-target="500" data-speed="600">0</div>
                        <div class="stat__label">Clinical Cases</div>
                    </div>
                    <div class="stat">
                        <div class="stat__number" data-target="12" data-speed="500">0</div>
                        <div class="stat__label">Body System Modules</div>
                    </div>
                    <div class="stat">
                        <div class="stat__number" data-target="10000" data-speed="700">0</div>
                        <div class="stat__label">Active Students</div>
                    </div>
                    <div class="stat">
                        <div class="stat__number" data-target="94" data-speed="500">0</div>
                        <div class="stat__label">Student Satisfaction</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== FEATURES SECTION ===== -->
        <section class="features" id="features">
            <div class="container">
                <div class="section-header">
                    <span class="section-header__badge">Features</span>
                    <h2 class="section-header__title">What Makes SINA Different</h2>
                    <div class="divider"></div>
                    <p class="section-header__desc">Innovative features designed to enhance your medical learning experience.</p>
                </div>

                <div class="features__grid">
                    <div class="feature">
                        <div class="feature__icon feature__icon--teal">
                            <span class="material-symbols-outlined">update</span>
                        </div>
                        <div class="feature__content">
                            <h3 class="feature__title">Spaced Repetition</h3>
                            <p class="feature__desc">Intelligent algorithms that review concepts exactly when you're about to forget them.</p>
                        </div>
                    </div>

                    <div class="feature">
                        <div class="feature__icon feature__icon--green">
                            <span class="material-symbols-outlined">sports_esports</span>
                        </div>
                        <div class="feature__content">
                            <h3 class="feature__title">Gamification</h3>
                            <p class="feature__desc">Earn points, unlock achievements, and compete on leaderboards.</p>
                        </div>
                    </div>

                    <div class="feature">
                        <div class="feature__icon feature__icon--purple">
                            <span class="material-symbols-outlined">analytics</span>
                        </div>
                        <div class="feature__content">
                            <h3 class="feature__title">Detailed Analytics</h3>
                            <p class="feature__desc">Track your performance over time and identify areas for improvement.</p>
                        </div>
                    </div>

                    <div class="feature">
                        <div class="feature__icon feature__icon--pink">
                            <span class="material-symbols-outlined">smartphone</span>
                        </div>
                        <div class="feature__content">
                            <h3 class="feature__title">Mobile-Friendly</h3>
                            <p class="feature__desc">Learn anywhere, anytime with a responsive interface optimized for all devices.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== AUDIENCE SECTION ===== -->
        <section class="audience">
            <div class="container">
                <div class="section-header">
                    <span class="section-header__badge">Audience</span>
                    <h2 class="section-header__title">Who Is SINA For?</h2>
                    <div class="divider"></div>
                    <p class="section-header__desc">SINA is designed for every healthcare student and professional.</p>
                </div>

                <div class="audience__grid">
                    <div class="audience__card card card--lift card--audience">
                        <div class="card__icon card__icon--teal">
                            <span class="material-symbols-outlined">stethoscope</span>
                        </div>
                        <h3 class="card__title">Medical Students</h3>
                        <p class="card__desc">Practice clinical reasoning in a risk-free environment.</p>
                        <span class="card__hover-label">→ Learn more</span>
                    </div>

                    <div class="audience__card card card--lift card--audience">
                        <div class="card__icon card__icon--green">
                            <span class="material-symbols-outlined">dentistry</span>
                        </div>
                        <h3 class="card__title">Dentistry Students</h3>
                        <p class="card__desc">Master systemic conditions affecting oral health.</p>
                        <span class="card__hover-label">→ Learn more</span>
                    </div>

                    <div class="audience__card card card--lift card--audience">
                        <div class="card__icon card__icon--purple">
                            <span class="material-symbols-outlined">pill</span>
                        </div>
                        <h3 class="card__title">Pharmacy Students</h3>
                        <p class="card__desc">Understand drug selection and treatment protocols.</p>
                        <span class="card__hover-label">→ Learn more</span>
                    </div>

                    <div class="audience__card card card--lift card--audience">
                        <div class="card__icon card__icon--pink">
                            <span class="material-symbols-outlined">local_hospital</span>
                        </div>
                        <h3 class="card__title">Interns &amp; Residents</h3>
                        <p class="card__desc">Prepare for real-world rotations and board exams.</p>
                        <span class="card__hover-label">→ Learn more</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== TESTIMONIALS SECTION ===== -->
        <section class="testimonials" id="testimonials">
            <div class="testimonials__decor">
                <div class="testimonials__blob testimonials__blob--top-right"></div>
                <div class="testimonials__blob testimonials__blob--bottom-left"></div>
            </div>

            <div class="container testimonials__container">
                <div class="section-header">
                    <span class="section-header__badge">Testimonials</span>
                    <h2 class="section-header__title">What Our Students Say</h2>
                    <div class="divider"></div>
                    <p class="section-header__desc">Real stories from real students who transformed their learning journey.</p>
                </div>

                <div class="testimonials__grid">
                    <div class="testimonial card card--testimonial">
                        <div class="testimonial__quote">"</div>
                        <div class="testimonial__stars">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                        </div>
                        <p class="testimonial__text">"SINA transformed how I study. The cases feel so real, and the feedback is incredible. I've never felt more prepared for clinical rotations."</p>
                        <div class="testimonial__author">
                            <div class="testimonial__avatar testimonial__avatar--teal">SA</div>
                            <div>
                                <div class="testimonial__name">Sarah A.</div>
                                <div class="testimonial__role">4th Year Medical Student</div>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial card card--testimonial">
                        <div class="testimonial__quote">"</div>
                        <div class="testimonial__stars">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                        </div>
                        <p class="testimonial__text">"The spaced repetition feature helped me finally master cardiology after failing it twice. This platform is a game-changer for medical education."</p>
                        <div class="testimonial__author">
                            <div class="testimonial__avatar testimonial__avatar--purple">KM</div>
                            <div>
                                <div class="testimonial__name">Dr. Khaled M.</div>
                                <div class="testimonial__role">Internal Medicine Resident</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== CONTACT / CTA SECTION ===== -->
        <section class="cta" id="contact">
            <div class="cta__bg"></div>
            <div class="cta__pattern"></div>

            <div class="container cta__container">
                <div class="cta__content">
                    <h2 class="cta__title">Ready to Start Your Medical Journey?</h2>
                    <p class="cta__desc">Join 10,000+ students already mastering clinical medicine with SINA.</p>
                    <div class="cta__actions">
                        <a href="#" class="btn btn--white btn--lg">
                            <span>Get Started Free</span>
                            <span class="material-symbols-outlined">arrow_forward</span>
                            <span class="btn__overlay"></span>
                        </a>
                        <a href="#" class="btn btn--outline-white btn--lg">
                            <span>Watch Demo</span>
                            <span class="material-symbols-outlined">play_circle</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="footer">
        <div class="container footer__container">

            <div class="footer__brand">
                <div class="footer__logo">
                    <img src="assets/img/logo1.png" alt="SINA Logo" class="footer__logo-img footer__logo-img--light">
                    <img src="assets/img/logo1.png" alt="SINA Logo" class="footer__logo-img footer__logo-img--dark">
                    <span class="footer__logo-text">SINA</span>
                </div>
                <p class="footer__desc">
                    Empowering the next generation of healthcare professionals through intelligent, case-based medical education.
                </p>
                <div class="footer__social">
                    <a href="#" class="footer__social-link" aria-label="LinkedIn">📘</a>
                    <a href="#" class="footer__social-link" aria-label="Twitter">🐦</a>
                    <a href="#" class="footer__social-link" aria-label="Instagram">📸</a>
                    <a href="#" class="footer__social-link" aria-label="YouTube">▶️</a>
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

    <!-- ===== JavaScript ===== -->
    <script src="assets/js/main.js"></script>

</body>
</html>