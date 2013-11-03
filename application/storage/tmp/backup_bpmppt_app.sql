-- MySQL dump 10.13  Distrib 5.5.28, for Win32 (x86)
--
-- Host: localhost    Database: bpmppt_db
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
-- Current Database: `bpmppt_db`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `bpmppt_db` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `bpmppt_db`;

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
  `permission` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`permission_id`),
  UNIQUE KEY `permission_UNIQUE` (`permission`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_auth_permissions`
--

LOCK TABLES `baka_auth_permissions` WRITE;
/*!40000 ALTER TABLE `baka_auth_permissions` DISABLE KEYS */;
INSERT INTO `baka_auth_permissions` VALUES (1,'open page','Open this page','Pages you can open',NULL),(2,'open user page','Only users can open this','User domain',NULL);
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
INSERT INTO `baka_auth_role_permissions` VALUES (1,1),(2,2);
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
  `default` tinyint(1) NOT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_UNIQUE` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_auth_roles`
--

LOCK TABLES `baka_auth_roles` WRITE;
/*!40000 ALTER TABLE `baka_auth_roles` DISABLE KEYS */;
INSERT INTO `baka_auth_roles` VALUES (1,'admin','Administrator',0),(2,'user','User',1);
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
INSERT INTO `baka_auth_user_autologin` VALUES ('379b509f2cfb9e604a338a12ad2f6211',1,'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36','127.0.0.1','2013-10-31 15:22:14');
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
  `country` char(2) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '',
  `timezone` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `website` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_auth_user_profiles`
--

LOCK TABLES `baka_auth_user_profiles` WRITE;
/*!40000 ALTER TABLE `baka_auth_user_profiles` DISABLE KEYS */;
INSERT INTO `baka_auth_user_profiles` VALUES (1,'Fery Wardiyanto','m','1991-02-10','','','','2013-10-31 17:22:31');
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
INSERT INTO `baka_auth_user_roles` VALUES (1,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_auth_users`
--

LOCK TABLES `baka_auth_users` WRITE;
/*!40000 ALTER TABLE `baka_auth_users` DISABLE KEYS */;
INSERT INTO `baka_auth_users` VALUES (1,'feryardiant','$2a$08$suO7xg5IdIuzAogzms3Uxe1qkmQ5YwLSlVsT1UKiuE.NcSVzZIhWO','ferywardiyanto@gmail.com',1,0,NULL,NULL,NULL,NULL,NULL,1,'','127.0.0.1','2013-11-04 00:19:38','2013-10-31 22:07:55','2013-11-03 17:19:38');
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
  `adopted_on` datetime DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `desc` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_data`
--

LOCK TABLES `baka_data` WRITE;
/*!40000 ALTER TABLE `baka_data` DISABLE KEYS */;
INSERT INTO `baka_data` VALUES (1,'\'1\'','0000-00-00 00:00:00',0,'gangguan','some label','saya sendiri',NULL,'pending',NULL),(4,'45678','2013-10-30 05:15:16',1,'izin_gangguan','-','dfghjkl','2013-10-30 05:15:16','pending',''),(7,'ghjk','2013-10-30 09:27:43',1,'izin_reklame','-','rfgthyjk','2013-10-30 09:27:43','pending','');
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
  `meta_key` varchar(50) NOT NULL,
  `meta_value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_data_meta`
--

LOCK TABLES `baka_data_meta` WRITE;
/*!40000 ALTER TABLE `baka_data_meta` DISABLE KEYS */;
INSERT INTO `baka_data_meta` VALUES (1,4,'izin_gangguan','izin_gangguan_surat_nomor','45678'),(2,4,'izin_gangguan','izin_gangguan_surat_tanggal','fghjkl'),(3,4,'izin_gangguan','izin_gangguan_surat_jenis_pengajuan','bn'),(4,4,'izin_gangguan','izin_gangguan_pemohon_nama','dfghjkl'),(5,4,'izin_gangguan','izin_gangguan_pemohon_kerja','p'),(6,4,'izin_gangguan','izin_gangguan_pemohon_alamat','rcvtbynuimo,ty hj'),(7,4,'izin_gangguan','izin_gangguan_pemohon_telp','45678'),(8,4,'izin_gangguan','izin_gangguan_usaha_nama','4567'),(9,4,'izin_gangguan','izin_gangguan_usaha_jenis','45678'),(10,4,'izin_gangguan','izin_gangguan_usaha_alamat','5678'),(11,4,'izin_gangguan','izin_gangguan_usaha_lokasi','56789'),(12,4,'izin_gangguan','izin_gangguan_usaha_luas','5678'),(13,4,'izin_gangguan','izin_gangguan_usaha_pekerja','5678'),(14,4,'izin_gangguan','izin_gangguan_usaha_tetangga_timur','56789'),(15,4,'izin_gangguan','izin_gangguan_usaha_tetangga_utara','5678'),(16,4,'izin_gangguan','izin_gangguan_usaha_tetangga_selatan','5678'),(17,4,'izin_gangguan','izin_gangguan_usaha_tetangga_barat','567890'),(18,5,'izin_reklame','izin_reklame_surat_nomor','ghjk'),(19,5,'izin_reklame','izin_reklame_surat_tanggal','dfghj'),(20,5,'izin_reklame','izin_reklame_pemohon_nama','rfgthyjk'),(21,5,'izin_reklame','izin_reklame_pemohon_kerja','kerja'),(22,5,'izin_reklame','izin_reklame_pemohon_alamat','tyjkl'),(23,5,'izin_reklame','izin_reklame_pemohon_telp','6789'),(24,5,'izin_reklame','izin_reklame_lokasi_jenis','fsdf'),(25,5,'izin_reklame','izin_reklame_reklame_juml','2'),(26,5,'izin_reklame','izin_reklame_reklame_lokasi','asdf'),(27,5,'izin_reklame','izin_reklame_reklame_ukuran_panjang','4'),(28,5,'izin_reklame','izin_reklame_reklame_ukuran_lebar','2'),(29,5,'izin_reklame','izin_reklame_reklame_range_tgl_mulai','2013-10-30'),(30,5,'izin_reklame','izin_reklame_reklame_range_tgl_selesai','2013-10-30'),(31,5,'izin_reklame','izin_reklame_reklame_tema','asdfasdf'),(32,5,'izin_reklame','izin_reklame_reklame_ket','asdfsdf'),(33,6,'izin_reklame','izin_reklame_surat_nomor','ghjk'),(34,6,'izin_reklame','izin_reklame_surat_tanggal','dfghj'),(35,6,'izin_reklame','izin_reklame_pemohon_nama','rfgthyjk'),(36,6,'izin_reklame','izin_reklame_pemohon_kerja','kerja'),(37,6,'izin_reklame','izin_reklame_pemohon_alamat','tyjkl'),(38,6,'izin_reklame','izin_reklame_pemohon_telp','6789'),(39,6,'izin_reklame','izin_reklame_lokasi_jenis','fsdf'),(40,6,'izin_reklame','izin_reklame_reklame_juml','2'),(41,6,'izin_reklame','izin_reklame_reklame_lokasi','asdf'),(42,6,'izin_reklame','izin_reklame_reklame_ukuran_panjang','4'),(43,6,'izin_reklame','izin_reklame_reklame_ukuran_lebar','2'),(44,6,'izin_reklame','izin_reklame_reklame_range_tgl_mulai','2013-10-30'),(45,6,'izin_reklame','izin_reklame_reklame_range_tgl_selesai','2013-10-31'),(46,6,'izin_reklame','izin_reklame_reklame_tema','asdfasdf'),(47,6,'izin_reklame','izin_reklame_reklame_ket','asdfsdf'),(48,7,'izin_reklame','izin_reklame_surat_nomor','ghjk'),(49,7,'izin_reklame','izin_reklame_surat_tanggal','dfghj'),(50,7,'izin_reklame','izin_reklame_pemohon_nama','rfgthyjk'),(51,7,'izin_reklame','izin_reklame_pemohon_kerja','kerja'),(52,7,'izin_reklame','izin_reklame_pemohon_alamat','tyjkl'),(53,7,'izin_reklame','izin_reklame_pemohon_telp','6789'),(54,7,'izin_reklame','izin_reklame_lokasi_jenis','fsdf'),(55,7,'izin_reklame','izin_reklame_reklame_juml','2'),(56,7,'izin_reklame','izin_reklame_reklame_lokasi','asdf'),(57,7,'izin_reklame','izin_reklame_reklame_ukuran_panjang','4'),(58,7,'izin_reklame','izin_reklame_reklame_ukuran_lebar','2'),(59,7,'izin_reklame','izin_reklame_reklame_range_tgl_mulai','2013-10-30'),(60,7,'izin_reklame','izin_reklame_reklame_range_tgl_selesai','2013-10-31'),(61,7,'izin_reklame','izin_reklame_reklame_tema','asdfasdf'),(62,7,'izin_reklame','izin_reklame_reklame_ket','asdfsdf'),(63,8,'izin_reklame','izin_reklame_surat_nomor','ghjk'),(64,8,'izin_reklame','izin_reklame_surat_tanggal','dfghj'),(65,8,'izin_reklame','izin_reklame_pemohon_nama','rfgthyjk'),(66,8,'izin_reklame','izin_reklame_pemohon_kerja','kerja'),(67,8,'izin_reklame','izin_reklame_pemohon_alamat','tyjkl'),(68,8,'izin_reklame','izin_reklame_pemohon_telp','6789'),(69,8,'izin_reklame','izin_reklame_lokasi_jenis','fsdf'),(70,8,'izin_reklame','izin_reklame_reklame_juml','2'),(71,8,'izin_reklame','izin_reklame_reklame_lokasi','asdf'),(72,8,'izin_reklame','izin_reklame_reklame_ukuran_panjang','4'),(73,8,'izin_reklame','izin_reklame_reklame_ukuran_lebar','2'),(74,8,'izin_reklame','izin_reklame_reklame_range_tgl_mulai','2013-10-30'),(75,8,'izin_reklame','izin_reklame_reklame_range_tgl_selesai','2013-10-31'),(76,8,'izin_reklame','izin_reklame_reklame_tema','asdfasdf'),(77,8,'izin_reklame','izin_reklame_reklame_ket','asdfsdf');
/*!40000 ALTER TABLE `baka_data_meta` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_system_opt`
--

LOCK TABLES `baka_system_opt` WRITE;
/*!40000 ALTER TABLE `baka_system_opt` DISABLE KEYS */;
INSERT INTO `baka_system_opt` VALUES (1,'skpd_name','Badan Penanaman Modal dan Pusat Perijinan Terpadu'),(2,'skpd_address','Jalan Mandurejo'),(3,'skpd_city','Kab. Pekalongan'),(4,'skpd_prov','Jawa Tengahz'),(5,'skpd_telp','(0285) 381992'),(6,'skpd_fax','(0285) 381992'),(7,'skpd_pos','54322'),(8,'skpd_web','http://bpmppt.kab-pekalongan.go.id'),(9,'skpd_email','contact@bpmppt.kab-pekalongan.go.id'),(10,'skpd_logo','application/storage/upload/logo_cetak.png'),(11,'app_data_show_limit','10'),(12,'app_date_format','j F Y'),(13,'app_datetime_format','j F Y\\,\\  H:i:s'),(14,'auth_username_min_length','4'),(15,'auth_username_max_length','20'),(16,'auth_password_min_length','4'),(17,'auth_password_max_length','20'),(18,'auth_allow_registration','1'),(19,'auth_captcha_registration','1'),(20,'auth_email_activation','0'),(21,'auth_email_act_expire','172800'),(22,'auth_use_username','1'),(23,'auth_login_by_username','1'),(24,'auth_login_by_email','1'),(25,'auth_login_record_ip','1'),(26,'auth_login_count_attempts','1'),(27,'auth_login_max_attempts','5'),(28,'auth_login_attempt_expire','86400'),(29,'auth_use_recaptcha','0'),(30,'auth_recaptcha_public_key',NULL),(31,'auth_recaptcha_private_key',NULL),(32,'auth_username_blacklist','admin,administrator,mod,moderator,root'),(33,'auth_username_blacklist_prepend','the,sys,system,site,super'),(34,'auth_username_exceptions',NULL),(35,'email_protocol','mail'),(36,'email_mailpath','/usr/sbin/sendmail	'),(37,'email_smtp_host',NULL),(38,'email_smtp_user',NULL),(39,'email_smtp_pass',NULL),(40,'email_smtp_port',NULL),(41,'email_smtp_timeout','5'),(42,'email_wordwrap','1'),(43,'email_mailtype','html'),(44,'email_priority','1'),(45,'auth_username_length_min','4'),(46,'auth_username_length_max','20'),(47,'auth_password_length_min','4'),(48,'auth_password_length_max','20');
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

-- Dump completed on 2013-11-04  0:19:41
