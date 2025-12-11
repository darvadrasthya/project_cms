<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
		<div>
        	<h1 class="h3 mb-0">Users</h1>
        	<nav aria-label="breadcrumb">
        	    <ol class="breadcrumb mb-0">
        	        <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
        	        <li class="breadcrumb-item active">Users</li>
        	    </ol>
        	</nav>
		</div>
			<a href="<?php echo base_url('users/create'); ?>" class="btn btn-primary">
				<i class="bi bi-plus-lg me-1"></i>Add User
			</a>
	</div>
</div>

<div class="content-wrapper">
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('error')): ?>
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
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($users) && !empty($users)): ?>
                            <?php foreach($users as $index => $user): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['username']); ?>&background=random&color=fff" 
                                                class="rounded-circle me-2" width="32" height="32" alt="">
                                            <?php echo htmlspecialchars($user['username']); ?>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <?php if(!empty($user['roles'])): ?>
                                            <?php 
                                            $roles = explode(',', $user['roles']);
                                            foreach($roles as $role): ?>
                                                <span class="badge bg-primary"><?php echo htmlspecialchars(trim($role)); ?></span>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">No Role</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($user['is_active']): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                        <?php if(isset($user['is_locked']) && $user['is_locked']): ?>
                                            <span class="badge bg-warning">Locked</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('d M Y', strtotime($user['created_at'])); ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?php echo base_url('users/view/'.$user['user_id']); ?>" 
                                                class="btn btn-sm btn-outline-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?php echo base_url('users/edit/'.$user['user_id']); ?>" 
                                                class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="<?php echo base_url('users/toggle-lock/'.$user['user_id']); ?>" 
                                                class="btn btn-sm btn-outline-warning" title="Toggle Lock">
                                                <i class="bi bi-<?php echo (isset($user['is_locked']) && $user['is_locked']) ? 'unlock' : 'lock'; ?>"></i>
                                            </a>
                                            <a href="<?php echo base_url('users/delete/'.$user['user_id']); ?>" 
                                                class="btn btn-sm btn-outline-danger" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this user?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bi bi-people display-4 text-muted"></i>
                                    <p class="text-muted mt-2">No users found</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if(isset($pagination)): ?>
                <div class="d-flex justify-content-center mt-3">
                    <?php echo $pagination; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
