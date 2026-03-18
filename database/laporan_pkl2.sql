-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 18 Mar 2026 pada 08.41
-- Versi server: 8.0.30
-- Versi PHP: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laporan_pkl2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `baku_mutu_peruntukan`
--

CREATE TABLE `baku_mutu_peruntukan` (
  `id` bigint NOT NULL,
  `indikator_id` bigint DEFAULT NULL,
  `peruntukan` varchar(50) DEFAULT NULL,
  `baku_mutu` decimal(10,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `baku_mutu_peruntukan`
--

INSERT INTO `baku_mutu_peruntukan` (`id`, `indikator_id`, `peruntukan`, `baku_mutu`, `created_at`, `updated_at`) VALUES
(4, 8, 'Biota Laut', 5.0000, '2026-03-11 20:16:25', '2026-03-16 18:03:05'),
(5, 8, 'Pelabuhan', 5.0000, '2026-03-11 20:16:25', '2026-03-16 18:03:05'),
(6, 8, 'Wisata Bahari', 5.0000, '2026-03-11 20:16:25', '2026-03-16 18:03:05'),
(7, 9, 'Biota Laut', 0.0200, '2026-03-11 21:45:47', '2026-03-16 17:59:42'),
(8, 9, 'Pelabuhan', 0.3000, '2026-03-11 21:45:48', '2026-03-16 17:59:42'),
(9, 9, 'Wisata Bahari', 0.3000, '2026-03-11 21:45:48', '2026-03-16 17:59:42'),
(10, 10, 'Biota Laut', 1.0000, '2026-03-11 21:48:08', '2026-03-11 21:48:08'),
(11, 10, 'Pelabuhan', 5.0000, '2026-03-11 21:48:08', '2026-03-11 21:48:08'),
(12, 10, 'Wisata Bahari', 1.0000, '2026-03-11 21:48:08', '2026-03-11 21:48:08'),
(13, 11, 'Biota Laut', 0.0150, '2026-03-11 21:49:10', '2026-03-16 18:21:01'),
(14, 11, 'Pelabuhan', 0.0150, '2026-03-11 21:49:10', '2026-03-16 18:21:01'),
(15, 11, 'Wisata Bahari', 0.0150, '2026-03-11 21:49:10', '2026-03-16 18:21:01'),
(16, 12, 'Biota Laut', 20.0000, '2026-03-11 21:53:01', '2026-03-11 21:53:01'),
(17, 12, 'Pelabuhan', 80.0000, '2026-03-11 21:53:01', '2026-03-11 21:53:01'),
(18, 12, 'Wisata Bahari', 20.0000, '2026-03-11 21:53:01', '2026-03-11 21:53:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_uji`
--

CREATE TABLE `hasil_uji` (
  `id` bigint UNSIGNED NOT NULL,
  `observasi_id` bigint UNSIGNED NOT NULL,
  `indikator_id` bigint UNSIGNED NOT NULL,
  `nilai` decimal(10,4) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `file_berkas` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `baku_mutu` decimal(10,4) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `indikator_uji`
--

CREATE TABLE `indikator_uji` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_indikator` varchar(20) NOT NULL,
  `nama_indikator` varchar(100) NOT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `indikator_uji`
--

INSERT INTO `indikator_uji` (`id`, `kode_indikator`, `nama_indikator`, `satuan`, `created_at`, `updated_at`) VALUES
(8, 'P01', 'Dissolved Oxygen', 'mg/L', '2026-03-11 20:16:25', '2026-03-11 20:16:25'),
(9, 'P02', 'Amonia Total', 'mg/L', '2026-03-11 21:45:47', '2026-03-11 21:45:47'),
(10, 'P03', 'Minyak dan Lemak', 'mg/L', '2026-03-11 21:48:07', '2026-03-11 21:48:07'),
(11, 'P04', 'Ortofosfat', 'mg/L', '2026-03-11 21:49:08', '2026-03-11 21:49:08'),
(12, 'P05', 'Total Suspended Solid', 'mg/L', '2026-03-11 21:53:01', '2026-03-11 21:53:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lokasi`
--

CREATE TABLE `lokasi` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_lokasi` varchar(50) NOT NULL,
  `nama_lokasi` varchar(150) NOT NULL,
  `alamat_lokasi` varchar(255) DEFAULT NULL,
  `provinsi` varchar(100) DEFAULT NULL,
  `latitude` decimal(10,6) DEFAULT NULL,
  `longitude` decimal(10,6) DEFAULT NULL,
  `peruntukan` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `lokasi`
--

INSERT INTO `lokasi` (`id`, `kode_lokasi`, `nama_lokasi`, `alamat_lokasi`, `provinsi`, `latitude`, `longitude`, `peruntukan`, `created_at`, `updated_at`) VALUES
(27, 'T1-KS-01-009', 'Kalsel23', 'Pantai Batakan', 'Kalimantan Selatan', -4.092820, 114.613460, 'Biota Laut', '2026-03-11 22:10:13', '2026-03-11 22:10:13'),
(28, 'T1-KS-10-001', 'Kalsel16', 'Perairan Batulicin 1 (Multi Trading Pratama)', 'Kalimantan Selatan', -3.455200, 116.015690, 'Pelabuhan', '2026-03-12 17:23:11', '2026-03-12 17:23:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `observasi`
--

CREATE TABLE `observasi` (
  `id` bigint UNSIGNED NOT NULL,
  `location_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `tanggal_pemantauan` date DEFAULT NULL,
  `tahun_pemantauan` year DEFAULT NULL,
  `periode_pemantauan` varchar(50) DEFAULT NULL,
  `shu` enum('ADA SHU','TIDAK ADA SHU') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `observasi`
--

INSERT INTO `observasi` (`id`, `location_id`, `user_id`, `tanggal_pemantauan`, `tahun_pemantauan`, `periode_pemantauan`, `shu`, `created_at`, `updated_at`) VALUES
(41, 27, 26, '2026-01-12', '2026', '1', 'ADA SHU', '2026-03-11 22:12:30', '2026-03-11 22:12:30'),
(42, 28, 26, '2026-01-13', '2026', '1', 'ADA SHU', '2026-03-12 17:27:02', '2026-03-12 17:27:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','petugas') NOT NULL DEFAULT 'petugas',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(24, 'Sendi Pratama', 'admin@test.com', '$2y$12$HbFueJ9WZEhfzKpdnHOZIe7Pb5lxzMdGJVxB/Yll0fugyofKxcJqO', 'admin', '2025-11-14 20:06:08', '2025-11-15 03:25:08'),
(25, 'Indra', 'petugas@test.com', '$2y$12$3ffp4z1LJiFP.OVFYbn5PeZtnLO72VI8xPrSiBdJpl5NMwlzdk1ge', 'petugas', '2025-11-15 03:33:47', '2025-11-24 19:22:17'),
(26, 'Azrul', 'petugas2@test.com', '$2y$12$uZ1PeFeCUPyXn2YLUQZ2z.SfqN4MtmZxNgUpjTHja7BBso39QNeFG', 'petugas', '2025-11-24 18:57:04', '2025-11-24 18:57:04');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `baku_mutu_peruntukan`
--
ALTER TABLE `baku_mutu_peruntukan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `hasil_uji`
--
ALTER TABLE `hasil_uji`
  ADD PRIMARY KEY (`id`),
  ADD KEY `observasi_id` (`observasi_id`),
  ADD KEY `indikator_id` (`indikator_id`);

--
-- Indeks untuk tabel `indikator_uji`
--
ALTER TABLE `indikator_uji`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_indikator` (`kode_indikator`);

--
-- Indeks untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_lokasi` (`kode_lokasi`);

--
-- Indeks untuk tabel `observasi`
--
ALTER TABLE `observasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `baku_mutu_peruntukan`
--
ALTER TABLE `baku_mutu_peruntukan`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `hasil_uji`
--
ALTER TABLE `hasil_uji`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;

--
-- AUTO_INCREMENT untuk tabel `indikator_uji`
--
ALTER TABLE `indikator_uji`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `observasi`
--
ALTER TABLE `observasi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `hasil_uji`
--
ALTER TABLE `hasil_uji`
  ADD CONSTRAINT `hasil_uji_ibfk_1` FOREIGN KEY (`observasi_id`) REFERENCES `observasi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hasil_uji_ibfk_2` FOREIGN KEY (`indikator_id`) REFERENCES `indikator_uji` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `observasi`
--
ALTER TABLE `observasi`
  ADD CONSTRAINT `observasi_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `lokasi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `observasi_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
