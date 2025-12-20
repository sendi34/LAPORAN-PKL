-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 20 Des 2025 pada 05.05
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `hasil_uji`
--

INSERT INTO `hasil_uji` (`id`, `observasi_id`, `indikator_id`, `nilai`, `keterangan`, `file_berkas`, `created_at`, `updated_at`) VALUES
(100, 20, 1, 17.5100, NULL, 'hasil_uji/BGDAzPRoPWy52kcl0flzs4IdrzoQgWUCfdVcyezw.pdf', '2025-12-12 18:34:34', '2025-12-12 18:34:34'),
(101, 20, 2, 1.2200, NULL, 'hasil_uji/BGDAzPRoPWy52kcl0flzs4IdrzoQgWUCfdVcyezw.pdf', '2025-12-12 18:34:34', '2025-12-12 18:34:34'),
(102, 20, 3, 5.9000, NULL, 'hasil_uji/BGDAzPRoPWy52kcl0flzs4IdrzoQgWUCfdVcyezw.pdf', '2025-12-12 18:34:34', '2025-12-12 18:34:34'),
(103, 20, 4, 0.0160, NULL, 'hasil_uji/BGDAzPRoPWy52kcl0flzs4IdrzoQgWUCfdVcyezw.pdf', '2025-12-12 18:34:34', '2025-12-12 18:34:34'),
(104, 20, 5, 0.0050, NULL, 'hasil_uji/BGDAzPRoPWy52kcl0flzs4IdrzoQgWUCfdVcyezw.pdf', '2025-12-12 18:34:34', '2025-12-12 18:34:34'),
(105, 21, 1, 18.3400, NULL, 'hasil_uji/O0hZpHFLGcaSSUA06AkGHcGI0Sr2Z3gmbwayNUbC.pdf', '2025-12-12 18:37:44', '2025-12-12 18:37:44'),
(106, 21, 2, 1.0500, NULL, 'hasil_uji/O0hZpHFLGcaSSUA06AkGHcGI0Sr2Z3gmbwayNUbC.pdf', '2025-12-12 18:37:44', '2025-12-12 18:37:44'),
(107, 21, 3, 5.8000, NULL, 'hasil_uji/O0hZpHFLGcaSSUA06AkGHcGI0Sr2Z3gmbwayNUbC.pdf', '2025-12-12 18:37:44', '2025-12-12 18:37:44'),
(108, 21, 4, 0.0160, NULL, 'hasil_uji/O0hZpHFLGcaSSUA06AkGHcGI0Sr2Z3gmbwayNUbC.pdf', '2025-12-12 18:37:44', '2025-12-12 18:37:44'),
(109, 21, 5, 0.0050, NULL, 'hasil_uji/O0hZpHFLGcaSSUA06AkGHcGI0Sr2Z3gmbwayNUbC.pdf', '2025-12-12 18:37:44', '2025-12-12 18:37:44'),
(110, 22, 1, 19.0600, NULL, 'hasil_uji/hciIgpYk7TB0GJyS8un1EzdFMtFY2L7AoYcToRl4.pdf', '2025-12-12 18:39:22', '2025-12-12 18:39:22'),
(111, 22, 2, 1.1500, NULL, 'hasil_uji/hciIgpYk7TB0GJyS8un1EzdFMtFY2L7AoYcToRl4.pdf', '2025-12-12 18:39:24', '2025-12-12 18:39:24'),
(112, 22, 3, 5.9000, NULL, 'hasil_uji/hciIgpYk7TB0GJyS8un1EzdFMtFY2L7AoYcToRl4.pdf', '2025-12-12 18:39:24', '2025-12-12 18:39:24'),
(113, 22, 4, 0.0160, NULL, 'hasil_uji/hciIgpYk7TB0GJyS8un1EzdFMtFY2L7AoYcToRl4.pdf', '2025-12-12 18:39:24', '2025-12-12 18:39:24'),
(114, 22, 5, 0.0050, NULL, 'hasil_uji/hciIgpYk7TB0GJyS8un1EzdFMtFY2L7AoYcToRl4.pdf', '2025-12-12 18:39:24', '2025-12-12 18:39:24'),
(115, 23, 1, 17.1900, NULL, 'hasil_uji/LFeU9Z2BMY7pfDIq8AKGoDYsF3l46hlPlnOznu8V.pdf', '2025-12-12 18:46:48', '2025-12-12 18:46:48'),
(116, 23, 2, 1.3500, NULL, 'hasil_uji/LFeU9Z2BMY7pfDIq8AKGoDYsF3l46hlPlnOznu8V.pdf', '2025-12-12 18:46:49', '2025-12-12 18:46:49'),
(117, 23, 3, 5.8000, NULL, 'hasil_uji/LFeU9Z2BMY7pfDIq8AKGoDYsF3l46hlPlnOznu8V.pdf', '2025-12-12 18:46:49', '2025-12-12 18:46:49'),
(118, 23, 4, 0.0160, NULL, 'hasil_uji/LFeU9Z2BMY7pfDIq8AKGoDYsF3l46hlPlnOznu8V.pdf', '2025-12-12 18:46:49', '2025-12-12 18:46:49'),
(119, 23, 5, 0.0050, NULL, 'hasil_uji/LFeU9Z2BMY7pfDIq8AKGoDYsF3l46hlPlnOznu8V.pdf', '2025-12-12 18:46:49', '2025-12-12 18:46:49'),
(120, 24, 1, 33.2800, NULL, 'hasil_uji/Xjlzxq56uLfwt5aZfo2QTDzULKhFeGomFhPN1Pfu.pdf', '2025-12-12 18:48:41', '2025-12-12 18:48:41'),
(121, 24, 2, 1.5600, NULL, 'hasil_uji/Xjlzxq56uLfwt5aZfo2QTDzULKhFeGomFhPN1Pfu.pdf', '2025-12-12 18:48:43', '2025-12-12 18:48:43'),
(122, 24, 3, 5.8000, NULL, 'hasil_uji/Xjlzxq56uLfwt5aZfo2QTDzULKhFeGomFhPN1Pfu.pdf', '2025-12-12 18:48:43', '2025-12-12 18:48:43'),
(123, 24, 4, 0.0160, NULL, 'hasil_uji/Xjlzxq56uLfwt5aZfo2QTDzULKhFeGomFhPN1Pfu.pdf', '2025-12-12 18:48:43', '2025-12-12 18:48:43'),
(124, 24, 5, 0.0050, NULL, 'hasil_uji/Xjlzxq56uLfwt5aZfo2QTDzULKhFeGomFhPN1Pfu.pdf', '2025-12-12 18:48:43', '2025-12-12 18:48:43'),
(125, 25, 1, 16.5600, NULL, 'hasil_uji/XFV2ay3XQSIL3ozcgrlnsthBXUreB8jqZYoHXegs.pdf', '2025-12-12 18:57:13', '2025-12-12 18:57:13'),
(126, 25, 2, 1.2100, NULL, 'hasil_uji/XFV2ay3XQSIL3ozcgrlnsthBXUreB8jqZYoHXegs.pdf', '2025-12-12 18:57:15', '2025-12-12 18:57:15'),
(127, 25, 3, 5.6000, NULL, 'hasil_uji/XFV2ay3XQSIL3ozcgrlnsthBXUreB8jqZYoHXegs.pdf', '2025-12-12 18:57:15', '2025-12-12 18:57:15'),
(128, 25, 4, 0.0160, NULL, 'hasil_uji/XFV2ay3XQSIL3ozcgrlnsthBXUreB8jqZYoHXegs.pdf', '2025-12-12 18:57:15', '2025-12-12 18:57:15'),
(129, 25, 5, 0.0050, NULL, 'hasil_uji/XFV2ay3XQSIL3ozcgrlnsthBXUreB8jqZYoHXegs.pdf', '2025-12-12 18:57:15', '2025-12-12 18:57:15'),
(130, 26, 1, 17.4100, NULL, 'hasil_uji/eUTQJkZgm7G7cuiFzBKDdc2PlUpaJjo5HFPgTEbz.pdf', '2025-12-12 18:58:30', '2025-12-12 18:58:30'),
(131, 26, 2, 1.3300, NULL, 'hasil_uji/eUTQJkZgm7G7cuiFzBKDdc2PlUpaJjo5HFPgTEbz.pdf', '2025-12-12 18:58:32', '2025-12-12 18:58:32'),
(132, 26, 3, 5.7000, NULL, 'hasil_uji/eUTQJkZgm7G7cuiFzBKDdc2PlUpaJjo5HFPgTEbz.pdf', '2025-12-12 18:58:32', '2025-12-12 18:58:32'),
(133, 26, 4, 0.0160, NULL, 'hasil_uji/eUTQJkZgm7G7cuiFzBKDdc2PlUpaJjo5HFPgTEbz.pdf', '2025-12-12 18:58:32', '2025-12-12 18:58:32'),
(134, 26, 5, 0.0050, NULL, 'hasil_uji/eUTQJkZgm7G7cuiFzBKDdc2PlUpaJjo5HFPgTEbz.pdf', '2025-12-12 18:58:32', '2025-12-12 18:58:32'),
(135, 27, 1, 17.7000, NULL, 'hasil_uji/gxABQ0dtOpWhdanmq2ax58bnTs0dSYFv0B58QDM5.pdf', '2025-12-12 18:59:40', '2025-12-12 18:59:40'),
(136, 27, 2, 1.3700, NULL, 'hasil_uji/gxABQ0dtOpWhdanmq2ax58bnTs0dSYFv0B58QDM5.pdf', '2025-12-12 18:59:40', '2025-12-12 18:59:40'),
(137, 27, 3, 5.7000, NULL, 'hasil_uji/gxABQ0dtOpWhdanmq2ax58bnTs0dSYFv0B58QDM5.pdf', '2025-12-12 18:59:40', '2025-12-12 18:59:40'),
(138, 27, 4, 0.0160, NULL, 'hasil_uji/gxABQ0dtOpWhdanmq2ax58bnTs0dSYFv0B58QDM5.pdf', '2025-12-12 18:59:40', '2025-12-12 18:59:40'),
(139, 27, 5, 0.0050, NULL, 'hasil_uji/gxABQ0dtOpWhdanmq2ax58bnTs0dSYFv0B58QDM5.pdf', '2025-12-12 18:59:40', '2025-12-12 18:59:40'),
(140, 28, 1, 17.5800, NULL, 'hasil_uji/pIBM0zzHnAxeh09R3imgFezCUjlsAREOEsi490ww.pdf', '2025-12-12 19:00:37', '2025-12-12 19:00:37'),
(141, 28, 2, 1.6500, NULL, 'hasil_uji/pIBM0zzHnAxeh09R3imgFezCUjlsAREOEsi490ww.pdf', '2025-12-12 19:00:39', '2025-12-12 19:00:39'),
(142, 28, 3, 6.0000, NULL, 'hasil_uji/pIBM0zzHnAxeh09R3imgFezCUjlsAREOEsi490ww.pdf', '2025-12-12 19:00:39', '2025-12-12 19:00:39'),
(143, 28, 4, 0.0160, NULL, 'hasil_uji/pIBM0zzHnAxeh09R3imgFezCUjlsAREOEsi490ww.pdf', '2025-12-12 19:00:39', '2025-12-12 19:00:39'),
(144, 28, 5, 0.0050, NULL, 'hasil_uji/pIBM0zzHnAxeh09R3imgFezCUjlsAREOEsi490ww.pdf', '2025-12-12 19:00:39', '2025-12-12 19:00:39'),
(145, 29, 1, 17.5800, NULL, 'hasil_uji/8FwEJMQp9WMpW4YGDjldQ2Np83jOj36lWaAa1krf.pdf', '2025-12-12 19:10:11', '2025-12-12 19:10:11'),
(146, 29, 2, 1.3300, NULL, 'hasil_uji/8FwEJMQp9WMpW4YGDjldQ2Np83jOj36lWaAa1krf.pdf', '2025-12-12 19:10:11', '2025-12-12 19:10:11'),
(147, 29, 3, 5.6000, NULL, 'hasil_uji/8FwEJMQp9WMpW4YGDjldQ2Np83jOj36lWaAa1krf.pdf', '2025-12-12 19:10:11', '2025-12-12 19:10:11'),
(148, 29, 4, 0.0260, NULL, 'hasil_uji/8FwEJMQp9WMpW4YGDjldQ2Np83jOj36lWaAa1krf.pdf', '2025-12-12 19:10:11', '2025-12-12 19:10:11'),
(149, 29, 5, 0.0050, NULL, 'hasil_uji/8FwEJMQp9WMpW4YGDjldQ2Np83jOj36lWaAa1krf.pdf', '2025-12-12 19:10:11', '2025-12-12 19:10:11'),
(150, 30, 1, 16.7800, NULL, 'hasil_uji/bWtlKxMlgF6kHPIfZsxkbtLw5bTTdiygzFCqrFV8.pdf', '2025-12-13 19:31:36', '2025-12-13 19:31:36'),
(151, 30, 2, 1.1700, NULL, 'hasil_uji/bWtlKxMlgF6kHPIfZsxkbtLw5bTTdiygzFCqrFV8.pdf', '2025-12-13 19:31:36', '2025-12-13 19:31:36'),
(152, 30, 3, 4.7000, NULL, 'hasil_uji/bWtlKxMlgF6kHPIfZsxkbtLw5bTTdiygzFCqrFV8.pdf', '2025-12-13 19:31:36', '2025-12-13 19:31:36'),
(153, 30, 4, 0.0160, NULL, 'hasil_uji/bWtlKxMlgF6kHPIfZsxkbtLw5bTTdiygzFCqrFV8.pdf', '2025-12-13 19:31:36', '2025-12-13 19:31:36'),
(154, 30, 5, 0.0050, NULL, 'hasil_uji/bWtlKxMlgF6kHPIfZsxkbtLw5bTTdiygzFCqrFV8.pdf', '2025-12-13 19:31:36', '2025-12-13 19:31:36'),
(155, 31, 1, 17.8900, NULL, 'hasil_uji/Xwcq6AUayiiwouc0WHSHH6qP58x5qPKvPypDTPAL.pdf', '2025-12-13 19:33:43', '2025-12-13 19:33:43'),
(156, 31, 2, 0.8000, NULL, 'hasil_uji/Xwcq6AUayiiwouc0WHSHH6qP58x5qPKvPypDTPAL.pdf', '2025-12-13 19:33:43', '2025-12-13 19:33:43'),
(157, 31, 3, 5.3000, NULL, 'hasil_uji/Xwcq6AUayiiwouc0WHSHH6qP58x5qPKvPypDTPAL.pdf', '2025-12-13 19:33:43', '2025-12-13 19:33:43'),
(158, 31, 4, 0.0160, NULL, 'hasil_uji/Xwcq6AUayiiwouc0WHSHH6qP58x5qPKvPypDTPAL.pdf', '2025-12-13 19:33:43', '2025-12-13 19:33:43'),
(159, 31, 5, 0.0050, NULL, 'hasil_uji/Xwcq6AUayiiwouc0WHSHH6qP58x5qPKvPypDTPAL.pdf', '2025-12-13 19:33:43', '2025-12-13 19:33:43'),
(160, 32, 1, 18.8800, NULL, 'hasil_uji/0O5gjcvOzlsRbMVbMGugp0BZapO5egMLnwiGVa7W.pdf', '2025-12-13 19:35:29', '2025-12-13 19:35:29'),
(161, 32, 2, 0.9000, NULL, 'hasil_uji/0O5gjcvOzlsRbMVbMGugp0BZapO5egMLnwiGVa7W.pdf', '2025-12-13 19:35:31', '2025-12-13 19:35:31'),
(162, 32, 3, 5.6000, NULL, 'hasil_uji/0O5gjcvOzlsRbMVbMGugp0BZapO5egMLnwiGVa7W.pdf', '2025-12-13 19:35:31', '2025-12-13 19:35:31'),
(163, 32, 4, 0.0160, NULL, 'hasil_uji/0O5gjcvOzlsRbMVbMGugp0BZapO5egMLnwiGVa7W.pdf', '2025-12-13 19:35:31', '2025-12-13 19:35:31'),
(164, 32, 5, 0.0050, NULL, 'hasil_uji/0O5gjcvOzlsRbMVbMGugp0BZapO5egMLnwiGVa7W.pdf', '2025-12-13 19:35:31', '2025-12-13 19:35:31'),
(165, 33, 1, 16.7800, NULL, 'hasil_uji/VVkQ0ASUd777KxDQj0MQQGiEL6Rkadgmva5G6HaP.pdf', '2025-12-13 19:36:44', '2025-12-13 19:36:44'),
(166, 33, 2, 1.1500, NULL, 'hasil_uji/VVkQ0ASUd777KxDQj0MQQGiEL6Rkadgmva5G6HaP.pdf', '2025-12-13 19:36:44', '2025-12-13 19:36:44'),
(167, 33, 3, 5.3000, NULL, 'hasil_uji/VVkQ0ASUd777KxDQj0MQQGiEL6Rkadgmva5G6HaP.pdf', '2025-12-13 19:36:44', '2025-12-13 19:36:44'),
(168, 33, 4, 0.0160, NULL, 'hasil_uji/VVkQ0ASUd777KxDQj0MQQGiEL6Rkadgmva5G6HaP.pdf', '2025-12-13 19:36:44', '2025-12-13 19:36:44'),
(169, 33, 5, 0.0050, NULL, 'hasil_uji/VVkQ0ASUd777KxDQj0MQQGiEL6Rkadgmva5G6HaP.pdf', '2025-12-13 19:36:44', '2025-12-13 19:36:44'),
(170, 34, 1, 30.3500, NULL, 'hasil_uji/kYCZpOVrafHOskDgORZkU9D8VThDgadoGwTZle0j.pdf', '2025-12-13 19:38:27', '2025-12-13 19:38:27'),
(171, 34, 2, 1.2800, NULL, 'hasil_uji/kYCZpOVrafHOskDgORZkU9D8VThDgadoGwTZle0j.pdf', '2025-12-13 19:38:27', '2025-12-13 19:38:27'),
(172, 34, 3, 5.3000, NULL, 'hasil_uji/kYCZpOVrafHOskDgORZkU9D8VThDgadoGwTZle0j.pdf', '2025-12-13 19:38:27', '2025-12-13 19:38:27'),
(173, 34, 4, 0.0160, NULL, 'hasil_uji/kYCZpOVrafHOskDgORZkU9D8VThDgadoGwTZle0j.pdf', '2025-12-13 19:38:27', '2025-12-13 19:38:27'),
(174, 34, 5, 0.0050, NULL, 'hasil_uji/kYCZpOVrafHOskDgORZkU9D8VThDgadoGwTZle0j.pdf', '2025-12-13 19:38:27', '2025-12-13 19:38:27'),
(175, 35, 1, 15.6700, NULL, 'hasil_uji/0C4BwVGS62pH0P2VXry1s1YyAzQurvoxK8CSKYXK.png', '2025-12-14 04:34:04', '2025-12-14 04:34:04'),
(176, 35, 2, 1.2500, NULL, 'hasil_uji/0C4BwVGS62pH0P2VXry1s1YyAzQurvoxK8CSKYXK.png', '2025-12-14 04:34:04', '2025-12-14 04:34:04'),
(177, 35, 3, 5.7000, NULL, 'hasil_uji/0C4BwVGS62pH0P2VXry1s1YyAzQurvoxK8CSKYXK.png', '2025-12-14 04:34:04', '2025-12-14 04:34:04'),
(178, 35, 4, 0.0160, NULL, 'hasil_uji/0C4BwVGS62pH0P2VXry1s1YyAzQurvoxK8CSKYXK.png', '2025-12-14 04:34:04', '2025-12-14 04:34:04'),
(179, 35, 5, 0.0050, NULL, 'hasil_uji/0C4BwVGS62pH0P2VXry1s1YyAzQurvoxK8CSKYXK.png', '2025-12-14 04:34:04', '2025-12-14 04:34:04'),
(180, 36, 1, 17.2400, NULL, 'hasil_uji/TNR0Ww0sMusZBcku0RHIRfVbWoReWgahRO5r0tUG.png', '2025-12-14 04:35:57', '2025-12-14 04:35:57'),
(181, 36, 2, 1.2400, NULL, 'hasil_uji/TNR0Ww0sMusZBcku0RHIRfVbWoReWgahRO5r0tUG.png', '2025-12-14 04:35:59', '2025-12-14 04:35:59'),
(182, 36, 3, 5.7000, NULL, 'hasil_uji/TNR0Ww0sMusZBcku0RHIRfVbWoReWgahRO5r0tUG.png', '2025-12-14 04:35:59', '2025-12-14 04:35:59'),
(183, 36, 4, 0.0160, NULL, 'hasil_uji/TNR0Ww0sMusZBcku0RHIRfVbWoReWgahRO5r0tUG.png', '2025-12-14 04:35:59', '2025-12-14 04:35:59'),
(184, 36, 5, 0.0050, NULL, 'hasil_uji/TNR0Ww0sMusZBcku0RHIRfVbWoReWgahRO5r0tUG.png', '2025-12-14 04:35:59', '2025-12-14 04:35:59'),
(185, 37, 1, 16.5600, NULL, 'hasil_uji/MpAqKlscmo5UrCBLThGkJrmCzZRQukCJg0kdRoMp.png', '2025-12-14 04:37:16', '2025-12-14 04:37:16'),
(186, 37, 2, 1.1400, NULL, 'hasil_uji/MpAqKlscmo5UrCBLThGkJrmCzZRQukCJg0kdRoMp.png', '2025-12-14 04:37:17', '2025-12-14 04:37:17'),
(187, 37, 3, 4.9600, NULL, 'hasil_uji/MpAqKlscmo5UrCBLThGkJrmCzZRQukCJg0kdRoMp.png', '2025-12-14 04:37:17', '2025-12-14 04:37:17'),
(188, 37, 4, 0.0160, NULL, 'hasil_uji/MpAqKlscmo5UrCBLThGkJrmCzZRQukCJg0kdRoMp.png', '2025-12-14 04:37:17', '2025-12-14 04:37:17'),
(189, 37, 5, 0.0050, NULL, 'hasil_uji/MpAqKlscmo5UrCBLThGkJrmCzZRQukCJg0kdRoMp.png', '2025-12-14 04:37:18', '2025-12-14 04:37:18'),
(190, 38, 1, 16.7800, NULL, 'hasil_uji/GuxmiAc923rGVlG8DUVJjUQkAkWg5azYKbK7Zwkj.png', '2025-12-14 04:39:02', '2025-12-14 04:39:02'),
(191, 38, 2, 1.3600, NULL, 'hasil_uji/GuxmiAc923rGVlG8DUVJjUQkAkWg5azYKbK7Zwkj.png', '2025-12-14 04:39:03', '2025-12-14 04:39:03'),
(192, 38, 3, 5.7800, NULL, 'hasil_uji/GuxmiAc923rGVlG8DUVJjUQkAkWg5azYKbK7Zwkj.png', '2025-12-14 04:39:03', '2025-12-14 04:39:03'),
(193, 38, 4, 0.0160, NULL, 'hasil_uji/GuxmiAc923rGVlG8DUVJjUQkAkWg5azYKbK7Zwkj.png', '2025-12-14 04:39:03', '2025-12-14 04:39:03'),
(194, 38, 5, 0.0050, NULL, 'hasil_uji/GuxmiAc923rGVlG8DUVJjUQkAkWg5azYKbK7Zwkj.png', '2025-12-14 04:39:03', '2025-12-14 04:39:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `indikator_uji`
--

CREATE TABLE `indikator_uji` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_indikator` varchar(20) NOT NULL,
  `nama_indikator` varchar(100) NOT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `baku_mutu` decimal(10,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `indikator_uji`
--

INSERT INTO `indikator_uji` (`id`, `kode_indikator`, `nama_indikator`, `satuan`, `baku_mutu`, `created_at`, `updated_at`) VALUES
(1, 'IU-0001', 'Total Susppended Solid', 'mg/L', 20.0000, '2025-11-15 03:29:28', '2025-11-26 22:40:01'),
(2, 'IU-0002', 'Minyak Lemak', 'mg/L', 1.0000, '2025-11-16 18:35:51', '2025-11-26 23:15:15'),
(3, 'IU-0003', 'Dissolved Oxygen', 'mg/L', 5.0000, '2025-11-26 22:41:05', '2025-11-26 22:41:05'),
(4, 'IU-0004', 'Amonia Total', 'mg/L', 0.3000, '2025-11-26 22:42:07', '2025-11-26 23:21:34'),
(5, 'IU-0005', 'Ortofosfat', 'mg/L', 0.0150, '2025-11-26 22:55:09', '2025-11-26 22:57:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id` bigint UNSIGNED NOT NULL,
  `judul_laporan` varchar(150) NOT NULL,
  `tahun_laporan` year NOT NULL,
  `jenis_laporan` enum('tahunan','perlokasi','rekap indikator','perpetugas') NOT NULL,
  `dibuat_oleh` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `longtitude` decimal(10,6) DEFAULT NULL,
  `peruntukan` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `lokasi`
--

INSERT INTO `lokasi` (`id`, `kode_lokasi`, `nama_lokasi`, `alamat_lokasi`, `provinsi`, `latitude`, `longtitude`, `peruntukan`, `created_at`, `updated_at`) VALUES
(4, 'T1-KS-01-008', 'Kalsel22', 'Pantai Tanjung Dewa-Muara Batakan', 'Kalimantan Selatan', -4.071600, 114.611760, 'Biota Laut', '2025-11-26 21:26:40', '2025-11-26 21:26:40'),
(5, 'T1-KS-01-007', 'Kalsel21', 'Pantai Tanjung Dewa', 'Kalimantan Selatan', -4.061110, 114.614330, 'Biota Laut', '2025-11-26 21:28:09', '2025-11-26 21:28:09'),
(6, 'T1-KS-01-006', 'Kalsel20', 'Pantai Takisung 2', 'Kalimantan Selatan', -3.875600, 114.614330, 'Biota Laut', '2025-11-26 21:29:27', '2025-11-26 21:29:27'),
(7, 'T1-KS-01-005', 'Kalsel19', 'Pantai Takisung 1', 'Kalimantan Selatan', -3.859420, 114.600347, 'Biota Laut', '2025-11-26 21:30:36', '2025-11-26 21:30:48'),
(8, 'T1-KS-04-003', 'Kalsel09', 'Muara Sungai Barito (Barat)', 'Kalimantan Selatan', -3.502250, 114.425028, 'Biota Laut', '2025-11-26 22:28:04', '2025-11-26 22:28:04'),
(9, 'T1-KS-04-002', 'Kalsel08', 'Sungai Rangit', 'Kalimantan Selatan', -3.514972, 114.463278, 'Biota Laut', '2025-11-26 22:29:43', '2025-11-26 22:29:43'),
(10, 'T1-KS-01-003', 'Kalsel04', 'Muara Sungai Barito 1', 'Kalimantan Selatan', -3.569417, 114.505167, 'Biota Laut', '2025-11-26 22:31:37', '2025-11-26 22:31:37'),
(11, 'T1-KS-01-002', 'Kalsel03', 'Pelaihari', 'Kalimantan Selatan', -3.628889, 114.504917, 'Biota Laut', '2025-11-26 22:32:50', '2025-11-26 22:32:50'),
(12, 'T1-KS-01-001', 'Kalsel02', 'Tabiano', 'Kalimantan Selatan', -3.687222, 114.491194, 'Biota Laut', '2025-11-26 22:35:12', '2025-11-26 22:35:12'),
(13, 'T1-KS-04-001', 'Kalsel01', 'Muara Tabanio (Kontrol)', 'Kalimantan Selatan', -3.635170, 114.324530, 'Biota Laut', '2025-12-11 04:28:12', '2025-12-11 04:28:12'),
(14, 'T1-KS-03-001', 'Kalsel05', 'Muara Sungai Barito 2', 'Kalimantan Selatan', -3.548000, 114.507028, 'Biota Laut', '2025-12-11 04:29:29', '2025-12-11 04:29:29'),
(15, 'T1-KS-03-002', 'Kalsel06', 'Pantai Sungai Musang', 'Kalimantan Selatan', -3.545194, 114.510444, 'Biota Laut', '2025-12-11 04:32:36', '2025-12-11 04:32:36'),
(16, 'T1-KS-03-003', 'Kalsel07', 'Tengah Muara Barito', 'Kalimantan Selatan', -3.533833, 114.492667, 'Biota Laut', '2025-12-11 04:33:52', '2025-12-11 04:33:52'),
(17, 'T1-KS-01-004', 'Kalsel10', 'Muara Sungai Musang', 'Kalimantan Selatan', -3.591417, 114.507972, 'Biota Laut', '2025-12-11 04:35:23', '2025-12-11 04:35:23'),
(18, 'T1-KS-02-001', 'Kalsel11', 'Siring Laut-1', 'Kalimantan Selatan', -3.234370, 116.228920, 'Biota Laut', '2025-12-11 04:37:01', '2025-12-11 04:37:01'),
(19, 'T1-KS-02-002', 'Kalsel12', 'Siring Laut-2', 'Kalimantan Selatan', -3.229540, 116.216120, 'Biota Laut', '2025-12-11 04:38:12', '2025-12-11 04:38:12'),
(20, 'T1-KS-02-003', 'Kalsel13', 'Area Pabrik Mesaya', 'Kalimantan Selatan', -3.234880, 116.195300, 'Biota Laut', '2025-12-11 04:39:22', '2025-12-11 04:39:22'),
(21, 'T1-KS-02-004', 'Kalsel14', 'Pertamina TBBM Kotabaru', 'Kalimantan Selatan', -3.245720, 116.195300, 'Pelabuhan', '2025-12-11 04:40:34', '2025-12-11 04:40:34'),
(22, 'T1-KS-02-005', 'Kalsel15', 'Pelabuhan Pelindo Kota Baru', 'Kalimantan Selatan', -3.291080, 116.147250, 'Pelabuhan', '2025-12-11 04:41:39', '2025-12-11 04:41:39'),
(23, 'T1-KS-10-001', 'Kalsel16', 'Perairan Batulicin 1 (Multi Trading Pratama)', 'Kalimantan Selatan', -3.455200, 116.015690, 'Pelabuhan', '2025-12-11 04:43:25', '2025-12-11 04:43:25'),
(24, 'T1-KS-10-002', 'Kalsel17', 'Perairan Batulicin 2', 'Kalimantan Selatan', -3.440340, 116.013720, 'Biota Laut', '2025-12-11 04:44:31', '2025-12-11 04:44:31'),
(25, 'T1-KS-10-003', 'Kalsel18', 'Perairan Batulicin 3 (Pelabuhan Tanbu)', 'Kalimantan Selatan', -3.430590, 116.016730, 'Pelabuhan', '2025-12-11 04:46:05', '2025-12-11 04:46:05'),
(26, 'T1-KS-01-009', 'Kalsel23', 'Pantai Batakan', 'Kalimantan Selatan', -4.092820, 114.613460, 'Biota Laut', '2025-12-11 04:47:32', '2025-12-11 04:47:32');

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
(20, 13, 25, '2025-04-01', '2025', '1', 'ADA SHU', '2025-12-12 18:29:22', '2025-12-12 18:30:33'),
(21, 12, 25, '2025-04-01', '2025', '1', 'ADA SHU', '2025-12-12 18:29:43', '2025-12-12 18:30:18'),
(22, 11, 25, '2025-04-01', '2025', '1', 'ADA SHU', '2025-12-12 18:30:55', '2025-12-12 18:31:07'),
(23, 10, 25, '2025-04-01', '2025', '1', 'ADA SHU', '2025-12-12 18:31:33', '2025-12-12 18:31:33'),
(24, 14, 25, '2025-04-01', '2025', '1', 'ADA SHU', '2025-12-12 18:31:51', '2025-12-12 18:31:51'),
(25, 15, 26, '2025-04-01', '2025', '1', 'ADA SHU', '2025-12-12 18:53:31', '2025-12-12 18:55:12'),
(26, 16, 26, '2025-04-01', '2025', '1', 'ADA SHU', '2025-12-12 18:53:57', '2025-12-12 18:55:01'),
(27, 9, 26, '2025-04-01', '2025', '1', 'ADA SHU', '2025-12-12 18:54:17', '2025-12-12 18:54:17'),
(28, 8, 26, '2025-04-01', '2025', '1', 'ADA SHU', '2025-12-12 18:55:29', '2025-12-12 18:55:29'),
(29, 17, 26, '2025-04-01', '2025', '1', 'ADA SHU', '2025-12-12 18:55:52', '2025-12-12 18:55:52'),
(30, 13, 25, '2025-12-01', '2025', '2', 'ADA SHU', '2025-12-13 19:09:55', '2025-12-13 19:09:55'),
(31, 12, 25, '2025-12-01', '2025', '2', 'ADA SHU', '2025-12-13 19:10:06', '2025-12-13 19:10:06'),
(32, 11, 25, '2025-12-01', '2025', '2', 'ADA SHU', '2025-12-13 19:10:16', '2025-12-13 19:10:16'),
(33, 10, 25, '2025-12-01', '2025', '2', 'ADA SHU', '2025-12-13 19:10:25', '2025-12-13 19:10:25'),
(34, 14, 25, '2025-12-01', '2025', '2', 'ADA SHU', '2025-12-13 19:10:41', '2025-12-13 19:37:13'),
(35, 15, 26, '2025-12-01', '2025', '2', 'ADA SHU', '2025-12-14 04:30:33', '2025-12-14 04:30:33'),
(36, 16, 26, '2025-12-01', '2025', '2', 'ADA SHU', '2025-12-14 04:30:46', '2025-12-14 04:30:46'),
(37, 9, 26, '2025-12-01', '2025', '2', 'ADA SHU', '2025-12-14 04:31:06', '2025-12-14 04:31:06'),
(38, 8, 26, '2025-12-01', '2025', '2', 'ADA SHU', '2025-12-14 04:31:22', '2025-12-14 04:31:22'),
(39, 17, 26, '2025-12-01', '2025', '2', 'ADA SHU', '2025-12-14 04:31:38', '2025-12-14 04:31:38');

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
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`);

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
-- AUTO_INCREMENT untuk tabel `hasil_uji`
--
ALTER TABLE `hasil_uji`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT untuk tabel `indikator_uji`
--
ALTER TABLE `indikator_uji`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `observasi`
--
ALTER TABLE `observasi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

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
-- Ketidakleluasaan untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
