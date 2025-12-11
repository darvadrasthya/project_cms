<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Menus</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Menus</li>
                </ol>
            </nav>
        </div>
        <a href="<?php echo base_url('menus/create'); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Menu
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

    <div class="row">
        <?php if (isset($menus) && !empty($menus)) : ?>
            <?php foreach ($menus as $menu) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong><?php echo htmlspecialchars($menu['menu_name']); ?></strong>
                            <span class="badge bg-info"><?php echo htmlspecialchars($menu['menu_location']); ?></span>
                        </div>
                        <div class="card-body">
                            <p class="text-muted"><?php echo htmlspecialchars($menu['description'] ?? 'No description'); ?></p>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="btn-group w-100 mb-2">
                                <a href="<?php echo base_url('menus/items/' . $menu['menu_id']); ?>" class="btn btn-outline-info" title="Manage Items">
                                    <i class="bi bi-list-ul"></i> Items
                                </a>
                                <a href="<?php echo base_url('menus/edit/' . $menu['menu_id']); ?>" class="btn btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="<?php echo base_url('menus/delete/' . $menu['menu_id']); ?>" class="btn btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                            <a href="<?php echo base_url('menus/preview/' . $menu['menu_id']); ?>" class="btn btn-success w-100" target="_blank" title="Preview Menu">
                                <i class="bi bi-eye"></i> Preview Menu
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-list text-muted" style="font-size: 3em;"></i>
                        <p class="mt-2 text-muted">No menus found</p>
                        <a href="<?php echo base_url('menus/create'); ?>" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> Create First Menu
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
