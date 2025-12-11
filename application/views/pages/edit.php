<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
    <h1>Edit Page</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('pages'); ?>">Pages</a></li>
            <li class="breadcrumb-item active">Edit</li>
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

    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (validation_errors()) : ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?php echo validation_errors(); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form action="<?php echo base_url('pages/edit/' . $page['page_id']); ?>" method="post">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="bi bi-file-text me-2"></i>Page Content
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" value="<?php echo htmlspecialchars($page['title']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control" value="<?php echo htmlspecialchars($page['slug']); ?>" readonly>
                            <small class="text-muted">Auto-generated from title</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea name="content" id="content" class="form-control" rows="15" required><?php echo htmlspecialchars($page['content']); ?></textarea>
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
                            <input type="text" name="meta_title" class="form-control" value="<?php echo htmlspecialchars($page['meta_title'] ?? ''); ?>">
                            <small class="text-muted">Leave empty to use page title</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3"><?php echo htmlspecialchars($page['meta_description'] ?? ''); ?></textarea>
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
                                <option value="draft" <?php echo ($page['status'] == 'draft') ? 'selected' : ''; ?>>Draft</option>
                                <option value="published" <?php echo ($page['status'] == 'published') ? 'selected' : ''; ?>>Published</option>
                            </select>
                        </div>

                        <?php if (!empty($page['created_by_name'])) : ?>
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="bi bi-person me-1"></i>Created by: <?php echo htmlspecialchars($page['created_by_name']); ?><br>
                                    <i class="bi bi-calendar me-1"></i>Created: <?php echo date('d M Y H:i', strtotime($page['created_at'])); ?>
                                    <?php if (!empty($page['updated_at'])) : ?>
                                        <br><i class="bi bi-pencil me-1"></i>Updated: <?php echo date('d M Y H:i', strtotime($page['updated_at'])); ?>
                                    <?php endif; ?>
                                </small>
                            </div>
                        <?php endif; ?>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i> Update Page
                            </button>
                            <a href="<?php echo base_url('pages/builder/' . $page['page_id']); ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-layout-text-window-reverse me-1"></i> Page Builder
                            </a>
                            <a href="<?php echo base_url('pages/view/' . $page['page_id']); ?>" class="btn btn-outline-info">
                                <i class="bi bi-eye me-1"></i> View Page
                            </a>
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
                        <?php if (!empty($page['featured_image_path'])) : ?>
                            <div class="mb-3 text-center">
                                <img src="<?php echo base_url($page['featured_image_path']); ?>" class="img-fluid rounded" alt="Featured Image">
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($media)) : ?>
                            <div class="mb-3">
                                <label class="form-label">Select from Media Library</label>
                                <select name="featured_image" class="form-select">
                                    <option value="">-- No Image --</option>
                                    <?php foreach ($media as $item) : ?>
                                        <option value="<?php echo $item['media_id']; ?>" <?php echo ($page['featured_image'] == $item['media_id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($item['file_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php else : ?>
                            <input type="hidden" name="featured_image" value="<?php echo $page['featured_image'] ?? ''; ?>">
                            <p class="text-muted mb-0">No images available in media library.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
