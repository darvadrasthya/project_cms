<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
	<h1>Create User</h1>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
			<li class="breadcrumb-item"><a href="<?php echo base_url('users'); ?>">Users</a></li>
			<li class="breadcrumb-item active">Create</li>
		</ol>
	</nav>
</div>

<div class="content-wrapper">
	<?php if (validation_errors()) : ?>
		<div class="alert alert-danger">
			<?php echo validation_errors(); ?>
		</div>
	<?php endif; ?>

	<div class="card">
		<div class="card-body">
			<form action="<?php echo base_url('users/create'); ?>" method="post">
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Username <span class="text-danger">*</span></label>
							<input type="text" name="username" class="form-control" value="<?php echo set_value('username'); ?>" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Email <span class="text-danger">*</span></label>
							<input type="email" name="email" class="form-control" value="<?php echo set_value('email'); ?>" required>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Password <span class="text-danger">*</span></label>
							<input type="password" name="password" class="form-control" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="form-label">Roles</label>
							<select name="roles[]" class="form-select" multiple>
								<?php if (isset($roles)) : ?>
									<?php foreach ($roles as $role) : ?>
										<option value="<?php echo $role['role_id']; ?>">
											<?php echo htmlspecialchars($role['role_name']); ?>
										</option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</div>
					</div>
				</div>

				<div class="mb-3">
					<label class="form-label">Status</label>
					<select name="is_active" class="form-select">
						<option value="1">Active</option>
						<option value="0">Inactive</option>
					</select>
				</div>

				<hr>
				<div class="d-flex justify-content-between">
					<a href="<?php echo base_url('users'); ?>" class="btn btn-secondary">
						<i class="bi bi-arrow-left"></i> Back
					</a>
					<button type="submit" class="btn btn-primary">
						<i class="bi bi-check-lg"></i> Create User
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>