<?php $this->load->view('templates/admin_header'); ?>

<style>
/* Page Builder Styles */
.builder-container {
    display: flex;
    gap: 20px;
    min-height: calc(100vh - 200px);
}
.builder-sidebar {
    width: 280px;
    flex-shrink: 0;
}
.builder-main {
    flex: 1;
    min-width: 0;
}
.section-type-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    margin-bottom: 8px;
    cursor: pointer;
    transition: all 0.2s;
    background: #fff;
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}
.section-type-item:hover {
    border-color: #0d6efd;
    background: #f8f9ff;
    transform: translateX(3px);
}
.section-type-item:active {
    transform: scale(0.98);
    background: #e7f1ff;
}
.section-type-item i {
    font-size: 1.25rem;
    color: #6c757d;
    width: 24px;
    text-align: center;
}
.section-type-item .info {
    flex: 1;
    min-width: 0;
}
.section-type-item .name {
    font-weight: 500;
    font-size: 0.875rem;
}
.section-type-item .desc {
    font-size: 0.75rem;
    color: #6c757d;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.sections-list {
    min-height: 200px;
}
.section-item {
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-bottom: 12px;
    transition: all 0.2s;
}
.section-item.inactive {
    opacity: 0.6;
    background: #f8f9fa;
}
.section-item:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.section-item.ui-sortable-helper {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transform: rotate(1deg);
}
.section-item.ui-sortable-placeholder {
    visibility: visible !important;
    background: #e3f2fd;
    border: 2px dashed #2196f3;
}
.section-item.sortable-ghost {
    opacity: 0.4;
    background: #f0f0f0;
}
.section-item.sortable-chosen {
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
.section-item.sortable-drag {
    background: #fff;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}
.section-header {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    border-bottom: 1px solid #eee;
    cursor: move;
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}
.section-header .drag-handle {
    color: #adb5bd;
    margin-right: 10px;
    cursor: grab;
}
.section-header .drag-handle:active {
    cursor: grabbing;
}
.section-header .section-icon {
    width: 32px;
    height: 32px;
    background: #e9ecef;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
}
.section-header .section-info {
    flex: 1;
}
.section-header .section-title {
    font-weight: 600;
    margin-bottom: 2px;
}
.section-header .section-type {
    font-size: 0.75rem;
    color: #6c757d;
}
.section-actions {
    display: flex;
    gap: 5px;
    pointer-events: auto;
}
.section-actions .btn {
    padding: 4px 8px;
    font-size: 0.8rem;
    cursor: pointer;
}
.section-body {
    padding: 15px;
    display: none;
}
.section-item.expanded .section-body {
    display: block;
}
.layout-option {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 15px;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
}
.layout-option:hover {
    border-color: #0d6efd;
}
.layout-option.active {
    border-color: #0d6efd;
    background: #f0f7ff;
}
.layout-option i {
    font-size: 2rem;
    margin-bottom: 8px;
    color: #495057;
}
.layout-option .name {
    font-weight: 500;
    font-size: 0.875rem;
}
.empty-sections {
    text-align: center;
    padding: 60px 20px;
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    color: #6c757d;
}
.empty-sections i {
    font-size: 3rem;
    margin-bottom: 15px;
    opacity: 0.5;
}
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="bi bi-layout-text-window-reverse me-2"></i>Page Builder</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('pages'); ?>">Pages</a></li>
                    <li class="breadcrumb-item active"><?php echo htmlspecialchars($page['title']); ?></li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="<?php echo base_url('pages/preview/' . $page['page_id']); ?>" class="btn btn-outline-info" target="_blank">
                <i class="bi bi-eye me-1"></i>Preview
            </a>
            <a href="<?php echo base_url('pages/edit/' . $page['page_id']); ?>" class="btn btn-outline-secondary">
                <i class="bi bi-pencil me-1"></i>Edit Content
            </a>
            <a href="<?php echo base_url('pages'); ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>
</div>

<div class="content-wrapper">
    <div class="builder-container">
        <!-- Sidebar -->
        <div class="builder-sidebar">
            <!-- Layout Settings -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-layout-wtf me-2"></i>Layout Template
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <?php foreach ($layout_templates as $key => $template): ?>
                        <div class="col-6">
                            <div class="layout-option <?php echo ($page['layout_template'] ?? 'full_width') == $key ? 'active' : ''; ?>" 
                                 data-layout="<?php echo $key; ?>" title="<?php echo htmlspecialchars($template['description']); ?>">
                                <i class="bi <?php echo $template['icon']; ?>"></i>
                                <span class="name"><?php echo htmlspecialchars($template['name']); ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <hr>
                    
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="use_sections" 
                               <?php echo ($page['use_sections'] ?? 0) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="use_sections">
                            Use Section Builder
                        </label>
                    </div>
                    <small class="text-muted">When enabled, sections will be used instead of content editor.</small>
                </div>
            </div>

            <!-- Add Section -->
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-plus-circle me-2"></i>Add Section
                </div>
                <div class="card-body p-2">
                    <div class="section-types-list" style="max-height: 400px; overflow-y: auto;">
                        <?php foreach ($section_types as $key => $type): ?>
                        <div class="section-type-item" data-type="<?php echo $key; ?>">
                            <i class="bi <?php echo $type['icon']; ?>"></i>
                            <div class="info">
                                <div class="name"><?php echo htmlspecialchars($type['name']); ?></div>
                                <div class="desc"><?php echo htmlspecialchars($type['description']); ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="builder-main">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-layers me-2"></i>Page Sections</span>
                    <span class="badge bg-secondary" id="section-count"><?php echo count($sections); ?> sections</span>
                </div>
                <div class="card-body">
                    <div class="sections-list" id="sections-list">
                        <?php if (empty($sections)): ?>
                        <div class="empty-sections" id="empty-message">
                            <i class="bi bi-inbox"></i>
                            <h5>No Sections Yet</h5>
                            <p class="mb-0">Click on a section type from the left panel to add it here.</p>
                        </div>
                        <?php else: ?>
                            <?php foreach ($sections as $section): ?>
                            <?php $type_info = $section_types[$section['section_type']] ?? null; ?>
                            <div class="section-item <?php echo !$section['is_active'] ? 'inactive' : ''; ?>" 
                                 data-section-id="<?php echo $section['section_id']; ?>"
                                 data-section-type="<?php echo $section['section_type']; ?>">
                                <div class="section-header">
                                    <i class="bi bi-grip-vertical drag-handle"></i>
                                    <div class="section-icon">
                                        <i class="bi <?php echo $type_info['icon'] ?? 'bi-square'; ?>"></i>
                                    </div>
                                    <div class="section-info">
                                        <div class="section-title"><?php echo htmlspecialchars($section['section_title']); ?></div>
                                        <div class="section-type"><?php echo $type_info['name'] ?? $section['section_type']; ?></div>
                                    </div>
                                    <div class="section-actions">
                                        <button class="btn btn-sm btn-outline-primary btn-edit-section" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary btn-toggle-section" title="Toggle">
                                            <i class="bi bi-<?php echo $section['is_active'] ? 'eye' : 'eye-slash'; ?>"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-info btn-duplicate-section" title="Duplicate">
                                            <i class="bi bi-copy"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger btn-delete-section" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="section-body">
                                    <!-- Section form will be loaded here via AJAX -->
                                    <div class="text-center py-3">
                                        <div class="spinner-border spinner-border-sm"></div>
                                        <span class="ms-2">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Edit Modal -->
<div class="modal fade" id="sectionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    <span id="modal-section-title">Edit Section</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="section-form-container">
                <div class="text-center py-5">
                    <div class="spinner-border"></div>
                    <p class="mt-2">Loading form...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btn-save-section">
                    <i class="bi bi-check-lg me-1"></i>Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
const pageId = <?php echo $page['page_id']; ?>;
const baseUrl = '<?php echo base_url(); ?>';
let currentSectionId = null;

// Initialize Sortable for sections list (drag to reorder)
const sectionsList = document.getElementById('sections-list');
if (sectionsList) {
    new Sortable(sectionsList, {
        handle: '.section-header',
        draggable: '.section-item',
        filter: '.section-actions, .section-actions .btn',
        preventOnFilter: false,
        animation: 150,
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        dragClass: 'sortable-drag',
        forceFallback: true,
        fallbackClass: 'sortable-fallback',
        fallbackOnBody: true,
        swapThreshold: 0.65,
        onStart: function(evt) {
            document.body.style.cursor = 'grabbing';
        },
        onEnd: function(evt) {
            document.body.style.cursor = '';
            saveSectionOrder();
        }
    });
}

// Layout selection
document.querySelectorAll('.layout-option').forEach(el => {
    el.addEventListener('click', function() {
        document.querySelectorAll('.layout-option').forEach(o => o.classList.remove('active'));
        this.classList.add('active');
        saveLayoutSettings();
    });
});

// Use sections toggle
document.getElementById('use_sections')?.addEventListener('change', saveLayoutSettings);

function saveLayoutSettings() {
    const layout = document.querySelector('.layout-option.active')?.dataset.layout || 'full_width';
    const useSections = document.getElementById('use_sections')?.checked ? 1 : 0;
    
    fetch(`${baseUrl}pages/update_layout/${pageId}`, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `layout_template=${layout}&use_sections=${useSections}`
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast('Layout settings saved', 'success');
        }
    });
}

// Add section
document.querySelectorAll('.section-type-item').forEach(el => {
    el.addEventListener('click', function() {
        const type = this.dataset.type;
        addSection(type);
    });
});

function addSection(type) {
    fetch(`${baseUrl}pages/add_section/${pageId}`, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `section_type=${type}`
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            // Remove empty message
            document.getElementById('empty-message')?.remove();
            
            // Add new section to list
            const section = data.section;
            const typeInfo = data.section_type_info;
            
            const html = `
                <div class="section-item" data-section-id="${section.section_id}" data-section-type="${section.section_type}">
                    <div class="section-header">
                        <i class="bi bi-grip-vertical drag-handle"></i>
                        <div class="section-icon">
                            <i class="bi ${typeInfo.icon}"></i>
                        </div>
                        <div class="section-info">
                            <div class="section-title">${escapeHtml(section.section_title)}</div>
                            <div class="section-type">${typeInfo.name}</div>
                        </div>
                        <div class="section-actions">
                            <button class="btn btn-sm btn-outline-primary btn-edit-section" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary btn-toggle-section" title="Toggle">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-info btn-duplicate-section" title="Duplicate">
                                <i class="bi bi-copy"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger btn-delete-section" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="text-center py-3">
                            <div class="spinner-border spinner-border-sm"></div>
                            <span class="ms-2">Loading...</span>
                        </div>
                    </div>
                </div>
            `;
            
            sectionsList.insertAdjacentHTML('beforeend', html);
            updateSectionCount();
            bindSectionEvents();
            showToast('Section added', 'success');
            
            // Auto open edit modal
            editSection(section.section_id);
        } else {
            showToast(data.message, 'danger');
        }
    });
}

function bindSectionEvents() {
    // Edit section
    document.querySelectorAll('.btn-edit-section').forEach(btn => {
        btn.onclick = function() {
            const item = this.closest('.section-item');
            const sectionId = item.dataset.sectionId;
            editSection(sectionId);
        };
    });

    // Toggle section
    document.querySelectorAll('.btn-toggle-section').forEach(btn => {
        btn.onclick = function() {
            const item = this.closest('.section-item');
            const sectionId = item.dataset.sectionId;
            toggleSection(sectionId, item, this);
        };
    });

    // Duplicate section
    document.querySelectorAll('.btn-duplicate-section').forEach(btn => {
        btn.onclick = function() {
            const item = this.closest('.section-item');
            const sectionId = item.dataset.sectionId;
            duplicateSection(sectionId);
        };
    });

    // Delete section
    document.querySelectorAll('.btn-delete-section').forEach(btn => {
        btn.onclick = function() {
            const item = this.closest('.section-item');
            const sectionId = item.dataset.sectionId;
            deleteSection(sectionId, item);
        };
    });
}

function editSection(sectionId) {
    currentSectionId = sectionId;
    const modal = new bootstrap.Modal(document.getElementById('sectionModal'));
    const container = document.getElementById('section-form-container');
    
    container.innerHTML = '<div class="text-center py-5"><div class="spinner-border"></div><p class="mt-2">Loading form...</p></div>';
    modal.show();
    
    fetch(`${baseUrl}pages/get_section_form/${sectionId}`)
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            container.innerHTML = data.html;
            document.getElementById('modal-section-title').textContent = 'Edit: ' + data.section.section_title;
            initFormComponents();
        } else {
            container.innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
        }
    });
}

function toggleSection(sectionId, item, btn) {
    fetch(`${baseUrl}pages/toggle_section/${sectionId}`, {method: 'POST'})
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            item.classList.toggle('inactive');
            const icon = btn.querySelector('i');
            icon.className = data.is_active ? 'bi bi-eye' : 'bi bi-eye-slash';
            showToast(data.message, 'success');
        }
    });
}

function duplicateSection(sectionId) {
    fetch(`${baseUrl}pages/duplicate_section/${sectionId}`, {method: 'POST'})
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function deleteSection(sectionId, item) {
    if (!confirm('Are you sure you want to delete this section?')) return;
    
    fetch(`${baseUrl}pages/delete_section/${sectionId}`, {method: 'POST'})
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            item.remove();
            updateSectionCount();
            showToast('Section deleted', 'success');
            
            // Show empty message if no sections
            if (sectionsList.children.length === 0) {
                sectionsList.innerHTML = `
                    <div class="empty-sections" id="empty-message">
                        <i class="bi bi-inbox"></i>
                        <h5>No Sections Yet</h5>
                        <p class="mb-0">Click on a section type from the left panel to add it here.</p>
                    </div>
                `;
            }
        }
    });
}

function saveSectionOrder() {
    const items = document.querySelectorAll('.section-item');
    const ids = Array.from(items).map(item => item.dataset.sectionId);
    
    fetch(`${baseUrl}pages/reorder_sections/${pageId}`, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({section_ids: ids})
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast('Order saved', 'success');
        }
    });
}

// Save section button
document.getElementById('btn-save-section')?.addEventListener('click', function() {
    if (!currentSectionId) return;
    
    const form = document.getElementById('section-edit-form');
    if (!form) return;
    
    const formData = new FormData(form);
    const sectionData = {};
    
    formData.forEach((value, key) => {
        if (key.startsWith('data[')) {
            const dataKey = key.replace('data[', '').replace(']', '');
            sectionData[dataKey] = value;
        }
    });
    
    const title = formData.get('section_title') || '';
    
    fetch(`${baseUrl}pages/update_section/${currentSectionId}`, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `section_title=${encodeURIComponent(title)}&section_data=${encodeURIComponent(JSON.stringify(sectionData))}`
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            // Update title in list
            const item = document.querySelector(`[data-section-id="${currentSectionId}"]`);
            if (item && title) {
                item.querySelector('.section-title').textContent = title;
            }
            
            bootstrap.Modal.getInstance(document.getElementById('sectionModal')).hide();
            showToast('Section saved', 'success');
        } else {
            showToast(data.message, 'danger');
        }
    });
});

function updateSectionCount() {
    const count = document.querySelectorAll('.section-item').length;
    document.getElementById('section-count').textContent = count + ' sections';
}

function initFormComponents() {
    // Initialize any special form components (color pickers, editors, etc.)
    // This can be extended for specific section types
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function showToast(message, type = 'info') {
    // Simple toast notification
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 200px;';
    toast.innerHTML = message;
    document.body.appendChild(toast);
    
    setTimeout(() => toast.remove(), 3000);
}

// Initial bind
bindSectionEvents();
</script>

<?php $this->load->view('templates/admin_footer'); ?>
