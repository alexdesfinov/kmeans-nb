<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="FADEL — Sistem Deteksi Kecanduan Internet pada SD Negeri 16 Timbalun menggunakan K-Means & Naive Bayes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>FADEL — Sistem Deteksi Kecanduan Internet</title>
    <link rel="icon" href="assets/img/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #cb0c9f;
            --primary-light: #e84dc5;
            --primary-dark: #a00a7e;
            --dark: #344767;
            --secondary: #627594;
            --body-bg: #f0f2f5;
            --gradient-primary: linear-gradient(135deg, #7928ca 0%, #cb0c9f 100%);
            --gradient-hero: linear-gradient(135deg, #1a0533 0%, #2d1054 40%, #4a1a6b 70%, #1a0533 100%);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font); color: var(--dark); overflow-x: hidden; }

        /* ===== NAVBAR ===== */
        .fadel-nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            padding: 1rem 0;
            transition: all 0.4s ease;
        }
        .fadel-nav.scrolled {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(20px);
            box-shadow: 0 4px 30px rgba(0,0,0,0.08);
            padding: 0.6rem 0;
        }
        .fadel-nav .nav-brand {
            font-weight: 800; font-size: 1.4rem; color: #fff;
            text-decoration: none; letter-spacing: -0.5px;
        }
        .fadel-nav.scrolled .nav-brand { color: var(--dark); }
        .fadel-nav .nav-links a {
            color: rgba(255,255,255,0.8); text-decoration: none;
            font-weight: 500; font-size: 0.9rem; margin-left: 2rem;
            transition: color 0.3s;
        }
        .fadel-nav.scrolled .nav-links a { color: var(--secondary); }
        .fadel-nav .nav-links a:hover { color: #fff; }
        .fadel-nav.scrolled .nav-links a:hover { color: var(--primary); }
        .fadel-nav .btn-masuk {
            background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3);
            color: #fff; padding: 8px 24px; border-radius: 10px;
            font-weight: 600; font-size: 0.85rem; transition: all 0.3s;
            text-decoration: none; margin-left: 2rem;
        }
        .fadel-nav.scrolled .btn-masuk {
            background: var(--gradient-primary); border: none; color: #fff;
            box-shadow: 0 4px 16px rgba(203,12,159,0.3);
        }
        .fadel-nav .btn-masuk:hover { transform: translateY(-2px); }

        /* ===== HERO ===== */
        .hero {
            min-height: 100vh;
            background: var(--gradient-hero);
            display: flex; align-items: center;
            position: relative; overflow: hidden;
        }
        .hero::before {
            content: ''; position: absolute;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(203,12,159,0.15) 0%, transparent 70%);
            top: -100px; right: -100px; border-radius: 50%;
        }
        .hero::after {
            content: ''; position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(121,40,202,0.1) 0%, transparent 70%);
            bottom: -50px; left: -50px; border-radius: 50%;
        }
        .hero-content { position: relative; z-index: 2; }
        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.15);
            padding: 6px 18px; border-radius: 50px;
            color: rgba(255,255,255,0.9); font-size: 0.8rem;
            font-weight: 500; margin-bottom: 1.5rem;
            letter-spacing: 0.5px;
        }
        .hero h1 {
            font-size: 3.5rem; font-weight: 900;
            color: #fff; line-height: 1.1;
            margin-bottom: 1.5rem; letter-spacing: -1.5px;
        }
        .hero h1 span {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero p {
            color: rgba(255,255,255,0.7);
            font-size: 1.1rem; line-height: 1.7;
            max-width: 500px; margin-bottom: 2rem;
        }
        .hero-cta {
            display: inline-flex; align-items: center; gap: 12px;
            background: var(--gradient-primary); color: #fff;
            padding: 14px 32px; border-radius: 14px;
            font-weight: 700; font-size: 0.95rem;
            text-decoration: none; transition: all 0.3s;
            box-shadow: 0 8px 32px rgba(203,12,159,0.35);
        }
        .hero-cta:hover { transform: translateY(-3px); box-shadow: 0 12px 40px rgba(203,12,159,0.5); color: #fff; }

        /* Hero Visual */
        .hero-visual {
            position: relative; z-index: 2;
        }
        .hero-card {
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 24px; padding: 2.5rem;
            color: #fff;
        }
        .hero-card .stat-row {
            display: flex; gap: 1.5rem; margin-bottom: 1.5rem;
        }
        .hero-card .stat-item {
            flex: 1; text-align: center;
            background: rgba(255,255,255,0.05);
            border-radius: 16px; padding: 1.2rem 0.8rem;
        }
        .hero-card .stat-item .num {
            font-size: 1.8rem; font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .hero-card .stat-item .label {
            font-size: 0.7rem; opacity: 0.6;
            text-transform: uppercase; letter-spacing: 1px;
            margin-top: 4px;
        }
        .hero-card .algo-tag {
            display: inline-block;
            background: rgba(203,12,159,0.15);
            color: var(--primary-light);
            padding: 4px 14px; border-radius: 8px;
            font-size: 0.75rem; font-weight: 600;
            margin-right: 8px; margin-bottom: 8px;
        }

        /* ===== FEATURES ===== */
        .features {
            padding: 6rem 0;
            background: #fff;
        }
        .section-label {
            display: inline-block;
            background: rgba(203,12,159,0.08);
            color: var(--primary);
            padding: 6px 18px; border-radius: 50px;
            font-size: 0.75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1.5px;
            margin-bottom: 1rem;
        }
        .section-title {
            font-size: 2.2rem; font-weight: 800;
            color: var(--dark); letter-spacing: -0.8px;
            margin-bottom: 0.75rem;
        }
        .section-desc {
            color: var(--secondary); font-size: 1rem;
            max-width: 550px; line-height: 1.7;
        }
        .feature-card {
            background: #fff;
            border: 1px solid rgba(0,0,0,0.06);
            border-radius: 20px; padding: 2rem;
            transition: all 0.4s cubic-bezier(0.25,0.8,0.25,1);
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            border-color: transparent;
        }
        .feature-icon {
            width: 56px; height: 56px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.25rem; font-size: 1.4rem; color: #fff;
        }
        .feature-card h5 {
            font-weight: 700; font-size: 1.05rem;
            margin-bottom: 0.5rem; color: var(--dark);
        }
        .feature-card p {
            color: var(--secondary); font-size: 0.85rem;
            line-height: 1.6; margin: 0;
        }

        /* ===== HOW IT WORKS ===== */
        .how-it-works {
            padding: 6rem 0;
            background: var(--body-bg);
        }
        .step-card {
            text-align: center; padding: 2rem 1.5rem;
            position: relative;
        }
        .step-number {
            width: 64px; height: 64px;
            border-radius: 20px;
            background: var(--gradient-primary);
            color: #fff; font-weight: 800; font-size: 1.4rem;
            display: inline-flex; align-items: center; justify-content: center;
            margin-bottom: 1.25rem;
            box-shadow: 0 8px 24px rgba(203,12,159,0.3);
        }
        .step-card h5 {
            font-weight: 700; font-size: 1.05rem;
            margin-bottom: 0.5rem; color: var(--dark);
        }
        .step-card p {
            color: var(--secondary); font-size: 0.85rem;
            line-height: 1.6;
        }
        .step-connector {
            position: absolute; top: 48px; right: -30px;
            font-size: 1.5rem; color: #d0d5dd;
        }

        /* ===== LOGIN SECTION ===== */
        .login-section {
            padding: 6rem 0;
            background: #fff;
        }
        .login-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            padding: 3rem;
            border: 1px solid rgba(0,0,0,0.04);
        }
        .login-card h3 {
            font-weight: 800; font-size: 1.6rem;
            margin-bottom: 0.5rem; color: var(--dark);
        }
        .login-card .subtitle {
            color: var(--secondary); font-size: 0.9rem;
            margin-bottom: 2rem;
        }
        .login-card label {
            font-weight: 600; font-size: 0.82rem;
            color: var(--dark); margin-bottom: 6px;
        }
        .login-card .form-control {
            border: 1.5px solid #e0e3e8;
            border-radius: 12px; padding: 12px 16px;
            font-size: 0.9rem; transition: all 0.3s;
            font-family: var(--font);
        }
        .login-card .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(203,12,159,0.1);
        }
        .login-card .btn-login {
            background: var(--gradient-primary); color: #fff;
            border: none; border-radius: 12px;
            padding: 13px; font-weight: 700; font-size: 0.95rem;
            width: 100%; transition: all 0.3s;
            box-shadow: 0 4px 16px rgba(203,12,159,0.3);
        }
        .login-card .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(203,12,159,0.45);
        }
        .login-info-side {
            display: flex; flex-direction: column; justify-content: center;
            height: 100%;
        }
        .login-info-side h2 {
            font-weight: 800; font-size: 2rem;
            color: var(--dark); letter-spacing: -0.5px;
            margin-bottom: 1rem;
        }
        .login-info-side p {
            color: var(--secondary); font-size: 0.95rem;
            line-height: 1.7; margin-bottom: 1.5rem;
        }
        .info-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(130,214,22,0.1); color: #2d8a0e;
            padding: 8px 16px; border-radius: 10px;
            font-size: 0.8rem; font-weight: 600;
        }

        /* ===== FOOTER ===== */
        .site-footer {
            background: var(--dark); color: rgba(255,255,255,0.6);
            padding: 3rem 0; text-align: center;
            font-size: 0.85rem;
        }
        .site-footer strong { color: #fff; }
        .site-footer a { color: var(--primary-light); text-decoration: none; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero h1 { font-size: 2.2rem; }
            .section-title { font-size: 1.6rem; }
            .fadel-nav .nav-links { display: none; }
            .step-connector { display: none; }
            .hero-card { margin-top: 2rem; }
        }

        /* ===== ANIMATIONS ===== */
        .fade-up {
            opacity: 0; transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .fade-up.visible { opacity: 1; transform: translateY(0); }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="fadel-nav" id="mainNav">
        <div class="container d-flex align-items-center justify-content-between">
            <a class="nav-brand" href="?">FADEL</a>
            <div class="d-flex align-items-center">
                <div class="nav-links d-none d-md-flex">
                    <a href="#features">Fitur</a>
                    <a href="#how-it-works">Cara Kerja</a>
                    <a href="#login">Masuk</a>
                </div>
                <a class="btn-masuk" href="portal">Masuk Portal</a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero" id="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <div class="hero-badge">
                        <i class="fas fa-microscope me-2"></i>Penelitian Teknik Informatika
                    </div>
                    <h1>Deteksi <span>Kecanduan Internet</span> dengan Data Mining</h1>
                    <p>Sistem analisis tingkat kecanduan internet menggunakan algoritma hybrid K-Means Clustering & Naive Bayes pada SD Negeri 16 Timbalun.</p>
                    <a href="#login" class="hero-cta">
                        Mulai Analisis
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="col-lg-5 offset-lg-1 hero-visual d-none d-lg-block">
                    <div class="hero-card">
                        <div class="stat-row">
                            <div class="stat-item">
                                <div class="num">4</div>
                                <div class="label">Cluster</div>
                            </div>
                            <div class="stat-item">
                                <div class="num">20</div>
                                <div class="label">Pertanyaan</div>
                            </div>
                            <div class="stat-item">
                                <div class="num">6</div>
                                <div class="label">Fitur K</div>
                            </div>
                        </div>
                        <div>
                            <span class="algo-tag">K-Means</span>
                            <span class="algo-tag">Naive Bayes</span>
                            <span class="algo-tag">Euclidean</span>
                            <span class="algo-tag">Laplace α=1.0</span>
                        </div>
                        <div style="margin-top:1.2rem;padding-top:1.2rem;border-top:1px solid rgba(255,255,255,0.08);">
                            <div style="font-size:0.7rem;opacity:0.5;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">Klasifikasi</div>
                            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                <span style="background:rgba(130,214,22,0.15);color:#82d616;padding:4px 12px;border-radius:8px;font-size:0.72rem;font-weight:600;">Normal</span>
                                <span style="background:rgba(251,207,51,0.15);color:#fbcf33;padding:4px 12px;border-radius:8px;font-size:0.72rem;font-weight:600;">Ringan</span>
                                <span style="background:rgba(23,193,232,0.15);color:#17c1e8;padding:4px 12px;border-radius:8px;font-size:0.72rem;font-weight:600;">Sedang</span>
                                <span style="background:rgba(234,6,6,0.15);color:#ea0606;padding:4px 12px;border-radius:8px;font-size:0.72rem;font-weight:600;">Parah</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features" id="features">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-label">Fitur Unggulan</span>
                <h2 class="section-title">Analisis Cerdas & Akurat</h2>
                <p class="section-desc mx-auto">Menggunakan pendekatan hybrid data mining untuk mengklasifikasikan tingkat kecanduan internet secara transparan dan ilmiah.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card fade-up">
                        <div class="feature-icon" style="background:linear-gradient(135deg,#7928ca,#cb0c9f);">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        <h5>K-Means Clustering</h5>
                        <p>Mengelompokkan responden ke dalam 4 cluster berdasarkan pola jawaban dengan iterasi transparan.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card fade-up">
                        <div class="feature-icon" style="background:linear-gradient(135deg,#21d4fd,#17c1e8);">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h5>Naive Bayes</h5>
                        <p>Prediksi tingkat kecanduan data testing berdasarkan model training dengan Laplace smoothing.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card fade-up">
                        <div class="feature-icon" style="background:linear-gradient(135deg,#98ec2d,#17ad37);">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h5>Laporan Cetak</h5>
                        <p>Cetak laporan hasil analisis lengkap dengan kop surat, siap untuk dokumentasi akademik.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card fade-up">
                        <div class="feature-icon" style="background:linear-gradient(135deg,#f5d100,#f09819);">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5>Multi-User</h5>
                        <p>Sistem mendukung admin (peneliti) dan user (responden) dengan akses yang terpisah.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works" id="how-it-works">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-label">Cara Kerja</span>
                <h2 class="section-title">3 Langkah Mudah</h2>
                <p class="section-desc mx-auto">Proses analisis yang sederhana untuk menghasilkan klasifikasi tingkat kecanduan internet.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="step-card fade-up">
                        <div class="step-number">1</div>
                        <h5>Isi Kuesioner</h5>
                        <p>Responden menjawab 20 pertanyaan tentang kebiasaan penggunaan internet & gadget.</p>
                        <span class="step-connector d-none d-md-block"><i class="fas fa-chevron-right"></i></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card fade-up">
                        <div class="step-number">2</div>
                        <h5>Proses Analisis</h5>
                        <p>Sistem memproses data dengan K-Means Clustering dan Naive Bayes classifier.</p>
                        <span class="step-connector d-none d-md-block"><i class="fas fa-chevron-right"></i></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card fade-up">
                        <div class="step-number">3</div>
                        <h5>Lihat Hasil</h5>
                        <p>Dapatkan klasifikasi: Normal, Ringan, Sedang, atau Parah — lengkap dengan detail proses.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Section -->
    <section class="login-section" id="login">
        <div class="container">
            <div class="row justify-content-center align-items-center g-5">
                <div class="col-lg-5">
                    <div class="login-info-side fade-up">
                        <span class="section-label">Masuk</span>
                        <h2>Akses Portal FADEL</h2>
                        <p>Masuk ke sistem untuk mengelola data, menjalankan analisis, atau mengisi kuesioner sebagai responden.</p>
                        <div>
                            <span class="info-badge"><i class="fas fa-shield-alt"></i> Sistem Aman & Terlindungi</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="login-card fade-up">
                        <h3>Login</h3>
                        <p class="subtitle">Masuk dengan akun Anda</p>
                        <form action="portal/index.php" method="post">
                            <div class="mb-3">
                                <label>Username</label>
                                <input type="text" required name="username" class="form-control" placeholder="Masukkan username">
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" required name="password" class="form-control" placeholder="Masukkan password">
                            </div>
                            <div class="form-check form-switch mb-4">
                                <input class="form-check-input" type="checkbox" name="rememberMe" id="rememberMe">
                                <label class="form-check-label" for="rememberMe" style="font-size:0.82rem;color:var(--secondary);">Ingat saya</label>
                            </div>
                            <button type="submit" class="btn-login">Masuk</button>
                            <div class="text-center mt-3">
                                <span style="font-size:0.82rem;color:var(--secondary);">Belum punya akun?</span>
                                <a href="portal/registration.php" style="font-size:0.82rem;font-weight:600;color:var(--primary);text-decoration:none;"> Daftar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <p>© <script>document.write(new Date().getFullYear())</script> <strong>FADEL</strong> — Sistem Deteksi Kecanduan Internet</p>
            <p style="font-size:0.78rem;margin-top:4px;">SD Negeri 16 Timbalun · Padang · Made by <a href="#">Antigravity</a></p>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('mainNav');
            if (window.scrollY > 80) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Scroll reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>

</html>