<?php
require_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/../../config/koneksi.php';
include_once __DIR__ . '/../../config/function.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// === SETTING NAMA TABEL & KOLOM (sesuaikan dengan DB kamu) ===
$colJenis  = "jenisData"; // ganti jadi "jenis_data" kalau kolom kamu itu namanya jenis_data

if (isset($_POST['submit'])) {
    $err = [];

    // === VALIDASI FILE ===
    if (!isset($_FILES['filexls']) || $_FILES['filexls']['error'] !== UPLOAD_ERR_OK) {
        $err[] = "Silahkan masukkan file Excel.";
    } else {
        $file_name = $_FILES['filexls']['name'];
        $file_tmp  = $_FILES['filexls']['tmp_name'];
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (!in_array($ext, ['xls', 'xlsx'])) {
            $err[] = "File harus bertipe .xls atau .xlsx (file kamu: <b>{$ext}</b>)";
        }
    }

    // === VALIDASI JENIS DATA ===
    $jenisData = $_POST['jenisData'] ?? '';
    $allowed = ['training' => 'dataset_training', 'testing' => 'dataset_testing'];

    if (!isset($allowed[$jenisData])) {
        $err[] = "Jenis data tidak valid (harus training/testing).";
    } else {
        $tableName = $allowed[$jenisData];
    }

    if (!empty($err)) {
        $_SESSION['import_errors'] = $err;
        header('Location: media.php?module=uploadDataset');
        exit;
    }


    // === LOAD EXCEL ===
    try {
        $reader = IOFactory::createReaderForFile($file_tmp);
        $spreadsheet = $reader->load($file_tmp);
        $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
    } catch (Exception $e) {
        $_SESSION['import_errors'] = ["Gagal membaca Excel: " . htmlspecialchars($e->getMessage())];
        header('Location: media.php?module=uploadDataset');
        exit;
    }

    // === PREPARE INSERT ===
    $sql = "INSERT INTO {$tableName}
        (nama, p1, p2, p3, p4, p5, p6, p7, p8, p9, p10,
         p11, p12, p13, p14, p15, p16, p17, p18, p19, p20, {$colJenis})
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $_SESSION['import_errors'] = ["Prepare SQL gagal: " . $conn->error];
        header('Location: media.php?module=uploadDataset');
        exit;
    }

    $inserted = 0;
    $rowErrors = []; // kumpulkan error validasi per baris
    $buffer = []; // simpan data yang sudah valid sebelum insert


    // Mulai baris ke-2 (skip header)
    for ($i = 1; $i < count($rows); $i++) {
        $nama = ucwords(strtolower(trim((string)($rows[$i][1] ?? ''))));
        if ($nama === '') continue;

        $excelRow = $i + 1;
        if (!preg_match("/^[a-zA-Z\s.']+$/", $nama)) {
            $rowErrors[] = "Baris {$excelRow} nama <b>" . htmlspecialchars($nama) . "</b> tidak valid: Hanya boleh mengandung huruf, spasi, tanda kutip, dan titik.";
        }

        $p = [];
        for ($k = 1; $k <= 20; $k++) {
            $raw = trim((string)($rows[$i][1 + $k] ?? ''));

            // normalisasi dulu
            $val = normalizeJawaban($raw);

            // validasi setelah normalisasi
            if ($val === '') {
                $rowErrors[] = "Baris {$excelRow} ({$nama}) kolom p{$k} tidak valid: <b>" . htmlspecialchars($raw) . "</b>";
            }

            $p[$k] = $val; // simpan yang sudah rapi
        }

        // simpan dulu untuk insert nanti (kalau tidak ada error)
        $buffer[] = ['nama' => $nama, 'p' => $p];
    }

    // kalau ada error, batalkan import (jangan truncate / insert)
    if (!empty($rowErrors)) {
        $_SESSION['import_errors'] = $rowErrors;
        $_SESSION['import_error_title'] = "Import dibatalkan. Ada data jawaban yang tidak sesuai.";
        $stmt->close();
        header('Location: media.php?module=uploadDataset');
        exit;
    }

    // ===============================
    // DATA DI-APPEND (TIDAK DIHAPUS)
    // ===============================
    // $conn->query("TRUNCATE TABLE {$tableName}");


    foreach ($buffer as $item) {
        $nama = $item['nama'];
        $p = $item['p'];

        $params = array_merge([$nama], array_values($p), [$jenisData]);
        $stmt->bind_param(str_repeat("s", 22), ...$params);

        if ($stmt->execute()) {
            $inserted++;
        }
    }

    $stmt->close();

    setFlash('alert alert-success', "Berhasil mengimpor <b>{$inserted}</b> data baru sebagai <b>" . htmlspecialchars($jenisData) . "</b>.", 'fa fa-check');
    header('Location: media.php?module=uploadDataset');
    exit;
}
