# 🚀 Project CMS - Content Management System

[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue)](https://php.net)
[![CodeIgniter](https://img.shields.io/badge/CodeIgniter-3.x-orange)](https://codeigniter.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.2-purple)](https://getbootstrap.com)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)

Sistem Manajemen Konten (CMS) lengkap yang dibangun dengan **CodeIgniter 3** dan **Bootstrap 5**. Dilengkapi dengan fitur autentikasi, manajemen user & role, manajemen halaman, menu builder, media library, dan audit logging.

---

## 📋 Daftar Isi

- [Fitur](#-fitur)
- [Teknologi](#-teknologi)
- [Struktur Database](#-struktur-database)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Penggunaan](#-penggunaan)
- [Screenshot](#-screenshot)
- [Kontribusi](#-kontribusi)

---

## ✨ Fitur

### 🔐 Authentication & Security
- Login/Logout dengan session management
- Password hashing SHA-256 dengan salt
- Login attempt tracking & rate limiting
- Account locking setelah gagal login berulang
- Session management di database

### 👥 User Management
- CRUD Users lengkap
- Role-based access control (RBAC)
- Assign multiple roles ke user
- User activation/deactivation
- Account lock/unlock

### 🛡️ Authorization & Permissions
- Dynamic permissions system
- Permission checking per action
- Super Admin bypass untuk semua permission
- Menu visibility berdasarkan permission

### 📄 Page Management
- CRUD Pages dengan WYSIWYG editor (Summernote)
- SEO-friendly slugs
- Meta title & description
- Featured image support
- Draft/Published status
- Public page view (`/page/{slug}`)

### 🍔 Menu Builder
- Unlimited nested menus
- Drag & drop ordering
- Multiple menu positions (header, footer, sidebar)
- Menu preview
- Icon support (Bootstrap Icons)

### 🖼️ Media Library
- Upload gambar & dokumen
- Organized media management
- Image preview
- File type validation

### 📊 Audit & Logging
- Audit trail semua aktivitas
- CRUD operation logging
- User activity tracking

### 🌐 Public Website
- Dynamic header/footer menu
- Public page display
- Responsive design
- SEO ready

---

## 🛠️ Teknologi

| Komponen | Teknologi |
|----------|-----------|
| **Backend** | PHP 7.4+, CodeIgniter 3.x |
| **Database** | MySQL 5.7+ / MariaDB 10+ |
| **Frontend** | Bootstrap 5.3.2, jQuery 3.x |
| **Icons** | Bootstrap Icons |
| **Editor** | Summernote WYSIWYG |
| **Server** | Apache/Nginx, Laragon (development) |

---

## 🗄️ Struktur Database

Database terdiri dari **14 tabel** utama:

### User & Auth
```
USERS              - Data user
ROLES              - Master roles
PERMISSIONS        - Master permissions
USER_ROLES         - Relasi user-role
ROLE_PERMISSIONS   - Relasi role-permission
LOGIN_ATTEMPTS     - Log percobaan login
USER_SESSIONS      - Session management
```

### Content Management
```
PAGES              - Halaman/konten
MEDIA              - File media (gambar, dokumen)
MENUS              - Master menu
MENU_ITEMS         - Item menu
```

### System & Logging
```
SITE_CONFIGURATIONS - Pengaturan website
AUDIT_LOGS          - Log aktivitas
```

---

## 📦 Instalasi

### Prasyarat
- PHP >= 7.4
- MySQL >= 5.7 atau MariaDB >= 10.3
- Apache/Nginx dengan mod_rewrite
- Composer (opsional)

### Langkah Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/darvadrasthya/project_cms.git
   cd project_cms
   ```

2. **Buat database**
   ```sql
   CREATE DATABASE cms_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. **Import schema database**
   ```bash
   mysql -u root -p cms_db < database/database_schema_v3.sql
   ```

4. **Konfigurasi database**
   
   Edit file `application/config/database.php`:
   ```php
   $db['default'] = array(
       'hostname' => 'localhost',
       'username' => 'root',
       'password' => '',
       'database' => 'cms_db',
       'dbdriver' => 'mysqli',
       // ...
   );
   ```

5. **Konfigurasi base URL**
   
   Edit file `application/config/config.php`:
   ```php
   $config['base_url'] = 'http://localhost/project_cms/';
   ```

6. **Set permission folder**
   ```bash
   chmod 777 upload/
   chmod 777 application/logs/
   chmod 777 application/cache/
   ```

7. **Akses aplikasi**
   ```
   http://localhost/project_cms/
   ```

---

## ⚙️ Konfigurasi

### Default Login
```
Email    : superadmin@cms.com
Password : password123
Role     : Super Admin
```

### Role & Permission Default

| Role | Permission |
|------|------------|
| **Super Admin** | Akses semua fitur (bypass permission) |
| **Admin** | user.*, page.*, media.*, config.manage |
| **Editor** | page.*, media.* |
| **Author** | page.view, page.create, page.edit |

---

## 🎯 Penggunaan

### Struktur URL Admin
```
/auth/login           - Halaman login
/dashboard            - Dashboard admin
/users                - Manajemen user
/roles                - Manajemen role
/permissions          - Manajemen permission
/pages                - Manajemen halaman
/menus                - Menu builder
/media                - Media library
/logs                 - Activity logs
/settings             - Pengaturan website
```

### Struktur URL Public
```
/                     - Homepage
/page/{slug}          - Halaman publik berdasarkan slug
```

---

## 📁 Struktur Folder

```
project_cms/
├── application/
│   ├── config/          # Konfigurasi CI
│   ├── controllers/     # Controllers
│   ├── helpers/         # Custom helpers
│   ├── libraries/       # Custom libraries (Auth, Authorization)
│   ├── models/          # Models
│   └── views/           # Views
│       ├── auth/        # Login views
│       ├── dashboard/   # Dashboard views
│       ├── menus/       # Menu management views
│       ├── pages/       # Page management views
│       ├── public/      # Public template (header, footer)
│       ├── roles/       # Role management views
│       ├── settings/    # Settings views
│       ├── templates/   # Admin template
│       └── users/       # User management views
├── assets/
│   ├── css/             # Stylesheet
│   ├── js/              # JavaScript
│   ├── img/             # Images
│   └── plugins/         # Third-party plugins
├── database/
│   └── database_schema_v3.sql  # SQL schema
├── system/              # CodeIgniter system
├── upload/              # Upload directory
└── index.php            # Entry point
```

---

## 📸 Screenshot

### Login Page
Modern login page dengan validasi

### Dashboard
Dashboard admin dengan statistik dan menu sidebar

### User Management
CRUD user dengan role assignment

### Page Editor
WYSIWYG editor dengan Summernote

### Menu Builder
Drag & drop menu management

---

## 🔧 File Konfigurasi Penting

| File | Fungsi |
|------|--------|
| `config/config.php` | Base URL, encryption key |
| `config/database.php` | Koneksi database |
| `config/autoload.php` | Auto-load libraries & helpers |
| `config/routes.php` | Routing URL |

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan:

1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

---

## 📄 Lisensi

Distributed under the MIT License. See `LICENSE` for more information.

---

## 📞 Kontak

**Developer:** darvadrasthya

**Repository:** [https://github.com/darvadrasthya/project_cms](https://github.com/darvadrasthya/project_cms)

---

⭐ **Jangan lupa berikan star jika project ini membantu!** ⭐
