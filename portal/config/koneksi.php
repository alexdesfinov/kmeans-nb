<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
$is_local = "yes";
if (strtolower($is_local) == 'yes') {
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$conn = new mysqli("localhost", "root", "", "fadel");
} else {
	$conn = new mysqli("localhost", "kitq3349_main", "1qAzxSw2#@!", "kitq3349_gizi");
}
