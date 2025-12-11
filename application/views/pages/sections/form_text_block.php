<?php
/**
 * Text Block Section Form
 * Fields: content, bg_color, text_align, padding
 */
$data = $section['section_data'] ?? [];
?>
<form id="section-edit-form">
    <div class="mb-3">
        <label class="form-label">Section Title (Internal)</label>
        <input type="text" name="section_title" class="form-control" 
               value="<?php echo htmlspecialchars($section['section_title'] ?? ''); ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Content <span class="text-danger">*</span></label>
        <textarea name="data[content]" class="form-control" rows="10" id="text-content-editor"><?php echo htmlspecialchars($data['content'] ?? ''); ?></textarea>
        <small class="text-muted">You can use HTML tags for formatting</small>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Background Color</label>
                <input type="color" name="data[bg_color]" class="form-control form-control-color w-100" 
                       value="<?php echo htmlspecialchars($data['bg_color'] ?? '#ffffff'); ?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Text Alignment</label>
                <select name="data[text_align]" class="form-select">
                    <option value="left" <?php echo ($data['text_align'] ?? '') == 'left' ? 'selected' : ''; ?>>Left</option>
                    <option value="center" <?php echo ($data['text_align'] ?? '') == 'center' ? 'selected' : ''; ?>>Center</option>
                    <option value="right" <?php echo ($data['text_align'] ?? '') == 'right' ? 'selected' : ''; ?>>Right</option>
                    <option value="justify" <?php echo ($data['text_align'] ?? '') == 'justify' ? 'selected' : ''; ?>>Justify</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Padding</label>
                <select name="data[padding]" class="form-select">
                    <option value="small" <?php echo ($data['padding'] ?? '') == 'small' ? 'selected' : ''; ?>>Small</option>
                    <option value="medium" <?php echo ($data['padding'] ?? 'medium') == 'medium' ? 'selected' : ''; ?>>Medium</option>
                    <option value="large" <?php echo ($data['padding'] ?? '') == 'large' ? 'selected' : ''; ?>>Large</option>
                </select>
            </div>
        </div>
    </div>
</form>
