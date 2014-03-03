-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Inang: localhost
-- Waktu pembuatan: 07 Des 2013 pada 05.01
-- Versi Server: 5.6.14-1+debphp.org~saucy+1-log
-- Versi PHP: 5.5.6-1+debphp.org~saucy+2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Basis data: `ci_baka`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `baka_auth_login_attempts`
--

DROP TABLE IF EXISTS `baka_auth_login_attempts`;
CREATE TABLE IF NOT EXISTS `baka_auth_login_attempts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `login` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `baka_auth_overrides`
--

DROP TABLE IF EXISTS `baka_auth_overrides`;
CREATE TABLE IF NOT EXISTS `baka_auth_overrides` (
  `user_id` int(10) unsigned NOT NULL,
  `permission_id` smallint(5) unsigned NOT NULL,
  `allow` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `user_id1_idx` (`user_id`),
  KEY `permissions_id1_idx` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `baka_auth_permissions`
--

DROP TABLE IF EXISTS `baka_auth_permissions`;
CREATE TABLE IF NOT EXISTS `baka_auth_permissions` (
  `permission_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `permission` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`permission_id`),
  UNIQUE KEY `permission_UNIQUE` (`permission`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `baka_auth_permissions`
--

INSERT INTO `baka_auth_permissions` (`parent`, `permission`, `description`, `status`) VALUES
('Dokumen', 'doc_manage', 'Mengelola Dokumen perijinan',1),
('Dokumen', 'doc_edit', 'Mengubah Dokumen perijinan yang sudah ada',1),
('Dokumen', 'doc_lokasi_manage', 'Mengelola Dokumen ijin Lokasi',1),
('Dokumen', 'doc_reklame_manage', 'Mengelola Dokumen ijin Reklame',1),
('Dokumen', 'doc_b3_manage', 'Mengelola Dokumen ijin B3',1),
('Dokumen', 'doc_ho_manage', 'Mengelola Dokumen ijin Ganggunan',1),
('Dokumen', 'doc_imb_manage', 'Mengelola Dokumen ijin Mendirikan bangunan',1),
('Dokumen', 'doc_iplc_manage', 'Mengelola Dokumen ijin Pembuangan Limbah',1),
('Dokumen', 'doc_iui_manage', 'Mengelola Dokumen ijin Usaha Industri',1),
('Dokumen', 'doc_iup_manage', 'Mengelola Dokumen ijin Usaha Pertambangan',1),
('Dokumen', 'doc_siup_manage', 'Mengelola Dokumen ijin Usaha Perdagangan',1),
('Dokumen', 'doc_tdp_manage', 'Mengelola Dokumen ijin TDP',1),
('Dokumen', 'doc_wisata_manage', 'Mengelola Dokumen ijin Pariwisata',1),
('Aplikasi', 'internal_skpd_manage', 'Mengelola pengaturan SKPD',1),
('Aplikasi', 'internal_application_manage', 'Mengelola pengaturan Aplikasi',1),
('Aplikasi', 'internal_security_manage', 'Mengelola pengaturan Keamanan',1),
('Pengguna', 'users_manage', 'Mengelola semua pengguna',1),
('Pengguna', 'users_add', 'Menambahkan pengguna',1),
('Pengguna', 'users_view', 'Melihat data pengguna',1),
('Pengguna', 'users_edit_self', 'Mengubah data pengguna',1),
('Pengguna', 'users_edit_other', 'Mengubah data pengguna lain',1),
('Pengguna', 'perms_manage', 'Mengelola wewenang pengguna',1),
('Pengguna', 'roles_manage', 'Mengelola Kelompok pengguna',1),
('System', 'sys_manage', 'Mengelola internal Sistem',1),
('System', 'sys_backstore_manage', 'Mengelola backup & restore sistem',1),
('System', 'sys_logs_manage', 'Memantau Aktifitas internal sistem',1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `baka_auth_roles`
--

DROP TABLE IF EXISTS `baka_auth_roles`;
CREATE TABLE IF NOT EXISTS `baka_auth_roles` (
  `role_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `full` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `desc` varchar(255) COLLATE utf8_unicode_ci default NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `can_delete` tinyint(1) NOT NULL DEFAULT '1',
  `actived` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_UNIQUE` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `baka_auth_roles`
--

INSERT INTO `baka_auth_roles` (`role`, `full`, `desc`, `default`, `can_delete`, `actived`) VALUES
('admin', 'Administrator', '-', 0, 1, 0),
('bag_1', 'Bagian 1', '-', 0, 1, 0),
('bag_2', 'Bagian 2', '-', 0, 1, 0),
('bag_3', 'Bagian 3', '-', 0, 1, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `baka_auth_role_permissions`
--

DROP TABLE IF EXISTS `baka_auth_role_permissions`;
CREATE TABLE IF NOT EXISTS `baka_auth_role_permissions` (
  `role_id` tinyint(3) unsigned NOT NULL,
  `permission_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `role_id2_idx` (`role_id`),
  KEY `permission_id2_idx` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `baka_auth_role_permissions`
--

INSERT INTO `baka_auth_role_permissions` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(2, 1),
(2, 10),
(2, 11),
(2, 12),
(3, 1),
(3, 6),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(4, 7),
(4, 8),
(4, 9);


-- --------------------------------------------------------

--
-- Struktur dari tabel `baka_auth_users`
--

DROP TABLE IF EXISTS `baka_auth_users`;
CREATE TABLE IF NOT EXISTS `baka_auth_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT 1,
  `banned` tinyint(1) NOT NULL DEFAULT 0,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `ban_reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` char(32) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_login` datetime DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `log` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `baka_auth_users`
--

INSERT INTO `baka_auth_users` (`username`, `password`, `email`, `activated`, `created`) VALUES
('admin', '$2a$08$LhuaYcUIVOy1tt7CJjyNh.2ECzQcJoeW44d/DSNVRUoFNriUtAyse', 'administrator@bpmppt.com', 1, '2013-10-31 22:07:55'),
('pengguna', '$2a$08$ugoMu3b9ULNzFBMHKm1cfeLY57u31iblFe6BQ8eoQ98ifGTEGo5we', 'pengguna@bpmppt.com', 1, '2013-11-04 18:29:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `baka_auth_usermeta`
--

DROP TABLE IF EXISTS `baka_auth_usermeta`;
CREATE TABLE IF NOT EXISTS `baka_auth_usermeta` (
  `meta_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) COLLATE utf8_unicode_ci NOT NULL,
  `meta_key` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `meta_value` text COLLATE utf8_unicode_ci DEFAULT '',
  PRIMARY KEY (`meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `baka_auth_user_autologin`
--

DROP TABLE IF EXISTS `baka_auth_user_autologin`;
CREATE TABLE IF NOT EXISTS `baka_auth_user_autologin` (
  `key_id` char(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_agent` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `baka_auth_user_roles`
--

DROP TABLE IF EXISTS `baka_auth_user_roles`;
CREATE TABLE IF NOT EXISTS `baka_auth_user_roles` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `user_id2_idx` (`user_id`),
  KEY `role_id1_idx` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `baka_auth_user_roles`
--

INSERT INTO `baka_auth_user_roles` (`user_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `baka_ci_sessions`
--

DROP TABLE IF EXISTS `baka_ci_sessions`;
CREATE TABLE IF NOT EXISTS `baka_ci_sessions` (
  `session_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `baka_data`
--

DROP TABLE IF EXISTS `baka_data`;
CREATE TABLE IF NOT EXISTS `baka_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_agenda` varchar(100) NOT NULL,
  `created_on` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `label` varchar(225) NOT NULL,
  `petitioner` varchar(45) NOT NULL,
  `status` varchar(45) DEFAULT NULL,
  `approved_on` datetime DEFAULT '0000-00-00 00:00:00',
  `done_on` datetime DEFAULT '0000-00-00 00:00:00',
  `printed_on` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_on` datetime DEFAULT '0000-00-00 00:00:00',
  `logs` longtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `baka_data_meta`
--

DROP TABLE IF EXISTS `baka_data_meta`;
CREATE TABLE IF NOT EXISTS `baka_data_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_id` int(11) NOT NULL,
  `data_type` varchar(50) NOT NULL,
  `meta_key` varchar(225) NOT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `baka_data_props`
--

DROP TABLE IF EXISTS `baka_data_props`;
CREATE TABLE IF NOT EXISTS `baka_data_props` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `prop_key` varchar(100) DEFAULT NULL,
  `prop_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `baka_data_props`
--

INSERT INTO `baka_data_props` (`name`, `prop_key`, `prop_value`) VALUES
('bentuk_usaha', 'Koperasi', 'Koperasi'),
('bentuk_usaha', 'pt', 'Perseroan Terbatas (PT)'),
('bentuk_usaha', 'bumn', 'Badan Usaha Milik Negara (BUMN)'),
('bentuk_usaha', 'po', 'Perorangan'),
('bentuk_usaha', 'cv', 'Perseroan Komanditer (CV)'),
('jenis_usaha', 'swasta', 'Swasta'),
('jenis_usaha', 'swasta-tbk', 'Swasta Tbk/Go Publik'),
('jenis_usaha', 'persero', 'Persero'),
('jenis_usaha', 'persero-tbk', 'Persero Tbk/Go Publik'),
('jenis_usaha', 'persh', 'Persh Daerah'),
('jenis_usaha', 'persh-tbk', 'Persh Daerah Tbk/Go Publik'),
('milik_bangunan', 'pinjam', 'Pinjam Pakai'),
('milik_bangunan', 'kontrak', 'Kontrak'),
('milik_bangunan', 'sewa', 'Sewa'),
('milik_bangunan', 'milik', 'Milik Sendiri'),
('kerjasama', 'mandiri', 'Mandiri'),
('kerjasama', 'kso', 'KSO'),
('kerjasama', 'wla', 'Waralaba Nasional'),
('kerjasama', 'wli', 'Waralaba Internasional'),
('kerjasama', 'ja', 'Jaringan Nasional'),
('kerjasama', 'ji', 'Jaringan Internasional'),
('koperasi', 'jasa', 'Jasa'),
('koperasi', 'pemasaran', 'Pemasaran'),
('koperasi', 'produsen', 'Produsen'),
('koperasi', 'konsumen', 'Konsumen'),
('koperasi', 'simpan', 'Simpan Pinjam'),
('koperasi', 'lainya', 'Lainya'),
('kwn', 'wna', 'Warga Negara Asing'),
('kwn', 'wni', 'Warga Negara Indonesia'),
('modal', 'pma', 'Penanaman Modal Asing'),
('modal', 'pmdn', 'Penanaman Modal Dalam Negeri'),
('modal', 'lain', 'Lainya'),
('pengajuan', 'baru', 'Pendaftaran Baru'),
('pengajuan', 'pembaruan', 'Daftar Ulang'),
('pengajuan', 'perubahan', 'Balik Nama'),
('rantai_dagang', 'produsen', 'Produsen'),
('rantai_dagang', 'exportir', 'Exportir'),
('rantai_dagang', 'importir', 'Importir'),
('rantai_dagang', 'dist', 'Distributor/Wholesaler/Grosir'),
('rantai_dagang', 'sub-dist', 'Sub Distributor'),
('rantai_dagang', 'agen', 'Agen'),
('rantai_dagang', 'pengecer', 'Pengecer'),
('status_usaha', 'tunggal', 'Kantor Tunggal'),
('status_usaha', 'pusat', 'Kantor Pusat'),
('status_usaha', 'cabang', 'Kantor Cabang'),
('status_usaha', 'pembantu', 'Kantor Pembantu'),
('status_usaha', 'perwakilan', 'Kantor Perwakilan'),
('sub_pariwisata', 'bpw', 'Jasa Biro Perjalanan Wisata'),
('sub_pariwisata', 'apw', 'Jasa Agen Perjalanan Wisata'),
('sub_pariwisata', 'jpw', 'Jasa Pramu-wisata'),
('sub_pariwisata', 'konvensi', 'Jasa Konvensi, perjalanan insentif dan pameran'),
('sub_pariwisata', 'konsul-wisata', 'Jasa Konsultan Pariwisata'),
('sub_pariwisata', 'io', 'Jasa Impresariat'),
('sub_pariwisata', 'info-wisata', 'Jasa Informasi Pariwisata'),
('sub_pariwisata', 'rekreasi', 'Taman Rekreasi'),
('sub_pariwisata', 'renang', 'Gelanggang renang'),
('sub_pariwisata', 'pemancingan', 'Kolam Pemancingan'),
('sub_pariwisata', 'permainan', 'Gelanggang Permainan dan Ketangka-san'),
('sub_pariwisata', 'billyard', 'Rumah Billyard'),
('sub_pariwisata', 'bioskop', 'Bioskop'),
('sub_pariwisata', 'atraksi', 'Atraksi wisata'),
('sub_pariwisata', 'rm', 'Rumah makan'),
('sub_pariwisata', 'hotel', 'Hotel/Losmen/Villa/Cottage/Pesanggra-han'),
('sub_pariwisata', 'pondok', 'Pondok wisata'),
('sub_pariwisata', 'karaoke', 'Karaoke'),
('sub_pariwisata', 'dufan', 'Dunia fantasi'),
('sub_pariwisata', 'seni', 'Pusat Seni dan Pameran'),
('sub_pariwisata', 'satwa', 'Taman Satwa dan pentas satwa'),
('sub_pariwisata', 'fitness', 'Fitness Centre'),
('sub_pariwisata', 'salon', 'Salon Kecantikan'),
('sub_pariwisata', 'mandala', 'Mandala Wisata'),
('sub_pariwisata', 'cafetaria', 'Cafetaria'),
('sub_pariwisata', 'game', 'Video Game/Play Station'),
('sub_pariwisata', 'golf', 'Padang Golf'),
('sub_pariwisata', 'kemah', 'Bumi Perkemahan'),
('bentuk_toko', 'toko', 'Toko/Kios'),
('bentuk_toko', 'toserba', 'Toserba/Departemen Store'),
('bentuk_toko', 'swalayan', 'Swalayan/Supermarket'),
('bentuk_toko', 'lainya', 'Lainya'),
('pekerjaan', 'pengangguran', 'Belum/Tidak bekerja'),
('pekerjaan', 'rumah-tangga', 'Mengurus rumah tangga'),
('pekerjaan', 'pelajar', 'Pelajar/Mahasiswa'),
('pekerjaan', 'pensiun', 'Pensiun'),
('pekerjaan', 'sipil', 'Pegawai Negeri Sipil'),
('pekerjaan', 'tni', 'Tentara Nasional Indonesia'),
('pekerjaan', 'polisi', 'Kepolisian RI'),
('pekerjaan', 'petani', 'Petani/pekebun'),
('pekerjaan', 'peternak', 'Peternak'),
('pekerjaan', 'nelayan', 'Nelayan/perikanan'),
('pekerjaan', 'industri', 'Industri'),
('pekerjaan', 'konstruksi', 'Konstruksi'),
('pekerjaan', 'transportasi', 'Transportasi'),
('pekerjaan', 'swasta', 'Karyawan Swasta'),
('pekerjaan', 'bumn', 'Karyawan BUMN'),
('pekerjaan', 'bumd', 'Karyawan BUMD'),
('pekerjaan', 'honorer', 'Karyawan Honorer'),
('pekerjaan', 'buruh-lepas', 'Buruh harian lepas'),
('pekerjaan', 'buruh-tani', 'Buruh tani/perkebunan'),
('pekerjaan', 'buruh-nelayan', 'Buruh nelayan/perikanan'),
('pekerjaan', 'buruh-ternak', 'Buruh peternakan'),
('pekerjaan', 'prt', 'Pembantu rumah tangga'),
('pekerjaan', 'tkg-cukur', 'Tukang cukur'),
('pekerjaan', 'tkg-listrik', 'Tukang listrik'),
('pekerjaan', 'tkg-batu', 'Tukang batu'),
('pekerjaan', 'tkg-kayu', 'Tukang kayu'),
('pekerjaan', 'tkg-sol', 'Tukang sol sepatu'),
('pekerjaan', 'tkg-las', 'Tukang las/pandai besi'),
('pekerjaan', 'tkg-jahit', 'Tukang jahit'),
('pekerjaan', 'tkg-Rambut', 'Penata Rambut'),
('pekerjaan', 'tkg-rias', 'Penata rias'),
('pekerjaan', 'tkg-busana', 'Penata busana'),
('pekerjaan', 'tkg-gigi', 'Tukang gigi'),
('pekerjaan', 'mekanik', 'Mekanik'),
('pekerjaan', 'seniman', 'Seniman'),
('pekerjaan', 'tabib', 'Tabib'),
('pekerjaan', 'peraji', 'Peraji'),
('pekerjaan', 'perancang', 'Perancang busana'),
('pekerjaan', 'penerjemah', 'Penerjemah'),
('pekerjaan', 'imam', 'Imam masjid'),
('pekerjaan', 'pendeta', 'Pendeta'),
('pekerjaan', 'pastur', 'Pastur'),
('pekerjaan', 'wartawan', 'Wartawan'),
('pekerjaan', 'ustad', 'Ustad/mubaligh'),
('pekerjaan', 'juru', 'Juru masak'),
('pekerjaan', 'promotor', 'Promotor acara'),
('pekerjaan', 'anggota', 'Anggota DPD'),
('pekerjaan', 'anggota', 'Anggota BPK'),
('pekerjaan', 'bupati', 'Bupati'),
('pekerjaan', 'wakil', 'Wakil Bupati'),
('pekerjaan', 'walikota', 'Walikota'),
('pekerjaan', 'wakil', 'Wakil Walikota'),
('pekerjaan', 'anggota', 'Anggota DPRD Propinsi'),
('pekerjaan', 'anggota', 'Anggota DPRD Kab/Kota'),
('pekerjaan', 'dosen', 'Dosen'),
('pekerjaan', 'guru', 'Guru'),
('pekerjaan', 'pilot', 'Pilot'),
('pekerjaan', 'pengacara', 'Pengacara'),
('pekerjaan', 'notaris', 'Notaris'),
('pekerjaan', 'arsitek', 'Arsitek'),
('pekerjaan', 'akuntan', 'Akuntan'),
('pekerjaan', 'konsultan', 'Konsultan'),
('pekerjaan', 'dokter', 'Dokter'),
('pekerjaan', 'bidan', 'Bidan'),
('pekerjaan', 'perawat', 'Perawat'),
('pekerjaan', 'apoteker', 'Apoteker'),
('pekerjaan', 'psikiater', 'Psikiater/Psikolog'),
('pekerjaan', 'penyiar', 'Penyiar televisi'),
('pekerjaan', 'penyiar', 'Penyiar radio'),
('pekerjaan', 'pelaut', 'Pelaut'),
('pekerjaan', 'peneliti', 'Peneliti'),
('pekerjaan', 'sopir', 'Sopir'),
('pekerjaan', 'pialang', 'Pialang'),
('pekerjaan', 'paranormal', 'Paranormal'),
('pekerjaan', 'pedagang', 'Pedagang'),
('pekerjaan', 'perangkat', 'Perangkat Desa'),
('pekerjaan', 'kepala', 'Kepala Desa'),
('pekerjaan', 'biarawati', 'Biarawati'),
('jabatan', 'kepala', 'Kepala/Pimpinan'),
('jabatan', 'sekretaris', 'Sekretaris'),
('jabatan', 'kabid', 'Kepala Bidang'),
('jabatan', 'kasubbid', 'Kepala Sub Bidang'),
('jabatan', 'kabag', 'Kepala Bagian'),
('jabatan', 'kasubbag', 'Kepala Sub Bagian'),
('jabatan', 'staf', 'Staf'),
('bagian', 'bpmppt', 'BPM PTT'),
('bagian', 'keuangan', 'Keuangan'),
('bagian', 'pengendalian', 'Pengendalian'),
('bagian', 'program', 'Program'),
('bagian', 'layanan', 'Pelayanan'),
('bagian', 'layanan-info', 'Pelayanan Informasi'),
('bagian', 'layanan-izin', 'Pelayanan Perizinan'),
('bagian', 'layanan-nonizin', 'Pelayanan Non Perizinan'),
('bagian', 'pengelolaan-sd', 'Pengelolaan, Pelayanan Sistem dan Data'),
('bagian', 'modal', 'Penanaman Modal'),
('bagian', 'umum', 'Umum dan Kepegawaian'),
('bagian', 'promosi', 'Promosi dan Kerjasama'),
('bagian', 'info-pengaduan', 'Informasi dan Pengaduan'),
('skala_usaha', 'usaha-kecil', 'Perusahaan Kecil'),
('skala_usaha', 'usaha_menengah', 'Perusahaan Menengah'),
('skala_usaha', 'usaha_besar', 'Perusahaan Besar'),
('milik_tanah', 'hak_milik', 'Hak Milik'),
('milik_tanah', 'hak_guna', 'Hak Guna Bangunan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `baka_media`
--

DROP TABLE IF EXISTS `baka_media`;
CREATE TABLE IF NOT EXISTS `baka_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uploaded_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `title` varchar(50) NOT NULL,
  `filename` varchar(50) NOT NULL,
  `path` varchar(255) NOT NULL,
  `mime` varchar(15) NOT NULL,
  `ext` varchar(5) NOT NULL,
  `size` int(11) NOT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `attached` tinyint(1) DEFAULT NULL,
  `attached_to` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `baka_system_env`
--

DROP TABLE IF EXISTS `baka_system_env`;
CREATE TABLE IF NOT EXISTS `baka_system_env` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `env_key` varchar(100) NOT NULL,
  `env_value` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `baka_system_opt`
--

DROP TABLE IF EXISTS `baka_system_opt`;
CREATE TABLE IF NOT EXISTS `baka_system_opt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `opt_key` varchar(100) NOT NULL,
  `opt_value` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `opt_key_UNIQUE` (`opt_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `baka_system_opt`
--

INSERT INTO `baka_system_opt` (`opt_key`, `opt_value`) VALUES
('skpd_name', 'Badan Penanaman Modal dan Pelayanan Perijinan Terpadu'),
('skpd_address', 'Jalan Mandurejo'),
('skpd_city', 'Kabupaten Pekalongan'),
('skpd_prov', 'Jawa Tengah'),
('skpd_telp', '(0285) 381992'),
('skpd_fax', '(0285) 381992'),
('skpd_pos', '54322'),
('skpd_web', 'http://bpmppt.kab-pekalongan.go.id'),
('skpd_email', 'contact@bpmppt.kab-pekalongan.go.id'),
('skpd_logo', 'application/storage/upload/logo_cetak.png'),
('skpd_lead_name', 'M. JANU HARYANTO,SH.MH'),
('skpd_lead_nip', '19570126 198007 1 001'),
('skpd_kab', 'Kajen'),
('app_data_show_limit', '10'),
('app_date_format', 'j F Y'),
('app_datetime_format', 'j F Y\\,\\  H:i:s'),
('app_fieldset_email', '0'),
('auth_username_min_length', '4'),
('auth_username_max_length', '20'),
('auth_password_min_length', '4'),
('auth_password_max_length', '20'),
('auth_allow_registration', '0'),
('auth_captcha_registration', '1'),
('auth_email_activation', '0'),
('auth_email_act_expire', '172800'),
('auth_use_username', '1'),
('auth_login_by_username', '1'),
('auth_login_by_email', '1'),
('auth_login_record_ip', '1'),
('auth_login_count_attempts', '1'),
('auth_login_max_attempts', '5'),
('auth_login_attempt_expire', '86400'),
('auth_use_recaptcha', '0'),
('auth_recaptcha_public_key', NULL),
('auth_recaptcha_private_key', NULL),
('auth_username_blacklist', 'admin,administrator,mod,moderator,root'),
('auth_username_blacklist_prepend', 'the,sys,system,site,super'),
('auth_username_exceptions', NULL),
('email_protocol', '-'),
('email_mailpath', ''),
('email_smtp_host', ''),
('email_smtp_user', ''),
('email_smtp_pass', ''),
('email_smtp_port', ''),
('email_smtp_timeout', '30'),
('email_wordwrap', '1'),
('email_mailtype', 'html'),
('email_priority', '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
