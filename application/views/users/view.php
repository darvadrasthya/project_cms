<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
	<h1>User Details</h1>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
			<li class="breadcrumb-item"><a href="<?php echo base_url('users'); ?>">Users</a></li>
			<li class="breadcrumb-item active"><?php echo htmlspecialchars($user['username']); ?></li>
		</ol>
	</nav>
</div>

<div class="content-wrapper">
	<div class="row">
		<div class="col-md-4">
			<div class="card">
				<div class="card-body text-center">
					<img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['username']); ?>&size=150&background=667eea&color=fff" class="rounded-circle mb-3" alt="">
					<h4><?php echo htmlspecialchars($user['username']); ?></h4>
					<p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>

					<?php if ($user['is_active']) : ?>
						<span class="badge bg-success">Active</span>
					<?php else : ?>
						<span class="badge bg-danger">Inactive</span>
					<?php endif; ?>

					<?php if (isset($user['is_locked']) && $user['is_locked']) : ?>
						<span class="badge bg-warning">Locked</span>
					<?php endif; ?>

					<hr>

					<div class="d-grid gap-2">
						<a href="<?php echo base_url('users/edit/' . $user['user_id']); ?>" class="btn btn-primary">
							<i class="bi bi-pencil"></i> Edit User
						</a>
						<a href="<?php echo base_url('users'); ?>" class="btn btn-secondary">
							<i class="bi bi-arrow-left"></i> Back to List
						</a>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-8">
			<div class="card">
				<div class="card-header">User Information</div>
				<div class="card-body">
					<table class="table">
						<tr>
							<th width="30%">User ID</th>
							<td><?php echo $user['user_id']; ?></td>
						</tr>
						<tr>
							<th>Full Name</th>
							<td><?php echo htmlspecialchars($user['full_name'] ?? '-'); ?></td>
						</tr>
						<tr>
							<th>Email</th>
							<td><?php echo htmlspecialchars($user['email']); ?></td>
						</tr>
						<tr>
							<th>Phone</th>
							<td><?php echo htmlspecialchars($user['phone'] ?? '-'); ?></td>
						</tr>
						<tr>
							<th>Created At</th>
							<td><?php echo date('d M Y H:i', strtotime($user['created_at'])); ?></td>
						</tr>
						<tr>
							<th>Last Login</th>
							<td><?php echo isset($user['last_login']) ? date('d M Y H:i', strtotime($user['last_login'])) : 'Never'; ?></td>
						</tr>
					</table>
				</div>
			</div>

			<div class="card">
				<div class="card-header">Roles</div>
				<div class="card-body">
					<?php if (isset($roles) && !empty($roles)) : ?>
						<?php foreach ($roles as $role) : ?>
							<span class="badge bg-primary me-1 mb-1" style="font-size: 0.9em;">
								<?php echo htmlspecialchars($role['role_name']); ?>
							</span>
						<?php endforeach; ?>
					<?php else : ?>
						<span class="text-muted">No roles assigned</span>
					<?php endif; ?>
				</div>
			</div>

			<div class="card">
				<div class="card-header">Permissions</div>
				<div class="card-body">
					<?php if (isset($permissions) && !empty($permissions)) : ?>
						<?php foreach ($permissions as $perm) : ?>
							<span class="badge bg-secondary me-1 mb-1">
								<?php echo htmlspecialchars($perm['permission_desc']); ?>
							</span>
						<?php endforeach; ?>
					<?php else : ?>
						<span class="text-muted">No direct permissions</span>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
