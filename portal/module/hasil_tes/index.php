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
        echo "<div class='alert alert-danger'>Harus memilih C1 sampai C4.</div>";
        $centroidError = true;
    } elseif (count(array_unique($ids)) !== 4) {
        echo "<div class='alert alert-danger'>Centroid tidak boleh memilih ID yang sama.</div>";
        $centroidError = true;
    } else {
        $vectors = getVectorsByIds($conn, $ids, $tableName);
        if (count($vectors) === 4) {
            saveCentroidsToDB($conn, $vectors, $ids);
        } else {
            echo "<div class='alert alert-danger'>Gagal membuat centroid dari ID yang dipilih.</div>";
            $centroidError = true;
        }
    }
}

// ===== PRINT MODE: jalankan otomatis tanpa klik tombol =====
$isPrint = defined('PRINT_MODE') && PRINT_MODE;

// kalau print, kita tidak perlu POST tombol, yang penting centroid sudah ada di DB
if ($isPrint && !isset($_POST['proses_kmeans'])) {
    // “palsukan” agar pipeline kmeans jalan
    $_POST['proses_kmeans'] = 1;
}


$initCentroids = getInitialCentroidsFromDB($conn);
$k = count($initCentroids);

// Print mode: proses dianggap boleh jalan kalau centroid sudah lengkap (>=4)
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
    echo "<div class='text-center py-5'><div style='font-size:3rem;color:#d0d5dd;margin-bottom:1rem;'>📊</div><h5 class='alert alert-warning' style='display:inline-block;'>MASUKAN DATA TRAINING</h5></div>";
} else {
    // ambil data training untuk opsi centroid
    $rowsTrain = fetchDatasetByJenis($conn, "training", $tableName, $colJenis);
    $centroidSources = getCentroidSources($conn); // contoh: [1=>12,2=>5,3=>9,4=>2]
?>

    <?php if (!defined('PRINT_MODE')): ?>
        <div class="card-body">
            <form method="post">
                <div class="row">
                    <div class="col-md-4">
                        <label>Centroid Awal C1</label>
                        <select name="c1" class="form-control">
                            <option value="">-- pilih --</option>
                            <?php foreach ($rowsTrain as $r): ?>
                                <option value="<?= (int)$r['id'] ?>"
                                    <?= ((int)$r['id'] === (int)($centroidSources[1] ?? 0)) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($r['nama']) ?> (ID: <?= (int)$r['id'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Centroid Awal C1</label>
                        <select name="c2" class="form-control">
                            <option value="">-- pilih --</option>
                            <?php foreach ($rowsTrain as $r): ?>
                                <option value="<?= (int)$r['id'] ?>"
                                    <?= ((int)$r['id'] === (int)($centroidSources[2] ?? 0)) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($r['nama']) ?> (ID: <?= (int)$r['id'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Centroid Awal C1</label>
                        <select name="c3" class="form-control">
                            <option value="">-- pilih --</option>
                            <?php foreach ($rowsTrain as $r): ?>
                                <option value="<?= (int)$r['id'] ?>"
                                    <?= ((int)$r['id'] === (int)($centroidSources[3] ?? 0)) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($r['nama']) ?> (ID: <?= (int)$r['id'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Centroid Awal C1</label>
                        <select name="c4" class="form-control">
                            <option value="">-- pilih --</option>
                            <?php foreach ($rowsTrain as $r): ?>
                                <option value="<?= (int)$r['id'] ?>"
                                    <?= ((int)$r['id'] === (int)($centroidSources[4] ?? 0)) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($r['nama']) ?> (ID: <?= (int)$r['id'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" name="proses_kmeans" class="btn btn-primary">
                        Proses K-Means
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
    // centroid wajib 4
    if (count($initCentroids) < $k) {
        echo "<div class='alert alert-warning'>Centroid awal belum lengkap. Pilih & Proses C1–C4 dulu.</div>";
    } else {
        $trace = kmeansRunWithTrace($hybrid['X_train_km'], $initCentroids, $k, $maxIter);
        $finalLabels = $trace['final']['labels'];
    }
}
?>


<?php if (!$dataKosong && $doProcess && isset($hybrid) && is_array($hybrid) && is_array($trace)): ?>
    <!-- SEMUA tampilan proses K-Means kamu taruh di sini -->
    <?php if (!$isPrint): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="mt-2 text-center" style="font-weight:800;letter-spacing:-0.3px;">DETAIL PROSES K-MEANS</h5>
                <p class="text-center mb-4" style="color:#627594;font-size:0.85rem;">Iterasi clustering hingga konvergen</p>

                <?php foreach ($trace['iterations'] as $it): ?>
                    <h6 class="mt-4">Iterasi <?= (int)$it['iter'] ?></h6>

                    <div class="table-responsive mb-3">
                        <table class="table table-bordered table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th class="text-center">K1</th>
                                    <th class="text-center">K2</th>
                                    <th class="text-center">K3</th>
                                    <th class="text-center">K4</th>
                                    <th class="text-center">K5</th>
                                    <th class="text-center">K6</th>

                                    <?php for ($c = 1; $c <= $k; $c++): ?>
                                        <th class="text-center">C<?= $c ?></th>
                                    <?php endfor; ?>

                                    <th class="text-center">Cluster</th>
                                    <th class="text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hybrid['trainRows'] as $i => $row): ?>
                                    <?php
                                    $vec = $hybrid['X_train_km'][$i];
                                    $cid = $it['labels'][$i];      // 0..k-1
                                    $minD = $it['minDist'][$i];
                                    $ket  = $hybrid['clusterNameMap'][$cid] ?? '-';
                                    ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= htmlspecialchars($row['nama'] ?? '-') ?></td>

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
                                            <td class="text-center" style="<?= $isMin ? 'background:#d4edda;font-weight:bold;' : '' ?>">
                                                <span class="math-tooltip-wrapper">
                                                    <?= $distTxt ?>
                                                    <span class="math-tooltip"><?= $tip ?></span>
                                                </span>
                                            </td>
                                        <?php endfor; ?>

                                        <td class="text-center"><b>C<?= $cid + 1 ?></b></td>
                                        <td class="text-center"><?= htmlspecialchars($ket) ?></td>
                                    </tr>
                                <?php endforeach; ?>

                                <tr class="table-warning">
                                    <td colspan="2"><b>Centroid (Dipakai di Iterasi Ini)</b></td>
                                    <td colspan="6"></td>
                                    <td colspan="<?= $k ?>"></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <?php for ($c = 0; $c < $k; $c++): ?>
                                    <tr class="table-warning">
                                        <td>C<?= $c + 1 ?></td>
                                        <td>Centroid</td>
                                        <?php for ($d = 0; $d < 6; $d++): ?>
                                            <?php $v = rtrim(rtrim(number_format((float)$it['centroids'][$c][$d], 1, '.', ''), '0'), '.'); ?>
                                            <td class="text-center"><?= $v ?></td>
                                        <?php endfor; ?>
                                        <td colspan="<?= $k ?>"></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php endfor; ?>

                                <tr class="table-info">
                                    <td colspan="2"><b>Centroid Baru (Hasil Update)</b></td>
                                    <td colspan="6"></td>
                                    <td colspan="<?= $k ?>"></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <?php for ($c = 0; $c < $k; $c++): ?>
                                    <tr class="table-info">
                                        <td>C<?= $c + 1 ?></td>
                                        <td>Centroid Baru</td>
                                        <?php for ($d = 0; $d < 6; $d++): ?>
                                            <?php $v = rtrim(rtrim(number_format((float)$it['newCentroids'][$c][$d], 1, '.', ''), '0'), '.'); ?>
                                            <td class="text-center"><?= $v ?></td>
                                        <?php endfor; ?>
                                        <td colspan="<?= $k ?>"></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php endfor; ?>

                            </tbody>
                        </table>
                    </div>

                    <?php if (!$it['changed']): ?>
                        <div class="alert alert-success">Konvergen pada iterasi <?= (int)$it['iter'] ?></div>
                    <?php endif; ?>

                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>


    <div class="card mb-3">
        <div class="card-body">
            <h5 class="mt-2" style="font-weight:800;">Hasil Akhir Clustering (Per Kluster)</h5>
            <p style="color:#627594;font-size:0.85rem;margin-bottom:1.5rem;">Pengelompokan responden berdasarkan tingkat kecanduan internet</p>

            <?php for ($c = 0; $c < $k; $c++): ?>
                <?php
                $status = $hybrid['clusterNameMap'][$c] ?? '-';
                $noAnggota = 1;
                // Determine color class based on status
                $statusLower = strtolower($status);
                if (strpos($statusLower, 'parah') !== false) {
                    $badgeClass = 'cluster-parah';
                } elseif (strpos($statusLower, 'sedang') !== false) {
                    $badgeClass = 'cluster-sedang';
                } elseif (strpos($statusLower, 'ringan') !== false) {
                    $badgeClass = 'cluster-ringan';
                } else {
                    $badgeClass = 'cluster-normal';
                }
                ?>

                <div class="mt-4 mb-4">
                    <h6 class="fw-bold" style="color:var(--fadel-dark,#344767);">
                        Kluster <?= $c + 1 ?> — <span class="cluster-badge <?= $badgeClass ?>"><?= htmlspecialchars($status) ?></span>
                    </h6>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center" width="5%">No</th>
                                    <th>Nama</th>
                                    <th class="text-center">K1</th>
                                    <th class="text-center">K2</th>
                                    <th class="text-center">K3</th>
                                    <th class="text-center">K4</th>
                                    <th class="text-center">K5</th>
                                    <th class="text-center">K6</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hybrid['trainRows'] as $i => $row): ?>
                                    <?php
                                    $cid = $finalLabels[$i] ?? -1;
                                    if ($cid !== $c) continue;
                                    $vec = $hybrid['X_train_km'][$i] ?? [0, 0, 0, 0, 0, 0];
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $noAnggota++ ?></td>
                                        <td><?= htmlspecialchars($row['nama'] ?? '-') ?></td>
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
                                        <td colspan="8" class="text-center text-muted">Tidak ada anggota di kluster ini.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            <?php endfor; ?>
        </div>
    </div>

<?php endif; ?>