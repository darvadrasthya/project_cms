<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
    <h1>Add Menu Item</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('menus'); ?>">Menus</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('menus/items/' . $menu['menu_id']); ?>"><?php echo htmlspecialchars($menu['menu_name']); ?></a></li>
            <li class="breadcrumb-item active">Add Item</li>
        </ol>
    </nav>
</div>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <form action="<?php echo base_url('menus/store-item/' . $menu['menu_id']); ?>" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">URL <span class="text-danger">*</span></label>
                            <input type="text" name="url" class="form-control" placeholder="https:// or /path" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Parent Item</label>
                            <select name="parent_id" class="form-select">
                                <option value="">-- None --</option>
                                <?php if (isset($parent_items)) : ?>
                                    <?php foreach ($parent_items as $item) : ?>
                                        <option value="<?php echo $item['item_id']; ?>"><?php echo htmlspecialchars($item['title']); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Target</label>
                            <select name="target" class="form-select">
                                <option value="_self">Same Window</option>
                                <option value="_blank">New Window</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="0">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Icon Class</label>
                            <input type="text" name="icon" class="form-control" placeholder="e.g., bi bi-house">
                            <small class="text-muted">Bootstrap Icons class</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 pt-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_active" value="1" id="is_active" checked>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-between">
                    <a href="<?php echo base_url('menus/items/' . $menu['menu_id']); ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> Add Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>