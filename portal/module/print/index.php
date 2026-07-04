<?php

// Flag supaya module tahu ini mode print (kalau kamu mau pakai)
define('PRINT_MODE', true);

// include kebutuhan dasar yang biasanya dipanggil media.php
require_once __DIR__ . '/../../config/koneksi.php';
// kalau media.php biasanya include helper/function, tambahkan juga:
require_once __DIR__ . '/../../config/function.php'; // kalau ada

requireAdmin();

if (isset($_GET['module']) && $_GET['module'] === 'print') {
    $logoKiriUrl  = 'assets/img/logos/logo-kiri.png';
    $logoKananUrl = 'assets/img/logos/logo-kanan.png';
} else {
    $logoKiriUrl  = '../../assets/img/logos/logo-kiri.png';
    $logoKananUrl = '../../assets/img/logos/logo-kanan.png';
}
// OPTIONAL: kalau portal kamu wajib login
// session_start();
// require_once __DIR__ . '/../../config/session_manager.php';

// ====== Tangkap output dari module hasil_tes (KMeans) ======
ob_start();
$pathKmeans = __DIR__ . '/../hasil_tes/index.php';     // sesuaikan kalau nama file beda
if (!file_exists($pathKmeans)) {
    $pathKmeans = __DIR__ . '/../hasil_tes.php';        // fallback
}
if (!file_exists($pathKmeans)) {
    die("File module K-Means tidak ditemukan. Cek lokasi hasil_tes.");
}
include $pathKmeans;
$htmlKmeans = ob_get_clean();

// ====== Tangkap output dari module hasil_tes_naive (Naive Bayes) ======
ob_start();
$pathNaive = __DIR__ . '/../hasil_tes_naive/index.php'; // sesuaikan kalau nama file beda
if (!file_exists($pathNaive)) {
    $pathNaive = __DIR__ . '/../hasil_tes_naive.php';     // fallback
}
if (!file_exists($pathNaive)) {
    die("File module Naive Bayes tidak ditemukan. Cek lokasi hasil_tes_naive.");
}
include $pathNaive;
$htmlNaive = ob_get_clean();
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Cetak Hasil</title>
    <style>
        @page {
            size: A4;
            margin: 14mm 12mm 16mm 12mm;
        }

        body {
            font-family: "Times New Roman", serif;
            color: #000;
        }

        /* Kop surat + layout seperti contoh */
        .topline {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 4mm
        }

        .kop {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10mm;
            padding-bottom: 4mm;
            border-bottom: 2px solid #000
        }

        .logo {
            width: 22mm;
            height: 22mm;
            object-fit: contain
        }

        .kop .center {
            flex: 1;
            text-align: center;
            line-height: 1.2
        }

        .instansi {
            font-weight: 800;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: .5px
        }

        .alamat {
            font-size: 11px;
            margin-top: 2mm
        }

        .judul {
            text-align: center;
            margin: 8mm 0 4mm 0
        }

        .judul .h1 {
            font-size: 15px;
            font-weight: 800;
            text-transform: uppercase;
            text-decoration: underline;
            margin-bottom: 2mm
        }

        .judul .h2 {
            font-size: 13px;
            font-weight: 700;
            text-decoration: underline;
            margin-bottom: 2mm
        }

        .judul .periode {
            font-size: 12px;
            margin-top: 2mm
        }

        .box {
            border: 1px solid #cfcfcf;
            border-radius: 4px;
            padding: 10px 12px;
            font-size: 12px;
            margin: 6mm 0
        }

        .box .title {
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 6px
        }

        .section-title {
            font-weight: 800;
            text-transform: uppercase;
            font-size: 13px;
            margin-top: 8mm;
            padding-bottom: 2mm;
            border-bottom: 2px solid #1e73be
        }

        .print-footer {
            position: fixed;
            bottom: 6mm;
            left: 12mm;
            right: 12mm;
            font-size: 11px;
            display: flex;
            justify-content: space-between
        }

        @media print {}

        /* ===== STYLE LAPORAN (PAKSA TABLE JADI RAPIIH) ===== */
        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
        }

        .section-title {
            margin-top: 10mm;
            font-weight: 700;
            font-size: 13px;
            border-bottom: 2px solid #1e73be;
            padding-bottom: 2mm;
        }

        h5 {
            font-size: 13px;
            font-weight: 700;
            margin: 6mm 0 2mm 0;
        }

        h6 {
            font-size: 12.5px;
            font-weight: 700;
            margin: 4mm 0 2mm 0;
        }

        table {
            width: 100% !important;
            border-collapse: collapse !important;
            margin-top: 2mm;
        }

        th,
        td {
            border: 1px solid #000 !important;
            padding: 6px 8px !important;
        }

        th {
            text-align: center !important;
            font-weight: 700 !important;
        }

        thead {
            display: table-header-group !important;
        }

        tr {
            page-break-inside: avoid;
        }

        /* Paksa tabel cluster konsisten */
        .table-cluster {
            width: 100% !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
        }

        /* Paksa lebar kolom konsisten */
        .table-cluster th:nth-child(1),
        .table-cluster td:nth-child(1) {
            width: 8mm !important;
            text-align: center !important;
        }

        .table-cluster th:nth-child(2),
        .table-cluster td:nth-child(2) {
            width: 70mm !important;
        }

        /* Nama */

        .table-cluster th:nth-child(3),
        .table-cluster td:nth-child(3),
        .table-cluster th:nth-child(4),
        .table-cluster td:nth-child(4),
        .table-cluster th:nth-child(5),
        .table-cluster td:nth-child(5),
        .table-cluster th:nth-child(6),
        .table-cluster td:nth-child(6),
        .table-cluster th:nth-child(7),
        .table-cluster td:nth-child(7),
        .table-cluster th:nth-child(8),
        .table-cluster td:nth-child(8) {
            width: 14mm !important;
            text-align: center !important;
        }

        /* Anggap semua table di Bagian I sebagai tabel cluster */
        .section-kmeans table {
            width: 100% !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
        }

        .section-kmeans th,
        .section-kmeans td {
            border: 1px solid #000 !important;
        }

        /* 1. Style untuk Tabel Anggota Kluster (8 Kolom) */
        .section-kmeans table.table-kmeans-member th:nth-child(1),
        .section-kmeans table.table-kmeans-member td:nth-child(1) {
            width: 10mm !important;
            text-align: center !important;
        }
        .section-kmeans table.table-kmeans-member th:nth-child(2),
        .section-kmeans table.table-kmeans-member td:nth-child(2) {
            width: 80mm !important;
        }
        .section-kmeans table.table-kmeans-member th:nth-child(n+3),
        .section-kmeans table.table-kmeans-member td:nth-child(n+3) {
            width: 16mm !important;
            text-align: center !important;
        }

        /* 2. Style untuk Tabel Detail Iterasi (13 Kolom) agar tidak meluber */
        .section-kmeans table.table-kmeans-iteration th:nth-child(1),
        .section-kmeans table.table-kmeans-iteration td:nth-child(1) {
            width: 8mm !important; /* No */
            text-align: center !important;
        }
        .section-kmeans table.table-kmeans-iteration th:nth-child(2),
        .section-kmeans table.table-kmeans-iteration td:nth-child(2) {
            width: 32mm !important; /* Nama */
            white-space: normal !important; /* Agar nama panjang turun ke bawah */
            word-wrap: break-word !important;
        }
        /* Kolom K1 - K6 (Kolom 3 s.d 8) */
        .section-kmeans table.table-kmeans-iteration th:nth-child(3),
        .section-kmeans table.table-kmeans-iteration td:nth-child(3),
        .section-kmeans table.table-kmeans-iteration th:nth-child(4),
        .section-kmeans table.table-kmeans-iteration td:nth-child(4),
        .section-kmeans table.table-kmeans-iteration th:nth-child(5),
        .section-kmeans table.table-kmeans-iteration td:nth-child(5),
        .section-kmeans table.table-kmeans-iteration th:nth-child(6),
        .section-kmeans table.table-kmeans-iteration td:nth-child(6),
        .section-kmeans table.table-kmeans-iteration th:nth-child(7),
        .section-kmeans table.table-kmeans-iteration td:nth-child(7),
        .section-kmeans table.table-kmeans-iteration th:nth-child(8),
        .section-kmeans table.table-kmeans-iteration td:nth-child(8) {
            width: 9mm !important;
            text-align: center !important;
        }
        /* Kolom C1 - C3 (Kolom 9 s.d 11) */
        .section-kmeans table.table-kmeans-iteration th:nth-child(9),
        .section-kmeans table.table-kmeans-iteration td:nth-child(9),
        .section-kmeans table.table-kmeans-iteration th:nth-child(10),
        .section-kmeans table.table-kmeans-iteration td:nth-child(10),
        .section-kmeans table.table-kmeans-iteration th:nth-child(11),
        .section-kmeans table.table-kmeans-iteration td:nth-child(11) {
            width: 12mm !important;
            text-align: center !important;
        }
        /* Kolom Cluster (Kolom 12) */
        .section-kmeans table.table-kmeans-iteration th:nth-child(12),
        .section-kmeans table.table-kmeans-iteration td:nth-child(12) {
            width: 13mm !important;
            text-align: center !important;
        }
        /* Kolom Keterangan (Kolom 13) */
        .section-kmeans table.table-kmeans-iteration th:nth-child(13),
        .section-kmeans table.table-kmeans-iteration td:nth-child(13) {
            width: 25mm !important;
            text-align: center !important;
            white-space: normal !important;
            word-wrap: break-word !important;
        }

        /* 3. Style untuk Tabel Ringkasan Semua Anggota (3 Kolom) */
        .section-kmeans table.table-kmeans-summary th:nth-child(1),
        .section-kmeans table.table-kmeans-summary td:nth-child(1) {
            width: 15mm !important;
            text-align: center !important;
        }
        .section-kmeans table.table-kmeans-summary th:nth-child(2),
        .section-kmeans table.table-kmeans-summary td:nth-child(2) {
            width: 110mm !important;
        }
        .section-kmeans table.table-kmeans-summary th:nth-child(3),
        .section-kmeans table.table-kmeans-summary td:nth-child(3) {
            width: 61mm !important;
            text-align: center !important;
        }


        /* ===== PERBAIKAN KHUSUS TABEL NAIVE BAYES ===== */
        #datatablesHasilNB {
            table-layout: fixed !important;
        }

        #datatablesHasilNB th,
        #datatablesHasilNB td {
            white-space: nowrap !important;
        }

        #datatablesHasilNB th:nth-child(1),
        #datatablesHasilNB td:nth-child(1) {
            width: 10mm !important;
            text-align: center !important;
        }

        #datatablesHasilNB th:nth-child(2) {
            text-align: center !important;
        }

        #datatablesHasilNB td:nth-child(2) {
            text-align: left !important;
            white-space: normal !important;
        }

        #datatablesHasilNB th:nth-child(3),
        #datatablesHasilNB td:nth-child(3) {
            width: 25mm !important;
            text-align: center !important;
            font-weight: bold !important;
        }

        .nb-block {
            margin-top: 5mm;
        }

        .nb-title {
            font-weight: 700;
            margin: 0 0 2mm 0;
            font-size: 12.5px;
        }

        .nb-table {
            width: 100% !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            font-size: 11.5px;
        }

        .nb-table th,
        .nb-table td {
            border: 1px solid #000 !important;
            padding: 6px 8px !important;
        }

        .nb-table th {
            text-align: center;
            font-weight: 700;
        }

        .nb-table td.center {
            text-align: center;
        }

        .nb-table td.bold {
            font-weight: 700;
        }
    </style>
</head>

<body>

    <div class="kop">
        <img class="logo" src="<?= $logoKiriUrl ?>" alt="Logo Kiri">
        <div class="center">
            <div class="instansi">SEKOLAH DASAR NEGERI 16 TIMBALUN</div>
            <div class="alamat">
                Jln Timbalun, Kec. Bungus Teluk Kabung, Kota Padang, Prov. Sumatera Barat<br>
                Email: sdnenambelastimbalun@gmail.com
            </div>
        </div>
        <img class="logo" src="<?= $logoKananUrl ?>" alt="Logo Kanan">
    </div>

    <div class="judul">
        <div class="h1">LAPORAN HASIL ANALISIS TINGKAT KECANDUAN INTERNET</div>
        <div class="h2">Hybrid: K-Means dan Naive Bayes</div>
        <div class="periode">Periode: <?= date('F Y'); ?></div>
    </div>

    <div style="margin-bottom: 20px; padding: 15px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 5px;">
        <h4 style="margin-top: 0; color: #495057;">KETERANGAN LAPORAN:</h4>
        <p style="margin: 5px 0; font-size: 12px; line-height: 1.5;">
            Laporan ini berisi hasil analisis menggunakan:
        </p>
        <ul style="margin: 5px 0; padding-left: 20px; font-size: 12px; line-height: 1.5;">
            <li><strong>Clustering K-Means:</strong> Mengelompokkan siswa berdasarkan tingkat kecanduan intenet ke dalam 4 cluster</li>
            <li><strong>Naive Bayes:</strong> Memprediksi tingkat kecanduan internet siswa baru berdasarkan hasil K-Means</li>
        </ul>
        <div><b>Tanggal cetak:</b> <?= date('d F Y'); ?></div>
    </div>

    <div class="section-title">Bagian I: Hasil Clustering K-Means</div>
    <div class="section-kmeans">
        <?= $htmlKmeans ?>
        <?php if (defined('PRINT_MODE') && PRINT_MODE): ?>

            <div style="margin-top:25px;">
                <h5 style="font-weight:bold;">Daftar Semua Anggota</h5>

                <table class="table table-bordered table-sm table-kmeans-summary" style="width:100%;">
                    <thead>
                        <tr>
                            <th style="width:8%; text-align:center;">No</th>
                            <th>Nama</th>
                            <th style="width:30%; text-align:center;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($hybrid['trainRows'] as $i => $row):
                            $cid = $finalLabels[$i] ?? -1;
                            $ket = $hybrid['clusterNameMap'][$cid] ?? '-';
                        ?>
                            <tr>
                                <td style="text-align:center;"><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama'] ?? '-') ?></td>
                                <td style="text-align:center; font-weight:bold;">
                                    <?= htmlspecialchars($ket) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>
    </div>

    <div class="section-title">Bagian II: Hasil Prediksi Naive Bayes</div>
    <?php
    // pastikan $testingPreds ada
    if (!isset($testingPreds) || !is_array($testingPreds)) {
        $testingPreds = [];
    }

    // urutan kategori sesuai yang kamu pakai
    $nbOrder = ['Parah', 'Sedang', 'Ringan', 'Normal'];
    $nbGroups = [];
    foreach ($nbOrder as $cat) $nbGroups[$cat] = [];

    // kelompokkan
    foreach ($testingPreds as $p) {
        $pred = $p['pred_class'] ?? '-';
        if (!isset($nbGroups[$pred])) $nbGroups[$pred] = [];
        $nbGroups[$pred][] = $p;
    }

    // tampilkan per kategori
    foreach ($nbOrder as $cat):
        $rows = $nbGroups[$cat] ?? [];
        if (count($rows) === 0) continue;
    ?>
        <div class="nb-block">
            <div class="nb-title">
                Daftar Anggota (Status: <?= htmlspecialchars($cat) ?>)
            </div>

            <table class="nb-table">
                <thead>
                    <tr>
                        <th style="width:10mm">No</th>
                        <th>Nama</th>
                        <th style="width:25mm">Prediksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($rows as $p): ?>
                        <tr>
                            <td class="center"><?= $no++ ?></td>
                            <td><?= htmlspecialchars($p['row']['nama'] ?? '-') ?></td>
                            <td class="center bold"><?= htmlspecialchars($p['pred_class'] ?? '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>

    <?php if (count($testingPreds) === 0): ?>
        <div style="margin-top:4mm; font-size:12px;">
            Data testing tidak ditemukan.
        </div>
    <?php endif; ?>
    <?= $htmlNaive ?>

    <div class="print-footer">
        <div></div>
        <div><span class="page"></span></div>
    </div>

    <script>
        window.print();

        function back() {
            history.back();
        }
        setTimeout(back, 3000);
    </script>
</body>

</html>