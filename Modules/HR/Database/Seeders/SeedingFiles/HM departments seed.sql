-- --------------------------------------------------------
-- Host:                         203.161.56.64
-- Server version:               8.0.33 - MySQL Community Server - GPL
-- Server OS:                    Linux
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

-- Dumping structure for table db_mhakim.departments
CREATE TABLE IF NOT EXISTS `departments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_name_bangla` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `com_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_mhakim.departments: ~8 rows (approximately)
-- INSERT INTO `departments` (`id`, `name`, `department_name_bangla`, `status`, `com_id`, `created_at`, `updated_at`) VALUES
-- 	(1, 'Administration', NULL, 'active', 'feb4b55f-df58-4aff-8ec2-5cbc12c8e029', '2023-07-11 17:23:05', '2023-07-11 17:23:05'),
-- 	(2, 'Furnace', NULL, 'active', 'feb4b55f-df58-4aff-8ec2-5cbc12c8e029', '2023-07-11 17:23:05', '2023-07-11 17:23:05'),
-- 	(3, 'CCM', NULL, 'active', 'feb4b55f-df58-4aff-8ec2-5cbc12c8e029', '2023-07-11 17:23:05', '2023-07-11 17:23:05'),
-- 	(4, 'Mech. & Elect.', NULL, 'active', 'feb4b55f-df58-4aff-8ec2-5cbc12c8e029', '2023-07-11 17:23:05', '2023-07-11 17:23:05'),
-- 	(5, 'Rolling', NULL, 'active', 'feb4b55f-df58-4aff-8ec2-5cbc12c8e029', '2023-07-11 17:23:05', '2023-07-11 17:23:05'),
-- 	(6, 'Logistic', NULL, 'active', 'feb4b55f-df58-4aff-8ec2-5cbc12c8e029', '2023-07-11 17:23:05', '2023-07-11 17:23:05'),
-- 	(7, 'Security', NULL, 'active', 'feb4b55f-df58-4aff-8ec2-5cbc12c8e029', '2023-07-11 17:23:05', '2023-07-11 17:23:05'),
-- 	(8, ' Indian Staff', NULL, 'active', 'feb4b55f-df58-4aff-8ec2-5cbc12c8e029', '2023-07-11 17:23:05', '2023-07-11 17:23:05');


INSERT INTO `departments` (`id`, `name`, `department_name_bangla`, `status`, `com_id`, `created_at`, `updated_at`) VALUES
	(1, 'Administration', NULL, 'active', '6fa50914-e296-49c5-b43b-3b73650ee807', '2023-07-11 17:23:05', '2023-07-11 17:23:05'),
	(2, 'Furnace', NULL, 'active', '6fa50914-e296-49c5-b43b-3b73650ee807', '2023-07-11 17:23:05', '2023-07-11 17:23:05'),
	(3, 'CCM', NULL, 'active', '6fa50914-e296-49c5-b43b-3b73650ee807', '2023-07-11 17:23:05', '2023-07-11 17:23:05'),
	(4, 'Mech. & Elect.', NULL, 'active', '6fa50914-e296-49c5-b43b-3b73650ee807', '2023-07-11 17:23:05', '2023-07-11 17:23:05'),
	(5, 'Rolling', NULL, 'active', '6fa50914-e296-49c5-b43b-3b73650ee807', '2023-07-11 17:23:05', '2023-07-11 17:23:05'),
	(6, 'Logistic', NULL, 'active', '6fa50914-e296-49c5-b43b-3b73650ee807', '2023-07-11 17:23:05', '2023-07-11 17:23:05'),
	(7, 'Security', NULL, 'active', '6fa50914-e296-49c5-b43b-3b73650ee807', '2023-07-11 17:23:05', '2023-07-11 17:23:05'),
	(8, ' Indian Staff', NULL, 'active', '6fa50914-e296-49c5-b43b-3b73650ee807', '2023-07-11 17:23:05', '2023-07-11 17:23:05');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
