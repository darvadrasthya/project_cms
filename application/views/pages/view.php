<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><?php echo htmlspecialchars($page['title']); ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('pages'); ?>">Pages</a></li>
                    <li class="breadcrumb-item active">View</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="<?php echo base_url('pages/edit/' . $page['page_id']); ?>" class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
            <a href="<?php echo base_url('pages'); ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>
</div>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-file-text me-2"></i>Page Content
                </div>
                <div class="card-body">
                    <?php if (!empty($page['featured_image_path'])) : ?>
                        <div class="mb-4">
                            <img src="<?php echo base_url($page['featured_image_path']); ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($page['title']); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="page-content">
                        <?php echo $page['content']; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>Page Information
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Status</th>
                            <td>
                                <?php if ($page['status'] == 'published') : ?>
                                    <span class="badge bg-success">Published</span>
                                <?php elseif ($page['status'] == 'draft') : ?>
                                    <span class="badge bg-warning">Draft</span>
                                <?php else : ?>
                                    <span class="badge bg-secondary"><?php echo ucfirst($page['status']); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Slug</th>
                            <td><code><?php echo htmlspecialchars($page['slug']); ?></code></td>
                        </tr>
                        <tr>
                            <th>Created By</th>
                            <td><?php echo htmlspecialchars($page['created_by_name'] ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <th>Created</th>
                            <td><?php echo date('d M Y H:i', strtotime($page['created_at'])); ?></td>
                        </tr>
                        <?php if (!empty($page['updated_at'])) : ?>
                            <tr>
                                <th>Updated</th>
                                <td><?php echo date('d M Y H:i', strtotime($page['updated_at'])); ?></td>
                            </tr>
                            <?php if (!empty($page['updated_by_name'])) : ?>
                                <tr>
                                    <th>Updated By</th>
                                    <td><?php echo htmlspecialchars($page['updated_by_name']); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                    </table>
                </div>
            </div>

            <?php if (!empty($page['meta_title']) || !empty($page['meta_description'])) : ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="bi bi-search me-2"></i>SEO Information
                    </div>
                    <div class="card-body">
                        <?php if (!empty($page['meta_title'])) : ?>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Meta Title</label>
                                <p class="mb-0"><?php echo htmlspecialchars($page['meta_title']); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($page['meta_description'])) : ?>
                            <div class="mb-0">
                                <label class="form-label fw-bold">Meta Description</label>
                                <p class="mb-0"><?php echo htmlspecialchars($page['meta_description']); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-lightning me-2"></i>Quick Actions
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <?php if ($page['status'] == 'draft') : ?>
                            <button type="button" class="btn btn-success btn-publish" data-id="<?php echo $page['page_id']; ?>">
                                <i class="bi bi-check-circle me-1"></i> Publish Page
                            </button>
                        <?php else : ?>
                            <button type="button" class="btn btn-warning btn-unpublish" data-id="<?php echo $page['page_id']; ?>">
                                <i class="bi bi-x-circle me-1"></i> Unpublish Page
                            </button>
                        <?php endif; ?>

                        <?php if ($page['status'] == 'published') : ?>
                            <a href="<?php echo base_url('page/' . $page['slug']); ?>" class="btn btn-outline-primary" target="_blank">
                                <i class="bi bi-box-arrow-up-right me-1"></i> View Live Page
                            </a>
                        <?php endif; ?>

                        <button type="button" class="btn btn-outline-danger btn-delete" data-id="<?php echo $page['page_id']; ?>">
                            <i class="bi bi-trash me-1"></i> Delete Page
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Publish page
        document.querySelectorAll('.btn-publish').forEach(function(btn) {
            btn.addEventListener('click', function() {
                if (confirm('Are you sure you want to publish this page?')) {
                    fetch('<?php echo base_url('pages/publish/'); ?>' + this.dataset.id, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert(data.message);
                            }
                        });
                }
            });
        });

        // Unpublish page
        document.querySelectorAll('.btn-unpublish').forEach(function(btn) {
            btn.addEventListener('click', function() {
                if (confirm('Are you sure you want to unpublish this page?')) {
                    fetch('<?php echo base_url('pages/unpublish/'); ?>' + this.dataset.id, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert(data.message);
                            }
                        });
                }
            });
        });

        // Delete page
        document.querySelectorAll('.btn-delete').forEach(function(btn) {
            btn.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this page? This action cannot be undone.')) {
                    fetch('<?php echo base_url('pages/delete/'); ?>' + this.dataset.id, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.href = '<?php echo base_url('pages'); ?>';
                            } else {
                                alert(data.message);
                            }
                        });
                }
            });
        });
    });
</script>

<?php $this->load->view('templates/admin_footer'); ?>