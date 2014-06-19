-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: bpmppt
-- ------------------------------------------------------
-- Server version	5.5.37-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `baka_auth_login_attempts`
--

DROP TABLE IF EXISTS `baka_auth_login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_auth_login_attempts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `login` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `baka_auth_overrides`
--

DROP TABLE IF EXISTS `baka_auth_overrides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_auth_overrides` (
  `user_id` int(10) unsigned NOT NULL,
  `permission_id` smallint(5) unsigned NOT NULL,
  `allow` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `user_id1_idx` (`user_id`),
  KEY `permissions_id1_idx` (`permission_id`),
  CONSTRAINT `permission_id1` FOREIGN KEY (`permission_id`) REFERENCES `baka_auth_permissions` (`permission_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `user_id1` FOREIGN KEY (`user_id`) REFERENCES `baka_auth_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `baka_auth_permissions`
--

DROP TABLE IF EXISTS `baka_auth_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_auth_permissions` (
  `permission_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `permission` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`permission_id`),
  UNIQUE KEY `permission_UNIQUE` (`permission`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_auth_permissions`
--

LOCK TABLES `baka_auth_permissions` WRITE;
/*!40000 ALTER TABLE `baka_auth_permissions` DISABLE KEYS */;
INSERT INTO `baka_auth_permissions` VALUES
(1,'Dokumen','doc_manage','Mengelola Dokumen perijinan',1),
(2,'Dokumen','doc_edit','Mengubah Dokumen perijinan yang sudah ada',1),
(3,'Dokumen','doc_lokasi_manage','Mengelola Dokumen ijin Lokasi',1),
(4,'Dokumen','doc_reklame_manage','Mengelola Dokumen ijin Reklame',1),
(5,'Dokumen','doc_b3_manage','Mengelola Dokumen ijin B3',1),
(6,'Dokumen','doc_ho_manage','Mengelola Dokumen ijin Ganggunan',1),
(7,'Dokumen','doc_imb_manage','Mengelola Dokumen ijin Mendirikan bangunan',1),
(8,'Dokumen','doc_iplc_manage','Mengelola Dokumen ijin Pembuangan Limbah',1),
(9,'Dokumen','doc_iui_manage','Mengelola Dokumen ijin Usaha Industri',1),
(10,'Dokumen','doc_iup_manage','Mengelola Dokumen ijin Usaha Pertambangan',1),
(11,'Dokumen','doc_siup_manage','Mengelola Dokumen ijin Usaha Perdagangan',1),
(12,'Dokumen','doc_tdp_manage','Mengelola Dokumen ijin TDP',1),
(13,'Dokumen','doc_wisata_manage','Mengelola Dokumen ijin Pariwisata',1),
(14,'Aplikasi','internal_skpd_manage','Mengelola pengaturan SKPD',1),
(15,'Aplikasi','internal_application_manage','Mengelola pengaturan Aplikasi',1),
(16,'Aplikasi','internal_security_manage','Mengelola pengaturan Keamanan',1),
(17,'Pengguna','users_manage','Mengelola semua pengguna',1),
(18,'Pengguna','users_add','Menambahkan pengguna',1),
(19,'Pengguna','users_view','Melihat data pengguna',1),
(20,'Pengguna','users_edit_self','Mengubah data pengguna',1),
(21,'Pengguna','users_edit_other','Mengubah data pengguna lain',1),
(22,'Pengguna','perms_manage','Mengelola wewenang pengguna',1),
(23,'Pengguna','roles_manage','Mengelola Kelompok pengguna',1),
(24,'System','sys_manage','Mengelola internal Sistem',1),
(25,'System','sys_backstore_manage','Mengelola backup & restore sistem',1),
(26,'System','sys_logs_manage','Memantau Aktifitas internal sistem',1);
/*!40000 ALTER TABLE `baka_auth_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `baka_auth_role_permissions`
--

DROP TABLE IF EXISTS `baka_auth_role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_auth_role_permissions` (
  `role_id` tinyint(3) unsigned NOT NULL,
  `permission_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `role_id2_idx` (`role_id`),
  KEY `permission_id2_idx` (`permission_id`),
  CONSTRAINT `permission_id2` FOREIGN KEY (`permission_id`) REFERENCES `baka_auth_permissions` (`permission_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `role_id2` FOREIGN KEY (`role_id`) REFERENCES `baka_auth_roles` (`role_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_auth_role_permissions`
--

LOCK TABLES `baka_auth_role_permissions` WRITE;
/*!40000 ALTER TABLE `baka_auth_role_permissions` DISABLE KEYS */;
INSERT INTO `baka_auth_role_permissions` VALUES
(1,1),
(1,2),
(1,3),
(1,4),
(1,5),
(1,6),
(1,7),
(1,8),
(1,9),
(1,10),
(1,11),
(1,12),
(1,13),
(1,14),
(1,15),
(1,16),
(1,17),
(1,18),
(1,19),
(1,20),
(1,21),
(1,22),
(1,23),
(1,24),
(1,25),
(1,26),
(2,1),
(3,1),
(3,10),
(3,11),
(3,12),
(4,1),
(4,6),
(5,1),
(5,2),
(5,3),
(5,4),
(5,5),
(5,7),
(5,8),
(5,9);
/*!40000 ALTER TABLE `baka_auth_role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `baka_auth_roles`
--

DROP TABLE IF EXISTS `baka_auth_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_auth_roles` (
  `role_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `full` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `can_delete` tinyint(1) NOT NULL DEFAULT '1',
  `actived` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_UNIQUE` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_auth_roles`
--

LOCK TABLES `baka_auth_roles` WRITE;
/*!40000 ALTER TABLE `baka_auth_roles` DISABLE KEYS */;
INSERT INTO `baka_auth_roles` VALUES
(1,'admin','Administrator','-',0,0,1),
(2,'pengguna','Pengguna','-',1,0,1),
(3,'bag_1','Bagian 1','-',0,1,1),
(4,'bag_2','Bagian 2','-',0,1,1),
(5,'bag_3','Bagian 3','-',0,1,1);
/*!40000 ALTER TABLE `baka_auth_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `baka_auth_user_autologin`
--

DROP TABLE IF EXISTS `baka_auth_user_autologin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_auth_user_autologin` (
  `key_id` char(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_agent` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `baka_auth_user_roles`
--

DROP TABLE IF EXISTS `baka_auth_user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_auth_user_roles` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `user_id2_idx` (`user_id`),
  KEY `role_id1_idx` (`role_id`),
  CONSTRAINT `role_id1` FOREIGN KEY (`role_id`) REFERENCES `baka_auth_roles` (`role_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `user_id2` FOREIGN KEY (`user_id`) REFERENCES `baka_auth_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_auth_user_roles`
--

LOCK TABLES `baka_auth_user_roles` WRITE;
/*!40000 ALTER TABLE `baka_auth_user_roles` DISABLE KEYS */;
INSERT INTO `baka_auth_user_roles` VALUES
(1,1),
(1,2),
(2,2),
(3,3),
(4,4),
(5,5);
/*!40000 ALTER TABLE `baka_auth_user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `baka_auth_usermeta`
--

DROP TABLE IF EXISTS `baka_auth_usermeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_auth_usermeta` (
  `meta_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `meta_key` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `meta_value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `baka_auth_users`
--

DROP TABLE IF EXISTS `baka_auth_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_auth_users` (
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
  `last_ip` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_login` datetime DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `log` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_auth_users`
--

LOCK TABLES `baka_auth_users` WRITE;
/*!40000 ALTER TABLE `baka_auth_users` DISABLE KEYS */;
INSERT INTO `baka_auth_users` VALUES
(1,'admin','$2a$08$LhuaYcUIVOy1tt7CJjyNh.2ECzQcJoeW44d/DSNVRUoFNriUtAyse','administrator@bpmppt.com','Admin Istrator',1,0,0,NULL,NULL,NULL,NULL,NULL,'127.0.0.1','2014-06-20 03:23:44','2013-10-31 22:07:55','2014-06-19 19:23:44',NULL),
(2,'pengguna','$2a$08$N4sHvUfnm.BKvJxNf6oJEeOqME6J79wZRCBB1cugbDpxAhL7z3dWO','pengguna@bpmppt.com','Pengguna Biasa',1,0,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2013-11-04 18:29:46','2014-05-26 16:28:41',NULL),
(3,'pengguna1','$2a$08$N4sHvUfnm.BKvJxNf6oJEeOqME6J79wZRCBB1cugbDpxAhL7z3dWO','pengguna1@bpmppt.com','Pengguna Satu',1,0,0,NULL,NULL,NULL,NULL,NULL,'127.0.0.1','2014-06-19 08:53:45','2014-03-10 05:45:14','2014-06-19 00:53:45',NULL),
(4,'pengguna2','$2a$08$N4sHvUfnm.BKvJxNf6oJEeOqME6J79wZRCBB1cugbDpxAhL7z3dWO','pengguna2@bpmppt.com','Pengguna Dua',1,0,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2014-03-10 05:45:14','2014-05-20 01:51:34',NULL),
(5,'pengguna3','$2a$08$N4sHvUfnm.BKvJxNf6oJEeOqME6J79wZRCBB1cugbDpxAhL7z3dWO','pengguna3@bpmppt.com','Pengguna Tiga',1,0,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2014-03-10 05:45:14','2014-05-20 01:51:34',NULL);
/*!40000 ALTER TABLE `baka_auth_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `baka_ci_sessions`
--

DROP TABLE IF EXISTS `baka_ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_ci_sessions` (
  `session_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `baka_data`
--

DROP TABLE IF EXISTS `baka_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_agenda` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_on` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `petitioner` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `approved_on` datetime DEFAULT '0000-00-00 00:00:00',
  `done_on` datetime DEFAULT '0000-00-00 00:00:00',
  `printed_on` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_on` datetime DEFAULT '0000-00-00 00:00:00',
  `logs` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `baka_data_meta`
--

DROP TABLE IF EXISTS `baka_data_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_data_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_id` int(11) NOT NULL,
  `data_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `meta_key` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `meta_value` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `baka_data_props`
--

DROP TABLE IF EXISTS `baka_data_props`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_data_props` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `prop_key` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prop_value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=183 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_data_props`
--

LOCK TABLES `baka_data_props` WRITE;
/*!40000 ALTER TABLE `baka_data_props` DISABLE KEYS */;
INSERT INTO `baka_data_props` VALUES
(1,'bentuk_usaha','Koperasi','Koperasi'),
(2,'bentuk_usaha','pt','Perseroan Terbatas (PT)'),
(3,'bentuk_usaha','bumn','Badan Usaha Milik Negara (BUMN)'),
(4,'bentuk_usaha','po','Perorangan'),
(5,'bentuk_usaha','cv','Perseroan Komanditer (CV)'),
(6,'jenis_usaha','swasta','Swasta'),
(7,'jenis_usaha','swasta-tbk','Swasta Tbk/Go Publik'),
(8,'jenis_usaha','persero','Persero'),
(9,'jenis_usaha','persero-tbk','Persero Tbk/Go Publik'),
(10,'jenis_usaha','persh','Persh Daerah'),
(11,'jenis_usaha','persh-tbk','Persh Daerah Tbk/Go Publik'),
(12,'milik_bangunan','pinjam','Pinjam Pakai'),
(13,'milik_bangunan','kontrak','Kontrak'),
(14,'milik_bangunan','sewa','Sewa'),
(15,'milik_bangunan','milik','Milik Sendiri'),
(16,'kerjasama','mandiri','Mandiri'),
(17,'kerjasama','kso','KSO'),
(18,'kerjasama','wla','Waralaba Nasional'),
(19,'kerjasama','wli','Waralaba Internasional'),
(20,'kerjasama','ja','Jaringan Nasional'),
(21,'kerjasama','ji','Jaringan Internasional'),
(22,'koperasi','jasa','Jasa'),
(23,'koperasi','pemasaran','Pemasaran'),
(24,'koperasi','produsen','Produsen'),
(25,'koperasi','konsumen','Konsumen'),
(26,'koperasi','simpan','Simpan Pinjam'),
(27,'koperasi','lainya','Lainya'),
(28,'kwn','wna','Warga Negara Asing'),
(29,'kwn','wni','Warga Negara Indonesia'),
(30,'modal','pma','Penanaman Modal Asing'),
(31,'modal','pmdn','Penanaman Modal Dalam Negeri'),
(32,'modal','lain','Lainya'),
(33,'pengajuan','baru','Pendaftaran Baru'),
(34,'pengajuan','pembaruan','Daftar Ulang'),
(35,'pengajuan','perubahan','Balik Nama'),
(36,'rantai_dagang','produsen','Produsen'),
(37,'rantai_dagang','exportir','Exportir'),
(38,'rantai_dagang','importir','Importir'),
(39,'rantai_dagang','dist','Distributor/Wholesaler/Grosir'),
(40,'rantai_dagang','sub-dist','Sub Distributor'),
(41,'rantai_dagang','agen','Agen'),
(42,'rantai_dagang','pengecer','Pengecer'),
(43,'status_usaha','tunggal','Kantor Tunggal'),
(44,'status_usaha','pusat','Kantor Pusat'),
(45,'status_usaha','cabang','Kantor Cabang'),
(46,'status_usaha','pembantu','Kantor Pembantu'),
(47,'status_usaha','perwakilan','Kantor Perwakilan'),
(48,'sub_pariwisata','bpw','Jasa Biro Perjalanan Wisata'),
(49,'sub_pariwisata','apw','Jasa Agen Perjalanan Wisata'),
(50,'sub_pariwisata','jpw','Jasa Pramu-wisata'),
(51,'sub_pariwisata','konvensi','Jasa Konvensi, perjalanan insentif dan pameran'),
(52,'sub_pariwisata','konsul-wisata','Jasa Konsultan Pariwisata'),
(53,'sub_pariwisata','io','Jasa Impresariat'),
(54,'sub_pariwisata','info-wisata','Jasa Informasi Pariwisata'),
(55,'sub_pariwisata','rekreasi','Taman Rekreasi'),
(56,'sub_pariwisata','renang','Gelanggang renang'),
(57,'sub_pariwisata','pemancingan','Kolam Pemancingan'),
(58,'sub_pariwisata','permainan','Gelanggang Permainan dan Ketangka-san'),
(59,'sub_pariwisata','billyard','Rumah Billyard'),
(60,'sub_pariwisata','bioskop','Bioskop'),
(61,'sub_pariwisata','atraksi','Atraksi wisata'),
(62,'sub_pariwisata','rm','Rumah makan'),
(63,'sub_pariwisata','hotel','Hotel/Losmen/Villa/Cottage/Pesanggra-han'),
(64,'sub_pariwisata','pondok','Pondok wisata'),
(65,'sub_pariwisata','karaoke','Karaoke'),
(66,'sub_pariwisata','dufan','Dunia fantasi'),
(67,'sub_pariwisata','seni','Pusat Seni dan Pameran'),
(68,'sub_pariwisata','satwa','Taman Satwa dan pentas satwa'),
(69,'sub_pariwisata','fitness','Fitness Centre'),
(70,'sub_pariwisata','salon','Salon Kecantikan'),
(71,'sub_pariwisata','mandala','Mandala Wisata'),
(72,'sub_pariwisata','cafetaria','Cafetaria'),
(73,'sub_pariwisata','game','Video Game/Play Station'),
(74,'sub_pariwisata','golf','Padang Golf'),
(75,'sub_pariwisata','kemah','Bumi Perkemahan'),
(76,'bentuk_toko','toko','Toko/Kios'),
(77,'bentuk_toko','toserba','Toserba/Departemen Store'),
(78,'bentuk_toko','swalayan','Swalayan/Supermarket'),
(79,'bentuk_toko','lainya','Lainya'),
(80,'pekerjaan','pengangguran','Belum/Tidak bekerja'),
(81,'pekerjaan','rumah-tangga','Mengurus rumah tangga'),
(82,'pekerjaan','pelajar','Pelajar/Mahasiswa'),
(83,'pekerjaan','pensiun','Pensiun'),
(84,'pekerjaan','sipil','Pegawai Negeri Sipil'),
(85,'pekerjaan','tni','Tentara Nasional Indonesia'),
(86,'pekerjaan','polisi','Kepolisian RI'),
(87,'pekerjaan','petani','Petani/pekebun'),
(88,'pekerjaan','peternak','Peternak'),
(89,'pekerjaan','nelayan','Nelayan/perikanan'),
(90,'pekerjaan','industri','Industri'),
(91,'pekerjaan','konstruksi','Konstruksi'),
(92,'pekerjaan','transportasi','Transportasi'),
(93,'pekerjaan','swasta','Karyawan Swasta'),
(94,'pekerjaan','bumn','Karyawan BUMN'),
(95,'pekerjaan','bumd','Karyawan BUMD'),
(96,'pekerjaan','honorer','Karyawan Honorer'),
(97,'pekerjaan','buruh-lepas','Buruh harian lepas'),
(98,'pekerjaan','buruh-tani','Buruh tani/perkebunan'),
(99,'pekerjaan','buruh-nelayan','Buruh nelayan/perikanan'),
(100,'pekerjaan','buruh-ternak','Buruh peternakan'),
(101,'pekerjaan','prt','Pembantu rumah tangga'),
(102,'pekerjaan','tkg-cukur','Tukang cukur'),
(103,'pekerjaan','tkg-listrik','Tukang listrik'),
(104,'pekerjaan','tkg-batu','Tukang batu'),
(105,'pekerjaan','tkg-kayu','Tukang kayu'),
(106,'pekerjaan','tkg-sol','Tukang sol sepatu'),
(107,'pekerjaan','tkg-las','Tukang las/pandai besi'),
(108,'pekerjaan','tkg-jahit','Tukang jahit'),
(109,'pekerjaan','tkg-Rambut','Penata Rambut'),
(110,'pekerjaan','tkg-rias','Penata rias'),
(111,'pekerjaan','tkg-busana','Penata busana'),
(112,'pekerjaan','tkg-gigi','Tukang gigi'),
(113,'pekerjaan','mekanik','Mekanik'),
(114,'pekerjaan','seniman','Seniman'),
(115,'pekerjaan','tabib','Tabib'),
(116,'pekerjaan','peraji','Peraji'),
(117,'pekerjaan','perancang','Perancang busana'),
(118,'pekerjaan','penerjemah','Penerjemah'),
(119,'pekerjaan','imam','Imam masjid'),
(120,'pekerjaan','pendeta','Pendeta'),
(121,'pekerjaan','pastur','Pastur'),
(122,'pekerjaan','wartawan','Wartawan'),
(123,'pekerjaan','ustad','Ustad/mubaligh'),
(124,'pekerjaan','juru','Juru masak'),
(125,'pekerjaan','promotor','Promotor acara'),
(126,'pekerjaan','anggota','Anggota DPD'),
(127,'pekerjaan','anggota','Anggota BPK'),
(128,'pekerjaan','bupati','Bupati'),
(129,'pekerjaan','wakil','Wakil Bupati'),
(130,'pekerjaan','walikota','Walikota'),
(131,'pekerjaan','wakil','Wakil Walikota'),
(132,'pekerjaan','anggota','Anggota DPRD Propinsi'),
(133,'pekerjaan','anggota','Anggota DPRD Kab/Kota'),
(134,'pekerjaan','dosen','Dosen'),
(135,'pekerjaan','guru','Guru'),
(136,'pekerjaan','pilot','Pilot'),
(137,'pekerjaan','pengacara','Pengacara'),
(138,'pekerjaan','notaris','Notaris'),
(139,'pekerjaan','arsitek','Arsitek'),
(140,'pekerjaan','akuntan','Akuntan'),
(141,'pekerjaan','konsultan','Konsultan'),
(142,'pekerjaan','dokter','Dokter'),
(143,'pekerjaan','bidan','Bidan'),
(144,'pekerjaan','perawat','Perawat'),
(145,'pekerjaan','apoteker','Apoteker'),
(146,'pekerjaan','psikiater','Psikiater/Psikolog'),
(147,'pekerjaan','penyiar','Penyiar televisi'),
(148,'pekerjaan','penyiar','Penyiar radio'),
(149,'pekerjaan','pelaut','Pelaut'),
(150,'pekerjaan','peneliti','Peneliti'),
(151,'pekerjaan','sopir','Sopir'),
(152,'pekerjaan','pialang','Pialang'),
(153,'pekerjaan','paranormal','Paranormal'),
(154,'pekerjaan','pedagang','Pedagang'),
(155,'pekerjaan','perangkat','Perangkat Desa'),
(156,'pekerjaan','kepala','Kepala Desa'),
(157,'pekerjaan','biarawati','Biarawati'),
(158,'jabatan','kepala','Kepala/Pimpinan'),
(159,'jabatan','sekretaris','Sekretaris'),
(160,'jabatan','kabid','Kepala Bidang'),
(161,'jabatan','kasubbid','Kepala Sub Bidang'),
(162,'jabatan','kabag','Kepala Bagian'),
(163,'jabatan','kasubbag','Kepala Sub Bagian'),
(164,'jabatan','staf','Staf'),
(165,'bagian','bpmppt','BPM PTT'),
(166,'bagian','keuangan','Keuangan'),
(167,'bagian','pengendalian','Pengendalian'),
(168,'bagian','program','Program'),
(169,'bagian','layanan','Pelayanan'),
(170,'bagian','layanan-info','Pelayanan Informasi'),
(171,'bagian','layanan-izin','Pelayanan Perizinan'),
(172,'bagian','layanan-nonizin','Pelayanan Non Perizinan'),
(173,'bagian','pengelolaan-sd','Pengelolaan, Pelayanan Sistem dan Data'),
(174,'bagian','modal','Penanaman Modal'),
(175,'bagian','umum','Umum dan Kepegawaian'),
(176,'bagian','promosi','Promosi dan Kerjasama'),
(177,'bagian','info-pengaduan','Informasi dan Pengaduan'),
(178,'skala_usaha','usaha-kecil','Perusahaan Kecil'),
(179,'skala_usaha','usaha_menengah','Perusahaan Menengah'),
(180,'skala_usaha','usaha_besar','Perusahaan Besar'),
(181,'milik_tanah','hak_milik','Hak Milik'),
(182,'milik_tanah','hak_guna','Hak Guna Bangunan');
/*!40000 ALTER TABLE `baka_data_props` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `baka_system_opt`
--

DROP TABLE IF EXISTS `baka_system_opt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_system_opt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `opt_key` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `opt_value` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `opt_key_UNIQUE` (`opt_key`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_system_opt`
--

LOCK TABLES `baka_system_opt` WRITE;
/*!40000 ALTER TABLE `baka_system_opt` DISABLE KEYS */;
INSERT INTO `baka_system_opt` VALUES
(1,'skpd_name','Badan Penanaman Modal dan Pelayanan Perijinan Terpadus'),
(2,'skpd_address','Jalan Mandurejo'),
(3,'skpd_city','Kabupaten Pekalongan'),
(4,'skpd_prov','Jawa Tengah'),
(5,'skpd_telp','(0285) 381992'),
(6,'skpd_fax','(0285) 381992'),
(7,'skpd_pos','54322'),
(8,'skpd_web','http://bpmppt.kab-pekalongan.go.id'),
(9,'skpd_email','contact@bpmppt.kab-pekalongan.go.id'),
(10,'skpd_logo','asset/img/logo_cetak.png'),
(11,'skpd_lead_name','M. JANU HARYANTO,SH.MH'),
(12,'skpd_lead_nip','19570126 198007 1 001'),
(13,'skpd_kab','Kajen'),
(14,'app_data_show_limit','7'),
(15,'app_date_format','j F Y'),
(16,'app_datetime_format','j F Y\\,\\  H:i:s'),
(17,'app_fieldset_email','0'),
(18,'auth_username_length_min','4'),
(19,'auth_username_length_max','20'),
(20,'auth_password_length_min','4'),
(21,'auth_password_length_max','20'),
(22,'auth_allow_registration','1'),
(23,'auth_captcha_registration','1'),
(24,'auth_email_activation','0'),
(25,'auth_email_act_expire','172800'),
(26,'auth_use_username','1'),
(27,'auth_login_by_username','1'),
(28,'auth_login_by_email','1'),
(29,'auth_login_record_ip','1'),
(30,'auth_login_count_attempts','1'),
(31,'auth_login_max_attempts','4'),
(32,'auth_login_attempt_expire','259200'),
(33,'auth_use_recaptcha','0'),
(34,'auth_recaptcha_public_key',NULL),
(35,'auth_recaptcha_private_key',NULL),
(36,'auth_username_blacklist','admin, administrator, mod, moderator, root'),
(37,'auth_username_blacklist_prepend','the, sys, system, site, super'),
(38,'auth_username_exceptions',NULL),
(39,'email_protocol','0'),
(40,'email_mailpath',''),
(41,'email_smtp_host',''),
(42,'email_smtp_user',''),
(43,'email_smtp_pass',''),
(44,'email_smtp_port',''),
(45,'email_smtp_timeout','30'),
(46,'email_wordwrap','0'),
(47,'email_mailtype','0'),
(48,'email_priority','2'),
(49,'welcome_title','Selamat Datang di BPMPPT App'),
(50,'welcome_login','<p>Aplikasi © Badan Penanaman Modal dan Pelayanan Perijinan Terpadu Kabupaten Pekalongan</p><p>Silahkan login untuk dapat menggunakan aplikasi ini.</p>'),
(51,'welcome_register','<p>Aplikasi © Badan Penanaman Modal dan Pelayanan Perijinan Terpadu Kabupaten Pekalongan</p><p>Silahkan login untuk dapat menggunakan aplikasi ini.</p>'),
(52,'welcome_forgot','<p>Aplikasi © Badan Penanaman Modal dan Pelayanan Perijinan Terpadu Kabupaten Pekalongan</p><p>Silahkan login untuk dapat menggunakan aplikasi ini.</p>'),
(53,'welcome_resend','<p>Aplikasi © Badan Penanaman Modal dan Pelayanan Perijinan Terpadu Kabupaten Pekalongan</p><p>Silahkan login untuk dapat menggunakan aplikasi ini.</p>');
/*!40000 ALTER TABLE `baka_system_opt` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-06-20  2:42:15
