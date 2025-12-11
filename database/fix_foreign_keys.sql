-- =====================================================
-- Fix Foreign Key Constraints for Audit/Log Tables
-- Run this script after deploying database_schema_v3.sql
-- Compatible with MySQL 5.x and 8.x
-- =====================================================

-- Drop foreign key constraints on logging tables to allow orphan user_id values
-- This is important because:
-- 1. Users may be deleted but their logs should remain
-- 2. Logs may reference users that no longer exist

-- First, check existing foreign keys with this query:
-- SELECT TABLE_NAME, CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE 
-- WHERE REFERENCED_TABLE_NAME = 'USERS' AND TABLE_SCHEMA = DATABASE();

-- Disable FK checks temporarily
SET FOREIGN_KEY_CHECKS = 0;

-- Fix AUDIT_LOGS - run these one by one, ignore errors if FK doesn't exist
-- ALTER TABLE AUDIT_LOGS DROP FOREIGN KEY audit_logs_ibfk_1;

-- Fix CRUD_LOGS
-- ALTER TABLE CRUD_LOGS DROP FOREIGN KEY crud_logs_ibfk_1;

-- Fix TRAFFIC_LOGS
-- ALTER TABLE TRAFFIC_LOGS DROP FOREIGN KEY traffic_logs_ibfk_1;

-- Fix USER_ACTIVITY
-- ALTER TABLE USER_ACTIVITY DROP FOREIGN KEY user_activity_ibfk_1;

-- Fix LOGIN_ATTEMPTS
-- ALTER TABLE LOGIN_ATTEMPTS DROP FOREIGN KEY login_attempts_ibfk_1;

-- Re-enable FK checks
SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- ALTERNATIVE: Recreate tables without FK constraints
-- =====================================================

-- Drop and recreate AUDIT_LOGS without FK
DROP TABLE IF EXISTS AUDIT_LOGS;
CREATE TABLE AUDIT_LOGS (
    audit_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    action VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent VARCHAR(500) NULL,
    details JSON NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_audit_user (user_id),
    INDEX idx_audit_action (action),
    INDEX idx_audit_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Drop and recreate CRUD_LOGS without FK
DROP TABLE IF EXISTS CRUD_LOGS;
CREATE TABLE CRUD_LOGS (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    table_name VARCHAR(100) NOT NULL,
    record_id INT NULL,
    action ENUM('create', 'read', 'update', 'delete') NOT NULL,
    old_data JSON NULL,
    new_data JSON NULL,
    ip_address VARCHAR(45) NULL,
    user_agent VARCHAR(500) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_crud_user (user_id),
    INDEX idx_crud_table (table_name),
    INDEX idx_crud_action (action),
    INDEX idx_crud_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Drop and recreate TRAFFIC_LOGS without FK
DROP TABLE IF EXISTS TRAFFIC_LOGS;
CREATE TABLE TRAFFIC_LOGS (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    ip_address VARCHAR(45) NOT NULL,
    device VARCHAR(100) NULL,
    browser VARCHAR(100) NULL,
    os VARCHAR(100) NULL,
    url_path VARCHAR(500) NULL,
    referrer VARCHAR(500) NULL,
    country VARCHAR(100) NULL,
    city VARCHAR(100) NULL,
    is_bot TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_traffic_user (user_id),
    INDEX idx_traffic_ip (ip_address),
    INDEX idx_traffic_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Drop and recreate USER_ACTIVITY without FK
DROP TABLE IF EXISTS USER_ACTIVITY;
CREATE TABLE USER_ACTIVITY (
    activity_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    activity TEXT NOT NULL,
    url VARCHAR(500) NULL,
    ip_address VARCHAR(45) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_activity_user (user_id),
    INDEX idx_activity_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Drop and recreate LOGIN_ATTEMPTS without FK
DROP TABLE IF EXISTS LOGIN_ATTEMPTS;
CREATE TABLE LOGIN_ATTEMPTS (
    attempt_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    ip_address VARCHAR(45) NOT NULL,
    user_agent VARCHAR(500) NULL,
    attempted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    success TINYINT(1) DEFAULT 0,
    INDEX idx_login_attempts_user (user_id),
    INDEX idx_login_attempts_ip (ip_address),
    INDEX idx_login_attempts_time (attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Verify user exists with ID being used
-- =====================================================
-- Run this to check existing users:
-- SELECT user_id, username, email FROM USERS;

-- If no users exist, insert a default admin:
INSERT INTO USERS (user_id, email, username, password_hash, password_salt, is_active, is_locked) 
SELECT 1, 'admin@example.com', 'admin', SHA2(CONCAT('admin123', 'default_salt'), 256), 'default_salt', 1, 0
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM USERS WHERE user_id = 1);
