<?php
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

$aksi = "module/" . ($_GET['module'] ?? '') . "/action.php";
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
      $page = isset($_GET['module']) ? $_GET['module'] : 'dashboard';
      $act = isset($_GET['act']) ? '/' . $_GET['act'] . '.php' : '/index.php';

      $target = 'module/' . $page . $act;

      if (!file_exists($target)) {
        echo "<div class='alert alert-danger'>Halaman tidak ditemukan: $target</div>";
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