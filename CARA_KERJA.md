# CARA KERJA SISTEM FADEL
## Sistem Deteksi Kecanduan Internet — SD Negeri 16 Timbalun
### Dokumen Alur Kerja Program

---

## GAMBARAN UMUM SISTEM

Sistem ini bernama **FADEL** (First-grade Addiction DEtection cLassification), sebuah aplikasi berbasis web untuk mendeteksi tingkat kecanduan internet pada siswa SD Negeri 16 Timbalun. Sistem menggunakan pendekatan **Data Mining Hybrid**: algoritma **K-Means Clustering** untuk mengelompokkan data training, lalu hasilnya digunakan sebagai label pelatihan **Naive Bayes** untuk memprediksi data testing (data baru).

---

## ARSITEKTUR SISTEM

### Halaman yang Ada

| Halaman | URL | Akses |
|---|---|---|
| Landing Page / Beranda | `/index.php` | Publik |
| Login Portal | `/portal/index.php` | Publik |
| Portal Utama (Router) | `/portal/media.php` | Login |
| Dashboard | `media.php?module=dashboard` | Login |
| Input Data (Admin) | `media.php?module=inputData` | Admin |
| Input Data (User/Siswa) | `media.php?module=inputDataUser` | User |
| Upload Dataset Excel | `media.php?module=uploadDataset` | Admin |
| Data Training | `media.php?module=dataTraining` | Admin |
| Data Testing | `media.php?module=dataTesting` | Admin |
| Hasil K-Means | `media.php?module=hasil_tes` | Admin |
| Hasil Naive Bayes | `media.php?module=hasil_tes_naive` | Admin |
| Master User | `media.php?module=user` | Admin |
| Cetak Hasil | `media.php?module=print` | Admin |

### Struktur Database

**Tabel `users`**
- `id`, `username`, `password` (bcrypt), `nama`, `level` (enum: `admin`/`user`)

**Tabel `dataset_training`**
- `id`, `nama`, `p1`–`p20` (jawaban varchar), `jenisData` (enum: `training`/`testing`)

**Tabel `dataset_testing`**
- `id`, `nama`, `p1`–`p20` (jawaban varchar), `jenisData` (enum: `training`/`testing`)

**Tabel `centroid`**
- `id_centroid`, `source_id` (ID responden asal), `data_centroid` (vektor 6 nilai, dipisah koma)

**Tabel `user_remember_tokens`**
- `id`, `user_id`, `token_hash` (SHA-256), `expires_at`, `created_at`

---

## ALUR KERJA 1 — AKSES DAN AUTENTIKASI

### 1.1 Pengguna Mengakses Halaman Publik

1. Pengguna membuka `index.php` (Landing Page).
2. Sistem secara otomatis memanggil fungsi `rememberMeTryLogin()`:
   - Sistem memeriksa apakah ada cookie `remember_me` di browser pengguna.
   - Jika ada cookie, sistem memvalidasi formatnya (64 karakter hex).
   - Jika valid, sistem mencari token yang di-hash SHA-256 di tabel `user_remember_tokens` dan memastikan belum kedaluwarsa.
   - Jika token ditemukan dan valid, sistem langsung men-set session tanpa perlu login manual.
3. Sistem memeriksa `$_SESSION['id']`:
   - Jika sudah login: tombol navbar berubah menjadi **"Portal"** (menuju `media.php`).
   - Jika belum login: tombol navbar tetap **"Masuk Portal"** dan bagian login ditampilkan.
4. Halaman menampilkan statistik langsung dari database (jumlah cluster, fitur, dan kelas kecanduan aktif dari tabel `centroid`).

### 1.2 Proses Login

1. Pengguna membuka `portal/index.php` atau klik tombol "Masuk Portal".
2. Sistem memanggil `rememberMeTryLogin()` — jika sudah login otomatis, langsung redirect ke `media.php`.
3. Jika belum login, halaman login ditampilkan dengan form (username, password, checkbox "Ingat Saya").
4. Pengguna mengisi form dan klik Masuk.
5. Form dikirim via POST ke `portal/index.php`.
6. Sistem memanggil fungsi `handleLoginPost()`:
   - Validasi: username dan password tidak boleh kosong. Jika kosong: flash error, redirect.
   - Query ke database dengan Prepared Statement mencari username.
   - Jika username tidak ditemukan: flash error, redirect.
   - Verifikasi password menggunakan `password_verify()` (bcrypt). Jika salah: flash error, redirect.
   - Jika berhasil: `loginSetSession()` dipanggil, mengisi session id, username, nama, level.
   - Jika checkbox "Ingat Saya" dicentang: buat token acak 64-karakter hex, hash dengan SHA-256, simpan ke tabel `user_remember_tokens` (kadaluarsa 30 hari), simpan token asli ke cookie browser.
   - Redirect ke `media.php`.

### 1.3 Proses Logout

1. Pengguna klik tombol logout (URL: `media.php?logout=1`).
2. `media.php` mendeteksi `$_GET['logout']` dan memanggil `logoutUser()`:
   - Hapus semua token dari tabel `user_remember_tokens` untuk user yang logout.
   - Hapus cookie `remember_me` dari browser.
   - Hancurkan session (`session_unset()` dan `session_destroy()`).
   - Redirect ke `index.php`.

---

## ALUR KERJA 2 — ROUTING PORTAL

### 2.1 Mekanisme Router `media.php`

`media.php` berfungsi sebagai **front controller** (router tunggal) untuk seluruh portal:

1. Include `koneksi.php`, `assets.php`, dan `function.php`.
2. Memanggil `rememberMeTryLogin()` untuk mendeteksi auto-login.
3. Jika ada `?logout`, proses logout dijalankan.
4. Jika `$_SESSION['id']` kosong: redirect ke `index.php`.
5. Cek apakah `?module=print`: jika ya, langsung include `module/print/index.php` tanpa layout dan keluar.
6. Untuk modul lain, sistem membaca `$_GET['module']` (default: `dashboard`) dan `$_GET['act']` (default: `index`).
7. Path file ditentukan: `module/{module}/{act}.php`.
8. Jika file ada: di-include dalam layout portal (header, nav, sidebar, footer).
9. Jika file tidak ada: tampilkan pesan error.

### 2.2 Perbedaan Tampilan Admin vs User

- **Admin**: sidebar (sidenav) ditampilkan, terlihat semua menu.
- **User**: sidebar **disembunyikan** via CSS, `main-content` digeser ke kiri penuh. User hanya melihat halaman input kuesioner.

---

## ALUR KERJA 3 — MANAJEMEN PENGGUNA (Khusus Admin)

### 3.1 Melihat Daftar User

1. Admin membuka `media.php?module=user`.
2. Sistem memanggil `requireAdmin()`: jika bukan admin, redirect ke `media.php`.
3. Query semua user: `SELECT id, username, nama, level FROM users ORDER BY id DESC`.
4. Data ditampilkan dalam tabel dengan tombol Edit dan Hapus untuk tiap user.
5. Admin tidak bisa menghapus akunnya sendiri (tombol hapus disembunyikan untuk id yang sama dengan session id).

### 3.2 Tambah User Baru

1. Admin klik Tambah User: `media.php?module=user&act=create`.
2. Form diisi: username, password, nama, level (admin/user).
3. Klik Simpan: data dikirim POST ke `module/user/action.php`.
4. Password di-hash menggunakan `password_hash()` (bcrypt) sebelum disimpan.
5. Data di-INSERT ke tabel `users`.
6. Flash message sukses: redirect ke daftar user.

### 3.3 Edit User

1. Admin klik Edit: `media.php?module=user&act=edit&id={id}`.
2. Data user lama dimuat dari database.
3. Admin mengubah data (password bisa dikosongkan jika tidak ingin diganti).
4. Klik Simpan: UPDATE ke database.

### 3.4 Hapus User

1. Admin klik Hapus: form POST ke `action.php?module=user&act=delete`.
2. `id` user dikirim via hidden input.
3. Data user di-DELETE dari database.

---

## ALUR KERJA 4 — PENGISIAN DATA KUESIONER

### 4.1 Input Data oleh Admin (modul `inputData`)

Admin menginput data atas nama responden (siswa) secara manual:

1. Admin membuka `media.php?module=inputData`.
2. Sistem memanggil `requireAdmin()`.
3. Halaman menampilkan form wizard **4 langkah** (stepper):
   - Langkah 1: Pertanyaan 1–5
   - Langkah 2: Pertanyaan 6–10
   - Langkah 3: Pertanyaan 11–15
   - Langkah 4: Pertanyaan 16–20
4. Di bagian atas form: kolom Nama Anak dan Jenis Data (dropdown: Training / Testing).
5. Setiap pertanyaan memiliki dropdown 6 pilihan jawaban: Tidak Pernah, Jarang, Kadang-Kadang, Sering, Sangat Sering, Selalu.
6. Jawaban disimpan di **localStorage** browser sehingga jika admin berpindah tab/halaman, jawaban tidak hilang. Data localStorage dibersihkan setelah Simpan berhasil.
7. Admin klik Simpan: form dikirim POST.
8. Sistem memanggil `handleInsertDatasetFromPost()`:
   - Validasi nama (wajib diisi, hanya huruf/spasi/titik/kutip).
   - Validasi 20 jawaban: semua wajib diisi dan nilainya valid.
   - Jika jenis data training: INSERT ke `dataset_training`.
   - Jika jenis data testing: INSERT ke `dataset_testing`.
   - Flash message sukses: redirect ke modul yang sama.

**Mode Edit:**
- Admin dapat mengedit data dengan URL: `?module=inputData&edit=1&jenis=training&id={id}`.
- Data lama dimuat dari database untuk mengisi form.
- Setelah simpan: UPDATE ke tabel yang sesuai.

### 4.2 Input Data oleh Siswa/User (modul `inputDataUser`)

Siswa mengisi kuesioner untuk diri mereka sendiri:

1. User login dan otomatis diarahkan ke `media.php?module=inputDataUser`.
2. Sistem memeriksa apakah user sudah pernah mengisi kuesioner:
   - Query: `SELECT * FROM dataset_testing WHERE nama = ? LIMIT 1` (nama dari session).
   - Jika sudah ada: form ditampilkan dengan jawaban lama (mode update/perbarui).
   - Jika belum: form kosong (mode pertama kali isi).
3. Nama responden di-hardcode dari session: user tidak bisa mengubah nama sendiri.
4. Jenis data di-hardcode sebagai `testing`: user tidak bisa memilih jenis data.
5. Jawaban disimpan di **localStorage** browser agar tidak hilang saat ganti tab. Kunci penyimpanannya menggunakan format `fadel_draft_{username}` sehingga draft antar pengguna berbeda di device yang sama **tidak saling tercampur**.
6. User klik Simpan:
   - Sistem memaksa `jenisData = 'testing'` dan nama dari session (aman dari manipulasi).
   - Jika belum ada data: INSERT baru ke `dataset_testing`.
   - Jika sudah ada data: UPDATE data yang ada (berdasarkan id).
   - Flash message sukses: halaman di-refresh dengan data terbaru.

---

## ALUR KERJA 5 — UPLOAD DATASET VIA EXCEL

Admin dapat menambahkan data dalam jumlah besar menggunakan file Excel:

1. Admin membuka `media.php?module=uploadDataset`.
2. Halaman menampilkan form upload: pilih file (.xls/.xlsx) dan pilih Jenis Data (Training / Testing).
3. Admin klik Upload: form dikirim POST ke `module/uploadDataset/aksi.php`.
4. **Validasi Awal:**
   - Cek file dikirim dan tidak ada error upload.
   - Cek ekstensi file: hanya `.xls` atau `.xlsx` yang diizinkan.
   - Cek jenis data: hanya `training` atau `testing`.
5. **Baca File Excel** menggunakan library PHPSpreadsheet (`IOFactory::createReaderForFile()`).
6. **Baca Tiap Baris** (mulai baris ke-2, skip header):
   - Kolom 1 = Nama responden.
   - Kolom 2–21 = Jawaban P1–P20.
   - Setiap jawaban dinormalisasi menggunakan `normalizeJawaban()` (konversi singkatan TP, J, KK, S, SS, SL ke format lengkap).
   - Validasi nama dan jawaban. Semua error dikumpulkan.
7. **Jika Ada Error:** Import dibatalkan total — tidak ada data yang masuk. Semua error ditampilkan ke admin.
8. **Jika Semua Valid:** Data di-INSERT ke tabel. Data lama **tidak dihapus** (mode append/tambah).
9. Flash message menampilkan jumlah baris berhasil diimpor.

---

## ALUR KERJA 6 — PEMROSESAN K-MEANS CLUSTERING

Ini adalah inti algoritma pertama. K-Means mengelompokkan data training ke dalam cluster kecanduan.

### 6.1 Dua Kondisi Halaman `hasil_tes`

Halaman `media.php?module=hasil_tes` memiliki **dua kondisi tampilan** berbeda:

**Kondisi A — Sebelum Admin Klik Proses K-Means:**
- Halaman menampilkan tabel seluruh data training dari `dataset_training`.
- Menampilkan form pilih **3 centroid awal** (C1, C2, C3) berupa dropdown berisi nama responden.
- Centroid yang sebelumnya pernah dipilih otomatis ter-select dari tabel `centroid`.
- Algoritma K-Means **belum dijalankan** pada kondisi ini.

**Kondisi B — Setelah Admin Klik Proses K-Means:**
- Sistem memvalidasi 3 ID centroid yang dipilih (tidak boleh 0, tidak boleh duplikat).
- Sistem mengambil vektor fitur dari responden terpilih, menyimpannya ke tabel `centroid` (TRUNCATE lalu INSERT).
- Algoritma K-Means dijalankan dengan centroid baru tersebut.
- Halaman menampilkan tabel iterasi lengkap + hasil cluster.

### 6.2 Penentuan Centroid Awal (Detail Proses)

1. Admin membuka `media.php?module=hasil_tes`.
2. Sistem memanggil `requireAdmin()`.
3. Admin memilih 3 responden berbeda dari dropdown C1, C2, C3 lalu klik Proses K-Means:
   - Sistem membaca 3 ID yang dipilih (c1, c2, c3).
   - Validasi: tidak boleh ada ID yang bernilai 0, dan ketiga ID harus berbeda.
   - Sistem mengambil data responden terpilih dari database dan mengkonversinya ke vektor fitur 6 dimensi.
   - Vektor disimpan ke tabel `centroid` (tabel di-TRUNCATE dulu, lalu di-INSERT baru).

### 6.2 Konversi Data ke Vektor Fitur

**Langkah A: Konversi Jawaban ke Angka (Skala Likert)**

```
Tidak Pernah  = 0
Jarang        = 1
Kadang-Kadang = 2
Sering        = 3
Sangat Sering = 4
Selalu        = 5
```

Fungsi: `jawabanKeAngkaFlexible()` — menerima singkatan (TP, J, KK, S, SS, SL) maupun teks lengkap.

**Langkah B: Pengelompokan ke 6 Kategori Fitur**

20 pertanyaan dikelompokkan ke dalam 6 kategori berdasarkan `kategoriMap()`:

```
K1 (Preokupasi)       : P7, P11, P17
K2 (Toleransi)        : P1, P5, P14
K3 (Penarikan Diri)   : P15, P20
K4 (Konflik Akademik) : P2, P6
K5 (Kontrol Impuls)   : P9, P10, P13, P16, P18
K6 (Isolasi Sosial)   : P3, P4, P8, P12, P19
```

Nilai tiap kategori = jumlah total nilai jawaban pertanyaan dalam kategori tersebut.
Hasilnya: satu responden = satu vektor 6 angka, misal [4, 5, 4, 4, 9, 8].

### 6.3 Iterasi K-Means

Algoritma K-Means dijalankan dengan menyimpan seluruh jejak iterasi (fungsi `kmeansRunWithTrace`):

**Untuk setiap iterasi (maks. 50 iterasi):**

1. **Assignment Step — Hitung Jarak Euclidean:**
   - Untuk setiap responden `i` dan setiap centroid `c`:
     - Hitung jarak: d(i,c) = sqrt( sum( (x_i - c_j)^2 ) ) untuk semua 6 dimensi.
     - Simpan seluruh matriks jarak distMatrix[i][c].
   - Tentukan cluster terdekat: label[i] = cluster dengan jarak terkecil.

2. **Update Step — Hitung Centroid Baru:**
   - Centroid baru tiap cluster = rata-rata vektor semua responden yang masuk cluster tersebut.
   - Nilai dibulatkan ke 1 desimal.

3. **Cek Konvergen:**
   - Jika semua centroid baru sama dengan centroid lama (selisih < 0.0001): **konvergen**, iterasi berhenti.
   - Jika ada perubahan: lanjut ke iterasi berikutnya.

4. **Simpan Jejak Iterasi:**
   - Setiap iterasi menyimpan: centroid sebelumnya, matriks jarak, jarak minimum tiap responden, label cluster, cluster yang terbentuk, centroid baru, dan status konvergen.

### 6.4 Penamaan Cluster

Sistem menggunakan penamaan tetap berdasarkan indeks cluster:

```
Cluster 0 -> Kecanduan Sedang
Cluster 1 -> Kecanduan Parah
Cluster 2 -> Kecanduan Ringan
```

### 6.5 Tampilan Hasil K-Means

Setelah K-Means selesai, halaman menampilkan:
- Tabel iterasi lengkap: setiap iterasi menampilkan matriks jarak (D1C1, D1C2, dst.) dengan tooltip rumus perhitungan jarak.
- Tabel anggota cluster: daftar responden dan cluster-nya.
- Centroid final: nilai centroid akhir tiap cluster.

---

## ALUR KERJA 7 — PIPELINE HYBRID (K-MEANS + NAIVE BAYES)

Fungsi inti `hybridTrainFromDb()` menggabungkan kedua algoritma:

### 7.1 Fase Training

1. **Ambil Data Training**: Query ke `dataset_training` untuk semua baris jenisData = 'training'.
2. **Buat 2 Versi Vektor:**
   - X_km: Vektor untuk K-Means (nilai mentah 0–15+ per kategori) — fungsi `rowToVectorKategori()`.
   - X_nb: Vektor untuk Naive Bayes (nilai diskrit 0/1/2) — fungsi `rowToVectorKategoriNB()`:
     - Nilai 0–2 = 0 (rendah), 3–5 = 1 (sedang), >= 6 = 2 (tinggi).
3. **Jalankan K-Means** dengan centroid awal dari database.
4. **Dapatkan Label Cluster**: Setiap responden training mendapat label cluster (0, 1, atau 2).
5. **Konversi Label ke Nama Kelas**: Cluster 0 = Sedang, Cluster 1 = Parah, Cluster 2 = Ringan.
6. **Training Naive Bayes** (`nbTrainCategorical()`):
   - Input: X_nb (vektor diskrit) dan y (label dari K-Means).
   - Hitung prior probability tiap kelas: P(C) = jumlah data kelas C / total data.
   - Hitung frekuensi kemunculan tiap nilai (0/1/2) untuk tiap fitur per kelas.
   - Hasil: model berisi priors, counts, dan parameter prediksi.

### 7.2 Fase Prediksi (Naive Bayes pada Data Testing)

Fungsi `hybridPredictTesting()`:

1. **Ambil Data Testing**: Query ke `dataset_testing`.
2. **Untuk Setiap Responden Testing:**
   - Konversi jawaban ke vektor diskrit x_nb.
   - Panggil `nbPredictOne()`:
     - Untuk setiap kelas C (Ringan, Sedang, Parah):
       - Hitung log P(C) = log prior.
       - Untuk tiap fitur j dan nilai v = x_nb[j]:
         - Hitung log P(x_j = v | C) = log( count(v, j, C) / classCount(C) ) — tanpa Laplace smoothing (alpha = 0.0).
         - Jumlahkan ke log-likelihood.
     - Pilih kelas dengan log-likelihood tertinggi sebagai prediksi.
   - Hasilnya: nama kelas prediksi (pred_class) dan skor log tiap kelas (log_scores).
3. Hasil prediksi dikembalikan beserta data mentah responden untuk ditampilkan.

---

## ALUR KERJA 8 — MENAMPILKAN HASIL NAIVE BAYES

1. Admin membuka `media.php?module=hasil_tes_naive`.
2. Sistem `requireAdmin()`.
3. Sistem mengecek apakah data training ada. Jika tidak: tampilkan peringatan.
4. Sistem mengecek apakah centroid sudah ada (minimal 3 centroid). Jika tidak: tampilkan peringatan untuk jalankan K-Means dulu.
5. Pipeline hybrid dijalankan: `hybridTrainFromDb()` + `hybridPredictTesting()`.
6. Tabel hasil ditampilkan: No, Nama, Prediksi (badge warna: Ringan=hijau, Sedang=kuning, Parah=merah).

---

## ALUR KERJA 9 — DASHBOARD

Dashboard menampilkan konten yang **berbeda** tergantung level user yang login:

### 9.1 Dashboard untuk Admin (`level = admin`)

1. Sistem membaca centroid dari database (`getInitialCentroidsFromDB()`).
2. Jika centroid sudah ada (>= 3) dan data training tersedia:
   - Jalankan pipeline hybrid lengkap (`hybridTrainFromDb()` + `hybridPredictTesting()`).
   - Hitung distribusi cluster K-Means: jumlah responden di tiap cluster (Ringan/Sedang/Parah).
   - Hitung distribusi prediksi Naive Bayes pada data testing.
   - Data divisualisasikan dalam **grafik Chart.js** (distribusi K-Means dan Naive Bayes).
3. Jika centroid belum ada atau data training kosong: grafik **tidak ditampilkan**.
4. Ditampilkan card ringkasan (jumlah data training, testing, cluster) dan menu shortcut ke semua modul admin.

### 9.2 Dashboard untuk User (`level = user`)

1. Pipeline hybrid dan grafik **tidak dijalankan sama sekali** (blok `if ($isAdmin)` tidak masuk).
2. Dashboard hanya menampilkan menu shortcut ke modul yang diizinkan untuk user.
3. User langsung diarahkan untuk mengisi kuesioner melalui menu yang tersedia.

---

## ALUR KERJA 10 — CETAK LAPORAN

1. Admin membuka `media.php?module=print`.
2. `media.php` langsung include `module/print/index.php` tanpa layout portal.
3. `print/index.php` mendefinisikan konstanta `PRINT_MODE = true`.
4. File ini menggunakan output buffering (`ob_start`) untuk menangkap output dari dua modul:
   - Include `hasil_tes/index.php`: tangkap HTML hasil K-Means.
   - Include `hasil_tes_naive/index.php`: tangkap HTML hasil Naive Bayes.
5. Dua blok HTML digabungkan ke dalam satu halaman cetak lengkap:
   - Header institusi (logo kiri dan kanan, nama sekolah, judul laporan).
   - Tabel iterasi K-Means.
   - Tabel hasil Naive Bayes.
6. Halaman cetak memiliki CSS `@media print` sehingga siap cetak langsung dari browser.

---

## ALUR KERJA 11 — MANAJEMEN DATA TRAINING DAN TESTING

### Data Training (`media.php?module=dataTraining`)
1. Admin membuka halaman.
2. Query ke `dataset_training` dijalankan.
3. Data ditampilkan dalam tabel dengan pagination dan fitur pencarian (DataTables).
4. Admin bisa menghapus satu data (DELETE by ID) atau mengedit (redirect ke modul inputData dengan parameter edit).

### Data Testing (`media.php?module=dataTesting`)
Sama seperti Data Training, tapi membaca dari tabel `dataset_testing`.

---

## RINGKASAN AKTOR DAN AKSI

### Aktor: Admin

| Aksi | Modul |
|---|---|
| Login / Logout | `portal/index.php`, `media.php?logout` |
| Tambah/Edit/Hapus User | `module/user` |
| Input data responden manual | `module/inputData` |
| Upload dataset dari Excel | `module/uploadDataset` |
| Lihat dan kelola data training | `module/dataTraining` |
| Lihat dan kelola data testing | `module/dataTesting` |
| Tentukan centroid awal & jalankan K-Means | `module/hasil_tes` |
| Lihat hasil prediksi Naive Bayes | `module/hasil_tes_naive` |
| Lihat dashboard statistik | `module/dashboard` |
| Cetak laporan hasil | `module/print` |

### Aktor: User (Siswa/Orang Tua)

| Aksi | Modul |
|---|---|
| Login / Logout | `portal/index.php`, `media.php?logout` |
| Isi/Update kuesioner 20 pertanyaan | `module/inputDataUser` |

### Aktor: Sistem (Otomatis)

| Aksi | Trigger |
|---|---|
| Auto-login via cookie Ingat Saya | Setiap halaman dibuka |
| Konversi jawaban teks ke vektor angka | Saat proses K-Means/NB |
| K-Means clustering dengan trace iterasi | Saat admin klik Proses K-Means |
| Naive Bayes training dari label K-Means | Setelah K-Means selesai |
| Naive Bayes prediksi data testing | Di halaman hasil NB dan dashboard |
| Simpan centroid ke database | Setelah centroid dipilih admin |

---

## CATATAN ALUR DATA PENTING

1. **Jawaban P1–P20** tersimpan sebagai **teks** di database (misal "Sering"), bukan angka. Konversi ke angka dilakukan saat runtime sebelum algoritma dijalankan.

2. **Centroid** tersimpan sebagai **string vektor** (misal "4,5,4,4,9,8") di kolom `data_centroid`. Saat dibaca, string dikonversi ke array float.

3. **K-Means tidak otomatis menyimpan hasil cluster per responden** ke database — hasil cluster hanya ada di memori saat runtime. Yang disimpan ke database hanya **centroid final** di tabel `centroid`.

4. **Naive Bayes** selalu di-train ulang setiap halaman dimuat menggunakan data training yang ada saat itu (model tidak disimpan ke database). Jika data training berubah, prediksi otomatis berubah.

5. **Upload Excel** menggunakan mode **append** (tambah) — data lama tidak dihapus. Jika data yang sama diupload dua kali, akan ada duplikasi.

6. **Validasi impor Excel bersifat all-or-nothing**: jika satu baris saja memiliki jawaban tidak valid, seluruh file ditolak dan tidak ada data yang masuk ke database.
