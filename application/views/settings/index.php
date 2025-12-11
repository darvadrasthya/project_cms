<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
	<h1>Settings</h1>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
			<li class="breadcrumb-item active">Settings</li>
		</ol>
	</nav>
</div>

<div class="content-wrapper">
	<?php if ($this->session->flashdata('success')) : ?>
		<div class="alert alert-success alert-dismissible fade show">
			<?php echo $this->session->flashdata('success'); ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
		</div>
	<?php endif; ?>

	<form action="<?php echo base_url('settings/update'); ?>" method="post">
		<div class="row">
			<!-- General Settings -->
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<i class="bi bi-gear me-2"></i>General Settings
					</div>
					<div class="card-body">
						<div class="mb-3">
							<label class="form-label">Site Name</label>
							<input type="text" name="site_name" class="form-control" value="<?php echo isset($settings['site_name']) ? htmlspecialchars($settings['site_name']) : ''; ?>">
						</div>
						<div class="mb-3">
							<label class="form-label">Site Description</label>
							<textarea name="site_description" class="form-control" rows="3"><?php echo isset($settings['site_description']) ? htmlspecialchars($settings['site_description']) : ''; ?></textarea>
						</div>
						<div class="mb-3">
							<label class="form-label">Admin Email</label>
							<input type="email" name="admin_email" class="form-control" value="<?php echo isset($settings['admin_email']) ? htmlspecialchars($settings['admin_email']) : ''; ?>">
						</div>
					</div>
				</div>
			</div>

			<!-- Security Settings -->
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<i class="bi bi-shield-check me-2"></i>Security Settings
					</div>
					<div class="card-body">
						<div class="mb-3">
							<label class="form-label">Max Login Attempts</label>
							<input type="number" name="max_login_attempts" class="form-control" value="<?php echo isset($settings['max_login_attempts']) ? $settings['max_login_attempts'] : 5; ?>">
						</div>
						<div class="mb-3">
							<label class="form-label">Lockout Duration (minutes)</label>
							<input type="number" name="lockout_duration" class="form-control" value="<?php echo isset($settings['lockout_duration']) ? $settings['lockout_duration'] : 15; ?>">
						</div>
						<div class="mb-3">
							<label class="form-label">Session Lifetime (minutes)</label>
							<input type="number" name="session_lifetime" class="form-control" value="<?php echo isset($settings['session_lifetime']) ? $settings['session_lifetime'] : 120; ?>">
						</div>
					</div>
				</div>
			</div>

			<!-- Upload Settings -->
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<i class="bi bi-upload me-2"></i>Upload Settings
					</div>
					<div class="card-body">
						<div class="mb-3">
							<label class="form-label">Max Upload Size (MB)</label>
							<input type="number" name="max_upload_size" class="form-control" value="<?php echo isset($settings['max_upload_size']) ? $settings['max_upload_size'] : 5; ?>">
						</div>
						<div class="mb-3">
							<label class="form-label">Allowed File Types</label>
							<input type="text" name="allowed_file_types" class="form-control" value="<?php echo isset($settings['allowed_file_types']) ? htmlspecialchars($settings['allowed_file_types']) : 'jpg,jpeg,png,gif,pdf,doc,docx'; ?>">
							<small class="text-muted">Comma separated extensions</small>
						</div>
					</div>
				</div>
			</div>

			<!-- Maintenance Settings -->
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<i class="bi bi-tools me-2"></i>Maintenance
					</div>
					<div class="card-body">
						<div class="mb-3">
							<div class="form-check form-switch">
								<input type="checkbox" class="form-check-input" name="maintenance_mode" value="1" id="maintenance_mode" <?php echo (isset($settings['maintenance_mode']) && $settings['maintenance_mode']) ? 'checked' : ''; ?>>
								<label class="form-check-label" for="maintenance_mode">Enable Maintenance Mode</label>
							</div>
						</div>
						<div class="mb-3">
							<label class="form-label">Maintenance Message</label>
							<textarea name="maintenance_message" class="form-control" rows="3"><?php echo isset($settings['maintenance_message']) ? htmlspecialchars($settings['maintenance_message']) : 'Site is under maintenance. Please check back later.'; ?></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="text-end">
			<button type="submit" class="btn btn-primary btn-lg">
				<i class="bi bi-check-lg"></i> Save Settings
			</button>
		</div>
	</form>
</div>

<?php $this->load->view('templates/admin_footer'); ?>