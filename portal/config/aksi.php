<?php
//Delete Dataset Training / Testing
if (isset($_POST['hapus_berdasarkan_jenis'])) {

    // Ambil jenis dari form
    $jenis = $_POST['jenisData'] ?? '';
    
    // Whitelist biar aman (hindari jenisData ngawur dan SQL injection)
    $allowed = ['training' => 'dataset_training', 'testing' => 'dataset_testing'];
    
    if (!isset($allowed[$jenis])) {
        setFlash('alert alert-danger', 'Jenis data tidak valid.', 'fa fa-times');
        header('Location: media.php?module=dataTraining');
        exit;
    }

    $tableName = $allowed[$jenis];

    // Prepared statement
    $stmt = $conn->prepare("DELETE FROM {$tableName} WHERE jenisData = ?");
    if (!$stmt) {
        setFlash('alert alert-danger', 'Gagal prepare query.', 'fa fa-times');
        $module = ($jenis === 'testing') ? 'dataTesting' : 'dataTraining';
        header('Location: media.php?module=' . $module);
        exit;
    }

    $stmt->bind_param("s", $jenis);

    if ($stmt->execute()) {
        $deleted = $stmt->affected_rows;
        setFlash('alert alert-success', "Berhasil menghapus {$deleted} data {$jenis}.", 'fa fa-check');
    } else {
        setFlash('alert alert-danger', 'Gagal menghapus data.', 'fa fa-times');
    }

    $stmt->close();

    $module = ($jenis === 'testing') ? 'dataTesting' : 'dataTraining';
    header('Location: media.php?module=' . $module);
    exit;
}

if (isset($_POST['hapus_item']) && $_POST['hapus_item'] == '1') {
    $id = (int)($_POST['id'] ?? 0);
    $jenis = $_POST['jenis'] ?? 'training';
    
    $allowed = ['training' => 'dataset_training', 'testing' => 'dataset_testing'];
    if (!isset($allowed[$jenis])) {
        setFlash('alert alert-danger', 'Jenis data tidak valid.', 'fa fa-times');
        header('Location: media.php?module=dataTraining');
        exit;
    }

    $table = $allowed[$jenis];

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
    header('Location: media.php?module=' . $module);
    exit;
}
