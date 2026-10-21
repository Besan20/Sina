/* ========================================
   SINA MAIN JAVASCRIPT - v2.1.0 (FULL)
   ======================================== */

// ============================================
// 1. THEME TOGGLE - GLOBAL
// ============================================
(function() {
    'use strict';

    const html = document.documentElement;
    const themeKey = 'sina-theme';

    function applyTheme(isDark) {
        if (isDark) {
            html.classList.add('dark');
            html.classList.remove('light');
        } else {
            html.classList.remove('dark');
            html.classList.add('light');
        }

        // تحديث أيقونة الزر
        const toggleBtns = document.querySelectorAll('#themeToggle');
        toggleBtns.forEach(btn => {
            if (btn) {
                btn.innerHTML = isDark ?
                    '<span class="material-symbols-outlined">light_mode</span>' :
                    '<span class="material-symbols-outlined">dark_mode</span>';
            }
        });

        // تحديث اللوغوات
        const lightLogos = document.querySelectorAll('.header__logo-img--light, .hero__logo--light, .footer__logo-img--light');
        const darkLogos = document.querySelectorAll('.header__logo-img--dark, .hero__logo--dark, .footer__logo-img--dark');

        lightLogos.forEach(el => { el.style.display = isDark ? 'none' : 'block'; });
        darkLogos.forEach(el => { el.style.display = isDark ? 'block' : 'none'; });

        try {
            localStorage.setItem(themeKey, isDark ? 'dark' : 'light');
        } catch (e) {}
    }

    function initTheme() {
        let isDark = false;
        try {
            const saved = localStorage.getItem(themeKey);
            if (saved === 'dark') isDark = true;
            else if (saved === 'light') isDark = false;
            else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) isDark = true;
        } catch (e) {}
        applyTheme(isDark);
    }

    function bindThemeToggle() {
        const toggleBtns = document.querySelectorAll('#themeToggle');
        toggleBtns.forEach(btn => {
            // إزالة الـ listeners القديمة
            const newBtn = btn.cloneNode(true);
            btn.parentNode.replaceChild(newBtn, btn);

            newBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const isDark = !html.classList.contains('dark');
                applyTheme(isDark);
                // تحديث كل الأزرار
                document.querySelectorAll('#themeToggle').forEach(b => {
                    b.innerHTML = isDark ?
                        '<span class="material-symbols-outlined">light_mode</span>' :
                        '<span class="material-symbols-outlined">dark_mode</span>';
                });
            });
        });
    }

    // تشغيل عند تحميل الصفحة
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        initTheme();
        bindThemeToggle();
    } else {
        document.addEventListener('DOMContentLoaded', function() {
            initTheme();
            bindThemeToggle();
        });
    }

    // مراقبة التغييرات من صفحات أخرى
    window.addEventListener('storage', function(e) {
        if (e.key === themeKey) {
            applyTheme(e.newValue === 'dark');
        }
    });

})();


// ============================================
// 2. HERO SHADER - مع حماية من الأخطاء
// ============================================
(function() {
    try {
        const canvas = document.getElementById('hero-shader');
        if (!canvas) return;

        function syncSize() {
            const rect = canvas.parentElement.getBoundingClientRect();
            const w = rect.width || 1280;
            const h = rect.height || 720;
            if (canvas.width !== w || canvas.height !== h) {
                canvas.width = w;
                canvas.height = h;
            }
        }

        if (typeof ResizeObserver !== 'undefined') {
            new ResizeObserver(syncSize).observe(canvas.parentElement);
        }
        syncSize();

        const gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
        if (!gl) return;

        const vs = `attribute vec2 a_position;
            varying vec2 v_texCoord;
            void main() {
                v_texCoord = a_position * 0.5 + 0.5;
                gl_Position = vec4(a_position, 0.0, 1.0);
            }`;

        const fs = `precision highp float;
            uniform float u_time;
            uniform vec2 u_resolution;
            uniform vec2 u_mouse;
            varying vec2 v_texCoord;

            float hash(vec2 p) {
                return fract(sin(dot(p, vec2(127.1, 311.7))) * 43758.5453);
            }

            float noise(vec2 p) {
                vec2 i = floor(p);
                vec2 f = fract(p);
                f = f * f * (3.0 - 2.0 * f);
                float a = hash(i);
                float b = hash(i + vec2(1.0, 0.0));
                float c = hash(i + vec2(0.0, 1.0));
                float d = hash(i + vec2(1.0, 1.0));
                return mix(mix(a, b, f.x), mix(c, d, f.x), f.y);
            }

            void main() {
                vec2 uv = v_texCoord;
                vec2 mouse = u_mouse / u_resolution;

                float time = u_time * 0.05;
                vec2 p = uv * 2.5 + time * 0.2;

                float n1 = noise(p);
                float n2 = noise(p + vec2(1.7, 4.3));
                float n3 = noise(p * 0.5 - time * 0.15);

                float flow = n1 * 0.5 + n2 * 0.3 + n3 * 0.2;
                flow = flow * 0.7 + 0.15;

                vec3 navy = vec3(0.039, 0.086, 0.157);
                vec3 teal = vec3(0.0, 0.706, 0.847);

                float gradient = uv.y * 0.7 + flow * 0.3;
                vec3 color = mix(navy, teal, gradient);

                float depth = sin(uv.x * 20.0 + u_time * 0.3) * 0.02 + 0.98;
                color *= depth;

                float mouseDist = distance(uv, mouse);
                float mouseGlow = 1.0 - smoothstep(0.0, 0.6, mouseDist);
                color += vec3(0.0, 0.3, 0.4) * mouseGlow * 0.15;

                float vignette = 1.0 - length(uv - 0.5) * 0.5;
                color *= vignette;

                gl_FragColor = vec4(color, 1.0);
            }`;

        function createShader(type, src) {
            const s = gl.createShader(type);
            gl.shaderSource(s, src);
            gl.compileShader(s);
            return s;
        }

        const prog = gl.createProgram();
        gl.attachShader(prog, createShader(gl.VERTEX_SHADER, vs));
        gl.attachShader(prog, createShader(gl.FRAGMENT_SHADER, fs));
        gl.linkProgram(prog);
        gl.useProgram(prog);

        const buf = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, buf);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1, -1, 1, -1, -1, 1, 1, 1]), gl.STATIC_DRAW);

        const pos = gl.getAttribLocation(prog, 'a_position');
        gl.enableVertexAttribArray(pos);
        gl.vertexAttribPointer(pos, 2, gl.FLOAT, false, 0, 0);

        const uTime = gl.getUniformLocation(prog, 'u_time');
        const uRes = gl.getUniformLocation(prog, 'u_resolution');
        const uMouse = gl.getUniformLocation(prog, 'u_mouse');

        let mouse = { x: canvas.width / 2, y: canvas.height / 2 };
        window.addEventListener('mousemove', (event) => {
            const rect = canvas.getBoundingClientRect();
            if (rect.width && rect.height) {
                const nx = (event.clientX - rect.left) / rect.width;
                const ny = 1.0 - (event.clientY - rect.top) / rect.height;
                mouse.x = nx * canvas.width;
                mouse.y = ny * canvas.height;
            }
        });

        let animationId = null;

        function render(t) {
            try {
                syncSize();
                gl.viewport(0, 0, canvas.width, canvas.height);
                if (uTime) gl.uniform1f(uTime, t * 0.001);
                if (uRes) gl.uniform2f(uRes, canvas.width, canvas.height);
                if (uMouse) gl.uniform2f(uMouse, mouse.x, mouse.y);
                gl.drawArrays(gl.TRIANGLE_STRIP, 0, 4);
                animationId = requestAnimationFrame(render);
            } catch (e) {
                if (animationId) {
                    cancelAnimationFrame(animationId);
                    animationId = null;
                }
            }
        }

        if (canvas.parentElement) {
            render(0);
        }

        window.addEventListener('beforeunload', function() {
            if (animationId) {
                cancelAnimationFrame(animationId);
                animationId = null;
            }
        });

    } catch (e) {
        console.warn('Hero shader error:', e.message);
    }
})();


// ============================================
// 3. ECG / HEARTBEAT SHADER - مع حماية
// ============================================
(function() {
    try {
        const canvas = document.getElementById('ecg-shader');
        if (!canvas) return;

        function syncSize() {
            const rect = canvas.parentElement.getBoundingClientRect();
            const w = rect.width || 1280;
            const h = rect.height || 720;
            if (canvas.width !== w || canvas.height !== h) {
                canvas.width = w;
                canvas.height = h;
            }
        }

        if (typeof ResizeObserver !== 'undefined') {
            new ResizeObserver(syncSize).observe(canvas.parentElement);
        }
        syncSize();

        const gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
        if (!gl) return;

        const vs = `attribute vec2 a_position;
            varying vec2 v_texCoord;
            void main() {
                v_texCoord = a_position * 0.5 + 0.5;
                gl_Position = vec4(a_position, 0.0, 1.0);
            }`;

        const fs = `precision highp float;
            uniform float u_time;
            uniform vec2 u_resolution;
            varying vec2 v_texCoord;

            float smoothPulse(float x, float center, float width) {
                float d = abs(x - center);
                return 1.0 - smoothstep(0.0, width, d);
            }

            void main() {
                vec2 uv = v_texCoord;

                float speed = 3.2;
                float x = uv.x * 14.0 - u_time * speed;
                float base_line = 0.48;

                float cycle = mod(x, 6.2832);
                float heartbeat = 0.0;

                // QRS Complex
                float qrs_pos = 0.15;
                float qrs_amplitude = 0.32;
                float r_wave = exp(-pow((cycle - qrs_pos) * 18.0, 2.0)) * qrs_amplitude;
                float q_wave = -exp(-pow((cycle - (qrs_pos - 0.08)) * 25.0, 2.0)) * 0.08;
                float s_wave = -exp(-pow((cycle - (qrs_pos + 0.10)) * 22.0, 2.0)) * 0.06;
                heartbeat += r_wave + q_wave + s_wave;

                // T Wave
                float t_pos = 0.75;
                float t_amplitude = 0.10;
                float t_wave = exp(-pow((cycle - t_pos) * 6.0, 2.0)) * t_amplitude;
                heartbeat += t_wave;

                // P Wave
                float p_pos = 4.9;
                float p_amplitude = 0.04;
                float p_wave = exp(-pow((cycle - p_pos) * 8.0, 2.0)) * p_amplitude;
                heartbeat += p_wave;

                // U Wave
                float u_pos = 1.3;
                float u_amplitude = 0.015;
                float u_wave = exp(-pow((cycle - u_pos) * 12.0, 2.0)) * u_amplitude;
                heartbeat += u_wave;

                float line_pos = base_line + heartbeat;
                float dist = abs(uv.y - line_pos);

                float glow = exp(-dist * 55.0);
                float trail = exp(-dist * 15.0) * 0.15;
                glow = max(glow, trail);

                vec3 color = vec3(0.0, 0.65, 0.82) * glow;
                float pulse = sin(u_time * 0.4) * 0.06 + 0.94;
                color *= pulse;

                float alpha = glow * 0.45;

                gl_FragColor = vec4(color, alpha);
            }`;

        function createShader(type, src) {
            const s = gl.createShader(type);
            gl.shaderSource(s, src);
            gl.compileShader(s);
            return s;
        }

        const prog = gl.createProgram();
        gl.attachShader(prog, createShader(gl.VERTEX_SHADER, vs));
        gl.attachShader(prog, createShader(gl.FRAGMENT_SHADER, fs));
        gl.linkProgram(prog);
        gl.useProgram(prog);

        const buf = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, buf);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1, -1, 1, -1, -1, 1, 1, 1]), gl.STATIC_DRAW);

        const pos = gl.getAttribLocation(prog, 'a_position');
        gl.enableVertexAttribArray(pos);
        gl.vertexAttribPointer(pos, 2, gl.FLOAT, false, 0, 0);

        const uTime = gl.getUniformLocation(prog, 'u_time');
        const uRes = gl.getUniformLocation(prog, 'u_resolution');

        let animationId = null;

        function render(t) {
            try {
                syncSize();
                gl.viewport(0, 0, canvas.width, canvas.height);
                if (uTime) gl.uniform1f(uTime, t * 0.001);
                if (uRes) gl.uniform2f(uRes, canvas.width, canvas.height);
                gl.drawArrays(gl.TRIANGLE_STRIP, 0, 4);
                animationId = requestAnimationFrame(render);
            } catch (e) {
                if (animationId) {
                    cancelAnimationFrame(animationId);
                    animationId = null;
                }
            }
        }

        if (canvas.parentElement) {
            render(0);
        }

        window.addEventListener('beforeunload', function() {
            if (animationId) {
                cancelAnimationFrame(animationId);
                animationId = null;
            }
        });

    } catch (e) {
        console.warn('ECG shader error:', e.message);
    }
})();


// ============================================
// 4. SCROLL REVEAL
// ============================================
(function() {
    try {
        const revealElements = document.querySelectorAll('.reveal-on-scroll');
        if (revealElements.length === 0) return;

        const revealCallback = (entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        };

        const revealObserver = new IntersectionObserver(revealCallback, {
            threshold: 0.15,
            rootMargin: "0px 0px -50px 0px"
        });

        revealElements.forEach(el => revealObserver.observe(el));
    } catch (e) {
        // نتجاوز الأخطاء
    }
})();


// ============================================
// 5. COUNT UP ANIMATION
// ============================================
(function() {
    try {
        const countElements = document.querySelectorAll('.stat__number, .stat-number, .count-number');
        if (countElements.length === 0) return;

        function animateCount(element) {
            const target = parseInt(element.dataset.target);
            if (isNaN(target)) return;

            const duration = 800;
            const startTime = performance.now();

            function update(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const ease = 1 - Math.pow(1 - progress, 3);
                const current = Math.round(ease * target);

                element.textContent = target >= 1000 ? current.toLocaleString() : current;

                if (progress < 1) {
                    requestAnimationFrame(update);
                } else {
                    element.textContent = target >= 1000 ? target.toLocaleString() : target;
                    element.style.opacity = 1;
                }
            }
            requestAnimationFrame(update);
        }

        const countObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCount(entry.target);
                    countObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });

        countElements.forEach(el => countObserver.observe(el));
    } catch (e) {
        // نتجاوز الأخطاء
    }
})();


// ============================================
// 6. MOBILE MENU TOGGLE
// ============================================
(function() {
    try {
        const menuBtn = document.getElementById('mobileMenuToggle');
        const nav = document.querySelector('.header__nav');

        if (menuBtn && nav) {
            menuBtn.addEventListener('click', () => {
                const isOpen = nav.style.display === 'block';
                nav.style.display = isOpen ? 'none' : 'block';
                menuBtn.innerHTML = isOpen ?
                    '<span class="material-symbols-outlined">menu</span>' :
                    '<span class="material-symbols-outlined">close</span>';
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) {
                    nav.style.display = '';
                    if (menuBtn) {
                        menuBtn.innerHTML = '<span class="material-symbols-outlined">menu</span>';
                    }
                }
            });
        }
    } catch (e) {
        // نتجاوز الأخطاء
    }
})();


// ============================================
// 7. PASSWORD TOGGLE
// ============================================
window.togglePassword = function() {
    try {
        const input = document.getElementById('password');
        const icon = document.getElementById('visibility-icon');
        if (!input || !icon) return;

        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility_off';
        }
    } catch (e) {
        // نتجاوز الأخطاء
    }
};


// ============================================
// 8. MODULES PAGE - SEARCH, FILTER & SORT
// ============================================
(function() {
    'use strict';

    // تأكد من وجود العناصر الخاصة بصفحة الموديولات
    const searchInput = document.getElementById('searchModules');
    const filterSelect = document.getElementById('filterStatus');
    const sortSelect = document.getElementById('sortBy');
    const grid = document.getElementById('modulesGrid');

    // إذا لم توجد هذه العناصر، نخرج من الدالة (الصفحة الحالية ليست صفحة الموديولات)
    if (!searchInput && !filterSelect && !sortSelect) return;

    const modules = document.querySelectorAll('.module-card');

    // --- Search Functionality ---
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();

            modules.forEach(function(module) {
                const title = module.querySelector('.module-card__title').textContent.toLowerCase();
                const desc = module.querySelector('.module-card__desc').textContent.toLowerCase();

                if (title.includes(query) || desc.includes(query)) {
                    module.style.display = '';
                } else {
                    module.style.display = 'none';
                }
            });
        });
    }

    // --- Filter Functionality ---
    if (filterSelect) {
        filterSelect.addEventListener('change', function() {
            const value = this.value;

            modules.forEach(function(module) {
                const status = module.dataset.status;

                if (value === 'all' || status === value) {
                    module.style.display = '';
                } else {
                    module.style.display = 'none';
                }
            });
        });
    }

    // --- Sort Functionality ---
    if (sortSelect && grid) {
        sortSelect.addEventListener('change', function() {
            const value = this.value;
            const modulesArray = Array.from(modules);

            modulesArray.sort(function(a, b) {
                if (value === 'name') {
                    const nameA = a.querySelector('.module-card__title').textContent;
                    const nameB = b.querySelector('.module-card__title').textContent;
                    return nameA.localeCompare(nameB);
                } else if (value === 'progress') {
                    return parseFloat(a.dataset.progress) - parseFloat(b.dataset.progress);
                } else if (value === 'progress-desc') {
                    return parseFloat(b.dataset.progress) - parseFloat(a.dataset.progress);
                } else if (value === 'cases') {
                    return parseInt(a.dataset.cases) - parseInt(b.dataset.cases);
                }
                return 0;
            });

            // Re-append sorted items
            modulesArray.forEach(function(item) {
                grid.appendChild(item);
            });
        });
    }

})();


// ============================================
// 9. INIT - تشغيل كل شيء عند التحميل
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ SINA: All scripts initialized successfully');
});