<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
    <h1>Manage Permissions: <?php echo htmlspecialchars($role['role_name']); ?></h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('roles'); ?>">Roles</a></li>
            <li class="breadcrumb-item active">Permissions</li>
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

    <div class="card">
        <div class="card-body">
            <form action="<?php echo base_url('roles/update-permissions/' . $role['role_id']); ?>" method="post">
                <div class="row">
                    <?php
                    $grouped = [];
                    if (isset($permissions)) {
                        foreach ($permissions as $perm) {
                            $group = explode('.', $perm['permission_desc'])[0] ?? 'other';
                            $grouped[$group][] = $perm;
                        }
                    }
                    ?>

                    <?php foreach ($grouped as $group => $perms) : ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input select-all" id="group_<?php echo $group; ?>">
                                        <label class="form-check-label fw-bold text-capitalize" for="group_<?php echo $group; ?>">
                                            <?php echo ucfirst($group); ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php foreach ($perms as $perm) : ?>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input perm-checkbox" name="permissions[]" value="<?php echo $perm['permission_id']; ?>" id="perm_<?php echo $perm['permission_id']; ?>" data-group="group_<?php echo $group; ?>" <?php echo (isset($role_permissions) && in_array($perm['permission_id'], $role_permissions)) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="perm_<?php echo $perm['permission_id']; ?>">
                                                <?php echo htmlspecialchars($perm['permission_desc']); ?>
                                                <?php if (!empty($perm['description'])) : ?>
                                                    <small class="text-muted d-block"><?php echo htmlspecialchars($perm['description']); ?></small>
                                                <?php endif; ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <hr>
                <div class="d-flex justify-content-between">
                    <a href="<?php echo base_url('roles'); ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> Save Permissions
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Select all permissions in a group
    document.querySelectorAll('.select-all').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var groupId = this.id;
            document.querySelectorAll('[data-group="' + groupId + '"]').forEach(function(perm) {
                perm.checked = checkbox.checked;
            });
        });
    });
</script>

<?php $this->load->view('templates/admin_footer'); ?>