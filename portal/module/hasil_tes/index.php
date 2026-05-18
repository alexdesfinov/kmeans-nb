<?php
require_admin();

// === Variabel ===
$tableName = "dataset_training";
$colJenis  = "jenisData";
$maxIter = 50;
$centroidError = false;

if (isset($_POST['proses_kmeans'])) {

    $ids = [];
    foreach (['c1', 'c2', 'c3', 'c4'] as $key) {
        $ids[] = (int)($_POST[$key] ?? 0);
    }

    if (in_array(0, $ids, true)) {
        echo "<div class='alert alert-danger border-0 text-white font-weight-bold' style='background:#f43f5e; border-radius:12px; font-size:0.85rem; padding:12px 18px; margin-bottom:20px;'><i class='fa fa-exclamation-circle me-2'></i>Harus memilih C1 sampai C4.</div>";
        $centroidError = true;
    } elseif (count(array_unique($ids)) !== 4) {
        echo "<div class='alert alert-danger border-0 text-white font-weight-bold' style='background:#f43f5e; border-radius:12px; font-size:0.85rem; padding:12px 18px; margin-bottom:20px;'><i class='fa fa-exclamation-circle me-2'></i>Centroid tidak boleh memilih ID yang sama.</div>";
        $centroidError = true;
    } else {
        $vectors = getVectorsByIds($conn, $ids, $tableName);
        if (count($vectors) === 4) {
            saveCentroidsToDB($conn, $vectors, $ids);
        } else {
            echo "<div class='alert alert-danger border-0 text-white font-weight-bold' style='background:#f43f5e; border-radius:12px; font-size:0.85rem; padding:12px 18px; margin-bottom:20px;'><i class='fa fa-exclamation-circle me-2'></i>Gagal membuat centroid dari ID yang dipilih.</div>";
            $centroidError = true;
        }
    }
}

// ===== PRINT MODE =====
$isPrint = defined('PRINT_MODE') && PRINT_MODE;

if ($isPrint && !isset($_POST['proses_kmeans'])) {
    $_POST['proses_kmeans'] = 1;
}

$initCentroids = getInitialCentroidsFromDB($conn);
$k = count($initCentroids);

if ($isPrint) {
    $doProcess = ($k >= 4) && !$centroidError;
} else {
    $doProcess = isset($_POST['proses_kmeans']) && !$centroidError;
}

$res = $conn->query("SELECT * FROM {$tableName} WHERE jenisData='training'");
$dataKosong = (!$res || $res->num_rows === 0);

if (!$dataKosong && $doProcess) {
    $hybrid = hybridTrainFromDb(
        $conn,
        count($initCentroids),
        $maxIter,
        $tableName,
        $colJenis,
        $initCentroids
    );
}

if ($dataKosong) {
    echo "<div class='text-center py-5'><div style='font-size:3.5rem;color:#cbd5e1;margin-bottom:1.2rem;'>📊</div><h5 class='alert alert-warning' style='display:inline-block; border-radius:12px; border:none; padding:12px 24px; font-weight:700;'>BELUM ADA DATA TRAINING</h5><p style='color:#64748b; font-size:0.85rem;'>Silakan masukkan data training terlebih dahulu sebelum memproses K-Means.</p></div>";
} else {
    $rowsTrain = fetchDatasetByJenis($conn, "training", $tableName, $colJenis);
    $centroidSources = getCentroidSources($conn);
?>

    <?php if (!defined('PRINT_MODE')): ?>
        <!-- Konfigurasi Centroid Card -->
        <div class="identitas-card-modern">
            <div class="identitas-title-section">
                <i class="fa fa-sliders"></i>
                <div>
                    <h5 class="mb-0" style="font-weight:750; color:#1e293b; font-size:1.05rem;">Konfigurasi Centroid Awal</h5>
                    <p class="mb-0" style="font-size:0.75rem; color:#64748b;">Pilih 4 responden berbeda sebagai titik pusat kluster awal</p>
                </div>
            </div>

            <form method="post">
                <div class="row">
                    <!-- C1 -->
                    <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                        <label class="centroid-label-modern">Centroid Awal C1</label>
                        <select name="c1" class="form-select" style="border-radius:10px; border:1.5px solid #cbd5e1; font-size:0.85rem; padding:10px 14px; width:100%; cursor:pointer;" required>
                            <option value="">-- Pilih Responden --</option>
                            <?php foreach ($rowsTrain as $r): ?>
                                <option value="<?= (int)$r['id'] ?>" <?= ((int)$r['id'] === (int)($centroidSources[1] ?? 0)) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($r['nama']) ?> (ID: <?= (int)$r['id'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- C2 -->
                    <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                        <label class="centroid-label-modern">Centroid Awal C2</label>
                        <select name="c2" class="form-select" style="border-radius:10px; border:1.5px solid #cbd5e1; font-size:0.85rem; padding:10px 14px; width:100%; cursor:pointer;" required>
                            <option value="">-- Pilih Responden --</option>
                            <?php foreach ($rowsTrain as $r): ?>
                                <option value="<?= (int)$r['id'] ?>" <?= ((int)$r['id'] === (int)($centroidSources[2] ?? 0)) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($r['nama']) ?> (ID: <?= (int)$r['id'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- C3 -->
                    <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                        <label class="centroid-label-modern">Centroid Awal C3</label>
                        <select name="c3" class="form-select" style="border-radius:10px; border:1.5px solid #cbd5e1; font-size:0.85rem; padding:10px 14px; width:100%; cursor:pointer;" required>
                            <option value="">-- Pilih Responden --</option>
                            <?php foreach ($rowsTrain as $r): ?>
                                <option value="<?= (int)$r['id'] ?>" <?= ((int)$r['id'] === (int)($centroidSources[3] ?? 0)) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($r['nama']) ?> (ID: <?= (int)$r['id'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- C4 -->
                    <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                        <label class="centroid-label-modern">Centroid Awal C4</label>
                        <select name="c4" class="form-select" style="border-radius:10px; border:1.5px solid #cbd5e1; font-size:0.85rem; padding:10px 14px; width:100%; cursor:pointer;" required>
                            <option value="">-- Pilih Responden --</option>
                            <?php foreach ($rowsTrain as $r): ?>
                                <option value="<?= (int)$r['id'] ?>" <?= ((int)$r['id'] === (int)($centroidSources[4] ?? 0)) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($r['nama']) ?> (ID: <?= (int)$r['id'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" name="proses_kmeans" class="btn btn-wizard-nav btn-wizard-next px-4" style="margin: 0;">
                        <i class="fa fa-cogs me-1"></i> Proses Analisis K-Means
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?>

<?php
}
?>

<?php
$k = count($initCentroids);
$trace = null;
$finalLabels = [];

if (!$dataKosong && $doProcess && isset($hybrid) && is_array($hybrid)) {
    if (count($initCentroids) < $k) {
        echo "<div class='alert alert-warning border-0 text-dark font-weight-bold' style='background:#fef08a; border-radius:12px; font-size:0.85rem; padding:12px 18px; margin-bottom:20px;'><i class='fa fa-exclamation-triangle me-2'></i>Centroid awal belum lengkap. Pilih & Proses C1–C4 dulu.</div>";
    } else {
        $trace = kmeansRunWithTrace($hybrid['X_train_km'], $initCentroids, $k, $maxIter);
        $finalLabels = $trace['final']['labels'];
    }
}
?>

<?php if (!$dataKosong && $doProcess && isset($hybrid) && is_array($hybrid) && is_array($trace)): ?>
    
    <!-- MAIN TAB NAVIGATION -->
    <?php if (!$isPrint): ?>
        <div class="kmeans-tabs-nav">
            <button type="button" class="kmeans-tab-btn active" data-target="pane-hasil-akhir">
                <i class="fa fa-check-circle"></i> Hasil Akhir Clustering
            </button>
            <button type="button" class="kmeans-tab-btn" data-target="pane-detail-proses">
                <i class="fa fa-history"></i> Detail Proses Iterasi
            </button>
        </div>
    <?php endif; ?>

    <!-- TAB CONTENT PANES -->
    <div class="kmeans-tab-panes-container">
        
        <!-- MAIN TAB 1: HASIL AKHIR CLUSTERING -->
        <div class="kmeans-tab-pane active" id="pane-hasil-akhir">
            <div class="identitas-card-modern">
                <div class="identitas-title-section">
                    <i class="fa fa-users" style="background:rgba(16,185,129,0.08); color:#10b981;"></i>
                    <div>
                        <h5 class="mb-0" style="font-weight:750; color:#1e293b; font-size:1.05rem;">Hasil Akhir Clustering (Per Kluster)</h5>
                        <p class="mb-0" style="font-size:0.75rem; color:#64748b;">Pengelompokan responden berdasarkan tingkat kecanduan internet</p>
                    </div>
                </div>

                <?php for ($c = 0; $c < $k; $c++): ?>
                    <?php
                    $status = $hybrid['clusterNameMap'][$c] ?? '-';
                    $noAnggota = 1;
                    $statusLower = strtolower($status);
                    if (strpos($statusLower, 'parah') !== false) {
                        $badgeClass = 'cluster-parah';
                        $accentColor = '#ef4444';
                        $bgLight = 'rgba(239, 68, 68, 0.03)';
                    } elseif (strpos($statusLower, 'sedang') !== false) {
                        $badgeClass = 'cluster-sedang';
                        $accentColor = '#f59e0b';
                        $bgLight = 'rgba(245, 158, 11, 0.03)';
                    } elseif (strpos($statusLower, 'ringan') !== false) {
                        $badgeClass = 'cluster-ringan';
                        $accentColor = '#10b981';
                        $bgLight = 'rgba(16, 185, 129, 0.03)';
                    } else {
                        $badgeClass = 'cluster-normal';
                        $accentColor = '#64748b';
                        $bgLight = 'rgba(100, 116, 139, 0.03)';
                    }
                    ?>

                    <div style="border-radius:12px; border:1px solid #e2e8f0; padding:18px; margin-bottom:20px; background:<?= $bgLight ?>; border-left: 5px solid <?= $accentColor ?>;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0" style="color:#1e293b; font-size:0.92rem;">
                                KLUSTER <?= $c + 1 ?>
                            </h6>
                            <span class="cluster-badge <?= $badgeClass ?>" style="padding: 5px 12px; font-weight:700; border-radius:8px; font-size:0.72rem; text-transform:uppercase;">
                                <?= htmlspecialchars($status) ?>
                            </span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size:0.84rem;">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center" width="6%" data-orderable="false" style="padding:10px;">No</th>
                                        <th style="padding:10px;">Nama Responden</th>
                                        <th class="text-center" width="10%">K1</th>
                                        <th class="text-center" width="10%">K2</th>
                                        <th class="text-center" width="10%">K3</th>
                                        <th class="text-center" width="10%">K4</th>
                                        <th class="text-center" width="10%">K5</th>
                                        <th class="text-center" width="10%">K6</th>
                                    </tr>
                                </thead>
                                <tbody style="background:#fff;">
                                    <?php foreach ($hybrid['trainRows'] as $i => $row): ?>
                                        <?php
                                        $cid = $finalLabels[$i] ?? -1;
                                        if ($cid !== $c) continue;
                                        $vec = $hybrid['X_train_km'][$i] ?? [0, 0, 0, 0, 0, 0];
                                        ?>
                                        <tr>
                                            <td class="text-center" style="font-weight:600; color:#64748b;"><?= $noAnggota++ ?></td>
                                            <td style="font-weight:600; color:var(--fadel-primary);"><?= htmlspecialchars($row['nama'] ?? '-') ?></td>
                                            <td class="text-center"><?= (int)$vec[0] ?></td>
                                            <td class="text-center"><?= (int)$vec[1] ?></td>
                                            <td class="text-center"><?= (int)$vec[2] ?></td>
                                            <td class="text-center"><?= (int)$vec[3] ?></td>
                                            <td class="text-center"><?= (int)$vec[4] ?></td>
                                            <td class="text-center"><?= (int)$vec[5] ?></td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <?php if ($noAnggota === 1): ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-3">Tidak ada anggota di kluster ini.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- MAIN TAB 2: DETAIL PROSES K-MEANS -->
        <div class="kmeans-tab-pane" id="pane-detail-proses">
            <div class="identitas-card-modern">
                <div class="identitas-title-section">
                    <i class="fa fa-history"></i>
                    <div>
                        <h5 class="mb-0" style="font-weight:750; color:#1e293b; font-size:1.05rem;">Detail Perhitungan Iterasi K-Means</h5>
                        <p class="mb-0" style="font-size:0.75rem; color:#64748b;">Lacak pergerakan centroid dan nilai euclidean distance hingga konvergen</p>
                    </div>
                </div>

                <!-- Sub-Navigation for Iteration Capsules -->
                <div class="kmeans-subtabs-container">
                    <div class="kmeans-subtabs-nav" id="iterTabsNav">
                        <?php foreach ($trace['iterations'] as $index => $it): ?>
                            <button type="button" class="kmeans-subtab-btn <?= $index === 0 ? 'active' : '' ?>" data-iter="<?= $it['iter'] ?>">
                                Iterasi <?= $it['iter'] ?> <?= !$it['changed'] ? ' (Konvergen)' : '' ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Iteration Panes -->
                <div class="kmeans-iter-panes-container">
                    <?php foreach ($trace['iterations'] as $index => $it): ?>
                        <div class="kmeans-iter-pane <?= $index === 0 ? 'active' : '' ?>" data-iter-pane="<?= $it['iter'] ?>">
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 style="font-weight:800; color:#1e293b; font-size:0.9rem; text-transform:uppercase; letter-spacing:0.5px;">
                                    <i class="fa fa-circle-o-notch fa-spin me-2 text-primary"></i> Tabel Perhitungan Iterasi <?= (int)$it['iter'] ?>
                                </h6>
                                <span class="badge" style="background:#e2e8f0; color:#475569; font-weight:700; padding:6px 12px; border-radius:8px;">
                                    Status: <?= $it['changed'] ? 'Mencari Centroid...' : 'Konvergen ✓' ?>
                                </span>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle" style="font-size:0.8rem;">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center" width="5%" data-orderable="false" style="padding:10px 6px;">No</th>
                                            <th style="padding:10px 8px;">Nama</th>
                                            <th class="text-center" style="padding:10px 4px;">K1</th>
                                            <th class="text-center" style="padding:10px 4px;">K2</th>
                                            <th class="text-center" style="padding:10px 4px;">K3</th>
                                            <th class="text-center" style="padding:10px 4px;">K4</th>
                                            <th class="text-center" style="padding:10px 4px;">K5</th>
                                            <th class="text-center" style="padding:10px 4px;">K6</th>

                                            <?php for ($c = 1; $c <= $k; $c++): ?>
                                                <th class="text-center" style="padding:10px 6px; background:#334155;">C<?= $c ?></th>
                                            <?php endfor; ?>

                                            <th class="text-center" style="padding:10px 6px; background:#0f172a;">Cluster</th>
                                            <th class="text-center" style="padding:10px 8px; background:#0f172a;">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody style="background:#fff;">
                                        <?php foreach ($hybrid['trainRows'] as $i => $row): ?>
                                            <?php
                                            $vec = $hybrid['X_train_km'][$i];
                                            $cid = $it['labels'][$i];
                                            $minD = $it['minDist'][$i];
                                            $ket  = $hybrid['clusterNameMap'][$cid] ?? '-';
                                            ?>
                                            <tr>
                                                <td class="text-center" style="font-weight:600; color:#64748b;"><?= $i + 1 ?></td>
                                                <td style="font-weight:600; color:#1e293b;"><?= htmlspecialchars($row['nama'] ?? '-') ?></td>

                                                <?php for ($d = 0; $d < 6; $d++): ?>
                                                    <td class="text-center"><?= (int)$vec[$d] ?></td>
                                                <?php endfor; ?>

                                                <?php for ($c = 0; $c < $k; $c++): ?>
                                                    <?php
                                                    $dist = (float)$it['dist'][$i][$c];
                                                    $isMin = (abs($dist - (float)$minD) < 0.0000001);
                                                    $tip = buildDistanceTip($i, $c, $vec, $it['centroids'][$c], $dist);
                                                    $distTxt = rtrim(rtrim(number_format($dist, 2, '.', ''), '0'), '.');
                                                    ?>
                                                    <td class="text-center">
                                                        <?php if ($isMin): ?>
                                                            <span class="math-tooltip-wrapper min-distance-badge">
                                                                <?= $distTxt ?>
                                                                <span class="math-tooltip"><?= $tip ?></span>
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="math-tooltip-wrapper" style="color:#64748b;">
                                                                <?= $distTxt ?>
                                                                <span class="math-tooltip"><?= $tip ?></span>
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endfor; ?>

                                                <td class="text-center" style="font-weight:700; color:#1e293b;">C<?= $cid + 1 ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    $statusLower = strtolower($ket);
                                                    if (strpos($statusLower, 'parah') !== false) {
                                                        $bColor = 'rgba(239, 68, 68, 0.1)'; $tColor = '#ef4444';
                                                    } elseif (strpos($statusLower, 'sedang') !== false) {
                                                        $bColor = 'rgba(245, 158, 11, 0.1)'; $tColor = '#d97706';
                                                    } elseif (strpos($statusLower, 'ringan') !== false) {
                                                        $bColor = 'rgba(16, 185, 129, 0.1)'; $tColor = '#059669';
                                                    } else {
                                                        $bColor = 'rgba(100, 116, 139, 0.1)'; $tColor = '#475569';
                                                    }
                                                    ?>
                                                    <span style="background:<?= $bColor ?>; color:<?= $tColor ?>; font-weight:700; font-size:0.7rem; border-radius:6px; padding:3px 8px; text-transform:uppercase;">
                                                        <?= htmlspecialchars($ket) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                        <!-- Centroid (Dipakai di Iterasi Ini) -->
                                        <tr style="background:#fffbeb; font-weight:700;">
                                            <td colspan="2" style="background:#fffbeb;">Centroid Awal Iterasi Ini</td>
                                            <td colspan="6" style="background:#fffbeb;"></td>
                                            <td colspan="<?= $k ?>" style="background:#fffbeb;"></td>
                                            <td style="background:#fffbeb;"></td>
                                            <td style="background:#fffbeb;"></td>
                                        </tr>

                                        <?php for ($c = 0; $c < $k; $c++): ?>
                                            <tr style="background:#fffbeb;">
                                                <td style="background:#fffbeb; font-weight:700; color:#d97706;">C<?= $c + 1 ?></td>
                                                <td style="background:#fffbeb; font-weight:600; color:#d97706;">Pusat Kluster</td>
                                                <?php for ($d = 0; $d < 6; $d++): ?>
                                                    <?php $v = rtrim(rtrim(number_format((float)$it['centroids'][$c][$d], 1, '.', ''), '0'), '.'); ?>
                                                    <td class="text-center" style="background:#fffbeb; color:#d97706; font-weight:600;"><?= $v ?></td>
                                                <?php endfor; ?>
                                                <td colspan="<?= $k ?>" style="background:#fffbeb;"></td>
                                                <td style="background:#fffbeb;"></td>
                                                <td style="background:#fffbeb;"></td>
                                            </tr>
                                        <?php endfor; ?>

                                        <!-- Centroid Baru (Hasil Update) -->
                                        <tr style="background:#f0fdf4; font-weight:700;">
                                            <td colspan="2" style="background:#f0fdf4;">Centroid Baru (Hasil Update)</td>
                                            <td colspan="6" style="background:#f0fdf4;"></td>
                                            <td colspan="<?= $k ?>" style="background:#f0fdf4;"></td>
                                            <td style="background:#f0fdf4;"></td>
                                            <td style="background:#f0fdf4;"></td>
                                        </tr>

                                        <?php for ($c = 0; $c < $k; $c++): ?>
                                            <tr style="background:#f0fdf4;">
                                                <td style="background:#f0fdf4; font-weight:700; color:#16a34a;">C<?= $c + 1 ?></td>
                                                <td style="background:#f0fdf4; font-weight:600; color:#16a34a;">Pusat Baru</td>
                                                <?php for ($d = 0; $d < 6; $d++): ?>
                                                    <?php $v = rtrim(rtrim(number_format((float)$it['newCentroids'][$c][$d], 1, '.', ''), '0'), '.'); ?>
                                                    <td class="text-center" style="background:#f0fdf4; color:#16a34a; font-weight:600;"><?= $v ?></td>
                                                <?php endfor; ?>
                                                <td colspan="<?= $k ?>" style="background:#f0fdf4;"></td>
                                                <td style="background:#f0fdf4;"></td>
                                                <td style="background:#f0fdf4;"></td>
                                            </tr>
                                        <?php endfor; ?>

                                    </tbody>
                                </table>
                            </div>

                            <?php if (!$it['changed']): ?>
                                <div class="alert alert-success mt-4 border-0 text-white font-weight-bold" style="background:#10b981; border-radius:12px; font-size:0.85rem; padding:14px 20px;">
                                    <i class="fa fa-check-circle me-2" style="font-size:1.15rem; vertical-align:middle;"></i> Konvergen dicapai pada iterasi <?= (int)$it['iter'] ?>. Nilai centroid pada iterasi ini sudah sama dengan iterasi sebelumnya sehingga perhitungan dihentikan.
                                </div>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>

    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Main Tabs handler
        const tabBtns = document.querySelectorAll(".kmeans-tab-btn");
        const tabPanes = document.querySelectorAll(".kmeans-tab-pane");
        
        tabBtns.forEach(btn => {
            btn.addEventListener("click", function() {
                const target = this.getAttribute("data-target");
                
                // Toggle nav active
                tabBtns.forEach(b => b.classList.remove("active"));
                this.classList.add("active");
                
                // Toggle pane active
                tabPanes.forEach(pane => {
                    if (pane.id === target) {
                        pane.classList.add("active");
                    } else {
                        pane.classList.remove("active");
                    }
                });
            });
        });

        // Iteration Sub-Tabs handler
        const subtabBtns = document.querySelectorAll(".kmeans-subtab-btn");
        const iterPanes = document.querySelectorAll(".kmeans-iter-pane");
        
        subtabBtns.forEach(btn => {
            btn.addEventListener("click", function() {
                const iterNum = this.getAttribute("data-iter");
                
                // Toggle subtab active
                subtabBtns.forEach(b => b.classList.remove("active"));
                this.classList.add("active");
                
                // Toggle iter pane active
                iterPanes.forEach(pane => {
                    const paneIter = pane.getAttribute("data-iter-pane");
                    if (paneIter === iterNum) {
                        pane.classList.add("active");
                    } else {
                        pane.classList.remove("active");
                    }
                });
            });
        });

        // Smooth scroll down to results when they are rendered after form submission
        const resultsNav = document.querySelector(".kmeans-tabs-nav");
        if (resultsNav) {
            setTimeout(function() {
                resultsNav.scrollIntoView({ behavior: "smooth", block: "start" });
            }, 150);
        }
    });
    </script>

<?php endif; ?>