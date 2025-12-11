# CMS System - Complete Installation Guide

## 📋 Daftar Isi
1. [Requirement](#requirement)
2. [Instalasi Database](#instalasi-database)
3. [Konfigurasi](#konfigurasi)
4. [Struktur Sistem](#struktur-sistem)
5. [Fitur Utama](#fitur-utama)
6. [Penggunaan](#penggunaan)

---

## 🔧 Requirement

- PHP 7.4 atau lebih tinggi
- MySQL 5.7+ atau MariaDB 10.2+
- Apache/Nginx web server
- CodeIgniter 3.x
- Extension PHP yang diperlukan:
  - mysqli
  - json
  - session
  - mbstring
  - openssl

---

## 💾 Instalasi Database

### 1. Buat Database Baru

```sql
CREATE DATABASE cms_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Import Schema Database

Jalankan file `database_schema.sql` yang sudah dibuat:

```bash
mysql -u root -p cms_system < database_schema.sql
```

Atau via phpMyAdmin:
1. Login ke phpMyAdmin
2. Pilih database `cms_system`
3. Import file `database_schema.sql`

### 3. Verifikasi Instalasi

Database akan memiliki 20 tabel:
- USERS
- LOGIN_ATTEMPTS
- USER_SESSIONS
- PASSWORD_RESETS
- MFA_TOKENS
- ROLES
- PERMISSIONS
- ROLE_PERMISSIONS
- USER_ROLES
- CONFIGURATIONS
- MEDIA
- PAGES
- MENUS
- MENU_ITEMS
- AUDIT_LOGS
- CRUD_LOGS
- TRAFFIC_LOGS
- TRAFFIC_SUMMARY

---

## ⚙️ Konfigurasi

### 1. Database Configuration

Edit file `application/config/database.php`:

```php
$db['default'] = array(
    'dsn'   => '',
    'hostname' => 'localhost',
    'username' => 'root',        // Sesuaikan username
    'password' => '',             // Sesuaikan password
    'database' => 'cms_system',  // Nama database
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_unicode_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
```

### 2. Base URL Configuration

Edit file `application/config/config.php`:

```php
$config['base_url'] = 'http://localhost/project-website/';
```

### 3. Autoload Configuration

Edit file `application/config/autoload.php`:

```php
$autoload['libraries'] = array('database', 'session');
$autoload['helper'] = array('url', 'security', 'form');
```

### 4. Routes Configuration

Edit file `application/config/routes.php`:

```php
$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth routes
$route['login'] = 'authcontroller/login';
$route['logout'] = 'authcontroller/logout';
$route['register'] = 'authcontroller/register';

// Admin routes
$route['dashboard'] = 'dashboardcontroller/index';
$route['users'] = 'usercontroller/index';
$route['pages'] = 'pagecontroller/index';
$route['media'] = 'mediacontroller/index';
```

---

## 📁 Struktur Sistem

### Models (application/models/)
- **UserModel.php** - Manajemen users
- **RoleModel.php** - Manajemen roles & user roles
- **PermissionModel.php** - Manajemen permissions
- **PageModel.php** - Manajemen pages/content
- **MediaModel.php** - Manajemen media files
- **MenuModel.php** - Manajemen menu & menu items
- **AuditLogModel.php** - Audit logs
- **CrudLogModel.php** - CRUD operation logs
- **TrafficLogModel.php** - Traffic & visitor logs
- **LoginAttemptModel.php** - Login attempts tracking
- **UserSessionModel.php** - Session management
- **ConfigurationModel.php** - System configuration

### Libraries (application/libraries/)
- **MY_Auth.php** - Authentication library (login, logout, register)
- **MY_Authorization.php** - Authorization library (roles & permissions)

### Controllers (application/controllers/)
- **AuthController.php** - Authentication (login, logout, register, forgot password)
- **DashboardController.php** - Dashboard & analytics
- **UserController.php** - User management (CRUD)
- **PageController.php** - Page/Content management (CRUD)
- **MediaController.php** - Media library management
- *Dan controller lainnya sesuai kebutuhan*

---

## 🎯 Fitur Utama

### 1. Authentication & Authorization
- ✅ Login/Logout dengan rate limiting
- ✅ User registration dengan approval
- ✅ Password hashing dengan salt (SHA-256)
- ✅ Session management dengan database tracking
- ✅ Login attempt tracking (mencegah brute force)
- ✅ Multi-factor authentication (MFA) support
- ✅ Password reset functionality

### 2. User Management
- ✅ CRUD Users
- ✅ User roles & permissions
- ✅ User activation/deactivation
- ✅ Account locking
- ✅ User profile management

### 3. Role & Permission Management
- ✅ CRUD Roles
- ✅ CRUD Permissions
- ✅ Assign permissions to roles
- ✅ Assign roles to users
- ✅ System roles protection

### 4. Content Management (Pages)
- ✅ CRUD Pages
- ✅ Rich text editor support
- ✅ Featured image
- ✅ SEO meta tags (title, description)
- ✅ Page status (draft/published)
- ✅ Auto slug generation

### 5. Media Library
- ✅ File upload (images, documents)
- ✅ File type validation
- ✅ File size limit
- ✅ Media browser
- ✅ Delete media

### 6. Menu Management
- ✅ CRUD Menus
- ✅ CRUD Menu Items
- ✅ Nested menu support
- ✅ Menu ordering

### 7. Logging & Auditing
- ✅ Audit logs (user activities)
- ✅ CRUD logs (data changes)
- ✅ Traffic logs (visitor tracking)
- ✅ Daily traffic summary
- ✅ Device & browser statistics

### 8. System Configuration
- ✅ Dynamic configuration
- ✅ Grouped settings
- ✅ Configuration management UI

---

## 📖 Penggunaan

### Default Login Credentials

Setelah instalasi, Anda perlu membuat user pertama secara manual atau melalui registrasi.

**Membuat Super Admin via SQL:**

```sql
-- Hash password: admin123 (ganti dengan password Anda)
-- Generate salt dan hash di PHP atau gunakan library

INSERT INTO USERS (email, username, password_hash, password_salt, is_active, created_at) 
VALUES (
    'admin@example.com', 
    'admin', 
    'hash_password_anda', 
    'salt_anda', 
    1, 
    NOW()
);

-- Assign Super Admin role
INSERT INTO USER_ROLES (user_id, role_id, assigned_at) 
VALUES (1, 1, NOW());
```

### Menggunakan Auth Library

```php
// Load library
$this->load->library('MY_Auth', null, 'auth');

// Login
$result = $this->auth->login($login, $password);

// Logout
$this->auth->logout();

// Check if logged in
if ($this->auth->is_logged_in()) {
    // User is logged in
}

// Get current user
$user = $this->auth->user();
$user_id = $this->auth->user_id();

// Require login
$this->auth->require_login();
```

### Menggunakan Authorization Library

```php
// Load library
$this->load->library('MY_Authorization', null, 'authorization');

// Check role
if ($this->authorization->has_role('Super Admin')) {
    // User is super admin
}

// Check permission
if ($this->authorization->has_permission('user.create')) {
    // User can create users
}

// Require permission
$this->authorization->require_permission('user.delete');

// Check CRUD permissions
$this->authorization->can_create('user');
$this->authorization->can_read('user');
$this->authorization->can_update('user');
$this->authorization->can_delete('user');
```

### Logging

```php
// Audit log
$this->load->model('AuditLogModel');
$this->AuditLogModel->log('user.login', ['user_id' => 1], $user_id);

// CRUD log
$this->load->model('CrudLogModel');
$this->CrudLogModel->log('USERS', 'create', $user_id, null, $data, 'User created', $current_user_id);

// Traffic log
$this->load->model('TrafficLogModel');
$this->TrafficLogModel->log_visit($user_id);
```

---

## 🔒 Security Best Practices

1. **Ganti password default** setelah instalasi
2. **Set environment** ke production di `index.php`
3. **Aktifkan CSRF protection** di `config/config.php`
4. **Gunakan HTTPS** untuk production
5. **Set proper file permissions** (755 untuk folder, 644 untuk file)
6. **Backup database** secara berkala
7. **Update CodeIgniter** ke versi terbaru
8. **Validasi semua input** dari user
9. **Gunakan prepared statements** (sudah built-in di CI Active Record)
10. **Enable error logging** tapi disable error display di production

---

## 📝 Notes

- Sistem ini menggunakan CodeIgniter 3
- Password di-hash menggunakan SHA-256 dengan salt
- Session disimpan di database untuk tracking
- Semua aktivitas user di-log untuk audit trail
- Support untuk multi-factor authentication (MFA)
- Built-in rate limiting untuk login

---

## 🤝 Support

Jika ada pertanyaan atau masalah, silakan hubungi developer.

---

**Version:** 1.0.0  
**Last Updated:** December 9, 2025
