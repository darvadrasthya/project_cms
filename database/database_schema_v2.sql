-- =============================================
-- Database Schema - Multi-Tenant CMS 
-- Company Profile Website with Admin Panel
-- Generated: December 9, 2025
-- Version: 2.0
-- =============================================

SET FOREIGN_KEY_CHECKS = 0;

-- Drop tables if exists (in reverse order of dependencies)
DROP TABLE IF EXISTS `TRAFFIC_LOGS`;
DROP TABLE IF EXISTS `AUDIT_LOGS`;
DROP TABLE IF EXISTS `CONTACT_PERSONS`;
DROP TABLE IF EXISTS `JOBS`;
DROP TABLE IF EXISTS `BRANCHES`;
DROP TABLE IF EXISTS `LOCATIONS`;
DROP TABLE IF EXISTS `MENU_ITEMS`;
DROP TABLE IF EXISTS `MENUS`;
DROP TABLE IF EXISTS `CONTENTS`;
DROP TABLE IF EXISTS `CONFIGURATIONS`;
DROP TABLE IF EXISTS `USER_ROLES`;
DROP TABLE IF EXISTS `ROLE_PERMISSIONS`;
DROP TABLE IF EXISTS `PERMISSIONS`;
DROP TABLE IF EXISTS `ROLES`;
DROP TABLE IF EXISTS `MFA_TOKENS`;
DROP TABLE IF EXISTS `PASSWORD_RESETS`;
DROP TABLE IF EXISTS `USER_SESSIONS`;
DROP TABLE IF EXISTS `LOGIN_ATTEMPTS`;
DROP TABLE IF EXISTS `SUBSCRIPTIONS`;
DROP TABLE IF EXISTS `USERS`;
DROP TABLE IF EXISTS `CLIENTS`;
DROP TABLE IF EXISTS `MEDIA`;

SET FOREIGN_KEY_CHECKS = 1;

-- =============================================
-- 3. CLIENTS & SUBSCRIPTIONS (MULTI-TENANT)
-- =============================================

-- Table: CLIENTS
CREATE TABLE `CLIENTS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `company_name` VARCHAR(255) NOT NULL,
  `company_phone` VARCHAR(50) NULL,
  `company_email` VARCHAR(255) NULL,
  `company_address` TEXT NULL,
  `domain` VARCHAR(255) NULL,
  `logo` VARCHAR(500) NULL,
  `favicon` VARCHAR(500) NULL,
  `status` ENUM('active', 'inactive', 'expired') NOT NULL DEFAULT 'active',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_domain` (`domain`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: SUBSCRIPTIONS
CREATE TABLE `SUBSCRIPTIONS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `client_id` INT NOT NULL,
  `plan_name` VARCHAR(100) NOT NULL,
  `start_date` DATETIME NOT NULL,
  `end_date` DATETIME NOT NULL,
  `max_users` INT NOT NULL DEFAULT 10,
  `max_storage` INT NOT NULL DEFAULT 1024 COMMENT 'in MB',
  `status` ENUM('active', 'grace', 'expired') NOT NULL DEFAULT 'active',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_client_id` (`client_id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_end_date` (`end_date`),
  CONSTRAINT `fk_subscriptions_client` 
    FOREIGN KEY (`client_id`) 
    REFERENCES `CLIENTS` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 1. SECURITY & USERS
-- =============================================

-- Table: USERS
CREATE TABLE `USERS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `client_id` INT NULL COMMENT 'NULL for super admin',
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `password_salt` VARCHAR(255) NOT NULL,
  `avatar` VARCHAR(500) NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `is_locked` TINYINT(1) NOT NULL DEFAULT 0,
  `last_login` DATETIME NULL,
  `created_by` INT NULL,
  `updated_by` INT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_client_id` (`client_id`),
  INDEX `idx_email` (`email`),
  INDEX `idx_username` (`username`),
  INDEX `idx_is_active` (`is_active`),
  CONSTRAINT `fk_users_client` 
    FOREIGN KEY (`client_id`) 
    REFERENCES `CLIENTS` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: LOGIN_ATTEMPTS
CREATE TABLE `LOGIN_ATTEMPTS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL,
  `ip_address` VARCHAR(45) NOT NULL,
  `user_agent` VARCHAR(500) NULL,
  `success` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_ip_address` (`ip_address`),
  INDEX `idx_created_at` (`created_at`),
  CONSTRAINT `fk_login_attempts_user` 
    FOREIGN KEY (`user_id`) 
    REFERENCES `USERS` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: USER_SESSIONS
CREATE TABLE `USER_SESSIONS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `session_token` VARCHAR(255) NOT NULL UNIQUE,
  `device_info` VARCHAR(500) NULL,
  `ip_address` VARCHAR(45) NULL,
  `location` VARCHAR(255) NULL,
  `is_mobile` TINYINT(1) NOT NULL DEFAULT 0,
  `revoked` TINYINT(1) NOT NULL DEFAULT 0,
  `expires_at` DATETIME NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_session_token` (`session_token`),
  INDEX `idx_expires_at` (`expires_at`),
  CONSTRAINT `fk_user_sessions_user` 
    FOREIGN KEY (`user_id`) 
    REFERENCES `USERS` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: PASSWORD_RESETS
CREATE TABLE `PASSWORD_RESETS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `reset_token` VARCHAR(255) NOT NULL UNIQUE,
  `used` TINYINT(1) NOT NULL DEFAULT 0,
  `expires_at` DATETIME NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_reset_token` (`reset_token`),
  INDEX `idx_expires_at` (`expires_at`),
  CONSTRAINT `fk_password_resets_user` 
    FOREIGN KEY (`user_id`) 
    REFERENCES `USERS` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: MFA_TOKENS
CREATE TABLE `MFA_TOKENS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `secret_key` VARCHAR(255) NOT NULL,
  `enabled` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_user_id` (`user_id`),
  CONSTRAINT `fk_mfa_tokens_user` 
    FOREIGN KEY (`user_id`) 
    REFERENCES `USERS` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 2. ROLES & PERMISSIONS
-- =============================================

-- Table: ROLES
CREATE TABLE `ROLES` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `client_id` INT NULL COMMENT 'NULL for system roles',
  `role_name` VARCHAR(100) NOT NULL,
  `description` VARCHAR(500) NULL,
  `is_system` TINYINT(1) NOT NULL DEFAULT 0,
  `created_by` INT NULL,
  `updated_by` INT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_client_id` (`client_id`),
  INDEX `idx_role_name` (`role_name`),
  CONSTRAINT `fk_roles_client` 
    FOREIGN KEY (`client_id`) 
    REFERENCES `CLIENTS` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: PERMISSIONS
CREATE TABLE `PERMISSIONS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `permission_key` VARCHAR(100) NOT NULL UNIQUE,
  `permission_desc` VARCHAR(500) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
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
    REFERENCES `ROLES` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_role_permissions_permission` 
    FOREIGN KEY (`permission_id`) 
    REFERENCES `PERMISSIONS` (`id`) 
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
    REFERENCES `USERS` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_user_roles_role` 
    FOREIGN KEY (`role_id`) 
    REFERENCES `ROLES` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 4. CONFIGURATION SETTINGS
-- =============================================

-- Table: CONFIGURATIONS
CREATE TABLE `CONFIGURATIONS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `client_id` INT NULL COMMENT 'NULL for global configs',
  `config_key` VARCHAR(100) NOT NULL,
  `config_value` TEXT NULL,
  `group_name` VARCHAR(100) NULL,
  `description` VARCHAR(500) NULL,
  `created_by` INT NULL,
  `updated_by` INT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_client_config_key` (`client_id`, `config_key`),
  INDEX `idx_config_key` (`config_key`),
  INDEX `idx_client_id` (`client_id`),
  CONSTRAINT `fk_configurations_client` 
    FOREIGN KEY (`client_id`) 
    REFERENCES `CLIENTS` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 5. CONTENT MANAGEMENT
-- =============================================

-- Table: MEDIA
CREATE TABLE `MEDIA` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `client_id` INT NULL,
  `file_name` VARCHAR(255) NOT NULL,
  `file_path` VARCHAR(500) NOT NULL,
  `file_type` VARCHAR(100) NULL,
  `file_size` INT NULL COMMENT 'in bytes',
  `alt_text` VARCHAR(255) NULL,
  `uploaded_by` INT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_client_id` (`client_id`),
  INDEX `idx_file_type` (`file_type`),
  INDEX `idx_uploaded_by` (`uploaded_by`),
  CONSTRAINT `fk_media_client` 
    FOREIGN KEY (`client_id`) 
    REFERENCES `CLIENTS` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_media_uploaded_by` 
    FOREIGN KEY (`uploaded_by`) 
    REFERENCES `USERS` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: CONTENTS
CREATE TABLE `CONTENTS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `client_id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `content_body` LONGTEXT NULL,
  `featured_image` INT NULL,
  `seo_title` VARCHAR(255) NULL,
  `seo_desc` VARCHAR(500) NULL,
  `seo_keywords` VARCHAR(500) NULL,
  `status` ENUM('draft', 'published', 'archived') NOT NULL DEFAULT 'draft',
  `created_by` INT NULL,
  `updated_by` INT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_client_slug` (`client_id`, `slug`),
  INDEX `idx_client_id` (`client_id`),
  INDEX `idx_slug` (`slug`),
  INDEX `idx_status` (`status`),
  CONSTRAINT `fk_contents_client` 
    FOREIGN KEY (`client_id`) 
    REFERENCES `CLIENTS` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_contents_featured_image` 
    FOREIGN KEY (`featured_image`) 
    REFERENCES `MEDIA` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_contents_created_by` 
    FOREIGN KEY (`created_by`) 
    REFERENCES `USERS` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_contents_updated_by` 
    FOREIGN KEY (`updated_by`) 
    REFERENCES `USERS` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 6. MENU BUILDER
-- =============================================

-- Table: MENUS
CREATE TABLE `MENUS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `client_id` INT NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `description` VARCHAR(500) NULL,
  `position` VARCHAR(50) NULL COMMENT 'header, footer, sidebar',
  `created_by` INT NULL,
  `updated_by` INT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_client_id` (`client_id`),
  INDEX `idx_position` (`position`),
  CONSTRAINT `fk_menus_client` 
    FOREIGN KEY (`client_id`) 
    REFERENCES `CLIENTS` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: MENU_ITEMS
CREATE TABLE `MENU_ITEMS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `menu_id` INT NOT NULL,
  `parent_id` INT NULL,
  `title` VARCHAR(100) NOT NULL,
  `url` VARCHAR(500) NULL,
  `icon` VARCHAR(100) NULL,
  `target` VARCHAR(20) NULL DEFAULT '_self' COMMENT '_self, _blank',
  `sort_order` INT NOT NULL DEFAULT 0,
  `visible` TINYINT(1) NOT NULL DEFAULT 1,
  `created_by` INT NULL,
  `updated_by` INT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_menu_id` (`menu_id`),
  INDEX `idx_parent_id` (`parent_id`),
  INDEX `idx_sort_order` (`sort_order`),
  CONSTRAINT `fk_menu_items_menu` 
    FOREIGN KEY (`menu_id`) 
    REFERENCES `MENUS` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_menu_items_parent` 
    FOREIGN KEY (`parent_id`) 
    REFERENCES `MENU_ITEMS` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 7. AREA & BRANCHES
-- =============================================

-- Table: LOCATIONS
CREATE TABLE `LOCATIONS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `client_id` INT NOT NULL,
  `area_name` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  `created_by` INT NULL,
  `updated_by` INT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_client_id` (`client_id`),
  CONSTRAINT `fk_locations_client` 
    FOREIGN KEY (`client_id`) 
    REFERENCES `CLIENTS` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: BRANCHES
CREATE TABLE `BRANCHES` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `location_id` INT NOT NULL,
  `branch_name` VARCHAR(255) NOT NULL,
  `address` TEXT NULL,
  `phone` VARCHAR(50) NULL,
  `email` VARCHAR(255) NULL,
  `latitude` DECIMAL(10, 8) NULL,
  `longitude` DECIMAL(11, 8) NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_by` INT NULL,
  `updated_by` INT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_location_id` (`location_id`),
  INDEX `idx_is_active` (`is_active`),
  CONSTRAINT `fk_branches_location` 
    FOREIGN KEY (`location_id`) 
    REFERENCES `LOCATIONS` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 8. CAREER MODULE (Job Posting)
-- =============================================

-- Table: JOBS
CREATE TABLE `JOBS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `client_id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  `requirements` TEXT NULL,
  `location` VARCHAR(255) NULL,
  `job_type` ENUM('full-time', 'part-time', 'contract', 'internship') NULL DEFAULT 'full-time',
  `salary_min` DECIMAL(15, 2) NULL,
  `salary_max` DECIMAL(15, 2) NULL,
  `deadline` DATE NULL,
  `status` ENUM('open', 'closed') NOT NULL DEFAULT 'open',
  `created_by` INT NULL,
  `updated_by` INT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_client_id` (`client_id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_deadline` (`deadline`),
  CONSTRAINT `fk_jobs_client` 
    FOREIGN KEY (`client_id`) 
    REFERENCES `CLIENTS` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: CONTACT_PERSONS
CREATE TABLE `CONTACT_PERSONS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `client_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NULL,
  `phone` VARCHAR(50) NULL,
  `position` VARCHAR(255) NULL,
  `department` VARCHAR(255) NULL,
  `photo` VARCHAR(500) NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_by` INT NULL,
  `updated_by` INT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_client_id` (`client_id`),
  INDEX `idx_is_active` (`is_active`),
  CONSTRAINT `fk_contact_persons_client` 
    FOREIGN KEY (`client_id`) 
    REFERENCES `CLIENTS` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 9. TRAFFIC ANALYTICS MODULE
-- =============================================

-- Table: TRAFFIC_LOGS
CREATE TABLE `TRAFFIC_LOGS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `client_id` INT NULL,
  `session_id` VARCHAR(255) NULL,
  `user_id` INT NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` VARCHAR(500) NULL,
  `device_type` VARCHAR(50) NULL COMMENT 'desktop, mobile, tablet',
  `browser` VARCHAR(100) NULL,
  `os` VARCHAR(100) NULL,
  `referrer` VARCHAR(500) NULL,
  `page_visited` VARCHAR(500) NULL,
  `location` VARCHAR(255) NULL,
  `country` VARCHAR(100) NULL,
  `city` VARCHAR(100) NULL,
  `is_bot` TINYINT(1) NOT NULL DEFAULT 0,
  `visited_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_client_id` (`client_id`),
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_session_id` (`session_id`),
  INDEX `idx_visited_at` (`visited_at`),
  INDEX `idx_ip_address` (`ip_address`),
  CONSTRAINT `fk_traffic_logs_client` 
    FOREIGN KEY (`client_id`) 
    REFERENCES `CLIENTS` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- 10. AUDIT LOGS
-- =============================================

-- Table: AUDIT_LOGS
CREATE TABLE `AUDIT_LOGS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL,
  `action` VARCHAR(100) NOT NULL,
  `table_name` VARCHAR(100) NULL,
  `record_id` INT NULL,
  `old_data` JSON NULL,
  `new_data` JSON NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` VARCHAR(500) NULL,
  `details` JSON NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_action` (`action`),
  INDEX `idx_table_name` (`table_name`),
  INDEX `idx_created_at` (`created_at`),
  CONSTRAINT `fk_audit_logs_user` 
    FOREIGN KEY (`user_id`) 
    REFERENCES `USERS` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- INITIAL DATA SEEDS
-- =============================================

-- Insert default client (System/Platform)
INSERT INTO `CLIENTS` (`id`, `company_name`, `company_email`, `status`) VALUES
(1, 'System Platform', 'admin@system.com', 'active');

-- Insert default roles (System roles)
INSERT INTO `ROLES` (`id`, `client_id`, `role_name`, `description`, `is_system`) VALUES
(1, NULL, 'Super Admin', 'Full system access - Platform administrator', 1),
(2, NULL, 'Admin', 'Administrative access for client', 1),
(3, NULL, 'Editor', 'Content management access', 1),
(4, NULL, 'User', 'Basic user access', 1);

-- Insert default permissions
INSERT INTO `PERMISSIONS` (`permission_key`, `permission_desc`) VALUES
-- User Management
('user.create', 'Create users'),
('user.read', 'View users'),
('user.update', 'Update users'),
('user.delete', 'Delete users'),
-- Role Management
('role.create', 'Create roles'),
('role.read', 'View roles'),
('role.update', 'Update roles'),
('role.delete', 'Delete roles'),
('role.assign_permissions', 'Assign permissions to roles'),
-- Content Management
('content.create', 'Create content pages'),
('content.read', 'View content pages'),
('content.update', 'Update content pages'),
('content.delete', 'Delete content pages'),
('content.publish', 'Publish content pages'),
-- Media Management
('media.upload', 'Upload media files'),
('media.read', 'View media files'),
('media.delete', 'Delete media files'),
-- Menu Management
('menu.create', 'Create menus'),
('menu.read', 'View menus'),
('menu.update', 'Update menus'),
('menu.delete', 'Delete menus'),
-- Location & Branch Management
('location.create', 'Create locations'),
('location.read', 'View locations'),
('location.update', 'Update locations'),
('location.delete', 'Delete locations'),
('branch.create', 'Create branches'),
('branch.read', 'View branches'),
('branch.update', 'Update branches'),
('branch.delete', 'Delete branches'),
-- Job Management
('job.create', 'Create job postings'),
('job.read', 'View job postings'),
('job.update', 'Update job postings'),
('job.delete', 'Delete job postings'),
-- Contact Person Management
('contact.create', 'Create contact persons'),
('contact.read', 'View contact persons'),
('contact.update', 'Update contact persons'),
('contact.delete', 'Delete contact persons'),
-- Client Management (Super Admin only)
('client.create', 'Create clients'),
('client.read', 'View clients'),
('client.update', 'Update clients'),
('client.delete', 'Delete clients'),
-- Configuration Management
('config.read', 'View configurations'),
('config.update', 'Update configurations'),
-- Logs & Analytics
('audit.view', 'View audit logs'),
('traffic.view', 'View traffic statistics');

-- Assign all permissions to Super Admin role
INSERT INTO `ROLE_PERMISSIONS` (`role_id`, `permission_id`)
SELECT 1, `id` FROM `PERMISSIONS`;

-- Assign selected permissions to Admin role
INSERT INTO `ROLE_PERMISSIONS` (`role_id`, `permission_id`)
SELECT 2, `id` FROM `PERMISSIONS` 
WHERE `permission_key` NOT IN ('client.create', 'client.read', 'client.update', 'client.delete');

-- Assign content permissions to Editor role
INSERT INTO `ROLE_PERMISSIONS` (`role_id`, `permission_id`)
SELECT 3, `id` FROM `PERMISSIONS` 
WHERE `permission_key` IN (
    'content.create', 'content.read', 'content.update', 'content.publish',
    'media.upload', 'media.read',
    'menu.read', 'location.read', 'branch.read', 'job.read', 'contact.read'
);

-- Assign basic permissions to User role
INSERT INTO `ROLE_PERMISSIONS` (`role_id`, `permission_id`)
SELECT 4, `id` FROM `PERMISSIONS` 
WHERE `permission_key` IN ('content.read', 'media.read', 'menu.read');

-- Insert default system configurations
INSERT INTO `CONFIGURATIONS` (`client_id`, `config_key`, `config_value`, `group_name`, `description`) VALUES
(NULL, 'site_name', 'Company Profile CMS', 'general', 'Default site name'),
(NULL, 'site_description', 'Multi-tenant Company Profile CMS', 'general', 'Default site description'),
(NULL, 'default_language', 'id', 'general', 'Default language'),
(NULL, 'timezone', 'Asia/Jakarta', 'general', 'Default timezone'),
(NULL, 'max_login_attempts', '5', 'security', 'Maximum login attempts before lockout'),
(NULL, 'lockout_duration', '30', 'security', 'Account lockout duration in minutes'),
(NULL, 'session_timeout', '3600', 'security', 'Session timeout in seconds'),
(NULL, 'password_min_length', '8', 'security', 'Minimum password length'),
(NULL, 'enable_mfa', '0', 'security', 'Enable multi-factor authentication'),
(NULL, 'max_file_size', '5242880', 'media', 'Maximum file upload size in bytes (5MB)'),
(NULL, 'allowed_file_types', 'jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx', 'media', 'Allowed file upload types'),
(NULL, 'maintenance_mode', '0', 'system', 'Enable maintenance mode'),
(NULL, 'maintenance_message', 'Site is under maintenance. Please check back later.', 'system', 'Maintenance mode message');

-- Insert default super admin user
-- Password: admin123 (hashed with SHA256 + salt)
INSERT INTO `USERS` (`id`, `client_id`, `name`, `email`, `username`, `password_hash`, `password_salt`, `is_active`, `created_at`) VALUES
(1, NULL, 'Super Administrator', 'admin@system.com', 'superadmin', 
 '541ecdc83b705996bce5babdab83bde366b095837f30ce679f8be23c67216564', 
 '2270de8382f15891ff3401e56b05583f9002090f919c28c5f49e934f00d2c108', 
 1, NOW());

-- Assign Super Admin role to default admin user
INSERT INTO `USER_ROLES` (`user_id`, `role_id`, `assigned_at`) VALUES
(1, 1, NOW());

-- =============================================
-- END OF SCHEMA V2
-- =============================================
