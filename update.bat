<# : batch portion
@echo off
powershell -NoProfile -ExecutionPolicy Bypass -Command "iex (Get-Content '%~f0' -Raw)" & exit /b
#>

# --- KONFIGURASI PROYEK ---
# PENTING: Ganti URL di bawah ini dengan URL repository GitHub Anda yang asli setelah di-publish!
$RepoUrl = "https://github.com/alexdesfinov/kmeans-nb.git"
$BranchName = "main"
# --------------------------

# Set Title
$host.UI.RawUI.WindowTitle = "Auto-Update Proyek Kmeans-NB"

Clear-Host
Write-Host "===================================================" -ForegroundColor Gray
Write-Host "Memulai proses pemeriksaan dan update proyek..." -ForegroundColor Gray
Write-Host "===================================================" -ForegroundColor Gray
Write-Host ""

Write-Host "Memeriksa instalasi Git..." -ForegroundColor Cyan

# Fungsi untuk mengecek apakah git bisa dijalankan
function Test-Git {
    try {
        $null = git --version
        return $true
    } catch {
        return $false
    }
}

# 1. Cek & Install Git jika belum ada
if (!(Test-Git)) {
    Write-Host "Git tidak ditemukan di sistem ini." -ForegroundColor Yellow
    Write-Host "Mencoba menginstal Git secara otomatis..." -ForegroundColor Cyan
    
    $wingetCheck = Get-Command winget -ErrorAction SilentlyContinue
    if ($wingetCheck) {
        Write-Host "Menginstal Git menggunakan winget..." -ForegroundColor Cyan
        Start-Process winget -ArgumentList "install --id Git.Git -e --source winget --accept-source-agreements --accept-package-agreements" -NoNewWindow -Wait
    } else {
        Write-Host "winget tidak ditemukan. Mengunduh installer Git dari web resmi..." -ForegroundColor Cyan
        $installerUrl = "https://github.com/git-for-windows/git/releases/download/v2.41.0.windows.1/Git-2.41.0-64-bit.exe"
        $installerPath = "$env:TEMP\Git-Installer.exe"
        
        try {
            Invoke-WebRequest -Uri $installerUrl -OutFile $installerPath
        } catch {
            Write-Host ""
            Write-Host "[!] GAGAL TERHUBUNG KE INTERNET" -ForegroundColor Red
            Write-Host "Tidak dapat mengunduh Git karena komputer tidak terhubung ke internet." -ForegroundColor Yellow
            Write-Host "Silakan aktifkan koneksi internet Anda dan coba lagi." -ForegroundColor Yellow
            Write-Host ""
            Write-Host "===================================================" -ForegroundColor Gray
            Write-Host "Proses dibatalkan." -ForegroundColor Gray
            Write-Host "===================================================" -ForegroundColor Gray
            Read-Host "Tekan Enter untuk keluar..."
            return
        }
        
        Write-Host "Menjalankan installer Git. Silakan setujui jika ada permintaan izin administrator (UAC)..." -ForegroundColor Yellow
        Start-Process -FilePath $installerPath -ArgumentList "/VERYSILENT /NORESTART /NOCANCEL /SP-" -NoNewWindow -Wait
    }
    
    Write-Host "Memperbarui Environment Path..." -ForegroundColor Cyan
    $env:Path = [System.Environment]::GetEnvironmentVariable("Path", "Machine") + ";" + [System.Environment]::GetEnvironmentVariable("Path", "User")
    
    if (!(Test-Git)) {
        Write-Host "Gagal menginstal Git secara otomatis. Silakan instal Git secara manual dari: https://git-scm.com/" -ForegroundColor Red
        Write-Host ""
        Write-Host "===================================================" -ForegroundColor Gray
        Write-Host "Proses selesai." -ForegroundColor Gray
        Write-Host "===================================================" -ForegroundColor Gray
        Read-Host "Tekan Enter untuk keluar..."
        return
    } else {
        Write-Host "Git berhasil diinstal!" -ForegroundColor Green
    }
} else {
    Write-Host "Git sudah terpasang." -ForegroundColor Green
}

# 2. Cek apakah direktori ini adalah repositori Git
if (!(Test-Path ".git")) {
    Write-Host "Direktori ini belum diinisialisasi Git. Melakukan setup awal..." -ForegroundColor Yellow
    
    git init
    git remote add origin $RepoUrl
    
    Write-Host "Mengunduh kode proyek dari GitHub..." -ForegroundColor Cyan
    $fetchOutput = git fetch origin 2>&1
    if ($LASTEXITCODE -ne 0) {
        Write-Host ""
        Write-Host "[!] GAGAL TERHUBUNG KE INTERNET" -ForegroundColor Red
        Write-Host "Tidak dapat terhubung ke GitHub / internet." -ForegroundColor Yellow
        Write-Host "Pastikan komputer Anda terhubung ke internet dan coba lagi." -ForegroundColor Yellow
        Write-Host ""
        Write-Host "===================================================" -ForegroundColor Gray
        Write-Host "Proses dibatalkan." -ForegroundColor Gray
        Write-Host "===================================================" -ForegroundColor Gray
        Read-Host "Tekan Enter untuk keluar..."
        return
    }
    
    git checkout -b $BranchName
    git branch --set-upstream-to=origin/$BranchName $BranchName
    git reset --hard origin/$BranchName
    Write-Host "Inisialisasi berhasil dan proyek diperbarui!" -ForegroundColor Green
} else {
    Write-Host "Direktori sudah berupa repositori Git." -ForegroundColor Green
    
    $remoteCheck = git remote -v
    if ($remoteCheck -notmatch "origin") {
        Write-Host "Menambahkan remote origin ke $RepoUrl..." -ForegroundColor Yellow
        git remote add origin $RepoUrl
    } else {
        git remote set-url origin $RepoUrl
    }
    
    Write-Host "Mengambil pembaruan terbaru dari GitHub..." -ForegroundColor Cyan
    $fetchOutput = git fetch origin 2>&1
    if ($LASTEXITCODE -ne 0) {
        Write-Host ""
        Write-Host "[!] GAGAL TERHUBUNG KE INTERNET" -ForegroundColor Red
        Write-Host "Tidak dapat memeriksa pembaruan karena komputer Anda belum terhubung ke internet." -ForegroundColor Yellow
        Write-Host "Silakan aktifkan koneksi internet Anda lalu jalankan kembali script ini." -ForegroundColor Yellow
        Write-Host ""
        Write-Host "===================================================" -ForegroundColor Gray
        Write-Host "Proses dibatalkan." -ForegroundColor Gray
        Write-Host "===================================================" -ForegroundColor Gray
        Read-Host "Tekan Enter untuk keluar..."
        return
    }
    
    $localHash = git rev-parse HEAD
    $remoteHash = git rev-parse origin/$BranchName
    
    if ($localHash -eq $remoteHash) {
        Write-Host "Proyek Anda sudah versi terbaru. Tidak ada perubahan." -ForegroundColor Green
    } else {
        Write-Host "Menemukan pembaruan baru! Menerapkan perubahan..." -ForegroundColor Yellow
        git reset --hard origin/$BranchName
        Write-Host "Proyek berhasil diperbarui ke versi terbaru!" -ForegroundColor Green
    }
}

Write-Host ""
Write-Host "===================================================" -ForegroundColor Gray
Write-Host "Proses selesai." -ForegroundColor Gray
Write-Host "===================================================" -ForegroundColor Gray
Read-Host "Tekan Enter untuk keluar..."
