-- =============================================
-- Database Schema - CMS with Authentication System
-- Generated: December 9, 2025
-- =============================================

-- Drop tables if exists (in reverse order of dependencies)
DROP TABLE IF EXISTS `TRAFFIC_SUMMARY`;
DROP TABLE IF EXISTS `TRAFFIC_LOGS`;
DROP TABLE IF EXISTS `CRUD_LOGS`;
DROP TABLE IF EXISTS `AUDIT_LOGS`;
DROP TABLE IF EXISTS `MENU_ITEMS`;
DROP TABLE IF EXISTS `MENUS`;
DROP TABLE IF EXISTS `PAGES`;
DROP TABLE IF EXISTS `MEDIA`;
DROP TABLE IF EXISTS `CONFIGURATIONS`;
DROP TABLE IF EXISTS `USER_ROLES`;
DROP TABLE IF EXISTS `ROLE_PERMISSIONS`;
DROP TABLE IF EXISTS `PERMISSIONS`;
DROP TABLE IF EXISTS `ROLES`;
DROP TABLE IF EXISTS `MFA_TOKENS`;
DROP TABLE IF EXISTS `PASSWORD_RESETS`;
DROP TABLE IF EXISTS `USER_SESSIONS`;
DROP TABLE IF EXISTS `LOGIN_ATTEMPTS`;
DROP TABLE IF EXISTS `USERS`;

-- =============================================
-- USER MANAGEMENT TABLES
-- =============================================

-- Table: USERS
CREATE TABLE `USERS` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `password_salt` VARCHAR(255) NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `is_locked` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  `last_login` DATETIME NULL,
  PRIMARY KEY (`user_id`),
  INDEX `idx_email` (`email`),
  INDEX `idx_username` (`username`),
  INDEX `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: LOGIN_ATTEMPTS
CREATE TABLE `LOGIN_ATTEMPTS` (
  `attempt_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL,
  `ip_address` VARCHAR(45) NOT NULL,
  `user_agent` VARCHAR(500) NULL,
  `attempted_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `success` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`attempt_id`),
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_ip_address` (`ip_address`),
  INDEX `idx_attempted_at` (`attempted_at`),
  CONSTRAINT `fk_login_attempts_user` 
    FOREIGN KEY (`user_id`) 
    REFERENCES `USERS` (`user_id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: USER_SESSIONS
CREATE TABLE `USER_SESSIONS` (
  `session_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `session_token` VARCHAR(255) NOT NULL UNIQUE,
  `device_info` VARCHAR(500) NULL,
  `ip_address` VARCHAR(45) NULL,
  `location` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` DATETIME NOT NULL,
  `revoked` TINYINT(1) NOT NULL DEFAULT 0,
  `is_mobile` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`session_id`),
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_session_token` (`session_token`),
  INDEX `idx_expires_at` (`expires_at`),
  CONSTRAINT `fk_user_sessions_user` 
    FOREIGN KEY (`user_id`) 
    REFERENCES `USERS` (`user_id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: PASSWORD_RESETS
CREATE TABLE `PASSWORD_RESETS` (
  `reset_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `reset_token` VARCHAR(255) NOT NULL UNIQUE,
  `requested_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` DATETIME NOT NULL,
  `used` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`reset_id`),
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_reset_token` (`reset_token`),
  INDEX `idx_expires_at` (`expires_at`),
  CONSTRAINT `fk_password_resets_user` 
    FOREIGN KEY (`user_id`) 
    REFERENCES `USERS` (`user_id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: MFA_TOKENS
CREATE TABLE `MFA_TOKENS` (
  `mfa_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `secret_key` VARCHAR(255) NOT NULL,
  `enabled` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mfa_id`),
  INDEX `idx_user_id` (`user_id`),
  CONSTRAINT `fk_mfa_tokens_user` 
    FOREIGN KEY (`user_id`) 
    REFERENCES `USERS` (`user_id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- ROLE & PERMISSION TABLES
-- =============================================

-- Table: ROLES
CREATE TABLE `ROLES` (
  `role_id` INT NOT NULL AUTO_INCREMENT,
  `role_name` VARCHAR(100) NOT NULL UNIQUE,
  `description` VARCHAR(500) NULL,
  `is_system` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`role_id`),
  INDEX `idx_role_name` (`role_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: PERMISSIONS
CREATE TABLE `PERMISSIONS` (
  `permission_id` INT NOT NULL AUTO_INCREMENT,
  `permission_key` VARCHAR(100) NOT NULL UNIQUE,
  `permission_desc` VARCHAR(500) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`permission_id`),
  INDEX `idx_permission_key` (`permission_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: ROLE_PERMISSIONS
CREATE TABLE `ROLE_PERMISSIONS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `role_id` INT NOT NULL,
  `permission_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_role_permission` (`role_id`, `permission_id`),
  INDEX `idx_role_id` (`role_id`),
  INDEX `idx_permission_id` (`permission_id`),
  CONSTRAINT `fk_role_permissions_role` 
    FOREIGN KEY (`role_id`) 
    REFERENCES `ROLES` (`role_id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_role_permissions_permission` 
    FOREIGN KEY (`permission_id`) 
    REFERENCES `PERMISSIONS` (`permission_id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: USER_ROLES
CREATE TABLE `USER_ROLES` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `role_id` INT NOT NULL,
  `assigned_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_user_role` (`user_id`, `role_id`),
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_role_id` (`role_id`),
  CONSTRAINT `fk_user_roles_user` 
    FOREIGN KEY (`user_id`) 
    REFERENCES `USERS` (`user_id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_user_roles_role` 
    FOREIGN KEY (`role_id`) 
    REFERENCES `ROLES` (`role_id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- CONTENT MANAGEMENT TABLES
-- =============================================

-- Table: MEDIA
CREATE TABLE `MEDIA` (
  `media_id` INT NOT NULL AUTO_INCREMENT,
  `file_name` VARCHAR(255) NOT NULL,
  `file_path` VARCHAR(500) NOT NULL,
  `file_type` VARCHAR(50) NULL,
  `file_size` INT NULL,
  `uploaded_by` INT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`media_id`),
  INDEX `idx_uploaded_by` (`uploaded_by`),
  INDEX `idx_file_type` (`file_type`),
  CONSTRAINT `fk_media_uploaded_by` 
    FOREIGN KEY (`uploaded_by`) 
    REFERENCES `USERS` (`user_id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: PAGES
CREATE TABLE `PAGES` (
  `page_id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `content` LONGTEXT NULL,
  `featured_image` INT NULL,
  `meta_title` VARCHAR(255) NULL,
  `meta_description` VARCHAR(500) NULL,
  `status` ENUM('draft','published') NOT NULL DEFAULT 'draft',
  `created_by` INT NULL,
  `updated_by` INT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`page_id`),
  INDEX `idx_slug` (`slug`),
  INDEX `idx_status` (`status`),
  INDEX `idx_created_by` (`created_by`),
  INDEX `idx_updated_by` (`updated_by`),
  INDEX `idx_featured_image` (`featured_image`),
  CONSTRAINT `fk_pages_created_by` 
    FOREIGN KEY (`created_by`) 
    REFERENCES `USERS` (`user_id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_pages_updated_by` 
    FOREIGN KEY (`updated_by`) 
    REFERENCES `USERS` (`user_id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_pages_featured_image` 
    FOREIGN KEY (`featured_image`) 
    REFERENCES `MEDIA` (`media_id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: MENUS
CREATE TABLE `MENUS` (
  `menu_id` INT NOT NULL AUTO_INCREMENT,
  `menu_name` VARCHAR(100) NOT NULL,
  `position` VARCHAR(50) NULL,
  `created_by` INT NULL,
  `updated_by` INT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`menu_id`),
  INDEX `idx_created_by` (`created_by`),
  INDEX `idx_updated_by` (`updated_by`),
  CONSTRAINT `fk_menus_created_by` 
    FOREIGN KEY (`created_by`) 
    REFERENCES `USERS` (`user_id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_menus_updated_by` 
    FOREIGN KEY (`updated_by`) 
    REFERENCES `USERS` (`user_id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: MENU_ITEMS
CREATE TABLE `MENU_ITEMS` (
  `item_id` INT NOT NULL AUTO_INCREMENT,
  `menu_id` INT NOT NULL,
  `label` VARCHAR(100) NOT NULL,
  `url` VARCHAR(500) NULL,
  `parent_id` INT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_by` INT NULL,
  `updated_by` INT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`item_id`),
  INDEX `idx_menu_id` (`menu_id`),
  INDEX `idx_parent_id` (`parent_id`),
  INDEX `idx_sort_order` (`sort_order`),
  INDEX `idx_created_by` (`created_by`),
  INDEX `idx_updated_by` (`updated_by`),
  CONSTRAINT `fk_menu_items_menu` 
    FOREIGN KEY (`menu_id`) 
    REFERENCES `MENUS` (`menu_id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_menu_items_parent` 
    FOREIGN KEY (`parent_id`) 
    REFERENCES `MENU_ITEMS` (`item_id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_menu_items_created_by` 
    FOREIGN KEY (`created_by`) 
    REFERENCES `USERS` (`user_id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_menu_items_updated_by` 
    FOREIGN KEY (`updated_by`) 
    REFERENCES `USERS` (`user_id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: CONFIGURATIONS
CREATE TABLE `CONFIGURATIONS` (
  `config_id` INT NOT NULL AUTO_INCREMENT,
  `config_key` VARCHAR(100) NOT NULL UNIQUE,
  `config_value` TEXT NULL,
  `group_name` VARCHAR(100) NULL,
  `description` VARCHAR(500) NULL,
  `updated_by` INT NULL,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`config_id`),
  INDEX `idx_config_key` (`config_key`),
  INDEX `idx_group_name` (`group_name`),
  INDEX `idx_updated_by` (`updated_by`),
  CONSTRAINT `fk_configurations_updated_by` 
    FOREIGN KEY (`updated_by`) 
    REFERENCES `USERS` (`user_id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- LOGGING & AUDIT TABLES
-- =============================================

-- Table: AUDIT_LOGS
CREATE TABLE `AUDIT_LOGS` (
  `audit_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL,
  `action` VARCHAR(100) NOT NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` VARCHAR(500) NULL,
  `details` JSON NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`audit_id`),
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_action` (`action`),
  INDEX `idx_created_at` (`created_at`),
  CONSTRAINT `fk_audit_logs_user` 
    FOREIGN KEY (`user_id`) 
    REFERENCES `USERS` (`user_id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: CRUD_LOGS
CREATE TABLE `CRUD_LOGS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL,
  `table_name` VARCHAR(100) NOT NULL,
  `record_id` INT NULL,
  `action` ENUM('create','read','update','delete') NOT NULL,
  `old_data` JSON NULL,
  `new_data` JSON NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` VARCHAR(500) NULL,
  `description` TEXT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_table_name` (`table_name`),
  INDEX `idx_action` (`action`),
  INDEX `idx_created_at` (`created_at`),
  CONSTRAINT `fk_crud_logs_user` 
    FOREIGN KEY (`user_id`) 
    REFERENCES `USERS` (`user_id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- TRAFFIC MONITORING TABLES
-- =============================================

-- Table: TRAFFIC_LOGS
CREATE TABLE `TRAFFIC_LOGS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `session_id` VARCHAR(255) NULL,
  `user_id` INT NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` VARCHAR(500) NULL,
  `device` VARCHAR(100) NULL,
  `browser` VARCHAR(100) NULL,
  `os` VARCHAR(100) NULL,
  `url_path` VARCHAR(500) NULL,
  `referrer` VARCHAR(500) NULL,
  `country` VARCHAR(100) NULL,
  `city` VARCHAR(100) NULL,
  `is_bot` TINYINT(1) NOT NULL DEFAULT 0,
  `accessed_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_session_id` (`session_id`),
  INDEX `idx_accessed_at` (`accessed_at`),
  INDEX `idx_ip_address` (`ip_address`),
  CONSTRAINT `fk_traffic_logs_user` 
    FOREIGN KEY (`user_id`) 
    REFERENCES `USERS` (`user_id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: TRAFFIC_SUMMARY
CREATE TABLE `TRAFFIC_SUMMARY` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `total_visits` INT NOT NULL DEFAULT 0,
  `unique_visitors` INT NOT NULL DEFAULT 0,
  `page_views` INT NOT NULL DEFAULT 0,
  `top_page` VARCHAR(500) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_date` (`date`),
  INDEX `idx_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- INITIAL DATA SEEDS
-- =============================================

-- Insert default roles
INSERT INTO `ROLES` (`role_name`, `description`, `is_system`) VALUES
('Super Admin', 'Full system access', 1),
('Admin', 'Administrative access', 1),
('Editor', 'Content management access', 1),
('User', 'Basic user access', 1);

-- Insert default permissions
INSERT INTO `PERMISSIONS` (`permission_key`, `permission_desc`) VALUES
('user.create', 'Create users'),
('user.read', 'View users'),
('user.update', 'Update users'),
('user.delete', 'Delete users'),
('role.manage', 'Manage roles and permissions'),
('page.create', 'Create pages'),
('page.read', 'View pages'),
('page.update', 'Update pages'),
('page.delete', 'Delete pages'),
('page.publish', 'Publish pages'),
('media.upload', 'Upload media files'),
('media.delete', 'Delete media files'),
('menu.manage', 'Manage menus'),
('config.manage', 'Manage system configurations'),
('audit.view', 'View audit logs'),
('traffic.view', 'View traffic statistics');

-- Assign all permissions to Super Admin role
INSERT INTO `ROLE_PERMISSIONS` (`role_id`, `permission_id`)
SELECT 1, `permission_id` FROM `PERMISSIONS`;

-- Insert default configurations
INSERT INTO `CONFIGURATIONS` (`config_key`, `config_value`, `group_name`, `description`) VALUES
('site_name', 'My CMS', 'general', 'Website name'),
('site_description', 'Content Management System', 'general', 'Website description'),
('max_login_attempts', '5', 'security', 'Maximum login attempts before lockout'),
('lockout_duration', '30', 'security', 'Account lockout duration in minutes'),
('session_timeout', '3600', 'security', 'Session timeout in seconds'),
('password_min_length', '8', 'security', 'Minimum password length'),
('enable_mfa', '0', 'security', 'Enable multi-factor authentication'),
('max_file_size', '5242880', 'media', 'Maximum file upload size in bytes (5MB)'),
('allowed_file_types', 'jpg,jpeg,png,gif,pdf,doc,docx', 'media', 'Allowed file upload types');

-- =============================================
-- END OF SCHEMA
-- =============================================
