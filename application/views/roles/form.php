<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
    <h1><?php echo isset($role) ? 'Edit Role' : 'Create Role'; ?></h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('roles'); ?>">Roles</a></li>
            <li class="breadcrumb-item active"><?php echo isset($role) ? 'Edit' : 'Create'; ?></li>
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

    <div class="card">
        <div class="card-body">
            <form action="<?php echo isset($role) ? base_url('roles/update/' . $role['role_id']) : base_url('roles/store'); ?>" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Role Name <span class="text-danger">*</span></label>
                            <input type="text" name="role_name" class="form-control" value="<?php echo isset($role) ? htmlspecialchars($role['role_name']) : set_value('role_name'); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <input type="text" name="description" class="form-control" value="<?php echo isset($role) ? htmlspecialchars($role['description'] ?? '') : set_value('description'); ?>">
                        </div>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-between">
                    <a href="<?php echo base_url('roles'); ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> <?php echo isset($role) ? 'Update' : 'Create'; ?> Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>