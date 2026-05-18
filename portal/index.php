<?php
include('config/koneksi.php');
include('config/function.php');

remember_me_try_login($conn);

// kalau sudah auto-login, langsung ke media
if (!empty($_SESSION['id'])) {
  header('Location: media.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  handle_login_post($conn);
}

// TITLE masih dari assets.php
include('config/assets.php');
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Login ke FADEL — Sistem Deteksi Kecanduan Internet">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <title>Login | <?php echo TITLE ?></title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <link id="pagestyle" href="assets/css/soft-ui-dashboard.min3447.css?v=1.0.5" rel="stylesheet" />

  <style>
    :root {
      --fadel-primary: #cb0c9f;
      --gradient-primary: linear-gradient(135deg, #7928ca 0%, #cb0c9f 100%);
      --fadel-dark: #344767;
      --fadel-font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    body { font-family: var(--fadel-font) !important; }
    .async-hide { opacity: 0 !important }

    .auth-page {
      min-height: 100vh;
      display: flex;
      align-items: center;
      background: linear-gradient(135deg, #f0f2f5 0%, #e8e4f0 100%);
    }

    .auth-card {
      background: #fff;
      border-radius: 24px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.08);
      border: 1px solid rgba(0,0,0,0.04);
      overflow: hidden;
    }

    .auth-form-side {
      padding: 3rem;
    }

    .auth-visual-side {
      background: var(--gradient-primary);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 3rem;
      position: relative;
      overflow: hidden;
    }

    .auth-visual-side::before {
      content: '';
      position: absolute;
      width: 300px; height: 300px;
      background: rgba(255,255,255,0.06);
      border-radius: 50%;
      top: -80px; right: -80px;
    }

    .auth-visual-side::after {
      content: '';
      position: absolute;
      width: 200px; height: 200px;
      background: rgba(255,255,255,0.04);
      border-radius: 50%;
      bottom: -60px; left: -30px;
    }

    .auth-visual-content {
      text-align: center;
      color: #fff;
      position: relative;
      z-index: 1;
    }

    .auth-visual-content h2 {
      font-weight: 800;
      font-size: 2rem;
      margin-bottom: 0.75rem;
      letter-spacing: -0.5px;
    }

    .auth-visual-content p {
      opacity: 0.8;
      font-size: 0.9rem;
      line-height: 1.6;
    }

    .auth-form-side h3 {
      font-weight: 800;
      font-size: 1.5rem;
      color: var(--fadel-dark);
      margin-bottom: 0.25rem;
    }

    .auth-form-side .subtitle {
      color: #627594;
      font-size: 0.88rem;
      margin-bottom: 2rem;
    }

    .auth-form-side label {
      font-weight: 600;
      font-size: 0.82rem;
      color: var(--fadel-dark);
    }

    .auth-form-side .form-control {
      border: 1.5px solid #e0e3e8;
      border-radius: 12px;
      padding: 12px 16px;
      font-size: 0.88rem;
      transition: all 0.3s;
      font-family: var(--fadel-font);
    }

    .auth-form-side .form-control:focus {
      border-color: var(--fadel-primary);
      box-shadow: 0 0 0 3px rgba(203,12,159,0.1);
    }

    .btn-auth {
      background: var(--gradient-primary) !important;
      color: #fff !important;
      border: none;
      border-radius: 12px;
      padding: 13px;
      font-weight: 700;
      font-size: 0.92rem;
      width: 100%;
      transition: all 0.3s;
      box-shadow: 0 4px 16px rgba(203,12,159,0.3);
    }

    .btn-auth:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(203,12,159,0.45);
    }

    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      color: #627594;
      text-decoration: none;
      font-size: 0.82rem;
      font-weight: 500;
      transition: color 0.3s;
      margin-bottom: 2rem;
    }
    .back-link:hover { color: var(--fadel-primary); }
  </style>
</head>

<body>
  <div class="auth-page">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
          <a href="../" class="back-link"><i class="ni ni-bold-left"></i> Kembali ke Beranda</a>
          <div class="auth-card">
            <div class="row g-0">
              <div class="col-md-6 auth-form-side">
                <?php flash_render_and_clear(); ?>
                <h3>Login</h3>
                <p class="subtitle">Masuk ke portal <?php echo TITLE ?></p>

                <form action="index.php" method="post">
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
                    <label class="form-check-label" for="rememberMe" style="font-size:0.82rem;color:#627594;">Ingat saya</label>
                  </div>

                  <button type="submit" class="btn-auth">Masuk</button>

                  <div class="text-center mt-3">
                    <span style="font-size:0.82rem;color:#627594;">Belum punya akun?</span>
                    <a href="registration.php" style="font-size:0.82rem;font-weight:600;color:var(--fadel-primary);text-decoration:none;"> Daftar</a>
                  </div>
                </form>
              </div>
              <div class="col-md-6 auth-visual-side d-none d-md-flex">
                <div class="auth-visual-content">
                  <div style="width:72px;height:72px;border-radius:20px;background:rgba(255,255,255,0.15);display:inline-flex;align-items:center;justify-content:center;margin-bottom:1.5rem;font-size:1.8rem;">
                    🔬
                  </div>
                  <h2><?php echo TITLE ?></h2>
                  <p>Sistem Deteksi Kecanduan Internet<br>SD Negeri 16 Timbalun</p>
                  <div style="margin-top:2rem;display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                    <span style="background:rgba(255,255,255,0.12);padding:6px 14px;border-radius:8px;font-size:0.72rem;font-weight:600;">K-Means</span>
                    <span style="background:rgba(255,255,255,0.12);padding:6px 14px;border-radius:8px;font-size:0.72rem;font-weight:600;">Naive Bayes</span>
                    <span style="background:rgba(255,255,255,0.12);padding:6px 14px;border-radius:8px;font-size:0.72rem;font-weight:600;">Data Mining</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
</body>

</html>