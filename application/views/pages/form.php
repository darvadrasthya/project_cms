<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
	<h1><?php echo isset($page) ? 'Edit Page' : 'Create Page'; ?></h1>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
			<li class="breadcrumb-item"><a href="<?php echo base_url('pages'); ?>">Pages</a></li>
			<li class="breadcrumb-item active"><?php echo isset($page) ? 'Edit' : 'Create'; ?></li>
		</ol>
	</nav>
</div>

<div class="content-wrapper">
	<?php if ($this->session->flashdata('error')) : ?>
		<div class="alert alert-danger alert-dismissible fade show">
			<?php echo $this->session->flashdata('error'); ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
		</div>
	<?php endif; ?>

	<form action="<?php echo isset($page) ? base_url('pages/update/' . $page['page_id']) : base_url('pages/store'); ?>" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">Page Content</div>
					<div class="card-body">
						<div class="mb-3">
							<label class="form-label">Title <span class="text-danger">*</span></label>
							<input type="text" name="title" id="title" class="form-control" value="<?php echo isset($page) ? htmlspecialchars($page['title']) : set_value('title'); ?>" required>
						</div>

						<div class="mb-3">
							<label class="form-label">Slug</label>
							<input type="text" name="slug" id="slug" class="form-control" value="<?php echo isset($page) ? htmlspecialchars($page['slug']) : set_value('slug'); ?>">
							<small class="text-muted">Leave empty to auto-generate from title</small>
						</div>

						<div class="mb-3">
							<label class="form-label">Content <span class="text-danger">*</span></label>
							<textarea name="content" id="content" class="form-control" rows="15" required><?php echo isset($page) ? htmlspecialchars($page['content']) : set_value('content'); ?></textarea>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-header">SEO Settings</div>
					<div class="card-body">
						<div class="mb-3">
							<label class="form-label">Meta Title</label>
							<input type="text" name="meta_title" class="form-control" value="<?php echo isset($page) ? htmlspecialchars($page['meta_title'] ?? '') : set_value('meta_title'); ?>">
						</div>
						<div class="mb-3">
							<label class="form-label">Meta Description</label>
							<textarea name="meta_description" class="form-control" rows="3"><?php echo isset($page) ? htmlspecialchars($page['meta_description'] ?? '') : set_value('meta_description'); ?></textarea>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="card">
					<div class="card-header">Publish</div>
					<div class="card-body">
						<div class="mb-3">
							<label class="form-label">Status</label>
							<select name="status" class="form-select">
								<option value="draft" <?php echo (isset($page) && $page['status'] == 'draft') ? 'selected' : ''; ?>>Draft</option>
								<option value="published" <?php echo (isset($page) && $page['status'] == 'published') ? 'selected' : ''; ?>>Published</option>
								<option value="archived" <?php echo (isset($page) && $page['status'] == 'archived') ? 'selected' : ''; ?>>Archived</option>
							</select>
						</div>

						<div class="d-grid gap-2">
							<button type="submit" class="btn btn-primary">
								<i class="bi bi-check-lg"></i> <?php echo isset($page) ? 'Update' : 'Save'; ?> Page
							</button>
							<a href="<?php echo base_url('pages'); ?>" class="btn btn-secondary">
								<i class="bi bi-arrow-left"></i> Back to List
							</a>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-header">Featured Image</div>
					<div class="card-body">
						<?php if (isset($page) && !empty($page['featured_image'])) : ?>
							<img src="<?php echo base_url($page['featured_image']); ?>" class="img-fluid mb-3 rounded" alt="">
						<?php endif; ?>
						<input type="file" name="featured_image" class="form-control" accept="image/*">
						<small class="text-muted">Recommended: 1200x630px</small>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script>
	// Auto generate slug from title
	document.getElementById('title').addEventListener('blur', function() {
		var slug = document.getElementById('slug');
		if (!slug.value) {
			slug.value = this.value.toLowerCase()
				.replace(/[^a-z0-9\s-]/g, '')
				.replace(/\s+/g, '-')
				.replace(/-+/g, '-');
		}
	});
</script>

<?php $this->load->view('templates/admin_footer'); ?>