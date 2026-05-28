<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
date_default_timezone_set("Asia/Jakarta");

/**
 * Memuat file .env secara manual dan memasukkannya ke $_ENV dan getenv()
 */
function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        return;
    }
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        // Lewati komentar atau baris kosong
        if ($line === '' || strpos($line, '#') === 0) {
            continue;
        }
        // Pisahkan key dan value
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            $key = trim($parts[0]);
            $value = trim($parts[1]);
            // Hapus tanda kutip luar jika ada
            if ((strpos($value, '"') === 0 && strrpos($value, '"') === strlen($value) - 1) ||
                (strpos($value, "'") === 0 && strrpos($value, "'") === strlen($value) - 1)) {
                $value = substr($value, 1, -1);
            }
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}

// Muat file .env dari root direktori proyek
loadEnv(dirname(dirname(__DIR__)) . '/.env');

// Ambil konfigurasi dari env
$db_host = getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? 'localhost');
$db_user = getenv('DB_USER') ?: ($_ENV['DB_USER'] ?? 'root');
$db_pass = getenv('DB_PASS') ?: ($_ENV['DB_PASS'] ?? '');
$db_name = getenv('DB_NAME') ?: ($_ENV['DB_NAME'] ?? 'kmeans_nb');
$app_env = getenv('APP_ENV') ?: ($_ENV['APP_ENV'] ?? 'local');

// Atur error reporting berdasarkan APP_ENV
if (strtolower($app_env) === 'local') {
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
} else {
	error_reporting(0);
	ini_set('display_errors', '0');
}

// Koneksi ke database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
