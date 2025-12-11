-- =====================================================
-- Verify and Fix User Roles & Permissions
-- Run this to ensure Super Admin has proper access
-- =====================================================

-- Check current users
SELECT user_id, username, email, is_active, is_locked FROM USERS;

-- Check current roles
SELECT * FROM ROLES;

-- Check current permissions
SELECT * FROM PERMISSIONS;

-- Check user-role assignments
SELECT u.user_id, u.username, r.role_id, r.role_name 
FROM USERS u
LEFT JOIN USER_ROLES ur ON u.user_id = ur.user_id
LEFT JOIN ROLES r ON ur.role_id = r.role_id;

-- Check role-permission assignments for Super Admin
SELECT r.role_name, p.permission_key, p.permission_desc 
FROM ROLES r
JOIN ROLE_PERMISSIONS rp ON r.role_id = rp.role_id
JOIN PERMISSIONS p ON rp.permission_id = p.permission_id
WHERE r.role_name = 'Super Admin';

-- =====================================================
-- FIX: Ensure Super Admin role exists
-- =====================================================
INSERT INTO ROLES (role_id, role_name, description, is_system) 
SELECT 1, 'Super Admin', 'Full system access', 1
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM ROLES WHERE role_name = 'Super Admin');

-- =====================================================
-- FIX: Ensure all permissions exist
-- =====================================================
INSERT INTO PERMISSIONS (permission_key, permission_desc) VALUES
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
('traffic.view', 'View traffic statistics')
ON DUPLICATE KEY UPDATE permission_key = permission_key;

-- =====================================================
-- FIX: Assign ALL permissions to Super Admin role
-- =====================================================
INSERT INTO ROLE_PERMISSIONS (role_id, permission_id)
SELECT r.role_id, p.permission_id
FROM ROLES r
CROSS JOIN PERMISSIONS p
WHERE r.role_name = 'Super Admin'
ON DUPLICATE KEY UPDATE role_id = role_id;

-- =====================================================
-- FIX: Assign Super Admin role to first user (admin)
-- =====================================================
INSERT INTO USER_ROLES (user_id, role_id)
SELECT u.user_id, r.role_id
FROM USERS u, ROLES r
WHERE u.username = 'admin' AND r.role_name = 'Super Admin'
ON DUPLICATE KEY UPDATE assigned_at = CURRENT_TIMESTAMP;

-- OR assign to user with specific user_id (e.g., user_id = 1)
INSERT INTO USER_ROLES (user_id, role_id)
SELECT 1, r.role_id
FROM ROLES r
WHERE r.role_name = 'Super Admin'
ON DUPLICATE KEY UPDATE assigned_at = CURRENT_TIMESTAMP;

-- =====================================================
-- Verify fix was applied
-- =====================================================
SELECT 'User Roles After Fix:' as info;
SELECT u.user_id, u.username, r.role_name 
FROM USERS u
JOIN USER_ROLES ur ON u.user_id = ur.user_id
JOIN ROLES r ON ur.role_id = r.role_id;

SELECT 'Super Admin Permissions Count:' as info;
SELECT COUNT(*) as total_permissions
FROM ROLE_PERMISSIONS rp
JOIN ROLES r ON rp.role_id = r.role_id
WHERE r.role_name = 'Super Admin';
