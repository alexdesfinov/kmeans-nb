<?php
session_start();
include __DIR__ . '/../../config/koneksi.php';
include __DIR__ . '/../../config/function.php';

// wajib admin
requireAdmin();

$module = $_GET['module'] ?? 'user';
$act    = $_GET['act'] ?? '';

function back_to_module($module)
{
    header('Location: ../../media.php?module=' . urlencode($module));
    exit;
}

if ($act === 'create') {
    $username = trim($_POST['username'] ?? '');
    $password = (string)($_POST['password'] ?? '');
    $nama     = trim($_POST['nama'] ?? '');
    $level    = ($_POST['level'] ?? 'user') === 'admin' ? 'admin' : 'user';

    if ($username === '' || $password === '' || $nama === '') {
        setFlash('alert alert-danger', 'Username, password, dan nama wajib diisi', 'fa fa-times');
        back_to_module($module);
    }

    // cek username unik
    $stmt = mysqli_prepare($conn, "SELECT 1 FROM users WHERE username=? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $exists = (mysqli_fetch_row($res) !== null);
    mysqli_stmt_close($stmt);

    if ($exists) {
        setFlash('alert alert-danger', 'Username sudah digunakan', 'fa fa-times');
        back_to_module($module);
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password, nama, level) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        setFlash('alert alert-danger', 'Prepare gagal: ' . mysqli_error($conn), 'fa fa-times');
        back_to_module($module);
    }

    mysqli_stmt_bind_param($stmt, "ssss", $username, $hash, $nama, $level);
    $ok  = mysqli_stmt_execute($stmt);
    $err = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);

    if (!$ok) {
        setFlash('alert alert-danger', 'Gagal tambah user: ' . $err, 'fa fa-times');
        back_to_module($module);
    }

    setFlash('alert alert-success', 'User berhasil ditambahkan', 'fa fa-check');
    back_to_module($module);
}

if ($act === 'edit') {
    $id    = (int)($_POST['id'] ?? 0);
    $nama  = trim($_POST['nama'] ?? '');
    $level = ($_POST['level'] ?? 'user') === 'admin' ? 'admin' : 'user';
    $pass  = (string)($_POST['password'] ?? '');

    if ($id <= 0 || $nama === '') {
        setFlash('alert alert-danger', 'Data tidak valid', 'fa fa-times');
        back_to_module($module);
    }

    if ($pass !== '') {
        if (strlen($pass) < 6) {
            setFlash('alert alert-danger', 'Password minimal 6 karakter', 'fa fa-times');
            header('Location: ../../media.php?module=' . urlencode($module) . '&act=edit&id=' . $id);
            exit;
        }

        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($conn, "UPDATE users SET password=?, nama=?, level=? WHERE id=?");
        if (!$stmt) {
            setFlash('alert alert-danger', 'Prepare gagal: ' . mysqli_error($conn), 'fa fa-times');
            back_to_module($module);
        }
        mysqli_stmt_bind_param($stmt, "sssi", $hash, $nama, $level, $id);
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE users SET nama=?, level=? WHERE id=?");
        if (!$stmt) {
            setFlash('alert alert-danger', 'Prepare gagal: ' . mysqli_error($conn), 'fa fa-times');
            back_to_module($module);
        }
        mysqli_stmt_bind_param($stmt, "ssi", $nama, $level, $id);
    }

    $ok  = mysqli_stmt_execute($stmt);
    $err = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);

    if (!$ok) {
        setFlash('alert alert-danger', 'Gagal edit user: ' . $err, 'fa fa-times');
        back_to_module($module);
    }

    // sinkron session kalau edit diri sendiri
    if ($id === (int)($_SESSION['id'] ?? 0)) {
        $_SESSION['nama']  = $nama;
        $_SESSION['level'] = $level;
    }

    setFlash('alert alert-success', 'User berhasil diupdate', 'fa fa-check');
    back_to_module($module);
}

if ($act === 'delete') {
    $id = (int)($_POST['id'] ?? 0);

    if ($id <= 0) {
        setFlash('alert alert-danger', 'ID tidak valid', 'fa fa-times');
        back_to_module($module);
    }

    if ($id === (int)($_SESSION['id'] ?? 0)) {
        setFlash('alert alert-danger', 'Tidak bisa menghapus akun yang sedang login', 'fa fa-times');
        back_to_module($module);
    }

    $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id=?");
    if (!$stmt) {
        setFlash('alert alert-danger', 'Prepare gagal: ' . mysqli_error($conn), 'fa fa-times');
        back_to_module($module);
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    $ok  = mysqli_stmt_execute($stmt);
    $err = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);

    if (!$ok) {
        setFlash('alert alert-danger', 'Gagal hapus user: ' . $err, 'fa fa-times');
        back_to_module($module);
    }

    setFlash('alert alert-success', 'User berhasil dihapus', 'fa fa-check');
    back_to_module($module);
}


// default
setFlash('alert alert-warning', 'Aksi tidak dikenali', 'fa fa-info');
back_to_module($module);
