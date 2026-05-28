# SD NEGERI 16 TIMBALUN — Sistem Deteksi Kecanduan Internet

Aplikasi web berbasis Data Mining untuk mendeteksi dan mengklasifikasikan tingkat kecanduan internet pada siswa menggunakan pendekatan hybrid **K-Means Clustering** dan **Naive Bayes Classifier** di **SD Negeri 16 Timbalun**.

Aplikasi ini menggunakan PHP Native (tanpa framework besar) dengan performa cepat, responsif menggunakan Bootstrap 5, serta dilengkapi fitur keamanan mutakhir.

---

## 🚀 Fitur Utama

- **Analisis K-Means Clustering**: Mengelompokkan data responden berdasarkan kemiripan pola jawaban ke dalam cluster. Dilengkapi visualisasi detail jarak Euclidean per iterasi.
- **Prediksi Naive Bayes**: Melakukan klasifikasi tingkat kecanduan internet untuk data testing (responden baru) dengan Laplace smoothing $\alpha = 1.0$.
- **Unggah Dataset Massal (CSV/Excel)**: Import banyak data responden sekaligus menggunakan library spreadsheet terintegrasi.
- **Multi-Level User Access**:
  - **Admin (Peneliti)**: Manajemen dataset training/testing, penetapan centroid awal, eksekusi K-Means, latih model Naive Bayes, cetak laporan.
  - **User (Responden)**: Mengisi 20 pertanyaan kuesioner secara mandiri dan melihat hasil analisis miliknya sendiri.
- **Cetak Laporan**: Halaman ramah cetak (print-ready) yang rapi untuk kebutuhan dokumentasi hasil analisis.

---

## 🛠️ Kebutuhan Sistem (System Requirements)

- **Web Server**: Apache atau Nginx (disarankan menggunakan bundle **XAMPP**)
- **PHP**: Versi **8.1** atau yang lebih baru (mendukung operator `match`, `fn()`, dsb.)
- **Database**: MySQL / MariaDB versi 10.4 atau yang lebih baru
- **Ekstensi PHP**: `mysqli`, `mbstring`, `openssl`
- **Composer**: Terinstal di komputer Anda (dibutuhkan untuk menginstal library pembaca berkas CSV/Excel di modul upload dataset)

---

## 📦 Langkah Setup & Instalasi (Setup & Installation Guide)

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi Kmeans-NB secara lokal di komputer Anda:

### 1. Download / Clone Proyek
Unduh repositori proyek ini dan tempatkan pada folder server lokal Anda:
- Jika menggunakan XAMPP di Windows, letakkan di: `C:\xampp\htdocs\Kmeans-NB`

### 2. Import Database
1. Jalankan **XAMPP Control Panel** dan aktifkan modul **Apache** dan **MySQL**.
2. Buka browser dan akses phpMyAdmin melalui URL: `http://localhost/phpmyadmin/`.
3. Buat database baru dengan nama `kmeans_nb`.
4. Pilih database `kmeans_nb` tersebut, lalu pergi ke tab **Import**.
5. Pilih file database yang sudah disediakan di folder proyek: `db/kmeans_nb.sql`.
6. Klik tombol **Import** (atau **Go**) dan tunggu hingga semua struktur tabel dan data berhasil diimpor.

### 3. Konfigurasi Environment (`.env`)
1. Salin file `.env.example` yang ada di root direktori proyek, lalu ubah namanya menjadi `.env`.
2. Buka file `.env` tersebut dan sesuaikan kredensial koneksi database lokal Anda. Konfigurasi standar untuk XAMPP:
   ```env
   # Mode Aplikasi (local / production)
   APP_ENV=local

   # Konfigurasi Database
   DB_HOST=localhost
   DB_USER=root
   DB_PASS=""
   DB_NAME=kmeans_nb
   ```
   *(Catatan: File `.env` ini secara otomatis diabaikan oleh Git karena tercantum di `.gitignore` untuk melindungi data kredensial).*

### 4. Instal Dependensi PHP (Composer)
Modul pengunggahan dataset menggunakan library pihak ketiga. Anda harus menginstal dependensi ini:
1. Buka terminal (CMD / PowerShell / Terminal git).
2. Arahkan direktori terminal ke subfolder pengunggah dataset:
   ```bash
   cd portal/module/uploadDataset
   ```
3. Jalankan perintah instalasi Composer:
   ```bash
   composer install
   ```
4. Tunggu hingga folder `vendor` berhasil terisi dengan dependensi yang diperlukan.

### 5. Jalankan Aplikasi
1. Buka browser Anda.
2. Akses aplikasi melalui URL berikut:
   ```url
   http://localhost/Kmeans-NB/
   ```
3. Halaman landing page akan terbuka.

---

## 🔐 Informasi Akun Bawaan (Default Accounts)

Untuk mempermudah pengujian awal, Anda dapat masuk menggunakan akun uji coba berikut:

- **Akun Administrator**:
  - **Username**: `admin`
  - **Password**: `admin12345`

- **Akun User (Responden)**:
  - **Username**: `user`
  - **Password**: `user12345`

---

## 📁 Struktur Direktori Utama

```text
Kmeans-NB/
├── assets/                  # Aset publik seperti CSS, JS, dan Gambar landing page
├── db/                      # Berisi backup database (kmeans_nb.sql)
├── page/                    # Halaman dinamis sistem (misal profile)
├── portal/                  # Inti dari aplikasi (Authenticated Dashboard)
│   ├── assets/              # Aset untuk dashboard portal
│   ├── config/              # File konfigurasi (koneksi.php, function.php)
│   ├── layout/              # Struktur pembangun halaman portal (header, footer, sidebar)
│   └── module/              # Berbagai modul fitur sistem (Data training, K-Means, Naive Bayes, dll.)
│       └── uploadDataset/   # Modul upload dataset (memiliki composer.json tersendiri)
├── .env                     # File konfigurasi kredensial lokal (tidak masuk Git)
├── .env.example             # Contoh template konfigurasi kredensial
├── .gitignore               # Konfigurasi file yang diabaikan oleh Git
└── README.md                # Dokumentasi proyek (file ini)
```

---
**Dibuat untuk Keperluan Penelitian Akademik SD Negeri 16 Timbalun.**
