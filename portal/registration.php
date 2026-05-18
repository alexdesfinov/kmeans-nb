<?php

require_once 'config/koneksi.php';
require_once 'config/function.php';
require_once 'config/assets.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  handle_register_post($conn);
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Daftar akun FADEL — Sistem Deteksi Kecanduan Internet">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <title>Register | <?php echo TITLE ?></title>

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
    .async-hide { opacity: 0 !important; }
    #submit[disabled] { cursor: not-allowed; opacity: 0.6; }

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

    .btn-auth:hover:not([disabled]) {
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
          <a href="index.php" class="back-link"><i class="ni ni-bold-left"></i> Kembali ke Login</a>
          <div class="auth-card">
            <div class="row g-0">
              <div class="col-md-6 auth-form-side">
                <?php flash_render_and_clear(); ?>
                <h3>Registrasi</h3>
                <p class="subtitle">Buat akun untuk akses sistem</p>

                <form action="registration.php" method="post" autocomplete="off">
                  <div class="mb-3">
                    <label>Nama</label>
                    <input
                      type="text" required name="nama" autocomplete="name"
                      value="<?php echo htmlspecialchars($_SESSION['flash']['credidential']['nama'] ?? '') ?>"
                      class="form-control" placeholder="Nama lengkap">
                  </div>

                  <div class="mb-3">
                    <label>Username</label>
                    <input
                      type="text" required name="username" autocomplete="username"
                      value="<?php echo htmlspecialchars($_SESSION['flash']['credidential']['username'] ?? '') ?>"
                      class="form-control" placeholder="Username">
                  </div>

                  <div class="mb-3">
                    <label>Password</label>
                    <input
                      type="password" required name="password" minlength="8"
                      id="password" autocomplete="new-password"
                      class="form-control" placeholder="Min. 8 karakter">
                  </div>

                  <div class="mb-3">
                    <label>Konfirmasi Password</label>
                    <input
                      type="password" required name="password2" minlength="8"
                      id="Cpassword" autocomplete="new-password"
                      class="form-control" placeholder="Ulangi password">
                    <small id="passwordMatch" style="font-size:0.78rem;"></small>
                  </div>

                  <button type="submit" disabled id="submit" class="btn-auth">Daftar</button>

                  <div class="text-center mt-3">
                    <span style="font-size:0.82rem;color:#627594;">Sudah punya akun?</span>
                    <a href="index.php" style="font-size:0.82rem;font-weight:600;color:var(--fadel-primary);text-decoration:none;"> Masuk</a>
                  </div>
                </form>
              </div>
              <div class="col-md-6 auth-visual-side d-none d-md-flex">
                <div class="auth-visual-content">
                  <div style="width:72px;height:72px;border-radius:20px;background:rgba(255,255,255,0.15);display:inline-flex;align-items:center;justify-content:center;margin-bottom:1.5rem;font-size:1.8rem;">
                    📝
                  </div>
                  <h2>Bergabung</h2>
                  <p>Daftar sebagai responden untuk mengisi kuesioner deteksi kecanduan internet.</p>
                  <div style="margin-top:2rem;">
                    <div style="background:rgba(255,255,255,0.1);border-radius:14px;padding:1.2rem;text-align:left;">
                      <div style="font-size:0.72rem;opacity:0.6;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">Setelah mendaftar</div>
                      <div style="font-size:0.82rem;line-height:1.8;">
                        ✓ Isi kuesioner 20 pertanyaan<br>
                        ✓ Lihat hasil analisis<br>
                        ✓ Data aman & terlindungi
                      </div>
                    </div>
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
  <script src="assets/js/soft-ui-dashboard.min3447.js?v=1.0.5"></script>

  <script>
    const pass = document.getElementById('password');
    const cpass = document.getElementById('Cpassword');
    const msg = document.getElementById('passwordMatch');
    const btn = document.getElementById('submit');

    function checkPasswordMatch() {
      if (!pass.value || !cpass.value) {
        msg.textContent = "";
        btn.disabled = true;
        return;
      }

      if (pass.value !== cpass.value) {
        msg.textContent = "Password tidak cocok!";
        msg.style.color = "#ea0606";
        btn.disabled = true;
      } else {
        msg.textContent = "Password cocok ✓";
        msg.style.color = "#82d616";
        btn.disabled = false;
      }
    }

    pass.addEventListener('keyup', checkPasswordMatch);
    cpass.addEventListener('keyup', checkPasswordMatch);
  </script>
</body>

</html>