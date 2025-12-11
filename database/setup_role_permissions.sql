-- =====================================================
-- Setup Permissions per Role
-- Super Admin: All permissions
-- Admin: User management, Page management, Media management
-- Editor: Page & Media only
-- User: Read only
-- =====================================================

-- First, clear existing role permissions for non-Super Admin roles
DELETE FROM ROLE_PERMISSIONS WHERE role_id IN (
    SELECT role_id FROM ROLES WHERE role_name IN ('Admin', 'Editor', 'User')
);

-- Get role IDs
SET @super_admin_id = (SELECT role_id FROM ROLES WHERE role_name = 'Super Admin');
SET @admin_id = (SELECT role_id FROM ROLES WHERE role_name = 'Admin');
SET @editor_id = (SELECT role_id FROM ROLES WHERE role_name = 'Editor');
SET @user_id = (SELECT role_id FROM ROLES WHERE role_name = 'User');

-- Super Admin gets ALL permissions (already set, but ensure)
INSERT INTO ROLE_PERMISSIONS (role_id, permission_id)
SELECT @super_admin_id, permission_id FROM PERMISSIONS
ON DUPLICATE KEY UPDATE role_id = role_id;

-- Admin permissions (NO: menu.manage, role.manage, audit.view, config.manage)
INSERT INTO ROLE_PERMISSIONS (role_id, permission_id)
SELECT @admin_id, permission_id FROM PERMISSIONS 
WHERE permission_key IN (
    'user.create', 'user.read', 'user.update', 'user.delete',
    'page.create', 'page.read', 'page.update', 'page.delete', 'page.publish',
    'media.upload', 'media.delete',
    'traffic.view'
)
ON DUPLICATE KEY UPDATE role_id = role_id;

-- Editor permissions (Page & Media management only)
INSERT INTO ROLE_PERMISSIONS (role_id, permission_id)
SELECT @editor_id, permission_id FROM PERMISSIONS 
WHERE permission_key IN (
    'page.create', 'page.read', 'page.update',
    'media.upload'
)
ON DUPLICATE KEY UPDATE role_id = role_id;

-- User permissions (Read only)
INSERT INTO ROLE_PERMISSIONS (role_id, permission_id)
SELECT @user_id, permission_id FROM PERMISSIONS 
WHERE permission_key IN (
    'page.read'
)
ON DUPLICATE KEY UPDATE role_id = role_id;

-- =====================================================
-- Verify permissions per role
-- =====================================================
SELECT r.role_name, GROUP_CONCAT(p.permission_key ORDER BY p.permission_key SEPARATOR ', ') as permissions
FROM ROLES r
LEFT JOIN ROLE_PERMISSIONS rp ON r.role_id = rp.role_id
LEFT JOIN PERMISSIONS p ON rp.permission_id = p.permission_id
GROUP BY r.role_id, r.role_name
ORDER BY r.role_id;
