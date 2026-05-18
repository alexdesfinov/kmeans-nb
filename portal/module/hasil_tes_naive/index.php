<?php
require_admin();

$tableName1 = "dataset_training";
$tableName2 = "dataset_testing";
$colJenis  = "jenisData";
$maxIter = 50;

$res = $conn->query("SELECT * FROM {$tableName1} WHERE jenisData='training'");

if (!$res || $res->num_rows === 0) {
    echo "<div><h5 class='text-center alert alert-warning mt-3'>MASUKAN DATA TRAINING</h5></div>";
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
?>

<?php $isPrint = defined('PRINT_MODE') && PRINT_MODE; ?>

<?php if (!$isPrint): ?>
    <div class="container-fluid">
        <h4>Hasil Naive Bayes (Prediksi Data Testing)</h4>
        <div class="card">
            <div class="card-body">
            <?php endif; ?>

            <h6 class="fw-bold text-primary">
                Hasil Prediksi Data Testing (Naive Bayes)
            </h6>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-sm" id="datatablesHasilNB">
                    <thead class="table-dark">
                        <tr>
                            <th style="width:8mm" class="text-center">No</th>
                            <th>Nama</th>
                            <th style="width:25mm" class="text-center">Prediksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($testingPreds)): ?>
                            <?php $no = 1;
                            foreach ($testingPreds as $p): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($p['row']['nama'] ?? '-') ?></td>
                                    <td class="text-center"><b><?= htmlspecialchars($p['pred_class'] ?? '-') ?></b></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">Tidak ada data testing.</td>
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