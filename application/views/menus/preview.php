<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f0f2f5;
            min-height: 100vh;
        }
        .preview-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .preview-header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .menu-preview-box {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .menu-preview-title {
            background: #343a40;
            color: white;
            padding: 15px 20px;
            font-weight: 600;
        }
        
        /* Horizontal Menu Style */
        .horizontal-menu {
            background: #212529;
            padding: 0;
        }
        .horizontal-menu .navbar-nav {
            width: 100%;
        }
        .horizontal-menu .nav-link {
            color: rgba(255,255,255,0.85) !important;
            padding: 15px 20px;
            transition: all 0.3s;
        }
        .horizontal-menu .nav-link:hover {
            color: white !important;
            background: rgba(255,255,255,0.1);
        }
        .horizontal-menu .dropdown-menu {
            border-radius: 0;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        /* Vertical Menu Style */
        .vertical-menu {
            padding: 0;
        }
        .vertical-menu .nav-link {
            color: #333;
            padding: 12px 20px;
            border-bottom: 1px solid #eee;
            transition: all 0.3s;
        }
        .vertical-menu .nav-link:hover {
            background: #f8f9fa;
            color: #0d6efd;
            padding-left: 25px;
        }
        .vertical-menu .nav-link i {
            margin-right: 10px;
            width: 20px;
        }
        .vertical-menu .submenu {
            padding-left: 20px;
            background: #f8f9fa;
        }
        .vertical-menu .submenu .nav-link {
            font-size: 0.9rem;
            padding: 10px 20px;
        }
        
        /* Footer Menu Style */
        .footer-menu {
            background: #212529;
            padding: 30px 20px;
        }
        .footer-menu .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 5px 15px;
        }
        .footer-menu .nav-link:hover {
            color: white;
        }
        
        .menu-info {
            padding: 20px;
            background: #f8f9fa;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="preview-container">
        <!-- Header -->
        <div class="preview-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">
                        <i class="bi bi-eye me-2"></i>Menu Preview
                    </h4>
                    <p class="text-muted mb-0">
                        <strong><?php echo htmlspecialchars($menu['menu_name']); ?></strong>
                        <?php if(!empty($menu['menu_location'])): ?>
                            <span class="badge bg-primary ms-2"><?php echo htmlspecialchars($menu['menu_location']); ?></span>
                        <?php endif; ?>
                    </p>
                </div>
                <div>
                    <a href="<?php echo base_url('menus/items/' . $menu['menu_id']); ?>" class="btn btn-outline-primary">
                        <i class="bi bi-pencil me-1"></i>Edit Items
                    </a>
                    <a href="<?php echo base_url('menus'); ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Back to Menus
                    </a>
                </div>
            </div>
        </div>

        <!-- Horizontal Menu Preview -->
        <div class="menu-preview-box mb-4">
            <div class="menu-preview-title">
                <i class="bi bi-layout-text-window me-2"></i>Horizontal Navigation (Header Style)
            </div>
            <nav class="navbar navbar-expand horizontal-menu">
                <div class="container-fluid">
                    <ul class="navbar-nav">
                        <?php echo render_menu_horizontal($menu_tree); ?>
                    </ul>
                </div>
            </nav>
        </div>

        <!-- Vertical Menu Preview -->
        <div class="row">
            <div class="col-md-4">
                <div class="menu-preview-box mb-4">
                    <div class="menu-preview-title">
                        <i class="bi bi-layout-sidebar me-2"></i>Vertical Navigation (Sidebar Style)
                    </div>
                    <nav class="vertical-menu">
                        <?php echo render_menu_vertical($menu_tree); ?>
                    </nav>
                </div>
            </div>
            <div class="col-md-8">
                <div class="menu-preview-box mb-4">
                    <div class="menu-preview-title">
                        <i class="bi bi-layout-text-window-reverse me-2"></i>Footer Navigation
                    </div>
                    <nav class="footer-menu text-center">
                        <ul class="nav justify-content-center">
                            <?php echo render_menu_footer($menu_tree); ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Menu Structure -->
        <div class="menu-preview-box">
            <div class="menu-preview-title">
                <i class="bi bi-diagram-3 me-2"></i>Menu Structure (JSON)
            </div>
            <div class="p-3">
                <pre class="bg-dark text-light p-3 rounded mb-0" style="max-height: 300px; overflow: auto;"><?php echo json_encode($menu_tree, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>
            </div>
            <div class="menu-info">
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Total Items: <strong><?php echo count_menu_items($menu_tree); ?></strong> |
                    Position: <strong><?php echo $menu['menu_location'] ?: 'Not set'; ?></strong> |
                    Created: <strong><?php echo date('d M Y', strtotime($menu['created_at'])); ?></strong>
                </small>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Helper functions for rendering menu

function render_menu_horizontal($items, $is_submenu = false) {
    if (empty($items)) return '';
    
    $html = '';
    foreach ($items as $item) {
        $has_children = !empty($item['children']);
        $label = htmlspecialchars($item['label'] ?? $item['title'] ?? '');
        $url = htmlspecialchars($item['url'] ?? '#');
        $icon = !empty($item['icon']) ? '<i class="bi bi-' . htmlspecialchars($item['icon']) . ' me-1"></i>' : '';
        
        if ($has_children) {
            $html .= '<li class="nav-item dropdown">';
            $html .= '<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">' . $icon . $label . '</a>';
            $html .= '<ul class="dropdown-menu">';
            foreach ($item['children'] as $child) {
                $child_label = htmlspecialchars($child['label'] ?? $child['title'] ?? '');
                $child_url = htmlspecialchars($child['url'] ?? '#');
                $html .= '<li><a class="dropdown-item" href="' . $child_url . '">' . $child_label . '</a></li>';
            }
            $html .= '</ul></li>';
        } else {
            $html .= '<li class="nav-item">';
            $html .= '<a class="nav-link" href="' . $url . '">' . $icon . $label . '</a>';
            $html .= '</li>';
        }
    }
    return $html;
}

function render_menu_vertical($items, $level = 0) {
    if (empty($items)) return '<div class="p-3 text-muted text-center"><em>No menu items</em></div>';
    
    $html = '';
    $class = $level > 0 ? 'submenu' : '';
    
    if ($level > 0) $html .= '<div class="' . $class . '">';
    
    foreach ($items as $item) {
        $has_children = !empty($item['children']);
        $label = htmlspecialchars($item['label'] ?? $item['title'] ?? '');
        $url = htmlspecialchars($item['url'] ?? '#');
        $icon = !empty($item['icon']) ? $item['icon'] : ($level == 0 ? 'chevron-right' : 'dot');
        
        $html .= '<a class="nav-link" href="' . $url . '">';
        $html .= '<i class="bi bi-' . $icon . '"></i>' . $label;
        $html .= '</a>';
        
        if ($has_children) {
            $html .= render_menu_vertical($item['children'], $level + 1);
        }
    }
    
    if ($level > 0) $html .= '</div>';
    
    return $html;
}

function render_menu_footer($items) {
    if (empty($items)) return '';
    
    $html = '';
    foreach ($items as $item) {
        $label = htmlspecialchars($item['label'] ?? $item['title'] ?? '');
        $url = htmlspecialchars($item['url'] ?? '#');
        $html .= '<li class="nav-item"><a class="nav-link" href="' . $url . '">' . $label . '</a></li>';
    }
    return $html;
}

function count_menu_items($items) {
    $count = count($items);
    foreach ($items as $item) {
        if (!empty($item['children'])) {
            $count += count_menu_items($item['children']);
        }
    }
    return $count;
}
?>
