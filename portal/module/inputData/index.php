<?php

$questions = [
    1 => "Seberapa sering anak Anda melanggar batas waktu yang Anda tetapkan dalam menggunakan gadget?",
    2 => "Seberapa sering anak Anda mengabaikan pekerjaan rumah tangga (misalnya merapikan mainan) untuk menghabiskan lebih banyak waktu dengan gadget?",
    3 => "Seberapa sering anak Anda memilih untuk menghabiskan waktu dengan gadget daripada dengan anggota keluarga lainnya?",
    4 => "Seberapa sering anak Anda membentuk hubungan baru dengan pengguna game online lainnya?",
    5 => "Seberapa sering Anda mengeluhkan durasi waktu yang dihabiskan anak Anda di internet / menggunakan gadget?",
    6 => "Seberapa sering nilai anak Anda menurun karena jumlah waktu yang dia habiskan di internet / menggunakan gadget?",
    7 => "Seberapa sering anak Anda memeriksa perangkatnya sebelum melakukan hal lain?",
    8 => "Seberapa sering anak Anda tampak menjauh dari orang lain sejak gadget itu ada?",
    9 => "Seberapa sering anak Anda membela diri atau diam ketika ditanya apa yang dia lakukan saat menggunakan internet / gadget?",
    10 => "Seberapa sering Anda melihat anak Anda mengintip untuk berselancar di internet/menggunakan gadget tanpa seizin Anda?",
    11 => "Seberapa sering anak Anda menghabiskan waktu sendiri di kamarnya bermain dengan gadget?",
    12 => "Seberapa sering anak Anda menerima panggilan telepon dari orang asing dari teman-teman online baru mereka?",
    13 => "Seberapa sering anak Anda marah/berulah jika dia terganggu saat menggunakan gadget?",
    14 => "Seberapa sering anak Anda terlihat lebih lelah daripada sebelumnya setelah menggunakan gadget?",
    15 => "Seberapa sering anak Anda ingin menggunakan gadget segera setelah dia tidak menggunakan gadget?",
    16 => "Seberapa sering anak Anda mengamuk ketika Anda campur tangan tentang seberapa banyak waktu yang dihabiskannya menggunakan gadget?",
    17 => "Seberapa sering anak Anda memilih untuk menghabiskan waktu menggunakan gadget daripada melakukan hobi atau aktivitas lain di luar rumah?",
    18 => "Seberapa sering anak Anda marah atau berargumen ketika Anda membatasi seberapa banyak waktu yang diizinkan untuk menggunakan gadgetnya?",
    19 => "Seberapa sering anak Anda memilih untuk menghabiskan lebih banyak waktu menggunakan gadget daripada pergi keluar bersama teman-teman (misalnya bersepeda, bermain di taman)?",
    20 => "Seberapa sering anak Anda merasa tertekan, memiliki perubahan suasana hati, atau cemas saat tidak menggunakan gadget, dan ingin segera menggunakan gadget mereka?"
];

$opts = allowedJawabanList();

$isEdit = (isset($_GET['edit']) && $_GET['edit'] == '1');
$jenisEdit = $_GET['jenis'] ?? '';
$editId = (int)($_GET['id'] ?? 0);

$editCtx = null;
if ($isEdit) {
    if (($jenisEdit !== 'training' && $jenisEdit !== 'testing') || $editId <= 0) {
        $isEdit = false;
        $errorMsg = "Parameter edit tidak valid.";
    } else {
        $editCtx = ['isEdit' => true, 'jenis' => $jenisEdit, 'id' => $editId];
    }
}


$state = handleInsertDatasetFromPost($conn, "dataset", "jenisData", $editCtx);
$successMsg = $state['successMsg'];
$errorMsg = $state['errorMsg'];
$old = $state['old'];

if ($isEdit && $editCtx && !isset($_POST['submit'])) {
    $row = fetchRowForEdit($conn, $jenisEdit, $editId);
    if ($row) {
        $old['nama'] = $row['nama'] ?? '';
        $old['jenisData'] = $jenisEdit;
        for ($i = 1; $i <= 20; $i++) {
            $old['p'][$i] = $row["p$i"] ?? '';
        }
    } else {
        $errorMsg = "Data tidak ditemukan.";
        $isEdit = false;
        $editCtx = null;
    }
}

?>

<?php if ($successMsg): ?>
    <div class="alert alert-success"><?= $successMsg ?></div>
<?php endif; ?>
<?php if ($errorMsg): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
<?php endif; ?>

<form method="post">
    <div>
        <div class="name-body">
            <div class="question-body">
                <div class="question-type">
                    <span class="type-title">NAMA</span>
                </div>

                <input type="text" class="name-input" name="nama"
                    value="<?= htmlspecialchars($old['nama'] ?? '') ?>"
                    placeholder="Masukkan nama" required>

                <?php if (!$isEdit): ?>
                    <div class="mt-3 jenis-data">
                        <select class="question-dropdown" name="jenisData" required>
                            <option value="">-- Jenis Data --</option>
                            <option value="training" <?= (($old['jenisData'] ?? '') === 'training') ? 'selected' : '' ?>>Data Training</option>
                            <option value="testing" <?= (($old['jenisData'] ?? '') === 'testing') ? 'selected' : '' ?>>Data Testing</option>
                        </select>
                    </div>
                <?php else: ?>
                    <div class="mt-3">
                        <span class="badge bg-info">Mode Edit: <?= htmlspecialchars($jenisEdit) ?> (ID: <?= (int)$editId ?>)</span>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>


    <div class="question-card">
        <div class="question-header">
            <span class="question-title">INPUT DATA</span>
        </div>
        <div class="question-container">
            <div class="name-body">
                <?php for ($i = 1; $i <= 20; $i++): ?>
                    <div class="question-body">
                        <div class="question-type">
                            <span class="type-title">PERTANYAAN <?= $i ?></span>
                            <span class="type-desc">Masukan Jawaban Anda</span>
                        </div>

                        <div class="question-content">
                            <label class="question-label"><?= htmlspecialchars($questions[$i] ?? "Pertanyaan $i") ?></label>

                            <select class="question-dropdown" name="p<?= $i ?>" required>
                                <option value="">-- Pilih Jawaban --</option>
                                <?php foreach ($opts as $opt): ?>
                                    <option value="<?= htmlspecialchars($opt) ?>"
                                        <?= (($old['p'][$i] ?? '') === $opt) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($opt) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
            <div class="mt-3">
                <input type="submit" name="submit" class="btn btn-primary" value="<?= $isEdit ? 'Update Data' : 'Input Data' ?>">
            </div>
        </div>
    </div>
</form>