<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Roles</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Roles</li>
                </ol>
            </nav>
        </div>
        <a href="<?php echo base_url('roles/create'); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Role
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
                            <th>Role Name</th>
                            <th>Description</th>
                            <th>System Role</th>
                            <th>Permissions</th>
                            <th>Users</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($roles) && !empty($roles)) : ?>
                            <?php $no = 1;
                            foreach ($roles as $role) : ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($role['role_name']); ?></strong>
                                    </td>
                                    <td><?php echo htmlspecialchars($role['description'] ?? '-'); ?></td>
                                    <td>
                                        <?php if (isset($role['is_system']) && $role['is_system']) : ?>
                                            <span class="badge bg-info">System</span>
                                        <?php else : ?>
                                            <span class="badge bg-secondary">Custom</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary"><?php echo isset($role['permission_count']) ? $role['permission_count'] : 0; ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success"><?php echo isset($role['user_count']) ? $role['user_count'] : 0; ?></span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?php echo base_url('roles/permissions/' . $role['role_id']); ?>" class="btn btn-sm btn-outline-info" title="Manage Permissions">
                                                <i class="bi bi-key"></i>
                                            </a>
                                            <a href="<?php echo base_url('roles/edit/' . $role['role_id']); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <?php if (!isset($role['is_system']) || !$role['is_system']) : ?>
                                                <a href="<?php echo base_url('roles/delete/' . $role['role_id']); ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this role?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-shield" style="font-size: 3em;"></i>
                                    <p class="mt-2">No roles found</p>
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