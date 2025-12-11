<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
    <h1><?php echo isset($permission) ? 'Edit Permission' : 'Create Permission'; ?></h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('permissions'); ?>">Permissions</a></li>
            <li class="breadcrumb-item active"><?php echo isset($permission) ? 'Edit' : 'Create'; ?></li>
        </ol>
    </nav>
</div>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <form action="<?php echo isset($permission) ? base_url('permissions/update/' . $permission['permission_id']) : base_url('permissions/store'); ?>" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Permission Name <span class="text-danger">*</span></label>
                            <input type="text" name="permission_desc" class="form-control" placeholder="e.g., user.create, page.delete" value="<?php echo isset($permission) ? htmlspecialchars($permission['permission_desc']) : set_value('permission_desc'); ?>" required>
                            <small class="text-muted">Use format: resource.action (e.g., user.create, page.read)</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <input type="text" name="description" class="form-control" value="<?php echo isset($permission) ? htmlspecialchars($permission['description'] ?? '') : set_value('description'); ?>">
                        </div>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-between">
                    <a href="<?php echo base_url('permissions'); ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> <?php echo isset($permission) ? 'Update' : 'Create'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>