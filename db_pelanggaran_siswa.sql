-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Nov 2025 pada 10.34
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
-- Database: `db_pelanggaran_siswa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bimbingan_konseling`
--

CREATE TABLE `bimbingan_konseling` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `jenis_layanan` varchar(100) NOT NULL,
  `topik` varchar(255) NOT NULL,
  `tindakan_solusi` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `tanggal_konseling` date NOT NULL,
  `tanggal_tindak_lanjut` date DEFAULT NULL,
  `hasil_evaluasi` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bimbingan_konseling`
--

INSERT INTO `bimbingan_konseling` (`id`, `siswa_id`, `tahun_ajaran_id`, `user_id`, `jenis_layanan`, `topik`, `tindakan_solusi`, `status`, `tanggal_konseling`, `tanggal_tindak_lanjut`, `hasil_evaluasi`, `created_at`) VALUES
(2, 13, 4, 3, 'Konseling Individual', 'pelanggaran', 'qwdqwdqwdw', 'Selesai', '2025-11-19', NULL, 'wdwd', '2025-11-19 10:56:50'),
(3, 13, 4, 3, 'Konseling Individual', 'r33e3e', 'sadwd3d', 'Selesai', '2025-11-20', NULL, 'wdwdwd', '2025-11-20 09:01:35'),
(4, 18, 4, 3, 'Konseling Individual', 'Melanggar', 'Teguran Lisan', 'Selesai', '2025-11-20', NULL, NULL, '2025-11-20 11:23:00');

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
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `nama_guru` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `bidang_studi` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `status` enum('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_guru`, `jenis_kelamin`, `bidang_studi`, `email`, `no_telp`, `status`, `created_at`) VALUES
(3, 13, '000506', 'salma', 'Perempuan', 'Matematika', 'salma@gmail.com', '081234567893', 'Aktif', '2025-11-11 09:05:57'),
(4, 14, '0970780', 'hurip permana', 'Laki-laki', 'Rekayasa Perangkat Lunak', 'hurip@example.com', '0808085045', 'Aktif', '2025-11-11 21:17:21'),
(5, 15, '080808', 'asep ramdhani', 'Laki-laki', 'Rekayasa Perangkat Lunak', 'asep@gmail.com', '0887654321346', 'Aktif', '2025-11-13 14:32:32'),
(9, 18, '087654', 'anto purnomo', 'Laki-laki', 'pkn', 'anto@gmail.com', '0812345678943', 'Aktif', '2025-11-13 19:34:21'),
(10, 19, '0005067', 'Suhendar Ekaalwi', 'Laki-laki', 'Pendidikan Agama Islam', 'suhendar@gmail.com', '0812345678934', 'Aktif', '2025-11-13 20:34:11'),
(11, 20, '00050678', 'AJi Sukma', 'Laki-laki', 'Rekayasa Perangkat Lunak', 'aji@gmail.com', '0851474140912', 'Aktif', '2025-11-13 20:39:32'),
(12, 23, '0099876', 'Handi Radhiman', 'Laki-laki', 'Muatan Lokal', 'handi@gmail.com', '088609663', 'Aktif', '2025-11-18 13:32:28'),
(13, 24, '086556', 'Fazrin Taufan', 'Laki-laki', 'Matematika', 'fazrin@gmail.com', '086767321', 'Aktif', '2025-11-18 13:35:31'),
(14, 28, '087979', 'Saepudin', 'Laki-laki', 'Indonesia', 'sae@gmail.com', '08676667767', 'Aktif', '2025-11-18 15:01:13'),
(15, 30, '00998791', 'elin karlina', 'Perempuan', 'Fisika', 'elin@gmail.com', '08676667769', 'Aktif', '2025-11-20 08:06:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_pelanggaran`
--

CREATE TABLE `jenis_pelanggaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategori_pelanggaran_id` bigint(20) UNSIGNED NOT NULL,
  `nama_pelanggaran` varchar(255) NOT NULL,
  `poin` int(11) NOT NULL,
  `sanksi` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jenis_pelanggaran`
--

INSERT INTO `jenis_pelanggaran` (`id`, `kategori_pelanggaran_id`, `nama_pelanggaran`, `poin`, `sanksi`, `keterangan`, `created_at`, `updated_at`) VALUES
(2, 1, 'Membuat keributan / kegaduhan dalam kelas pada saat berlangsungnya pelajaran', 10, 'SP1', NULL, '2025-11-12 19:45:31', '2025-11-12 19:45:31'),
(3, 3, 'Masuk dan atau keluar lingkungan sekolah tidak melalui gerbang sekolah', 20, 'SP1', NULL, '2025-11-12 19:46:06', '2025-11-12 19:56:33'),
(4, 1, 'Berkata tidak jujur, tidak sopan/kasar', 10, 'SP1', NULL, '2025-11-12 19:46:43', '2025-11-12 19:46:43'),
(5, 1, 'Mengotori (misalnya: coret) barang milik sekolah, guru, karyawan atau teman', 10, 'SP1', NULL, '2025-11-12 19:47:30', '2025-11-12 19:47:30'),
(6, 1, 'Merusak atau menghilangkan barang milik sekolah, guru, karyawan atau teman', 25, 'SP1', NULL, '2025-11-12 19:48:06', '2025-11-12 19:48:06'),
(7, 1, 'Mengambil (mencuri) barang milik sekolah, guru, karyawan atau teman', 50, 'SP1', NULL, '2025-11-12 19:48:45', '2025-11-12 19:48:45'),
(8, 1, 'Makan dan minum di dalam kelas saat berlangsungnya pelajaran', 5, 'SP1', NULL, '2025-11-12 19:49:19', '2025-11-12 19:49:19'),
(9, 1, 'Mengaktifkan alat komunikasi didalam kelas pada saat pelajaran berlangsung', 5, 'SP1', NULL, '2025-11-12 19:49:48', '2025-11-12 19:49:48'),
(10, 1, 'Membuang sampah tidak pada tempatnya', 5, 'SP1', NULL, '2025-11-12 19:50:53', '2025-11-12 19:50:53'),
(11, 1, 'Membawa teman selain siswa SMK BN maupun dengan siswa sekolah lain atau pihak lain', 5, 'SP1', NULL, '2025-11-12 19:51:18', '2025-11-12 19:51:18'),
(12, 1, 'Membawa benda yang tidak ada kaitannya dengan proses belajar mengajar', 10, 'SP1', NULL, '2025-11-12 19:51:47', '2025-11-12 19:51:47'),
(13, 1, 'Bertengkar / bertentangan dengan teman di lingkungan sekolah', 15, 'SP1', NULL, '2025-11-12 19:52:17', '2025-11-12 19:52:17'),
(14, 1, 'Memalsu tandatangan guru, walikelas, kepala sekolah', 40, NULL, NULL, '2025-11-12 19:52:39', '2025-11-12 19:52:39'),
(15, 1, 'Menggunakan/menggelapkan SPP dari orang tua', 40, 'SP1', NULL, '2025-11-12 19:53:08', '2025-11-12 19:53:08'),
(16, 1, 'Membentuk organisasi selain OSIS maupun kegiatan lainnya tanpa seijin Kepala Sekolah', 15, 'SP1', NULL, '2025-11-12 19:53:32', '2025-11-12 19:53:32'),
(17, 1, 'Menyalahgunakan Uang SPP', 40, 'SP1', NULL, '2025-11-12 19:53:56', '2025-11-12 19:53:56'),
(18, 2, 'Membawa rokok', 25, 'SP1', NULL, '2025-11-12 19:54:25', '2025-11-12 19:54:25'),
(19, 2, 'Merokok / menghisap rokok di sekolah', 40, 'SP1', NULL, '2025-11-12 19:54:51', '2025-11-12 19:54:51'),
(20, 2, 'Merokok/ menghisap rokok di luar sekolah memakai seragam sekolah', 40, 'SP1', NULL, '2025-11-12 19:55:17', '2025-11-12 19:55:17'),
(21, 3, 'Membawa buku, majalah, kaset terlarang atau HP berisi gambar dan film porno', 25, 'SP1', NULL, '2025-11-12 19:55:46', '2025-11-12 19:56:49'),
(22, 3, 'Memperjual belikan buku, majalah atau kaset terlarang', 75, 'SP1', NULL, '2025-11-12 19:56:17', '2025-11-12 19:56:17'),
(23, 4, 'Membawa senjata tajam tanpa ijin', 40, 'SP1', NULL, '2025-11-12 19:57:27', '2025-11-12 19:57:27'),
(24, 4, 'Memperjual belikan senjata tajam di sekolah', 40, 'SP1', NULL, '2025-11-12 19:57:50', '2025-11-12 19:57:50'),
(25, 4, 'Menggunakan senjata tajam untuk mengancam', 75, 'SP1', NULL, '2025-11-12 19:58:12', '2025-11-12 19:58:12'),
(26, 4, 'Menggunakan senjata tajam untuk melukai', 75, 'SP3', NULL, '2025-11-12 19:59:17', '2025-11-17 23:49:11'),
(27, 5, 'Membawa obat terlarang / minuman terlarang', 75, NULL, NULL, NULL, NULL),
(28, 5, 'Menggunakan obat / minuman terlarang di dalam lingkungan sekolah', 100, NULL, NULL, NULL, NULL),
(29, 5, 'Memperjual belikan obat / minuman terlarang di dalam / di luar sekolah', 100, NULL, NULL, NULL, NULL),
(30, 6, 'Disebabkan oleh siswa di dalam sekolah (Intern)', 75, NULL, NULL, NULL, NULL),
(31, 6, 'Disebabkan oleh sekolah lain', 25, NULL, NULL, NULL, NULL),
(32, 6, 'Antar siswa SMK BN 666', 75, NULL, NULL, NULL, NULL),
(33, 7, 'Disertai ancaman', 75, NULL, NULL, NULL, NULL),
(34, 7, 'Disertai pemukulan', 100, NULL, NULL, NULL, NULL),
(35, 8, 'Terlambat masuk sekolah lebih dari 15 menit - Satu kali', 2, NULL, NULL, NULL, NULL),
(36, 8, 'Terlambat masuk sekolah lebih dari 15 menit - Dua kali', 3, NULL, NULL, NULL, NULL),
(37, 8, 'Terlambat masuk sekolah lebih dari 15 menit - Tiga kali dan selebihnya', 5, NULL, NULL, NULL, NULL),
(38, 8, 'Terlambat masuk karena izin', 3, NULL, NULL, NULL, NULL),
(39, 8, 'Terlambat masuk karena diberi tugas guru', 2, NULL, NULL, NULL, NULL),
(40, 8, 'Terlambat masuk karena alasan yang dibuat-buat', 5, NULL, NULL, NULL, NULL),
(41, 8, 'Izin keluar saat proses belajar berlangsung dan tidak kembali', 10, NULL, NULL, NULL, NULL),
(42, 8, 'Pulang tanpa izin', 10, NULL, NULL, NULL, NULL),
(43, 9, 'Siswa tidak masuk karena - Sakit tanpa keterangan (surat)', 2, NULL, NULL, NULL, NULL),
(44, 9, 'Siswa tidak masuk karena - Izin tanpa keterangan (surat)', 2, NULL, NULL, NULL, NULL),
(45, 9, 'Siswa tidak masuk karena - Alpa', 5, NULL, NULL, NULL, NULL),
(46, 9, 'Tidak mengikuti kegiatan belajar (membolos)', 10, NULL, NULL, NULL, NULL),
(47, 9, 'Siswa tidak masuk dengan membuat keterangan (surat)', 10, NULL, NULL, NULL, NULL),
(48, 9, 'Palsu', 10, NULL, NULL, NULL, NULL),
(49, 9, 'Siswa keluar kelas saat proses belajar mengajar berlangsung tanpa izin', 5, NULL, NULL, NULL, NULL),
(50, 10, 'Tidak memakai seragam tidak rapi / tidak dimasukkan', 5, NULL, NULL, NULL, NULL),
(51, 10, 'Siswa putri memakai seragam yang ketat / rok pendek', 5, NULL, NULL, NULL, NULL),
(52, 10, 'Tidak memakai perlengkapan upacara bendera (topi)', 5, NULL, NULL, NULL, NULL),
(53, 10, 'Salah memakai baju, rok atau celana', 5, NULL, NULL, NULL, NULL),
(54, 10, 'Salah atau tidak memakai ikat pinggang', 5, NULL, NULL, NULL, NULL),
(55, 10, 'Salah memakai sepatu (tidak sesuai ketentuan)', 5, NULL, NULL, NULL, NULL),
(56, 10, 'Tidak memakai kaos kaki', 5, NULL, NULL, NULL, NULL),
(57, 10, 'Salah / tidak memakai kaos dalam', 5, NULL, NULL, NULL, NULL),
(58, 10, 'Memakai topi yang bukan topi sekolah di lingkungan sekolah', 5, NULL, NULL, NULL, NULL),
(59, 10, 'Siswa putri memakai perhiasan perlebihan', 5, NULL, NULL, NULL, NULL),
(60, 10, 'Siswa putra memakai perhiasan atau aksesories (kalung, gelang, dll)', 5, NULL, NULL, NULL, NULL),
(61, 11, 'Potongan rambut putra tidak sesuai dengan ketentuan sekolah', 15, NULL, NULL, NULL, NULL),
(62, 11, 'Dicat / diwarna-warnai (putra-putri)', 15, NULL, NULL, NULL, NULL),
(63, 12, 'Bertato', 100, NULL, NULL, NULL, NULL),
(65, 6, 'dwadw', 232, 'Teguran Lisan', 'fefef', '2025-11-19 18:12:16', '2025-11-19 18:12:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_prestasi`
--

CREATE TABLE `jenis_prestasi` (
  `id` int(11) NOT NULL,
  `nama_prestasi` varchar(255) NOT NULL,
  `poin` int(11) NOT NULL DEFAULT 0,
  `kategori` enum('akademik','non_akademik') NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `reward` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jenis_prestasi`
--

INSERT INTO `jenis_prestasi` (`id`, `nama_prestasi`, `poin`, `kategori`, `deskripsi`, `reward`, `created_at`) VALUES
(1, 'Futsal', 60, 'akademik', 'drggd', 'dapet bala bala', '2025-11-08 12:42:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_sanksi`
--

CREATE TABLE `jenis_sanksi` (
  `id` int(11) NOT NULL,
  `nama_sanksi` varchar(255) NOT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jenis_sanksi`
--

INSERT INTO `jenis_sanksi` (`id`, `nama_sanksi`, `kategori`, `deskripsi`, `created_at`) VALUES
(1, 'SP1', 'SEDANG', 'Hati Hati kau', '2025-11-12 13:03:58'),
(2, 'Teguran Lisan', 'RINGAN', 'Masih DItoleransi', '2025-11-18 06:46:07'),
(3, 'SP2', 'SEDANG', 'Sudah ke tahap berbahaya', '2025-11-18 06:47:03'),
(4, 'SP3', 'BERAT', 'Siap-Siap akan segera dikeluarkan, jika melanggar lagi', '2025-11-18 06:47:18'),
(5, 'Out', 'BERAT', 'Maap saya harus mengeluarkan anda dari sekolah', '2025-11-18 06:48:17');

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
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id` int(11) NOT NULL,
  `nama_jurusan` varchar(100) NOT NULL,
  `singkatan` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id`, `nama_jurusan`, `singkatan`, `created_at`) VALUES
(1, 'Pengembangan Perangkat Lunak dan Gim 1', 'PPLG-1', '2025-11-11 22:13:21'),
(2, 'Akuntansi 1', 'AKT-1', '2025-11-11 22:13:21'),
(3, 'Desain Komunikasi Visual', 'DKV', '2025-11-11 22:13:21'),
(4, 'Animasi', 'ANM', '2025-11-11 22:13:21'),
(5, 'Bisnis dan Pemasaran', 'BDP', '2025-11-11 22:13:21'),
(6, 'Pengembangan Perangkat Lunak Dan Gim 2', 'PPLG-2', '2025-11-12 10:57:22'),
(7, 'Pengembangan Perangkat Lunak dan Gim 3', 'PPLG-3', '2025-11-13 14:47:18'),
(9, 'Akuntansi 2', 'AKT-2', '2025-11-20 08:04:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_pelanggaran`
--

CREATE TABLE `kategori_pelanggaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `kode_kategori` varchar(255) DEFAULT NULL,
  `kategori_induk` enum('KEPRIBADIAN','KERAJINAN','KERAPIAN') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategori_pelanggaran`
--

INSERT INTO `kategori_pelanggaran` (`id`, `nama_kategori`, `kode_kategori`, `kategori_induk`, `created_at`, `updated_at`) VALUES
(1, 'KETERTIBAN', 'KEP001', 'KEPRIBADIAN', '2025-11-12 04:02:37', '2025-11-12 19:39:18'),
(2, 'ROKOK', 'KEP002', 'KEPRIBADIAN', '2025-11-12 16:41:23', '2025-11-12 19:39:54'),
(3, 'BUKU, MAJALAH ATAU KASET TERLARANG', 'KEP003', 'KEPRIBADIAN', '2025-11-12 16:42:02', '2025-11-12 19:40:18'),
(4, 'SENJATA', 'KEP004', 'KEPRIBADIAN', '2025-11-12 16:42:23', '2025-11-12 19:40:30'),
(5, 'OBAT / MINUMAN TERLARANG', 'KEP005', 'KEPRIBADIAN', '2025-11-12 16:43:26', '2025-11-12 19:40:53'),
(6, 'PERKELAHIAN', 'KEP006', 'KEPRIBADIAN', '2025-11-12 16:43:48', '2025-11-12 19:41:11'),
(7, 'PELANGGARAN TERHADAP KEPALA SEKOLAH, GURU DAN KARYAWAN', 'KEP007', 'KEPRIBADIAN', '2025-11-12 19:41:37', '2025-11-12 19:41:37'),
(8, 'KETERLAMBATAN', 'KER008', 'KERAJINAN', '2025-11-12 19:42:38', '2025-11-12 19:42:38'),
(9, 'KEHADIRAN', 'KER009', 'KERAJINAN', '2025-11-12 19:43:02', '2025-11-12 19:43:02'),
(10, 'PAKAIAN', 'KER010', 'KERAPIAN', '2025-11-12 19:43:37', '2025-11-12 19:43:37'),
(11, 'RAMBUT', 'KER011', 'KERAPIAN', '2025-11-12 19:43:58', '2025-11-12 19:43:58'),
(12, 'BADAN', 'KER012', 'KERAPIAN', '2025-11-12 19:44:25', '2025-11-12 19:44:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `tingkat_kelas` enum('X','XI','XII') NOT NULL,
  `jurusan_id` int(11) NOT NULL,
  `kapasitas` int(11) NOT NULL DEFAULT 36,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id`, `tingkat_kelas`, `jurusan_id`, `kapasitas`, `created_at`) VALUES
(1, 'XII', 1, 30, '2025-11-19 08:47:36'),
(2, 'XII', 6, 29, '2025-11-19 08:47:46'),
(4, 'XII', 7, 26, '2025-11-19 08:48:09'),
(5, 'XII', 2, 30, '2025-11-19 08:48:20'),
(6, 'XII', 4, 16, '2025-11-19 08:48:37'),
(7, 'XII', 3, 30, '2025-11-19 08:48:52'),
(8, 'XII', 5, 10, '2025-11-19 08:49:14'),
(9, 'XII', 9, 28, '2025-11-20 08:05:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas_backup`
--

CREATE TABLE `kelas_backup` (
  `id` int(11) NOT NULL DEFAULT 0,
  `nama_kelas` varchar(50) NOT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas_backup`
--

INSERT INTO `kelas_backup` (`id`, `nama_kelas`, `jurusan`, `kapasitas`, `created_at`) VALUES
(1, 'X RPL 1', 'Rekayasa Perangkat Lunak', 36, '2025-11-06 16:24:18'),
(3, 'XI RPL 1', 'Rekayasa Perangkat Lunak', 36, '2025-11-06 16:24:18'),
(6, 'XII PPLG 2', 'Rekayasa Perangkat Lunak', 30, '2025-11-08 06:33:48');

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
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_11_06_095856_create_sessions_table', 2),
(4, '2025_11_10_121924_create_guru_table', 3),
(5, '2025_11_22_082907_modify_prestasi_table_guru_pencatat_nullable', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `monitoring_pelanggaran`
--

CREATE TABLE `monitoring_pelanggaran` (
  `id` int(11) NOT NULL,
  `pelanggaran_id` int(11) NOT NULL,
  `kepala_sekolah_id` int(11) DEFAULT NULL,
  `status_monitoring` varchar(50) DEFAULT NULL,
  `catatan_monitoring` varchar(255) DEFAULT NULL,
  `tanggal_monitoring` date NOT NULL,
  `tindak_lanjut` varchar(255) DEFAULT NULL,
  `hasil` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `orangtua`
--

CREATE TABLE `orangtua` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `siswa_id` int(11) NOT NULL,
  `hubungan` varchar(50) DEFAULT NULL,
  `pekerjaan` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orangtua`
--

INSERT INTO `orangtua` (`id`, `user_id`, `siswa_id`, `hubungan`, `pekerjaan`, `alamat`, `created_at`) VALUES
(5, 9, 13, 'Ayah', 'Karyawan Swasta', 'dsfsf', '2025-11-19 09:23:48'),
(6, 35, 18, 'Ayah', 'Karyawan Swasta', 'Taman CIleunyi', '2025-11-20 11:20:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelaksanaan_sanksi`
--

CREATE TABLE `pelaksanaan_sanksi` (
  `id` int(11) NOT NULL,
  `sanksi_id` int(11) NOT NULL,
  `tanggal_pelaksanaan` date NOT NULL,
  `bukti_pelaksanaan` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `status` enum('pending','selesai','dibatalkan') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelaksanaan_sanksi`
--

INSERT INTO `pelaksanaan_sanksi` (`id`, `sanksi_id`, `tanggal_pelaksanaan`, `bukti_pelaksanaan`, `catatan`, `status`, `created_at`) VALUES
(2, 7, '2024-11-19', 'pelaksanaan-sanksi/1763523279_WhatsApp Image 2025-10-02 at 09.05.10.jpeg', 'dsvsdv', 'selesai', '2025-11-19 03:33:40'),
(3, 8, '2025-11-20', 'pelaksanaan-sanksi/1763604034_WhatsApp Image 2025-10-02 at 09.05.10.jpeg', 'weewrr', 'pending', '2025-11-20 02:00:34'),
(4, 9, '2025-11-20', 'pelaksanaan-sanksi/1763607928_WhatsApp Image 2025-10-02 at 09.05.10.jpeg', 'efef', 'pending', '2025-11-20 03:05:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggaran`
--

CREATE TABLE `pelanggaran` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `jenis_pelanggaran_id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) NOT NULL,
  `poin` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `bukti_foto` varchar(255) DEFAULT NULL,
  `guru_pencatat` int(11) DEFAULT NULL,
  `guru_verifikator` int(11) DEFAULT NULL,
  `catatan_verifikasi` text DEFAULT NULL,
  `status_verifikasi` enum('pending','disetujui','ditolak') DEFAULT 'pending',
  `tanggal` date NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggaran`
--

INSERT INTO `pelanggaran` (`id`, `siswa_id`, `jenis_pelanggaran_id`, `tahun_ajaran_id`, `poin`, `keterangan`, `bukti_foto`, `guru_pencatat`, `guru_verifikator`, `catatan_verifikasi`, `status_verifikasi`, `tanggal`, `created_at`) VALUES
(42, 13, 15, 4, 40, 'ssac', 'pelanggaran/1763522562_WhatsApp Image 2025-10-02 at 09.05.10.jpeg', 5, NULL, NULL, 'disetujui', '2025-11-19', '2025-11-19 10:22:42'),
(43, 14, 4, 4, 10, 'scscs', 'pelanggaran/1763523072_WhatsApp Image 2025-08-06 at 07.54.20.jpeg', 3, 3, NULL, 'disetujui', '2025-11-19', '2025-11-19 10:31:12'),
(44, 13, 13, 4, 15, 'efewfef', 'pelanggaran/1763539272_WhatsApp Image 2025-08-06 at 07.54.20.jpeg', 3, 3, NULL, 'disetujui', '2025-11-19', '2025-11-19 15:01:13'),
(47, 14, 9, 4, 5, 'wwdw', 'pelanggaran/1763602466_WhatsApp Image 2025-08-06 at 07.54.20.jpeg', 5, NULL, NULL, 'disetujui', '2025-11-20', '2025-11-20 08:34:26'),
(48, 17, 60, 4, 5, 'werqee', 'pelanggaran/1763609986_WhatsApp Image 2025-08-06 at 07.54.20.jpeg', 3, 3, NULL, 'disetujui', '2025-11-20', '2025-11-20 10:39:46'),
(50, 16, 3, 4, 20, 'efefe', 'pelanggaran/1763610116_WhatsApp Image 2025-10-02 at 09.05.10.jpeg', 19, NULL, NULL, 'disetujui', '2025-11-20', '2025-11-20 10:41:56'),
(51, 17, 63, 4, 100, 'sswsqwq', 'pelanggaran/1763610146_WhatsApp Image 2025-08-06 at 07.54.20.jpeg', 19, NULL, NULL, 'disetujui', '2025-11-20', '2025-11-20 10:42:26'),
(52, 18, 17, 4, 40, 'wwewee', 'pelanggaran/1763612324_WhatsApp Image 2025-08-06 at 07.54.20.jpeg', 13, 13, NULL, 'disetujui', '2025-11-20', '2025-11-20 11:18:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `prestasi`
--

CREATE TABLE `prestasi` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `guru_pencatat` bigint(20) UNSIGNED DEFAULT NULL,
  `jenis_prestasi_id` int(11) NOT NULL,
  `tanggal_prestasi` date DEFAULT NULL,
  `tahun_ajaran_id` int(11) NOT NULL,
  `poin` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status_verifikasi` varchar(50) NOT NULL DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `prestasi`
--

INSERT INTO `prestasi` (`id`, `siswa_id`, `guru_pencatat`, `jenis_prestasi_id`, `tanggal_prestasi`, `tahun_ajaran_id`, `poin`, `keterangan`, `status_verifikasi`, `created_at`) VALUES
(2, 14, NULL, 1, NULL, 4, 60, 'rthrth', 'disetujui', '2025-11-22 15:30:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `prestasi_backup`
--

CREATE TABLE `prestasi_backup` (
  `id` int(11) NOT NULL DEFAULT 0,
  `siswa_id` int(11) NOT NULL,
  `jenis_prestasi_id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) NOT NULL,
  `poin` int(11) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tingkat` varchar(100) DEFAULT NULL,
  `penghargaan` varchar(255) DEFAULT NULL,
  `user_pencatat` int(11) DEFAULT NULL,
  `user_verifikator` int(11) DEFAULT NULL,
  `status_verifikasi` enum('pending','disetujui','ditolak') DEFAULT 'pending',
  `catatan_verifikasi` text DEFAULT NULL,
  `tanggal` datetime NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sanksi`
--

CREATE TABLE `sanksi` (
  `id` int(11) NOT NULL,
  `pelanggaran_id` int(11) NOT NULL,
  `jenis_sanksi` varchar(255) DEFAULT NULL,
  `deskripsi_sanksi` text DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status` enum('belum','proses','selesai') NOT NULL DEFAULT 'belum',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sanksi`
--

INSERT INTO `sanksi` (`id`, `pelanggaran_id`, `jenis_sanksi`, `deskripsi_sanksi`, `tanggal_mulai`, `tanggal_selesai`, `status`, `created_at`, `updated_at`) VALUES
(7, 42, 'SP1', 'axscs', '2025-01-19', NULL, 'selesai', '2025-11-18 20:33:20', '2025-11-19 01:06:04'),
(8, 44, 'Teguran Lisan', NULL, '2025-11-20', NULL, 'proses', '2025-11-19 19:00:10', '2025-11-19 19:00:10'),
(9, 43, 'SP1', 'wdwdw', '2025-11-20', NULL, 'proses', '2025-11-19 20:03:07', '2025-11-19 20:03:07');

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
('KpKn8tPSA7pehhQWTbtnqblSJuRPnrK4dgiCkOEd', 15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQXlBamUxTmVNS2Q3cTBkZURUWWJtRHRpeERrOEhac25tU0xFUkRzYyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ndXJ1L3BlbGFuZ2dhcmFuLzQ3Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTU7fQ==', 1763801412);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nis` varchar(20) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `agama` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `user_id`, `nis`, `nisn`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `alamat`, `no_telepon`, `kelas_id`, `foto`, `created_at`) VALUES
(13, 21, '232401', '2324170001', 'Bandung', '2007-01-01', 'L', 'Islam', 'asdfgh', '0858609661', 1, 'siswa/1763518898_1762693402_unnamed.png', '2025-11-19 09:21:38'),
(14, 22, '232402', '2324170002', 'Bandung', '2007-02-01', 'L', 'Kristen', 'dvsdvds', '0858609661', 2, 'siswa/1763518956_images.jpg', '2025-11-19 09:22:36'),
(15, 31, '232403', '2324170003', 'Bandung', '2008-01-08', 'L', 'Islam', 'Rancaekek', '0858609663', 1, 'siswa/1763606902_Screenshot 2025-11-14 134703.png', '2025-11-20 09:48:22'),
(16, 32, '23240', '232417000', 'Bandung', '2007-01-08', 'L', 'Islam', 'Cikadut', '085860968', 1, 'siswa/1763608018_Screenshot 2025-11-14 135023.png', '2025-11-20 10:06:58'),
(17, 33, '232404', '2324170004', 'Bandung', '2007-01-08', 'L', 'Kristen', 'Rancabatok', '081234567898', 1, 'siswa/1763609905_Screenshot 2025-11-14 133411.png', '2025-11-20 10:38:25'),
(18, 34, '232400987', '23241700067', 'Bandung', '2007-01-08', 'L', 'Islam', 'Rancakekek', '081234567898', 1, 'siswa/1763612211_Screenshot 2025-11-14 134947.png', '2025-11-20 11:16:51'),
(20, 25, '097y87567', '0077', 'm,m', '2007-12-07', 'P', 'Islam', 'nknk', '97897', 1, 'siswa/1763797419_Screenshot 2025-11-14 135124.png', '2025-11-20 22:21:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id` int(11) NOT NULL,
  `kode_tahun` varchar(20) NOT NULL,
  `tahun_ajaran` varchar(20) NOT NULL,
  `semester` enum('ganjil','genap') NOT NULL,
  `status_aktif` tinyint(1) DEFAULT 0,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id`, `kode_tahun`, `tahun_ajaran`, `semester`, `status_aktif`, `tanggal_mulai`, `tanggal_selesai`, `created_at`) VALUES
(4, '55666', '2025/2026', 'ganjil', 1, '2025-07-15', '2025-12-31', '2025-11-08 11:00:27'),
(5, '77777', '2025/2026', 'genap', 0, '2026-01-01', '2026-06-30', '2025-11-08 11:41:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `level` enum('admin','kepala_sekolah','kesiswaan','bk','guru','wali_kelas','orang_tua','siswa') NOT NULL DEFAULT 'guru',
  `can_verify` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `level`, `can_verify`, `is_active`, `last_login`, `created_at`) VALUES
(1, 'danis', '$2y$12$cvF9QXJ9jFrl0aWjhY0JsOeSYya.R33oiigJ/UO8I9UBAbevPmgYO', 'Deni Danis', 'kepala_sekolah', 0, 1, NULL, '2025-11-06 16:24:18'),
(2, 'dini', '$2y$12$tr26nFFKx3tN0RY7rjM81.ochCouBNhG02txwoLG.lardUF51idqu', 'Dini Susanti', 'kesiswaan', 1, 1, NULL, '2025-11-06 16:24:18'),
(3, 'ridwan', '$2y$12$isT/PX1Yr5DFU0KNJJ/hE.TSH8DmI9yt4Efkq.ZNcYEfIYvGwV0Q.', 'ridwan', 'bk', 0, 1, NULL, '2025-11-06 16:24:18'),
(5, 'ahmad', '$2y$12$e0aKOsmlGy.KIW1pD4bHdeJb5uLRLg0k7XflPXdlABtrnNH.9fjm2', 'Bapak Ahmad', 'orang_tua', 0, 1, NULL, '2025-11-06 16:24:18'),
(9, 'Iman', '$2y$12$HoAtPStMZIjAYg9IGHzi/OyNv63QIXjZE47I308PeIl.imTQHIVBq', 'Iman Sukiman', 'orang_tua', 0, 1, NULL, '2025-11-09 06:08:02'),
(11, 'admin', '$2y$12$j5.0A4blcW9psYRYSblncO.ymrcKZJ6lqXxixyRQNWGGjYkZWyLH.', 'Administrator Utama', 'admin', 1, 1, NULL, '2025-11-10 09:47:45'),
(13, 'salma', '$2y$12$WXyivJG02ByBTfrIy5wxNOJkicnWA7GUpmcA5R7xouYFSV2lZbCPq', 'salma', 'guru', 0, 1, NULL, '2025-11-11 06:47:31'),
(14, 'hurip', '$2y$12$Tt.kuuXj48PpEMTLe1Wf7eJSG/tMRu3rTSK0y60T0XtMV6jyR4I0C', 'hurip permana', 'guru', 0, 1, NULL, '2025-11-11 21:16:13'),
(15, 'asep', '$2y$12$iqPRObNroGVgPVVJAP.AIuAxz1rt4O.y9YBHg8ZyRELipCy5S6fg.', 'asep ramdhani', 'guru', 0, 1, NULL, '2025-11-13 14:28:53'),
(18, 'anto', '$2y$12$EZlRX2XyEVuYJOI.Zkw7meFLAVi9c.G81cNJflke/ZgGdkcVSJKyO', 'anto purnomo', 'guru', 0, 1, NULL, '2025-11-13 19:33:19'),
(19, 'suhendar', '$2y$12$QQlOFJifibY5vD310SFkYOqaIgCCPT9Sp2ci7LO.h4VQphwu0s35.', 'Suhendar Ekaalwi', 'wali_kelas', 0, 1, NULL, '2025-11-13 20:33:27'),
(20, 'aji', '$2y$12$SxZ.FGT73wGuSkuKZ4ac4OMnasfZvc3.HDgrZSfMFnudaV/nj2Vae', 'AJi Sukma', 'wali_kelas', 0, 1, NULL, '2025-11-13 20:38:54'),
(21, 'gathan', '$2y$12$9WBQTBKgX9AhBCtMLHTnmu282CGJKphEg4Y2bQI1/939oaf1ZT/uy', 'Muhammad Gathan Prayoga', 'siswa', 0, 1, NULL, '2025-11-14 16:23:25'),
(22, 'Prayogo', '$2y$12$Hy9untjVDGzI7X8wSfFsPOSQqhZXYHF/P0vl0cBLyrljlfV3GQPEm', 'Prayogo Putra', 'siswa', 0, 1, NULL, '2025-11-14 16:40:21'),
(23, 'handi', '$2y$12$33Zt.bYLNl8jSNgz7JnpaeHnlRMwjMLbLotxMXyJB9igyj1WelxDO', 'Handi Radhiman', 'wali_kelas', 0, 1, NULL, '2025-11-18 13:31:43'),
(24, 'fazrin', '$2y$12$SwGcWTHNTb5Rqc6SoeJVw.VBemiTb7HLr78m0QGO8wf1onnSVslF6', 'Fazrin Taufan', 'wali_kelas', 0, 1, NULL, '2025-11-18 13:33:34'),
(25, 'indah', '$2y$12$IHo1gw0lgBdLoh8GZAXGMueIu0t00a.uZd4UhIUvyegUnpYi9lEMG', 'Indah Permata', 'siswa', 0, 1, NULL, '2025-11-18 13:41:18'),
(26, 'rena', '$2y$12$Z8zz3cGXd6HGQV1VQpfmkexFZNbomdcCwhu1RFVrKbD2t.fAJ9UP.', 'Rena Ardelia', 'siswa', 0, 1, NULL, '2025-11-18 13:41:40'),
(27, 'ajeng', '$2y$12$Rw/L/Z5GiyfUWdvLwXSsU.DVD7gOegN5zpvI1gRRlmfWenGMt9qcO', 'Ajeng Kayla', 'siswa', 0, 1, NULL, '2025-11-18 13:42:03'),
(28, 'saepudin', '$2y$12$cOgNew3FEY2wK3MBx15BJ.FSqS4wBtL04Bw0r.jkqTWPX0ZYXRsVG', 'Saepudin', 'guru', 0, 1, NULL, '2025-11-18 15:00:27'),
(29, 'gatot', '$2y$12$QEkwQvgzPsInee3hBVV5zeW8gVizR3C5EGGT84x1vdui6kz0UZoIi', 'gatot taufik', 'kesiswaan', 0, 1, NULL, '2025-11-20 07:58:16'),
(30, 'elin', '$2y$12$6rgWKzpFjIjGIpgY.r7GIO.8vTIgILacqKpvw.4g.HXPG1ytcnJCq', 'elin karlina', 'guru', 0, 1, NULL, '2025-11-20 08:00:17'),
(31, 'dhimas', '$2y$12$96yN1uR6LokF1sRZLCIkU.ozhduEUBri4MBuZRYx0KFDqqD88QcQG', 'dhimas rakha catur', 'siswa', 0, 1, NULL, '2025-11-20 09:46:25'),
(32, 'alfaatih', '$2y$12$A5fXmUbh1rVW8l.3CoQzzum107R87EajNlRbhhfEzPsZ1y8primIS', 'alfaatih kamil mushtafa', 'siswa', 0, 1, NULL, '2025-11-20 09:46:52'),
(33, 'taufik', '$2y$12$nImRPUu.DCHAPYMpZvCnyeO1fwzAHjmv76c7S.Ri7JJCxF7myeZmq', 'Taufik Firmansyah', 'siswa', 0, 1, NULL, '2025-11-20 10:36:38'),
(34, 'fauzi', '$2y$12$XhMm9FAgofqXvTNsUXbk3.V6Z4PIHtUFKww63Y5B0d4Uf8jm49lAa', 'fauzi rafi', 'siswa', 0, 1, NULL, '2025-11-20 11:15:42'),
(35, 'yanto', '$2y$12$dQDUZlp89i.2JEbjrYhu0.E9gU4L2gfML.zwTX1jn/vTEL7lapLDa', 'yanto', 'orang_tua', 0, 1, NULL, '2025-11-20 11:20:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `verifikasi_data`
--

CREATE TABLE `verifikasi_data` (
  `id` int(11) NOT NULL,
  `tabel_terkait` varchar(50) NOT NULL COMMENT 'pelanggaran, prestasi, sanksi',
  `id_terkait` int(11) NOT NULL,
  `user_verifikator` int(11) DEFAULT NULL COMMENT 'User dengan role kesiswaan',
  `status` enum('pending','disetujui','ditolak') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabel untuk menyimpan data verifikasi oleh kesiswaan';

-- --------------------------------------------------------

--
-- Struktur dari tabel `wali_kelas`
--

CREATE TABLE `wali_kelas` (
  `id` int(11) NOT NULL,
  `guru_id` int(11) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `tahun_ajaran_id` int(11) NOT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `wali_kelas`
--

INSERT INTO `wali_kelas` (`id`, `guru_id`, `kelas_id`, `tahun_ajaran_id`, `tanggal_mulai`, `tanggal_selesai`, `catatan`, `created_at`) VALUES
(28, 19, 1, 4, '2023-01-01', NULL, 'fwefwf', '2025-11-19 09:06:01'),
(29, 20, 2, 4, '2023-01-01', NULL, 'scsd', '2025-11-19 09:26:11'),
(30, 23, 4, 4, '2023-01-01', NULL, 'dd', '2025-11-19 09:26:41'),
(31, 24, 7, 4, '2025-06-20', NULL, 'wefef', '2025-11-20 08:08:31');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bimbingan_konseling`
--
ALTER TABLE `bimbingan_konseling`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `user_id` (`user_id`);

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
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `jenis_pelanggaran`
--
ALTER TABLE `jenis_pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_jenis_pelanggaran_kategori` (`kategori_pelanggaran_id`);

--
-- Indeks untuk tabel `jenis_prestasi`
--
ALTER TABLE `jenis_prestasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jenis_sanksi`
--
ALTER TABLE `jenis_sanksi`
  ADD PRIMARY KEY (`id`);

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
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `singkatan` (`singkatan`);

--
-- Indeks untuk tabel `kategori_pelanggaran`
--
ALTER TABLE `kategori_pelanggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `monitoring_pelanggaran`
--
ALTER TABLE `monitoring_pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kepala_sekolah_id` (`kepala_sekolah_id`),
  ADD KEY `idx_monitoring_pelanggaran` (`pelanggaran_id`);

--
-- Indeks untuk tabel `orangtua`
--
ALTER TABLE `orangtua`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_orangtua_siswa` (`siswa_id`),
  ADD KEY `idx_orangtua_user` (`user_id`);

--
-- Indeks untuk tabel `pelaksanaan_sanksi`
--
ALTER TABLE `pelaksanaan_sanksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sanksi_id` (`sanksi_id`),
  ADD KEY `idx_tanggal` (`tanggal_pelaksanaan`),
  ADD KEY `idx_status` (`status`);

--
-- Indeks untuk tabel `pelanggaran`
--
ALTER TABLE `pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jenis_pelanggaran_id` (`jenis_pelanggaran_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `user_pencatat` (`guru_pencatat`),
  ADD KEY `user_verifikator` (`guru_verifikator`),
  ADD KEY `idx_pelanggaran_siswa` (`siswa_id`),
  ADD KEY `idx_pelanggaran_tanggal` (`tanggal`),
  ADD KEY `idx_pelanggaran_status` (`status_verifikasi`);

--
-- Indeks untuk tabel `prestasi`
--
ALTER TABLE `prestasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_siswa` (`siswa_id`),
  ADD KEY `fk_guru` (`guru_pencatat`),
  ADD KEY `fk_jenis_prestasi` (`jenis_prestasi_id`),
  ADD KEY `fk_tahun_ajaran` (`tahun_ajaran_id`);

--
-- Indeks untuk tabel `sanksi`
--
ALTER TABLE `sanksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggaran_id` (`pelanggaran_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD KEY `idx_siswa_nis` (`nis`),
  ADD KEY `idx_siswa_kelas` (`kelas_id`),
  ADD KEY `fk_siswa_user` (`user_id`);

--
-- Indeks untuk tabel `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_tahun` (`kode_tahun`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `verifikasi_data`
--
ALTER TABLE `verifikasi_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_tabel_id` (`tabel_terkait`,`id_terkait`),
  ADD KEY `idx_tabel_terkait` (`tabel_terkait`),
  ADD KEY `idx_id_terkait` (`id_terkait`),
  ADD KEY `idx_user_verifikator` (`user_verifikator`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indeks untuk tabel `wali_kelas`
--
ALTER TABLE `wali_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `fk_wali_kelas_guru` (`guru_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bimbingan_konseling`
--
ALTER TABLE `bimbingan_konseling`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `jenis_pelanggaran`
--
ALTER TABLE `jenis_pelanggaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT untuk tabel `jenis_prestasi`
--
ALTER TABLE `jenis_prestasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jenis_sanksi`
--
ALTER TABLE `jenis_sanksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `kategori_pelanggaran`
--
ALTER TABLE `kategori_pelanggaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `monitoring_pelanggaran`
--
ALTER TABLE `monitoring_pelanggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `orangtua`
--
ALTER TABLE `orangtua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pelaksanaan_sanksi`
--
ALTER TABLE `pelaksanaan_sanksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pelanggaran`
--
ALTER TABLE `pelanggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `prestasi`
--
ALTER TABLE `prestasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `sanksi`
--
ALTER TABLE `sanksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `verifikasi_data`
--
ALTER TABLE `verifikasi_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `wali_kelas`
--
ALTER TABLE `wali_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bimbingan_konseling`
--
ALTER TABLE `bimbingan_konseling`
  ADD CONSTRAINT `bimbingan_konseling_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bimbingan_konseling_ibfk_2` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bimbingan_konseling_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jenis_pelanggaran`
--
ALTER TABLE `jenis_pelanggaran`
  ADD CONSTRAINT `fk_jenis_pelanggaran_kategori` FOREIGN KEY (`kategori_pelanggaran_id`) REFERENCES `kategori_pelanggaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `monitoring_pelanggaran`
--
ALTER TABLE `monitoring_pelanggaran`
  ADD CONSTRAINT `monitoring_pelanggaran_ibfk_1` FOREIGN KEY (`pelanggaran_id`) REFERENCES `pelanggaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `monitoring_pelanggaran_ibfk_2` FOREIGN KEY (`kepala_sekolah_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `orangtua`
--
ALTER TABLE `orangtua`
  ADD CONSTRAINT `orangtua_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orangtua_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pelaksanaan_sanksi`
--
ALTER TABLE `pelaksanaan_sanksi`
  ADD CONSTRAINT `pelaksanaan_sanksi_ibfk_1` FOREIGN KEY (`sanksi_id`) REFERENCES `sanksi` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pelanggaran`
--
ALTER TABLE `pelanggaran`
  ADD CONSTRAINT `pelanggaran_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelanggaran_ibfk_3` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelanggaran_ibfk_4` FOREIGN KEY (`guru_pencatat`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pelanggaran_ibfk_5` FOREIGN KEY (`guru_verifikator`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `sanksi`
--
ALTER TABLE `sanksi`
  ADD CONSTRAINT `sanksi_ibfk_1` FOREIGN KEY (`pelanggaran_id`) REFERENCES `pelanggaran` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `fk_siswa_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`),
  ADD CONSTRAINT `fk_siswa_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `verifikasi_data`
--
ALTER TABLE `verifikasi_data`
  ADD CONSTRAINT `fk_verifikasi_user` FOREIGN KEY (`user_verifikator`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `wali_kelas`
--
ALTER TABLE `wali_kelas`
  ADD CONSTRAINT `fk_wali_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`),
  ADD CONSTRAINT `wali_kelas_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wali_kelas_ibfk_3` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
