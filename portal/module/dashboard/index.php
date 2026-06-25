<?php
$isAdmin = (($_SESSION['level'] ?? 'user') === 'admin');

$showCharts = false;
$kmeansChartData = [];
$nbChartData = [];
$clusterNames = [];
$renderedClasses = [];
$nbCounts = [];

if ($isAdmin) {
    $initCentroids = getInitialCentroidsFromDB($conn);
    $k = count($initCentroids);
    
    $resTrain = $conn->query("SELECT COUNT(*) as total FROM dataset_training WHERE jenisData='training'");
    $countTrain = ($resTrain) ? (int)$resTrain->fetch_assoc()['total'] : 0;
    
    if ($k >= 3 && $countTrain > 0) {
        $hybrid = hybridTrainFromDb($conn, $k, 50, "dataset_training", "jenisData", $initCentroids);
        if (is_array($hybrid) && isset($hybrid['X_train_km'])) {
            $trace = $hybrid['kmeans']['trace'] ?? kmeansRunWithTrace($hybrid['X_train_km'], $initCentroids, $k, 50);
            if (is_array($trace) && isset($trace['final']['labels'])) {
                $finalLabels = $trace['final']['labels'];
                
                // K-Means counts
                $kmCounts = array_fill(0, $k, 0);
                foreach ($finalLabels as $lbl) {
                    if (isset($kmCounts[$lbl])) {
                        $kmCounts[$lbl]++;
                    }
                }
                
                // Map names
                $nameMap = $hybrid['clusterNameMap'];
                foreach ($nameMap as $cid => $rawName) {
                    $clusterNames[$cid] = normalizeNbLabel($rawName);
                    $kmeansChartData[$cid] = $kmCounts[$cid];
                }
                
                // Active dynamic classes ordered naturally: Ringan, Sedang, Parah
                $order = ['Ringan', 'Sedang', 'Parah'];
                foreach ($order as $o) {
                    if (in_array($o, $clusterNames)) {
                        $renderedClasses[] = $o;
                    }
                }
                foreach ($clusterNames as $ac) {
                    if (!in_array($ac, $renderedClasses)) {
                        $renderedClasses[] = $ac;
                    }
                }
                
                // Naive Bayes counts on testing data
                $preds = hybridPredictTesting($conn, $hybrid, "dataset_testing", "jenisData");
                $nbCounts = [
                    'Ringan' => 0,
                    'Sedang' => 0,
                    'Parah' => 0
                ];
                foreach ($preds as $p) {
                    $cls = $p['pred_class'] ?? '';
                    if (isset($nbCounts[$cls])) {
                        $nbCounts[$cls]++;
                    }
                }
                
                $nbChartData = [
                    'Ringan' => $nbCounts['Ringan'],
                    'Sedang' => $nbCounts['Sedang'],
                    'Parah' => $nbCounts['Parah']
                ];
                
                $showCharts = true;
            }
        }
    }
}

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

<?php if ($isAdmin): ?>
  <?php if ($showCharts): ?>
    <!-- Charts Section -->
    <div class="row mt-4">
      <!-- Chart K-Means -->
      <div class="col-lg-6 mb-4">
        <div class="card h-100 shadow-sm border-0" style="border-radius: 16px; background: #ffffff;">
          <div class="card-header pb-0 bg-transparent border-0 d-flex align-items-center justify-content-between" style="padding: 20px 20px 0 20px;">
            <div>
              <h6 class="font-weight-bolder mb-0" style="color: #1e293b; font-size: 1.05rem;">
                <i class="fa fa-pie-chart me-2 text-danger"></i>Kluster K-Means (Data Training)
              </h6>
              <p class="text-xs mb-0 text-secondary">Distribusi tingkat kecanduan internet hasil clustering</p>
            </div>
            <span class="badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; font-weight: 700; border-radius: 8px; font-size: 0.72rem; padding: 6px 12px;">K-Means</span>
          </div>
          <div class="card-body d-flex flex-column align-items-center justify-content-center" style="position: relative; padding: 20px; min-height: 320px;">
            <div style="width: 100%; max-width: 240px; height: 200px; margin-bottom: 12px; position: relative;">
              <canvas id="kmeansChart"></canvas>
            </div>
            <div class="d-flex justify-content-center gap-4 mt-3" style="width: 100%; font-size: 0.8rem; border-top: 1px solid rgba(0,0,0,0.05); padding-top: 15px;">
              <?php foreach ($renderedClasses as $cls): 
                  $cid = array_search($cls, $clusterNames);
                  $count = ($cid !== false) ? $kmeansChartData[$cid] : 0;
                  
                  $dotColor = '#94a3b8';
                  if (strtolower($cls) === 'ringan') $dotColor = '#10b981';
                  elseif (strtolower($cls) === 'sedang') $dotColor = '#f59e0b';
                  elseif (strtolower($cls) === 'parah') $dotColor = '#ef4444';
              ?>
                <div class="d-flex align-items-center">
                  <span style="display:inline-block; width:10px; height:10px; border-radius:50%; background:<?= $dotColor ?>; margin-right:6px;"></span>
                  <span class="font-weight-bold" style="color:#475569;"><?= $cls ?>: <span style="color:#0f172a; font-weight:800;"><?= $count ?></span></span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Chart Naive Bayes -->
      <div class="col-lg-6 mb-4">
        <div class="card h-100 shadow-sm border-0" style="border-radius: 16px; background: #ffffff;">
          <div class="card-header pb-0 bg-transparent border-0 d-flex align-items-center justify-content-between" style="padding: 20px 20px 0 20px;">
            <div>
              <h6 class="font-weight-bolder mb-0" style="color: #1e293b; font-size: 1.05rem;">
                <i class="fa fa-bar-chart me-2 text-dark"></i>Prediksi Naive Bayes (Data Testing)
              </h6>
              <p class="text-xs mb-0 text-secondary">Klasifikasi tingkat kecanduan internet pada data pengujian</p>
            </div>
            <span class="badge" style="background: rgba(15, 23, 42, 0.1); color: #0f172a; font-weight: 700; border-radius: 8px; font-size: 0.72rem; padding: 6px 12px;">Naive Bayes</span>
          </div>
          <div class="card-body d-flex flex-column align-items-center justify-content-center" style="position: relative; padding: 20px; min-height: 320px;">
            <div style="width: 100%; height: 200px; margin-bottom: 12px; position: relative;">
              <canvas id="naiveBayesChart"></canvas>
            </div>
            <div class="d-flex justify-content-center gap-4 mt-3" style="width: 100%; font-size: 0.8rem; border-top: 1px solid rgba(0,0,0,0.05); padding-top: 15px;">
              <?php foreach (['Ringan', 'Sedang', 'Parah'] as $cls): 
                  $count = $nbChartData[$cls] ?? 0;
                  
                  $dotColor = '#94a3b8';
                  if (strtolower($cls) === 'ringan') $dotColor = '#10b981';
                  elseif (strtolower($cls) === 'sedang') $dotColor = '#f59e0b';
                  elseif (strtolower($cls) === 'parah') $dotColor = '#ef4444';
              ?>
                <div class="d-flex align-items-center">
                  <span style="display:inline-block; width:10px; height:10px; border-radius:50%; background:<?= $dotColor ?>; margin-right:6px;"></span>
                  <span class="font-weight-bold" style="color:#475569;"><?= $cls ?>: <span style="color:#0f172a; font-weight:800;"><?= $count ?></span></span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php else: ?>
    <!-- Notice Card -->
    <div class="row mt-4">
      <div class="col-12">
        <div class="card shadow-sm border-0" style="border-radius: 16px; background: #ffffff; padding: 24px;">
          <div class="text-center py-4">
            <div style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"><i class="fa fa-line-chart"></i></div>
            <h5 style="color: #475569; font-weight: 700; font-size: 1.1rem;">Gagal Memuat Grafik Hasil Analisis</h5>
            <p style="color: #64748b; font-size: 0.85rem; max-width: 500px; margin: 0.5rem auto 1.5rem auto;">
              Grafik visualisasi tidak dapat ditampilkan karena data training kosong atau centroid awal K-Means belum dikonfigurasi di portal.
            </p>
            <a href="?module=hasil_tes" class="btn px-4 py-2" style="background: var(--gradient-primary, linear-gradient(135deg, #0f172a, #334155)); color: #fff; border-radius: 10px; font-weight: 600; font-size: 0.82rem; text-decoration: none; border: none; box-shadow: 0 4px 12px rgba(15,23,42,0.15);">
              Konfigurasi Centroid Sekarang
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    <?php if ($isAdmin && $showCharts): ?>
    // K-Means Chart
    const ctxKm = document.getElementById('kmeansChart');
    if (ctxKm) {
        new Chart(ctxKm, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode(array_values($clusterNames)) ?>,
                datasets: [{
                    data: <?= json_encode(array_values($kmeansChartData)) ?>,
                    backgroundColor: [
                        'rgba(245, 158, 11, 0.15)', // Sedang
                        'rgba(239, 68, 68, 0.15)',  // Parah
                        'rgba(16, 185, 129, 0.15)'  // Ringan
                    ].slice(0, <?= $k ?>),
                    borderColor: [
                        '#f59e0b', // Sedang
                        '#ef4444', // Parah
                        '#10b981'  // Ringan
                    ].slice(0, <?= $k ?>),
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += context.parsed + ' responden';
                                }
                                return label;
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    }

    // Naive Bayes Chart
    const ctxNb = document.getElementById('naiveBayesChart');
    if (ctxNb) {
        new Chart(ctxNb, {
            type: 'bar',
            data: {
                labels: ['Ringan', 'Sedang', 'Parah'],
                datasets: [{
                    label: 'Jumlah Prediksi',
                    data: [
                        <?= $nbChartData['Ringan'] ?>,
                        <?= $nbChartData['Sedang'] ?>,
                        <?= $nbChartData['Parah'] ?>
                    ],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.2)',
                        'rgba(245, 158, 11, 0.2)',
                        'rgba(239, 68, 68, 0.2)'
                    ],
                    borderColor: [
                        '#10b981',
                        '#f59e0b',
                        '#ef4444'
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            color: '#64748b',
                            font: {
                                family: 'Inter',
                                size: 11
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.04)',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            color: '#64748b',
                            font: {
                                family: 'Inter',
                                size: 11,
                                weight: '600'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
    <?php endif; ?>
});
</script>