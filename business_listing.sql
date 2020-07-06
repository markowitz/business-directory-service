# ************************************************************
# Sequel Pro SQL dump
# Version 5446
#
# https://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 8.0.17)
# Database: business-directory
# Generation Time: 2020-07-06 01:41:27 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table business_listings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `business_listings`;

CREATE TABLE `business_listings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `views_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `business_listings` WRITE;
/*!40000 ALTER TABLE `business_listings` DISABLE KEYS */;

INSERT INTO `business_listings` (`id`, `name`, `description`, `url`, `email`, `phone`, `address`, `published`, `created_at`, `updated_at`, `views_count`)
VALUES
	(2,'Hotels.ng','hotel listing site to give you freedom','https://hotels.ng','icnwakanma@gmail.com','+23481234567','2 Laula Ibrahim Street, Bariga, Lagos',1,'2020-07-05 10:26:19','2020-07-06 01:39:04',21),
	(3,'Piggyvest Limited','PiggyVest helps you achieve financial freedom by enabling you save responsibly and invest on the go.','https://piggyvest.com','info@piggyvest.com','+234811111111','3 Birrel Avenue',1,'2020-07-06 01:05:59','2020-07-06 01:09:16',2);

/*!40000 ALTER TABLE `business_listings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table business_listings_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `business_listings_categories`;

CREATE TABLE `business_listings_categories` (
  `business_listings_id` bigint(20) unsigned NOT NULL,
  `categories_id` bigint(20) unsigned NOT NULL,
  KEY `business_listings_categories_business_listings_id_foreign` (`business_listings_id`),
  KEY `business_listings_categories_categories_id_foreign` (`categories_id`),
  CONSTRAINT `business_listings_categories_business_listings_id_foreign` FOREIGN KEY (`business_listings_id`) REFERENCES `business_listings` (`id`),
  CONSTRAINT `business_listings_categories_categories_id_foreign` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `business_listings_categories` WRITE;
/*!40000 ALTER TABLE `business_listings_categories` DISABLE KEYS */;

INSERT INTO `business_listings_categories` (`business_listings_id`, `categories_id`)
VALUES
	(2,1),
	(3,3),
	(2,2);

/*!40000 ALTER TABLE `business_listings_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` bigint(20) unsigned NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`),
  KEY `categories_added_by_foreign` (`added_by`),
  CONSTRAINT `categories_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`id`, `name`, `added_by`, `published`, `created_at`, `updated_at`)
VALUES
	(1,'Hospitality',2,1,'2020-07-05 09:19:57','2020-07-05 09:20:21'),
	(2,'Technology',1,1,'2020-07-06 00:49:18','2020-07-06 00:49:38'),
	(3,'Financial Industry',1,1,'2020-07-06 00:49:34','2020-07-06 00:49:41');

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table failed_jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table listing_images
# ------------------------------------------------------------

DROP TABLE IF EXISTS `listing_images`;

CREATE TABLE `listing_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `business_listings_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `listing_images_business_listings_id_foreign` (`business_listings_id`),
  CONSTRAINT `listing_images_business_listings_id_foreign` FOREIGN KEY (`business_listings_id`) REFERENCES `business_listings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `listing_images` WRITE;
/*!40000 ALTER TABLE `listing_images` DISABLE KEYS */;

INSERT INTO `listing_images` (`id`, `image_path`, `is_default`, `business_listings_id`, `created_at`, `updated_at`)
VALUES
	(3,'storage/listings/C0aDD3xc7FDotFc9itw56uyRsfTm9qKR8OYK47hT.jpeg',1,2,'2020-07-05 10:26:19','2020-07-05 10:26:19'),
	(4,'storage/listings/ku0YuiafoqpCns3s3ttCIKLSKCVhDwtvwJ5zLyfj.jpeg',0,2,'2020-07-05 10:26:19','2020-07-05 10:26:19'),
	(5,'storage/listings/N9CBOXgIdMyblWBoW0H3EvLcfOkUX5MFOH13Mcme.jpeg',1,3,'2020-07-06 01:05:59','2020-07-06 01:05:59'),
	(6,'storage/listings/vSAu7Rzu4h2x3oGGDiwCqWaI4yrbUhsCXReba2Q4.jpeg',0,3,'2020-07-06 01:05:59','2020-07-06 01:05:59');

/*!40000 ALTER TABLE `listing_images` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(50,'2014_10_12_000000_create_users_table',1),
	(51,'2014_10_12_100000_create_password_resets_table',1),
	(52,'2019_08_19_000000_create_failed_jobs_table',1),
	(53,'2019_12_14_000001_create_personal_access_tokens_table',1),
	(54,'2020_07_04_112320_create_categories_table',1),
	(55,'2020_07_04_123333_create_migration_business_listings_table',1),
	(56,'2020_07_04_123511_create_business_listings_categories_table',1),
	(57,'2020_07_04_215213_create_listing_images_table',1),
	(58,'2020_07_05_194825_create_reviews_table',2),
	(59,'2020_07_05_210335_add_views_count_to_business_listings',3);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table personal_access_tokens
# ------------------------------------------------------------

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table reviews
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reviews`;

CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `review` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` int(11) NOT NULL,
  `listing_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_listing_id_foreign` (`listing_id`),
  CONSTRAINT `reviews_listing_id_foreign` FOREIGN KEY (`listing_id`) REFERENCES `business_listings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;

INSERT INTO `reviews` (`id`, `name`, `email`, `title`, `review`, `rate`, `listing_id`, `created_at`, `updated_at`)
VALUES
	(1,'Ikechukwu Nwakanma','icnwakanma@gmail.com','awesome service','They really tried rendering an awesome service',5,2,'2020-07-05 20:21:12','2020-07-05 20:21:12'),
	(2,'Jane Doe','nwakanma5@yahoo.com','Bad','they are really poor in service',1,2,'2020-07-06 01:08:20','2020-07-06 01:08:20'),
	(3,'Ikechukwu Nwakanma','patjickconsult@gmail.com','awesome','they are really good. used them to save my rent',5,3,'2020-07-06 01:09:16','2020-07-06 01:09:16');

/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'admin',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `user_type`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'Super Admin','superadmin@gmail.com',NULL,'$2y$10$hjM1Pe6QJ4GKyOc0jFT.z.447FajB0/UGxGy9gXhWWauWc.tqfIBC','super_admin',NULL,NULL,NULL),
	(2,'Admin','icnwakanma@gmail.com',NULL,'$2y$10$jCU02OlWH4wXOzOq.2WIG.FaN3BKquo2BDpMzlaLdkFg..uC0r2tO','admin',NULL,NULL,NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
