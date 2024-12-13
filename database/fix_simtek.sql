-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Des 2024 pada 01.31
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fix_simtek`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `nama_kategori`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, 'Sirup', 2, '2024-11-19 16:27:12', '2024-12-03 15:03:34'),
(3, 'Kapsul', 2, '2024-11-19 16:29:56', '2024-11-19 16:35:29'),
(6, 'Tablet', 1, '2024-12-03 14:57:02', '2024-12-03 15:03:01'),
(7, 'Salep', 0, '2024-12-03 14:57:15', '2024-12-03 14:57:15'),
(8, 'Alat Bedah', 2, '2024-12-03 15:01:40', '2024-12-03 15:05:44'),
(9, 'Alat Laboratorium', 2, '2024-12-03 15:01:48', '2024-12-03 15:06:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_dokter` varchar(255) NOT NULL,
  `spesialis` varchar(255) NOT NULL,
  `nomor_hp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `doctors`
--

INSERT INTO `doctors` (`id`, `nama_dokter`, `spesialis`, `nomor_hp`, `email`, `alamat`, `created_at`, `updated_at`) VALUES
(4, 'Jein', 'UMUM', '08123456789', 'dokter@gmail.com', 'abcbdhfifwghiiiiiiiiii', '2024-11-28 03:03:08', '2024-11-28 04:01:03'),
(5, 'Hardi', 'UMUM', '089287654352', 'dokter3@gmail.com', 'abchefgyre', '2024-11-28 03:10:54', '2024-11-28 03:10:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_karyawan` varchar(255) NOT NULL,
  `posisi` varchar(255) NOT NULL,
  `umur` int(11) NOT NULL,
  `nomor_hp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `employees`
--

INSERT INTO `employees` (`id`, `nama_karyawan`, `posisi`, `umur`, `nomor_hp`, `email`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'Oji', 'ADMIN', 56, '081234567890', 'pemilik@gmail.com', 'abcjeicwe', '2024-11-19 16:43:13', '2024-11-28 00:15:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `medicines`
--

CREATE TABLE `medicines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_obat` varchar(255) NOT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `satuan_id` bigint(20) UNSIGNED NOT NULL,
  `stok` int(11) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `keterangan` text NOT NULL,
  `suplier_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kode_produk` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `medicines`
--

INSERT INTO `medicines` (`id`, `nama_obat`, `kategori_id`, `satuan_id`, `stok`, `harga`, `keterangan`, `suplier_id`, `created_at`, `updated_at`, `kode_produk`) VALUES
(1, 'Sanmol', 1, 4, 40, 50000, '-', 1, '2024-11-19 16:33:47', '2024-12-11 14:07:29', 'OBAT62A4D62'),
(2, 'Mixagrip', 3, 5, 50, 5000, '-', 2, '2024-11-19 16:34:58', '2024-12-11 14:10:13', 'OBAT1AA24F9'),
(3, 'Redoxon', 3, 4, 30, 35000, '-', 2, '2024-11-19 16:35:29', '2024-12-11 14:04:52', 'OBATED51F4E'),
(6, 'Imboost', 6, 4, 30, 75000, 'tidak ada', 3, '2024-12-03 15:03:01', '2024-12-11 14:06:40', 'OBAT2F58ABC'),
(7, 'Hufagrip', 1, 4, 30, 35000, 'tidak ada', 3, '2024-12-03 15:03:34', '2024-12-11 14:09:47', 'OBAT3F76E1B');

-- --------------------------------------------------------

--
-- Struktur dari tabel `medicine_devices`
--

CREATE TABLE `medicine_devices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_produk` varchar(255) NOT NULL,
  `nama_alatkesehatan` varchar(255) NOT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `satuan_id` bigint(20) UNSIGNED NOT NULL,
  `stok` int(11) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `keterangan` text NOT NULL,
  `suplier_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `medicine_devices`
--

INSERT INTO `medicine_devices` (`id`, `kode_produk`, `nama_alatkesehatan`, `kategori_id`, `satuan_id`, `stok`, `harga`, `keterangan`, `suplier_id`, `created_at`, `updated_at`) VALUES
(3, 'ALKESDDE4E02', 'Gunting Bedah', 8, 1, 30, 30000, 'tidak ada', 2, '2024-12-03 15:04:36', '2024-12-11 14:08:42'),
(4, 'ALKES1740C79', 'Pisau Bedah', 8, 1, 30, 35000, '-', 1, '2024-12-03 15:05:33', '2024-12-11 14:08:42'),
(6, 'ALKES0D4C893', 'Latex', 9, 2, 45, 150000, '-', 3, '2024-12-03 15:06:15', '2024-12-11 14:07:49'),
(7, 'ALKES4484123', 'Jarum Suntik', 9, 1, 30, 15000, '-', 3, '2024-12-03 15:06:55', '2024-12-11 14:02:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_10_25_065912_create_patients_table', 1),
(5, '2024_10_25_115014_create_doctors_table', 1),
(6, '2024_10_25_124934_create_employees_table', 1),
(7, '2024_10_25_132310_create_units_table', 1),
(8, '2024_10_25_135918_create_categories_table', 1),
(9, '2024_10_25_143057_create_suppliers_table', 1),
(10, '2024_10_25_153458_create_medicines_table', 1),
(11, '2024_10_27_060550_add_kode_produk_to_medicines_table', 1),
(12, '2024_10_27_063258_create_medicine_devices_table', 1),
(13, '2024_10_27_071441_create_transactions_table', 1),
(14, '2024_10_29_122913_add_tanggal_transaksi_to_transactions_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_pasien` varchar(255) NOT NULL,
  `umur` varchar(255) NOT NULL,
  `nomor_hp` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `patients`
--

INSERT INTO `patients` (`id`, `nama_pasien`, `umur`, `nomor_hp`, `alamat`, `created_at`, `updated_at`) VALUES
(2, 'Jein Ananda', '25', '0842462842864', 'abcjeicwefhijkklkfm', '2024-11-19 16:38:14', '2024-11-28 00:42:55'),
(5, 'Ogah', '50', '0812345678900', 'bwhdbwhd', '2024-11-27 22:30:01', '2024-11-27 22:30:01'),
(6, 'Fajrian', '20', '081234567890', 'abcbhfbewif', '2024-11-28 00:05:58', '2024-11-28 00:05:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('BK2N4adIDKvPmS4vs8AGx4U0Q87nYYSyZBV970Ma', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM042RkdXUENiTko1Z2IxcE9vc0pwd2lyQUd6SnFZTU9wZ1d0NTNIZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1733956496),
('tIESCwvXifmXUBHO02c9j7RtbU1UofZWfObhNzXX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiTEhRSm00ampiNkpPMFhJYzdYTmhNZVpINmNnSTNZWWFUQ2hTakFMMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=', 1734006461);

-- --------------------------------------------------------

--
-- Struktur dari tabel `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_suplier` varchar(255) NOT NULL,
  `nomor_hp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `suppliers`
--

INSERT INTO `suppliers` (`id`, `nama_suplier`, `nomor_hp`, `email`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'PT.HIJKLK', '081234567890', 'supplier@gmail.com', 'abcdefghijklkmdw', '2024-11-19 16:32:38', '2024-11-28 05:47:40'),
(2, 'PT.ABCXYZ', '08123456789', 'supplier2@gmail.com', 'hfdgfywfbjblaoef', '2024-11-19 16:32:53', '2024-11-28 05:51:24'),
(3, 'PT.MNOP', '081234567453', 'suplier3@gmail.com', 'abcdef', '2024-11-19 16:33:15', '2024-11-19 16:33:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaksi_id` varchar(250) NOT NULL,
  `medicine_id` bigint(20) UNSIGNED DEFAULT NULL,
  `medicinedevice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('buy','sale') NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `tanggal_transaksi` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `transaksi_id`, `medicine_id`, `medicinedevice_id`, `status`, `jumlah`, `total_harga`, `tanggal_transaksi`, `created_at`, `updated_at`) VALUES
(43, 'IDBBDA41495', 2, NULL, 'buy', 5, 25000.00, '2024-11-29', '2024-12-04 21:34:33', '2024-12-04 21:34:33'),
(44, 'ID367E4C079', NULL, 7, 'buy', 5, 75000.00, '2024-11-30', '2024-12-04 21:35:13', '2024-12-04 21:35:13'),
(45, 'IDB2216A4B2', 3, NULL, 'buy', 2, 70000.00, '2024-12-01', '2024-12-04 21:35:35', '2024-12-04 21:35:35'),
(46, 'IDF987CEA1A', NULL, 4, 'buy', 2, 70000.00, '2024-12-02', '2024-12-04 21:36:27', '2024-12-04 21:36:27'),
(47, 'IDFD3D70C24', 3, NULL, 'sale', 7, 245000.00, '2024-11-29', '2024-12-04 21:41:29', '2024-12-04 21:41:29'),
(48, 'IDEFA39141F', NULL, 4, 'sale', 3, 105000.00, '2024-11-30', '2024-12-04 21:41:59', '2024-12-04 21:41:59'),
(49, 'IDCDBD14A3C', NULL, 4, 'sale', 4, 140000.00, '2024-12-01', '2024-12-04 21:42:13', '2024-12-04 21:42:13'),
(50, 'ID76146785F', 6, NULL, 'sale', 5, 375000.00, '2024-12-02', '2024-12-04 21:42:50', '2024-12-04 21:42:50'),
(51, 'IDE5C4338D7', 3, NULL, 'buy', 5, 175000.00, '2024-12-03', '2024-12-04 21:53:35', '2024-12-04 21:53:35'),
(52, 'ID416036174', NULL, 7, 'buy', 5, 75000.00, '2024-12-03', '2024-12-04 21:53:35', '2024-12-04 21:53:35'),
(53, 'ID70523535D', 7, NULL, 'sale', 20, 700000.00, '2024-12-03', '2024-12-04 21:54:45', '2024-12-04 21:54:45'),
(54, 'ID6C71562C8', 2, NULL, 'buy', 15, 75000.00, '2024-01-05', '2024-12-04 21:56:35', '2024-12-04 21:56:35'),
(55, 'ID21D3F6DDB', 3, NULL, 'buy', 15, 525000.00, '2024-01-05', '2024-12-04 21:56:35', '2024-12-04 21:56:35'),
(56, 'IDB1E7DE731', 7, NULL, 'sale', 20, 700000.00, '2024-01-10', '2024-12-04 21:57:56', '2024-12-04 21:57:56'),
(57, 'IDA19CE4CCD', NULL, 6, 'sale', 5, 750000.00, '2024-01-10', '2024-12-04 21:57:56', '2024-12-04 21:57:56'),
(58, 'IDD62F65116', 7, NULL, 'buy', 30, 1050000.00, '2024-12-05', '2024-12-11 14:02:05', '2024-12-11 14:02:05'),
(59, 'ID044A9C812', 2, NULL, 'sale', 10, 50000.00, '2024-12-05', '2024-12-11 14:02:31', '2024-12-11 14:02:31'),
(60, 'IDEDE736AAC', NULL, 7, 'sale', 10, 150000.00, '2024-12-05', '2024-12-11 14:02:31', '2024-12-11 14:02:31'),
(61, 'IDF73E31DF2', 3, NULL, 'sale', 20, 700000.00, '2024-12-05', '2024-12-11 14:03:11', '2024-12-11 14:03:11'),
(62, 'ID7253DF2A5', NULL, 3, 'sale', 5, 150000.00, '2024-12-05', '2024-12-11 14:03:11', '2024-12-11 14:03:11'),
(63, 'IDEB149D04F', 3, NULL, 'sale', 10, 350000.00, '2024-12-11', '2024-12-11 14:03:37', '2024-12-11 14:03:37'),
(64, 'IDF55768B1A', 1, NULL, 'sale', 10, 500000.00, '2024-12-05', '2024-12-11 14:04:26', '2024-12-11 14:04:26'),
(65, 'IDB58BECA6A', 3, NULL, 'buy', 20, 700000.00, '2024-12-06', '2024-12-11 14:04:52', '2024-12-11 14:04:52'),
(66, 'IDC91E1325D', NULL, 6, 'sale', 15, 2250000.00, '2024-12-06', '2024-12-11 14:05:08', '2024-12-11 14:05:08'),
(67, 'IDA5D584393', 6, NULL, 'buy', 5, 375000.00, '2024-12-07', '2024-12-11 14:06:10', '2024-12-11 14:06:10'),
(68, 'ID40ADCCD66', NULL, 4, 'buy', 5, 175000.00, '2024-12-07', '2024-12-11 14:06:10', '2024-12-11 14:06:10'),
(69, 'ID2A150A643', 6, NULL, 'sale', 5, 375000.00, '2024-12-07', '2024-12-11 14:06:40', '2024-12-11 14:06:40'),
(70, 'ID509C78D6D', NULL, 6, 'sale', 5, 750000.00, '2024-12-07', '2024-12-11 14:06:40', '2024-12-11 14:06:40'),
(71, 'ID583979E84', 1, NULL, 'buy', 20, 1000000.00, '2024-12-08', '2024-12-11 14:07:29', '2024-12-11 14:07:29'),
(72, 'ID721948F0B', NULL, 6, 'sale', 10, 1500000.00, '2024-12-09', '2024-12-11 14:07:49', '2024-12-11 14:07:49'),
(73, 'ID6E59C73D8', 7, NULL, 'sale', 20, 700000.00, '2024-12-10', '2024-12-11 14:08:42', '2024-12-11 14:08:42'),
(74, 'ID88CED5462', NULL, 3, 'sale', 5, 150000.00, '2024-12-10', '2024-12-11 14:08:42', '2024-12-11 14:08:42'),
(75, 'ID543DDCC79', NULL, 4, 'sale', 5, 175000.00, '2024-12-10', '2024-12-11 14:08:42', '2024-12-11 14:08:42'),
(76, 'IDB92EB2FFD', 7, NULL, 'buy', 10, 350000.00, '2024-12-11', '2024-12-11 14:09:20', '2024-12-11 14:09:20'),
(77, 'ID794B53EFA', 7, NULL, 'buy', 10, 350000.00, '2024-12-11', '2024-12-11 14:09:47', '2024-12-11 14:09:47'),
(78, 'ID483424D22', 2, NULL, 'buy', 20, 100000.00, '2024-12-10', '2024-12-11 14:10:13', '2024-12-11 14:10:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_satuan` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `units`
--

INSERT INTO `units` (`id`, `nama_satuan`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, 'Pcs', 3, '2024-11-19 16:30:07', '2024-12-03 15:06:55'),
(2, 'Boxs', 1, '2024-11-19 16:30:35', '2024-11-19 16:37:01'),
(3, 'Set', 0, '2024-11-19 16:30:44', '2024-11-28 04:53:00'),
(4, 'Botol', 4, '2024-11-19 16:30:56', '2024-12-03 15:03:34'),
(5, 'Strip', 3, '2024-11-19 16:34:24', '2024-11-28 06:37:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$O5qFXJKnElJJ4fUU005bDO9GYQYFOihimxCxqNeQC1qT38YEnRd1O', NULL, '2024-11-01 19:55:44', '2024-12-05 21:26:48'),
(2, 'Taufik', 'admin2@gmail.com', NULL, '$2y$12$H2XEL9d9uQPi3QZbhEEwCuU6fNBIoGz6jN6rIWS/4ks/SiOB8h5vC', NULL, '2024-11-19 17:58:03', '2024-11-19 17:58:03'),
(3, 'Risa', 'adminrisa@gmail.com', NULL, '$2y$12$QIriNF8aoHBk/LgXQsg8jukcveXlAusSb7DyzoJwe8RC2pByrCtxW', NULL, '2024-11-28 21:39:02', '2024-11-28 21:39:02'),
(4, 'Taufik Ilham', 'admin123@gmail.com', NULL, '$2y$12$vC3gqvF9vxlq4BD26bSuCOg/K2MRv/jfUgSK3/d9yovG8zBVG9gOG', NULL, '2024-12-05 21:37:44', '2024-12-05 22:36:42');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doctors_email_unique` (`email`);

--
-- Indeks untuk tabel `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_email_unique` (`email`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `medicines_kode_produk_unique` (`kode_produk`),
  ADD KEY `medicines_kategori_id_foreign` (`kategori_id`),
  ADD KEY `medicines_satuan_id_foreign` (`satuan_id`),
  ADD KEY `medicines_suplier_id_foreign` (`suplier_id`);

--
-- Indeks untuk tabel `medicine_devices`
--
ALTER TABLE `medicine_devices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `medicine_devices_kode_produk_unique` (`kode_produk`),
  ADD KEY `medicine_devices_kategori_id_foreign` (`kategori_id`),
  ADD KEY `medicine_devices_satuan_id_foreign` (`satuan_id`),
  ADD KEY `medicine_devices_suplier_id_foreign` (`suplier_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_email_unique` (`email`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_medicine_id_foreign` (`medicine_id`),
  ADD KEY `transactions_medicinedevice_id_foreign` (`medicinedevice_id`);

--
-- Indeks untuk tabel `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `medicine_devices`
--
ALTER TABLE `medicine_devices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT untuk tabel `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `medicines`
--
ALTER TABLE `medicines`
  ADD CONSTRAINT `medicines_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medicines_satuan_id_foreign` FOREIGN KEY (`satuan_id`) REFERENCES `units` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medicines_suplier_id_foreign` FOREIGN KEY (`suplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `medicine_devices`
--
ALTER TABLE `medicine_devices`
  ADD CONSTRAINT `medicine_devices_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medicine_devices_satuan_id_foreign` FOREIGN KEY (`satuan_id`) REFERENCES `units` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medicine_devices_suplier_id_foreign` FOREIGN KEY (`suplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_medicinedevice_id_foreign` FOREIGN KEY (`medicinedevice_id`) REFERENCES `medicine_devices` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
