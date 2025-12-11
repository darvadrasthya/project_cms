<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= isset($title) ? $title . ' - ' : '' ?>CMS System</title>

	<!-- Bootstrap CSS -->
	<link href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="<?= base_url('assets/plugins/fontawesome/css/all.min.css') ?>" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="<?= base_url('assets/css/style.min.css') ?>" rel="stylesheet">

	<style>
		.sidebar {
			position: fixed;
			top: 0;
			bottom: 0;
			left: 0;
			z-index: 100;
			width: 260px;
			background: #2c3e50;
			color: white;
			overflow-y: auto;
		}

		.sidebar-header {
			padding: 1.5rem;
			border-bottom: 1px solid rgba(255, 255, 255, 0.1);
		}

		.sidebar-menu {
			padding: 1rem 0;
		}

		.sidebar-menu .nav-link {
			color: rgba(255, 255, 255, 0.8);
			padding: 0.75rem 1.5rem;
			transition: all 0.3s;
		}

		.sidebar-menu .nav-link:hover,
		.sidebar-menu .nav-link.active {
			background: rgba(255, 255, 255, 0.1);
			color: white;
		}

		.main-content {
			margin-left: 260px;
			padding: 2rem;
		}

		.topbar {
			background: white;
			padding: 1rem 2rem;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
			margin-bottom: 2rem;
		}

		.stat-card {
			background: white;
			border-radius: 8px;
			padding: 1.5rem;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
			margin-bottom: 1.5rem;
		}

		.stat-card h3 {
			font-size: 2rem;
			font-weight: 700;
			margin-bottom: 0.5rem;
		}

		.stat-card p {
			color: #6c757d;
			margin-bottom: 0;
		}
	</style>
</head>

<body>
	<!-- Sidebar -->
	<div class="sidebar">
		<div class="sidebar-header">
			<h4 class="mb-0">CMS System</h4>
		</div>

		<nav class="sidebar-menu">
			<ul class="nav flex-column">
				<li class="nav-item">
					<a class="nav-link <?= $this->uri->segment(1) == 'dashboard' ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>">
						<i class="fas fa-home me-2"></i> Dashboard
					</a>
				</li>

				<?php if ($this->authorization->has_permission('page.read')) : ?>
					<li class="nav-item">
						<a class="nav-link <?= $this->uri->segment(1) == 'pages' ? 'active' : '' ?>" href="<?= site_url('pages') ?>">
							<i class="fas fa-file-alt me-2"></i> Pages
						</a>
					</li>
				<?php endif; ?>

				<?php if ($this->authorization->has_permission('media.upload')) : ?>
					<li class="nav-item">
						<a class="nav-link <?= $this->uri->segment(1) == 'media' ? 'active' : '' ?>" href="<?= site_url('media') ?>">
							<i class="fas fa-images me-2"></i> Media
						</a>
					</li>
				<?php endif; ?>

				<?php if ($this->authorization->has_permission('user.read')) : ?>
					<li class="nav-item">
						<a class="nav-link <?= $this->uri->segment(1) == 'users' ? 'active' : '' ?>" href="<?= site_url('users') ?>">
							<i class="fas fa-users me-2"></i> Users
						</a>
					</li>
				<?php endif; ?>

				<?php if ($this->authorization->has_permission('role.manage')) : ?>
					<li class="nav-item">
						<a class="nav-link <?= $this->uri->segment(1) == 'roles' ? 'active' : '' ?>" href="<?= site_url('roles') ?>">
							<i class="fas fa-user-shield me-2"></i> Roles & Permissions
						</a>
					</li>
				<?php endif; ?>

				<?php if ($this->authorization->has_permission('audit.view')) : ?>
					<li class="nav-item">
						<a class="nav-link <?= $this->uri->segment(1) == 'logs' ? 'active' : '' ?>" href="<?= site_url('logs') ?>">
							<i class="fas fa-clipboard-list me-2"></i> Logs
						</a>
					</li>
				<?php endif; ?>

				<li class="nav-item">
					<a class="nav-link" href="<?= site_url('auth/logout') ?>">
						<i class="fas fa-sign-out-alt me-2"></i> Logout
					</a>
				</li>
			</ul>
		</nav>
	</div>

	<!-- Main Content -->
	<div class="main-content">
		<!-- Topbar -->
		<div class="topbar">
			<div class="d-flex justify-content-between align-items-center">
				<div>
					<h4 class="mb-0"><?= isset($title) ? $title : 'Dashboard' ?></h4>
					<?php if (isset($subtitle)) : ?>
						<p class="text-muted mb-0"><small><?= $subtitle ?></small></p>
					<?php endif; ?>
				</div>
				<div>
					<span class="me-3">Welcome, <strong><?= $this->auth->user()['username'] ?></strong></span>
				</div>
			</div>
		</div>

		<!-- Flash Messages -->
		<?php if ($this->session->flashdata('success')) : ?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<?= $this->session->flashdata('success') ?>
				<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
			</div>
		<?php endif; ?>

		<?php if ($this->session->flashdata('error')) : ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<?= $this->session->flashdata('error') ?>
				<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
			</div>
		<?php endif; ?>

		<!-- Dashboard Stats -->
		<div class="row">
			<div class="col-md-3">
				<div class="stat-card">
					<i class="fas fa-users fa-2x text-primary mb-3"></i>
					<h3><?= number_format($stats['total_users']) ?></h3>
					<p>Total Users</p>
				</div>
			</div>
			<div class="col-md-3">
				<div class="stat-card">
					<i class="fas fa-file-alt fa-2x text-success mb-3"></i>
					<h3><?= number_format($stats['total_pages']) ?></h3>
					<p>Total Pages</p>
				</div>
			</div>
			<div class="col-md-3">
				<div class="stat-card">
					<i class="fas fa-check-circle fa-2x text-info mb-3"></i>
					<h3><?= number_format($stats['published_pages']) ?></h3>
					<p>Published Pages</p>
				</div>
			</div>
			<div class="col-md-3">
				<div class="stat-card">
					<i class="fas fa-images fa-2x text-warning mb-3"></i>
					<h3><?= number_format($stats['total_media']) ?></h3>
					<p>Media Files</p>
				</div>
			</div>
		</div>

		<!-- Recent Pages -->
		<div class="card mt-4">
			<div class="card-header">
				<h5 class="mb-0">Recent Pages</h5>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Title</th>
								<th>Status</th>
								<th>Created By</th>
								<th>Created At</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($recent_pages)) : ?>
								<?php foreach ($recent_pages as $page) : ?>
									<tr>
										<td><?= htmlspecialchars($page['title']) ?></td>
										<td>
											<span class="badge bg-<?= $page['status'] == 'published' ? 'success' : 'warning' ?>">
												<?= ucfirst($page['status']) ?>
											</span>
										</td>
										<td><?= htmlspecialchars($page['created_by_name']) ?></td>
										<td><?= date('M d, Y', strtotime($page['created_at'])) ?></td>
										<td>
											<a href="<?= site_url('pages/view/' . $page['page_id']) ?>" class="btn btn-sm btn-info">
												<i class="fas fa-eye"></i>
											</a>
											<a href="<?= site_url('pages/edit/' . $page['page_id']) ?>" class="btn btn-sm btn-warning">
												<i class="fas fa-edit"></i>
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php else : ?>
								<tr>
									<td colspan="5" class="text-center">No pages found</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap JS -->
	<script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
	<script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
</body>

</html>