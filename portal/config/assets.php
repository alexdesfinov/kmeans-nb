<?php
define("TITLE",	"Sistem Deteksi Kecanduan Internet");
// define(	"BASE_URL",	"http://brainy.monev-unsada.my.id");
// assets css
$css = array(
	'assets/css/bootstrap.min.css',
	'assets/css/inter.css',
	'assets/css/datatables.css',
	'assets/css/fontawesome.css',
	'assets/css/soft-ui-dashboard.min3447.css?v=1.0.5',
	'assets/css/style.css',
);
// assets javascript
$js = array(
	'assets/js/jquery.min.js',
	'assets/js/popper.min.js',
	'assets/js/bootstrap.min.js',
	'assets/js/sweetalert2.all.min.js',
	'assets/js/jquery.dataTables.min.js',
);
//breadcrumb
$breadcrumb = array();
$breadcrumb[] = ['text' => '<i class="fa fa-home"></i>', 'link' => '?'];
$breadcrumb[] = isset($_GET['module']) ? ['text' => ucwords(str_replace("_", " ", $_GET['module'])), 'link' => '?module=' . $_GET['module']] : ['text' => "Dashboard", 'link' => '?'];
if (isset($_GET['act'])) {
	$breadcrumb[] = ['text' => ucwords(str_replace("_", " ", $_GET['act'])), 'link' => '?module=' . $_GET['module'] . '&act=' . $_GET['act']];
}
