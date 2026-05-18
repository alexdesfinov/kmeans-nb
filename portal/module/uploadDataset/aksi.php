<?php
require 'vendor/autoload.php';
include_once '../../config/koneksi.php';
include_once '../../config/function.php';

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

    if ($jenisData === 'training') {
        $tableName = "dataset_training";
    } elseif ($jenisData === 'testing') {
        $tableName = "dataset_testing";
    }

    if ($jenisData !== 'training' && $jenisData !== 'testing') {
        $err[] = "Jenis data tidak valid (harus training/testing).";
    }

    if (!empty($err)) {
        echo '<div class="alert alert-danger"><ul><li>' . implode('</li><li>', $err) . '</li></ul></div>';
        return;
    }


    // === LOAD EXCEL ===
    try {
        $reader = IOFactory::createReaderForFile($file_tmp);
        $spreadsheet = $reader->load($file_tmp);
        $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Gagal membaca Excel: ' . htmlspecialchars($e->getMessage()) . '</div>';
        return;
    }

    // === PREPARE INSERT ===
    $sql = "INSERT INTO {$tableName}
        (nama, p1, p2, p3, p4, p5, p6, p7, p8, p9, p10,
         p11, p12, p13, p14, p15, p16, p17, p18, p19, p20, {$colJenis})
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        echo '<div class="alert alert-danger">Prepare SQL gagal: ' . mysqli_error($conn) . '</div>';
        return;
    }

    $inserted = 0;
    $rowErrors = []; // kumpulkan error validasi per baris
    $buffer = []; // simpan data yang sudah valid sebelum insert


    // Mulai baris ke-2 (skip header)
    // Mulai baris ke-2 (skip header)
    for ($i = 1; $i < count($rows); $i++) {
        $nama = trim((string)($rows[$i][1] ?? ''));
        if ($nama === '') continue;

        $p = [];
        for ($k = 1; $k <= 20; $k++) {
            $raw = trim((string)($rows[$i][1 + $k] ?? ''));

            // normalisasi dulu
            $val = normalize_jawaban($raw);

            // validasi setelah normalisasi
            if ($val === '') {
                $excelRow = $i + 1;
                $rowErrors[] = "Baris {$excelRow} ({$nama}) kolom p{$k} tidak valid: <b>" . htmlspecialchars($raw) . "</b>";
            }

            $p[$k] = $val; // simpan yang sudah rapi

        }

        // simpan dulu untuk insert nanti (kalau tidak ada error)
        $buffer[] = ['nama' => $nama, 'p' => $p];
    }

    // kalau ada error, batalkan import (jangan truncate / insert)
    if (!empty($rowErrors)) {
        echo '<div class="alert alert-danger"><b>Import dibatalkan.</b> Ada data jawaban yang tidak sesuai.</div>';
        echo '<div class="alert alert-warning"><ul><li>' . implode('</li><li>', $rowErrors) . '</li></ul></div>';
        mysqli_stmt_close($stmt);
        return;
    }

    // ===============================
    // 🚨 TRUNCATE TABEL SEBELUM INSERT
    // ===============================
    mysqli_query($conn, "TRUNCATE TABLE {$tableName}");


    foreach ($buffer as $item) {
        $nama = $item['nama'];
        $p = $item['p'];

        mysqli_stmt_bind_param(
            $stmt,
            str_repeat("s", 22),
            $nama,
            $p[1],
            $p[2],
            $p[3],
            $p[4],
            $p[5],
            $p[6],
            $p[7],
            $p[8],
            $p[9],
            $p[10],
            $p[11],
            $p[12],
            $p[13],
            $p[14],
            $p[15],
            $p[16],
            $p[17],
            $p[18],
            $p[19],
            $p[20],
            $jenisData
        );

        if (mysqli_stmt_execute($stmt)) {
            $inserted++;
        }
    }

    mysqli_stmt_close($stmt);

    echo '<div class="alert alert-success">
        Dataset lama berhasil dihapus.<br>
        Berhasil import <b>' . $inserted . '</b> baris sebagai <b>' . htmlspecialchars($jenisData) . '</b>.
    </div>';
}
