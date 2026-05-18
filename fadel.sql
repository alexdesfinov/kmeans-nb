-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Feb 2026 pada 19.50
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fadel`
--
CREATE DATABASE IF NOT EXISTS `fadel` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fadel`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `centroid`
--

CREATE TABLE IF NOT EXISTS `centroid` (
  `id_centroid` int(11) NOT NULL AUTO_INCREMENT,
  `source_id` int(11) DEFAULT NULL,
  `data_centroid` varchar(255) NOT NULL,
  PRIMARY KEY (`id_centroid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `centroid`
--

INSERT INTO `centroid` (`id_centroid`, `source_id`, `data_centroid`) VALUES
(1, 4, '4,5,4,4,9,8'),
(2, 8, '6,7,7,5,23,13'),
(3, 10, '7,5,2,3,7,7');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dataset_testing`
--

CREATE TABLE IF NOT EXISTS `dataset_testing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `p1` varchar(20) NOT NULL,
  `p2` varchar(20) NOT NULL,
  `p3` varchar(20) NOT NULL,
  `p4` varchar(20) NOT NULL,
  `p5` varchar(20) NOT NULL,
  `p6` varchar(20) NOT NULL,
  `p7` varchar(20) NOT NULL,
  `p8` varchar(20) NOT NULL,
  `p9` varchar(20) NOT NULL,
  `p10` varchar(20) NOT NULL,
  `p11` varchar(20) NOT NULL,
  `p12` varchar(20) NOT NULL,
  `p13` varchar(20) NOT NULL,
  `p14` varchar(20) NOT NULL,
  `p15` varchar(20) NOT NULL,
  `p16` varchar(20) NOT NULL,
  `p17` varchar(20) NOT NULL,
  `p18` varchar(20) NOT NULL,
  `p19` varchar(20) NOT NULL,
  `p20` varchar(20) NOT NULL,
  `jenisData` enum('training','testing') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dataset_testing`
--

INSERT INTO `dataset_testing` (`id`, `nama`, `p1`, `p2`, `p3`, `p4`, `p5`, `p6`, `p7`, `p8`, `p9`, `p10`, `p11`, `p12`, `p13`, `p14`, `p15`, `p16`, `p17`, `p18`, `p19`, `p20`, `jenisData`) VALUES
(1, 'Dinny Aulia Putri', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Sering', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'testing');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dataset_training`
--

CREATE TABLE IF NOT EXISTS `dataset_training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `p1` varchar(20) NOT NULL,
  `p2` varchar(20) NOT NULL,
  `p3` varchar(20) NOT NULL,
  `p4` varchar(20) NOT NULL,
  `p5` varchar(20) NOT NULL,
  `p6` varchar(20) NOT NULL,
  `p7` varchar(20) NOT NULL,
  `p8` varchar(20) NOT NULL,
  `p9` varchar(20) NOT NULL,
  `p10` varchar(20) NOT NULL,
  `p11` varchar(20) NOT NULL,
  `p12` varchar(20) NOT NULL,
  `p13` varchar(20) NOT NULL,
  `p14` varchar(20) NOT NULL,
  `p15` varchar(20) NOT NULL,
  `p16` varchar(20) NOT NULL,
  `p17` varchar(20) NOT NULL,
  `p18` varchar(20) NOT NULL,
  `p19` varchar(20) NOT NULL,
  `p20` varchar(20) NOT NULL,
  `jenisData` enum('training','testing') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dataset_training`
--

INSERT INTO `dataset_training` (`id`, `nama`, `p1`, `p2`, `p3`, `p4`, `p5`, `p6`, `p7`, `p8`, `p9`, `p10`, `p11`, `p12`, `p13`, `p14`, `p15`, `p16`, `p17`, `p18`, `p19`, `p20`, `jenisData`) VALUES
(1, 'Agif Al Wafi Hendra', 'Sering', 'Kadang-Kadang', 'Jarang', 'Jarang', 'Kadang-Kadang', 'Jarang', 'Kadang-Kadang', 'Tidak Pernah', 'Kadang-Kadang', 'Kadang-Kadang', 'Jarang', 'Tidak Pernah', 'Kadang-Kadang', 'Tidak Pernah', 'Kadang-Kadang', 'Jarang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Jarang', 'training'),
(2, 'Alfian Rizki Safi\'i', 'Jarang', 'Jarang', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'training'),
(3, 'Angelina Putri', 'Kadang-Kadang', 'Kadang-Kadang', 'Jarang', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Kadang-Kadang', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Jarang', 'Tidak Pernah', 'training'),
(4, 'Bunga Erlin', 'Kadang-Kadang', 'Sering', 'Kadang-Kadang', 'Jarang', 'Jarang', 'Jarang', 'Jarang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Jarang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Jarang', 'Jarang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'training'),
(5, 'Halbi Luthfi', 'Kadang-Kadang', 'Sangat Sering', 'Sangat Sering', 'Kadang-Kadang', 'Tidak Pernah', 'Kadang-Kadang', 'Kadang-Kadang', 'Tidak Pernah', 'Kadang-Kadang', 'Tidak Pernah', 'Tidak Pernah', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Tidak Pernah', 'training'),
(6, 'Indah Nur Anugerah Z.', 'Jarang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Jarang', 'Tidak Pernah', 'Kadang-Kadang', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Kadang-Kadang', 'Jarang', 'Tidak Pernah', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Jarang', 'Kadang-Kadang', 'Kadang-Kadang', 'training'),
(7, 'Khayla Lovita Waruwu', 'Sering', 'Selalu', 'Sering', 'Tidak Pernah', 'Sering', 'Jarang', 'Selalu', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Sering', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Kadang-Kadang', 'Jarang', 'Sering', 'Jarang', 'Sering', 'Tidak Pernah', 'training'),
(8, 'Leo Waldi', 'Sering', 'Sering', 'Sangat Sering', 'Tidak Pernah', 'Tidak Pernah', 'Kadang-Kadang', 'Jarang', 'Selalu', 'Selalu', 'Selalu', 'Jarang', 'Tidak Pernah', 'Selalu', 'Sangat Sering', 'Sering', 'Sangat Sering', 'Sangat Sering', 'Sangat Sering', 'Sangat Sering', 'Sangat Sering', 'training'),
(9, 'Rafidah Atifah', 'Selalu', 'Sangat Sering', 'Sering', 'Tidak Pernah', 'Sangat Sering', 'Sering', 'Selalu', 'Sering', 'Sering', 'Jarang', 'Jarang', 'Tidak Pernah', 'Sering', 'Sering', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'training'),
(10, 'Refan Novridon', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Jarang', 'Kadang-Kadang', 'Jarang', 'Kadang-Kadang', 'Kadang-Kadang', 'Sering', 'Kadang-Kadang', 'Sering', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'training'),
(11, 'Alifa Andri Rahma', 'Jarang', 'Kadang-Kadang', 'Kadang-Kadang', 'Jarang', 'Jarang', 'Sering', 'Sering', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Kadang-Kadang', 'Jarang', 'Kadang-Kadang', 'Jarang', 'Jarang', 'Kadang-Kadang', 'Kadang-Kadang', 'Tidak Pernah', 'training'),
(12, 'Cantika Tri Oktarisma', 'Jarang', 'Kadang-Kadang', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Jarang', 'Kadang-Kadang', 'Kadang-Kadang', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Jarang', 'Tidak Pernah', 'training'),
(13, 'Davi Putra', 'Kadang-Kadang', 'Sering', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Jarang', 'Kadang-Kadang', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Sering', 'Jarang', 'Tidak Pernah', 'Sering', 'Tidak Pernah', 'Tidak Pernah', 'training'),
(14, 'Dico Septian', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Tidak Pernah', 'Kadang-Kadang', 'Sering', 'Jarang', 'Tidak Pernah', 'Kadang-Kadang', 'Tidak Pernah', 'Kadang-Kadang', 'Tidak Pernah', 'Kadang-Kadang', 'Tidak Pernah', 'Kadang-Kadang', 'Sering', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Tidak Pernah', 'training'),
(15, 'Fahiratul Sa\'dyah', 'Kadang-Kadang', 'Kadang-Kadang', 'Sering', 'Jarang', 'Kadang-Kadang', 'Tidak Pernah', 'Selalu', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Kadang-Kadang', 'Tidak Pernah', 'Sering', 'Tidak Pernah', 'Kadang-Kadang', 'Tidak Pernah', 'Tidak Pernah', 'Kadang-Kadang', 'Kadang-Kadang', 'Tidak Pernah', 'training'),
(16, 'Ikhwah Syakdyah', 'Jarang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Jarang', 'Tidak Pernah', 'Kadang-Kadang', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Kadang-Kadang', 'Jarang', 'Tidak Pernah', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Jarang', 'Kadang-Kadang', 'Kadang-Kadang', 'training'),
(17, 'Memet Jor Lukman', 'Tidak Pernah', 'Tidak Pernah', 'Sangat Sering', 'Sangat Sering', 'Sangat Sering', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Jarang', 'Sangat Sering', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Sangat Sering', 'Tidak Pernah', 'training'),
(18, 'Muhammad Raziq Hanan', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Jarang', 'Kadang-Kadang', 'Kadang-Kadang', 'Jarang', 'Tidak Pernah', 'Jarang', 'Sering', 'Kadang-Kadang', 'Tidak Pernah', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Jarang', 'training'),
(19, 'Nur Alifah Thahirah', 'Kadang-Kadang', 'Kadang-Kadang', 'Sering', 'Tidak Pernah', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Kadang-Kadang', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Kadang-Kadang', 'Kadang-Kadang', 'Jarang', 'Kadang-Kadang', 'Sering', 'Tidak Pernah', 'training'),
(20, 'Resky Aditya', 'Sangat Sering', 'Tidak Pernah', 'Kadang-Kadang', 'Sangat Sering', 'Tidak Pernah', 'Kadang-Kadang', 'Jarang', 'Selalu', 'Sering', 'Tidak Pernah', 'Kadang-Kadang', 'Jarang', 'Kadang-Kadang', 'Kadang-Kadang', 'Tidak Pernah', 'Sangat Sering', 'Selalu', 'Selalu', 'Tidak Pernah', 'Jarang', 'training'),
(21, 'Alda', 'Kadang-Kadang', 'Kadang-Kadang', 'Tidak Pernah', 'Sering', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'Kadang-Kadang', 'training'),
(22, 'Atika Zahara Rutifa', 'Jarang', 'Kadang-Kadang', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Kadang-Kadang', 'Tidak Pernah', 'Tidak Pernah', 'Kadang-Kadang', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'training'),
(23, 'Dzakira Talita Zahra', 'Tidak Pernah', 'Jarang', 'Kadang-Kadang', 'Tidak Pernah', 'Kadang-Kadang', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Kadang-Kadang', 'Kadang-Kadang', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Kadang-Kadang', 'Jarang', 'Jarang', 'Kadang-Kadang', 'Tidak Pernah', 'Sering', 'training'),
(24, 'Faini Nada', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Kadang-Kadang', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Kadang-Kadang', 'Tidak Pernah', 'Jarang', 'Jarang', 'Tidak Pernah', 'Jarang', 'training'),
(25, 'Ficky Oktarian', 'Sering', 'Sangat Sering', 'Jarang', 'Tidak Pernah', 'Jarang', 'Jarang', 'Jarang', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Kadang-Kadang', 'Jarang', 'Tidak Pernah', 'Jarang', 'Kadang-Kadang', 'Jarang', 'Kadang-Kadang', 'Tidak Pernah', 'training'),
(26, 'Fikri', 'Sering', 'Kadang-Kadang', 'Kadang-Kadang', 'Sangat Sering', 'Sangat Sering', 'Jarang', 'Tidak Pernah', 'Selalu', 'Selalu', 'Jarang', 'Tidak Pernah', 'Sering', 'Tidak Pernah', 'Sangat Sering', 'Kadang-Kadang', 'Tidak Pernah', 'Kadang-Kadang', 'Tidak Pernah', 'Jarang', 'Selalu', 'training'),
(27, 'Hafis Fachrul Rhamadhan', 'Jarang', 'Jarang', 'Jarang', 'Tidak Pernah', 'Jarang', 'Jarang', 'Jarang', 'Jarang', 'Jarang', 'Jarang', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'training'),
(28, 'Keysha Tulilmi', 'Jarang', 'Jarang', 'Jarang', 'Jarang', 'Jarang', 'Jarang', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'training'),
(29, 'Regia Putra Caniago', 'Kadang-Kadang', 'Sering', 'Kadang-Kadang', 'Jarang', 'Sering', 'Kadang-Kadang', 'Jarang', 'Sering', 'Sering', 'Jarang', 'Sangat Sering', 'Tidak Pernah', 'Sering', 'Selalu', 'Jarang', 'Jarang', 'Kadang-Kadang', 'Kadang-Kadang', 'Jarang', 'Sering', 'training'),
(30, 'Stivan Gusnindo', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Kadang-Kadang', 'Tidak Pernah', 'Sering', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Sering', 'Tidak Pernah', 'Tidak Pernah', 'Kadang-Kadang', 'Jarang', 'Tidak Pernah', 'Kadang-Kadang', 'training'),
(31, 'Dinny Aulia Putri', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Sering', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Tidak Pernah', 'Jarang', 'Tidak Pernah', 'Tidak Pernah', 'training');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `nama` varchar(100) NOT NULL,
  `level` enum('admin','user') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `level`) VALUES
(1, 'admin', '$2y$10$.ddtyzf2jiqcWmoyJcOLyeUwZIpabtkBTS/4V/rWvOusk/OJSM5qa', 'Administrator', 'admin'),
(8, 'user', '$2y$10$KQmVAJfS7zMRDJzDcKOK6uOKr6r9XDQqd3.jnhoHYj7RYOmvd5o8i', 'User', 'user');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_remember_tokens`
--

CREATE TABLE IF NOT EXISTS `user_remember_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token_hash` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `token_hash` (`token_hash`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `user_remember_tokens`
--
ALTER TABLE `user_remember_tokens`
  ADD CONSTRAINT `fk_user_remember` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
