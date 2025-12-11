<?php
// Get authorization instance
$CI =& get_instance();
if (!isset($CI->authorization)) {
	$CI->load->library('MY_Authorization', null, 'authorization');
}
$auth = $CI->authorization;
?>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
	<div class="position-sticky pt-3 sidebar-sticky">
		<ul class="nav flex-column">
			<li class="nav-item">
				<a class="nav-link text-white <?= uri_string() == 'dashboard' ? 'active bg-primary' : '' ?>" href="<?= site_url('dashboard') ?>">
					<i class="bi bi-speedometer2 me-2"></i>
					Dashboard
				</a>
			</li>
		</ul>

		<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
			<span>Content Management</span>
		</h6>
		<ul class="nav flex-column">
			<?php if($auth->has_permission('page.read')): ?>
			<li class="nav-item">
				<a class="nav-link text-white <?= strpos(uri_string(), 'pages') === 0 ? 'active bg-primary' : '' ?>" href="<?= site_url('pages') ?>">
					<i class="bi bi-file-earmark me-2"></i>
					Pages
				</a>
			</li>
			<?php endif; ?>
			<?php if($auth->has_permission('media.upload')): ?>
			<li class="nav-item">
				<a class="nav-link text-white <?= strpos(uri_string(), 'media') === 0 ? 'active bg-primary' : '' ?>" href="<?= site_url('media') ?>">
					<i class="bi bi-images me-2"></i>
					Media
				</a>
			</li>
			<?php endif; ?>
			<?php if($auth->has_permission('menu.manage')): ?>
			<li class="nav-item">
				<a class="nav-link text-white <?= strpos(uri_string(), 'menus') === 0 ? 'active bg-primary' : '' ?>" href="<?= site_url('menus') ?>">
					<i class="bi bi-list me-2"></i>
					Menus
				</a>
			</li>
			<?php endif; ?>
		</ul>

		<?php if($auth->has_permission('user.read')): ?>
		<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
			<span>User Management</span>
		</h6>
		<ul class="nav flex-column">
			<li class="nav-item">
				<a class="nav-link text-white <?= strpos(uri_string(), 'users') === 0 ? 'active bg-primary' : '' ?>" href="<?= site_url('users') ?>">
					<i class="bi bi-people me-2"></i>
					Users
				</a>
			</li>
			<?php if($auth->has_permission('role.manage')): ?>
			<li class="nav-item">
				<a class="nav-link text-white <?= strpos(uri_string(), 'roles') === 0 ? 'active bg-primary' : '' ?>" href="<?= site_url('roles') ?>">
					<i class="bi bi-shield-check me-2"></i>
					Roles
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-white <?= strpos(uri_string(), 'permissions') === 0 ? 'active bg-primary' : '' ?>" href="<?= site_url('permissions') ?>">
					<i class="bi bi-key me-2"></i>
					Permissions
				</a>
			</li>
			<?php endif; ?>
		</ul>
		<?php endif; ?>

		<?php if($auth->has_permission('audit.view') || $auth->has_permission('config.manage')): ?>
		<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
			<span>System</span>
		</h6>
		<ul class="nav flex-column mb-5">
			<?php if($auth->has_permission('audit.view')): ?>
			<li class="nav-item">
				<a class="nav-link text-white <?= strpos(uri_string(), 'logs') === 0 ? 'active bg-primary' : '' ?>" href="<?= site_url('logs') ?>">
					<i class="bi bi-clock-history me-2"></i>
					Logs
				</a>
			</li>
			<?php endif; ?>
			<?php if($auth->has_permission('config.manage')): ?>
			<li class="nav-item">
				<a class="nav-link text-white <?= strpos(uri_string(), 'settings') === 0 ? 'active bg-primary' : '' ?>" href="<?= site_url('settings') ?>">
					<i class="bi bi-gear me-2"></i>
					Settings
				</a>
			</li>
			<?php endif; ?>
		</ul>
		<?php endif; ?>
	</div>
</nav>
