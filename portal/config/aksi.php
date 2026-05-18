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
        setFlash('alert alert-danger', 'Jenis data tidak valid.', 'fa fa-times');
        $module = ($jenis === 'testing') ? 'dataTesting' : 'dataTraining';
        echo "<script>window.location.href = 'media.php?module=$module';</script>";
        exit;
    }

    // Prepared statement
    $stmt = mysqli_prepare($conn, "DELETE FROM {$tableName} WHERE jenisData = ?");
    if (!$stmt) {
        setFlash('alert alert-danger', 'Gagal prepare query.', 'fa fa-times');
        $module = ($jenis === 'testing') ? 'dataTesting' : 'dataTraining';
        echo "<script>window.location.href = 'media.php?module=$module';</script>";
        exit;
    }

    mysqli_stmt_bind_param($stmt, "s", $jenis);

    if (mysqli_stmt_execute($stmt)) {
        $deleted = mysqli_stmt_affected_rows($stmt);
        setFlash('alert alert-success', "Berhasil menghapus {$deleted} data {$jenis}.", 'fa fa-check');
    } else {
        setFlash('alert alert-danger', 'Gagal menghapus data.', 'fa fa-times');
    }

    mysqli_stmt_close($stmt);

    $module = ($jenis === 'testing') ? 'dataTesting' : 'dataTraining';
    echo "<script>window.location.href = 'media.php?module=$module';</script>";
    exit;
}

if (isset($_POST['hapus_item']) && $_POST['hapus_item'] == '1') {
    $id = (int)($_POST['id'] ?? 0);
    $jenis = $_POST['jenis'] ?? 'training';
    $table = ($jenis === 'testing') ? 'dataset_testing' : 'dataset_training';

    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM $table WHERE id=?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                setFlash('alert alert-success', 'Data berhasil dihapus.', 'fa fa-check');
            } else {
                setFlash('alert alert-danger', 'Gagal menghapus data.', 'fa fa-times');
            }
            $stmt->close();
        }
    }

    $module = ($jenis === 'testing') ? 'dataTesting' : 'dataTraining';
    echo "<script>window.location.href = 'media.php?module=$module';</script>";
    exit;
}
