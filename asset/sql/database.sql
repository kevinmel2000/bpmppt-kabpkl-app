/*!40100 DEFAULT CHARACTER SET utf8 */;

-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: 127.0.0.1
-- ------------------------------------------------------
-- Server version	5.5.28

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
-- Dumping data for table `baka_auth_login_attempts`
--

LOCK TABLES `baka_auth_login_attempts` WRITE;
/*!40000 ALTER TABLE `baka_auth_login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `baka_auth_login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `baka_auth_overrides`
--

LOCK TABLES `baka_auth_overrides` WRITE;
/*!40000 ALTER TABLE `baka_auth_overrides` DISABLE KEYS */;
/*!40000 ALTER TABLE `baka_auth_overrides` ENABLE KEYS */;
UNLOCK TABLES;

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
  `sort` tinyint(3) unsigned DEFAULT NULL,
  `status` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`permission_id`),
  UNIQUE KEY `permission_UNIQUE` (`permission`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_auth_permissions`
--

LOCK TABLES `baka_auth_permissions` WRITE;
/*!40000 ALTER TABLE `baka_auth_permissions` DISABLE KEYS */;
INSERT INTO `baka_auth_permissions` VALUES (1,'Halaman','open page','Open this page',NULL,NULL),(2,'Pengguna','open user page','Only users can open this',NULL,NULL),(3,'Pengguna','user_add','Menambahkan pengguna',NULL,NULL),(4,'Pengguna','user_del','Menghapus pengguna',NULL,NULL),(5,'Pengguna','user_ban','Mencekal pengguna',NULL,NULL),(6,'Pengguna','user_view','Melihat data pengguna',NULL,NULL),(7,'Pengguna','user_edit','Mengubah data pengguna',NULL,NULL),(8,'Pengguna','user_activate','Mengaktifkan pengguna baru',NULL,NULL),(9,'Pengguna','user_approve','Mengijinkan pengguna baru',NULL,NULL),(10,'Data','doc_manage','-',NULL,NULL),(11,'Wewenang','perm_manage','Mengelola wewenang',NULL,NULL),(12,'Kelompok','roles_manage','Mengelola Kelompok',NULL,NULL),(13,'Sistem','setting_manage','Mengelola Pengaturan Sistem',NULL,NULL),(14,'Data','doc_report','Membuat laporan dokumen',NULL,NULL),(15,'Data','doc_view','Melihat dokumen',NULL,NULL),(16,'Data','doc_edit','Mengubah dokumen',NULL,NULL),(17,'Data','doc_approve','Menyetujui dokumen',NULL,NULL),(18,'Data','doc_del','Menghapus dokumen',NULL,NULL),(30,'Data','doc_gangguan_manage','Mengelola Dokumen ijin Ganggunan',NULL,NULL),(31,'Data','doc_lokasi_manage','Mengelola Dokumen ijin Lokasi',NULL,NULL),(32,'Data','doc_mendirikan_bangunan_manage','Mengelola Dokumen ijin Mendirikan bangunan',NULL,NULL),(33,'Data','doc_pembuangan_limbah_manage','Mengelola Dokumen ijin Pembuangan Limbah',NULL,NULL),(34,'Data','doc_pengelolaan_b3_manage','Mengelola Dokumen ijin B3',NULL,NULL),(35,'Data','doc_reklame_manage','Mengelola Dokumen ijin Reklame',NULL,NULL),(36,'Data','doc_tanda_daftar_perusahaan_manage','Mengelola Dokumen ijin TDP',NULL,NULL),(37,'Data','doc_usaha_industri_manage','Mengelola Dokumen ijin Usaha Industri',NULL,NULL),(38,'Data','doc_usaha_pariwisata_manage','Mengelola Dokumen ijin Pariwisata',NULL,NULL),(39,'Data','doc_usaha_perdagangan_manage','Mengelola Dokumen ijin Usaha Perdagangan',NULL,NULL),(40,'Data','doc_usaha_pertambangan_manage','Mengelola Dokumen ijin Usaha Pertambangan',NULL,NULL);
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
INSERT INTO `baka_auth_role_permissions` VALUES (1,1),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),(1,13),(1,14),(1,15),(1,16),(1,18),(1,31),(1,32),(1,33),(1,34),(1,35),(1,36),(1,37),(1,38),(1,39),(1,40),(2,2),(9,10),(9,14),(9,15),(9,16),(9,17),(9,18),(9,36),(9,38),(10,10),(10,14),(10,15),(10,16),(10,17),(10,18),(10,31),(10,33),(10,34),(10,35),(10,37),(10,40),(11,2),(11,10),(11,14),(11,32);
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
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `can_delete` tinyint(1) NOT NULL DEFAULT '1',
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_UNIQUE` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_auth_roles`
--

LOCK TABLES `baka_auth_roles` WRITE;
/*!40000 ALTER TABLE `baka_auth_roles` DISABLE KEYS */;
INSERT INTO `baka_auth_roles` VALUES (1,'admin','Administrator',0,1,0,0),(2,'user','User',1,1,0,0),(9,'bag_1','Bagian 1',0,1,0,0),(10,'bag_2','Bagian 2',0,1,0,0),(11,'bag_3','Bagian 3',0,1,0,0);
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
-- Dumping data for table `baka_auth_user_autologin`
--

LOCK TABLES `baka_auth_user_autologin` WRITE;
/*!40000 ALTER TABLE `baka_auth_user_autologin` DISABLE KEYS */;
INSERT INTO `baka_auth_user_autologin` VALUES ('25db2b34a3a82c9e9417b91b91316a6d',1,'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36','127.0.0.1','2013-11-12 09:09:40'),('cae74083f062fce68dbaaa21c4db5847',1,'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1710.0 Safari/537.36','127.0.0.1','2013-11-16 03:34:05'),('ff6968de6ee9dc7c5989c24d602627c8',1,'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36','127.0.0.1','2013-11-16 11:40:02');
/*!40000 ALTER TABLE `baka_auth_user_autologin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `baka_auth_user_profiles`
--

DROP TABLE IF EXISTS `baka_auth_user_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_auth_user_profiles` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `gender` char(1) COLLATE utf8_unicode_ci DEFAULT '',
  `dob` date DEFAULT '0000-00-00',
  `address` varchar(225) COLLATE utf8_unicode_ci DEFAULT '',
  `phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT '',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_auth_user_profiles`
--

LOCK TABLES `baka_auth_user_profiles` WRITE;
/*!40000 ALTER TABLE `baka_auth_user_profiles` DISABLE KEYS */;
INSERT INTO `baka_auth_user_profiles` VALUES (1,'Fery Wardiyanto','m','1991-02-10','','','2013-10-31 17:22:31'),(2,'','','0000-00-00','','','2013-11-04 11:29:46'),(6,'','','0000-00-00','','','2013-11-19 22:51:49');
/*!40000 ALTER TABLE `baka_auth_user_profiles` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `baka_auth_user_roles` VALUES (1,1),(1,2),(2,2);
/*!40000 ALTER TABLE `baka_auth_user_roles` ENABLE KEYS */;
UNLOCK TABLES;

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
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` char(32) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `approved` tinyint(1) DEFAULT NULL COMMENT 'For acct approval.',
  `meta` varchar(2000) COLLATE utf8_unicode_ci DEFAULT '',
  `last_ip` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_login` datetime DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_auth_users`
--

LOCK TABLES `baka_auth_users` WRITE;
/*!40000 ALTER TABLE `baka_auth_users` DISABLE KEYS */;
INSERT INTO `baka_auth_users` VALUES (1,'feryardiant','$2a$08$LhuaYcUIVOy1tt7CJjyNh.2ECzQcJoeW44d/DSNVRUoFNriUtAyse','ferywardiyanto@gmail.com',1,0,NULL,NULL,NULL,NULL,NULL,1,'','127.0.0.1','2013-11-20 05:57:33','2013-10-31 22:07:55','2013-11-19 22:57:33'),(2,'mimin-ardiant','$2a$08$ugoMu3b9ULNzFBMHKm1cfeLY57u31iblFe6BQ8eoQ98ifGTEGo5we','feryardiant@gmail.com',1,0,NULL,NULL,NULL,NULL,NULL,1,'','127.0.0.1','2013-11-04 18:29:46','2013-11-04 18:29:46','2013-11-04 11:29:46'),(6,'asddsaasd','$2a$08$Lnny1B2CMV5ddoNSjdWvsOfLp4LV2BC0OJ55BUe./ijS9YZOxoK5y','alamat@mail.com',1,0,NULL,NULL,NULL,NULL,NULL,1,'','127.0.0.1','2013-11-20 05:51:48','2013-11-20 05:51:48','2013-11-19 22:51:49');
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
-- Dumping data for table `baka_ci_sessions`
--

LOCK TABLES `baka_ci_sessions` WRITE;
/*!40000 ALTER TABLE `baka_ci_sessions` DISABLE KEYS */;
INSERT INTO `baka_ci_sessions` VALUES ('abc9cd77774447776e27666c84e73a0f','127.0.0.1','Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36',1384901810,'a:4:{s:9:\"user_data\";s:0:\"\";s:7:\"user_id\";s:1:\"1\";s:8:\"username\";s:11:\"feryardiant\";s:6:\"status\";i:1;}');
/*!40000 ALTER TABLE `baka_ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `baka_data`
--

DROP TABLE IF EXISTS `baka_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_data` (
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
  `logs` longtext,
  `desc` varchar(225) DEFAULT NULL,
  `deleted_on` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_data`
--

LOCK TABLES `baka_data` WRITE;
/*!40000 ALTER TABLE `baka_data` DISABLE KEYS */;
INSERT INTO `baka_data` VALUES (7,'ghjk','2013-10-30 09:27:43',1,'izin_reklame','-','rfgthyjk','pending','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'','0000-00-00 00:00:00'),(8,'566','2013-11-07 01:00:07',1,'izin_lokasi','-','Mimin','pending','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'','0000-00-00 00:00:00'),(9,'edrtyui','2013-11-07 02:54:37',1,'izin_mendirikan_bangunan','-','Nama lengkap','pending','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'','0000-00-00 00:00:00'),(11,'76543','2013-11-07 07:30:03',1,'izin_pengelolaan_b3','-','nama lengkap','pending','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'','0000-00-00 00:00:00'),(17,'99','2013-11-18 20:36:40',1,'izin_pembuangan_air_limbah','-','Nama Lengkap','pending','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'','0000-00-00 00:00:00'),(18,'1234','2013-11-19 15:54:30',1,'izin_gangguan','-','Nama lengkap','deleted','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','a:1:{i:0;a:3:{s:7:\"user_id\";s:1:\"1\";s:4:\"date\";s:19:\"2013-11-19 16:03:08\";s:7:\"message\";s:39:\"Mengubah status dokumen menjadi Dihapus\";}}','','2013-11-19 16:03:08'),(19,'3456789','2013-11-19 16:04:59',1,'izin_gangguan','-','uhnj uhjn','pending','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `baka_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `baka_data_meta`
--

DROP TABLE IF EXISTS `baka_data_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_data_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_id` int(11) NOT NULL,
  `data_type` varchar(50) NOT NULL,
  `meta_key` varchar(225) NOT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=276 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_data_meta`
--

LOCK TABLES `baka_data_meta` WRITE;
/*!40000 ALTER TABLE `baka_data_meta` DISABLE KEYS */;
INSERT INTO `baka_data_meta` VALUES (18,5,'izin_reklame','izin_reklame_surat_nomor','ghjk'),(19,5,'izin_reklame','izin_reklame_surat_tanggal','dfghj'),(20,5,'izin_reklame','izin_reklame_pemohon_nama','rfgthyjk'),(21,5,'izin_reklame','izin_reklame_pemohon_kerja','kerja'),(22,5,'izin_reklame','izin_reklame_pemohon_alamat','tyjkl'),(23,5,'izin_reklame','izin_reklame_pemohon_telp','6789'),(24,5,'izin_reklame','izin_reklame_lokasi_jenis','fsdf'),(25,5,'izin_reklame','izin_reklame_reklame_juml','2'),(26,5,'izin_reklame','izin_reklame_reklame_lokasi','asdf'),(27,5,'izin_reklame','izin_reklame_reklame_ukuran_panjang','4'),(28,5,'izin_reklame','izin_reklame_reklame_ukuran_lebar','2'),(29,5,'izin_reklame','izin_reklame_reklame_range_tgl_mulai','2013-10-30'),(30,5,'izin_reklame','izin_reklame_reklame_range_tgl_selesai','2013-10-30'),(31,5,'izin_reklame','izin_reklame_reklame_tema','asdfasdf'),(32,5,'izin_reklame','izin_reklame_reklame_ket','asdfsdf'),(33,6,'izin_reklame','izin_reklame_surat_nomor','ghjk'),(34,6,'izin_reklame','izin_reklame_surat_tanggal','dfghj'),(35,6,'izin_reklame','izin_reklame_pemohon_nama','rfgthyjk'),(36,6,'izin_reklame','izin_reklame_pemohon_kerja','kerja'),(37,6,'izin_reklame','izin_reklame_pemohon_alamat','tyjkl'),(38,6,'izin_reklame','izin_reklame_pemohon_telp','6789'),(39,6,'izin_reklame','izin_reklame_lokasi_jenis','fsdf'),(40,6,'izin_reklame','izin_reklame_reklame_juml','2'),(41,6,'izin_reklame','izin_reklame_reklame_lokasi','asdf'),(42,6,'izin_reklame','izin_reklame_reklame_ukuran_panjang','4'),(43,6,'izin_reklame','izin_reklame_reklame_ukuran_lebar','2'),(44,6,'izin_reklame','izin_reklame_reklame_range_tgl_mulai','2013-10-30'),(45,6,'izin_reklame','izin_reklame_reklame_range_tgl_selesai','2013-10-31'),(46,6,'izin_reklame','izin_reklame_reklame_tema','asdfasdf'),(47,6,'izin_reklame','izin_reklame_reklame_ket','asdfsdf'),(48,7,'izin_reklame','izin_reklame_surat_nomor','ghjk'),(49,7,'izin_reklame','izin_reklame_surat_tanggal','dfghj'),(50,7,'izin_reklame','izin_reklame_pemohon_nama','rfgthyjk'),(51,7,'izin_reklame','izin_reklame_pemohon_kerja','kerja'),(52,7,'izin_reklame','izin_reklame_pemohon_alamat','tyjkl'),(53,7,'izin_reklame','izin_reklame_pemohon_telp','6789'),(54,7,'izin_reklame','izin_reklame_lokasi_jenis','fsdf'),(55,7,'izin_reklame','izin_reklame_reklame_juml','2'),(56,7,'izin_reklame','izin_reklame_reklame_lokasi','asdf'),(57,7,'izin_reklame','izin_reklame_reklame_ukuran_panjang','4'),(58,7,'izin_reklame','izin_reklame_reklame_ukuran_lebar','2'),(59,7,'izin_reklame','izin_reklame_reklame_range_tgl_mulai','2013-10-30'),(60,7,'izin_reklame','izin_reklame_reklame_range_tgl_selesai','2013-10-31'),(61,7,'izin_reklame','izin_reklame_reklame_tema','asdfasdf'),(62,7,'izin_reklame','izin_reklame_reklame_ket','asdfsdf'),(63,8,'izin_reklame','izin_reklame_surat_nomor','ghjk'),(64,8,'izin_reklame','izin_reklame_surat_tanggal','dfghj'),(65,8,'izin_reklame','izin_reklame_pemohon_nama','rfgthyjk'),(66,8,'izin_reklame','izin_reklame_pemohon_kerja','kerja'),(67,8,'izin_reklame','izin_reklame_pemohon_alamat','tyjkl'),(68,8,'izin_reklame','izin_reklame_pemohon_telp','6789'),(69,8,'izin_reklame','izin_reklame_lokasi_jenis','fsdf'),(70,8,'izin_reklame','izin_reklame_reklame_juml','2'),(71,8,'izin_reklame','izin_reklame_reklame_lokasi','asdf'),(72,8,'izin_reklame','izin_reklame_reklame_ukuran_panjang','4'),(73,8,'izin_reklame','izin_reklame_reklame_ukuran_lebar','2'),(74,8,'izin_reklame','izin_reklame_reklame_range_tgl_mulai','2013-10-30'),(75,8,'izin_reklame','izin_reklame_reklame_range_tgl_selesai','2013-10-31'),(76,8,'izin_reklame','izin_reklame_reklame_tema','asdfasdf'),(77,8,'izin_reklame','izin_reklame_reklame_ket','asdfsdf'),(78,8,'izin_lokasi','izin_lokasi_surat_nomor','566'),(79,8,'izin_lokasi','izin_lokasi_surat_tanggal','2013-07-11'),(80,8,'izin_lokasi','izin_lokasi_pemohon_nama','Mimin'),(81,8,'izin_lokasi','izin_lokasi_pemohon_jabatan','pemilik'),(82,8,'izin_lokasi','izin_lokasi_pemohon_usaha','apa aja'),(83,8,'izin_lokasi','izin_lokasi_pemohon_alamat','dimana aja'),(84,8,'izin_lokasi','izin_lokasi_lokasi_tujuan','bjif sdf bwjsd fsjk'),(85,8,'izin_lokasi','izin_lokasi_lokasi_alamat','sdf bksdfk sdjkf '),(86,8,'izin_lokasi','izin_lokasi_lokasi_nama','100'),(87,8,'izin_lokasi','izin_lokasi_lokasi_area_hijau','sjfdjksg bn'),(88,9,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_surat_nomor','edrtyui'),(89,9,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_surat_tanggal','2013-04-11'),(90,9,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_bangunan_maksud','rehap'),(91,9,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_bangunan_guna','kios'),(92,9,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_pemohon_nama','Nama lengkap'),(93,9,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_pemohon_kerja','pekerjaan'),(94,9,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_pemohon_alamat','almaat'),(95,9,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_bangunan_lokasi','lokasi bangunan'),(96,9,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_bangunan_tanah_luas','100'),(97,9,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_bangunan_tanah_keadaan','d1'),(98,9,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_bangunan_tanah_status','hm'),(99,9,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_bangunan_milik_no','0987654'),(100,9,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_bangunan_milik_an','456789'),(101,9,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_bangunan_luas','765'),(119,11,'izin_pengelolaan_b3','izin_pengelolaan_b3_surat_nomor','76543'),(120,11,'izin_pengelolaan_b3','izin_pengelolaan_b3_surat_tanggal','2013-05-11'),(121,11,'izin_pengelolaan_b3','izin_pengelolaan_b3_pemohon_nama','nama lengkap'),(122,11,'izin_pengelolaan_b3','izin_pengelolaan_b3_pemohon_alamat','alamat'),(123,11,'izin_pengelolaan_b3','izin_pengelolaan_b3_pemohon_jabatan','jabatan'),(124,11,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_nama','nama perusahaan'),(125,11,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_bidang','bidang usaha'),(126,11,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_alamat','alamat kantor'),(127,11,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_lokasi','lokasi usaha'),(128,11,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_kontak_telp','09766'),(129,11,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_kontak_fax','09876'),(130,11,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_tps_fungsi','asd'),(131,11,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_tps_ukuran','asd'),(132,11,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_tps_koor_s','asd'),(133,11,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_tps_koor_e','asd'),(208,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_surat_nomor','99'),(209,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_surat_tanggal','1970-01-01'),(210,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_pemohon_nama','Nama Lengkap'),(211,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_pemohon_jabatan','Jabatan'),(212,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_pemohon_usaha','Nama Perusahaan'),(213,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_pemohon_alamat','Alamat Lengkap'),(214,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kapasitas_produksi','76'),(215,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_debit_max_proses','6776'),(216,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_debit_max_kond','67'),(217,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_proses_bod','76'),(218,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_proses_cod','67'),(219,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_proses_tts','6'),(220,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_proses_minyak','7'),(221,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_proses_sulfida','86'),(222,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_proses_ph','8987'),(223,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_proses_bod','7'),(224,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_proses_cod','856'),(225,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_proses_tts','8'),(226,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_proses_minyak','8'),(227,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_proses_sulfida','3'),(228,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_proses_ph','56'),(229,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_kond_bod','67'),(230,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_kond_cod','67'),(231,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_kond_tts','67'),(232,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_kond_minyak','56'),(233,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_kond_sulfida','67'),(234,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_kond_ph','6'),(235,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_kond_bod','67'),(236,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_kond_cod','6'),(237,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_kond_tts','67'),(238,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_kond_minyak','586'),(239,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_kond_sulfida','67'),(240,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_kond_ph','8'),(241,17,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_target_buang','568'),(242,18,'izin_gangguan','izin_gangguan_surat_nomor','1234'),(243,18,'izin_gangguan','izin_gangguan_surat_tanggal','1970-01-01'),(244,18,'izin_gangguan','izin_gangguan_surat_jenis_pengajuan','bn'),(245,18,'izin_gangguan','izin_gangguan_pemohon_nama','Nama lengkap'),(246,18,'izin_gangguan','izin_gangguan_pemohon_kerja','p'),(247,18,'izin_gangguan','izin_gangguan_pemohon_alamat','Alamat lengkap'),(248,18,'izin_gangguan','izin_gangguan_pemohon_telp','09876549765'),(249,18,'izin_gangguan','izin_gangguan_usaha_nama','Nama perusahaan'),(250,18,'izin_gangguan','izin_gangguan_usaha_jenis','jenis usah'),(251,18,'izin_gangguan','izin_gangguan_usaha_alamat','Alamat kantor'),(252,18,'izin_gangguan','izin_gangguan_usaha_lokasi','Lokasi Usaha'),(253,18,'izin_gangguan','izin_gangguan_usaha_luas','876'),(254,18,'izin_gangguan','izin_gangguan_usaha_pekerja','8'),(255,18,'izin_gangguan','izin_gangguan_usaha_tetangga_timur','ASDF'),(256,18,'izin_gangguan','izin_gangguan_usaha_tetangga_utara','rtybhnujimk'),(257,18,'izin_gangguan','izin_gangguan_usaha_tetangga_selatan','yguhnjimk'),(258,18,'izin_gangguan','izin_gangguan_usaha_tetangga_barat','vyuhnjimk,l'),(259,19,'izin_gangguan','izin_gangguan_surat_nomor','3456789'),(260,19,'izin_gangguan','izin_gangguan_surat_tanggal','1970-01-01'),(261,19,'izin_gangguan','izin_gangguan_surat_jenis_pengajuan','br'),(262,19,'izin_gangguan','izin_gangguan_pemohon_nama','uhnj uhjn'),(263,19,'izin_gangguan','izin_gangguan_pemohon_kerja','p'),(264,19,'izin_gangguan','izin_gangguan_pemohon_alamat','bn yjuhnjhn ujn'),(265,19,'izin_gangguan','izin_gangguan_pemohon_telp','234234234'),(266,19,'izin_gangguan','izin_gangguan_usaha_nama','jn'),(267,19,'izin_gangguan','izin_gangguan_usaha_jenis','jnm uj'),(268,19,'izin_gangguan','izin_gangguan_usaha_alamat','jn'),(269,19,'izin_gangguan','izin_gangguan_usaha_lokasi','j'),(270,19,'izin_gangguan','izin_gangguan_usaha_luas','234'),(271,19,'izin_gangguan','izin_gangguan_usaha_pekerja','12'),(272,19,'izin_gangguan','izin_gangguan_usaha_tetangga_timur','ujn'),(273,19,'izin_gangguan','izin_gangguan_usaha_tetangga_utara','hjn'),(274,19,'izin_gangguan','izin_gangguan_usaha_tetangga_selatan','hjn'),(275,19,'izin_gangguan','izin_gangguan_usaha_tetangga_barat','hjn');
/*!40000 ALTER TABLE `baka_data_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `baka_doc_meta`
--

DROP TABLE IF EXISTS `baka_doc_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_doc_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_id` int(11) NOT NULL,
  `data_type` varchar(50) NOT NULL,
  `meta_key` varchar(50) NOT NULL,
  `meta_value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_doc_meta`
--

LOCK TABLES `baka_doc_meta` WRITE;
/*!40000 ALTER TABLE `baka_doc_meta` DISABLE KEYS */;
/*!40000 ALTER TABLE `baka_doc_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `baka_doc_props`
--

DROP TABLE IF EXISTS `baka_doc_props`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_doc_props` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `prop_key` varchar(100) DEFAULT NULL,
  `prop_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=191 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_doc_props`
--

LOCK TABLES `baka_doc_props` WRITE;
/*!40000 ALTER TABLE `baka_doc_props` DISABLE KEYS */;
INSERT INTO `baka_doc_props` VALUES (1,'bentuk_usaha','Koperasi','Koperasi'),(2,'bentuk_usaha','pt','Perseroan Terbatas (PT)'),(3,'bentuk_usaha','bumn','Badan Usaha Milik Negara (BUMN)'),(4,'bentuk_usaha','po','Perorangan'),(5,'bentuk_usaha','cv','Perseroan Komanditer (CV)'),(6,'jenis_usaha','swasta','Swasta'),(7,'jenis_usaha','swasta-tbk','Swasta Tbk/Go Publik'),(8,'jenis_usaha','persero','Persero'),(9,'jenis_usaha','persero-tbk','Persero Tbk/Go Publik'),(10,'jenis_usaha','persh','Persh Daerah'),(11,'jenis_usaha','persh-tbk','Persh Daerah Tbk/Go Publik'),(12,'milik_bangunan','pinjam','Pinjam Pakai'),(13,'milik_bangunan','kontrak','Kontrak'),(14,'milik_bangunan','sewa','Sewa'),(15,'milik_bangunan','milik','Milik Sendiri'),(16,'kerjasama','mandiri','Mandiri'),(17,'kerjasama','kso','KSO'),(18,'kerjasama','wla','Waralaba Nasional'),(19,'kerjasama','wli','Waralaba Internasional'),(20,'kerjasama','ja','Jaringan Nasional'),(21,'kerjasama','ji','Jaringan Internasional'),(22,'koperasi','jasa','Jasa'),(23,'koperasi','pemasaran','Pemasaran'),(24,'koperasi','produsen','Produsen'),(25,'koperasi','konsumen','Konsumen'),(26,'koperasi','simpan','Simpan Pinjam'),(27,'koperasi','lainya','Lainya'),(28,'kwn','wna','Warga Negara Asing'),(29,'kwn','wni','Warga Negara Indonesia'),(30,'modal','pma','Penanaman Modal Asing'),(31,'modal','pmdn','Penanaman Modal Dalam Negeri'),(32,'modal','lain','Lainya'),(33,'pengajuan','baru','Pendaftaran Baru'),(34,'pengajuan','pembaruan','Daftar Ulang'),(35,'pengajuan','perubahan','Balik Nama'),(36,'rantai_dagang','produsen','Produsen'),(37,'rantai_dagang','exportir','Exportir'),(38,'rantai_dagang','importir','Importir'),(39,'rantai_dagang','dist','Distributor/Wholesaler/Grosir'),(40,'rantai_dagang','sub-dist','Sub Distributor'),(41,'rantai_dagang','agen','Agen'),(42,'rantai_dagang','pengecer','Pengecer'),(43,'status_usaha','tunggal','Kantor Tunggal'),(44,'status_usaha','pusat','Kantor Pusat'),(45,'status_usaha','cabang','Kantor Cabang'),(46,'status_usaha','pembantu','Kantor Pembantu'),(47,'status_usaha','perwakilan','Kantor Perwakilan'),(48,'sub_pariwisata','bpw','Jasa Biro Perjalanan Wisata'),(49,'sub_pariwisata','apw','Jasa Agen Perjalanan Wisata'),(50,'sub_pariwisata','jpw','Jasa Pramu-wisata'),(51,'sub_pariwisata','konvensi','Jasa Konvensi, perjalanan insentif dan pameran'),(52,'sub_pariwisata','konsul-wisata','Jasa Konsultan Pariwisata'),(53,'sub_pariwisata','io','Jasa Impresariat'),(54,'sub_pariwisata','info-wisata','Jasa Informasi Pariwisata'),(55,'sub_pariwisata','rekreasi','Taman Rekreasi'),(56,'sub_pariwisata','renang','Gelanggang renang'),(57,'sub_pariwisata','pemancingan','Kolam Pemancingan'),(58,'sub_pariwisata','permainan','Gelanggang Permainan dan Ketangka-san'),(59,'sub_pariwisata','billyard','Rumah Billyard'),(60,'sub_pariwisata','bioskop','Bioskop'),(61,'sub_pariwisata','atraksi','Atraksi wisata'),(62,'sub_pariwisata','rm','Rumah makan'),(63,'sub_pariwisata','hotel','Hotel/Losmen/Villa/Cottage/Pesanggra-han'),(64,'sub_pariwisata','pondok','Pondok wisata'),(65,'sub_pariwisata','karaoke','Karaoke'),(66,'sub_pariwisata','dufan','Dunia fantasi'),(67,'sub_pariwisata','seni','Pusat Seni dan Pameran'),(68,'sub_pariwisata','satwa','Taman Satwa dan pentas satwa'),(69,'sub_pariwisata','fitness','Fitness Centre'),(70,'sub_pariwisata','salon','Salon Kecantikan'),(71,'sub_pariwisata','mandala','Mandala Wisata'),(72,'sub_pariwisata','cafetaria','Cafetaria'),(73,'sub_pariwisata','game','Video Game/Play Station'),(74,'sub_pariwisata','golf','Padang Golf'),(75,'sub_pariwisata','kemah','Bumi Perkemahan'),(76,'bentuk_toko','toko','Toko/Kios'),(77,'bentuk_toko','toserba','Toserba/Departemen Store'),(78,'bentuk_toko','swalayan','Swalayan/Supermarket'),(79,'bentuk_toko','lainya','Lainya'),(80,'pekerjaan','pengangguran','Belum/Tidak bekerja'),(81,'pekerjaan','rumah-tangga','Mengurus rumah tangga'),(82,'pekerjaan','pelajar','Pelajar/Mahasiswa'),(83,'pekerjaan','pensiun','Pensiun'),(84,'pekerjaan','sipil','Pegawai Negeri Sipil'),(85,'pekerjaan','tni','Tentara Nasional Indonesia'),(86,'pekerjaan','polisi','Kepolisian RI'),(87,'pekerjaan','petani','Petani/pekebun'),(88,'pekerjaan','peternak','Peternak'),(89,'pekerjaan','nelayan','Nelayan/perikanan'),(90,'pekerjaan','industri','Industri'),(91,'pekerjaan','konstruksi','Konstruksi'),(92,'pekerjaan','transportasi','Transportasi'),(93,'pekerjaan','swasta','Karyawan Swasta'),(94,'pekerjaan','bumn','Karyawan BUMN'),(95,'pekerjaan','bumd','Karyawan BUMD'),(96,'pekerjaan','honorer','Karyawan Honorer'),(97,'pekerjaan','buruh-lepas','Buruh harian lepas'),(98,'pekerjaan','buruh-tani','Buruh tani/perkebunan'),(99,'pekerjaan','buruh-nelayan','Buruh nelayan/perikanan'),(100,'pekerjaan','buruh-ternak','Buruh peternakan'),(101,'pekerjaan','prt','Pembantu rumah tangga'),(102,'pekerjaan','tkg-cukur','Tukang cukur'),(103,'pekerjaan','tkg-listrik','Tukang listrik'),(104,'pekerjaan','tkg-batu','Tukang batu'),(105,'pekerjaan','tkg-kayu','Tukang kayu'),(106,'pekerjaan','tkg-sol','Tukang sol sepatu'),(107,'pekerjaan','tkg-las','Tukang las/pandai besi'),(108,'pekerjaan','tkg-jahit','Tukang jahit'),(109,'pekerjaan','tkg-Rambut','Penata Rambut'),(110,'pekerjaan','tkg-rias','Penata rias'),(111,'pekerjaan','tkg-busana','Penata busana'),(112,'pekerjaan','tkg-gigi','Tukang gigi'),(113,'pekerjaan','mekanik','Mekanik'),(114,'pekerjaan','seniman','Seniman'),(115,'pekerjaan','tabib','Tabib'),(116,'pekerjaan','peraji','Peraji'),(117,'pekerjaan','perancang','Perancang busana'),(118,'pekerjaan','penerjemah','Penerjemah'),(119,'pekerjaan','imam','Imam masjid'),(120,'pekerjaan','pendeta','Pendeta'),(121,'pekerjaan','pastur','Pastur'),(122,'pekerjaan','wartawan','Wartawan'),(123,'pekerjaan','ustad','Ustad/mubaligh'),(124,'pekerjaan','juru','Juru masak'),(125,'pekerjaan','promotor','Promotor acara'),(126,'pekerjaan','anggota','Anggota DPD'),(127,'pekerjaan','anggota','Anggota BPK'),(128,'pekerjaan','bupati','Bupati'),(129,'pekerjaan','wakil','Wakil Bupati'),(130,'pekerjaan','walikota','Walikota'),(131,'pekerjaan','wakil','Wakil Walikota'),(132,'pekerjaan','anggota','Anggota DPRD Propinsi'),(133,'pekerjaan','anggota','Anggota DPRD Kab/Kota'),(134,'pekerjaan','dosen','Dosen'),(135,'pekerjaan','guru','Guru'),(136,'pekerjaan','pilot','Pilot'),(137,'pekerjaan','pengacara','Pengacara'),(138,'pekerjaan','notaris','Notaris'),(139,'pekerjaan','arsitek','Arsitek'),(140,'pekerjaan','akuntan','Akuntan'),(141,'pekerjaan','konsultan','Konsultan'),(142,'pekerjaan','dokter','Dokter'),(143,'pekerjaan','bidan','Bidan'),(144,'pekerjaan','perawat','Perawat'),(145,'pekerjaan','apoteker','Apoteker'),(146,'pekerjaan','psikiater','Psikiater/Psikolog'),(147,'pekerjaan','penyiar','Penyiar televisi'),(148,'pekerjaan','penyiar','Penyiar radio'),(149,'pekerjaan','pelaut','Pelaut'),(150,'pekerjaan','peneliti','Peneliti'),(151,'pekerjaan','sopir','Sopir'),(152,'pekerjaan','pialang','Pialang'),(153,'pekerjaan','paranormal','Paranormal'),(154,'pekerjaan','pedagang','Pedagang'),(155,'pekerjaan','perangkat','Perangkat Desa'),(156,'pekerjaan','kepala','Kepala Desa'),(157,'pekerjaan','biarawati','Biarawati'),(158,'jabatan','kepala','Kepala/Pimpinan'),(159,'jabatan','sekretaris','Sekretaris'),(160,'jabatan','kabid','Kepala Bidang'),(161,'jabatan','kasubbid','Kepala Sub Bidang'),(162,'jabatan','kabag','Kepala Bagian'),(163,'jabatan','kasubbag','Kepala Sub Bagian'),(164,'jabatan','staf','Staf'),(165,'bagian','bpmppt','BPM PTT'),(166,'bagian','keuangan','Keuangan'),(167,'bagian','pengendalian','Pengendalian'),(168,'bagian','program','Program'),(169,'bagian','layanan','Pelayanan'),(170,'bagian','layanan-info','Pelayanan Informasi'),(171,'bagian','layanan-izin','Pelayanan Perizinan'),(172,'bagian','layanan-nonizin','Pelayanan Non Perizinan'),(173,'bagian','pengelolaan-sd','Pengelolaan, Pelayanan Sistem dan Data'),(174,'bagian','modal','Penanaman Modal'),(175,'bagian','umum','Umum dan Kepegawaian'),(176,'bagian','promosi','Promosi dan Kerjasama'),(177,'bagian','info-pengaduan','Informasi dan Pengaduan'),(178,'syarat','foto_copy_akta_pendi','Foto copy Akta Pendirian badan usaha'),(179,'syarat','foto_copy_gambar_den','Foto copy Gambar Denah Lokasi'),(180,'syarat','foto_copy_bukti_kepe','Foto copy Bukti Kepemilikan Tanah atau Sertifikat'),(181,'skala_usaha','usaha-kecil','Perusahaan Kecil'),(182,'skala_usaha','usaha_menengah','Perusahaan Menengah'),(183,'skala_usaha','usaha_besar','Perusahaan Besar'),(189,'milik_tanah','hak_milik','Hak Milik'),(190,'milik_tanah','hak_guna','Hak Guna Bangunan');
/*!40000 ALTER TABLE `baka_doc_props` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `baka_docs`
--

DROP TABLE IF EXISTS `baka_docs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_docs` (
  `doc_id` int(11) NOT NULL,
  `no_agenda` varchar(45) NOT NULL,
  `type` varchar(45) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(45) NOT NULL,
  `petitioner` varchar(100) NOT NULL,
  `status` varchar(30) NOT NULL,
  `approved_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `closed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) NOT NULL DEFAULT '0',
  `modify_reasons` text,
  `deleted_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_by` int(11) NOT NULL DEFAULT '0',
  `delete_reasons` text,
  `logs` longtext,
  `desc` text,
  PRIMARY KEY (`doc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_docs`
--

LOCK TABLES `baka_docs` WRITE;
/*!40000 ALTER TABLE `baka_docs` DISABLE KEYS */;
/*!40000 ALTER TABLE `baka_docs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `baka_media`
--

DROP TABLE IF EXISTS `baka_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_media` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_media`
--

LOCK TABLES `baka_media` WRITE;
/*!40000 ALTER TABLE `baka_media` DISABLE KEYS */;
/*!40000 ALTER TABLE `baka_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `baka_system_env`
--

DROP TABLE IF EXISTS `baka_system_env`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_system_env` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `env_key` varchar(100) NOT NULL,
  `env_value` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_system_env`
--

LOCK TABLES `baka_system_env` WRITE;
/*!40000 ALTER TABLE `baka_system_env` DISABLE KEYS */;
/*!40000 ALTER TABLE `baka_system_env` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `baka_system_opt`
--

DROP TABLE IF EXISTS `baka_system_opt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baka_system_opt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `opt_key` varchar(100) NOT NULL,
  `opt_value` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_system_opt`
--

LOCK TABLES `baka_system_opt` WRITE;
/*!40000 ALTER TABLE `baka_system_opt` DISABLE KEYS */;
INSERT INTO `baka_system_opt` VALUES (1,'skpd_name','Badan Penanaman Modal dan Pusat Perijinan Terpadu'),(2,'skpd_address','Jalan Mandurejo'),(3,'skpd_city','Kabupaten Pekalongan'),(4,'skpd_prov','Jawa Tengah'),(5,'skpd_telp','(0285) 381992'),(6,'skpd_fax','(0285) 381992'),(7,'skpd_pos','54322'),(8,'skpd_web','http://bpmppt.kab-pekalongan.go.id'),(9,'skpd_email','contact@bpmppt.kab-pekalongan.go.id'),(10,'skpd_logo','application/storage/upload/logo_cetak.png'),(11,'app_data_show_limit','10'),(12,'app_date_format','j F Y'),(13,'app_datetime_format','j F Y\\,\\  H:i:s'),(14,'auth_username_min_length','4'),(15,'auth_username_max_length','20'),(16,'auth_password_min_length','4'),(17,'auth_password_max_length','20'),(18,'auth_allow_registration','1'),(19,'auth_captcha_registration','1'),(20,'auth_email_activation','0'),(21,'auth_email_act_expire','172800'),(22,'auth_use_username','1'),(23,'auth_login_by_username','1'),(24,'auth_login_by_email','1'),(25,'auth_login_record_ip','1'),(26,'auth_login_count_attempts','1'),(27,'auth_login_max_attempts','5'),(28,'auth_login_attempt_expire','86400'),(29,'auth_use_recaptcha','0'),(30,'auth_recaptcha_public_key',NULL),(31,'auth_recaptcha_private_key',NULL),(32,'auth_username_blacklist','admin,administrator,mod,moderator,root'),(33,'auth_username_blacklist_prepend','the,sys,system,site,super'),(34,'auth_username_exceptions',NULL),(35,'email_protocol','smtp'),(36,'email_mailpath','/usr/sbin/sendmail	'),(37,'email_smtp_host','ssl://smtp.googlemail.com'),(38,'email_smtp_user','feryardiant@gmail.com'),(39,'email_smtp_pass','7733b8wck9'),(40,'email_smtp_port','465'),(41,'email_smtp_timeout','30'),(42,'email_wordwrap','1'),(43,'email_mailtype','html'),(44,'email_priority','1'),(45,'auth_username_length_min','4'),(46,'auth_username_length_max','20'),(47,'auth_password_length_min','4'),(48,'auth_password_length_max','20'),(49,'email_smtp_host','smtp.gmail.com'),(50,'email_smtp_user','feryardiant@gmail.com'),(51,'email_smtp_pass','7733b8wck9'),(52,'email_smtp_port','465'),(53,'email_smtp_host','smtp.gmail.com'),(54,'email_smtp_user','feryardiant@gmail.com'),(55,'email_smtp_pass','7733b8wck9'),(56,'email_smtp_port','465'),(57,'email_smtp_host','smtp.gmail.com'),(58,'email_smtp_host','smtp.gmail.com'),(59,'email_smtp_host','smtp.gmail.com'),(60,'app_fieldset_email','0'),(61,'skpd_lead_name','M. JANU HARYANTO,SH.MH'),(62,'skpd_lead_nip','19570126 198007 1 001'),(63,'skpd_kab','KAJEN');
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

-- Dump completed on 2013-11-20  6:16:48
