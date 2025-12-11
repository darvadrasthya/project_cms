<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
    <h1>Create Page</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('pages'); ?>">Pages</a></li>
            <li class="breadcrumb-item active">Create</li>
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

    <?php if (validation_errors()) : ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?php echo validation_errors(); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form action="<?php echo base_url('pages/create'); ?>" method="post">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="bi bi-file-text me-2"></i>Page Content
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" value="<?php echo set_value('title'); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea name="content" id="content" class="form-control" rows="15" required><?php echo set_value('content'); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="bi bi-search me-2"></i>SEO Settings
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="<?php echo set_value('meta_title'); ?>">
                            <small class="text-muted">Leave empty to use page title</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3"><?php echo set_value('meta_description'); ?></textarea>
                            <small class="text-muted">Brief description for search engines (max 160 characters)</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="bi bi-gear me-2"></i>Publish Settings
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="draft" <?php echo set_select('status', 'draft', true); ?>>Draft</option>
                                <option value="published" <?php echo set_select('status', 'published'); ?>>Published</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i> Create Page
                            </button>
                            <a href="<?php echo base_url('pages'); ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="bi bi-image me-2"></i>Featured Image
                    </div>
                    <div class="card-body">
                        <div id="featured-image-preview" class="mb-3 text-center" style="display: none;">
                            <img src="" class="img-fluid rounded" alt="Featured Image Preview">
                        </div>

                        <?php if (!empty($media)) : ?>
                            <div class="mb-3">
                                <label class="form-label">Select from Media Library</label>
                                <select name="featured_image" class="form-select">
                                    <option value="">-- No Image --</option>
                                    <?php foreach ($media as $item) : ?>
                                        <option value="<?php echo $item['media_id']; ?>"><?php echo htmlspecialchars($item['file_name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php else : ?>
                            <input type="hidden" name="featured_image" value="">
                            <p class="text-muted mb-0">No images available in media library.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?php $this->load->view('templates/admin_footer'); ?>