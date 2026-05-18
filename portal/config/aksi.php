<?php
//Delete Dataset Training / Testing
if (isset($_POST['hapus_berdasarkan_jenis'])) {

    // Ambil jenis dari form
    $jenis = $_POST['jenisData'] ?? '';

    if ($jenis === 'training') {
        $tableName = "dataset_training";
    } elseif ($jenis === 'testing') {
        $tableName = "dataset_testing";
    }

    // Whitelist biar aman (hindari jenisData ngawur)
    $allowed = ['training', 'testing'];
    if (!in_array($jenis, $allowed, true)) {
        echo "<div class='alert alert-danger'>Jenis data tidak valid.</div>";
        return;
    }

    // Prepared statement
    $stmt = mysqli_prepare($conn, "DELETE FROM {$tableName} WHERE jenisData = ?");
    if (!$stmt) {
        echo "<div class='alert alert-danger'>Gagal prepare query.</div>";
        return;
    }

    mysqli_stmt_bind_param($stmt, "s", $jenis);

    if (mysqli_stmt_execute($stmt)) {
        $deleted = mysqli_stmt_affected_rows($stmt);
        echo "<div class='alert alert-success'>Berhasil menghapus {$deleted} data {$jenis}.</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus data.</div>";
    }

    mysqli_stmt_close($stmt);
}

if (isset($_POST['hapus_item']) && $_POST['hapus_item'] == '1') {
    $id = (int)($_POST['id'] ?? 0);
    $jenis = $_POST['jenis'] ?? 'training';
    $table = ($jenis === 'testing') ? 'dataset_testing' : 'dataset_training';

    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM $table WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}
