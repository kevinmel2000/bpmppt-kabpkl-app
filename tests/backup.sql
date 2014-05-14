-- MySQL dump 10.13  Distrib 5.6.16, for Win64 (x86_64)
--
-- Host: localhost    Database: bpmppt_db
-- ------------------------------------------------------
-- Server version	5.6.16-log

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
INSERT INTO `baka_auth_permissions` VALUES (1,'Dokumen','doc_manage','Mengelola Dokumen perijinan',1),(2,'Dokumen','doc_edit','Mengubah Dokumen perijinan yang sudah ada',1),(3,'Dokumen','doc_lokasi_manage','Mengelola Dokumen ijin Lokasi',1),(4,'Dokumen','doc_reklame_manage','Mengelola Dokumen ijin Reklame',1),(5,'Dokumen','doc_b3_manage','Mengelola Dokumen ijin B3',1),(6,'Dokumen','doc_ho_manage','Mengelola Dokumen ijin Ganggunan',1),(7,'Dokumen','doc_imb_manage','Mengelola Dokumen ijin Mendirikan bangunan',1),(8,'Dokumen','doc_iplc_manage','Mengelola Dokumen ijin Pembuangan Limbah',1),(9,'Dokumen','doc_iui_manage','Mengelola Dokumen ijin Usaha Industri',1),(10,'Dokumen','doc_iup_manage','Mengelola Dokumen ijin Usaha Pertambangan',1),(11,'Dokumen','doc_siup_manage','Mengelola Dokumen ijin Usaha Perdagangan',1),(12,'Dokumen','doc_tdp_manage','Mengelola Dokumen ijin TDP',1),(13,'Dokumen','doc_wisata_manage','Mengelola Dokumen ijin Pariwisata',1),(14,'Aplikasi','internal_skpd_manage','Mengelola pengaturan SKPD',1),(15,'Aplikasi','internal_application_manage','Mengelola pengaturan Aplikasi',1),(16,'Aplikasi','internal_security_manage','Mengelola pengaturan Keamanan',1),(17,'Pengguna','users_manage','Mengelola semua pengguna',1),(18,'Pengguna','users_add','Menambahkan pengguna',1),(19,'Pengguna','users_view','Melihat data pengguna',1),(20,'Pengguna','users_edit_self','Mengubah data pengguna',1),(21,'Pengguna','users_edit_other','Mengubah data pengguna lain',1),(22,'Pengguna','perms_manage','Mengelola wewenang pengguna',1),(23,'Pengguna','roles_manage','Mengelola Kelompok pengguna',1),(24,'System','sys_manage','Mengelola internal Sistem',1),(25,'System','sys_backstore_manage','Mengelola backup & restore sistem',1),(26,'System','sys_logs_manage','Memantau Aktifitas internal sistem',1);
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
INSERT INTO `baka_auth_role_permissions` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),(1,13),(1,14),(1,15),(1,16),(1,17),(1,18),(1,19),(1,20),(1,21),(1,22),(1,23),(1,24),(1,25),(1,26),(2,1),(2,10),(2,11),(2,12),(3,1),(3,6),(4,1),(4,2),(4,3),(4,4),(4,5),(4,7),(4,8),(4,9);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_auth_roles`
--

LOCK TABLES `baka_auth_roles` WRITE;
/*!40000 ALTER TABLE `baka_auth_roles` DISABLE KEYS */;
INSERT INTO `baka_auth_roles` VALUES (1,'admin','Administrator','-',0,1,0),(2,'bag_1','Bagian 1','-',0,1,0),(3,'bag_2','Bagian 2','-',0,1,0),(4,'bag_3','Bagian 3','-',0,1,0);
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
INSERT INTO `baka_auth_user_autologin` VALUES ('0222466a3557a6709bf8d00d64fb1fa4',1,'Mozilla/5.0 (Linux; Android 4.1.2; New Andromax-i Build/JZO54K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Mobile Safari/537.36','192.168.1.4','2014-04-14 02:15:53'),('1b10a7388830e193268a3e97e34c642a',1,'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:27.0) Gecko/20100101 Firefox/27.0','127.0.0.1','2014-02-12 03:48:41'),('220a6916dfc89e917fb7243fa4b0ee00',1,'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36','::1','2014-03-25 15:12:16'),('479ffc3b98eda73c47d336763600df68',1,'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.131 Safari/537.36','127.0.0.1','2014-05-09 20:46:29'),('b0fad440e95441fcb7834202ed84f26d',1,'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:28.0) Gecko/20100101 Firefox/28.0','127.0.0.1','2014-04-04 20:52:53'),('f566bd039578924a7e257e68399003c2',1,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36','127.0.0.1','2014-03-10 01:06:53'),('f94205822f0401469ac4172fc475f3c3',1,'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36','127.0.0.1','2014-03-27 20:46:31');
/*!40000 ALTER TABLE `baka_auth_user_autologin` ENABLE KEYS */;
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
INSERT INTO `baka_auth_user_roles` VALUES (1,1),(1,2),(2,2),(5,3);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_auth_usermeta`
--

LOCK TABLES `baka_auth_usermeta` WRITE;
/*!40000 ALTER TABLE `baka_auth_usermeta` DISABLE KEYS */;
INSERT INTO `baka_auth_usermeta` VALUES (1,5,'firstname',''),(2,5,'lastname',''),(3,5,'phone',''),(4,5,'address','');
/*!40000 ALTER TABLE `baka_auth_usermeta` ENABLE KEYS */;
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
INSERT INTO `baka_auth_users` VALUES (1,'admin','$2a$08$LhuaYcUIVOy1tt7CJjyNh.2ECzQcJoeW44d/DSNVRUoFNriUtAyse','administrator@bpmppt.com',1,0,0,NULL,NULL,NULL,NULL,NULL,'127.0.0.1','2014-05-13 03:25:48','2013-10-31 22:07:55','2014-05-12 20:25:48',NULL),(2,'pengguna','$2a$08$ugoMu3b9ULNzFBMHKm1cfeLY57u31iblFe6BQ8eoQ98ifGTEGo5we','pengguna@bpmppt.com',1,0,0,NULL,NULL,NULL,NULL,NULL,'','0000-00-00 00:00:00','2013-11-04 18:29:46','2014-02-06 03:12:42',NULL),(5,'pengguna1','$2a$08$N4sHvUfnm.BKvJxNf6oJEeOqME6J79wZRCBB1cugbDpxAhL7z3dWO','pengguna1@bpmppt.com',1,0,0,NULL,NULL,NULL,NULL,NULL,'127.0.0.1','2014-03-10 05:45:48','2014-03-10 05:45:14','2014-03-09 22:45:48',NULL);
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
INSERT INTO `baka_ci_sessions` VALUES ('01f63df51e333863327f837c35d3cc21','0.0.0.0','0',1399915337,''),('0629477e0505fa4deceacd93d6a9907e','0.0.0.0','0',1399915219,''),('09100cbfcae948df374cedd4b543f358','0.0.0.0','0',1399915336,''),('095651fca581c41dfeaeb44ee3391d02','0.0.0.0','0',1399915220,''),('0e4596028d11912400ce4b677d054300','0.0.0.0','0',1399918200,''),('0eec3f3760b2d844119d4e5310a39063','0.0.0.0','0',1399913842,''),('112f0341d28d9382af6adbf387837d12','0.0.0.0','0',1399915773,''),('2795d03bd419360bcd176b52c53e999a','0.0.0.0','0',1399915895,''),('2941398dfb8d564dadccef37f7294428','0.0.0.0','0',1399918898,''),('302d2e032e38aa644a6d40e285850272','0.0.0.0','0',1399915336,''),('31aeef426f9e33f50394cee40b709721','0.0.0.0','0',1399913690,''),('32a9090b8cedb933b2005cad229da98f','0.0.0.0','0',1399918746,''),('332f4a406918b09f604c50d4dedc36fc','0.0.0.0','0',1399918147,''),('34c64fabc3977479b809b2ff992e5aad','0.0.0.0','0',1399918214,''),('38d9c04820ad88a0664dfb8c24e97bdb','0.0.0.0','0',1399915920,''),('3c824e6e55c0c2739218f5f76361a679','0.0.0.0','0',1399915315,''),('4d21360a3965d93218e4e1889d71e8bc','0.0.0.0','0',1399914501,''),('4e387247914185861e46b91406882857','0.0.0.0','0',1399915921,''),('5bd3b81cbf997f3e4ba94901aeffb350','0.0.0.0','0',1399915772,''),('5dcb878718f92faa44e8d79dbbc78db1','0.0.0.0','0',1399915240,''),('5f7a4b19691da52048bbdc7f9d34a677','0.0.0.0','0',1399916447,''),('60b2e4f26c47a04f8da08cd4d69c3b70','0.0.0.0','0',1399915220,''),('648685d8df76c1e98dc980af676d5d4e','0.0.0.0','0',1399915316,''),('699c688eeafe34941303ff4dc7ecf56c','0.0.0.0','0',1399915283,''),('6e72f80fbfaf64de744317bd3378d6c6','0.0.0.0','0',1399915920,''),('71ad0016e10af750efc8bba525819d93','0.0.0.0','0',1399916901,''),('74bc7065954997a43ebd24249860f739','0.0.0.0','0',1399915283,''),('754798ab4f6d42b3471ded793ccca2d9','0.0.0.0','0',1399915401,''),('789154ae82ff208164774e4549e72526','0.0.0.0','0',1399915400,''),('792a65db63bc91787163c038772affb0','0.0.0.0','0',1399913835,''),('7f08915a1f482c8c326333266e67978d','0.0.0.0','0',1399915781,''),('7f0e5e6cbda43e09daa997ee0d04a520','0.0.0.0','0',1399918250,''),('8efdeab578e9b8e82504d0c02110c7e7','0.0.0.0','0',1399915773,''),('9ce404e96f7ed21447e6c9747c0df927','0.0.0.0','0',1399915282,''),('9d8e94aa8534c1271830511fa2f07615','0.0.0.0','0',1399918296,''),('a6c1a8b0908632d46dfd6156da22edd7','0.0.0.0','0',1399914509,''),('aaddc74ea0d5c3005112e4379662c074','0.0.0.0','0',1399915903,''),('b44b9fbe1e77b12f75088e50256929c3','0.0.0.0','0',1399913807,''),('b5650dff2091664d6295d151334b2ec7','0.0.0.0','0',1399915240,''),('b8273ec94d298483c137021d96e04358','127.0.0.1','Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.131 Safari/537.36',1399926339,'a:5:{s:9:\"user_data\";s:0:\"\";s:7:\"user_id\";s:1:\"1\";s:8:\"username\";s:5:\"admin\";s:6:\"status\";i:1;s:10:\"user_perms\";a:26:{i:1;s:10:\"doc_manage\";i:2;s:8:\"doc_edit\";i:3;s:17:\"doc_lokasi_manage\";i:4;s:18:\"doc_reklame_manage\";i:5;s:13:\"doc_b3_manage\";i:6;s:13:\"doc_ho_manage\";i:7;s:14:\"doc_imb_manage\";i:8;s:15:\"doc_iplc_manage\";i:9;s:14:\"doc_iui_manage\";i:10;s:14:\"doc_iup_manage\";i:11;s:15:\"doc_siup_manage\";i:12;s:14:\"doc_tdp_manage\";i:13;s:17:\"doc_wisata_manage\";i:14;s:20:\"internal_skpd_manage\";i:15;s:27:\"internal_application_manage\";i:16;s:24:\"internal_security_manage\";i:17;s:12:\"users_manage\";i:18;s:9:\"users_add\";i:19;s:10:\"users_view\";i:20;s:15:\"users_edit_self\";i:21;s:16:\"users_edit_other\";i:22;s:12:\"perms_manage\";i:23;s:12:\"roles_manage\";i:24;s:10:\"sys_manage\";i:25;s:20:\"sys_backstore_manage\";i:26;s:15:\"sys_logs_manage\";}}'),('ba0db17b59fc71f439349194a2ece3ae','0.0.0.0','0',1399916711,''),('bf282f9820e039c14470345146b00c0e','0.0.0.0','0',1399915241,''),('bfcd6ca4ffeba28da99f6f0e2249447b','0.0.0.0','0',1399914512,''),('c44eaee2112508c806fa437dff268171','0.0.0.0','0',1399915315,''),('ca7adf4fc390ac6f2bac71c36b40dc60','0.0.0.0','0',1399915920,''),('cccd4971983951a55304e8c64b09cc89','0.0.0.0','0',1399915400,''),('ce1ff69a74f9866be0ec968938e55bde','0.0.0.0','0',1399915315,''),('ce7dc559251a6f50921bf08afa0e83d8','0.0.0.0','0',1399915220,''),('e0e09fc7e1464b4ddaec28e04f859e5b','0.0.0.0','0',1399916799,''),('e1e2b4356b218ac5b56bc6ad6ec2537c','0.0.0.0','0',1399915773,''),('e20feda2ba3b2384dafb471f43c14ac4','0.0.0.0','0',1399929645,''),('e60f9ed6a80b85b9907d199943b5200c','0.0.0.0','0',1399917162,''),('e61ed7c32ee7c27bc51fea42a52ab830','0.0.0.0','0',1399915335,''),('ea0aa77128380a1d52305c620a3ead82','0.0.0.0','0',1399915401,''),('eefad901031c93977da6f584842a4b2f','0.0.0.0','0',1399913453,''),('f201cfe6f4da6e25bff7e9d85565c8b4','0.0.0.0','0',1399915879,''),('f345d70d4b2a740ce90e9f2c4f670576','0.0.0.0','0',1399918099,''),('f51d7a20809e062800354a1cf0405c81','0.0.0.0','0',1399915283,''),('fd825b95532d62ab6e1439cdca2a342d','0.0.0.0','0',1399915241,'');
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_data`
--

LOCK TABLES `baka_data` WRITE;
/*!40000 ALTER TABLE `baka_data` DISABLE KEYS */;
INSERT INTO `baka_data` VALUES (1,'swfrwe','2014-02-20 01:03:48',1,'izin_pengelolaan_b3','-','swdf ','pending','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL),(2,'510.8','2014-02-20 01:18:58',1,'izin_reklame','-','Khaerul Ashar','pending','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL),(3,'510.8','2014-02-20 01:44:32',1,'izin_reklame','-','sadf asdf','pending','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL),(4,'510','2014-02-20 03:26:57',1,'izin_pembuangan_air_limbah','-','Nama Lengkap','pending','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL),(5,'614','2014-03-07 23:37:55',1,'izin_mendirikan_bangunan','-','Nama Lengkap','pending','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL),(6,'123','2014-03-08 00:09:10',1,'izin_pengelolaan_b3','-','Nama Lengkap','deleted','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-04-05 01:34:50','a:1:{i:0;a:3:{s:7:\"user_id\";s:1:\"1\";s:4:\"date\";s:19:\"2014-04-05 01:34:50\";s:7:\"message\";s:39:\"Mengubah status dokumen menjadi Dihapus\";}}'),(7,'123','2014-03-08 00:45:27',1,'izin_pengelolaan_b3','-','Nama Lengkap','pending','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL),(8,'123','2014-03-08 01:19:22',1,'izin_gangguan','-','Nama Lengkap','pending','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL),(9,'123','2014-03-08 02:19:42',1,'izin_lokasi','-','Nama Pemohon','pending','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL),(10,'123','2014-03-10 00:00:25',1,'izin_usaha_pertambangan','-','Nama Lengkap','deleted','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-03-10 00:01:29','a:1:{i:0;a:3:{s:7:\"user_id\";s:1:\"1\";s:4:\"date\";s:19:\"2014-03-10 00:01:29\";s:7:\"message\";s:39:\"Mengubah status dokumen menjadi Dihapus\";}}'),(11,'123','2014-03-10 00:02:17',1,'izin_usaha_pertambangan','-','Nama Lengkap','deleted','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-03-10 01:01:46','a:1:{i:0;a:3:{s:7:\"user_id\";s:1:\"1\";s:4:\"date\";s:19:\"2014-03-10 01:01:46\";s:7:\"message\";s:39:\"Mengubah status dokumen menjadi Dihapus\";}}'),(12,'123','2014-03-10 00:45:38',1,'izin_usaha_pertambangan','-','Nama Lengkap','deleted','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-03-10 01:01:50','a:1:{i:0;a:3:{s:7:\"user_id\";s:1:\"1\";s:4:\"date\";s:19:\"2014-03-10 01:01:50\";s:7:\"message\";s:39:\"Mengubah status dokumen menjadi Dihapus\";}}'),(13,'123','2014-03-10 01:01:22',1,'izin_usaha_pertambangan','-','Nama Lengkap','pending','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL),(14,'123','2014-03-10 01:10:48',1,'izin_usaha_pertambangan','-','Nama Lengkap','pending','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL),(15,'123','2014-03-10 01:25:21',1,'izin_usaha_pertambangan','-','Nama Lengkap','pending','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL),(16,'123','2014-05-02 11:25:29',1,'izin_lokasi','-','nama lengkap','pending','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL);
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
  `data_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `meta_key` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `meta_value` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=244 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_data_meta`
--

LOCK TABLES `baka_data_meta` WRITE;
/*!40000 ALTER TABLE `baka_data_meta` DISABLE KEYS */;
INSERT INTO `baka_data_meta` VALUES (1,1,'izin_pengelolaan_b3','izin_pengelolaan_b3_surat_nomor','swfrwe'),(2,1,'izin_pengelolaan_b3','izin_pengelolaan_b3_surat_tanggal','2014-02-20'),(3,1,'izin_pengelolaan_b3','izin_pengelolaan_b3_pemohon_nama','swdf '),(4,1,'izin_pengelolaan_b3','izin_pengelolaan_b3_pemohon_alamat','wdf g'),(5,1,'izin_pengelolaan_b3','izin_pengelolaan_b3_pemohon_jabatan','wdf '),(6,1,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_nama','dwfg'),(7,1,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_bidang','wdf g'),(8,1,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_alamat','wqd g'),(9,1,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_lokasi','wdf g'),(10,1,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_kontak_telp','wdfg'),(11,1,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_kontak_fax','qgfwdfg'),(12,1,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_tps_fungsi','wdfgwdf'),(13,1,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_tps_ukuran','wdf gwdfg'),(14,1,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_tps_koor_s','dswfgq'),(15,1,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_tps_koor_e','sdf g'),(16,2,'izin_reklame','izin_reklame_surat_nomor','510.8'),(17,2,'izin_reklame','izin_reklame_surat_tanggal','2014-02-20'),(18,2,'izin_reklame','izin_reklame_pemohon_nama','Khaerul Ashar'),(19,2,'izin_reklame','izin_reklame_pemohon_kerja','kerja'),(20,2,'izin_reklame','izin_reklame_pemohon_alamat','Kajen'),(21,2,'izin_reklame','izin_reklame_pemohon_telp','98765678987'),(22,2,'izin_reklame','izin_reklame_lokasi_jenis','PENERIMAAN MAHASISWA BARU'),(23,2,'izin_reklame','izin_reklame_reklame_juml','2'),(24,2,'izin_reklame','izin_reklame_reklame_lokasi','kAJEN'),(25,2,'izin_reklame','izin_reklame_reklame_ukuran_panjang','3'),(26,2,'izin_reklame','izin_reklame_reklame_ukuran_lebar','3'),(27,2,'izin_reklame','izin_reklame_reklame_range_tgl_mulai','20-02-2014'),(28,2,'izin_reklame','izin_reklame_reklame_range_tgl_selesai','15-03-2014'),(29,2,'izin_reklame','izin_reklame_reklame_tema','PENERIMAAN MAHASISWA BARU'),(30,2,'izin_reklame','izin_reklame_reklame_ket','-'),(31,3,'izin_reklame','izin_reklame_surat_nomor','510.8'),(32,3,'izin_reklame','izin_reklame_surat_tanggal','2014-02-20'),(33,3,'izin_reklame','izin_reklame_pemohon_nama','sadf asdf'),(34,3,'izin_reklame','izin_reklame_pemohon_kerja','kerja'),(35,3,'izin_reklame','izin_reklame_pemohon_alamat','sdf gsdf gsdfg'),(36,3,'izin_reklame','izin_reklame_pemohon_telp',''),(37,3,'izin_reklame','izin_reklame_reklame_jenis','jenus'),(38,3,'izin_reklame','izin_reklame_reklame_juml','3'),(39,3,'izin_reklame','izin_reklame_reklame_lokasi','sdfg'),(40,3,'izin_reklame','izin_reklame_reklame_ukuran_panjang','2'),(41,3,'izin_reklame','izin_reklame_reklame_ukuran_lebar','3'),(42,3,'izin_reklame','izin_reklame_reklame_range_tgl_mulai','15-01-2014'),(43,3,'izin_reklame','izin_reklame_reklame_range_tgl_selesai','15-02-2014'),(44,3,'izin_reklame','izin_reklame_reklame_tema','f fdgsd'),(45,3,'izin_reklame','izin_reklame_reklame_ket','sdf gb'),(46,3,'izin_reklame','izin_reklame',''),(47,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_surat_nomor','510'),(48,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_surat_tanggal','2014-02-20'),(49,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_pemohon_nama','Nama Lengkap'),(50,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_pemohon_jabatan','jabatan'),(51,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_pemohon_usaha','nama Perushaaan'),(52,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_pemohon_alamat','Alamat'),(53,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kapasitas_produksi','1000'),(54,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_debit_max_proses','100'),(55,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_debit_max_kond','100'),(56,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_proses_bod','9'),(57,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_proses_cod','9'),(58,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_proses_tts','9'),(59,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_proses_minyak','9'),(60,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_proses_sulfida','9'),(61,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_proses_ph','9'),(62,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_proses_bod','9'),(63,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_proses_cod','9'),(64,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_proses_tts','9'),(65,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_proses_minyak','9'),(66,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_proses_sulfida','9'),(67,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_proses_ph','9'),(68,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_kond_bod','9'),(69,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_kond_cod','9'),(70,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_kond_tts','9'),(71,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_kond_minyak','9'),(72,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_kond_sulfida','9'),(73,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_kadar_max_kond_ph','9'),(74,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_kond_bod','9'),(75,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_kond_cod','9'),(76,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_kond_tts','9'),(77,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_kond_minyak','9'),(78,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_kond_sulfida','9'),(79,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_beban_max_kond_ph','9'),(80,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah_limbah_target_buang','Dimana aja'),(81,4,'izin_pembuangan_air_limbah','izin_pembuangan_air_limbah',''),(82,5,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_bangunan_maksud','baru'),(83,5,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_bangunan_guna','rumah'),(84,5,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_pemohon_nama','Nama Lengkap'),(85,5,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_pemohon_kerja','Pekerjaan'),(86,5,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_pemohon_alamat','Alamat'),(87,5,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_bangunan_lokasi','Lokasi Bangunan'),(88,5,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_bangunan_tanah_luas','100'),(89,5,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_bangunan_tanah_keadaan','d1'),(90,5,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_bangunan_tanah_status','hm'),(91,5,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_bangunan_milik_no','123456'),(92,5,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_bangunan_milik_an','Atas Nama'),(93,5,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_bangunan_luas','100'),(94,5,'izin_mendirikan_bangunan','izin_mendirikan_bangunan_surat_nomor','614'),(95,5,'izin_mendirikan_bangunan','izin_mendirikan_bangunan',''),(96,6,'izin_pengelolaan_b3','izin_pengelolaan_b3_surat_nomor','123'),(97,6,'izin_pengelolaan_b3','izin_pengelolaan_b3_surat_tanggal','2014-03-08'),(98,6,'izin_pengelolaan_b3','izin_pengelolaan_b3_pemohon_nama','Nama Lengkap'),(99,6,'izin_pengelolaan_b3','izin_pengelolaan_b3_pemohon_alamat','Alamat Lengkap'),(100,6,'izin_pengelolaan_b3','izin_pengelolaan_b3_pemohon_jabatan','Jabatan'),(101,6,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_nama','Nama Perusahaan'),(102,6,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_bidang','Bidang Usaha'),(103,6,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_alamat','Alamat lengkap Kantor'),(104,6,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_lokasi','Lokasi Usaha'),(105,6,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_kontak_telp','012345789'),(106,6,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_kontak_fax',''),(107,6,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_tps_fungsi','Ket. Fungsi'),(108,6,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_tps_ukuran','Ukuran'),(109,6,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_tps_koor_s','12345'),(110,6,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_tps_koor_e','12345'),(111,6,'izin_pengelolaan_b3','izin_pengelolaan_b3',''),(112,7,'izin_pengelolaan_b3','izin_pengelolaan_b3_surat_nomor','123'),(113,7,'izin_pengelolaan_b3','izin_pengelolaan_b3_surat_tanggal','2014-03-08'),(114,7,'izin_pengelolaan_b3','izin_pengelolaan_b3_pemohon_nama','Nama Lengkap'),(115,7,'izin_pengelolaan_b3','izin_pengelolaan_b3_pemohon_alamat','Alamat Lengkap'),(116,7,'izin_pengelolaan_b3','izin_pengelolaan_b3_pemohon_jabatan','Jabatan'),(117,7,'izin_pengelolaan_b3','izin_pengelolaan_b3_daftar_nomor','321/32/321'),(118,7,'izin_pengelolaan_b3','izin_pengelolaan_b3_daftar_tanggal','08-03-2014'),(119,7,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_nama','Nama Perusahaan'),(120,7,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_bidang','Bidang Usaha'),(121,7,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_alamat','Alamat Kantor'),(122,7,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_lokasi','Lokasi Usaha'),(123,7,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_kontak_telp','321'),(124,7,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_kontak_fax',''),(125,7,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_tps_fungsi','Ket. Fungsi'),(126,7,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_tps_ukuran','Ukuran'),(127,7,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_tps_koor_s','123'),(128,7,'izin_pengelolaan_b3','izin_pengelolaan_b3_usaha_tps_koor_e','456'),(129,7,'izin_pengelolaan_b3','izin_pengelolaan_b3',''),(130,8,'izin_gangguan','izin_gangguan_surat_nomor','123'),(131,8,'izin_gangguan','izin_gangguan_surat_tanggal','2014-03-08'),(132,8,'izin_gangguan','izin_gangguan_surat_jenis_pengajuan','br'),(133,8,'izin_gangguan','izin_gangguan_pemohon_nama','Nama Lengkap'),(134,8,'izin_gangguan','izin_gangguan_pemohon_kerja','Pekerjaan'),(135,8,'izin_gangguan','izin_gangguan_pemohon_alamat','Alamat'),(136,8,'izin_gangguan','izin_gangguan_pemohon_telp','123456'),(137,8,'izin_gangguan','izin_gangguan_usaha_nama','Nama Perusahaan'),(138,8,'izin_gangguan','izin_gangguan_usaha_jenis','Jenis Usaha'),(139,8,'izin_gangguan','izin_gangguan_usaha_alamat','Alamat Kantor'),(140,8,'izin_gangguan','izin_gangguan_usaha_lokasi','Lokasi Usaha'),(141,8,'izin_gangguan','izin_gangguan_usaha_luas','123'),(142,8,'izin_gangguan','izin_gangguan_usaha_pekerja','12'),(143,8,'izin_gangguan','izin_gangguan_usaha_tetangga_timur','asdf'),(144,8,'izin_gangguan','izin_gangguan_usaha_tetangga_utara','wqer'),(145,8,'izin_gangguan','izin_gangguan_usaha_tetangga_selatan','xsczv'),(146,8,'izin_gangguan','izin_gangguan_usaha_tetangga_barat','ljkoh'),(147,8,'izin_gangguan','izin_gangguan',''),(148,9,'izin_lokasi','izin_lokasi_surat_nomor','123'),(149,9,'izin_lokasi','izin_lokasi_surat_tanggal','2014-03-08'),(150,9,'izin_lokasi','izin_lokasi_pemohon_nama','Nama Pemohon'),(151,9,'izin_lokasi','izin_lokasi_pemohon_jabatan','Jabatan'),(152,9,'izin_lokasi','izin_lokasi_pemohon_usaha','Perusahaan'),(153,9,'izin_lokasi','izin_lokasi_pemohon_alamat','Alamat'),(154,9,'izin_lokasi','izin_lokasi_lokasi_tujuan','Pembangunan sesuatu'),(155,9,'izin_lokasi','izin_lokasi_lokasi_alamat','Alamat Pekerjaan'),(156,9,'izin_lokasi','izin_lokasi_lokasi_nama','123'),(157,9,'izin_lokasi','izin_lokasi_lokasi_area_hijau','62 : 35 %'),(158,9,'izin_lokasi','izin_lokasi',''),(159,10,'izin_usaha_pertambangan','izin_usaha_pertambangan_surat_nomor','123'),(160,10,'izin_usaha_pertambangan','izin_usaha_pertambangan_surat_tanggal','2014-03-09'),(161,10,'izin_usaha_pertambangan','izin_usaha_pertambangan_rekomendasi_nomor','123'),(162,10,'izin_usaha_pertambangan','izin_usaha_pertambangan_rekomendasi_tanggal','2014-03-09'),(163,10,'izin_usaha_pertambangan','izin_usaha_pertambangan_pemohon_nama','Nama Lengkap'),(164,10,'izin_usaha_pertambangan','izin_usaha_pertambangan_pemohon_alamat','Alamat'),(165,10,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_waktu_nomor','09-03-2014'),(166,10,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_waktu_tanggal','2014-03-24'),(167,10,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_jns_galian','Jenis Galian'),(168,10,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_luas','123'),(169,10,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_alamat','Lokasi Galian'),(170,10,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_koor','0'),(171,10,'izin_usaha_pertambangan','izin_usaha_pertambangan',''),(172,11,'izin_usaha_pertambangan','izin_usaha_pertambangan_surat_nomor','123'),(173,11,'izin_usaha_pertambangan','izin_usaha_pertambangan_surat_tanggal','2014-03-10'),(174,11,'izin_usaha_pertambangan','izin_usaha_pertambangan_rekomendasi_nomor','123'),(175,11,'izin_usaha_pertambangan','izin_usaha_pertambangan_rekomendasi_tanggal','2014-03-10'),(176,11,'izin_usaha_pertambangan','izin_usaha_pertambangan_pemohon_nama','Nama Lengkap'),(177,11,'izin_usaha_pertambangan','izin_usaha_pertambangan_pemohon_alamat','Alamat Lengkap'),(178,11,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_waktu_mulai','10-03-2014'),(179,11,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_waktu_selesai','2014-03-10'),(180,11,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_jns_galian','Jenis'),(181,11,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_luas','213'),(182,11,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_alamat','Alamat Galian'),(183,11,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_koor','0'),(184,11,'izin_usaha_pertambangan','izin_usaha_pertambangan',''),(185,12,'izin_usaha_pertambangan','izin_usaha_pertambangan_surat_nomor','123'),(186,12,'izin_usaha_pertambangan','izin_usaha_pertambangan_surat_tanggal','2014-03-10'),(187,12,'izin_usaha_pertambangan','izin_usaha_pertambangan_rekomendasi_nomor','123'),(188,12,'izin_usaha_pertambangan','izin_usaha_pertambangan_rekomendasi_tanggal','2014-03-10'),(189,12,'izin_usaha_pertambangan','izin_usaha_pertambangan_pemohon_nama','Nama Lengkap'),(190,12,'izin_usaha_pertambangan','izin_usaha_pertambangan_pemohon_alamat','Alamat Lengkap 2'),(191,12,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_waktu_mulai','10-03-2014'),(192,12,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_waktu_selesai','2014-03-10'),(193,12,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_jns_galian','Jenis Galian'),(194,12,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_luas','123'),(195,12,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_alamat','Lokasi'),(196,12,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_koor','N;'),(197,12,'izin_usaha_pertambangan','izin_usaha_pertambangan',''),(198,13,'izin_usaha_pertambangan','izin_usaha_pertambangan_surat_nomor','123'),(199,13,'izin_usaha_pertambangan','izin_usaha_pertambangan_surat_tanggal','2014-03-10'),(200,13,'izin_usaha_pertambangan','izin_usaha_pertambangan_rekomendasi_nomor','123'),(201,13,'izin_usaha_pertambangan','izin_usaha_pertambangan_rekomendasi_tanggal','2014-03-10'),(202,13,'izin_usaha_pertambangan','izin_usaha_pertambangan_pemohon_nama','Nama Lengkap'),(203,13,'izin_usaha_pertambangan','izin_usaha_pertambangan_pemohon_alamat','Alamat'),(204,13,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_waktu_mulai','10-03-2014'),(205,13,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_waktu_selesai','2014-03-10'),(206,13,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_jns_galian','Jenis Galian'),(207,13,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_luas','123'),(208,13,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_alamat','Lokasi Galian'),(209,13,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_koor','a:1:{i:0;a:8:{s:2:\"no\";s:1:\"2\";s:4:\"gb-1\";s:1:\"2\";s:4:\"gb-2\";s:1:\"2\";s:4:\"gb-3\";s:1:\"2\";s:4:\"gl-1\";s:1:\"2\";s:4:\"gl-2\";s:1:\"2\";s:4:\"gl-3\";s:1:\"2\";s:3:\"lsu\";s:1:\"2\";}}'),(210,14,'izin_usaha_pertambangan','izin_usaha_pertambangan_surat_nomor','123'),(211,14,'izin_usaha_pertambangan','izin_usaha_pertambangan_surat_tanggal','2014-03-10'),(212,14,'izin_usaha_pertambangan','izin_usaha_pertambangan_rekomendasi_nomor','123'),(213,14,'izin_usaha_pertambangan','izin_usaha_pertambangan_rekomendasi_tanggal','2014-03-10'),(214,14,'izin_usaha_pertambangan','izin_usaha_pertambangan_pemohon_nama','Nama Lengkap'),(215,14,'izin_usaha_pertambangan','izin_usaha_pertambangan_pemohon_alamat','Alamat Lengkap'),(216,14,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_waktu_mulai','10-03-2014'),(217,14,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_waktu_selesai','2014-03-10'),(218,14,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_jns_galian','Jenis Galian'),(219,14,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_luas','123'),(220,14,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_alamat','Lokasi'),(221,14,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_koor','a:1:{i:0;a:8:{s:2:\"no\";s:1:\"3\";s:4:\"gb-1\";s:1:\"3\";s:4:\"gb-2\";s:1:\"3\";s:4:\"gb-3\";s:1:\"3\";s:4:\"gl-1\";s:1:\"3\";s:4:\"gl-2\";s:1:\"3\";s:4:\"gl-3\";s:1:\"3\";s:3:\"lsu\";s:1:\"3\";}}'),(222,15,'izin_usaha_pertambangan','izin_usaha_pertambangan_surat_nomor','123'),(223,15,'izin_usaha_pertambangan','izin_usaha_pertambangan_surat_tanggal','2014-03-10'),(224,15,'izin_usaha_pertambangan','izin_usaha_pertambangan_rekomendasi_nomor','1321'),(225,15,'izin_usaha_pertambangan','izin_usaha_pertambangan_rekomendasi_tanggal','2014-03-10'),(226,15,'izin_usaha_pertambangan','izin_usaha_pertambangan_pemohon_nama','Nama Lengkap'),(227,15,'izin_usaha_pertambangan','izin_usaha_pertambangan_pemohon_alamat','Alamat Lengkap'),(228,15,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_waktu_mulai','10-03-2014'),(229,15,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_waktu_selesai','2014-03-10'),(230,15,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_jns_galian','Jenis Galian'),(231,15,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_luas','12345'),(232,15,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_alamat','Lokasi Galian'),(233,15,'izin_usaha_pertambangan','izin_usaha_pertambangan_tambang_koor','a:3:{i:0;a:8:{s:2:\"no\";s:1:\"1\";s:4:\"gb-1\";s:1:\"1\";s:4:\"gb-2\";s:1:\"1\";s:4:\"gb-3\";s:1:\"1\";s:4:\"gl-1\";s:1:\"1\";s:4:\"gl-2\";s:1:\"1\";s:4:\"gl-3\";s:1:\"1\";s:3:\"lsu\";s:1:\"1\";}i:1;a:8:{s:2:\"no\";s:1:\"2\";s:4:\"gb-1\";s:1:\"2\";s:4:\"gb-2\";s:1:\"2\";s:4:\"gb-3\";s:1:\"2\";s:4:\"gl-1\";s:1:\"2\";s:4:\"gl-2\";s:1:\"2\";s:4:\"gl-3\";s:1:\"2\";s:3:\"lsu\";s:1:\"2\";}i:2;a:8:{s:2:\"no\";s:2:\"33\";s:4:\"gb-1\";s:1:\"3\";s:4:\"gb-2\";s:1:\"3\";s:4:\"gb-3\";s:1:\"3\";s:4:\"gl-1\";s:1:\"3\";s:4:\"gl-2\";s:1:\"3\";s:4:\"gl-3\";s:1:\"3\";s:3:\"lsu\";s:1:\"3\";}}'),(234,16,'izin_lokasi','izin_lokasi_surat_nomor','123'),(235,16,'izin_lokasi','izin_lokasi_surat_tanggal','2014-05-02'),(236,16,'izin_lokasi','izin_lokasi_pemohon_nama','nama lengkap'),(237,16,'izin_lokasi','izin_lokasi_pemohon_jabatan','jabatan '),(238,16,'izin_lokasi','izin_lokasi_pemohon_usaha','perusahaan'),(239,16,'izin_lokasi','izin_lokasi_pemohon_alamat','alamat lengkap'),(240,16,'izin_lokasi','izin_lokasi_lokasi_tujuan','tujuan permohonan '),(241,16,'izin_lokasi','izin_lokasi_lokasi_alamat','lokasi permohonan'),(242,16,'izin_lokasi','izin_lokasi_lokasi_luas','luas area'),(243,16,'izin_lokasi','izin_lokasi_lokasi_area_hijau','area hijau');
/*!40000 ALTER TABLE `baka_data_meta` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `baka_data_props` VALUES (1,'bentuk_usaha','Koperasi','Koperasi'),(2,'bentuk_usaha','pt','Perseroan Terbatas (PT)'),(3,'bentuk_usaha','bumn','Badan Usaha Milik Negara (BUMN)'),(4,'bentuk_usaha','po','Perorangan'),(5,'bentuk_usaha','cv','Perseroan Komanditer (CV)'),(6,'jenis_usaha','swasta','Swasta'),(7,'jenis_usaha','swasta-tbk','Swasta Tbk/Go Publik'),(8,'jenis_usaha','persero','Persero'),(9,'jenis_usaha','persero-tbk','Persero Tbk/Go Publik'),(10,'jenis_usaha','persh','Persh Daerah'),(11,'jenis_usaha','persh-tbk','Persh Daerah Tbk/Go Publik'),(12,'milik_bangunan','pinjam','Pinjam Pakai'),(13,'milik_bangunan','kontrak','Kontrak'),(14,'milik_bangunan','sewa','Sewa'),(15,'milik_bangunan','milik','Milik Sendiri'),(16,'kerjasama','mandiri','Mandiri'),(17,'kerjasama','kso','KSO'),(18,'kerjasama','wla','Waralaba Nasional'),(19,'kerjasama','wli','Waralaba Internasional'),(20,'kerjasama','ja','Jaringan Nasional'),(21,'kerjasama','ji','Jaringan Internasional'),(22,'koperasi','jasa','Jasa'),(23,'koperasi','pemasaran','Pemasaran'),(24,'koperasi','produsen','Produsen'),(25,'koperasi','konsumen','Konsumen'),(26,'koperasi','simpan','Simpan Pinjam'),(27,'koperasi','lainya','Lainya'),(28,'kwn','wna','Warga Negara Asing'),(29,'kwn','wni','Warga Negara Indonesia'),(30,'modal','pma','Penanaman Modal Asing'),(31,'modal','pmdn','Penanaman Modal Dalam Negeri'),(32,'modal','lain','Lainya'),(33,'pengajuan','baru','Pendaftaran Baru'),(34,'pengajuan','pembaruan','Daftar Ulang'),(35,'pengajuan','perubahan','Balik Nama'),(36,'rantai_dagang','produsen','Produsen'),(37,'rantai_dagang','exportir','Exportir'),(38,'rantai_dagang','importir','Importir'),(39,'rantai_dagang','dist','Distributor/Wholesaler/Grosir'),(40,'rantai_dagang','sub-dist','Sub Distributor'),(41,'rantai_dagang','agen','Agen'),(42,'rantai_dagang','pengecer','Pengecer'),(43,'status_usaha','tunggal','Kantor Tunggal'),(44,'status_usaha','pusat','Kantor Pusat'),(45,'status_usaha','cabang','Kantor Cabang'),(46,'status_usaha','pembantu','Kantor Pembantu'),(47,'status_usaha','perwakilan','Kantor Perwakilan'),(48,'sub_pariwisata','bpw','Jasa Biro Perjalanan Wisata'),(49,'sub_pariwisata','apw','Jasa Agen Perjalanan Wisata'),(50,'sub_pariwisata','jpw','Jasa Pramu-wisata'),(51,'sub_pariwisata','konvensi','Jasa Konvensi, perjalanan insentif dan pameran'),(52,'sub_pariwisata','konsul-wisata','Jasa Konsultan Pariwisata'),(53,'sub_pariwisata','io','Jasa Impresariat'),(54,'sub_pariwisata','info-wisata','Jasa Informasi Pariwisata'),(55,'sub_pariwisata','rekreasi','Taman Rekreasi'),(56,'sub_pariwisata','renang','Gelanggang renang'),(57,'sub_pariwisata','pemancingan','Kolam Pemancingan'),(58,'sub_pariwisata','permainan','Gelanggang Permainan dan Ketangka-san'),(59,'sub_pariwisata','billyard','Rumah Billyard'),(60,'sub_pariwisata','bioskop','Bioskop'),(61,'sub_pariwisata','atraksi','Atraksi wisata'),(62,'sub_pariwisata','rm','Rumah makan'),(63,'sub_pariwisata','hotel','Hotel/Losmen/Villa/Cottage/Pesanggra-han'),(64,'sub_pariwisata','pondok','Pondok wisata'),(65,'sub_pariwisata','karaoke','Karaoke'),(66,'sub_pariwisata','dufan','Dunia fantasi'),(67,'sub_pariwisata','seni','Pusat Seni dan Pameran'),(68,'sub_pariwisata','satwa','Taman Satwa dan pentas satwa'),(69,'sub_pariwisata','fitness','Fitness Centre'),(70,'sub_pariwisata','salon','Salon Kecantikan'),(71,'sub_pariwisata','mandala','Mandala Wisata'),(72,'sub_pariwisata','cafetaria','Cafetaria'),(73,'sub_pariwisata','game','Video Game/Play Station'),(74,'sub_pariwisata','golf','Padang Golf'),(75,'sub_pariwisata','kemah','Bumi Perkemahan'),(76,'bentuk_toko','toko','Toko/Kios'),(77,'bentuk_toko','toserba','Toserba/Departemen Store'),(78,'bentuk_toko','swalayan','Swalayan/Supermarket'),(79,'bentuk_toko','lainya','Lainya'),(80,'pekerjaan','pengangguran','Belum/Tidak bekerja'),(81,'pekerjaan','rumah-tangga','Mengurus rumah tangga'),(82,'pekerjaan','pelajar','Pelajar/Mahasiswa'),(83,'pekerjaan','pensiun','Pensiun'),(84,'pekerjaan','sipil','Pegawai Negeri Sipil'),(85,'pekerjaan','tni','Tentara Nasional Indonesia'),(86,'pekerjaan','polisi','Kepolisian RI'),(87,'pekerjaan','petani','Petani/pekebun'),(88,'pekerjaan','peternak','Peternak'),(89,'pekerjaan','nelayan','Nelayan/perikanan'),(90,'pekerjaan','industri','Industri'),(91,'pekerjaan','konstruksi','Konstruksi'),(92,'pekerjaan','transportasi','Transportasi'),(93,'pekerjaan','swasta','Karyawan Swasta'),(94,'pekerjaan','bumn','Karyawan BUMN'),(95,'pekerjaan','bumd','Karyawan BUMD'),(96,'pekerjaan','honorer','Karyawan Honorer'),(97,'pekerjaan','buruh-lepas','Buruh harian lepas'),(98,'pekerjaan','buruh-tani','Buruh tani/perkebunan'),(99,'pekerjaan','buruh-nelayan','Buruh nelayan/perikanan'),(100,'pekerjaan','buruh-ternak','Buruh peternakan'),(101,'pekerjaan','prt','Pembantu rumah tangga'),(102,'pekerjaan','tkg-cukur','Tukang cukur'),(103,'pekerjaan','tkg-listrik','Tukang listrik'),(104,'pekerjaan','tkg-batu','Tukang batu'),(105,'pekerjaan','tkg-kayu','Tukang kayu'),(106,'pekerjaan','tkg-sol','Tukang sol sepatu'),(107,'pekerjaan','tkg-las','Tukang las/pandai besi'),(108,'pekerjaan','tkg-jahit','Tukang jahit'),(109,'pekerjaan','tkg-Rambut','Penata Rambut'),(110,'pekerjaan','tkg-rias','Penata rias'),(111,'pekerjaan','tkg-busana','Penata busana'),(112,'pekerjaan','tkg-gigi','Tukang gigi'),(113,'pekerjaan','mekanik','Mekanik'),(114,'pekerjaan','seniman','Seniman'),(115,'pekerjaan','tabib','Tabib'),(116,'pekerjaan','peraji','Peraji'),(117,'pekerjaan','perancang','Perancang busana'),(118,'pekerjaan','penerjemah','Penerjemah'),(119,'pekerjaan','imam','Imam masjid'),(120,'pekerjaan','pendeta','Pendeta'),(121,'pekerjaan','pastur','Pastur'),(122,'pekerjaan','wartawan','Wartawan'),(123,'pekerjaan','ustad','Ustad/mubaligh'),(124,'pekerjaan','juru','Juru masak'),(125,'pekerjaan','promotor','Promotor acara'),(126,'pekerjaan','anggota','Anggota DPD'),(127,'pekerjaan','anggota','Anggota BPK'),(128,'pekerjaan','bupati','Bupati'),(129,'pekerjaan','wakil','Wakil Bupati'),(130,'pekerjaan','walikota','Walikota'),(131,'pekerjaan','wakil','Wakil Walikota'),(132,'pekerjaan','anggota','Anggota DPRD Propinsi'),(133,'pekerjaan','anggota','Anggota DPRD Kab/Kota'),(134,'pekerjaan','dosen','Dosen'),(135,'pekerjaan','guru','Guru'),(136,'pekerjaan','pilot','Pilot'),(137,'pekerjaan','pengacara','Pengacara'),(138,'pekerjaan','notaris','Notaris'),(139,'pekerjaan','arsitek','Arsitek'),(140,'pekerjaan','akuntan','Akuntan'),(141,'pekerjaan','konsultan','Konsultan'),(142,'pekerjaan','dokter','Dokter'),(143,'pekerjaan','bidan','Bidan'),(144,'pekerjaan','perawat','Perawat'),(145,'pekerjaan','apoteker','Apoteker'),(146,'pekerjaan','psikiater','Psikiater/Psikolog'),(147,'pekerjaan','penyiar','Penyiar televisi'),(148,'pekerjaan','penyiar','Penyiar radio'),(149,'pekerjaan','pelaut','Pelaut'),(150,'pekerjaan','peneliti','Peneliti'),(151,'pekerjaan','sopir','Sopir'),(152,'pekerjaan','pialang','Pialang'),(153,'pekerjaan','paranormal','Paranormal'),(154,'pekerjaan','pedagang','Pedagang'),(155,'pekerjaan','perangkat','Perangkat Desa'),(156,'pekerjaan','kepala','Kepala Desa'),(157,'pekerjaan','biarawati','Biarawati'),(158,'jabatan','kepala','Kepala/Pimpinan'),(159,'jabatan','sekretaris','Sekretaris'),(160,'jabatan','kabid','Kepala Bidang'),(161,'jabatan','kasubbid','Kepala Sub Bidang'),(162,'jabatan','kabag','Kepala Bagian'),(163,'jabatan','kasubbag','Kepala Sub Bagian'),(164,'jabatan','staf','Staf'),(165,'bagian','bpmppt','BPM PTT'),(166,'bagian','keuangan','Keuangan'),(167,'bagian','pengendalian','Pengendalian'),(168,'bagian','program','Program'),(169,'bagian','layanan','Pelayanan'),(170,'bagian','layanan-info','Pelayanan Informasi'),(171,'bagian','layanan-izin','Pelayanan Perizinan'),(172,'bagian','layanan-nonizin','Pelayanan Non Perizinan'),(173,'bagian','pengelolaan-sd','Pengelolaan, Pelayanan Sistem dan Data'),(174,'bagian','modal','Penanaman Modal'),(175,'bagian','umum','Umum dan Kepegawaian'),(176,'bagian','promosi','Promosi dan Kerjasama'),(177,'bagian','info-pengaduan','Informasi dan Pengaduan'),(178,'skala_usaha','usaha-kecil','Perusahaan Kecil'),(179,'skala_usaha','usaha_menengah','Perusahaan Menengah'),(180,'skala_usaha','usaha_besar','Perusahaan Besar'),(181,'milik_tanah','hak_milik','Hak Milik'),(182,'milik_tanah','hak_guna','Hak Guna Bangunan');
/*!40000 ALTER TABLE `baka_data_props` ENABLE KEYS */;
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
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mime` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `ext` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(11) NOT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `attached` tinyint(1) DEFAULT NULL,
  `attached_to` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
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
  `env_key` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `env_value` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
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
  `opt_key` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `opt_value` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `opt_key_UNIQUE` (`opt_key`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baka_system_opt`
--

LOCK TABLES `baka_system_opt` WRITE;
/*!40000 ALTER TABLE `baka_system_opt` DISABLE KEYS */;
INSERT INTO `baka_system_opt` VALUES (1,'skpd_name','Badan Penanaman Modal dan Pelayanan Perijinan Terpadu'),(2,'skpd_address','Jalan Mandurejo'),(3,'skpd_city','Kabupaten Pekalongan'),(4,'skpd_prov','Jawa Tengah'),(5,'skpd_telp','(0285) 381992'),(6,'skpd_fax','(0285) 381992'),(7,'skpd_pos','54322'),(8,'skpd_web','http://bpmppt.kab-pekalongan.go.id'),(9,'skpd_email','contact@bpmppt.kab-pekalongan.go.id'),(10,'skpd_logo','application/storage/upload/logo_cetak.png'),(11,'skpd_lead_name','M. JANU HARYANTO,SH.MH'),(12,'skpd_lead_nip','19570126 198007 1 001'),(13,'skpd_kab','Kajen'),(14,'app_data_show_limit','10'),(15,'app_date_format','j F Y'),(16,'app_datetime_format','j F Y\\,\\  H:i:s'),(17,'app_fieldset_email','0'),(18,'auth_username_min_length','4'),(19,'auth_username_max_length','20'),(20,'auth_password_min_length','4'),(21,'auth_password_max_length','20'),(22,'auth_allow_registration','1'),(23,'auth_captcha_registration','1'),(24,'auth_email_activation','0'),(25,'auth_email_act_expire','172800'),(26,'auth_use_username','1'),(27,'auth_login_by_username','1'),(28,'auth_login_by_email','1'),(29,'auth_login_record_ip','1'),(30,'auth_login_count_attempts','1'),(31,'auth_login_max_attempts','5'),(32,'auth_login_attempt_expire','6'),(33,'auth_use_recaptcha','0'),(34,'auth_recaptcha_public_key',NULL),(35,'auth_recaptcha_private_key',NULL),(36,'auth_username_blacklist','admin, administrator, mod, moderator, root'),(37,'auth_username_blacklist_prepend','the,sys,system,site,super'),(38,'auth_username_exceptions',NULL),(39,'email_protocol','0'),(40,'email_mailpath',''),(41,'email_smtp_host',''),(42,'email_smtp_user','admin'),(43,'email_smtp_pass','password'),(44,'email_smtp_port',''),(45,'email_smtp_timeout','30'),(46,'email_wordwrap','0'),(47,'email_mailtype','0'),(48,'email_priority','2');
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

-- Dump completed on 2014-05-13  4:47:25
