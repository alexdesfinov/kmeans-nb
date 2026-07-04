<?php
define('SECURE_ACCESS', true);
include 'config/koneksi.php';
include 'config/assets.php';
include 'config/function.php';

rememberMeTryLogin($conn);

if (isset($_GET['logout'])) {
  logoutUser($conn); // ini akan delete token + clear cookie + destroy session + redirect
}

// kalau tetap belum login, lempar ke index
if (empty($_SESSION['id'])) {
  header('Location: index.php');
  exit;
}

// Validasi modul di awal (whitelist)
$allowed_modules = [
  'dashboard', 'dataTesting', 'dataTraining', 'hasil_tes', 
  'hasil_tes_naive', 'inputData', 'inputDataUser', 'print', 
  'uploadDataset', 'user'
];
$page = isset($_GET['module']) ? $_GET['module'] : 'dashboard';
if (!in_array($page, $allowed_modules)) {
  header('Location: media.php?module=dashboard');
  exit;
}

// Jika modul yang dipanggil adalah print, render langsung tanpa layout media.php
if ($page === 'print') {
  include 'module/print/index.php';
  exit;
}

$aksi = "module/" . $page . "/action.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'layout/head.php'; ?>
  <?php if (($_SESSION['level'] ?? 'user') === 'user'): ?>
    <style>
      #sidenav-main {
        display: none !important;
      }
      .main-content {
        margin-left: 0 !important;
      }
      .navbar-main {
        margin-left: 0 !important;
        margin-right: 0 !important;
      }
    </style>
  <?php endif; ?>
</head>

<body class="g-sidenav-show  bg-gray-100">
  <?php include 'layout/nav.php'; ?>
  <main id="mainContent" class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php include 'layout/header.php'; ?>
    <div class="container-fluid py-4">
      <?php
      // Sanitasi act agar hanya mengandung huruf dan angka saja (mencegah path traversal)
      $act_clean = isset($_GET['act']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['act']) : 'index';
      $target = 'module/' . $page . '/' . $act_clean . '.php';

      if (!file_exists($target)) {
        echo "<div class='alert alert-warning border-radius-lg font-weight-bold p-3' style='background:#fffbeb; color:#92400e; border: 1.5px dashed #f59e0b;'>Halaman yang Anda cari tidak ditemukan.</div>";
      } else {
        include $target;
      }

      ?>
    </div>
    </div>
    </div>
    <?php //include 'layout/footer.php'; 
    ?>
    </div>
  </main>
  <?php include 'layout/script.php'; ?>
</body>

</html>