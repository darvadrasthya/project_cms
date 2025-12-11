<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Media Library</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Media</li>
                </ol>
            </nav>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
            <i class="bi bi-upload"></i> Upload File
        </button>
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
            <div class="row">
                <?php if (isset($media) && !empty($media)) : ?>
                    <?php foreach ($media as $item) : ?>
                        <div class="col-md-3 col-sm-4 col-6 mb-4">
                            <div class="card h-100">
                                <div class="position-relative" style="height: 150px; background: #f8f9fa;">
                                    <?php
                                    $ext = pathinfo($item['file_name'], PATHINFO_EXTENSION);
                                    $is_image = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                                    ?>
                                    <?php if ($is_image) : ?>
                                        <img src="<?php echo base_url($item['file_path']); ?>" class="card-img-top" style="height: 150px; object-fit: cover;" alt="<?php echo htmlspecialchars($item['file_name']); ?>">
                                    <?php else : ?>
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <i class="bi bi-file-earmark text-muted" style="font-size: 4em;"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body p-2">
                                    <p class="card-text small text-truncate mb-1" title="<?php echo htmlspecialchars($item['file_name']); ?>">
                                        <?php echo htmlspecialchars($item['file_name']); ?>
                                    </p>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            <?php echo number_format($item['file_size'] / 1024, 1); ?> KB
                                        </small>
                                    </p>
                                </div>
                                <div class="card-footer bg-white p-2">
                                    <div class="btn-group w-100">
                                        <a href="<?php echo base_url($item['file_path']); ?>" class="btn btn-sm btn-outline-info" target="_blank" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-primary copy-url" data-url="<?php echo base_url($item['file_path']); ?>" title="Copy URL">
                                            <i class="bi bi-clipboard"></i>
                                        </button>
                                        <a href="<?php echo base_url('media/delete/' . $item['media_id']); ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this file?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-images text-muted" style="font-size: 4em;"></i>
                        <p class="mt-3 text-muted">No media files found</p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            <i class="bi bi-upload"></i> Upload Your First File
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo base_url('media/upload'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select File</label>
                        <input type="file" name="file" class="form-control" required>
                        <small class="text-muted">Max size: 5MB. Allowed: jpg, jpeg, png, gif, pdf, doc, docx, xls, xlsx</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alt Text (for images)</label>
                        <input type="text" name="alt_text" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.copy-url').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var url = this.dataset.url;
            navigator.clipboard.writeText(url).then(function() {
                alert('URL copied to clipboard!');
            });
        });
    });
</script>

<?php $this->load->view('templates/admin_footer'); ?>