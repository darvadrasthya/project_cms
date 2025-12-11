<?php
/**
 * Pricing Table Section Form
 * Fields: title, subtitle, items (array), columns
 */
$data = $section['section_data'] ?? [];
$items = $data['items'] ?? [
    ['name' => 'Basic', 'price' => '99', 'period' => '/month', 'features' => "Feature 1\nFeature 2\nFeature 3", 'btn_text' => 'Get Started', 'btn_link' => '#', 'highlighted' => '0'],
];
?>
<form id="section-edit-form">
    <div class="mb-3">
        <label class="form-label">Section Title (Internal)</label>
        <input type="text" name="section_title" class="form-control" 
               value="<?php echo htmlspecialchars($section['section_title'] ?? ''); ?>">
    </div>
    
    <div class="row">
        <div class="col-md-5">
            <div class="mb-3">
                <label class="form-label">Section Heading</label>
                <input type="text" name="data[title]" class="form-control" 
                       value="<?php echo htmlspecialchars($data['title'] ?? ''); ?>" placeholder="Pricing Plans">
            </div>
        </div>
        <div class="col-md-5">
            <div class="mb-3">
                <label class="form-label">Subtitle</label>
                <input type="text" name="data[subtitle]" class="form-control" 
                       value="<?php echo htmlspecialchars($data['subtitle'] ?? ''); ?>" placeholder="Choose the best plan">
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-3">
                <label class="form-label">Columns</label>
                <select name="data[columns]" class="form-select">
                    <option value="2" <?php echo ($data['columns'] ?? '') == '2' ? 'selected' : ''; ?>>2</option>
                    <option value="3" <?php echo ($data['columns'] ?? '3') == '3' ? 'selected' : ''; ?>>3</option>
                    <option value="4" <?php echo ($data['columns'] ?? '') == '4' ? 'selected' : ''; ?>>4</option>
                </select>
            </div>
        </div>
    </div>
    
    <hr>
    <h6 class="mb-3"><i class="bi bi-currency-dollar me-2"></i>Pricing Plans</h6>
    
    <div id="pricing-container">
        <?php foreach ($items as $index => $item): ?>
        <div class="pricing-item card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-2">
                            <input type="text" name="data[items][<?php echo $index; ?>][name]" class="form-control form-control-sm" 
                                   value="<?php echo htmlspecialchars($item['name'] ?? ''); ?>" placeholder="Plan Name">
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text">$</span>
                            <input type="text" name="data[items][<?php echo $index; ?>][price]" class="form-control" 
                                   value="<?php echo htmlspecialchars($item['price'] ?? ''); ?>" placeholder="99">
                            <input type="text" name="data[items][<?php echo $index; ?>][period]" class="form-control" 
                                   value="<?php echo htmlspecialchars($item['period'] ?? ''); ?>" placeholder="/month">
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" name="data[items][<?php echo $index; ?>][highlighted]" value="1"
                                   <?php echo ($item['highlighted'] ?? '0') == '1' ? 'checked' : ''; ?>>
                            <label class="form-check-label">Highlight</label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <textarea name="data[items][<?php echo $index; ?>][features]" class="form-control form-control-sm" rows="4" 
                                  placeholder="One feature per line"><?php echo htmlspecialchars($item['features'] ?? ''); ?></textarea>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2">
                            <input type="text" name="data[items][<?php echo $index; ?>][btn_text]" class="form-control form-control-sm" 
                                   value="<?php echo htmlspecialchars($item['btn_text'] ?? ''); ?>" placeholder="Button Text">
                        </div>
                        <div class="mb-2">
                            <input type="text" name="data[items][<?php echo $index; ?>][btn_link]" class="form-control form-control-sm" 
                                   value="<?php echo htmlspecialchars($item['btn_link'] ?? ''); ?>" placeholder="Button Link">
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-pricing">
                            <i class="bi bi-trash me-1"></i>Remove
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-pricing">
        <i class="bi bi-plus me-1"></i>Add Plan
    </button>
</form>

<script>
let pricingIndex = <?php echo count($items); ?>;

document.getElementById('btn-add-pricing')?.addEventListener('click', function() {
    const container = document.getElementById('pricing-container');
    const html = `
        <div class="pricing-item card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-2">
                            <input type="text" name="data[items][${pricingIndex}][name]" class="form-control form-control-sm" placeholder="Plan Name">
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text">$</span>
                            <input type="text" name="data[items][${pricingIndex}][price]" class="form-control" placeholder="99">
                            <input type="text" name="data[items][${pricingIndex}][period]" class="form-control" placeholder="/month">
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" name="data[items][${pricingIndex}][highlighted]" value="1">
                            <label class="form-check-label">Highlight</label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <textarea name="data[items][${pricingIndex}][features]" class="form-control form-control-sm" rows="4" placeholder="One feature per line"></textarea>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-2">
                            <input type="text" name="data[items][${pricingIndex}][btn_text]" class="form-control form-control-sm" placeholder="Button Text">
                        </div>
                        <div class="mb-2">
                            <input type="text" name="data[items][${pricingIndex}][btn_link]" class="form-control form-control-sm" placeholder="Button Link">
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-pricing">
                            <i class="bi bi-trash me-1"></i>Remove
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    pricingIndex++;
    bindRemovePricingButtons();
});

function bindRemovePricingButtons() {
    document.querySelectorAll('.btn-remove-pricing').forEach(btn => {
        btn.onclick = function() {
            this.closest('.pricing-item').remove();
        };
    });
}
bindRemovePricingButtons();
</script>
