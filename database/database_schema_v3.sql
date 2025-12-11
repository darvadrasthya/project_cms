-- =====================================================
-- CMS Database Schema v3 (Based on ERD)
-- Database: db_cms
-- Generated: December 9, 2025
-- =====================================================

SET FOREIGN_KEY_CHECKS = 0;

-- =====================================================
-- 1. AUTHENTICATION & USER MANAGEMENT TABLES
-- =====================================================

-- USERS Table
CREATE TABLE IF NOT EXISTS USERS (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    password_salt VARCHAR(255) NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    is_locked TINYINT(1) DEFAULT 0,
    last_login DATETIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_users_email (email),
    INDEX idx_users_username (username),
    INDEX idx_users_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- LOGIN_ATTEMPTS Table
CREATE TABLE IF NOT EXISTS LOGIN_ATTEMPTS (
    attempt_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    ip_address VARCHAR(45) NOT NULL,
    user_agent VARCHAR(500) NULL,
    attempted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    success TINYINT(1) DEFAULT 0,
    INDEX idx_login_attempts_user (user_id),
    INDEX idx_login_attempts_ip (ip_address),
    INDEX idx_login_attempts_time (attempted_at),
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- USER_SESSIONS Table
CREATE TABLE IF NOT EXISTS USER_SESSIONS (
    session_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    session_token VARCHAR(255) NOT NULL UNIQUE,
    device_info VARCHAR(500) NULL,
    ip_address VARCHAR(45) NULL,
    location VARCHAR(255) NULL,
    expires_at DATETIME NOT NULL,
    revoked TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_sessions_user (user_id),
    INDEX idx_sessions_token (session_token),
    INDEX idx_sessions_expires (expires_at),
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- PASSWORD_RESETS Table
CREATE TABLE IF NOT EXISTS PASSWORD_RESETS (
    reset_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    reset_token VARCHAR(255) NOT NULL UNIQUE,
    expires_at DATETIME NOT NULL,
    used TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_resets_user (user_id),
    INDEX idx_resets_token (reset_token),
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- MFA_TOKENS Table
CREATE TABLE IF NOT EXISTS MFA_TOKENS (
    mfa_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    secret_key VARCHAR(255) NOT NULL,
    enabled TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_mfa_user (user_id),
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 2. ROLES & PERMISSIONS TABLES
-- =====================================================

-- ROLES Table
CREATE TABLE IF NOT EXISTS ROLES (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(100) NOT NULL UNIQUE,
    description VARCHAR(500) NULL,
    is_system TINYINT(1) DEFAULT 0,
    created_by INT NULL,
    updated_by INT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_roles_name (role_name),
    FOREIGN KEY (created_by) REFERENCES USERS(user_id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES USERS(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- PERMISSIONS Table
CREATE TABLE IF NOT EXISTS PERMISSIONS (
    permission_id INT AUTO_INCREMENT PRIMARY KEY,
    permission_key VARCHAR(100) NOT NULL UNIQUE,
    permission_desc VARCHAR(500) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_permissions_key (permission_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ROLE_PERMISSIONS Table
CREATE TABLE IF NOT EXISTS ROLE_PERMISSIONS (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_role_permission (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES ROLES(role_id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES PERMISSIONS(permission_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- USER_ROLES Table
CREATE TABLE IF NOT EXISTS USER_ROLES (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    assigned_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_role (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES ROLES(role_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 3. CMS CONTENT TABLES
-- =====================================================

-- MEDIA Table (must be created before PAGES due to FK reference)
CREATE TABLE IF NOT EXISTS MEDIA (
    media_id INT AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_type VARCHAR(100) NULL,
    file_size INT NULL,
    created_by INT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_media_type (file_type),
    FOREIGN KEY (created_by) REFERENCES USERS(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- PAGES Table
CREATE TABLE IF NOT EXISTS PAGES (
    page_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    status ENUM('draft', 'published') DEFAULT 'draft',
    featured_image INT NULL,
    created_by INT NULL,
    updated_by INT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_pages_slug (slug),
    INDEX idx_pages_status (status),
    FOREIGN KEY (featured_image) REFERENCES MEDIA(media_id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES USERS(user_id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES USERS(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- CONTENT_BLOCKS Table
CREATE TABLE IF NOT EXISTS CONTENT_BLOCKS (
    block_id INT AUTO_INCREMENT PRIMARY KEY,
    page_id INT NOT NULL,
    block_type VARCHAR(100) NOT NULL,
    block_data JSON NULL,
    sort_order INT DEFAULT 0,
    created_by INT NULL,
    updated_by INT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_blocks_page (page_id),
    INDEX idx_blocks_order (sort_order),
    FOREIGN KEY (page_id) REFERENCES PAGES(page_id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES USERS(user_id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES USERS(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 4. MENU TABLES
-- =====================================================

-- MENUS Table
CREATE TABLE IF NOT EXISTS MENUS (
    menu_id INT AUTO_INCREMENT PRIMARY KEY,
    menu_name VARCHAR(100) NOT NULL,
    position VARCHAR(100) NULL,
    created_by INT NULL,
    updated_by INT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES USERS(user_id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES USERS(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- MENU_ITEMS Table
CREATE TABLE IF NOT EXISTS MENU_ITEMS (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    menu_id INT NOT NULL,
    label VARCHAR(255) NOT NULL,
    url VARCHAR(500) NULL,
    parent_id INT NULL,
    sort_order INT DEFAULT 0,
    created_by INT NULL,
    updated_by INT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_menu_items_menu (menu_id),
    INDEX idx_menu_items_parent (parent_id),
    FOREIGN KEY (menu_id) REFERENCES MENUS(menu_id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES MENU_ITEMS(item_id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES USERS(user_id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES USERS(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 5. CATEGORY & TAG TABLES
-- =====================================================

-- CATEGORIES Table
CREATE TABLE IF NOT EXISTS CATEGORIES (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    parent_id INT NULL,
    created_by INT NULL,
    updated_by INT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_categories_slug (slug),
    INDEX idx_categories_parent (parent_id),
    FOREIGN KEY (parent_id) REFERENCES CATEGORIES(category_id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES USERS(user_id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES USERS(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TAGS Table
CREATE TABLE IF NOT EXISTS TAGS (
    tag_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_tags_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- PAGE_CATEGORIES Table
CREATE TABLE IF NOT EXISTS PAGE_CATEGORIES (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_id INT NOT NULL,
    category_id INT NOT NULL,
    UNIQUE KEY unique_page_category (page_id, category_id),
    FOREIGN KEY (page_id) REFERENCES PAGES(page_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES CATEGORIES(category_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- PAGE_TAGS Table
CREATE TABLE IF NOT EXISTS PAGE_TAGS (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_id INT NOT NULL,
    tag_id INT NOT NULL,
    UNIQUE KEY unique_page_tag (page_id, tag_id),
    FOREIGN KEY (page_id) REFERENCES PAGES(page_id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES TAGS(tag_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 6. CONFIGURATION TABLES
-- =====================================================

-- CONFIGURATIONS Table
CREATE TABLE IF NOT EXISTS CONFIGURATIONS (
    config_id INT AUTO_INCREMENT PRIMARY KEY,
    config_key VARCHAR(100) NOT NULL UNIQUE,
    config_value TEXT NULL,
    group_name VARCHAR(100) NULL,
    created_by INT NULL,
    updated_by INT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_config_key (config_key),
    INDEX idx_config_group (group_name),
    FOREIGN KEY (created_by) REFERENCES USERS(user_id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES USERS(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- CONFIG_HISTORY Table
CREATE TABLE IF NOT EXISTS CONFIG_HISTORY (
    history_id INT AUTO_INCREMENT PRIMARY KEY,
    config_id INT NOT NULL,
    old_value TEXT NULL,
    new_value TEXT NULL,
    changed_by INT NULL,
    changed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_config_history (config_id),
    FOREIGN KEY (config_id) REFERENCES CONFIGURATIONS(config_id) ON DELETE CASCADE,
    FOREIGN KEY (changed_by) REFERENCES USERS(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 7. FORM BUILDER TABLES
-- =====================================================

-- FORMS Table
CREATE TABLE IF NOT EXISTS FORMS (
    form_id INT AUTO_INCREMENT PRIMARY KEY,
    form_name VARCHAR(255) NOT NULL,
    description VARCHAR(500) NULL,
    created_by INT NULL,
    updated_by INT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES USERS(user_id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES USERS(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- FORM_FIELDS Table
CREATE TABLE IF NOT EXISTS FORM_FIELDS (
    field_id INT AUTO_INCREMENT PRIMARY KEY,
    form_id INT NOT NULL,
    field_type VARCHAR(50) NOT NULL,
    label VARCHAR(255) NOT NULL,
    placeholder VARCHAR(255) NULL,
    validation_rules VARCHAR(500) NULL,
    sort_order INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_form_fields (form_id),
    FOREIGN KEY (form_id) REFERENCES FORMS(form_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- FORM_SUBMISSIONS Table
CREATE TABLE IF NOT EXISTS FORM_SUBMISSIONS (
    submission_id INT AUTO_INCREMENT PRIMARY KEY,
    form_id INT NOT NULL,
    data JSON NULL,
    ip_address VARCHAR(45) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_form_submissions (form_id),
    FOREIGN KEY (form_id) REFERENCES FORMS(form_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 8. SEO TABLE
-- =====================================================

-- SEO_METADATA Table
CREATE TABLE IF NOT EXISTS SEO_METADATA (
    seo_id INT AUTO_INCREMENT PRIMARY KEY,
    page_id INT NOT NULL,
    meta_title VARCHAR(255) NULL,
    meta_description TEXT NULL,
    meta_keywords TEXT NULL,
    og_title VARCHAR(255) NULL,
    og_description TEXT NULL,
    og_image VARCHAR(500) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_page_seo (page_id),
    FOREIGN KEY (page_id) REFERENCES PAGES(page_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 9. LOGGING TABLES
-- =====================================================

-- AUDIT_LOGS Table
CREATE TABLE IF NOT EXISTS AUDIT_LOGS (
    audit_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    action VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent VARCHAR(500) NULL,
    details JSON NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_audit_user (user_id),
    INDEX idx_audit_action (action),
    INDEX idx_audit_created (created_at),
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- CRUD_LOGS Table
CREATE TABLE IF NOT EXISTS CRUD_LOGS (
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
    INDEX idx_crud_created (created_at),
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- USER_ACTIVITY Table
CREATE TABLE IF NOT EXISTS USER_ACTIVITY (
    activity_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    activity TEXT NOT NULL,
    url VARCHAR(500) NULL,
    ip_address VARCHAR(45) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_activity_user (user_id),
    INDEX idx_activity_created (created_at),
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 10. TRAFFIC & ANALYTICS TABLES
-- =====================================================

-- TRAFFIC_LOGS Table
CREATE TABLE IF NOT EXISTS TRAFFIC_LOGS (
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
    INDEX idx_traffic_created (created_at),
    INDEX idx_traffic_bot (is_bot),
    FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TRAFFIC_SUMMARY Table
CREATE TABLE IF NOT EXISTS TRAFFIC_SUMMARY (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL UNIQUE,
    total_visits INT DEFAULT 0,
    unique_visitors INT DEFAULT 0,
    page_views INT DEFAULT 0,
    top_page VARCHAR(500) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_summary_date (date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 11. SECURITY TABLE
-- =====================================================

-- SECURITY_BLOCKLIST Table
CREATE TABLE IF NOT EXISTS SECURITY_BLOCKLIST (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    reason VARCHAR(500) NULL,
    blocked_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_blocklist_ip (ip_address)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- DEFAULT DATA
-- =====================================================

-- Insert default admin user (password: admin123)
INSERT INTO USERS (email, username, password_hash, password_salt, is_active, is_locked) VALUES
('admin@example.com', 'admin', SHA2(CONCAT('admin123', 'default_salt'), 256), 'default_salt', 1, 0)
ON DUPLICATE KEY UPDATE email = email;

-- Insert default roles
INSERT INTO ROLES (role_name, description, is_system) VALUES
('Super Admin', 'Full system access', 1),
('Admin', 'Administrative access', 1),
('Editor', 'Content management access', 0),
('Author', 'Create and edit own content', 0),
('Viewer', 'Read-only access', 0)
ON DUPLICATE KEY UPDATE role_name = role_name;

-- Insert default permissions
INSERT INTO PERMISSIONS (permission_key, permission_desc) VALUES
('users.view', 'View users list'),
('users.create', 'Create new users'),
('users.edit', 'Edit users'),
('users.delete', 'Delete users'),
('roles.view', 'View roles'),
('roles.manage', 'Manage roles and permissions'),
('pages.view', 'View pages'),
('pages.create', 'Create pages'),
('pages.edit', 'Edit pages'),
('pages.delete', 'Delete pages'),
('pages.publish', 'Publish pages'),
('media.view', 'View media library'),
('media.upload', 'Upload media files'),
('media.delete', 'Delete media files'),
('menus.view', 'View menus'),
('menus.manage', 'Manage menus'),
('categories.view', 'View categories'),
('categories.manage', 'Manage categories'),
('tags.view', 'View tags'),
('tags.manage', 'Manage tags'),
('forms.view', 'View forms'),
('forms.manage', 'Manage forms'),
('config.view', 'View configurations'),
('config.manage', 'Manage configurations'),
('logs.view', 'View system logs'),
('analytics.view', 'View analytics')
ON DUPLICATE KEY UPDATE permission_key = permission_key;

-- Assign Super Admin role to admin user
INSERT INTO USER_ROLES (user_id, role_id)
SELECT u.user_id, r.role_id 
FROM USERS u, ROLES r 
WHERE u.username = 'admin' AND r.role_name = 'Super Admin'
ON DUPLICATE KEY UPDATE assigned_at = CURRENT_TIMESTAMP;

-- Grant all permissions to Super Admin role
INSERT INTO ROLE_PERMISSIONS (role_id, permission_id)
SELECT r.role_id, p.permission_id
FROM ROLES r, PERMISSIONS p
WHERE r.role_name = 'Super Admin'
ON DUPLICATE KEY UPDATE created_at = CURRENT_TIMESTAMP;

-- Insert default configurations
INSERT INTO CONFIGURATIONS (config_key, config_value, group_name) VALUES
('site_name', 'My CMS', 'general'),
('site_description', 'A powerful content management system', 'general'),
('site_logo', NULL, 'general'),
('site_favicon', NULL, 'general'),
('contact_email', 'contact@example.com', 'contact'),
('contact_phone', NULL, 'contact'),
('contact_address', NULL, 'contact'),
('smtp_host', NULL, 'email'),
('smtp_port', '587', 'email'),
('smtp_user', NULL, 'email'),
('smtp_pass', NULL, 'email'),
('maintenance_mode', '0', 'system'),
('allow_registration', '1', 'system'),
('default_language', 'id', 'system')
ON DUPLICATE KEY UPDATE config_key = config_key;
