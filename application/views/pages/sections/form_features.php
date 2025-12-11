<?php
/**
 * Features Grid Section Form
 * Fields: title, subtitle, items (array), columns, style
 */
$data = $section['section_data'] ?? [];
$items = $data['items'] ?? [
    ['icon' => 'bi-star', 'title' => 'Feature 1', 'description' => 'Description here'],
    ['icon' => 'bi-heart', 'title' => 'Feature 2', 'description' => 'Description here'],
    ['icon' => 'bi-lightning', 'title' => 'Feature 3', 'description' => 'Description here']
];
?>
<form id="section-edit-form">
    <div class="mb-3">
        <label class="form-label">Section Title (Internal)</label>
        <input type="text" name="section_title" class="form-control" 
               value="<?php echo htmlspecialchars($section['section_title'] ?? ''); ?>">
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Section Heading</label>
                <input type="text" name="data[title]" class="form-control" 
                       value="<?php echo htmlspecialchars($data['title'] ?? ''); ?>" placeholder="Our Features">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Subtitle</label>
                <input type="text" name="data[subtitle]" class="form-control" 
                       value="<?php echo htmlspecialchars($data['subtitle'] ?? ''); ?>" placeholder="Why choose us">
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Columns</label>
                <select name="data[columns]" class="form-select">
                    <option value="2" <?php echo ($data['columns'] ?? '') == '2' ? 'selected' : ''; ?>>2 Columns</option>
                    <option value="3" <?php echo ($data['columns'] ?? '3') == '3' ? 'selected' : ''; ?>>3 Columns</option>
                    <option value="4" <?php echo ($data['columns'] ?? '') == '4' ? 'selected' : ''; ?>>4 Columns</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Style</label>
                <select name="data[style]" class="form-select">
                    <option value="cards" <?php echo ($data['style'] ?? 'cards') == 'cards' ? 'selected' : ''; ?>>Cards</option>
                    <option value="icons" <?php echo ($data['style'] ?? '') == 'icons' ? 'selected' : ''; ?>>Icons Only</option>
                    <option value="minimal" <?php echo ($data['style'] ?? '') == 'minimal' ? 'selected' : ''; ?>>Minimal</option>
                </select>
            </div>
        </div>
    </div>
    
    <hr>
    <h6 class="mb-3"><i class="bi bi-list-ul me-2"></i>Feature Items</h6>
    
    <div id="features-container">
        <?php foreach ($items as $index => $item): ?>
        <div class="feature-item card mb-2">
            <div class="card-body py-2">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <input type="text" name="data[items][<?php echo $index; ?>][icon]" class="form-control form-control-sm" 
                               value="<?php echo htmlspecialchars($item['icon'] ?? ''); ?>" placeholder="bi-star">
                        <small class="text-muted">Bootstrap Icon</small>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="data[items][<?php echo $index; ?>][title]" class="form-control form-control-sm" 
                               value="<?php echo htmlspecialchars($item['title'] ?? ''); ?>" placeholder="Title">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="data[items][<?php echo $index; ?>][description]" class="form-control form-control-sm" 
                               value="<?php echo htmlspecialchars($item['description'] ?? ''); ?>" placeholder="Description">
                    </div>
                    <div class="col-md-1 text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-feature">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-feature">
        <i class="bi bi-plus me-1"></i>Add Feature
    </button>
</form>

<script>
let featureIndex = <?php echo count($items); ?>;

document.getElementById('btn-add-feature')?.addEventListener('click', function() {
    const container = document.getElementById('features-container');
    const html = `
        <div class="feature-item card mb-2">
            <div class="card-body py-2">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <input type="text" name="data[items][${featureIndex}][icon]" class="form-control form-control-sm" placeholder="bi-star">
                        <small class="text-muted">Bootstrap Icon</small>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="data[items][${featureIndex}][title]" class="form-control form-control-sm" placeholder="Title">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="data[items][${featureIndex}][description]" class="form-control form-control-sm" placeholder="Description">
                    </div>
                    <div class="col-md-1 text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-feature">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    featureIndex++;
    bindRemoveButtons();
});

function bindRemoveButtons() {
    document.querySelectorAll('.btn-remove-feature').forEach(btn => {
        btn.onclick = function() {
            this.closest('.feature-item').remove();
        };
    });
}
bindRemoveButtons();
</script>
