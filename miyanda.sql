-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for miyanda
CREATE DATABASE IF NOT EXISTS `miyanda` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `miyanda`;

-- Dumping structure for table miyanda.tblconfiguration
CREATE TABLE IF NOT EXISTS `tblconfiguration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `url` varchar(300) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `frequency` int(11) DEFAULT NULL,
  `last_checked` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table miyanda.tblconfiguration: ~3 rows (approximately)
/*!40000 ALTER TABLE `tblconfiguration` DISABLE KEYS */;
INSERT INTO `tblconfiguration` (`id`, `userid`, `email`, `url`, `status`, `frequency`, `last_checked`) VALUES
	(4, 2, 'juniorpeter159@gmail.com', 'https://github.com/iamjuniorpeter/lav_sms', 200, NULL, '2021-04-27 04:55:07'),
	(5, 1, 'juniorpeter159@gmail.com', 'http://redlensentertainment.com/', 200, 5, '2021-04-27 04:55:12'),
	(6, 1, 'juniorpeter159@gmail.com', 'http://transferwisemoney.com/', 400, 5, NULL);
/*!40000 ALTER TABLE `tblconfiguration` ENABLE KEYS */;

-- Dumping structure for table miyanda.tbluser
CREATE TABLE IF NOT EXISTS `tbluser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table miyanda.tbluser: ~2 rows (approximately)
/*!40000 ALTER TABLE `tbluser` DISABLE KEYS */;
INSERT INTO `tbluser` (`id`, `name`, `email`, `password`) VALUES
	(1, 'Junior Peter', 'jp@gmail.com', '12345'),
	(2, 'Michael Jummai', 'mj@gmail.com', '12345');
/*!40000 ALTER TABLE `tbluser` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
