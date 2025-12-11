/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.7.39 : Database - db_cms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_cms` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_cms`;

/*Table structure for table `audit_logs` */

DROP TABLE IF EXISTS `audit_logs`;

CREATE TABLE `audit_logs` (
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` json DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`audit_id`),
  KEY `idx_audit_user` (`user_id`),
  KEY `idx_audit_action` (`action`),
  KEY `idx_audit_created` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `audit_logs` */

insert  into `audit_logs`(`audit_id`,`user_id`,`action`,`ip_address`,`user_agent`,`details`,`created_at`) values (1,NULL,'user.logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,'2025-12-09 23:48:51'),(2,1,'user.login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','{\"email\": \"admin@example.com\", \"user_id\": \"1\", \"username\": \"admin\"}','2025-12-09 23:51:12'),(3,1,'user.logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,'2025-12-09 23:57:52'),(4,1,'user.login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','{\"email\": \"admin@example.com\", \"user_id\": \"1\", \"username\": \"admin\"}','2025-12-09 23:58:08'),(5,1,'user.logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,'2025-12-10 00:01:54'),(6,1,'user.login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','{\"email\": \"admin@example.com\", \"user_id\": \"1\", \"username\": \"admin\"}','2025-12-10 00:01:59'),(7,2,'user.login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','{\"email\": \"ddarfa24@gmail.com\", \"user_id\": \"2\", \"username\": \"darva\"}','2025-12-10 00:07:26'),(8,2,'user.logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,'2025-12-10 00:20:26'),(9,2,'user.login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','{\"email\": \"ddarfa24@gmail.com\", \"user_id\": \"2\", \"username\": \"darva\"}','2025-12-10 00:20:35'),(10,1,'user.login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','{\"email\": \"admin@example.com\", \"user_id\": \"1\", \"username\": \"admin\"}','2025-12-10 09:44:03'),(11,1,'user.login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','{\"email\": \"admin@example.com\", \"user_id\": \"1\", \"username\": \"admin\"}','2025-12-10 11:52:57'),(12,1,'user.login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','{\"email\": \"admin@example.com\", \"user_id\": \"1\", \"username\": \"admin\"}','2025-12-11 10:13:44'),(13,1,'user.logout','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',NULL,'2025-12-11 12:16:14'),(14,1,'user.login','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','{\"email\": \"admin@example.com\", \"user_id\": \"1\", \"username\": \"admin\"}','2025-12-11 12:16:19');

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_categories_slug` (`slug`),
  KEY `idx_categories_parent` (`parent_id`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL,
  CONSTRAINT `categories_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  CONSTRAINT `categories_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `categories` */

/*Table structure for table `config_history` */

DROP TABLE IF EXISTS `config_history`;

CREATE TABLE `config_history` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `config_id` int(11) NOT NULL,
  `old_value` text COLLATE utf8mb4_unicode_ci,
  `new_value` text COLLATE utf8mb4_unicode_ci,
  `changed_by` int(11) DEFAULT NULL,
  `changed_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`history_id`),
  KEY `idx_config_history` (`config_id`),
  KEY `changed_by` (`changed_by`),
  CONSTRAINT `config_history_ibfk_1` FOREIGN KEY (`config_id`) REFERENCES `configurations` (`config_id`) ON DELETE CASCADE,
  CONSTRAINT `config_history_ibfk_2` FOREIGN KEY (`changed_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `config_history` */

/*Table structure for table `configurations` */

DROP TABLE IF EXISTS `configurations`;

CREATE TABLE `configurations` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `config_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `config_value` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `group_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`config_id`),
  UNIQUE KEY `config_key` (`config_key`),
  KEY `idx_config_key` (`config_key`),
  KEY `idx_config_group` (`group_name`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `configurations_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  CONSTRAINT `configurations_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `configurations` */

insert  into `configurations`(`config_id`,`config_key`,`config_value`,`description`,`group_name`,`created_by`,`updated_by`,`created_at`,`updated_at`) values (1,'site_name','My CMS',NULL,'general',NULL,NULL,'2025-12-09 23:37:26','2025-12-11 11:25:16'),(2,'site_description','A powerful content management system',NULL,'general',NULL,NULL,'2025-12-09 23:37:26','2025-12-11 11:25:16'),(3,'site_logo',NULL,NULL,'general',NULL,NULL,'2025-12-09 23:37:26','2025-12-09 23:37:26'),(4,'site_favicon',NULL,NULL,'general',NULL,NULL,'2025-12-09 23:37:26','2025-12-09 23:37:26'),(5,'contact_email','contact@example.com',NULL,'contact',NULL,NULL,'2025-12-09 23:37:26','2025-12-09 23:37:26'),(6,'contact_phone','+62812345678',NULL,'contact',NULL,NULL,'2025-12-09 23:37:26','2025-12-10 01:03:21'),(7,'contact_address','Jakarta, Indonesia',NULL,'contact',NULL,NULL,'2025-12-09 23:37:26','2025-12-10 01:03:29'),(8,'smtp_host',NULL,NULL,'email',NULL,NULL,'2025-12-09 23:37:26','2025-12-09 23:37:26'),(9,'smtp_port','587',NULL,'email',NULL,NULL,'2025-12-09 23:37:26','2025-12-09 23:37:26'),(10,'smtp_user',NULL,NULL,'email',NULL,NULL,'2025-12-09 23:37:26','2025-12-09 23:37:26'),(11,'smtp_pass',NULL,NULL,'email',NULL,NULL,'2025-12-09 23:37:26','2025-12-09 23:37:26'),(12,'maintenance_mode','0',NULL,'system',NULL,NULL,'2025-12-09 23:37:26','2025-12-11 11:25:16'),(13,'allow_registration','1',NULL,'system',NULL,NULL,'2025-12-09 23:37:26','2025-12-09 23:37:26'),(14,'default_language','id',NULL,'system',NULL,NULL,'2025-12-09 23:37:26','2025-12-09 23:37:26'),(34,'hero_title','Welcome to Our Website',NULL,NULL,NULL,NULL,'2025-12-10 01:03:40','2025-12-10 01:03:40'),(35,'hero_subtitle','Your tagline here',NULL,NULL,NULL,NULL,'2025-12-10 01:03:40','2025-12-10 01:03:40'),(36,'admin_email','',NULL,NULL,NULL,NULL,'2025-12-11 11:18:40','2025-12-11 11:25:16'),(37,'max_login_attempts','5',NULL,NULL,NULL,NULL,'2025-12-11 11:18:40','2025-12-11 11:25:16'),(38,'lockout_duration','15',NULL,NULL,NULL,NULL,'2025-12-11 11:18:40','2025-12-11 11:25:16'),(39,'session_lifetime','120',NULL,NULL,NULL,NULL,'2025-12-11 11:18:40','2025-12-11 11:25:16'),(40,'max_upload_size','5',NULL,NULL,NULL,NULL,'2025-12-11 11:18:40','2025-12-11 11:25:16'),(41,'allowed_file_types','jpg,jpeg,png,gif,pdf,doc,docx',NULL,NULL,NULL,NULL,'2025-12-11 11:18:40','2025-12-11 11:25:16'),(42,'maintenance_message','Site is under maintenance. Please check back later.',NULL,NULL,NULL,NULL,'2025-12-11 11:18:40','2025-12-11 11:25:16');

/*Table structure for table `content_blocks` */

DROP TABLE IF EXISTS `content_blocks`;

CREATE TABLE `content_blocks` (
  `block_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `block_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `block_data` json DEFAULT NULL,
  `sort_order` int(11) DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`block_id`),
  KEY `idx_blocks_page` (`page_id`),
  KEY `idx_blocks_order` (`sort_order`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `content_blocks_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`page_id`) ON DELETE CASCADE,
  CONSTRAINT `content_blocks_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  CONSTRAINT `content_blocks_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `content_blocks` */

/*Table structure for table `crud_logs` */

DROP TABLE IF EXISTS `crud_logs`;

CREATE TABLE `crud_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `table_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `record_id` int(11) DEFAULT NULL,
  `action` enum('create','read','update','delete') COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_data` json DEFAULT NULL,
  `new_data` json DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_crud_user` (`user_id`),
  KEY `idx_crud_table` (`table_name`),
  KEY `idx_crud_action` (`action`),
  KEY `idx_crud_created` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `crud_logs` */

insert  into `crud_logs`(`id`,`user_id`,`table_name`,`record_id`,`action`,`old_data`,`new_data`,`description`,`ip_address`,`user_agent`,`created_at`) values (1,1,'MEDIA',2,'create',NULL,'{\"file_name\": \"WhatsApp_Image_2025-10-31_at_08_46_25_(1).jpeg\", \"file_path\": \"./upload/media/234d157197ad907033844cb0e89fea1e.jpeg\", \"file_size\": 53.94, \"file_type\": \"image/jpeg\", \"created_at\": \"2025-12-09 23:53:00\", \"uploaded_by\": \"1\"}','Media uploaded','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-12-09 23:53:00'),(2,1,'USERS',2,'create',NULL,'{\"email\": \"ddarfa24@gmail.com\", \"username\": \"darva\", \"is_active\": \"1\", \"created_at\": \"2025-12-10 00:07:14\", \"password_hash\": \"a31610fcf9363e9a5ecfcc6766b75c11f076ad455308a6c305f1ea4a9173a844\", \"password_salt\": \"dadee4be2fbb310481f07c8af49dadfb\"}','User created','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-12-10 00:07:14'),(3,1,'MEDIA',1,'delete','{\"media_id\": \"1\", \"file_name\": \"WhatsApp_Image_2025-10-31_at_08_46_25_(1).jpeg\", \"file_path\": \"./upload/media/0c9edd82061a6980548c898ed7e69d70.jpeg\", \"file_size\": \"54\", \"file_type\": \"image/jpeg\", \"created_at\": \"2025-12-09 23:52:17\", \"uploaded_by\": \"1\", \"uploaded_by_name\": \"admin\"}',NULL,'Media deleted','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-12-10 00:21:32'),(4,1,'PAGES',1,'create',NULL,'{\"slug\": \"about\", \"title\": \"About\", \"status\": \"published\", \"created_at\": \"2025-12-10 00:27:12\", \"created_by\": \"1\", \"featured_image\": null}','Page created','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-12-10 00:27:12'),(5,1,'PAGES',1,'update','{\"slug\": \"about\", \"title\": \"About\", \"status\": \"draft\", \"content\": null, \"page_id\": \"1\", \"created_at\": \"2025-12-10 00:27:12\", \"created_by\": \"1\", \"updated_at\": \"2025-12-10 00:28:35\", \"updated_by\": \"1\", \"featured_image\": null, \"created_by_name\": \"admin\", \"updated_by_name\": \"admin\", \"featured_image_name\": null, \"featured_image_path\": null}','{\"slug\": \"about\", \"title\": \"About\", \"status\": \"draft\", \"content\": \"test\", \"updated_at\": \"2025-12-10 00:30:02\", \"updated_by\": \"1\", \"featured_image\": null}','Page updated','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-12-10 00:30:02'),(6,1,'MEDIA',2,'delete','{\"media_id\": \"2\", \"file_name\": \"WhatsApp_Image_2025-10-31_at_08_46_25_(1).jpeg\", \"file_path\": \"./upload/media/234d157197ad907033844cb0e89fea1e.jpeg\", \"file_size\": \"54\", \"file_type\": \"image/jpeg\", \"created_at\": \"2025-12-09 23:53:00\", \"uploaded_by\": \"1\", \"uploaded_by_name\": \"admin\"}',NULL,'Media deleted','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-12-10 00:31:26'),(7,1,'PAGES',1,'update','{\"slug\": \"about\", \"title\": \"About\", \"status\": \"published\", \"content\": \"test\", \"page_id\": \"1\", \"created_at\": \"2025-12-10 00:27:12\", \"created_by\": \"1\", \"updated_at\": \"2025-12-10 00:30:09\", \"updated_by\": \"1\", \"featured_image\": null, \"created_by_name\": \"admin\", \"updated_by_name\": \"admin\", \"featured_image_name\": null, \"featured_image_path\": null}','{\"slug\": \"about\", \"title\": \"About\", \"status\": \"published\", \"content\": \"test\", \"updated_at\": \"2025-12-10 00:31:42\", \"updated_by\": \"1\", \"featured_image\": null}','Page updated','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-12-10 00:31:42'),(8,1,'MEDIA',3,'create',NULL,'{\"file_name\": \"WhatsApp_Image_2025-10-31_at_08_46_25_(1).jpeg\", \"file_path\": \"./upload/media/bef93dfc42cf882376c76ec831ff746b.jpeg\", \"file_size\": 53.94, \"file_type\": \"image/jpeg\", \"created_at\": \"2025-12-10 00:31:53\", \"uploaded_by\": \"1\"}','Media uploaded','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-12-10 00:31:53'),(9,1,'PAGES',1,'update','{\"slug\": \"about\", \"title\": \"About\", \"status\": \"published\", \"content\": \"test\", \"page_id\": \"1\", \"created_at\": \"2025-12-10 00:27:12\", \"created_by\": \"1\", \"updated_at\": \"2025-12-10 00:31:42\", \"updated_by\": \"1\", \"featured_image\": null, \"created_by_name\": \"admin\", \"updated_by_name\": \"admin\", \"featured_image_name\": null, \"featured_image_path\": null}','{\"slug\": \"about\", \"title\": \"About\", \"status\": \"published\", \"content\": \"test\", \"updated_at\": \"2025-12-10 00:32:04\", \"updated_by\": \"1\", \"featured_image\": \"3\"}','Page updated','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-12-10 00:32:04'),(10,1,'PAGES',2,'create',NULL,'{\"slug\": \"tentang-kami\", \"title\": \"Tentang Kami\", \"status\": \"published\", \"content\": \"test\", \"created_at\": \"2025-12-10 11:53:39\", \"created_by\": \"1\", \"featured_image\": null}','Page created','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','2025-12-10 11:53:39');

/*Table structure for table `form_fields` */

DROP TABLE IF EXISTS `form_fields`;

CREATE TABLE `form_fields` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `field_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `placeholder` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `validation_rules` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`field_id`),
  KEY `idx_form_fields` (`form_id`),
  CONSTRAINT `form_fields_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`form_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `form_fields` */

/*Table structure for table `form_submissions` */

DROP TABLE IF EXISTS `form_submissions`;

CREATE TABLE `form_submissions` (
  `submission_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `data` json DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`submission_id`),
  KEY `idx_form_submissions` (`form_id`),
  CONSTRAINT `form_submissions_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`form_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `form_submissions` */

/*Table structure for table `forms` */

DROP TABLE IF EXISTS `forms`;

CREATE TABLE `forms` (
  `form_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`form_id`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `forms_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  CONSTRAINT `forms_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `forms` */

/*Table structure for table `login_attempts` */

DROP TABLE IF EXISTS `login_attempts`;

CREATE TABLE `login_attempts` (
  `attempt_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attempted_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `success` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`attempt_id`),
  KEY `idx_login_attempts_user` (`user_id`),
  KEY `idx_login_attempts_ip` (`ip_address`),
  KEY `idx_login_attempts_time` (`attempted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `login_attempts` */

/*Table structure for table `media` */

DROP TABLE IF EXISTS `media`;

CREATE TABLE `media` (
  `media_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`media_id`),
  KEY `idx_media_type` (`file_type`),
  KEY `created_by` (`uploaded_by`),
  CONSTRAINT `media_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `media` */

insert  into `media`(`media_id`,`file_name`,`file_path`,`file_type`,`file_size`,`uploaded_by`,`created_at`) values (3,'WhatsApp_Image_2025-10-31_at_08_46_25_(1).jpeg','./upload/media/bef93dfc42cf882376c76ec831ff746b.jpeg','image/jpeg',54,1,'2025-12-10 00:31:53');

/*Table structure for table `menu_items` */

DROP TABLE IF EXISTS `menu_items`;

CREATE TABLE `menu_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT '0',
  `is_active` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`item_id`),
  KEY `idx_menu_items_menu` (`menu_id`),
  KEY `idx_menu_items_parent` (`parent_id`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `menu_items_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`menu_id`) ON DELETE CASCADE,
  CONSTRAINT `menu_items_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`item_id`) ON DELETE SET NULL,
  CONSTRAINT `menu_items_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  CONSTRAINT `menu_items_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `menu_items` */

insert  into `menu_items`(`item_id`,`menu_id`,`title`,`url`,`target`,`icon`,`parent_id`,`sort_order`,`is_active`,`created_by`,`updated_by`,`created_at`,`updated_at`) values (3,2,'Profil','http://localhost/_LANDING_PAGE/project-website/profil','_self','',NULL,0,1,NULL,NULL,'2025-12-10 00:56:05','2025-12-10 00:56:05'),(4,2,'Tentang Kami','http://localhost/_LANDING_PAGE/project-website/page/tentang-kami','_self','',3,0,1,NULL,NULL,'2025-12-10 00:56:28','2025-12-11 11:56:24');

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_location` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`menu_id`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  CONSTRAINT `menus_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `menus` */

insert  into `menus`(`menu_id`,`menu_name`,`menu_location`,`description`,`created_by`,`updated_by`,`created_at`,`updated_at`) values (2,'Profil','header','Test',NULL,NULL,'2025-12-10 00:35:54','2025-12-10 00:55:31');

/*Table structure for table `mfa_tokens` */

DROP TABLE IF EXISTS `mfa_tokens`;

CREATE TABLE `mfa_tokens` (
  `mfa_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `secret_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mfa_id`),
  KEY `idx_mfa_user` (`user_id`),
  CONSTRAINT `mfa_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `mfa_tokens` */

/*Table structure for table `page_categories` */

DROP TABLE IF EXISTS `page_categories`;

CREATE TABLE `page_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_page_category` (`page_id`,`category_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `page_categories_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`page_id`) ON DELETE CASCADE,
  CONSTRAINT `page_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `page_categories` */

/*Table structure for table `page_sections` */

DROP TABLE IF EXISTS `page_sections`;

CREATE TABLE `page_sections` (
  `section_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `section_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_data` json DEFAULT NULL,
  `section_order` int(11) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`section_id`),
  KEY `idx_page_id` (`page_id`),
  KEY `idx_section_order` (`section_order`),
  CONSTRAINT `page_sections_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`page_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `page_sections` */

insert  into `page_sections`(`section_id`,`page_id`,`section_type`,`section_title`,`section_data`,`section_order`,`is_active`,`created_at`,`updated_at`) values (1,1,'hero','Welcome','{\"title\": \"Welcome to Our Site\", \"bg_color\": \"#4A90A4\", \"btn_link\": \"#about\", \"btn_text\": \"Learn More\", \"subtitle\": \"We provide the best solutions\", \"text_color\": \"#ffffff\"}',1,1,'2025-12-11 12:15:12','2025-12-11 12:15:12');

/*Table structure for table `page_tags` */

DROP TABLE IF EXISTS `page_tags`;

CREATE TABLE `page_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_page_tag` (`page_id`,`tag_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `page_tags_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`page_id`) ON DELETE CASCADE,
  CONSTRAINT `page_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `page_tags` */

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `content` text COLLATE utf8mb4_unicode_ci,
  `layout_template` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'full_width',
  `use_sections` tinyint(1) DEFAULT '0',
  `featured_image` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_pages_slug` (`slug`),
  KEY `idx_pages_status` (`status`),
  KEY `featured_image` (`featured_image`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`featured_image`) REFERENCES `media` (`media_id`) ON DELETE SET NULL,
  CONSTRAINT `pages_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  CONSTRAINT `pages_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pages` */

insert  into `pages`(`page_id`,`title`,`slug`,`status`,`content`,`layout_template`,`use_sections`,`featured_image`,`created_by`,`updated_by`,`created_at`,`updated_at`) values (1,'About','about','published','test','full_width',0,3,1,1,'2025-12-10 00:27:12','2025-12-11 12:21:02'),(2,'Tentang Kami','tentang-kami','published','test','full_width',1,NULL,1,NULL,'2025-12-10 11:53:39','2025-12-11 12:22:13');

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `reset_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `reset_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`reset_id`),
  UNIQUE KEY `reset_token` (`reset_token`),
  KEY `idx_resets_user` (`user_id`),
  KEY `idx_resets_token` (`reset_token`),
  CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_desc` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`permission_id`),
  UNIQUE KEY `permission_key` (`permission_key`),
  KEY `idx_permissions_key` (`permission_key`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permissions` */

insert  into `permissions`(`permission_id`,`permission_key`,`permission_desc`,`created_at`,`updated_at`) values (1,'users.view','View users list','2025-12-09 23:37:26','2025-12-09 23:37:26'),(2,'users.create','Create new users','2025-12-09 23:37:26','2025-12-09 23:37:26'),(3,'users.edit','Edit users','2025-12-09 23:37:26','2025-12-09 23:37:26'),(5,'roles.view','View roles','2025-12-09 23:37:26','2025-12-09 23:37:26'),(9,'pages.edit','Edit pages','2025-12-09 23:37:26','2025-12-09 23:37:26'),(12,'media.view','View media library','2025-12-09 23:37:26','2025-12-09 23:37:26'),(13,'media.upload','Upload media files','2025-12-09 23:37:26','2025-12-09 23:37:26'),(14,'media.delete','Delete media files','2025-12-09 23:37:26','2025-12-09 23:37:26'),(15,'menus.view','View menus','2025-12-09 23:37:26','2025-12-09 23:37:26'),(17,'categories.view','View categories','2025-12-09 23:37:26','2025-12-09 23:37:26'),(18,'categories.manage','Manage categories','2025-12-09 23:37:26','2025-12-09 23:37:26'),(19,'tags.view','View tags','2025-12-09 23:37:26','2025-12-09 23:37:26'),(20,'tags.manage','Manage tags','2025-12-09 23:37:26','2025-12-09 23:37:26'),(21,'forms.view','View forms','2025-12-09 23:37:26','2025-12-09 23:37:26'),(22,'forms.manage','Manage forms','2025-12-09 23:37:26','2025-12-09 23:37:26'),(23,'config.view','View configurations','2025-12-09 23:37:26','2025-12-09 23:37:26'),(24,'config.manage','Manage configurations','2025-12-09 23:37:26','2025-12-09 23:37:26'),(25,'logs.view','View system logs','2025-12-09 23:37:26','2025-12-09 23:37:26'),(26,'analytics.view','View analytics','2025-12-09 23:37:26','2025-12-09 23:37:26'),(27,'user.create','Create users','2025-12-10 00:01:40','2025-12-10 00:01:40'),(28,'user.read','View users','2025-12-10 00:01:40','2025-12-10 00:01:40'),(29,'user.update','Update users','2025-12-10 00:01:40','2025-12-10 00:01:40'),(30,'user.delete','Delete users','2025-12-10 00:01:40','2025-12-10 00:01:40'),(31,'role.manage','Manage roles and permissions','2025-12-10 00:01:40','2025-12-10 00:01:40'),(32,'page.create','Create pages','2025-12-10 00:01:40','2025-12-10 00:01:40'),(33,'page.read','View pages','2025-12-10 00:01:40','2025-12-10 00:01:40'),(34,'page.update','Update pages','2025-12-10 00:01:40','2025-12-10 00:01:40'),(35,'page.delete','Delete pages','2025-12-10 00:01:40','2025-12-10 00:01:40'),(36,'page.publish','Publish pages','2025-12-10 00:01:40','2025-12-10 00:01:40'),(37,'menu.manage','Manage menus','2025-12-10 00:01:40','2025-12-10 00:01:40'),(38,'audit.view','View audit logs','2025-12-10 00:01:40','2025-12-10 00:01:40'),(39,'traffic.view','View traffic statistics','2025-12-10 00:01:40','2025-12-10 00:01:40');

/*Table structure for table `role_permissions` */

DROP TABLE IF EXISTS `role_permissions`;

CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_role_permission` (`role_id`,`permission_id`),
  KEY `permission_id` (`permission_id`),
  CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE,
  CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `role_permissions` */

insert  into `role_permissions`(`id`,`role_id`,`permission_id`,`created_at`) values (1,1,26,'2025-12-09 23:37:26'),(2,1,18,'2025-12-09 23:37:26'),(3,1,17,'2025-12-09 23:37:26'),(4,1,24,'2025-12-09 23:37:26'),(5,1,23,'2025-12-09 23:37:26'),(6,1,22,'2025-12-09 23:37:26'),(7,1,21,'2025-12-09 23:37:26'),(8,1,25,'2025-12-09 23:37:26'),(9,1,14,'2025-12-09 23:37:26'),(10,1,13,'2025-12-09 23:37:26'),(11,1,12,'2025-12-09 23:37:26'),(13,1,15,'2025-12-09 23:37:26'),(16,1,9,'2025-12-09 23:37:26'),(20,1,5,'2025-12-09 23:37:26'),(21,1,20,'2025-12-09 23:37:26'),(22,1,19,'2025-12-09 23:37:26'),(23,1,2,'2025-12-09 23:37:26'),(25,1,3,'2025-12-09 23:37:26'),(26,1,1,'2025-12-09 23:37:26'),(39,1,38,'2025-12-10 00:15:50'),(40,1,37,'2025-12-10 00:15:50'),(41,1,32,'2025-12-10 00:15:50'),(42,1,35,'2025-12-10 00:15:50'),(43,1,36,'2025-12-10 00:15:50'),(44,1,33,'2025-12-10 00:15:50'),(45,1,34,'2025-12-10 00:15:50'),(46,1,31,'2025-12-10 00:15:50'),(47,1,39,'2025-12-10 00:15:50'),(48,1,27,'2025-12-10 00:15:50'),(49,1,30,'2025-12-10 00:15:50'),(50,1,28,'2025-12-10 00:15:50'),(51,1,29,'2025-12-10 00:15:50'),(69,3,13,'2025-12-10 00:15:50'),(70,3,32,'2025-12-10 00:15:50'),(71,3,33,'2025-12-10 00:15:50'),(72,3,34,'2025-12-10 00:15:50'),(76,2,32,'2025-12-10 00:20:04');

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_system` tinyint(1) DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_name` (`role_name`),
  KEY `idx_roles_name` (`role_name`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `roles_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  CONSTRAINT `roles_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`role_id`,`role_name`,`description`,`is_system`,`created_by`,`updated_by`,`created_at`,`updated_at`) values (1,'Super Admin','Full system access',1,NULL,NULL,'2025-12-09 23:37:26','2025-12-09 23:37:26'),(2,'Admin','Administrative access',0,NULL,NULL,'2025-12-09 23:37:26','2025-12-10 00:12:01'),(3,'Editor','Content management access',0,NULL,NULL,'2025-12-09 23:37:26','2025-12-09 23:37:26'),(4,'Author','Create and edit own content',0,NULL,NULL,'2025-12-09 23:37:26','2025-12-09 23:37:26'),(5,'Viewer','Read-only access',0,NULL,NULL,'2025-12-09 23:37:26','2025-12-09 23:37:26');

/*Table structure for table `security_blocklist` */

DROP TABLE IF EXISTS `security_blocklist`;

CREATE TABLE `security_blocklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blocked_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_blocklist_ip` (`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `security_blocklist` */

/*Table structure for table `seo_metadata` */

DROP TABLE IF EXISTS `seo_metadata`;

CREATE TABLE `seo_metadata` (
  `seo_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `og_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_description` text COLLATE utf8mb4_unicode_ci,
  `og_image` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`seo_id`),
  UNIQUE KEY `unique_page_seo` (`page_id`),
  CONSTRAINT `seo_metadata_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`page_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `seo_metadata` */

/*Table structure for table `tags` */

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tag_id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_tags_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tags` */

/*Table structure for table `traffic_logs` */

DROP TABLE IF EXISTS `traffic_logs`;

CREATE TABLE `traffic_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_path` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referrer` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_bot` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_traffic_user` (`user_id`),
  KEY `idx_traffic_ip` (`ip_address`),
  KEY `idx_traffic_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `traffic_logs` */

/*Table structure for table `traffic_summary` */

DROP TABLE IF EXISTS `traffic_summary`;

CREATE TABLE `traffic_summary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `total_visits` int(11) DEFAULT '0',
  `unique_visitors` int(11) DEFAULT '0',
  `page_views` int(11) DEFAULT '0',
  `top_page` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`),
  KEY `idx_summary_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `traffic_summary` */

/*Table structure for table `user_activity` */

DROP TABLE IF EXISTS `user_activity`;

CREATE TABLE `user_activity` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `activity` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`activity_id`),
  KEY `idx_activity_user` (`user_id`),
  KEY `idx_activity_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_activity` */

/*Table structure for table `user_roles` */

DROP TABLE IF EXISTS `user_roles`;

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `assigned_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_role` (`user_id`,`role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_roles` */

insert  into `user_roles`(`id`,`user_id`,`role_id`,`assigned_at`) values (1,1,1,'2025-12-10 00:01:40'),(4,2,2,'2025-12-10 00:07:14');

/*Table structure for table `user_sessions` */

DROP TABLE IF EXISTS `user_sessions`;

CREATE TABLE `user_sessions` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `session_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_info` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expires_at` datetime NOT NULL,
  `revoked` tinyint(1) DEFAULT '0',
  `is_mobile` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`session_id`),
  UNIQUE KEY `session_token` (`session_token`),
  KEY `idx_sessions_user` (`user_id`),
  KEY `idx_sessions_token` (`session_token`),
  KEY `idx_sessions_expires` (`expires_at`),
  CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_sessions` */

insert  into `user_sessions`(`session_id`,`user_id`,`session_token`,`device_info`,`ip_address`,`location`,`expires_at`,`revoked`,`is_mobile`,`created_at`,`updated_at`) values (1,1,'be0b8f6340c3c91324efc0cd8e7c589a69e4483e378ff6e1daa1978f6bee6601','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','::1',NULL,'2025-12-10 23:51:12',1,0,'2025-12-09 23:51:12','2025-12-09 23:57:52'),(2,1,'966612828a328b70f62849cf4d22ff6e6dc218861d888bbd1f410703858f4988','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','::1',NULL,'2025-12-10 23:58:08',1,0,'2025-12-09 23:58:08','2025-12-10 00:01:54'),(3,1,'79c95ddb2d3da382c5c6dc9ee8881518c67671e58f1de5c5aa427c1bccdf7643','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','::1',NULL,'2025-12-11 00:01:59',0,0,'2025-12-10 00:01:59','2025-12-10 00:01:59'),(4,2,'9e5bfcd47201cfe4479363e86c3b348959bb60d29f834d6de5b8880ec1abc1f0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','::1',NULL,'2025-12-11 00:07:26',1,0,'2025-12-10 00:07:26','2025-12-10 00:20:26'),(5,2,'fe9c7c8284a7ad9de606792364b1dcb41fc979e31cc06308fa5f8692c303ae15','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','::1',NULL,'2025-12-11 00:20:35',0,0,'2025-12-10 00:20:35','2025-12-10 00:20:35'),(6,1,'7a8fc74c5ebffdb717086fb4d7419c0b9fc0c6385ebd40264c8b9cf5b380427c','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','::1',NULL,'2025-12-11 09:44:03',0,0,'2025-12-10 09:44:03','2025-12-10 09:44:03'),(7,1,'cbe09b9e9e2daad5b1709b220b974b85d3e6606717915f9bde7bdc08fddc7c7b','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','::1',NULL,'2025-12-11 11:52:57',0,0,'2025-12-10 11:52:57','2025-12-10 11:52:57'),(8,1,'755a26fdc6d0d3cdf3421dccc591e8a7c7600cc21874dcb99fc29a01fbf1f9ad','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','::1',NULL,'2025-12-12 10:13:44',1,0,'2025-12-11 10:13:44','2025-12-11 12:16:14'),(9,1,'ee10aff29593a75b68dd41dd7872756069d96699e1aa53c2298e1b8c5ee89759','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','::1',NULL,'2025-12-12 12:16:19',0,0,'2025-12-11 12:16:19','2025-12-11 12:16:19');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_salt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `is_locked` tinyint(1) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  KEY `idx_users_email` (`email`),
  KEY `idx_users_username` (`username`),
  KEY `idx_users_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`user_id`,`email`,`username`,`password_hash`,`password_salt`,`is_active`,`is_locked`,`last_login`,`created_at`,`updated_at`) values (1,'admin@example.com','admin','70632ff10a681b1233a51c015d4f7b5f8ccd399d8926b51717792cead231637e','default_salt',1,0,'2025-12-11 12:16:19','2025-12-09 23:37:26','2025-12-11 12:16:19'),(2,'ddarfa24@gmail.com','darva','a31610fcf9363e9a5ecfcc6766b75c11f076ad455308a6c305f1ea4a9173a844','dadee4be2fbb310481f07c8af49dadfb',1,0,'2025-12-10 00:20:35','2025-12-10 00:07:14','2025-12-10 00:20:35');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
