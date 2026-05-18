<?php
$adminMenus = [
  [
    'title' => 'Input Data',
    'desc' => 'Input data responden manual',
    'link' => '?module=inputData',
    'gradient' => 'icon-gradient-primary',
    'icon' => '<path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1" />'
  ],
  [
    'title' => 'Dataset',
    'desc' => 'Upload CSV dataset',
    'link' => '?module=uploadDataset',
    'gradient' => 'icon-gradient-info',
    'icon' => '<path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0M8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1" /><path d="M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12 12 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7m6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.55 4.55 0 0 1 .23-2.002m-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.5 4.5 0 0 1-1.3-1.905" />'
  ],
  [
    'title' => 'Data Training',
    'desc' => 'Lihat & kelola data training',
    'link' => '?module=dataTraining',
    'gradient' => 'icon-gradient-success',
    'icon' => '<path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m.5 10v-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5m-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5z" />'
  ],
  [
    'title' => 'Data Testing',
    'desc' => 'Lihat & kelola data testing',
    'link' => '?module=dataTesting',
    'gradient' => 'icon-gradient-warning',
    'icon' => '<path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m.5 10v-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5m-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5z" />'
  ],
  [
    'title' => 'Hasil K-Means',
    'desc' => 'Clustering & iterasi K-Means',
    'link' => '?module=hasil_tes',
    'gradient' => 'icon-gradient-danger',
    'icon' => '<path d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1z" />'
  ],
  [
    'title' => 'Hasil Naive Bayes',
    'desc' => 'Prediksi data testing',
    'link' => '?module=hasil_tes_naive',
    'gradient' => 'icon-gradient-dark',
    'icon' => '<path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07"/>'
  ],
  [
    'title' => 'Cetak Hasil',
    'desc' => 'Cetak laporan analisis',
    'link' => '?module=print',
    'gradient' => 'icon-gradient-info',
    'icon' => '<path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1" /><path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />'
  ],
  [
    'title' => 'Master User',
    'desc' => 'Kelola akun pengguna',
    'link' => '?module=user',
    'gradient' => 'icon-gradient-primary',
    'icon' => '<path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />'
  ],
];

$userMenus = [
  [
    'title' => 'Isi Kuesioner',
    'desc' => 'Jawab 20 pertanyaan kuesioner',
    'link' => '?module=inputDataUser',
    'gradient' => 'icon-gradient-primary',
    'icon' => '<path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1" />'
  ],
];

$isAdmin = (($_SESSION['level'] ?? 'user') === 'admin');
$menus = $isAdmin ? $adminMenus : $userMenus;
$nama = htmlspecialchars($_SESSION['nama'] ?? 'User');
?>

<!-- Welcome Banner -->
<div class="welcome-banner animate-in">
  <h3 style="font-size: 1.8rem; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 0.5rem; color: #ffffff;">Selamat Datang, <span style="color: #fbcf33; font-weight: 800; text-shadow: 0 2px 8px rgba(251, 207, 51, 0.25);"><?= $nama ?></span>! 👋</h3>
  <p style="opacity: 0.85; font-size: 0.95rem; font-weight: 500; color: #ffffff;">Sistem Deteksi Kecanduan Internet — SD Negeri 16 Timbalun</p>
</div>

<!-- Flash Messages -->
<?php flashRenderAndClear(); ?>

<!-- Menu Cards -->
<div class="row">
  <div class="col-md-12 mb-3">
    <h6 class="text-uppercase text-xs font-weight-bolder opacity-6" style="letter-spacing:1.5px;">Menu Utama</h6>
  </div>

  <?php foreach ($menus as $i => $menu): ?>
    <div class="col-xl-3 col-md-4 col-sm-6 col-12 mb-3 animate-in animate-delay-<?= min($i + 1, 4) ?>">
      <div class="card dash-card h-100">
        <div class="card-body">
          <a href="<?= $menu['link'] ?>">
            <div class="row align-items-center">
              <div class="col-8">
                <div class="numbers">
                  <h5><?= htmlspecialchars($menu['title']) ?></h5>
                  <p class="card-desc"><?= htmlspecialchars($menu['desc']) ?></p>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape <?= $menu['gradient'] ?> shadow text-center border-radius-md d-inline-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" viewBox="0 0 16 16">
                    <?= $menu['icon'] ?>
                  </svg>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

</div>