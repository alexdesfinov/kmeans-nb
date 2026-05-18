<?php
include 'config/koneksi.php';
include 'config/assets.php';
include 'config/function.php';

remember_me_try_login($conn);

if (isset($_GET['logout'])) {
  logout_user($conn); // ini akan delete token + clear cookie + destroy session + redirect
}

// kalau tetap belum login, lempar ke index
if (empty($_SESSION['id'])) {
  header('Location: index.php');
  exit;
}

if (isset($_GET['logout']) || !isset($_SESSION['id'])) {
  session_destroy();
  if (!isset($_GET['logout'])) {
    header('location:index.php?r=' . rawurlencode(str_replace($project, '', $_SERVER['REQUEST_URI'])));
  } else {
    header('location:index.php');
  }
}
$aksi = "module/" . $_GET['module'] . "/action.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'layout/head.php'; ?>
</head>

<body class="g-sidenav-show  bg-gray-100">
  <?php include 'layout/nav.php'; ?>
  <main id="mainContent" class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php include 'layout/header.php'; ?>
    <div class="container-fluid py-4">
      <?php
      $page = isset($_GET['module']) ? $_GET['module'] : 'dashboard.php';
      if (isset($_GET['module'])) {
        $act = isset($_GET['act']) ? '/' . $_GET['act'] . '.php' : '/index.php';
      } else {
        $act = '';
      }

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
<?php unset($_SESSION['flash']) ?>