<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Public Header Template
 * Variables: $site_name, $site_logo, $header_menu, $meta_title, $meta_description
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($meta_title ?? $title ?? 'Website'); ?><?php if(!empty($site_name)): ?> | <?php echo htmlspecialchars($site_name); ?><?php endif; ?></title>
    
    <?php if(!empty($meta_description)): ?>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php endif; ?>
    
    <?php if(!empty($meta_keywords)): ?>
    <meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
    <?php endif; ?>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/logo/favicon.png'); ?>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/public.css'); ?>">
    
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --dark-color: #1a1a2e;
            --light-color: #f8f9fa;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-color);
            color: #333;
        }
        
        /* Navbar Styles */
        .navbar {
            padding: 15px 0;
            transition: all 0.3s ease;
        }
        
        .navbar-brand img {
            max-height: 45px;
            transition: all 0.3s ease;
        }
        
        .navbar-brand-text {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .navbar-dark .navbar-brand-text {
            background: linear-gradient(135deg, #fff, #e0e0e0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .navbar.scrolled {
            padding: 10px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }
        
        .nav-link {
            font-weight: 500;
            padding: 8px 16px !important;
            transition: all 0.3s ease;
        }
        
        .navbar-dark .nav-link:hover {
            color: #fff !important;
            background: rgba(255,255,255,0.1);
            border-radius: 5px;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border-radius: 10px;
            padding: 10px 0;
        }
        
        .dropdown-item {
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .dropdown-item:hover {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: #fff;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 80px 0 60px;
            position: relative;
        }
        
        /* Content Styles */
        .content-section {
            padding: 60px 0;
        }
        
        .page-content {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.08);
        }
        
        .page-content img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        
        .featured-image {
            width: 100%;
            max-height: 450px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
        }
        
        .btn-outline-light:hover {
            background: white;
            color: var(--primary-color);
        }
        
        /* Footer */
        footer {
            background: var(--dark-color);
            color: #adb5bd;
            padding: 50px 0 30px;
        }
        
        footer a {
            color: #adb5bd;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        footer a:hover {
            color: #fff;
        }
        
        .footer-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 15px;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            display: inline-block;
            padding: 3px 0;
        }
        
        .footer-links a:hover {
            padding-left: 5px;
        }
        
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
            margin-top: 30px;
        }
        
        /* Scroll to top */
        .scroll-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
            border: none;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        
        .scroll-to-top.visible {
            opacity: 1;
            visibility: visible;
        }
        
        .scroll-to-top:hover {
            transform: translateY(-5px);
        }
    </style>
    
    <?php if(isset($extra_css)): ?>
    <?php echo $extra_css; ?>
    <?php endif; ?>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo base_url(); ?>">
                <?php if(!empty($site_logo)): ?>
                    <img src="<?php echo base_url('upload/' . $site_logo); ?>" alt="<?php echo htmlspecialchars($site_name ?? 'Logo'); ?>" class="me-2">
                <?php endif; ?>
                <span class="navbar-brand-text"><?php echo htmlspecialchars($site_name ?? 'Website'); ?></span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto">
                    <?php if(!empty($header_menu)): ?>
                        <?php foreach($header_menu as $item): ?>
                            <?php 
                            $item_title = $item['title'] ?? $item['label'] ?? '';
                            $item_url = $item['url'] ?? '#';
                            $item_target = $item['target'] ?? '_self';
                            $item_icon = $item['icon'] ?? '';
                            ?>
                            
                            <?php if(!empty($item['children'])): ?>
                                <!-- Dropdown Menu -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navDropdown<?php echo $item['item_id']; ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php if(!empty($item_icon)): ?><i class="<?php echo htmlspecialchars($item_icon); ?> me-1"></i><?php endif; ?>
                                        <?php echo htmlspecialchars($item_title); ?>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navDropdown<?php echo $item['item_id']; ?>">
                                        <?php foreach($item['children'] as $child): ?>
                                            <?php 
                                            $child_title = $child['title'] ?? $child['label'] ?? '';
                                            $child_url = $child['url'] ?? '#';
                                            $child_target = $child['target'] ?? '_self';
                                            $child_icon = $child['icon'] ?? '';
                                            ?>
                                            <li>
                                                <a class="dropdown-item" href="<?php echo htmlspecialchars($child_url); ?>" target="<?php echo htmlspecialchars($child_target); ?>">
                                                    <?php if(!empty($child_icon)): ?><i class="<?php echo htmlspecialchars($child_icon); ?> me-2"></i><?php endif; ?>
                                                    <?php echo htmlspecialchars($child_title); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <!-- Regular Menu Item -->
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo htmlspecialchars($item_url); ?>" target="<?php echo htmlspecialchars($item_target); ?>">
                                        <?php if(!empty($item_icon)): ?><i class="<?php echo htmlspecialchars($item_icon); ?> me-1"></i><?php endif; ?>
                                        <?php echo htmlspecialchars($item_title); ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback menu -->
                        <li class="nav-item">
                            <a class="nav-link active" href="<?php echo base_url(); ?>">
                                <i class="bi bi-house me-1"></i> Home
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
