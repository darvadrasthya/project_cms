<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
	<div class="d-flex justify-content-between align-items-center">
		<div>
			<h1>Pages</h1>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
					<li class="breadcrumb-item active">Pages</li>
				</ol>
			</nav>
		</div>
		<a href="<?php echo base_url('pages/create'); ?>" class="btn btn-primary">
			<i class="bi bi-plus-lg"></i> Add Page
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

	<?php if ($this->session->flashdata('error')) : ?>
		<div class="alert alert-danger alert-dismissible fade show">
			<?php echo $this->session->flashdata('error'); ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
		</div>
	<?php endif; ?>

	<div class="card">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Title</th>
							<th>Slug</th>
							<th>Author</th>
							<th>Status</th>
							<th>Created</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php if (isset($pages) && !empty($pages)) : ?>
							<?php $no = 1;
							foreach ($pages as $page) : ?>
								<tr>
									<td><?php echo $no++; ?></td>
									<td>
										<strong><?php echo htmlspecialchars($page['title']); ?></strong>
										<?php if (!empty($page['meta_title'])) : ?>
											<br><small class="text-muted"><?php echo htmlspecialchars($page['meta_title']); ?></small>
										<?php endif; ?>
									</td>
									<td><code><?php echo htmlspecialchars($page['slug']); ?></code></td>
									<td><?php echo htmlspecialchars($page['author_name'] ?? 'Unknown'); ?></td>
									<td>
										<?php if ($page['status'] == 'published') : ?>
											<span class="badge bg-success">Published</span>
										<?php elseif ($page['status'] == 'draft') : ?>
											<span class="badge bg-warning">Draft</span>
										<?php else : ?>
											<span class="badge bg-danger">Archived</span>
										<?php endif; ?>
									</td>
									<td><?php echo date('d M Y', strtotime($page['created_at'])); ?></td>
									<td>
										<div class="btn-group">
											<a href="<?php echo base_url('pages/view/' . $page['page_id']); ?>" class="btn btn-sm btn-outline-info" title="View">
												<i class="bi bi-eye"></i>
											</a>
											<a href="<?php echo base_url('pages/edit/' . $page['page_id']); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
												<i class="bi bi-pencil"></i>
											</a>
											<?php if ($page['status'] != 'published') : ?>
												<a href="<?php echo base_url('pages/publish/' . $page['page_id']); ?>" class="btn btn-sm btn-outline-success" title="Publish">
													<i class="bi bi-check-circle"></i>
												</a>
											<?php else : ?>
												<a href="<?php echo base_url('pages/unpublish/' . $page['page_id']); ?>" class="btn btn-sm btn-outline-warning" title="Unpublish">
													<i class="bi bi-x-circle"></i>
												</a>
											<?php endif; ?>
											<a href="<?php echo base_url('pages/delete/' . $page['page_id']); ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this page?')">
												<i class="bi bi-trash"></i>
											</a>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else : ?>
							<tr>
								<td colspan="7" class="text-center text-muted py-4">
									<i class="bi bi-file-earmark-x" style="font-size: 3em;"></i>
									<p class="mt-2">No pages found</p>
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>