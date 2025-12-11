<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo isset($title) ? $title . ' - ' : ''; ?>CMS Admin</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
	<style>
		:root {
			--sidebar-width: 260px;
			--primary-color: #667eea;
			--secondary-color: #764ba2;
		}

		body {
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			background-color: #f4f6f9;
		}

		.sidebar {
			position: fixed;
			top: 0;
			left: 0;
			width: var(--sidebar-width);
			height: 100vh;
			background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
			padding: 0;
			z-index: 1000;
			overflow-y: auto;
		}

		.sidebar-brand {
			padding: 20px;
			text-align: center;
			border-bottom: 1px solid rgba(255, 255, 255, 0.1);
		}

		.sidebar-brand h4 {
			color: white;
			margin: 0;
			font-weight: 700;
		}

		.sidebar-menu {
			padding: 15px 0;
		}

		.sidebar-menu .nav-link {
			color: rgba(255, 255, 255, 0.8);
			padding: 12px 20px;
			display: flex;
			align-items: center;
			transition: all 0.3s;
			border-left: 3px solid transparent;
		}

		.sidebar-menu .nav-link:hover,
		.sidebar-menu .nav-link.active {
			color: white;
			background: rgba(255, 255, 255, 0.1);
			border-left-color: white;
		}

		.sidebar-menu .nav-link i {
			margin-right: 10px;
			font-size: 1.1em;
		}

		.sidebar-menu .menu-header {
			color: rgba(255, 255, 255, 0.5);
			font-size: 0.75em;
			text-transform: uppercase;
			letter-spacing: 1px;
			padding: 15px 20px 5px;
			margin-top: 10px;
		}

		.main-content {
			margin-left: var(--sidebar-width);
			min-height: 100vh;
		}

		.top-navbar {
			background: white;
			padding: 15px 25px;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		.page-header {
			padding: 25px;
			background: white;
			margin-bottom: 25px;
			border-bottom: 1px solid #e0e0e0;
		}

		.page-header h1 {
			font-size: 1.75em;
			margin: 0;
			color: #333;
		}

		.page-header .breadcrumb {
			margin: 5px 0 0;
			padding: 0;
			background: transparent;
		}

		.content-wrapper {
			padding: 0 25px 25px;
		}

		.card {
			border: none;
			border-radius: 10px;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
			margin-bottom: 25px;
		}

		.card-header {
			background: white;
			border-bottom: 1px solid #e0e0e0;
			padding: 15px 20px;
			font-weight: 600;
		}

		.stat-card {
			padding: 25px;
			border-radius: 10px;
			color: white;
			margin-bottom: 25px;
		}

		.stat-card.primary {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		}

		.stat-card.success {
			background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
		}

		.stat-card.warning {
			background: linear-gradient(135deg, #F2994A 0%, #F2C94C 100%);
		}

		.stat-card.danger {
			background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
		}

		.stat-card.info {
			background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
		}

		.stat-card h3 {
			font-size: 2em;
			margin: 0;
		}

		.stat-card p {
			margin: 5px 0 0;
			opacity: 0.9;
		}

		.btn-primary {
			background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
			border: none;
		}

		.btn-primary:hover {
			background: linear-gradient(135deg, #5a6fd6 0%, #6a4190 100%);
		}

		.table th {
			background: #f8f9fa;
			font-weight: 600;
			border-bottom: 2px solid #dee2e6;
		}

		.badge-status {
			padding: 5px 10px;
			border-radius: 20px;
			font-size: 0.8em;
		}

		.user-dropdown {
			display: flex;
			align-items: center;
			cursor: pointer;
		}

		.user-dropdown img {
			width: 35px;
			height: 35px;
			border-radius: 50%;
			margin-right: 10px;
		}

		@media (max-width: 768px) {
			.sidebar {
				transform: translateX(-100%);
			}

			.main-content {
				margin-left: 0;
			}
		}
	</style>
</head>

<body>
	<!-- Sidebar -->
	<div class="sidebar">
		<div class="sidebar-brand">
			<h4>🚀 CMS Admin</h4>
		</div>
		<div class="sidebar-menu">
			<a href="<?php echo base_url('dashboard'); ?>" class="nav-link <?php echo ($this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == '') ? 'active' : ''; ?>">
				<i class="bi bi-speedometer2"></i> Dashboard
			</a>

			<div class="menu-header">Content Management</div>
			<a href="<?php echo base_url('pages'); ?>" class="nav-link <?php echo $this->uri->segment(1) == 'pages' ? 'active' : ''; ?>">
				<i class="bi bi-file-earmark-text"></i> Pages
			</a>
			<a href="<?php echo base_url('media'); ?>" class="nav-link <?php echo $this->uri->segment(1) == 'media' ? 'active' : ''; ?>">
				<i class="bi bi-images"></i> Media Library
			</a>
			<a href="<?php echo base_url('menus'); ?>" class="nav-link <?php echo $this->uri->segment(1) == 'menus' ? 'active' : ''; ?>">
				<i class="bi bi-list"></i> Menus
			</a>

			<div class="menu-header">User Management</div>
			<a href="<?php echo base_url('users'); ?>" class="nav-link <?php echo $this->uri->segment(1) == 'users' ? 'active' : ''; ?>">
				<i class="bi bi-people"></i> Users
			</a>
			<a href="<?php echo base_url('roles'); ?>" class="nav-link <?php echo $this->uri->segment(1) == 'roles' ? 'active' : ''; ?>">
				<i class="bi bi-shield-check"></i> Roles
			</a>
			<a href="<?php echo base_url('permissions'); ?>" class="nav-link <?php echo $this->uri->segment(1) == 'permissions' ? 'active' : ''; ?>">
				<i class="bi bi-key"></i> Permissions
			</a>

			<div class="menu-header">System</div>
			<a href="<?php echo base_url('logs'); ?>" class="nav-link <?php echo $this->uri->segment(1) == 'logs' ? 'active' : ''; ?>">
				<i class="bi bi-journal-text"></i> Activity Logs
			</a>
			<a href="<?php echo base_url('settings'); ?>" class="nav-link <?php echo $this->uri->segment(1) == 'settings' ? 'active' : ''; ?>">
				<i class="bi bi-gear"></i> Settings
			</a>
		</div>
	</div>

	<!-- Main Content -->
	<div class="main-content">
		<!-- Top Navbar -->
		<div class="top-navbar">
			<div>
				<button class="btn btn-sm btn-outline-secondary d-md-none" id="sidebarToggle">
					<i class="bi bi-list"></i>
				</button>
			</div>
			<div class="dropdown">
				<div class="user-dropdown" data-bs-toggle="dropdown">
					<img src="https://ui-avatars.com/api/?name=<?php echo urlencode($this->session->userdata('username') ?? 'Admin'); ?>&background=667eea&color=fff" alt="User">
					<span><?php echo $this->session->userdata('username') ?? 'Admin'; ?></span>
					<i class="bi bi-chevron-down ms-2"></i>
				</div>
				<ul class="dropdown-menu dropdown-menu-end">
					<li><a class="dropdown-item" href="<?php echo base_url('profile'); ?>"><i class="bi bi-person me-2"></i>Profile</a></li>
					<li><a class="dropdown-item" href="<?php echo base_url('auth/change-password'); ?>"><i class="bi bi-key me-2"></i>Change Password</a></li>
					<li>
						<hr class="dropdown-divider">
					</li>
					<li><a class="dropdown-item text-danger" href="<?php echo base_url('auth/logout'); ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
				</ul>
			</div>
		</div>