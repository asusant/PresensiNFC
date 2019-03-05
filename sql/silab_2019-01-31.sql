# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: cokilabs.com (MySQL 5.5.5-10.2.21-MariaDB)
# Database: u4114683_silab
# Generation Time: 2019-01-31 14:17:28 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table contents
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contents`;

CREATE TABLE `contents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `section` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(7) DEFAULT NULL,
  `updated_by` int(7) DEFAULT NULL,
  `deleted_by` int(7) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `contents` WRITE;
/*!40000 ALTER TABLE `contents` DISABLE KEYS */;

INSERT INTO `contents` (`id`, `section`, `content`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES
	(1,'site-name','Sistem Informasi Laboratorium',NULL,NULL,NULL,NULL,NULL,NULL),
	(2,'site-logo','assets/newassets/images/site-logo.png',NULL,NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `contents` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dosen
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dosen`;

CREATE TABLE `dosen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `dosen` WRITE;
/*!40000 ALTER TABLE `dosen` DISABLE KEYS */;

INSERT INTO `dosen` (`id`, `id_user`, `nip`, `alamat`, `email`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES
	(1,5,'1348943589784','Jl. HR. Hardijanto No. 6 RT.01 RW.02','dosen@mail.com','2018-12-29 10:35:47','2019-01-31 12:00:05',NULL,3,1,0),
	(2,6,'2347652343274','Jl. HR. Hardijanto No.6','sukaryo@mail.com','2018-12-29 10:41:29','2018-12-29 10:41:34','2018-12-29 10:41:34',3,0,3),
	(3,11,'2376452341251','Jl. Dosen','dosen2@mail.com','2019-01-03 15:55:38','2019-01-31 12:03:15',NULL,3,1,0),
	(4,18,'846466594','Jakarta','Suryo@gmail.com','2019-01-30 21:48:15','2019-01-30 21:48:15',NULL,1,0,0),
	(5,22,'61863168169361','Tambora, Jakarta Barat','jackma@gmail.com','2019-01-31 12:01:19','2019-01-31 12:01:44',NULL,1,1,0);

/*!40000 ALTER TABLE `dosen` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hari
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hari`;

CREATE TABLE `hari` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hari` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `hari` WRITE;
/*!40000 ALTER TABLE `hari` DISABLE KEYS */;

INSERT INTO `hari` (`id`, `hari`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES
	(1,'Senin','2018-12-29 09:44:46','2018-12-29 09:44:46',NULL,3,0,0),
	(2,'Selasa','2018-12-29 09:44:50','2018-12-29 09:44:50',NULL,3,0,0),
	(3,'Rabu','2018-12-29 09:44:55','2018-12-29 09:44:55',NULL,3,0,0),
	(4,'Kamis','2018-12-29 09:44:58','2018-12-29 09:44:58',NULL,3,0,0),
	(5,'Jumat','2018-12-29 09:45:04','2018-12-29 09:45:04',NULL,3,0,0),
	(6,'Sabtu','2019-01-12 15:14:35','2019-01-12 15:14:35',NULL,1,0,0);

/*!40000 ALTER TABLE `hari` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kalab
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kalab`;

CREATE TABLE `kalab` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `kalab` WRITE;
/*!40000 ALTER TABLE `kalab` DISABLE KEYS */;

INSERT INTO `kalab` (`id`, `id_user`, `nip`, `alamat`, `email`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES
	(1,7,'32524121653214524','Jl. HR. Hardijanto No.5','kalab@mail.com','2018-12-29 11:01:59','2018-12-29 11:01:59',NULL,3,0,0),
	(2,8,'12124523432654254','Jl. Kolonel','kalab2@mail.com','2018-12-29 11:02:37','2018-12-29 11:03:00',NULL,3,3,3);

/*!40000 ALTER TABLE `kalab` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table laboratorium
# ------------------------------------------------------------

DROP TABLE IF EXISTS `laboratorium`;

CREATE TABLE `laboratorium` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user_kepala` int(11) NOT NULL,
  `laboratorium` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maks_peserta` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `laboratorium` WRITE;
/*!40000 ALTER TABLE `laboratorium` DISABLE KEYS */;

INSERT INTO `laboratorium` (`id`, `id_user_kepala`, `laboratorium`, `lokasi`, `maks_peserta`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES
	(1,7,'Lab. Multimedias 1','Gedung IT Lt. 1',51,'2018-12-29 13:28:39','2019-01-31 13:45:03',NULL,3,1,0),
	(2,8,'Lab. Multimedia 4','Gedung IT Lt. 2',55,'2018-12-29 13:29:13','2019-01-31 14:24:12',NULL,3,1,0),
	(3,8,'Lab Jarkoms 3','Lt 3',50,'2019-01-30 21:14:17','2019-01-31 14:24:26',NULL,1,1,0),
	(4,8,'Lab Multimedia','Gedung FMIPA',40,'2019-01-31 12:04:41','2019-01-31 13:02:15','2019-01-31 13:02:15',1,1,1),
	(5,7,'Lab Multimedia','Gedung FMIPA Lt. 3',50,'2019-01-31 14:21:23','2019-01-31 14:21:37',NULL,1,1,0);

/*!40000 ALTER TABLE `laboratorium` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table levels
# ------------------------------------------------------------

DROP TABLE IF EXISTS `levels`;

CREATE TABLE `levels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(7) DEFAULT NULL,
  `updated_by` int(7) DEFAULT NULL,
  `deleted_by` int(7) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `levels` WRITE;
/*!40000 ALTER TABLE `levels` DISABLE KEYS */;

INSERT INTO `levels` (`id`, `level`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES
	(1,'Root','2018-03-08 00:00:00',NULL,NULL,1,NULL,NULL),
	(2,'Admin','2018-03-08 00:00:00',NULL,NULL,1,NULL,NULL),
	(3,'Kalab','2018-12-29 10:10:21','2018-12-29 10:10:21',NULL,3,NULL,NULL),
	(4,'Dosen','2018-12-29 10:10:25','2018-12-29 10:10:25',NULL,3,NULL,NULL),
	(5,'Mahasiswa','2018-12-29 10:10:28','2018-12-29 10:10:28',NULL,3,NULL,NULL),
	(6,'Mahasiswa4','2019-01-12 11:22:23','2019-01-12 15:30:04','2019-01-12 15:30:04',1,NULL,1);

/*!40000 ALTER TABLE `levels` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log`;

CREATE TABLE `log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `nama_tabel` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_objek` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aktivitas` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kalimat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;

INSERT INTO `log` (`id`, `id_user`, `nama_tabel`, `id_objek`, `aktivitas`, `kalimat`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES
	(1,3,NULL,NULL,'Menambah Submenu User Levels.',NULL,'2018-04-21 22:43:02','2018-04-21 22:43:02',NULL,3,NULL,NULL),
	(2,3,NULL,NULL,'Menambah Submenu User Levels.',NULL,'2018-04-21 22:43:17','2018-04-21 22:43:17',NULL,3,NULL,NULL),
	(3,3,NULL,NULL,'Menambah Submenu Application Menus.',NULL,'2018-04-21 22:43:27','2018-04-21 22:43:27',NULL,3,NULL,NULL),
	(4,3,NULL,NULL,'Menambah Submenu Logs.',NULL,'2018-04-21 22:43:55','2018-04-21 22:43:55',NULL,3,NULL,NULL),
	(5,3,NULL,NULL,'Menghapus Menu Trash.',NULL,'2018-05-24 08:28:56','2018-05-24 08:28:56',NULL,3,NULL,NULL),
	(6,3,NULL,NULL,'Menambah Menu Trash.',NULL,'2018-05-24 08:29:32','2018-05-24 08:29:32',NULL,3,NULL,NULL),
	(7,3,NULL,NULL,'Menghapus Menu Trash.',NULL,'2018-05-24 08:34:54','2018-05-24 08:34:54',NULL,3,NULL,NULL),
	(8,3,NULL,NULL,'Menambah Menu Trash.',NULL,'2018-05-24 08:35:21','2018-05-24 08:35:21',NULL,3,NULL,NULL),
	(9,3,NULL,NULL,'Menghapus Menu Trash.',NULL,'2018-05-24 08:57:26','2018-05-24 08:57:26',NULL,3,NULL,NULL),
	(10,3,NULL,NULL,'Menambah Submenu Tipe Kehadiran.',NULL,'2018-12-29 09:13:25','2018-12-29 09:13:25',NULL,3,NULL,NULL),
	(11,3,NULL,NULL,'Menambah Submenu Hari.',NULL,'2018-12-29 09:31:03','2018-12-29 09:31:03',NULL,3,NULL,NULL),
	(12,3,NULL,NULL,'Menambah Tipe Kehadiran.',NULL,'2018-12-29 09:32:55','2018-12-29 09:32:55',NULL,3,NULL,NULL),
	(13,3,NULL,NULL,'Menambah Hari.',NULL,'2018-12-29 09:44:46','2018-12-29 09:44:46',NULL,3,NULL,NULL),
	(14,3,NULL,NULL,'Menambah Hari.',NULL,'2018-12-29 09:44:50','2018-12-29 09:44:50',NULL,3,NULL,NULL),
	(15,3,NULL,NULL,'Menambah Hari.',NULL,'2018-12-29 09:44:55','2018-12-29 09:44:55',NULL,3,NULL,NULL),
	(16,3,NULL,NULL,'Menambah Hari.',NULL,'2018-12-29 09:44:58','2018-12-29 09:44:58',NULL,3,NULL,NULL),
	(17,3,NULL,NULL,'Menambah Hari.',NULL,'2018-12-29 09:45:04','2018-12-29 09:45:04',NULL,3,NULL,NULL),
	(18,3,NULL,NULL,'Menambah User Level: Kalab',NULL,'2018-12-29 10:10:21','2018-12-29 10:10:21',NULL,3,NULL,NULL),
	(19,3,NULL,NULL,'Menambah User Level: Dosen',NULL,'2018-12-29 10:10:25','2018-12-29 10:10:25',NULL,3,NULL,NULL),
	(20,3,NULL,NULL,'Menambah User Level: Mahasiswa',NULL,'2018-12-29 10:10:28','2018-12-29 10:10:28',NULL,3,NULL,NULL),
	(21,3,NULL,NULL,'Menambah Menu Dosen.',NULL,'2018-12-29 10:29:17','2018-12-29 10:29:17',NULL,3,NULL,NULL),
	(22,3,NULL,NULL,'Menambah Dosen.',NULL,'2018-12-29 10:35:47','2018-12-29 10:35:47',NULL,3,NULL,NULL),
	(23,3,NULL,NULL,'Mengubah Dosen.',NULL,'2018-12-29 10:39:48','2018-12-29 10:39:48',NULL,3,NULL,NULL),
	(24,3,NULL,NULL,'Menambah Dosen.',NULL,'2018-12-29 10:41:29','2018-12-29 10:41:29',NULL,3,NULL,NULL),
	(25,3,NULL,NULL,'Menghapus Dosen.',NULL,'2018-12-29 10:41:34','2018-12-29 10:41:34',NULL,3,NULL,NULL),
	(26,3,NULL,NULL,'Menambah Menu Kepala Laboratorium.',NULL,'2018-12-29 10:57:21','2018-12-29 10:57:21',NULL,3,NULL,NULL),
	(27,3,NULL,NULL,'Menambah Kalab.',NULL,'2018-12-29 11:01:59','2018-12-29 11:01:59',NULL,3,NULL,NULL),
	(28,3,NULL,NULL,'Menambah Kalab.',NULL,'2018-12-29 11:02:37','2018-12-29 11:02:37',NULL,3,NULL,NULL),
	(29,3,NULL,NULL,'Mengubah Kalab.',NULL,'2018-12-29 11:02:44','2018-12-29 11:02:44',NULL,3,NULL,NULL),
	(30,3,NULL,NULL,'Menghapus Kalab.',NULL,'2018-12-29 11:03:00','2018-12-29 11:03:00',NULL,3,NULL,NULL),
	(31,3,NULL,NULL,'Menambah Menu Mahasiswa.',NULL,'2018-12-29 11:15:45','2018-12-29 11:15:45',NULL,3,NULL,NULL),
	(32,3,NULL,NULL,'Menambah Mahasiswa.',NULL,'2018-12-29 11:17:04','2018-12-29 11:17:04',NULL,3,NULL,NULL),
	(33,3,NULL,NULL,'Menambah Mahasiswa.',NULL,'2018-12-29 11:18:05','2018-12-29 11:18:05',NULL,3,NULL,NULL),
	(34,3,NULL,NULL,'Menambah Menu Laboratorium.',NULL,'2018-12-29 13:25:32','2018-12-29 13:25:32',NULL,3,NULL,NULL),
	(35,3,NULL,NULL,'Menambah Laboratorium.',NULL,'2018-12-29 13:28:39','2018-12-29 13:28:39',NULL,3,NULL,NULL),
	(36,3,NULL,NULL,'Menambah Laboratorium.',NULL,'2018-12-29 13:29:13','2018-12-29 13:29:13',NULL,3,NULL,NULL),
	(37,3,NULL,NULL,'Mengubah Laboratorium.',NULL,'2018-12-29 13:30:07','2018-12-29 13:30:07',NULL,3,NULL,NULL),
	(38,3,NULL,NULL,'Mengubah Laboratorium.',NULL,'2018-12-29 13:30:13','2018-12-29 13:30:13',NULL,3,NULL,NULL),
	(39,3,NULL,NULL,'Menambah Menu Praktikum.',NULL,'2019-01-02 08:19:41','2019-01-02 08:19:41',NULL,3,NULL,NULL),
	(40,3,NULL,NULL,'Menambah Menu Praktikum.',NULL,'2019-01-02 08:19:48','2019-01-02 08:19:48',NULL,3,NULL,NULL),
	(41,3,NULL,NULL,'Menambah Praktikum.',NULL,'2019-01-03 15:45:07','2019-01-03 15:45:07',NULL,3,NULL,NULL),
	(42,3,NULL,NULL,'Menambah Praktikum.',NULL,'2019-01-03 15:47:36','2019-01-03 15:47:36',NULL,3,NULL,NULL),
	(43,3,NULL,NULL,'Menambah Praktikum.',NULL,'2019-01-03 15:54:28','2019-01-03 15:54:28',NULL,3,NULL,NULL),
	(44,3,NULL,NULL,'Menambah Dosen.',NULL,'2019-01-03 15:55:38','2019-01-03 15:55:38',NULL,3,NULL,NULL),
	(45,3,NULL,NULL,'Menambah Praktikum.',NULL,'2019-01-03 15:59:49','2019-01-03 15:59:49',NULL,3,NULL,NULL),
	(46,3,NULL,NULL,'Mengubah Praktikum.',NULL,'2019-01-03 16:04:18','2019-01-03 16:04:18',NULL,3,NULL,NULL),
	(47,3,NULL,NULL,'Menambah Submenu Praktikum Aktif.',NULL,'2019-01-10 10:08:21','2019-01-10 10:08:21',NULL,3,NULL,NULL),
	(48,3,NULL,NULL,'Menambah Submenu Praktikum Aktif.',NULL,'2019-01-10 10:11:45','2019-01-10 10:11:45',NULL,3,NULL,NULL),
	(49,3,NULL,NULL,'Menambah Submenu Praktikum Non Aktif.',NULL,'2019-01-10 10:14:05','2019-01-10 10:14:05',NULL,3,NULL,NULL),
	(50,3,NULL,NULL,'Menonaktifkan Praktikum.',NULL,'2019-01-10 10:26:32','2019-01-10 10:26:32',NULL,3,NULL,NULL),
	(51,3,NULL,NULL,'Menonaktifkan Praktikum.',NULL,'2019-01-10 10:46:05','2019-01-10 10:46:05',NULL,3,NULL,NULL),
	(52,3,NULL,NULL,'Mengubah status Pendaftaran Praktikum.',NULL,'2019-01-10 10:56:31','2019-01-10 10:56:31',NULL,3,NULL,NULL),
	(53,3,NULL,NULL,'Mengubah status Pendaftaran Praktikum.',NULL,'2019-01-10 10:58:10','2019-01-10 10:58:10',NULL,3,NULL,NULL),
	(54,3,NULL,NULL,'Mengubah status Pendaftaran Praktikum.',NULL,'2019-01-10 11:01:41','2019-01-10 11:01:41',NULL,3,NULL,NULL),
	(55,3,NULL,NULL,'Mengubah status Pendaftaran Praktikum.',NULL,'2019-01-10 11:01:43','2019-01-10 11:01:43',NULL,3,NULL,NULL),
	(56,3,NULL,NULL,'Mengubah status Pendaftaran Praktikum.',NULL,'2019-01-10 11:01:45','2019-01-10 11:01:45',NULL,3,NULL,NULL),
	(57,3,NULL,NULL,'Mengaktifkan PraktikumNonaktif.',NULL,'2019-01-10 11:10:43','2019-01-10 11:10:43',NULL,3,NULL,NULL),
	(58,3,NULL,NULL,'Menambah Menu Pendaftaran Praktikum.',NULL,'2019-01-10 11:56:24','2019-01-10 11:56:24',NULL,3,NULL,NULL),
	(59,9,NULL,NULL,'Mendaftar Pendaftaran Praktikum.',NULL,'2019-01-10 12:15:28','2019-01-10 12:15:28',NULL,9,NULL,NULL),
	(60,10,NULL,NULL,'Mendaftar Pendaftaran Praktikum.',NULL,'2019-01-10 12:16:45','2019-01-10 12:16:45',NULL,10,NULL,NULL),
	(61,10,NULL,NULL,'Membatalkan Pendaftaran Praktikum.',NULL,'2019-01-10 12:16:49','2019-01-10 12:16:49',NULL,10,NULL,NULL),
	(62,10,NULL,NULL,'Mendaftar Pendaftaran Praktikum.',NULL,'2019-01-10 12:16:53','2019-01-10 12:16:53',NULL,10,NULL,NULL),
	(63,3,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-11 07:14:41','2019-01-11 07:14:41',NULL,3,NULL,NULL),
	(64,3,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-11 07:14:45','2019-01-11 07:14:45',NULL,3,NULL,NULL),
	(65,9,NULL,NULL,'Mendaftar Pendaftaran Praktikum.',NULL,'2019-01-11 07:22:52','2019-01-11 07:22:52',NULL,9,NULL,NULL),
	(66,3,NULL,NULL,'Menambah Menu Praktikum Dosen.',NULL,'2019-01-11 07:29:21','2019-01-11 07:29:21',NULL,3,NULL,NULL),
	(67,3,NULL,NULL,'Menambah Submenu Praktikum Aktif.',NULL,'2019-01-11 07:29:43','2019-01-11 07:29:43',NULL,3,NULL,NULL),
	(68,5,NULL,NULL,'Mengaktifkan Praktikum Dosen.',NULL,'2019-01-11 07:42:39','2019-01-11 07:42:39',NULL,5,NULL,NULL),
	(69,3,NULL,NULL,'Menambah Submenu Praktikum Nonaktif.',NULL,'2019-01-11 07:49:42','2019-01-11 07:49:42',NULL,3,NULL,NULL),
	(70,3,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-11 07:57:24','2019-01-11 07:57:24',NULL,3,NULL,NULL),
	(71,3,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-11 09:00:47','2019-01-11 09:00:47',NULL,3,NULL,NULL),
	(72,3,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-11 09:00:51','2019-01-11 09:00:51',NULL,3,NULL,NULL),
	(73,3,NULL,NULL,'Menghapus Menu Praktikum Dosen.',NULL,'2019-01-11 09:33:53','2019-01-11 09:33:53',NULL,3,NULL,NULL),
	(74,5,NULL,NULL,'Menambah Presensi Praktikum.',NULL,'2019-01-11 13:41:03','2019-01-11 13:41:03',NULL,5,NULL,NULL),
	(75,5,NULL,NULL,'Menambah Presensi Praktikum.',NULL,'2019-01-11 13:56:10','2019-01-11 13:56:10',NULL,5,NULL,NULL),
	(76,5,NULL,NULL,'Menambah Praktikum Aktif.',NULL,'2019-01-11 21:24:00','2019-01-11 21:24:00',NULL,5,NULL,NULL),
	(77,3,NULL,NULL,'Menonaktifkan Praktikum Aktif.',NULL,'2019-01-11 21:37:35','2019-01-11 21:37:35',NULL,3,NULL,NULL),
	(78,3,NULL,NULL,'Mengaktifkan PraktikumNonaktif.',NULL,'2019-01-11 21:38:28','2019-01-11 21:38:28',NULL,3,NULL,NULL),
	(79,3,NULL,NULL,'Menambah Menu Jadwal Praktikum.',NULL,'2019-01-11 21:50:07','2019-01-11 21:50:07',NULL,3,NULL,NULL),
	(80,3,NULL,NULL,'Menonaktifkan Praktikum Aktif.',NULL,'2019-01-11 21:53:39','2019-01-11 21:53:39',NULL,3,NULL,NULL),
	(81,3,NULL,NULL,'Mengaktifkan PraktikumNonaktif.',NULL,'2019-01-11 21:53:59','2019-01-11 21:53:59',NULL,3,NULL,NULL),
	(82,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-11 22:02:03','2019-01-11 22:02:03',NULL,1,NULL,NULL),
	(83,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-11 22:02:11','2019-01-11 22:02:11',NULL,1,NULL,NULL),
	(84,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-11 22:04:15','2019-01-11 22:04:15',NULL,1,NULL,NULL),
	(85,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-11 23:33:15','2019-01-11 23:33:15',NULL,1,NULL,NULL),
	(86,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-11 23:33:27','2019-01-11 23:33:27',NULL,1,NULL,NULL),
	(87,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-11 23:33:35','2019-01-11 23:33:35',NULL,1,NULL,NULL),
	(88,1,NULL,NULL,'Menambah User Level: Mahasiswa4',NULL,'2019-01-12 11:22:23','2019-01-12 11:22:23',NULL,1,NULL,NULL),
	(89,14,NULL,NULL,'Menambah Praktikum Aktif.',NULL,'2019-01-12 12:19:45','2019-01-12 12:19:45',NULL,14,NULL,NULL),
	(90,1,NULL,NULL,'Menambah Praktikum Aktif.',NULL,'2019-01-12 14:48:23','2019-01-12 14:48:23',NULL,1,NULL,NULL),
	(91,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-12 14:48:46','2019-01-12 14:48:46',NULL,1,NULL,NULL),
	(92,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-12 14:49:49','2019-01-12 14:49:49',NULL,1,NULL,NULL),
	(93,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-12 14:49:57','2019-01-12 14:49:57',NULL,1,NULL,NULL),
	(94,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-12 14:50:02','2019-01-12 14:50:02',NULL,1,NULL,NULL),
	(95,9,NULL,NULL,'Mendaftar Pendaftaran Praktikum.',NULL,'2019-01-12 14:52:53','2019-01-12 14:52:53',NULL,9,NULL,NULL),
	(96,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-12 15:11:05','2019-01-12 15:11:05',NULL,1,NULL,NULL),
	(97,1,NULL,NULL,'Menonaktifkan Praktikum Aktif.',NULL,'2019-01-12 15:11:14','2019-01-12 15:11:14',NULL,1,NULL,NULL),
	(98,1,NULL,NULL,'Mengaktifkan PraktikumNonaktif.',NULL,'2019-01-12 15:11:40','2019-01-12 15:11:40',NULL,1,NULL,NULL),
	(99,1,NULL,NULL,'Menambah Hari.',NULL,'2019-01-12 15:14:35','2019-01-12 15:14:35',NULL,1,NULL,NULL),
	(100,5,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-12 15:20:26','2019-01-12 15:20:26',NULL,5,NULL,NULL),
	(101,1,NULL,NULL,'Menghapus User Level: Mahasiswa4',NULL,'2019-01-12 15:30:04','2019-01-12 15:30:04',NULL,1,NULL,NULL),
	(102,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-12 15:34:17','2019-01-12 15:34:17',NULL,1,NULL,NULL),
	(103,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-12 15:34:26','2019-01-12 15:34:26',NULL,1,NULL,NULL),
	(104,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-12 15:34:32','2019-01-12 15:34:32',NULL,1,NULL,NULL),
	(105,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-12 15:34:36','2019-01-12 15:34:36',NULL,1,NULL,NULL),
	(106,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-12 15:34:43','2019-01-12 15:34:43',NULL,1,NULL,NULL),
	(107,1,NULL,NULL,'Menambah Praktikum Aktif.',NULL,'2019-01-12 15:36:42','2019-01-12 15:36:42',NULL,1,NULL,NULL),
	(108,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-12 15:41:57','2019-01-12 15:41:57',NULL,1,NULL,NULL),
	(109,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-12 15:42:21','2019-01-12 15:42:21',NULL,1,NULL,NULL),
	(110,9,NULL,NULL,'Mendaftar Pendaftaran Praktikum.',NULL,'2019-01-12 15:43:55','2019-01-12 15:43:55',NULL,9,NULL,NULL),
	(111,9,NULL,NULL,'Mendaftar Pendaftaran Praktikum.',NULL,'2019-01-12 15:43:58','2019-01-12 15:43:58',NULL,9,NULL,NULL),
	(112,5,NULL,NULL,'Menambah Presensi Praktikum.',NULL,'2019-01-12 15:51:43','2019-01-12 15:51:43',NULL,5,NULL,NULL),
	(113,1,NULL,NULL,'Menambah Praktikum Aktif.',NULL,'2019-01-12 15:58:40','2019-01-12 15:58:40',NULL,1,NULL,NULL),
	(114,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-12 15:59:00','2019-01-12 15:59:00',NULL,1,NULL,NULL),
	(115,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-12 18:14:05','2019-01-12 18:14:05',NULL,1,NULL,NULL),
	(116,3,NULL,NULL,'Menambah Praktikum Aktif.',NULL,'2019-01-12 18:21:59','2019-01-12 18:21:59',NULL,3,NULL,NULL),
	(117,9,NULL,NULL,'Mendaftar Pendaftaran Praktikum.',NULL,'2019-01-12 18:22:24','2019-01-12 18:22:24',NULL,9,NULL,NULL),
	(118,3,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-12 18:23:22','2019-01-12 18:23:22',NULL,3,NULL,NULL),
	(119,11,NULL,NULL,'Menambah Presensi Praktikum.',NULL,'2019-01-12 18:44:50','2019-01-12 18:44:50',NULL,11,NULL,NULL),
	(120,11,NULL,NULL,'Menambah Presensi Praktikum.',NULL,'2019-01-12 18:56:15','2019-01-12 18:56:15',NULL,11,NULL,NULL),
	(121,11,NULL,NULL,'Menambah Praktikum Aktif.',NULL,'2019-01-12 18:56:40','2019-01-12 18:56:40',NULL,11,NULL,NULL),
	(122,5,NULL,NULL,'Menambah Presensi Praktikum.',NULL,'2019-01-12 19:44:09','2019-01-12 19:44:09',NULL,5,NULL,NULL),
	(123,3,NULL,NULL,'Menambah Menu History Praktikum.',NULL,'2019-01-15 12:16:52','2019-01-15 12:16:52',NULL,3,NULL,NULL),
	(124,3,NULL,NULL,'Menambah Menu History Praktikum.',NULL,'2019-01-15 12:17:54','2019-01-15 12:17:54',NULL,3,NULL,NULL),
	(125,3,NULL,NULL,'Menonaktifkan Praktikum Aktif.',NULL,'2019-01-15 14:39:14','2019-01-15 14:39:14',NULL,3,NULL,NULL),
	(126,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-15 14:50:52','2019-01-15 14:50:52',NULL,1,NULL,NULL),
	(127,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-15 14:50:57','2019-01-15 14:50:57',NULL,1,NULL,NULL),
	(128,5,NULL,NULL,'Menambah Presensi Praktikum.',NULL,'2019-01-15 15:03:27','2019-01-15 15:03:27',NULL,5,NULL,NULL),
	(129,9,NULL,NULL,'Membatalkan Pendaftaran Praktikum.',NULL,'2019-01-17 11:58:18','2019-01-17 11:58:18',NULL,9,NULL,NULL),
	(130,9,NULL,NULL,'Mendaftar Pendaftaran Praktikum.',NULL,'2019-01-17 11:58:21','2019-01-17 11:58:21',NULL,9,NULL,NULL),
	(131,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-17 13:38:38','2019-01-17 13:38:38',NULL,1,NULL,NULL),
	(132,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-17 13:40:40','2019-01-17 13:40:40',NULL,1,NULL,NULL),
	(133,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-17 13:40:48','2019-01-17 13:40:48',NULL,1,NULL,NULL),
	(134,9,NULL,NULL,'Membatalkan Pendaftaran Praktikum.',NULL,'2019-01-19 22:16:42','2019-01-19 22:16:42',NULL,9,NULL,NULL),
	(135,3,NULL,NULL,'Menambah Menu Modul.',NULL,'2019-01-21 09:52:45','2019-01-21 09:52:45',NULL,3,NULL,NULL),
	(136,3,NULL,NULL,'Menambah Modul.',NULL,'2019-01-21 09:54:02','2019-01-21 09:54:02',NULL,3,NULL,NULL),
	(137,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 16:26:15','2019-01-21 16:26:15',NULL,7,NULL,NULL),
	(138,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 16:26:20','2019-01-21 16:26:20',NULL,7,NULL,NULL),
	(139,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 16:26:24','2019-01-21 16:26:24',NULL,7,NULL,NULL),
	(140,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 16:26:39','2019-01-21 16:26:39',NULL,7,NULL,NULL),
	(141,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 16:29:36','2019-01-21 16:29:36',NULL,7,NULL,NULL),
	(142,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 16:29:40','2019-01-21 16:29:40',NULL,7,NULL,NULL),
	(143,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 16:29:45','2019-01-21 16:29:45',NULL,7,NULL,NULL),
	(144,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 16:29:49','2019-01-21 16:29:49',NULL,7,NULL,NULL),
	(145,9,NULL,NULL,'Mendaftar Pendaftaran Praktikum.',NULL,'2019-01-21 16:30:35','2019-01-21 16:30:35',NULL,9,NULL,NULL),
	(146,7,NULL,NULL,'Menambah Praktikum Aktif.',NULL,'2019-01-21 16:36:19','2019-01-21 16:36:19',NULL,7,NULL,NULL),
	(147,9,NULL,NULL,'Mendaftar Pendaftaran Praktikum.',NULL,'2019-01-21 16:44:59','2019-01-21 16:44:59',NULL,9,NULL,NULL),
	(148,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 16:52:17','2019-01-21 16:52:17',NULL,7,NULL,NULL),
	(149,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:15:06','2019-01-21 17:15:06',NULL,7,NULL,NULL),
	(150,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:15:14','2019-01-21 17:15:14',NULL,7,NULL,NULL),
	(151,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:15:21','2019-01-21 17:15:21',NULL,7,NULL,NULL),
	(152,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:15:29','2019-01-21 17:15:29',NULL,7,NULL,NULL),
	(153,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:23:03','2019-01-21 17:23:03',NULL,7,NULL,NULL),
	(154,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:23:09','2019-01-21 17:23:09',NULL,7,NULL,NULL),
	(155,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:23:15','2019-01-21 17:23:15',NULL,7,NULL,NULL),
	(156,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:24:06','2019-01-21 17:24:06',NULL,7,NULL,NULL),
	(157,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:24:11','2019-01-21 17:24:11',NULL,7,NULL,NULL),
	(158,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:24:15','2019-01-21 17:24:15',NULL,7,NULL,NULL),
	(159,7,NULL,NULL,'Menambah Praktikum Aktif.',NULL,'2019-01-21 17:28:32','2019-01-21 17:28:32',NULL,7,NULL,NULL),
	(160,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:33:42','2019-01-21 17:33:42',NULL,7,NULL,NULL),
	(161,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:33:46','2019-01-21 17:33:46',NULL,7,NULL,NULL),
	(162,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:33:53','2019-01-21 17:33:53',NULL,7,NULL,NULL),
	(163,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:33:55','2019-01-21 17:33:55',NULL,7,NULL,NULL),
	(164,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:33:57','2019-01-21 17:33:57',NULL,7,NULL,NULL),
	(165,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:33:59','2019-01-21 17:33:59',NULL,7,NULL,NULL),
	(166,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:34:02','2019-01-21 17:34:02',NULL,7,NULL,NULL),
	(167,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:34:04','2019-01-21 17:34:04',NULL,7,NULL,NULL),
	(168,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:34:24','2019-01-21 17:34:24',NULL,7,NULL,NULL),
	(169,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:34:26','2019-01-21 17:34:26',NULL,7,NULL,NULL),
	(170,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:34:30','2019-01-21 17:34:30',NULL,7,NULL,NULL),
	(171,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:34:32','2019-01-21 17:34:32',NULL,7,NULL,NULL),
	(172,9,NULL,NULL,'Mendaftar Pendaftaran Praktikum.',NULL,'2019-01-21 17:35:19','2019-01-21 17:35:19',NULL,9,NULL,NULL),
	(173,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:38:40','2019-01-21 17:38:40',NULL,7,NULL,NULL),
	(174,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:39:01','2019-01-21 17:39:01',NULL,7,NULL,NULL),
	(175,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-21 17:42:56','2019-01-21 17:42:56',NULL,7,NULL,NULL),
	(176,9,NULL,NULL,'Membatalkan Pendaftaran Praktikum.',NULL,'2019-01-23 14:58:47','2019-01-23 14:58:47',NULL,9,NULL,NULL),
	(177,1,NULL,NULL,'Menghapus Mahasiswa.',NULL,'2019-01-30 18:24:14','2019-01-30 18:24:14',NULL,1,NULL,NULL),
	(178,1,NULL,NULL,'Menghapus Mahasiswa.',NULL,'2019-01-30 18:24:17','2019-01-30 18:24:17',NULL,1,NULL,NULL),
	(179,1,NULL,NULL,'Menambah praktikum \"Machine Learning.\" dengan import excel.',NULL,'2019-01-30 18:24:28','2019-01-30 18:24:28',NULL,1,NULL,NULL),
	(180,1,NULL,NULL,'Menambah praktikum \"Data Science.\" dengan import excel.',NULL,'2019-01-30 18:24:28','2019-01-30 18:24:28',NULL,1,NULL,NULL),
	(181,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-30 18:24:34','2019-01-30 18:24:34',NULL,1,NULL,NULL),
	(182,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-30 18:24:46','2019-01-30 18:24:46',NULL,1,NULL,NULL),
	(183,1,NULL,NULL,'Menambah Laboratorium.',NULL,'2019-01-30 21:14:17','2019-01-30 21:14:17',NULL,1,NULL,NULL),
	(184,1,NULL,NULL,'Menambah Dosen.',NULL,'2019-01-30 21:48:15','2019-01-30 21:48:15',NULL,1,NULL,NULL),
	(185,1,NULL,NULL,'Menambah praktikum \"Machine Learning.\" dengan import excel.',NULL,'2019-01-31 10:08:39','2019-01-31 10:08:39',NULL,1,NULL,NULL),
	(186,1,NULL,NULL,'Menambah praktikum \"Data Science.\" dengan import excel.',NULL,'2019-01-31 10:08:39','2019-01-31 10:08:39',NULL,1,NULL,NULL),
	(187,1,NULL,NULL,'Menambah praktikum \"Algen.\" dengan import excel.',NULL,'2019-01-31 10:14:41','2019-01-31 10:14:41',NULL,1,NULL,NULL),
	(188,1,NULL,NULL,'Menambah praktikum \"Machine Learning.\" dengan import excel.',NULL,'2019-01-31 10:21:02','2019-01-31 10:21:02',NULL,1,NULL,NULL),
	(189,1,NULL,NULL,'Menambah praktikum \"Data Science.\" dengan import excel.',NULL,'2019-01-31 10:21:02','2019-01-31 10:21:02',NULL,1,NULL,NULL),
	(190,1,NULL,NULL,'Menambah praktikum \"Machine Learning.\" dengan import excel.',NULL,'2019-01-31 10:21:29','2019-01-31 10:21:29',NULL,1,NULL,NULL),
	(191,1,NULL,NULL,'Menambah praktikum \"Data Science.\" dengan import excel.',NULL,'2019-01-31 10:21:29','2019-01-31 10:21:29',NULL,1,NULL,NULL),
	(192,1,NULL,NULL,'Menambah praktikum \"Machine Learning.\" dengan import excel.',NULL,'2019-01-31 10:23:05','2019-01-31 10:23:05',NULL,1,NULL,NULL),
	(193,1,NULL,NULL,'Menambah praktikum \"Data Science.\" dengan import excel.',NULL,'2019-01-31 10:23:05','2019-01-31 10:23:05',NULL,1,NULL,NULL),
	(194,21,NULL,NULL,'Mendaftar Pendaftaran Praktikum.',NULL,'2019-01-31 10:29:06','2019-01-31 10:29:06',NULL,21,NULL,NULL),
	(195,21,NULL,NULL,'Mendaftar Pendaftaran Praktikum.',NULL,'2019-01-31 10:29:33','2019-01-31 10:29:33',NULL,21,NULL,NULL),
	(196,1,NULL,NULL,'Menambah praktikum \"Machine Learning.\" dengan import excel.',NULL,'2019-01-31 10:30:17','2019-01-31 10:30:17',NULL,1,NULL,NULL),
	(197,1,NULL,NULL,'Menambah praktikum \"Data Science.\" dengan import excel.',NULL,'2019-01-31 10:30:17','2019-01-31 10:30:17',NULL,1,NULL,NULL),
	(198,1,NULL,NULL,'Menambah praktikum \"Machine Learning.\" dengan import excel.',NULL,'2019-01-31 10:33:26','2019-01-31 10:33:26',NULL,1,NULL,NULL),
	(199,1,NULL,NULL,'Menambah praktikum \"Data Science.\" dengan import excel.',NULL,'2019-01-31 10:33:26','2019-01-31 10:33:26',NULL,1,NULL,NULL),
	(200,1,NULL,NULL,'Menambah praktikum \"Machine Learning.\" dengan import excel.',NULL,'2019-01-31 10:33:57','2019-01-31 10:33:57',NULL,1,NULL,NULL),
	(201,1,NULL,NULL,'Menambah praktikum \"Data Science.\" dengan import excel.',NULL,'2019-01-31 10:33:57','2019-01-31 10:33:57',NULL,1,NULL,NULL),
	(202,1,NULL,NULL,'Menambah praktikum \"Machine Learning.\" dengan import excel.',NULL,'2019-01-31 10:36:57','2019-01-31 10:36:57',NULL,1,NULL,NULL),
	(203,1,NULL,NULL,'Menambah praktikum \"Data Science.\" dengan import excel.',NULL,'2019-01-31 10:36:57','2019-01-31 10:36:57',NULL,1,NULL,NULL),
	(204,1,NULL,NULL,'Menambah praktikum \"Machine Learning.\" dengan import excel.',NULL,'2019-01-31 10:37:07','2019-01-31 10:37:07',NULL,1,NULL,NULL),
	(205,1,NULL,NULL,'Menambah praktikum \"Data Science.\" dengan import excel.',NULL,'2019-01-31 10:37:07','2019-01-31 10:37:07',NULL,1,NULL,NULL),
	(206,1,NULL,NULL,'Menambah praktikum \"Machine Learning.\" dengan import excel.',NULL,'2019-01-31 10:41:18','2019-01-31 10:41:18',NULL,1,NULL,NULL),
	(207,1,NULL,NULL,'Menambah praktikum \"Data Science.\" dengan import excel.',NULL,'2019-01-31 10:41:18','2019-01-31 10:41:18',NULL,1,NULL,NULL),
	(208,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:50:09','2019-01-31 10:50:09',NULL,1,NULL,NULL),
	(209,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:50:13','2019-01-31 10:50:13',NULL,1,NULL,NULL),
	(210,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:50:17','2019-01-31 10:50:17',NULL,1,NULL,NULL),
	(211,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:50:20','2019-01-31 10:50:20',NULL,1,NULL,NULL),
	(212,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:50:24','2019-01-31 10:50:24',NULL,1,NULL,NULL),
	(213,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:50:28','2019-01-31 10:50:28',NULL,1,NULL,NULL),
	(214,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:50:33','2019-01-31 10:50:33',NULL,1,NULL,NULL),
	(215,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:50:36','2019-01-31 10:50:36',NULL,1,NULL,NULL),
	(216,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:50:40','2019-01-31 10:50:40',NULL,1,NULL,NULL),
	(217,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:50:48','2019-01-31 10:50:48',NULL,1,NULL,NULL),
	(218,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:50:54','2019-01-31 10:50:54',NULL,1,NULL,NULL),
	(219,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:51:00','2019-01-31 10:51:00',NULL,1,NULL,NULL),
	(220,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:51:04','2019-01-31 10:51:04',NULL,1,NULL,NULL),
	(221,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:51:09','2019-01-31 10:51:09',NULL,1,NULL,NULL),
	(222,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:51:13','2019-01-31 10:51:13',NULL,1,NULL,NULL),
	(223,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:51:17','2019-01-31 10:51:17',NULL,1,NULL,NULL),
	(224,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:51:22','2019-01-31 10:51:22',NULL,1,NULL,NULL),
	(225,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:51:27','2019-01-31 10:51:27',NULL,1,NULL,NULL),
	(226,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:51:32','2019-01-31 10:51:32',NULL,1,NULL,NULL),
	(227,1,NULL,NULL,'Menghapus Praktikum Aktif.',NULL,'2019-01-31 10:51:44','2019-01-31 10:51:44',NULL,1,NULL,NULL),
	(228,7,NULL,NULL,'Menambah praktikum \"Algen.\" dengan import excel.',NULL,'2019-01-31 11:26:49','2019-01-31 11:26:49',NULL,7,NULL,NULL),
	(229,7,NULL,NULL,'Menambah praktikum \"PBO.\" dengan import excel.',NULL,'2019-01-31 11:36:38','2019-01-31 11:36:38',NULL,7,NULL,NULL),
	(230,7,NULL,NULL,'Menambah praktikum \"PBO.\" dengan import excel.',NULL,'2019-01-31 11:37:58','2019-01-31 11:37:58',NULL,7,NULL,NULL),
	(231,7,NULL,NULL,'Menambah Praktikum Aktif.',NULL,'2019-01-31 11:49:01','2019-01-31 11:49:01',NULL,7,NULL,NULL),
	(232,7,NULL,NULL,'Menambah Praktikum Aktif.',NULL,'2019-01-31 11:49:37','2019-01-31 11:49:37',NULL,7,NULL,NULL),
	(233,7,NULL,NULL,'Menambah Praktikum Aktif.',NULL,'2019-01-31 11:54:29','2019-01-31 11:54:29',NULL,7,NULL,NULL),
	(234,7,NULL,NULL,'Menonaktifkan Praktikum Aktif.',NULL,'2019-01-31 11:58:57','2019-01-31 11:58:57',NULL,7,NULL,NULL),
	(235,7,NULL,NULL,'Menonaktifkan Praktikum Aktif.',NULL,'2019-01-31 11:59:02','2019-01-31 11:59:02',NULL,7,NULL,NULL),
	(236,7,NULL,NULL,'Menonaktifkan Praktikum Aktif.',NULL,'2019-01-31 11:59:08','2019-01-31 11:59:08',NULL,7,NULL,NULL),
	(237,21,NULL,NULL,'Mendaftar Pendaftaran Praktikum.',NULL,'2019-01-31 12:00:03','2019-01-31 12:00:03',NULL,21,NULL,NULL),
	(238,1,NULL,NULL,'Mengubah Dosen.',NULL,'2019-01-31 12:00:05','2019-01-31 12:00:05',NULL,1,NULL,NULL),
	(239,21,NULL,NULL,'Mendaftar Pendaftaran Praktikum.',NULL,'2019-01-31 12:00:08','2019-01-31 12:00:08',NULL,21,NULL,NULL),
	(240,1,NULL,NULL,'Menambah Dosen.',NULL,'2019-01-31 12:01:19','2019-01-31 12:01:19',NULL,1,NULL,NULL),
	(241,1,NULL,NULL,'Mengubah Dosen.',NULL,'2019-01-31 12:01:32','2019-01-31 12:01:32',NULL,1,NULL,NULL),
	(242,1,NULL,NULL,'Mengubah Dosen.',NULL,'2019-01-31 12:01:44','2019-01-31 12:01:44',NULL,1,NULL,NULL),
	(243,5,NULL,NULL,'Menambah Presensi Praktikum.',NULL,'2019-01-31 12:01:49','2019-01-31 12:01:49',NULL,5,NULL,NULL),
	(244,3,NULL,NULL,'Mengubah Praktikum Aktif.',NULL,'2019-01-31 12:02:31','2019-01-31 12:02:31',NULL,3,NULL,NULL),
	(245,1,NULL,NULL,'Mengubah Dosen.',NULL,'2019-01-31 12:03:15','2019-01-31 12:03:15',NULL,1,NULL,NULL),
	(246,1,NULL,NULL,'Mengubah Mahasiswa.',NULL,'2019-01-31 12:03:24','2019-01-31 12:03:24',NULL,1,NULL,NULL),
	(247,1,NULL,NULL,'Menambah Laboratorium.',NULL,'2019-01-31 12:04:41','2019-01-31 12:04:41',NULL,1,NULL,NULL),
	(248,1,NULL,NULL,'Mengubah Laboratorium.',NULL,'2019-01-31 12:05:00','2019-01-31 12:05:00',NULL,1,NULL,NULL),
	(249,1,NULL,NULL,'Mengubah Laboratorium.',NULL,'2019-01-31 12:05:09','2019-01-31 12:05:09',NULL,1,NULL,NULL),
	(250,3,NULL,NULL,'Mengubah Praktikum Aktif.',NULL,'2019-01-31 12:05:40','2019-01-31 12:05:40',NULL,3,NULL,NULL),
	(251,3,NULL,NULL,'Menambah Praktikum Aktif.',NULL,'2019-01-31 12:05:58','2019-01-31 12:05:58',NULL,3,NULL,NULL),
	(252,9,NULL,NULL,'Mendaftar Pendaftaran Praktikum.',NULL,'2019-01-31 12:06:15','2019-01-31 12:06:15',NULL,9,NULL,NULL),
	(253,9,NULL,NULL,'Mendaftar Pendaftaran Praktikum.',NULL,'2019-01-31 12:06:20','2019-01-31 12:06:20',NULL,9,NULL,NULL),
	(254,1,NULL,NULL,'Mengubah Laboratorium.',NULL,'2019-01-31 12:08:06','2019-01-31 12:08:06',NULL,1,NULL,NULL),
	(255,1,NULL,NULL,'Mengubah Laboratorium.',NULL,'2019-01-31 13:02:11','2019-01-31 13:02:11',NULL,1,NULL,NULL),
	(256,1,NULL,NULL,'Menghapus Laboratorium.',NULL,'2019-01-31 13:02:15','2019-01-31 13:02:15',NULL,1,NULL,NULL),
	(257,1,NULL,NULL,'Mengubah Laboratorium.',NULL,'2019-01-31 13:02:55','2019-01-31 13:02:55',NULL,1,NULL,NULL),
	(258,1,NULL,NULL,'Mengubah Laboratorium.',NULL,'2019-01-31 13:03:04','2019-01-31 13:03:04',NULL,1,NULL,NULL),
	(259,1,NULL,NULL,'Mengubah Praktikum Aktif.',NULL,'2019-01-31 13:05:21','2019-01-31 13:05:21',NULL,1,NULL,NULL),
	(260,7,NULL,NULL,'Mengubah Praktikum Aktif.',NULL,'2019-01-31 13:11:59','2019-01-31 13:11:59',NULL,7,NULL,NULL),
	(261,7,NULL,NULL,'Mengubah Praktikum Aktif.',NULL,'2019-01-31 13:17:43','2019-01-31 13:17:43',NULL,7,NULL,NULL),
	(262,7,NULL,NULL,'Mengubah Praktikum Aktif.',NULL,'2019-01-31 13:34:25','2019-01-31 13:34:25',NULL,7,NULL,NULL),
	(263,9,NULL,NULL,'Mendaftar Pendaftaran Praktikum.',NULL,'2019-01-31 13:40:36','2019-01-31 13:40:36',NULL,9,NULL,NULL),
	(264,1,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-31 13:41:06','2019-01-31 13:41:06',NULL,1,NULL,NULL),
	(265,1,NULL,NULL,'Mengubah Laboratorium.',NULL,'2019-01-31 13:45:03','2019-01-31 13:45:03',NULL,1,NULL,NULL),
	(266,1,NULL,NULL,'Mengubah Laboratorium.',NULL,'2019-01-31 13:45:15','2019-01-31 13:45:15',NULL,1,NULL,NULL),
	(267,1,NULL,NULL,'Mengubah Laboratorium.',NULL,'2019-01-31 13:45:36','2019-01-31 13:45:36',NULL,1,NULL,NULL),
	(268,3,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-31 14:03:21','2019-01-31 14:03:21',NULL,3,NULL,NULL),
	(269,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-31 14:18:09','2019-01-31 14:18:09',NULL,7,NULL,NULL),
	(270,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-31 14:18:15','2019-01-31 14:18:15',NULL,7,NULL,NULL),
	(271,1,NULL,NULL,'Menambah Laboratorium.',NULL,'2019-01-31 14:21:23','2019-01-31 14:21:23',NULL,1,NULL,NULL),
	(272,1,NULL,NULL,'Mengubah Laboratorium.',NULL,'2019-01-31 14:21:31','2019-01-31 14:21:31',NULL,1,NULL,NULL),
	(273,1,NULL,NULL,'Mengubah Laboratorium.',NULL,'2019-01-31 14:21:37','2019-01-31 14:21:37',NULL,1,NULL,NULL),
	(274,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-31 14:23:30','2019-01-31 14:23:30',NULL,7,NULL,NULL),
	(275,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-31 14:23:39','2019-01-31 14:23:39',NULL,7,NULL,NULL),
	(276,7,NULL,NULL,'Mengubah status Pendaftaran Praktikum Aktif.',NULL,'2019-01-31 14:23:54','2019-01-31 14:23:54',NULL,7,NULL,NULL),
	(277,1,NULL,NULL,'Mengubah Laboratorium.',NULL,'2019-01-31 14:24:12','2019-01-31 14:24:12',NULL,1,NULL,NULL),
	(278,1,NULL,NULL,'Mengubah Laboratorium.',NULL,'2019-01-31 14:24:26','2019-01-31 14:24:26',NULL,1,NULL,NULL);

/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table mahasiswa
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mahasiswa`;

CREATE TABLE `mahasiswa` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `nim` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `mahasiswa` WRITE;
/*!40000 ALTER TABLE `mahasiswa` DISABLE KEYS */;

INSERT INTO `mahasiswa` (`id`, `id_user`, `nim`, `alamat`, `email`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES
	(1,9,'4611414043','Jl. HR. Hardijanto No. 7 RT.01 RW.02, Jakarta Pusat','mahasiswa@mail.com','2018-12-29 11:17:04','2019-01-31 12:03:24',NULL,3,1,0),
	(2,10,'4611414042','Jl. HR Hardijanto','mahasiswa2@mail.com','2018-12-29 11:18:05','2018-12-29 11:18:05',NULL,3,0,0),
	(3,16,'4611414026','Brebes','anbiya@mail.co.id','2019-01-30 18:24:09','2019-01-30 18:24:14','2019-01-30 18:24:14',1,0,1),
	(4,17,'4611414027','Jakarta','bulir@mail.co.my','2019-01-30 18:24:09','2019-01-30 18:24:17','2019-01-30 18:24:17',1,0,1),
	(5,19,'4611414026','Brebes','anbiya@mail.co.id','2019-01-31 10:07:38','2019-01-31 10:07:38',NULL,1,0,0),
	(6,20,'4611414027','Jakarta','bulir@mail.co.my','2019-01-31 10:07:38','2019-01-31 10:07:38',NULL,1,0,0),
	(7,21,'4569797913','Brebes','anbiya@mail.co.id','2019-01-31 10:12:01','2019-01-31 10:12:01',NULL,1,0,0);

/*!40000 ALTER TABLE `mahasiswa` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table menus
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `routing` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;

INSERT INTO `menus` (`id`, `menu`, `route`, `routing`, `icon`, `urutan`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES
	(1,'Dashboard','dashboard','dashboard.read','fa-dashboard',1,'2018-04-18 00:00:00',NULL,NULL,NULL,NULL,NULL),
	(2,'Users','users','users.read','fa-users',2,'2018-04-18 00:00:00',NULL,NULL,NULL,NULL,NULL),
	(3,'Application Config','configs','configs.read','fa-th',5,'2018-04-18 00:00:00',NULL,NULL,NULL,NULL,NULL),
	(4,'Profil','profile','profile.read','fa-user-circle',6,'2018-01-16 00:00:00',NULL,NULL,NULL,NULL,NULL),
	(5,'Log','log','log.read','fa-terminal',7,'2018-01-16 00:00:00',NULL,NULL,NULL,NULL,NULL),
	(6,'Trash','trash','trash.read','fa-trash',90,'2018-05-24 08:27:52','2018-05-24 08:28:55','2018-05-24 08:28:55',3,NULL,3),
	(7,'Trash','trash','trash.read','fa-trash',90,'2018-05-24 08:29:32','2018-05-24 08:34:54','2018-05-24 08:34:54',3,NULL,3),
	(8,'Trash','trash','trash.read','fa-trash',90,'2018-05-24 08:35:21','2018-05-24 08:57:26','2018-05-24 08:57:26',3,NULL,3),
	(9,'Dosen','dosen','dosen.read','fa-graduation-cap',7,'2018-12-29 10:29:17','2018-12-29 10:29:17',NULL,3,NULL,NULL),
	(10,'Kepala Laboratorium','kalab','kalab.read','fa-user-circle-o',8,'2018-12-29 10:57:21','2018-12-29 10:57:21',NULL,3,NULL,NULL),
	(11,'Mahasiswa','mahasiswa','mahasiswa.read','fa-users',9,'2018-12-29 11:15:45','2018-12-29 11:15:45',NULL,3,NULL,NULL),
	(12,'Laboratorium','laboratorium','laboratorium.read','fa-building-o',10,'2018-12-29 13:25:32','2018-12-29 13:25:32',NULL,3,NULL,NULL),
	(13,'Praktikum','praktikum','praktikum.read','fa-language',11,'2019-01-02 08:19:41','2019-01-02 08:19:48',NULL,3,3,NULL),
	(14,'Pendaftaran Praktikum','pendaftaranpraktikum','pendaftaranpraktikum.read','fa-sign-in',12,'2019-01-10 11:56:24','2019-01-10 11:56:24',NULL,3,NULL,NULL),
	(15,'Praktikum Dosen','praktikumdosen','praktikumdosen.read','fa-language',13,'2019-01-11 07:29:21','2019-01-11 09:33:53','2019-01-11 09:33:53',3,NULL,3),
	(16,'Jadwal Praktikum','jadwalpraktikum','jadwalpraktikum.read','fa-calendar',13,'2019-01-11 21:50:07','2019-01-11 21:50:07',NULL,3,NULL,NULL),
	(17,'History Praktikum','historypraktikum','historypraktikum.read','fa-calendar-check-o',14,'2019-01-15 12:16:52','2019-01-15 12:17:54',NULL,3,3,NULL),
	(18,'Modul','modul','modul.read','fa-book',15,'2019-01-21 09:52:45','2019-01-21 09:52:45',NULL,3,NULL,NULL);

/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'2014_10_12_000000_create_users_table',1),
	(2,'2014_10_12_100000_create_password_resets_table',1),
	(3,'2018_01_11_080123_create_menus_table',1),
	(4,'2018_01_11_081038_create_previleges_table',1),
	(5,'2018_01_11_081301_create_levels_table',1),
	(6,'2018_01_11_082649_create_user_levels_table',1),
	(7,'2018_01_11_091032_create_contents_table',1),
	(8,'2018_01_11_092154_add_column_to_users_table',1),
	(9,'2018_01_11_094545_add_soft_delete_to_users_table',1),
	(10,'2018_01_11_141306_create_submenus_table',1),
	(11,'2018_01_11_141844_add_column_to_submenus_table',1),
	(19,'2018_01_16_072632_create_submissions_table',2),
	(20,'2018_01_16_072735_create_abstract_reviews_table',2),
	(21,'2018_01_16_072810_create_publication_types_table',2),
	(22,'2018_01_16_072948_create_prices_table',2),
	(23,'2018_01_16_073018_create_scopes_table',2),
	(24,'2018_01_16_073050_create_countries_table',2),
	(25,'2018_01_16_073600_create_payments_table',2),
	(26,'2018_01_17_051942_create_status_table',3),
	(27,'2018_01_17_052837_create_full_paper_reviews_table',4),
	(28,'2018_01_17_055822_add_class_to_status_table',4),
	(29,'2018_01_17_065603_create_author_submission_update_table',4),
	(30,'2018_01_17_070247_create_reviewer_submission_review_table',4),
	(31,'2018_03_07_043346_create_log_table',5),
	(32,'2018_03_07_043535_create_masuk_table',5),
	(33,'2018_03_07_043619_create_keluar_table',5),
	(34,'2018_03_07_043731_create_barang_table',5),
	(35,'2018_03_07_043856_create_agen_table',5),
	(36,'2018_03_07_043935_create_status_keluar_table',5),
	(37,'2018_03_07_044025_create_satuan_table',5),
	(38,'2018_03_07_044109_create_kategori_agen_table',5),
	(39,'2018_03_26_142643_create_jalur_table',6),
	(40,'2018_04_01_093147_create_keuangan_table',7),
	(41,'2018_12_29_084416_create_laboratorium_table',8),
	(42,'2018_12_29_084428_create_kalab_table',8),
	(43,'2018_12_29_084434_create_dosen_table',8),
	(44,'2018_12_29_084440_create_hari_table',8),
	(45,'2018_12_29_084440_create_mahasiswa_table',8),
	(46,'2018_12_29_084451_create_praktikum_table',8),
	(47,'2018_12_29_084504_create_peserta_praktikum_table',8),
	(48,'2018_12_29_084513_create_pertemuan_table',8),
	(49,'2018_12_29_084520_create_tipe_kehadiran_table',8),
	(50,'2018_12_29_084523_create_presensi_praktikum_table',8),
	(51,'2018_12_29_084536_create_penilaian_praktikum_table',8),
	(52,'2018_12_29_084543_create_modul_table',8);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table modul
# ------------------------------------------------------------

DROP TABLE IF EXISTS `modul`;

CREATE TABLE `modul` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `modul` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `modul` WRITE;
/*!40000 ALTER TABLE `modul` DISABLE KEYS */;

INSERT INTO `modul` (`id`, `modul`, `file`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES
	(1,'Contoh Report Nilai','1548039242.pdf','2019-01-21 09:54:02','2019-01-21 09:54:02',NULL,3,0,0);

/*!40000 ALTER TABLE `modul` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table nilai_praktikum
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nilai_praktikum`;

CREATE TABLE `nilai_praktikum` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_praktikum` int(11) NOT NULL,
  `id_user_mahasiswa` int(11) NOT NULL,
  `nilai` float NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `nilai_praktikum` WRITE;
/*!40000 ALTER TABLE `nilai_praktikum` DISABLE KEYS */;

INSERT INTO `nilai_praktikum` (`id`, `id_praktikum`, `id_user_mahasiswa`, `nilai`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES
	(1,1,9,87,'2019-01-11 21:24:00','2019-01-11 21:24:00',NULL,5,0,0),
	(2,1,10,86,'2019-01-11 21:24:00','2019-01-11 21:24:00',NULL,5,0,0),
	(3,2,9,68,'2019-01-12 14:48:23','2019-01-12 14:48:23',NULL,1,0,0),
	(4,3,9,89,'2019-01-12 15:36:42','2019-01-12 15:36:42',NULL,1,0,0),
	(5,5,9,90,'2019-01-12 15:58:40','2019-01-12 15:58:40',NULL,1,0,0),
	(6,6,9,80,'2019-01-12 18:56:40','2019-01-12 18:56:40',NULL,11,0,0);

/*!40000 ALTER TABLE `nilai_praktikum` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;

INSERT INTO `password_resets` (`email`, `token`, `created_at`)
VALUES
	('admin@midnight-dev.com','$2y$10$WPFMN/CsSuueMQW6CCxZm.curzps5jqEH6SAXLEAicqZcSQwP0Z2y','2018-02-19 07:25:56');

/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table pertemuan
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pertemuan`;

CREATE TABLE `pertemuan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_praktikum` int(11) NOT NULL,
  `waktu_pertemuan` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `pertemuan` WRITE;
/*!40000 ALTER TABLE `pertemuan` DISABLE KEYS */;

INSERT INTO `pertemuan` (`id`, `id_praktikum`, `waktu_pertemuan`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES
	(2,1,'2019-01-11 13:41:03','2019-01-11 13:41:03','2019-01-11 13:41:03',NULL,5,0,0),
	(3,1,'2019-01-11 13:56:10','2019-01-11 13:56:10','2019-01-11 13:56:10',NULL,5,0,0),
	(4,1,'2019-01-12 14:47:27','2019-01-12 14:47:27','2019-01-12 14:47:27',NULL,1,0,0),
	(5,1,'2019-01-12 14:47:43','2019-01-12 14:47:43','2019-01-12 14:47:43',NULL,1,0,0),
	(6,1,'2019-01-12 15:51:43','2019-01-12 15:51:43','2019-01-12 15:51:43',NULL,5,0,0),
	(7,6,'2019-01-12 18:44:50','2019-01-12 18:44:50','2019-01-12 18:44:50',NULL,11,0,0),
	(8,6,'2019-01-12 18:56:15','2019-01-12 18:56:15','2019-01-12 18:56:15',NULL,11,0,0),
	(9,3,'2019-01-12 19:44:09','2019-01-12 19:44:09','2019-01-12 19:44:09',NULL,5,0,0),
	(10,2,'2019-01-15 15:03:27','2019-01-15 15:03:27','2019-01-15 15:03:27',NULL,5,0,0),
	(11,8,'2019-01-31 12:01:49','2019-01-31 12:01:49','2019-01-31 12:01:49',NULL,5,0,0);

/*!40000 ALTER TABLE `pertemuan` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table peserta_praktikum
# ------------------------------------------------------------

DROP TABLE IF EXISTS `peserta_praktikum`;

CREATE TABLE `peserta_praktikum` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_praktikum` int(11) NOT NULL,
  `id_user_mahasiswa` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `peserta_praktikum` WRITE;
/*!40000 ALTER TABLE `peserta_praktikum` DISABLE KEYS */;

INSERT INTO `peserta_praktikum` (`id`, `id_praktikum`, `id_user_mahasiswa`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES
	(1,1,9,'2019-01-10 12:15:28','2019-01-10 12:15:28',NULL,0,0,0),
	(2,1,10,'2019-01-10 12:16:45','2019-01-10 12:16:49','2019-01-10 12:16:49',0,0,10),
	(3,1,10,'2019-01-10 12:16:53','2019-01-10 12:16:53',NULL,0,0,0),
	(4,2,9,'2019-01-11 07:22:52','2019-01-19 22:16:42','2019-01-19 22:16:42',0,0,9),
	(5,3,9,'2019-01-12 14:52:53','2019-01-12 14:52:53',NULL,0,0,0),
	(6,4,9,'2019-01-12 15:43:55','2019-01-17 11:58:18','2019-01-17 11:58:18',0,0,9),
	(7,5,9,'2019-01-12 15:43:58','2019-01-12 15:43:58',NULL,0,0,0),
	(8,6,9,'2019-01-12 18:22:24','2019-01-12 18:22:24',NULL,0,0,0),
	(9,4,9,'2019-01-17 11:58:21','2019-01-23 14:58:47','2019-01-23 14:58:47',0,0,9),
	(10,2,9,'2019-01-21 16:30:35','2019-01-21 16:30:35',NULL,0,0,0),
	(11,7,9,'2019-01-21 16:44:59','2019-01-21 16:44:59',NULL,0,0,0),
	(12,8,9,'2019-01-21 17:35:19','2019-01-21 17:35:19',NULL,0,0,0),
	(13,12,21,'2019-01-31 10:29:06','2019-01-31 10:29:06',NULL,0,0,0),
	(14,15,21,'2019-01-31 10:29:33','2019-01-31 10:29:33',NULL,0,0,0),
	(15,4,21,'2019-01-31 12:00:03','2019-01-31 12:00:03',NULL,0,0,0),
	(16,37,21,'2019-01-31 12:00:08','2019-01-31 12:00:08',NULL,0,0,0),
	(17,13,9,'2019-01-31 12:06:15','2019-01-31 12:06:15',NULL,0,0,0),
	(18,37,9,'2019-01-31 12:06:20','2019-01-31 12:06:20',NULL,0,0,0),
	(19,4,9,'2019-01-31 13:40:36','2019-01-31 13:40:36',NULL,0,0,0);

/*!40000 ALTER TABLE `peserta_praktikum` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table praktikum
# ------------------------------------------------------------

DROP TABLE IF EXISTS `praktikum`;

CREATE TABLE `praktikum` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_laboratorium` int(11) NOT NULL,
  `id_user_dosen` int(11) NOT NULL,
  `id_hari` int(11) NOT NULL,
  `praktikum` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `is_pendaftaran` smallint(1) NOT NULL DEFAULT 1,
  `is_aktif` smallint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `praktikum` WRITE;
/*!40000 ALTER TABLE `praktikum` DISABLE KEYS */;

INSERT INTO `praktikum` (`id`, `id_laboratorium`, `id_user_dosen`, `id_hari`, `praktikum`, `waktu_mulai`, `waktu_selesai`, `is_pendaftaran`, `is_aktif`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES
	(1,1,5,1,'Praktikum Desain Grafis','07:00:00','09:00:00',0,0,'2019-01-03 15:45:07','2019-01-15 14:39:14',NULL,3,3,0),
	(2,1,5,2,'Praktikum Desain Manga','12:30:00','14:30:00',0,1,'2019-01-03 15:47:36','2019-01-31 13:34:25',NULL,3,7,0),
	(3,2,5,1,'Praktikum Desain Video','12:30:00','14:30:00',0,1,'2019-01-03 15:54:28','2019-01-21 17:34:26',NULL,3,7,0),
	(4,2,11,2,'Praktikum Desain Video','09:30:00','11:30:00',0,1,'2019-01-03 15:59:49','2019-01-31 13:41:06',NULL,3,1,0),
	(5,1,5,1,'Algoritma','12:19:00','01:19:00',0,1,'2019-01-12 12:19:45','2019-01-31 13:11:59',NULL,14,7,0),
	(6,2,11,5,'Desain Produk','10:00:00','12:00:00',0,1,'2019-01-12 18:21:59','2019-01-31 14:03:21',NULL,3,3,0),
	(7,1,11,4,'Baspro','00:18:00','13:35:00',0,1,'2019-01-21 16:36:19','2019-01-31 14:18:15',NULL,7,7,0),
	(8,2,5,5,'Visual','12:28:00','14:28:00',0,1,'2019-01-21 17:28:32','2019-01-21 17:42:56',NULL,7,7,0),
	(9,1,11,4,'Machine Learning','10:00:00','12:00:00',1,1,'2019-01-30 18:24:28','2019-01-30 18:24:34','2019-01-30 18:24:34',1,0,1),
	(10,2,5,5,'Data Science','13:00:00','14:30:00',1,1,'2019-01-30 18:24:28','2019-01-30 18:24:46','2019-01-30 18:24:46',1,0,1),
	(11,1,11,4,'Machine Learning','10:00:00','12:00:00',1,1,'2019-01-31 10:08:39','2019-01-31 10:51:32','2019-01-31 10:51:32',1,0,1),
	(12,2,5,5,'Data Science','13:00:00','14:30:00',1,1,'2019-01-31 10:08:39','2019-01-31 10:50:17','2019-01-31 10:50:17',1,0,1),
	(13,2,11,5,'Algen','05:00:00','07:00:00',0,1,'2019-01-31 10:14:41','2019-01-31 14:18:09',NULL,1,7,0),
	(14,1,11,4,'Machine Learning','10:00:00','12:00:00',1,1,'2019-01-31 10:21:02','2019-01-31 10:51:27','2019-01-31 10:51:27',1,0,1),
	(15,2,5,5,'Data Science','13:00:00','14:30:00',1,1,'2019-01-31 10:21:02','2019-01-31 10:50:09','2019-01-31 10:50:09',1,0,1),
	(16,1,11,4,'Machine Learning','10:00:00','12:00:00',1,1,'2019-01-31 10:21:29','2019-01-31 10:51:22','2019-01-31 10:51:22',1,0,1),
	(17,2,5,5,'Data Science','13:00:00','14:30:00',1,1,'2019-01-31 10:21:29','2019-01-31 10:50:13','2019-01-31 10:50:13',1,0,1),
	(18,1,11,4,'Machine Learning','10:00:00','12:00:00',1,1,'2019-01-31 10:23:05','2019-01-31 10:51:17','2019-01-31 10:51:17',1,0,1),
	(19,2,5,5,'Data Science','13:00:00','14:30:00',1,1,'2019-01-31 10:23:05','2019-01-31 10:50:20','2019-01-31 10:50:20',1,0,1),
	(20,1,11,4,'Machine Learning','10:00:00','12:00:00',1,1,'2019-01-31 10:30:17','2019-01-31 10:51:13','2019-01-31 10:51:13',1,0,1),
	(21,2,5,5,'Data Science','13:00:00','14:30:00',1,1,'2019-01-31 10:30:17','2019-01-31 10:50:24','2019-01-31 10:50:24',1,0,1),
	(22,1,11,4,'Machine Learning','10:00:00','12:00:00',1,1,'2019-01-31 10:33:26','2019-01-31 10:51:09','2019-01-31 10:51:09',1,0,1),
	(23,2,5,5,'Data Science','13:00:00','14:30:00',1,1,'2019-01-31 10:33:26','2019-01-31 10:50:40','2019-01-31 10:50:40',1,0,1),
	(24,1,11,4,'Machine Learning','10:00:00','12:00:00',1,1,'2019-01-31 10:33:57','2019-01-31 10:51:04','2019-01-31 10:51:04',1,0,1),
	(25,2,5,5,'Data Science','13:00:00','14:30:00',1,1,'2019-01-31 10:33:57','2019-01-31 10:50:28','2019-01-31 10:50:28',1,0,1),
	(26,1,11,4,'Machine Learning','10:00:00','12:00:00',1,1,'2019-01-31 10:36:57','2019-01-31 10:51:00','2019-01-31 10:51:00',1,0,1),
	(27,2,5,5,'Data Science','13:00:00','14:30:00',1,1,'2019-01-31 10:36:57','2019-01-31 10:50:36','2019-01-31 10:50:36',1,0,1),
	(28,1,11,4,'Machine Learning','10:00:00','12:00:00',1,1,'2019-01-31 10:37:07','2019-01-31 10:50:54','2019-01-31 10:50:54',1,0,1),
	(29,2,5,5,'Data Science','13:00:00','14:30:00',1,1,'2019-01-31 10:37:07','2019-01-31 10:51:44','2019-01-31 10:51:44',1,0,1),
	(30,1,11,4,'Machine Learning','10:00:00','12:00:00',1,1,'2019-01-31 10:41:18','2019-01-31 10:50:48','2019-01-31 10:50:48',1,0,1),
	(31,2,5,5,'Data Science','13:00:00','14:30:00',1,1,'2019-01-31 10:41:18','2019-01-31 10:50:33','2019-01-31 10:50:33',1,0,1),
	(32,2,11,5,'Algen','00:00:00','00:00:00',1,0,'2019-01-31 11:26:49','2019-01-31 11:58:57',NULL,7,7,0),
	(33,2,11,2,'PBO','00:00:00','00:00:00',1,0,'2019-01-31 11:36:38','2019-01-31 11:59:02',NULL,7,7,0),
	(34,2,11,2,'PBO','00:00:00','00:00:00',1,0,'2019-01-31 11:37:58','2019-01-31 11:59:08',NULL,7,7,0),
	(35,3,18,3,'visual','00:00:00','14:06:00',1,1,'2019-01-31 11:49:01','2019-01-31 14:23:39',NULL,7,7,0),
	(36,2,18,1,'Program Java','06:00:00','08:00:00',1,1,'2019-01-31 11:49:37','2019-01-31 11:49:37',NULL,7,0,0),
	(37,3,11,6,'java','06:00:00','08:00:00',0,1,'2019-01-31 11:54:29','2019-01-31 14:23:54',NULL,7,7,0),
	(38,1,22,2,'Algoritmaaa','11:35:00','12:10:00',1,1,'2019-01-31 12:05:58','2019-01-31 13:05:21',NULL,3,1,0);

/*!40000 ALTER TABLE `praktikum` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table presensi_praktikum
# ------------------------------------------------------------

DROP TABLE IF EXISTS `presensi_praktikum`;

CREATE TABLE `presensi_praktikum` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_pertemuan` int(11) NOT NULL,
  `id_user_mahasiswa` int(11) NOT NULL,
  `id_tipe_kehadiran` int(11) NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `presensi_praktikum` WRITE;
/*!40000 ALTER TABLE `presensi_praktikum` DISABLE KEYS */;

INSERT INTO `presensi_praktikum` (`id`, `id_pertemuan`, `id_user_mahasiswa`, `id_tipe_kehadiran`, `keterangan`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES
	(1,2,9,1,'-','2019-01-11 13:41:03','2019-01-11 13:41:03',NULL,5,0,0),
	(2,2,10,2,'Magh','2019-01-11 13:41:03','2019-01-11 13:41:03',NULL,5,0,0),
	(3,3,9,1,'-','2019-01-11 13:56:10','2019-01-11 13:56:10',NULL,5,0,0),
	(4,3,10,1,'-','2019-01-11 13:56:10','2019-01-11 13:56:10',NULL,5,0,0),
	(5,4,9,2,'-','2019-01-12 14:47:27','2019-01-12 14:47:27',NULL,1,0,0),
	(6,5,9,1,'Hadir','2019-01-12 14:47:43','2019-01-12 14:47:43',NULL,1,0,0),
	(7,6,9,3,'Ijin','2019-01-12 15:51:43','2019-01-12 15:51:43',NULL,5,0,0),
	(8,6,10,1,'-','2019-01-12 15:51:43','2019-01-12 15:51:43',NULL,5,0,0),
	(9,7,9,1,'-','2019-01-12 18:44:50','2019-01-12 18:44:50',NULL,11,0,0),
	(10,8,9,2,'Gigi','2019-01-12 18:56:15','2019-01-12 18:56:15',NULL,11,0,0),
	(11,9,9,3,'-','2019-01-12 19:44:09','2019-01-12 19:44:09',NULL,5,0,0),
	(12,10,9,1,'-','2019-01-15 15:03:27','2019-01-15 15:03:27',NULL,5,0,0),
	(13,11,9,1,'-','2019-01-31 12:01:49','2019-01-31 12:01:49',NULL,5,0,0);

/*!40000 ALTER TABLE `presensi_praktikum` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table previleges
# ------------------------------------------------------------

DROP TABLE IF EXISTS `previleges`;

CREATE TABLE `previleges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_level` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `create` int(11) NOT NULL DEFAULT 0,
  `read` int(11) NOT NULL DEFAULT 0,
  `update` int(11) NOT NULL DEFAULT 0,
  `delete` int(11) NOT NULL DEFAULT 0,
  `validate` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `previleges` WRITE;
/*!40000 ALTER TABLE `previleges` DISABLE KEYS */;

INSERT INTO `previleges` (`id`, `id_level`, `id_menu`, `create`, `read`, `update`, `delete`, `validate`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,1,1,1,1,1,1,1,NULL,'2018-04-13 20:47:55',NULL),
	(2,1,2,1,1,1,1,1,NULL,'2018-04-21 20:45:27',NULL),
	(3,1,3,1,1,1,1,1,NULL,NULL,NULL),
	(4,1,4,1,1,1,1,1,NULL,'2018-04-21 20:45:28',NULL),
	(5,1,5,1,1,1,1,1,NULL,NULL,NULL),
	(6,2,1,0,1,0,0,0,NULL,'2019-01-31 19:58:25',NULL),
	(7,2,2,0,1,0,0,0,NULL,NULL,NULL),
	(8,2,3,0,0,0,0,0,'2018-04-18 13:40:04','2018-04-18 13:40:04',NULL),
	(9,2,4,1,1,1,1,0,'2018-04-18 14:02:14','2019-01-12 18:07:58',NULL),
	(10,2,5,0,0,0,0,0,'2018-04-18 14:03:12','2018-04-18 14:03:12',NULL),
	(11,1,6,0,0,0,0,0,'2018-05-24 08:27:52','2018-05-24 08:28:55','2018-05-24 08:28:55'),
	(12,2,6,0,0,0,0,0,'2018-05-24 08:27:52','2018-05-24 08:28:55','2018-05-24 08:28:55'),
	(13,1,7,0,0,0,0,0,'2018-05-24 08:29:32','2018-05-24 08:34:54','2018-05-24 08:34:54'),
	(14,2,7,0,0,0,0,0,'2018-05-24 08:29:32','2018-05-24 08:34:54','2018-05-24 08:34:54'),
	(15,1,8,0,0,0,0,0,'2018-05-24 08:35:21','2018-05-24 08:57:26','2018-05-24 08:57:26'),
	(16,2,8,1,1,1,1,1,'2018-05-24 08:35:21','2018-05-24 08:57:26','2018-05-24 08:57:26'),
	(17,3,1,0,1,0,0,0,'2018-12-29 10:10:21','2019-01-31 19:57:09',NULL),
	(18,3,2,0,0,0,0,0,'2018-12-29 10:10:21','2018-12-29 10:10:21',NULL),
	(19,3,3,0,0,0,0,0,'2018-12-29 10:10:21','2018-12-29 10:10:21',NULL),
	(20,3,4,0,1,0,0,0,'2018-12-29 10:10:21','2019-01-12 11:46:10',NULL),
	(21,3,5,0,0,0,0,0,'2018-12-29 10:10:21','2019-01-21 16:27:43',NULL),
	(22,4,1,0,1,0,0,0,'2018-12-29 10:10:25','2019-01-11 07:39:59',NULL),
	(23,4,2,0,0,0,0,0,'2018-12-29 10:10:25','2019-01-11 07:40:01',NULL),
	(24,4,3,0,0,0,0,0,'2018-12-29 10:10:25','2019-01-11 07:40:03',NULL),
	(25,4,4,0,1,0,0,0,'2018-12-29 10:10:25','2019-01-12 15:49:52',NULL),
	(26,4,5,0,0,0,0,0,'2018-12-29 10:10:25','2018-12-29 10:10:25',NULL),
	(27,5,1,0,1,0,0,0,'2018-12-29 10:10:28','2019-01-10 11:56:55',NULL),
	(28,5,2,0,0,1,0,0,'2018-12-29 10:10:28','2019-01-21 15:53:01',NULL),
	(29,5,3,0,0,0,0,0,'2018-12-29 10:10:28','2018-12-29 10:10:28',NULL),
	(30,5,4,1,1,1,1,1,'2018-12-29 10:10:28','2019-01-21 15:52:39',NULL),
	(31,5,5,0,0,0,0,0,'2018-12-29 10:10:28','2018-12-29 10:10:28',NULL),
	(32,1,9,1,1,1,1,0,'2018-12-29 10:29:17','2018-12-29 10:29:33',NULL),
	(33,2,9,1,1,1,1,1,'2018-12-29 10:29:17','2019-01-12 18:07:38',NULL),
	(34,3,9,0,1,0,0,0,'2018-12-29 10:29:17','2019-01-12 11:45:50',NULL),
	(35,4,9,0,0,0,0,0,'2018-12-29 10:29:17','2019-01-12 15:50:00',NULL),
	(36,5,9,0,0,0,0,0,'2018-12-29 10:29:17','2018-12-29 10:29:17',NULL),
	(37,1,10,1,1,1,1,0,'2018-12-29 10:57:21','2018-12-29 10:57:32',NULL),
	(38,2,10,1,1,1,1,1,'2018-12-29 10:57:21','2019-01-12 18:07:40',NULL),
	(39,3,10,0,0,0,0,0,'2018-12-29 10:57:21','2018-12-29 10:57:21',NULL),
	(40,4,10,0,0,0,0,0,'2018-12-29 10:57:21','2018-12-29 10:57:21',NULL),
	(41,5,10,0,0,0,0,0,'2018-12-29 10:57:21','2018-12-29 10:57:21',NULL),
	(42,1,11,1,1,1,1,0,'2018-12-29 11:15:45','2018-12-29 11:15:56',NULL),
	(43,2,11,1,1,1,1,1,'2018-12-29 11:15:45','2019-01-12 18:07:44',NULL),
	(44,3,11,0,1,0,0,0,'2018-12-29 11:15:45','2019-01-31 10:13:53',NULL),
	(45,4,11,0,1,0,0,0,'2018-12-29 11:15:45','2019-01-31 12:04:35',NULL),
	(46,5,11,0,0,0,0,0,'2018-12-29 11:15:45','2019-01-15 12:18:45',NULL),
	(47,1,12,1,1,1,1,0,'2018-12-29 13:25:32','2018-12-29 13:25:42',NULL),
	(48,2,12,1,1,1,1,1,'2018-12-29 13:25:32','2019-01-12 18:07:52',NULL),
	(49,3,12,0,1,0,0,0,'2018-12-29 13:25:32','2019-01-31 14:25:18',NULL),
	(50,4,12,0,0,0,0,0,'2018-12-29 13:25:32','2018-12-29 13:25:32',NULL),
	(51,5,12,0,0,0,0,0,'2018-12-29 13:25:32','2018-12-29 13:25:32',NULL),
	(52,1,13,1,1,1,1,1,'2019-01-02 08:19:41','2019-01-10 10:24:46',NULL),
	(53,2,13,1,1,1,1,1,'2019-01-02 08:19:41','2019-01-12 18:07:53',NULL),
	(54,3,13,1,1,1,1,1,'2019-01-02 08:19:41','2019-01-31 19:56:51',NULL),
	(55,4,13,0,1,1,0,0,'2019-01-02 08:19:41','2019-01-31 10:13:32',NULL),
	(56,5,13,0,0,0,0,0,'2019-01-02 08:19:41','2019-01-21 16:50:09',NULL),
	(57,1,14,0,0,0,0,0,'2019-01-10 11:56:24','2019-01-10 11:56:24',NULL),
	(58,2,14,0,0,0,0,0,'2019-01-10 11:56:24','2019-01-10 11:56:24',NULL),
	(59,3,14,0,0,0,0,0,'2019-01-10 11:56:24','2019-01-10 11:56:24',NULL),
	(60,4,14,0,0,0,0,0,'2019-01-10 11:56:24','2019-01-10 11:56:24',NULL),
	(61,5,14,1,1,0,0,0,'2019-01-10 11:56:24','2019-01-10 11:56:36',NULL),
	(62,1,15,0,0,0,0,0,'2019-01-11 07:29:21','2019-01-11 09:33:53','2019-01-11 09:33:53'),
	(63,2,15,0,0,0,0,0,'2019-01-11 07:29:21','2019-01-11 09:33:53','2019-01-11 09:33:53'),
	(64,3,15,0,0,0,0,0,'2019-01-11 07:29:21','2019-01-11 09:33:53','2019-01-11 09:33:53'),
	(65,4,15,1,1,1,1,1,'2019-01-11 07:29:21','2019-01-11 09:33:53','2019-01-11 09:33:53'),
	(66,5,15,0,0,0,0,0,'2019-01-11 07:29:21','2019-01-11 09:33:53','2019-01-11 09:33:53'),
	(67,1,16,0,0,0,0,0,'2019-01-11 21:50:07','2019-01-11 21:50:07',NULL),
	(68,2,16,0,0,0,0,0,'2019-01-11 21:50:07','2019-01-12 18:08:06',NULL),
	(69,3,16,0,0,0,0,0,'2019-01-11 21:50:07','2019-01-21 17:32:41',NULL),
	(70,4,16,0,0,0,0,0,'2019-01-11 21:50:07','2019-01-21 17:36:24',NULL),
	(71,5,16,0,1,0,0,0,'2019-01-11 21:50:07','2019-01-11 21:50:19',NULL),
	(72,6,1,0,1,0,0,0,'2019-01-12 11:22:23','2019-01-12 11:22:54',NULL),
	(73,6,2,0,0,0,0,0,'2019-01-12 11:22:23','2019-01-12 11:22:23',NULL),
	(74,6,3,0,0,0,0,0,'2019-01-12 11:22:23','2019-01-12 11:22:23',NULL),
	(75,6,4,0,1,1,0,0,'2019-01-12 11:22:23','2019-01-12 11:33:08',NULL),
	(76,6,5,0,0,0,0,0,'2019-01-12 11:22:23','2019-01-12 11:31:22',NULL),
	(77,6,9,0,0,0,0,0,'2019-01-12 11:22:23','2019-01-12 11:22:23',NULL),
	(78,6,10,0,0,0,0,0,'2019-01-12 11:22:23','2019-01-12 11:22:23',NULL),
	(79,6,11,0,0,0,0,0,'2019-01-12 11:22:23','2019-01-12 11:22:23',NULL),
	(80,6,12,0,0,0,0,0,'2019-01-12 11:22:23','2019-01-12 11:22:23',NULL),
	(81,6,13,0,1,0,0,0,'2019-01-12 11:22:23','2019-01-12 11:31:35',NULL),
	(82,6,14,0,0,0,0,0,'2019-01-12 11:22:23','2019-01-12 11:22:23',NULL),
	(83,6,16,0,0,0,0,0,'2019-01-12 11:22:23','2019-01-12 11:22:23',NULL),
	(84,1,17,0,0,0,0,0,'2019-01-15 12:16:52','2019-01-15 12:16:52',NULL),
	(85,2,17,0,0,0,0,0,'2019-01-15 12:16:52','2019-01-15 12:16:52',NULL),
	(86,3,17,0,0,0,0,0,'2019-01-15 12:16:52','2019-01-15 12:16:52',NULL),
	(87,4,17,0,0,0,0,0,'2019-01-15 12:16:52','2019-01-15 12:16:52',NULL),
	(88,5,17,0,1,0,0,0,'2019-01-15 12:16:52','2019-01-15 12:17:03',NULL),
	(89,1,18,1,1,1,1,0,'2019-01-21 09:52:45','2019-01-21 09:52:59',NULL),
	(90,2,18,1,1,1,1,0,'2019-01-21 09:52:45','2019-01-21 09:53:09',NULL),
	(91,3,18,0,0,0,0,0,'2019-01-21 09:52:45','2019-01-21 17:19:28',NULL),
	(92,4,18,0,0,0,0,0,'2019-01-21 09:52:45','2019-01-21 17:19:11',NULL),
	(93,5,18,0,1,0,0,0,'2019-01-21 09:52:45','2019-01-21 09:53:27',NULL);

/*!40000 ALTER TABLE `previleges` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table submenus
# ------------------------------------------------------------

DROP TABLE IF EXISTS `submenus`;

CREATE TABLE `submenus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `submenu` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` int(5) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `routing` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `submenus` WRITE;
/*!40000 ALTER TABLE `submenus` DISABLE KEYS */;

INSERT INTO `submenus` (`id`, `id_menu`, `submenu`, `urutan`, `created_at`, `updated_at`, `routing`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES
	(1,3,'User Levels',1,'2018-04-18 00:00:00','2018-04-21 22:43:17','configs.level.read',NULL,NULL,3,NULL),
	(2,3,'User Privileges',2,'2018-04-18 00:00:00',NULL,'configs.privileges.read','2018-03-08 00:00:00',NULL,NULL,NULL),
	(3,3,'Application Menus',2,'2018-04-18 00:00:00','2018-04-21 22:43:26','configs.menu.read',NULL,NULL,3,NULL),
	(4,3,'Log Aktivitas',4,'2018-03-08 00:00:00',NULL,'configs.log.read','2018-04-09 00:00:00',NULL,NULL,NULL),
	(5,3,'Logs',3,'2018-04-21 22:43:55','2018-04-21 22:43:55','configs.logsss.read','2018-04-21 00:00:00',3,NULL,NULL),
	(6,3,'Tipe Kehadiran',3,'2018-12-29 09:13:25','2018-12-29 09:13:25','configs.tipe-kehadiran.read',NULL,3,NULL,NULL),
	(7,3,'Hari',4,'2018-12-29 09:31:03','2018-12-29 09:31:03','configs.hari.read',NULL,3,NULL,NULL),
	(8,13,'Praktikum Aktif',1,'2019-01-10 10:08:21','2019-01-10 10:11:45','praktikum.aktif.read',NULL,3,3,NULL),
	(9,13,'Praktikum Non Aktif',2,'2019-01-10 10:14:05','2019-01-10 10:14:05','praktikum.nonaktif.read',NULL,3,NULL,NULL),
	(10,15,'Praktikum Aktif',1,'2019-01-11 07:29:43','2019-01-11 07:29:43','praktikumdosen.read',NULL,3,NULL,NULL),
	(11,15,'Praktikum Nonaktif',2,'2019-01-11 07:49:42','2019-01-11 07:49:42','praktikumdosen.nonaktif.read',NULL,3,NULL,NULL);

/*!40000 ALTER TABLE `submenus` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tipe_kehadiran
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tipe_kehadiran`;

CREATE TABLE `tipe_kehadiran` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `alias` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `tipe_kehadiran` WRITE;
/*!40000 ALTER TABLE `tipe_kehadiran` DISABLE KEYS */;

INSERT INTO `tipe_kehadiran` (`id`, `alias`, `tipe`, `class`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES
	(1,'H','Hadir','success','2018-12-29 09:32:55','2018-12-29 09:32:55',NULL,3,0,0),
	(2,'S','Sakit','warning','2018-09-16 15:49:59','2018-09-16 15:49:59',NULL,3,0,0),
	(3,'I','Izin','warning','2018-09-16 15:50:07','2018-09-16 15:50:07',NULL,3,0,0),
	(4,'A','Alpa','danger','2018-09-16 15:50:16','2018-09-16 15:50:16',NULL,3,0,0);

/*!40000 ALTER TABLE `tipe_kehadiran` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_levels
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_levels`;

CREATE TABLE `user_levels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_level` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `user_levels` WRITE;
/*!40000 ALTER TABLE `user_levels` DISABLE KEYS */;

INSERT INTO `user_levels` (`id`, `id_user`, `id_level`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,1,1,NULL,'2018-03-08 19:06:17',NULL),
	(2,2,2,NULL,NULL,NULL),
	(3,3,1,'2018-04-11 21:28:31','2018-04-11 21:28:31',NULL),
	(4,3,2,'2018-04-11 21:28:31','2018-04-11 21:28:31',NULL),
	(5,5,4,'2018-12-29 10:35:47','2018-12-29 10:35:47',NULL),
	(6,6,4,'2018-12-29 10:41:29','2018-12-29 10:41:34','2018-12-29 10:41:34'),
	(7,7,3,'2018-12-29 11:01:59','2018-12-29 11:01:59',NULL),
	(8,8,3,'2018-12-29 11:02:37','2018-12-29 11:02:48',NULL),
	(9,9,5,'2018-12-29 11:17:04','2018-12-29 11:17:04',NULL),
	(10,10,5,'2018-12-29 11:18:05','2019-01-12 14:56:52','2019-01-12 14:56:52'),
	(11,11,4,'2019-01-03 15:55:38','2019-01-03 15:55:38',NULL),
	(12,12,3,'2019-01-11 23:23:51','2019-01-11 23:23:51',NULL),
	(13,13,6,'2019-01-12 11:25:36','2019-01-12 12:06:35','2019-01-12 12:06:35'),
	(14,14,4,'2019-01-12 12:14:06','2019-01-12 12:14:06',NULL),
	(15,15,5,'2019-01-15 14:46:04','2019-01-15 14:46:04',NULL),
	(16,16,5,'2019-01-30 18:24:09','2019-01-30 18:24:14','2019-01-30 18:24:14'),
	(17,17,5,'2019-01-30 18:24:09','2019-01-30 18:24:17','2019-01-30 18:24:17'),
	(18,18,4,'2019-01-30 21:48:15','2019-01-30 21:48:15',NULL),
	(19,19,5,'2019-01-31 10:07:38','2019-01-31 10:07:38',NULL),
	(20,20,5,'2019-01-31 10:07:38','2019-01-31 10:07:38',NULL),
	(21,21,5,'2019-01-31 10:12:01','2019-01-31 10:12:01',NULL),
	(22,22,4,'2019-01-31 12:01:19','2019-01-31 12:01:19',NULL);

/*!40000 ALTER TABLE `user_levels` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `username`, `password`, `phone`, `remember_token`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'Super Admin','superadmin','$2y$10$z/ZFg.YbOmI44Y8jaBlbf.YjYNOxhtuC6I5QA4wCMB9pjdoaAiBiS','0878304159299','Ph3wmQ7v7mMXq47wSyXGQg5jFOPVNKjq4yqNIn0LPeZXa6EHBev3IDmQ7nqB',NULL,'2018-04-02 13:49:15',NULL),
	(2,'Admin','admin','$2y$10$ayjOmiOb51L87hXBvVYar.r/Vsn4c5VX1YJlV/MIcy2taDlEwfw9W','087830415543','OFgY41r6uHzy0DccKdOG6nZbQq7gvrGwBn9c846h9F1AAevhiPRmW4mTI7gX',NULL,'2019-01-31 10:25:51',NULL),
	(3,'Root','root','$2y$10$jJ7ZzvfEVGvZBz53ZSLrvObGxqyYfUXbawesrjZVYk8CaiJRZ07BO','081111111111','a34luUbPWT3o2s2oixAq9T9xjeZhfYYeInHxaYSVGlvurgkEGoerrYLtsg9g','2018-04-11 21:28:31','2018-12-29 08:42:28',NULL),
	(5,'Dr. Dosen S.Pd., M.Pd.','dosen','$2y$10$ozmlfQZ3S1xfIeDpvV8Rx.wI56dAY7q.F1HfbXcxUpcd.oHrUvrVC','08123456789','0xeaCGKRF0vjiPqbvfpIOCwwC8evaIDuRWCC4fNoy9XzBlDZrNAAZHc1C3wa','2018-12-29 10:35:47','2019-01-12 11:39:08',NULL),
	(6,'Sukaryo S.Pd.','sukaryo','$2y$10$SEpcoezNwvkhcPeNblW45u5/91sQVFxuynH91wVaE6tGDY9xvqJlS','081234567890',NULL,'2018-12-29 10:41:29','2018-12-29 10:41:34','2018-12-29 10:41:34'),
	(7,'Kalab S.Kom., M.Kom.','kalab','$2y$10$jec8kyC9SYuLdM8HipueUeGgBTPQ/p5.nnw37etdcsBJga6MWXX9a','081234567890','xOPCV4nCTTm1exljjs9Kk7uXOK7iUX0kG4IxVWaL5ytl7vY3oKHsCD15XT3S','2018-12-29 11:01:59','2019-01-12 11:48:02',NULL),
	(8,'Kalab 2 S.Pd., M.Kom.','kalab2','$2y$10$wK5XKIq4HVnJyGn5hg.o7OX5GUXFHKrJ8G6XdMWhGdHSDK.pZ4JVy','081234567890','ASr8h2gj8NjxVqrYwB8Us0gVAKqBPcj4A24kmKLLzvRj601ASEbfZrLpnCMI','2018-12-29 11:02:37','2019-01-12 14:58:39',NULL),
	(9,'Mahasiswa','mahasiswa','$2y$10$VyfZi7iFA3cWJpDre0vT5uH6gW2ka9zLIrEaTi5wfGLVmyqJ92dCa','08976757','y44a7D6gz5c2osKCFydBRlrQaxdjkZkF3XuUuVOLYsZiIvSapT4ZTXsx2SoY','2018-12-29 11:17:04','2019-01-31 12:03:24',NULL),
	(10,'Mahasiswa 2','mahasiswa2','$2y$10$OxydN/IWhqLe7V/yHmD47OIoexHq7cBA0CxteZCQjra8EMVJCds0G','081234567890',NULL,'2018-12-29 11:18:05','2019-01-12 14:56:52','2019-01-12 14:56:52'),
	(11,'Prof. Dosen Grafis','dosen2','$2y$10$sRpjgMKYLJGU1bm0HC49CeZ.oVIXMvkL..owBjChYNAcxN9QUvD/e','081234567890','cKgH7gOzPnNcxeykICoucwQYv9Tiye7wnISVcNpfmJaQGIeQmpEsI7bNa1Vm','2019-01-03 15:55:38','2019-01-31 12:03:15',NULL),
	(12,'dosen 1','dosen1','$2y$10$yD6JOo4PjHyi4jnTy3wR1O42zcFkqykeTRQ.hRU5e3h8ydxr7c4Zq','02656897944',NULL,'2019-01-11 23:23:51','2019-01-11 23:23:51',NULL),
	(13,'Mahasiswa4','Mahasiswa4','$2y$10$ZBSETnauiyGgSRhZ8YTJte/jWajx2Dgd4EOm8/oVN/k9kHL1FIbKy','08856454991616','2beOHDTitMoX5IAzKIVBl0XG3pi4JPZdHhdqFNUlWVI1UC7UlcGwwuM6dlTI','2019-01-12 11:25:36','2019-01-12 12:06:35','2019-01-12 12:06:35'),
	(14,'Jackie chan','jack','$2y$10$y2H1ZSxKj7u3leqHy0m.qO9wG77RARRRtWLK.xV6rkw2Ae5U35U4y','0815634','Y16Hz52w3Zf9tTVUFt1VLLHiMlM6rhobP90n3nNri0VTmrCqC2Y4AFmQOnNP','2019-01-12 12:14:06','2019-01-12 12:14:06',NULL),
	(15,'belia','belia','$2y$10$GuH3drw08/X6neSMzIGq7.88AoBmRBo/WWMzC3QJD0vZOQuTA5Swe','098979','RPu4IEnxXHbsUTsoDyUEzjTm1O7L1yJmNOSApuALzSqE81JEjQ1b5QrYCmxm','2019-01-15 14:46:04','2019-01-15 14:46:04',NULL),
	(16,'Muhamad Anbiya','4611414026','$2y$10$o.qXZ6dfxiLiPrxhow0I4eXzbDf7XmCwKELIu.62soVyrVXO/t/ba','0878498245',NULL,'2019-01-30 18:24:09','2019-01-30 18:24:14','2019-01-30 18:24:14'),
	(17,'Bulir Al Basyir','4611414027','$2y$10$vP.gs92wLP1HWh4GvRYkfO4rNZpJGc9roCPwhIMdTnEgVv0zNJUMS','08121234543',NULL,'2019-01-30 18:24:09','2019-01-30 18:24:17','2019-01-30 18:24:17'),
	(18,'Suryo','Suryo','$2y$10$j.HSAwN0j/lWTrJSQFIIhempHen..nZg0zK0wPqjXzqwFh9HnWs.6','0283838911',NULL,'2019-01-30 21:48:15','2019-01-30 21:48:15',NULL),
	(19,'Muhamad Anbiya','4611414026','$2y$10$X/RxYhQtLthLUusfNy6Ug.yBZPg1KPlvaLzZfiOEmCtyxjAWVJone','0878498245',NULL,'2019-01-31 10:07:38','2019-01-31 10:07:38',NULL),
	(20,'Bulir Al Basyir','4611414027','$2y$10$Pi0FISputvKsG56u7GtmHO2MXZ/LZWvzTMu8OGTRkU9xoxHDgmpou','08121234543',NULL,'2019-01-31 10:07:38','2019-01-31 10:07:38',NULL),
	(21,'priyanto','4569797913','$2y$10$iU9IC1jUZaymrN0yU7vapu7jim/akEDMN2EddYh/M58GfITuw9Uqy','0878498245','C1wSEkmwXkROi3Wbk0GsxK8BhQAIFabZnMcWOJ7ElF2ylVFAfSDgl6x70eWf','2019-01-31 10:12:01','2019-01-31 10:12:01',NULL),
	(22,'Jack Ma,SPd,M.M.,','jackma','$2y$10$tl7zO2Z/OLyfcXsDPc8NN.KNJArbyE.54f7XRg2Qu.X53XJiJSMUq','0989767365656',NULL,'2019-01-31 12:01:19','2019-01-31 12:01:32',NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
