-- phpMyAdmin SQL Dump
-- version 4.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 18 Jun 2014 pada 20.57
-- Versi Server: 5.5.37-0ubuntu0.14.04.1
-- PHP Version: 5.5.12-2+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bpmppt`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_login_attempts`
--

DROP TABLE IF EXISTS `auth_login_attempts`;
CREATE TABLE IF NOT EXISTS `auth_login_attempts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `login` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_overrides`
--

DROP TABLE IF EXISTS `auth_overrides`;
CREATE TABLE IF NOT EXISTS `auth_overrides` (
  `user_id` int(10) unsigned NOT NULL,
  `permission_id` smallint(5) unsigned NOT NULL,
  `allow` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`user_id`, `permission_id`),
  KEY `user_id1_idx` (`user_id`),
  KEY `permissions_id1_idx` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_permissions`
--

DROP TABLE IF EXISTS `auth_permissions`;
CREATE TABLE IF NOT EXISTS `auth_permissions` (
  `permission_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `permission` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`permission_id`),
  UNIQUE KEY `permission_UNIQUE` (`permission`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `auth_permissions`
--

INSERT INTO `auth_permissions` (`parent`, `permission`, `description`) VALUES
('Dokumen', 'doc_manage', 'Mengelola Dokumen perijinan'),
('Dokumen', 'doc_edit', 'Mengubah Dokumen perijinan yang sudah ada'),
('Aplikasi', 'internal_skpd_manage', 'Mengelola pengaturan SKPD'),
('Aplikasi', 'internal_application_manage', 'Mengelola pengaturan Aplikasi'),
('Aplikasi', 'internal_security_manage', 'Mengelola pengaturan Keamanan'),
('Pengguna', 'users_manage', 'Mengelola semua pengguna'),
('Pengguna', 'users_add', 'Menambahkan pengguna'),
('Pengguna', 'users_view', 'Melihat data pengguna'),
('Pengguna', 'users_edit_self', 'Mengubah data pengguna'),
('Pengguna', 'users_edit_other', 'Mengubah data pengguna lain'),
('Pengguna', 'perms_manage', 'Mengelola wewenang pengguna'),
('Pengguna', 'roles_manage', 'Mengelola Kelompok pengguna'),
('System', 'sys_manage', 'Mengelola internal Sistem'),
('System', 'sys_backstore_manage', 'Mengelola backup & restore sistem'),
('System', 'sys_logs_manage', 'Memantau Aktifitas internal sistem');

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_roles`
--

DROP TABLE IF EXISTS `auth_roles`;
CREATE TABLE IF NOT EXISTS `auth_roles` (
  `role_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `full` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `can_delete` tinyint(1) NOT NULL DEFAULT '1',
  `actived` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_UNIQUE` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `auth_roles`
--

INSERT INTO `auth_roles` (`role_id`, `role`, `full`, `default`, `can_delete`, `actived`) VALUES
(1, 'admin', 'Administrator', 0, 0, 1),
(2, 'pengguna', 'Pengguna', 1, 0, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_role_permissions`
--

DROP TABLE IF EXISTS `auth_role_permissions`;
CREATE TABLE IF NOT EXISTS `auth_role_permissions` (
  `role_id` tinyint(3) unsigned NOT NULL,
  `permission_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`role_id`, `permission_id`),
  KEY `role_id2_idx` (`role_id`),
  KEY `permission_id2_idx` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `auth_role_permissions`
--

INSERT INTO `auth_role_permissions` (`role_id`, `permission_id`) VALUES
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
(2, 1));

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_usermeta`
--

DROP TABLE IF EXISTS `auth_usermeta`;
CREATE TABLE IF NOT EXISTS `auth_usermeta` (
  `meta_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `meta_key` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `meta_value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_users`
--

DROP TABLE IF EXISTS `auth_users`;
CREATE TABLE IF NOT EXISTS `auth_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `display` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` char(32) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `last_login` datetime DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `log` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `auth_users`
--

INSERT INTO `auth_users` (`id`, `username`, `password`, `email`, `display`, `created`) VALUES
(1, 'admin', '$2a$08$LhuaYcUIVOy1tt7CJjyNh.2ECzQcJoeW44d/DSNVRUoFNriUtAyse', 'administrator@bpmppt.com', 'Admin Istrator', '2013-10-31 22:07:55'),
(2, 'pengguna', '$2a$08$N4sHvUfnm.BKvJxNf6oJEeOqME6J79wZRCBB1cugbDpxAhL7z3dWO', 'pengguna@bpmppt.com', 'Pengguna Biasa', '2013-11-04 18:29:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_user_autologin`
--

DROP TABLE IF EXISTS `auth_user_autologin`;
CREATE TABLE IF NOT EXISTS `auth_user_autologin` (
  `key_id` char(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_agent` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`, `user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_user_roles`
--

DROP TABLE IF EXISTS `auth_user_roles`;
CREATE TABLE IF NOT EXISTS `auth_user_roles` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`user_id`, `role_id`),
  KEY `user_id2_idx` (`user_id`),
  KEY `role_id1_idx` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `auth_user_roles`
--

INSERT INTO `auth_user_roles` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `system_opt`
--

DROP TABLE IF EXISTS `system_opt`;
CREATE TABLE IF NOT EXISTS `system_opt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `opt_key` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `opt_value` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `opt_key_UNIQUE` (`opt_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `system_opt`
--

INSERT INTO `system_opt` (`opt_key`, `opt_value`) VALUES
('app_data_show_limit', '10'),
('app_date_format', 'j F Y'),
('app_datetime_format', 'j F Y\\,\\  H:i:s'),
('app_fieldset_email', '0'),
('auth_username_length_min', '4'),
('auth_username_length_max', '20'),
('auth_password_length_min', '4'),
('auth_password_length_max', '20'),
('auth_allow_registration', '1'),
('auth_captcha_registration', '1'),
('auth_email_activation', '0'),
('auth_email_act_expire', '172800'),
('auth_use_username', '1'),
('auth_login_by_username', '1'),
('auth_login_by_email', '1'),
('auth_login_record_ip', '1'),
('auth_login_count_attempts', '1'),
('auth_login_max_attempts', '5'),
('auth_login_attempt_expire', '259200'),
('auth_use_recaptcha', '0'),
('auth_recaptcha_public_key', NULL),
('auth_recaptcha_private_key', NULL),
('auth_username_blacklist', 'admin, administrator, mod, moderator, root'),
('auth_username_blacklist_prepend', 'the, sys, system, site, super'),
('auth_username_exceptions', NULL),
('email_protocol', '0'),
('email_mailpath', ''),
('email_smtp_host', ''),
('email_smtp_user', ''),
('email_smtp_pass', ''),
('email_smtp_port', ''),
('email_smtp_timeout', '30'),
('email_wordwrap', '0'),
('email_mailtype', '0'),
('email_priority', '2');
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `auth_overrides`
--
ALTER TABLE `auth_overrides`
ADD CONSTRAINT `permission_id1` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`permission_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `user_id1` FOREIGN KEY (`user_id`) REFERENCES `auth_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `auth_role_permissions`
--
ALTER TABLE `auth_role_permissions`
ADD CONSTRAINT `permission_id2` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`permission_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `role_id2` FOREIGN KEY (`role_id`) REFERENCES `auth_roles` (`role_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `auth_user_roles`
--
ALTER TABLE `auth_user_roles`
ADD CONSTRAINT `role_id1` FOREIGN KEY (`role_id`) REFERENCES `auth_roles` (`role_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `user_id2` FOREIGN KEY (`user_id`) REFERENCES `auth_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
