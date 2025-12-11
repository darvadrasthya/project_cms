<?php
/**
 * Statistics/Counter Section Form
 * Fields: title, items (array), bg_color, animate
 */
$data = $section['section_data'] ?? [];
$items = $data['items'] ?? [
    ['number' => '100', 'suffix' => '+', 'label' => 'Clients'],
    ['number' => '50', 'suffix' => '+', 'label' => 'Projects'],
    ['number' => '10', 'suffix' => '', 'label' => 'Years Experience'],
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
                       value="<?php echo htmlspecialchars($data['title'] ?? ''); ?>" placeholder="Our Achievements">
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label class="form-label">Background Color</label>
                <input type="color" name="data[bg_color]" class="form-control form-control-color w-100" 
                       value="<?php echo htmlspecialchars($data['bg_color'] ?? '#f8f9fa'); ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label class="form-label">Animate Numbers</label>
                <select name="data[animate]" class="form-select">
                    <option value="1" <?php echo ($data['animate'] ?? '1') == '1' ? 'selected' : ''; ?>>Yes</option>
                    <option value="0" <?php echo ($data['animate'] ?? '') == '0' ? 'selected' : ''; ?>>No</option>
                </select>
            </div>
        </div>
    </div>
    
    <hr>
    <h6 class="mb-3"><i class="bi bi-graph-up me-2"></i>Statistics Items</h6>
    
    <div id="stats-container">
        <?php foreach ($items as $index => $item): ?>
        <div class="stat-item card mb-2">
            <div class="card-body py-2">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <input type="number" name="data[items][<?php echo $index; ?>][number]" class="form-control form-control-sm" 
                               value="<?php echo htmlspecialchars($item['number'] ?? ''); ?>" placeholder="Number">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="data[items][<?php echo $index; ?>][suffix]" class="form-control form-control-sm" 
                               value="<?php echo htmlspecialchars($item['suffix'] ?? ''); ?>" placeholder="Suffix (+, %, K)">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="data[items][<?php echo $index; ?>][label]" class="form-control form-control-sm" 
                               value="<?php echo htmlspecialchars($item['label'] ?? ''); ?>" placeholder="Label">
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-stat">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-stat">
        <i class="bi bi-plus me-1"></i>Add Statistic
    </button>
</form>

<script>
let statIndex = <?php echo count($items); ?>;

document.getElementById('btn-add-stat')?.addEventListener('click', function() {
    const container = document.getElementById('stats-container');
    const html = `
        <div class="stat-item card mb-2">
            <div class="card-body py-2">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <input type="number" name="data[items][${statIndex}][number]" class="form-control form-control-sm" placeholder="Number">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="data[items][${statIndex}][suffix]" class="form-control form-control-sm" placeholder="Suffix (+, %, K)">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="data[items][${statIndex}][label]" class="form-control form-control-sm" placeholder="Label">
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-stat">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    statIndex++;
    bindRemoveStatButtons();
});

function bindRemoveStatButtons() {
    document.querySelectorAll('.btn-remove-stat').forEach(btn => {
        btn.onclick = function() {
            this.closest('.stat-item').remove();
        };
    });
}
bindRemoveStatButtons();
</script>
