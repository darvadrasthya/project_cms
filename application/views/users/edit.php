<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
	<div>
	<h1 class="h3 mb-0">Edit User</h1>
        <nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0">
				<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url('users'); ?>">Users</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
	</div>
    </div>
</div>

<div class="content-wrapper">
    <?php if(validation_errors()): ?>
        <div class="alert alert-danger">
            <?php echo validation_errors(); ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form action="<?php echo base_url('users/edit/'.$user['user_id']); ?>" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control"
                                   value="<?php echo set_value('username', $user['username']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control"
                                   value="<?php echo set_value('email', $user['email']); ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                            <small class="text-muted">Leave blank to keep current password</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Roles</label>
                            <select name="roles[]" class="form-select" multiple>
                                <?php 
                                $user_role_ids = [];
                                if(isset($user_roles)) {
                                    foreach($user_roles as $ur) {
                                        $user_role_ids[] = $ur['role_id'];
                                    }
                                }
                                ?>
                                <?php if(isset($roles)): ?>
                                    <?php foreach($roles as $role): ?>
                                        <option value="<?php echo $role['role_id']; ?>"
                                            <?php echo in_array($role['role_id'], $user_role_ids) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($role['role_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1" <?php echo $user['is_active'] ? 'selected' : ''; ?>>Active</option>
                        <option value="0" <?php echo !$user['is_active'] ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="<?php echo base_url('users'); ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
