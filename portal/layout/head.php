<meta charset="utf-8" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="FADEL — Sistem Deteksi Kecanduan Internet menggunakan K-Means & Naive Bayes">
<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
<link rel="icon" type="image/png" href="assets/img/favicon.png">
<title><?php echo isset($_GET['module']) ? ucwords(str_replace("_", " ", $_GET['module'])) . " | " . TITLE : " Dashboard " . " | " . TITLE ?></title>

<!-- Preload core JS files for instant pagination initialization -->
<link rel="preload" href="assets/js/jquery.min.js" as="script">
<link rel="preload" href="assets/js/jquery.dataTables.min.js" as="script">
<link rel="preload" href="assets/js/bootstrap.min.js" as="script">

<?php

foreach ($css as $key => $value) {
?>
  <link href="<?= $value ?>" rel="stylesheet" />
<?php
}
?>
<style>
  .async-hide {
    opacity: 0 !important
  }

  th {
    text-align: left;
  }
</style>