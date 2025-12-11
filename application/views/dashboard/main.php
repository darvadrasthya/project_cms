<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
	<h1>Dashboard</h1>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item active">Dashboard</li>
		</ol>
	</nav>
</div>

<div class="content-wrapper">
	<!-- Stats Cards -->
	<div class="row">
		<div class="col-md-3">
			<div class="stat-card primary">
				<h3><?php echo isset($stats['total_users']) ? $stats['total_users'] : 0; ?></h3>
				<p><i class="bi bi-people"></i> Total Users</p>
			</div>
		</div>
		<div class="col-md-3">
			<div class="stat-card success">
				<h3><?php echo isset($stats['total_pages']) ? $stats['total_pages'] : 0; ?></h3>
				<p><i class="bi bi-file-earmark-text"></i> Total Pages</p>
			</div>
		</div>
		<div class="col-md-3">
			<div class="stat-card warning">
				<h3><?php echo isset($stats['total_media']) ? $stats['total_media'] : 0; ?></h3>
				<p><i class="bi bi-images"></i> Media Files</p>
			</div>
		</div>
		<div class="col-md-3">
			<div class="stat-card info">
				<h3><?php echo isset($stats['total_visits']) ? $stats['total_visits'] : 0; ?></h3>
				<p><i class="bi bi-graph-up"></i> Total Visits</p>
			</div>
		</div>
	</div>

	<div class="row">
		<!-- Recent Users -->
		<div class="col-md-6">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<span>Recent Users</span>
					<a href="<?php echo base_url('users'); ?>" class="btn btn-sm btn-primary">View All</a>
				</div>
				<div class="card-body p-0">
					<table class="table table-hover mb-0">
						<thead>
							<tr>
								<th>Username</th>
								<th>Email</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php if (isset($recent_users) && !empty($recent_users)) : ?>
								<?php foreach ($recent_users as $user) : ?>
									<tr>
										<td><?php echo htmlspecialchars($user['username']); ?></td>
										<td><?php echo htmlspecialchars($user['email']); ?></td>
										<td>
											<?php if ($user['is_active']) : ?>
												<span class="badge bg-success">Active</span>
											<?php else : ?>
												<span class="badge bg-danger">Inactive</span>
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php else : ?>
								<tr>
									<td colspan="3" class="text-center text-muted">No users found</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<!-- Recent Pages -->
		<div class="col-md-6">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<span>Recent Pages</span>
					<a href="<?php echo base_url('pages'); ?>" class="btn btn-sm btn-primary">View All</a>
				</div>
				<div class="card-body p-0">
					<table class="table table-hover mb-0">
						<thead>
							<tr>
								<th>Title</th>
								<th>Author</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php if (isset($recent_pages) && !empty($recent_pages)) : ?>
								<?php foreach ($recent_pages as $page) : ?>
									<tr>
										<td><?php echo htmlspecialchars($page['title']); ?></td>
										<td><?php echo htmlspecialchars($page['author_name'] ?? 'Unknown'); ?></td>
										<td>
											<?php if ($page['status'] == 'published') : ?>
												<span class="badge bg-success">Published</span>
											<?php else : ?>
												<span class="badge bg-warning">Draft</span>
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php else : ?>
								<tr>
									<td colspan="3" class="text-center text-muted">No pages found</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<!-- Recent Activity -->
	<div class="card">
		<div class="card-header d-flex justify-content-between align-items-center">
			<span>Recent Activity</span>
			<a href="<?php echo base_url('logs'); ?>" class="btn btn-sm btn-primary">View All</a>
		</div>
		<div class="card-body p-0">
			<table class="table table-hover mb-0">
				<thead>
					<tr>
						<th>User</th>
						<th>Action</th>
						<th>IP Address</th>
						<th>Time</th>
					</tr>
				</thead>
				<tbody>
					<?php if (isset($recent_logs) && !empty($recent_logs)) : ?>
						<?php foreach ($recent_logs as $log) : ?>
							<tr>
								<td><?php echo htmlspecialchars($log['username'] ?? 'System'); ?></td>
								<td><?php echo htmlspecialchars($log['action']); ?></td>
								<td><code><?php echo htmlspecialchars($log['ip_address']); ?></code></td>
								<td><?php echo date('d M Y H:i', strtotime($log['created_at'])); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr>
							<td colspan="4" class="text-center text-muted">No activity found</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>