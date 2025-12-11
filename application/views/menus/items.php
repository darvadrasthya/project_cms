<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Menu Items: <?php echo htmlspecialchars($menu['menu_name']); ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('menus'); ?>">Menus</a></li>
                    <li class="breadcrumb-item active">Items</li>
                </ol>
            </nav>
        </div>
        <a href="<?php echo base_url('menus/add-item/' . $menu['menu_id']); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Item
        </a>
        <a href="<?php echo base_url('menus/preview/' . $menu['menu_id']); ?>" class="btn btn-success ms-2" target="_blank">
            <i class="bi bi-eye"></i> Preview Menu
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

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Title</th>
                        <th>URL</th>
                        <th>Target</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($items) && !empty($items)) : ?>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td><?php echo $item['sort_order']; ?></td>
                                <td>
                                    <?php if (!empty($item['icon'])) : ?>
                                        <i class="<?php echo htmlspecialchars($item['icon']); ?> me-1"></i>
                                    <?php endif; ?>
                                    <?php echo htmlspecialchars($item['title']); ?>
                                    <?php if (!empty($item['parent_id'])) : ?>
                                        <small class="text-muted">(Child)</small>
                                    <?php endif; ?>
                                </td>
                                <td><code><?php echo htmlspecialchars($item['url']); ?></code></td>
                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($item['target']); ?></span></td>
                                <td>
                                    <?php if ($item['is_active']) : ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else : ?>
                                        <span class="badge bg-danger">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url('menus/delete-item/' . $menu['menu_id'] . '/' . $item['item_id']); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No menu items found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <a href="<?php echo base_url('menus'); ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Menus
    </a>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
