<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once 'portal/config/koneksi.php';
include_once 'portal/config/function.php';

rememberMeTryLogin($conn);
$isLoggedIn = !empty($_SESSION['id']);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="FADEL — Sistem Deteksi Kecanduan Internet pada SD Negeri 16 Timbalun menggunakan K-Means & Naive Bayes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SD N 16 TIMBALUN — Sistem Deteksi Kecanduan Internet</title>
    <link rel="icon" href="assets/img/favicon.png">
    <link href="portal/assets/css/inter.css" rel="stylesheet">
    <link rel="stylesheet" href="portal/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <style>
        :root {
            --primary: #1e293b;
            --primary-light: #475569;
            --primary-dark: #0f172a;
            --accent: #64748b;
            --dark: #0f172a;
            --secondary: #627594;
            --body-bg: #f0f2f5;
            --gradient-primary: linear-gradient(135deg, #0f172a 0%, #334155 100%);
            --gradient-hero: linear-gradient(135deg, #0f172a 0%, #1e293b 40%, #334155 70%, #0f172a 100%);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 80px;
        }
        body { font-family: var(--font); color: var(--primary); overflow-x: hidden; }

        .features, .how-it-works, .login-section {
            scroll-margin-top: 80px;
        }

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
        .fadel-nav.scrolled .nav-brand { color: var(--primary); }
        .fadel-nav .nav-links a {
            color: rgba(255,255,255,0.7); text-decoration: none;
            font-weight: 500; font-size: 0.9rem; margin-left: 2rem;
            transition: color 0.3s;
        }
        .fadel-nav.scrolled .nav-links a { color: var(--secondary); }
        .fadel-nav .nav-links a:hover { color: #fff; }
        .fadel-nav.scrolled .nav-links a:hover { color: var(--primary); }
        .fadel-nav .btn-masuk {
            background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.25);
            color: #fff; padding: 8px 24px; border-radius: 10px;
            font-weight: 600; font-size: 0.85rem; transition: all 0.3s;
            text-decoration: none; margin-left: 2rem;
        }
        .fadel-nav.scrolled .btn-masuk {
            background: var(--gradient-primary); border: none; color: #fff;
            box-shadow: 0 4px 16px rgba(15,23,42,0.25);
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
            background: radial-gradient(circle, rgba(100,116,139,0.12) 0%, transparent 70%);
            top: -100px; right: -100px; border-radius: 50%;
        }
        .hero::after {
            content: ''; position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(71,85,105,0.08) 0%, transparent 70%);
            bottom: -50px; left: -50px; border-radius: 50%;
        }
        .hero-content { position: relative; z-index: 2; }
        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.12);
            padding: 6px 18px; border-radius: 50px;
            color: rgba(255,255,255,0.8); font-size: 0.8rem;
            font-weight: 500; margin-bottom: 1.5rem;
            letter-spacing: 0.5px;
        }
        .hero h1 {
            font-size: 3.5rem; font-weight: 900;
            color: #fff; line-height: 1.1;
            margin-bottom: 1.5rem; letter-spacing: -1.5px;
        }
        .hero h1 span {
            background: linear-gradient(135deg, #94a3b8, #e2e8f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero p {
            color: rgba(255,255,255,0.6);
            font-size: 1.1rem; line-height: 1.7;
            max-width: 500px; margin-bottom: 2rem;
        }
        .hero-cta {
            display: inline-flex; align-items: center; gap: 12px;
            background: #fff; color: var(--primary);
            padding: 14px 32px; border-radius: 14px;
            font-weight: 700; font-size: 0.95rem;
            text-decoration: none; transition: all 0.3s;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        }
        .hero-cta:hover { transform: translateY(-3px); box-shadow: 0 12px 40px rgba(0,0,0,0.3); color: var(--primary); }

        /* Hero Visual */
        .hero-visual {
            position: relative; z-index: 2;
        }
        .hero-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px; padding: 2.5rem;
            color: #fff;
        }
        .hero-card .stat-row {
            display: flex; gap: 1.5rem; margin-bottom: 1.5rem;
        }
        .hero-card .stat-item {
            flex: 1; text-align: center;
            background: rgba(255,255,255,0.04);
            border-radius: 16px; padding: 1.2rem 0.8rem;
        }
        .hero-card .stat-item .num {
            font-size: 1.8rem; font-weight: 800;
            color: #e2e8f0;
        }
        .hero-card .stat-item .label {
            font-size: 0.7rem; opacity: 0.5;
            text-transform: uppercase; letter-spacing: 1px;
            margin-top: 4px;
        }
        .hero-card .algo-tag {
            display: inline-block;
            background: rgba(148,163,184,0.15);
            color: #94a3b8;
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
            background: rgba(30,41,59,0.06);
            color: var(--primary);
            padding: 6px 18px; border-radius: 50px;
            font-size: 0.75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1.5px;
            margin-bottom: 1rem;
        }
        .section-title {
            font-size: 2.2rem; font-weight: 800;
            color: var(--primary); letter-spacing: -0.8px;
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
            margin-bottom: 0.5rem; color: var(--primary);
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
            box-shadow: 0 8px 24px rgba(15,23,42,0.25);
        }
        .step-card h5 {
            font-weight: 700; font-size: 1.05rem;
            margin-bottom: 0.5rem; color: var(--primary);
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
            margin-bottom: 0.5rem; color: var(--primary);
        }
        .login-card .subtitle {
            color: var(--secondary); font-size: 0.9rem;
            margin-bottom: 2rem;
        }
        .login-card label {
            font-weight: 600; font-size: 0.82rem;
            color: var(--primary); margin-bottom: 6px;
        }
        .login-card .form-control {
            border: 1.5px solid #e0e3e8;
            border-radius: 12px; padding: 12px 16px;
            font-size: 0.9rem; transition: all 0.3s;
            font-family: var(--font);
        }
        .login-card .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(30,41,59,0.08);
        }
        .login-card .btn-login {
            background: var(--gradient-primary); color: #fff;
            border: none; border-radius: 12px;
            padding: 13px; font-weight: 700; font-size: 0.95rem;
            width: 100%; transition: all 0.3s;
            box-shadow: 0 4px 16px rgba(15,23,42,0.2);
        }
        .login-card .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(15,23,42,0.35);
        }
        .login-info-side {
            display: flex; flex-direction: column; justify-content: center;
            height: 100%;
        }
        .login-info-side h2 {
            font-weight: 800; font-size: 2rem;
            color: var(--primary); letter-spacing: -0.5px;
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
            background: var(--dark); color: rgba(255,255,255,0.5);
            padding: 3rem 0; text-align: center;
            font-size: 0.85rem;
        }
        .site-footer strong { color: #fff; }
        .site-footer a { color: #94a3b8; text-decoration: none; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            html {
                scroll-padding-top: 100px;
            }
            .hero {
                padding-top: 120px !important;
                padding-bottom: 60px !important;
                min-height: auto !important;
            }
            .hero h1 { font-size: 2.2rem; }
            .section-title { font-size: 1.6rem; }
            .fadel-nav .nav-links { display: none; }
            .step-connector { display: none; }
            .hero-card { margin-top: 2rem; }

            /* Spacing adjustments to prevent fixed navbar overlap */
            .features, .how-it-works, .login-section {
                padding-top: 6rem !important;
                padding-bottom: 3rem !important;
                scroll-margin-top: 100px;
            }

            .fadel-nav .nav-brand {
                font-size: 1rem;
                white-space: nowrap;
            }
            .fadel-nav {
                padding: 0.8rem 0;
            }
            .fadel-nav.scrolled {
                padding: 0.5rem 0;
            }
            .fadel-nav .btn-masuk {
                padding: 6px 12px;
                font-size: 0.78rem;
                margin-left: 1rem;
                white-space: nowrap;
            }
        }

        /* ===== ANIMATIONS ===== */
        .fade-up {
            opacity: 0; transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .fade-up.visible { opacity: 1; transform: translateY(0); }

        /* Sembunyikan ikon mata bawaan Microsoft Edge/IE */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none !important;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="fadel-nav" id="mainNav">
        <div class="container d-flex align-items-center justify-content-between">
            <a class="nav-brand" href="?">SD NEGERI 16 TIMBALUN</a>
            <div class="d-flex align-items-center">
                <div class="nav-links d-none d-md-flex">
                    <a href="#features">Fitur</a>
                    <a href="#how-it-works">Cara Kerja</a>
                    <a href="#about">Tentang</a>
                    <?php if (!$isLoggedIn): ?>
                        <a href="#login">Masuk</a>
                    <?php endif; ?>
                </div>
                <a class="btn-masuk" href="portal"><?= $isLoggedIn ? 'Portal' : 'Masuk Portal' ?></a>
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
                    <a href="portal/" class="hero-cta">
                        Mulai
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="col-lg-5 offset-lg-1 hero-visual d-none d-lg-block">
                    <?php
                    $initCentroids = getInitialCentroidsFromDB($conn);
                    $countCluster = count($initCentroids);
                    if ($countCluster === 0) {
                        $countCluster = 3; // fallback default
                    }
                    $countPertanyaan = 20; // default 20
                    $countFitur = count(kategoriMap());

                    $activeClusterNames = mapClusterNamesFixed($countCluster);
                    $activeClasses = [];
                    foreach ($activeClusterNames as $name) {
                        $activeClasses[] = normalizeNbLabel($name);
                    }
                    $order = ['Ringan', 'Sedang', 'Parah'];
                    $renderedClasses = [];
                    foreach ($order as $o) {
                        if (in_array($o, $activeClasses)) {
                            $renderedClasses[] = $o;
                        }
                    }
                    foreach ($activeClasses as $ac) {
                        if (!in_array($ac, $renderedClasses)) {
                            $renderedClasses[] = $ac;
                        }
                    }
                    ?>
                    <div class="hero-card">
                        <div class="stat-row">
                            <div class="stat-item">
                                <div class="num"><?= $countCluster ?></div>
                                <div class="label">Cluster</div>
                            </div>
                            <div class="stat-item">
                                <div class="num"><?= $countPertanyaan ?></div>
                                <div class="label">Pertanyaan</div>
                            </div>
                            <div class="stat-item">
                                <div class="num"><?= $countFitur ?></div>
                                <div class="label">Fitur K</div>
                            </div>
                        </div>
                        <div>
                            <span class="algo-tag">K-Means</span>
                            <span class="algo-tag">Naive Bayes</span>
                            <span class="algo-tag">Euclidean</span>
                            <span class="algo-tag">Laplace α=1.0</span>
                        </div>
                        <div style="margin-top:1.2rem;padding-top:1.2rem;border-top:1px solid rgba(255,255,255,0.06);">
                            <div style="font-size:0.7rem;opacity:0.4;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">Klasifikasi</div>
                            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                <?php
                                foreach ($renderedClasses as $cls) {
                                    $bg = 'rgba(100, 116, 139, 0.15)'; // gray fallback
                                    $color = '#94a3b8';
                                    
                                    if (strtolower($cls) === 'normal') {
                                        $bg = 'rgba(130,214,22,0.15)';
                                        $color = '#82d616';
                                    } elseif (strtolower($cls) === 'ringan') {
                                        $bg = 'rgba(251,207,51,0.15)';
                                        $color = '#fbcf33';
                                    } elseif (strtolower($cls) === 'sedang') {
                                        $bg = 'rgba(23,193,232,0.15)';
                                        $color = '#17c1e8';
                                    } elseif (strtolower($cls) === 'parah') {
                                        $bg = 'rgba(234,6,6,0.15)';
                                        $color = '#ea0606';
                                    }
                                    
                                    echo '<span style="background:' . $bg . ';color:' . $color . ';padding:4px 12px;border-radius:8px;font-size:0.72rem;font-weight:600;">' . htmlspecialchars($cls) . '</span>';
                                }
                                ?>
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
                        <div class="feature-icon" style="background:linear-gradient(135deg,#0f172a,#334155);">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        <h5>K-Means Clustering</h5>
                        <p>Mengelompokkan responden ke dalam <?= $countCluster ?> cluster berdasarkan pola jawaban dengan iterasi transparan.</p>
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
            <div class="row justify-content-center g-4">
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
                        <?php
                        $listString = implode(', ', $renderedClasses);
                        if (count($renderedClasses) > 1) {
                            $lastCommaPos = strrpos($listString, ', ');
                            if ($lastCommaPos !== false) {
                                $listString = substr_replace($listString, ' atau ', $lastCommaPos, 2);
                            }
                        }
                        ?>
                        <p>Dapatkan klasifikasi: <?= htmlspecialchars($listString) ?> — lengkap dengan detail proses.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="features" id="about" style="padding: 6rem 0; background: #fff;">
        <div class="container">
            <div class="row align-items-center justify-content-between g-5">
                <div class="col-lg-5">
                    <div class="fade-up visible">
                        <span class="section-label">Tentang Sekolah</span>
                        <h2 class="section-title"><span style="background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">SD</span> Negeri 16 Timbalun</h2>
                        <p class="mt-4" style="text-align: justify; color: var(--secondary); font-size: 0.95rem; line-height: 1.8;">
                            SD Negeri 16 Timbalun merupakan sekolah dasar negeri di Kelurahan Bungus Timur, Kota Padang, Provinsi Sumatera Barat, yang berdiri sejak tahun 1981. Sekolah ini berstatus negeri di bawah Pemerintah Daerah, memiliki luas tanah 2.200 m², and menyelenggarakan kegiatan belajar pada pagi hari selama enam hari dalam seminggu. Dengan akreditasi B, SD Negeri 16 Timbalun didukung fasilitas akses internet dan listrik PLN sebagai wujud komitmen dalam meningkatkan kualitas pendidikan berbasis teknologi.
                        </p>
                        
                        <!-- Contact Info Cards -->
                        <div class="mt-5" style="display: flex; flex-direction: column; gap: 1.25rem;">
                            <a href="https://maps.app.goo.gl/Yt6hq5JGBGPRm7KR9" target="_blank" style="display: flex; align-items: center; gap: 1rem; text-decoration: none; color: inherit; background: var(--body-bg); padding: 16px 20px; border-radius: 16px; border: 1px solid rgba(0,0,0,0.04); transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                                <div style="width: 44px; height: 44px; border-radius: 12px; background: var(--gradient-primary, linear-gradient(135deg, #0f172a, #334155)); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.1rem; flex-shrink: 0;">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <span style="font-size: 0.88rem; font-weight: 500; color: var(--primary-light); line-height: 1.5;">Jln Timbalun, Kec. Bungus Teluk Kabung, Kota Padang, Prov. Sumatera Barat</span>
                            </a>
                            
                            <a href="mailto:sdnenambelastimbalun@gmail.com" style="display: flex; align-items: center; gap: 1rem; text-decoration: none; color: inherit; background: var(--body-bg); padding: 16px 20px; border-radius: 16px; border: 1px solid rgba(0,0,0,0.04); transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                                <div style="width: 44px; height: 44px; border-radius: 12px; background: var(--gradient-primary, linear-gradient(135deg, #0f172a, #334155)); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.1rem; flex-shrink: 0;">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <span style="font-size: 0.88rem; font-weight: 500; color: var(--primary-light);">sdnenambelastimbalun@gmail.com</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 d-flex align-items-center justify-content-center" style="align-self: center;">
                    <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(0,0,0,0.06); border-radius: 28px; padding: 1rem; box-shadow: 0 20px 50px rgba(0,0,0,0.05); text-align: center; width: 100%; display: flex; justify-content: center; align-items: center;">
                        <img src="assets/img/td.jpeg" alt="SD Negeri 16 Timbalun" loading="lazy" style="width: 100%; max-width: 500px; height: auto; border-radius: 20px; object-fit: cover; box-shadow: 0 8px 30px rgba(0,0,0,0.06);" />
                    </div>
                </div>
            </div>
            
            <!-- Map Embed iframe -->
            <div class="row mt-5 pt-4">
                <div class="col-12">
                    <div style="border-radius: 24px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.08); border: 1.5px solid rgba(0,0,0,0.06); height: 350px;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1994.5995024025037!2d100.43372080221502!3d-1.0095380123762059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4bb9e55b36f89%3A0x5ce5011fa5622e5e!2sSDN%2016%20Timbalun%2C%20Kel.%20Bungus%20Timur!5e0!3m2!1sid!2sid!4v1770408073568!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Section -->
    <?php if (!$isLoggedIn): ?>
    <section class="login-section" id="login" style="padding: 6rem 0; background: var(--body-bg); border-top: 1px solid rgba(0,0,0,0.03);">
        <div class="container">
            <div class="row justify-content-center align-items-center g-5">
                <div class="col-lg-5">
                    <div class="login-info-side fade-up">
                        <span class="section-label">Masuk</span>
                        <h2>Akses Portal SD Negeri 16 Timbalun</h2>
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
                                 <div class="position-relative">
                                     <input type="password" required name="password" class="form-control" placeholder="Masukkan password" style="padding-right: 45px;">
                                     <button type="button" class="btn-toggle-password position-absolute end-0 top-50 translate-middle-y border-0 bg-transparent text-secondary" style="padding: 10px; cursor: pointer; outline: none; z-index: 10;">
                                         <i class="fa fa-eye-slash" style="font-size: 1rem;"></i>
                                     </button>
                                 </div>
                             </div>
                            <div class="form-check form-switch mb-4">
                                <input class="form-check-input" type="checkbox" name="rememberMe" id="rememberMe">
                                <label class="form-check-label" for="rememberMe" style="font-size:0.82rem;color:var(--secondary);">Ingat saya</label>
                            </div>
                            <button type="submit" class="btn-login">Masuk</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <p>© <script>document.write(new Date().getFullYear())</script> <strong>SD NEGERI 16 TIMBALUN</strong> — Sistem Deteksi Kecanduan Internet</p>
            <p style="font-size:0.78rem;margin-top:4px;">SD Negeri 16 Timbalun · Padang · Made by <a href="#">Moch Reza</a></p>
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

        // Password visibility toggle
        document.querySelectorAll(".btn-toggle-password").forEach(function(btn) {
            btn.addEventListener("click", function() {
                const container = btn.closest(".position-relative");
                if (!container) return;
                const input = container.querySelector("input[type='password'], input[type='text']");
                const icon = btn.querySelector("i");
                if (!input || !icon) return;

                const isPassword = input.getAttribute("type") === "password";
                input.setAttribute("type", isPassword ? "text" : "password");
                if (isPassword) {
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                } else {
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                }
            });
        });
    </script>
</body>

</html>