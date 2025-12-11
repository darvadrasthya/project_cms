<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
	<div class="d-flex justify-content-between align-items-center">
		<div>
			<h1>Permissions</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
					<li class="breadcrumb-item active">Permissions</li>
				</ol>
			</nav>
		</div>
		<a href="<?php echo base_url('permissions/create'); ?>" class="btn btn-primary">
			<i class="bi bi-plus-lg"></i> Add Permission
		</a>
	</div>
</div>

<div class="content-wrapper">
	<?php if ($this->session->flashdata('success')) : ?>
		<div class="alert alert-success alert-dismissible fade show">
			<?php echo $this->session->flashdata('success'); ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
		</div>
	<?php endif; ?>

	<div class="card">
		<div class="card-body">
			<?php
			$grouped = [];
			if (isset($permissions)) {
				foreach ($permissions as $perm) {
					$group = explode('.', $perm['permission_desc'])[0] ?? 'other';
					$grouped[$group][] = $perm;
				}
			}
			?>

			<div class="row">
				<?php foreach ($grouped as $group => $perms) : ?>
					<div class="col-md-4 mb-4">
						<div class="card">
							<div class="card-header bg-light">
								<strong class="text-capitalize"><?php echo ucfirst($group); ?></strong>
								<span class="badge bg-primary float-end"><?php echo count($perms); ?></span>
							</div>
							<ul class="list-group list-group-flush">
								<?php foreach ($perms as $perm) : ?>
									<li class="list-group-item d-flex justify-content-between align-items-center">
										<div>
											<code><?php echo htmlspecialchars($perm['permission_desc']); ?></code>
											<?php if (!empty($perm['description'])) : ?>
												<br><small class="text-muted"><?php echo htmlspecialchars($perm['description']); ?></small>
											<?php endif; ?>
										</div>
										<div class="btn-group">
											<a href="<?php echo base_url('permissions/edit/' . $perm['permission_id']); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
												<i class="bi bi-pencil"></i>
											</a>
											<a href="<?php echo base_url('permissions/delete/' . $perm['permission_id']); ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')">
												<i class="bi bi-trash"></i>
											</a>
										</div>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if (empty($grouped)) : ?>
				<div class="text-center py-5">
					<i class="bi bi-key text-muted" style="font-size: 3em;"></i>
					<p class="mt-2 text-muted">No permissions found</p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>