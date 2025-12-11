<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
    <h1><?php echo isset($menu) ? 'Edit Menu' : 'Create Menu'; ?></h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('menus'); ?>">Menus</a></li>
            <li class="breadcrumb-item active"><?php echo isset($menu) ? 'Edit' : 'Create'; ?></li>
        </ol>
    </nav>
</div>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <form action="<?php echo isset($menu) ? base_url('menus/update/' . $menu['menu_id']) : base_url('menus/store'); ?>" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Menu Name <span class="text-danger">*</span></label>
                            <input type="text" name="menu_name" class="form-control" value="<?php echo isset($menu) ? htmlspecialchars($menu['menu_name']) : set_value('menu_name'); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Location <span class="text-danger">*</span></label>
                            <select name="menu_location" class="form-select" required>
                                <option value="header" <?php echo (isset($menu) && $menu['menu_location'] == 'header') ? 'selected' : ''; ?>>Header</option>
                                <option value="footer" <?php echo (isset($menu) && $menu['menu_location'] == 'footer') ? 'selected' : ''; ?>>Footer</option>
                                <option value="sidebar" <?php echo (isset($menu) && $menu['menu_location'] == 'sidebar') ? 'selected' : ''; ?>>Sidebar</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"><?php echo isset($menu) ? htmlspecialchars($menu['description'] ?? '') : set_value('description'); ?></textarea>
                </div>

                <hr>
                <div class="d-flex justify-content-between">
                    <a href="<?php echo base_url('menus'); ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> <?php echo isset($menu) ? 'Update' : 'Create'; ?> Menu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>