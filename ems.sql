-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for ci
CREATE DATABASE IF NOT EXISTS `ci` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `ci`;

-- Dumping structure for table ci.department
CREATE TABLE IF NOT EXISTS `department` (
  `d_id` int NOT NULL AUTO_INCREMENT,
  `d_name` varchar(255) NOT NULL,
  `d_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`d_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table ci.department: ~5 rows (approximately)
INSERT INTO `department` (`d_id`, `d_name`, `d_date`) VALUES
	(1, 'IT Department', '2025-08-26 14:30:59'),
	(2, 'Human Resources', '2025-08-26 14:30:59'),
	(3, 'Marketing', '2025-08-26 14:30:59'),
	(4, 'Finance', '2025-08-26 14:30:59'),
	(5, 'Designer', '2025-08-26 14:38:34');

-- Dumping structure for table ci.employees
CREATE TABLE IF NOT EXISTS `employees` (
  `e_id` int NOT NULL AUTO_INCREMENT,
  `e_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `e_name` varchar(255) NOT NULL,
  `e_email` varchar(255) NOT NULL,
  `e_phone` varchar(255) NOT NULL,
  `e_job` varchar(255) NOT NULL,
  `e_department` int DEFAULT NULL,
  PRIMARY KEY (`e_id`),
  KEY `e_department` (`e_department`),
  CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`e_department`) REFERENCES `department` (`d_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table ci.employees: ~4 rows (approximately)
INSERT INTO `employees` (`e_id`, `e_date`, `e_name`, `e_email`, `e_phone`, `e_job`, `e_department`) VALUES
	(2, '2020-05-30 14:09:56', 'John Smith', 'johnsmith@gmail.com', '8521479632', 'Graphic Designer', 5),
	(4, '2020-05-30 14:10:52', 'Rahul Sharma', 'rahulsharma@gmail.com', '74563210147', 'Graphic Designer', 5),
	(5, '2020-05-30 18:23:31', 'Fatah Gabrial', 'fatahgabrial@gmail.com', '7418529632', 'Web Developer', 1),
	(7, '2025-08-26 14:43:19', 'Aghanim', 'aghanim@gmail.com', '0238429323', 'Graphic Designer', 5);

-- Dumping structure for table ci.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `j_id` int NOT NULL AUTO_INCREMENT,
  `j_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `j_name` varchar(255) NOT NULL,
  `j_department` varchar(255) NOT NULL,
  `d_id` int DEFAULT NULL,
  PRIMARY KEY (`j_id`),
  KEY `d_id` (`d_id`),
  CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`d_id`) REFERENCES `department` (`d_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table ci.jobs: ~5 rows (approximately)
INSERT INTO `jobs` (`j_id`, `j_date`, `j_name`, `j_department`, `d_id`) VALUES
	(1, '2020-05-30 11:15:23', 'Graphic Designer', '', 5),
	(4, '2020-05-30 13:27:29', 'Web Designer', '', 1),
	(5, '2020-05-30 13:27:51', 'Web Developer', '', 1),
	(6, '2020-05-30 13:27:58', 'Senior Digital Marketer', '', 3),
	(7, '2025-08-26 14:07:41', 'UI/UX Designer', '', 5);

-- Dumping structure for table ci.users
CREATE TABLE IF NOT EXISTS `users` (
  `u_id` int NOT NULL AUTO_INCREMENT,
  `u_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `u_email` varchar(255) NOT NULL,
  `u_name` varchar(255) NOT NULL,
  `u_pass` varchar(255) NOT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table ci.users: ~4 rows (approximately)
INSERT INTO `users` (`u_id`, `u_date`, `u_email`, `u_name`, `u_pass`) VALUES
	(2, '2020-05-29 23:02:38', 'fatahgabrial@gmail.com', 'fatahgabrial', '202cb962ac59075b964b07152d234b70'),
	(3, '2025-08-22 11:03:04', 'amir@gmail.com', 'amirkurniawan', 'e2fc714c4727ee9395f324cd2e7f331f'),
	(4, '2025-08-22 11:06:01', 'mira@gmail.com', 'mira', 'eeafbf4d9b3957b139da7b7f2e7f2d4a'),
	(5, '2025-08-26 10:30:17', 'amir@gmail.com', 'amir', 'e2fc714c4727ee9395f324cd2e7f331f');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
