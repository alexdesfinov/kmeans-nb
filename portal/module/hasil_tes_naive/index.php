<?php
requireAdmin();

$tableName1 = "dataset_training";
$tableName2 = "dataset_testing";
$colJenis  = "jenisData";
$maxIter = 50;

$res = $conn->query("SELECT * FROM {$tableName1} WHERE jenisData='training'");

if (!$res || $res->num_rows === 0) {
    echo "<div class='text-center py-5'><div style='font-size:3rem;color:#d0d5dd;margin-bottom:1rem;'>📊</div><h5 class='alert alert-warning' style='display:inline-block;'>MASUKAN DATA TRAINING</h5></div>";
    return;
}

// ✅ Ambil centroid dari DB (INI WAJIB)
$initCentroids = getInitialCentroidsFromDB($conn);
$k = count($initCentroids);

if ($k < 2) {
    echo "<div class='alert alert-warning mt-3'>Centroid belum ada / belum lengkap. Pilih centroid dan proses K-Means dulu.</div>";
    return;
}

// ✅ Hybrid training pakai centroid DB supaya stabil
$hybrid = hybridTrainFromDb($conn, $k, $maxIter, $tableName1, $colJenis, $initCentroids);

if (!is_array($hybrid)) {
    echo "<div class='alert alert-danger mt-3'>Gagal memproses training.</div>";
    return;
}

// Prediksi testing pakai Naive Bayes
$testingPreds = hybridPredictTesting($conn, $hybrid, $tableName2, $colJenis);

// Helper function to determine badge class
function getPredBadgeClass(string $pred): string {
    $lower = strtolower($pred);
    if (strpos($lower, 'parah') !== false) return 'cluster-parah';
    if (strpos($lower, 'sedang') !== false) return 'cluster-sedang';
    if (strpos($lower, 'ringan') !== false) return 'cluster-ringan';
    if (strpos($lower, 'normal') !== false) return 'cluster-normal';
    return '';
}
?>

<?php $isPrint = defined('PRINT_MODE') && PRINT_MODE; ?>

<?php if (!$isPrint): ?>
    <div class="container-fluid">
        <div class="d-flex align-items-center mb-4">
            <div class="icon icon-shape icon-gradient-dark shadow text-center border-radius-md d-inline-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07"/>
                </svg>
            </div>
            <div>
                <h5 class="mb-0" style="font-weight:700;">Hasil Naive Bayes</h5>
                <p class="mb-0" style="font-size:0.78rem;color:#627594;">Prediksi tingkat kecanduan data testing</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
            <?php endif; ?>

            <h6 class="fw-bold" style="color:var(--fadel-dark,#344767);">
                Hasil Prediksi Data Testing
            </h6>

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm align-middle" id="datatablesHasilNB">
                    <thead class="table-dark">
                        <tr>
                            <th style="width:8mm" class="text-center">No</th>
                            <th>Nama</th>
                            <th style="width:35mm" class="text-center">Prediksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($testingPreds)): ?>
                            <?php $no = 1;
                            foreach ($testingPreds as $p): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td style="font-weight:500;"><?= htmlspecialchars($p['row']['nama'] ?? '-') ?></td>
                                    <td class="text-center">
                                        <span class="cluster-badge <?= getPredBadgeClass($p['pred_class'] ?? '') ?>">
                                            <?= htmlspecialchars($p['pred_class'] ?? '-') ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted" style="padding:2rem;">Tidak ada data testing.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if (!$isPrint): ?>
                <?php if (count($testingPreds) === 0): ?>
                    <div class="alert alert-warning mt-3">
                        Tidak ada data testing. Upload data dengan jenis <b>testing</b>.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>