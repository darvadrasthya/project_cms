<?php
/**
 * Hero Section Form
 * Fields: title, subtitle, bg_image, bg_color, text_color, btn_text, btn_link, btn_style, overlay_opacity, height
 */
$data = $section['section_data'] ?? [];
?>
<form id="section-edit-form">
    <div class="row">
        <div class="col-md-8">
            <div class="mb-3">
                <label class="form-label">Section Title (Internal)</label>
                <input type="text" name="section_title" class="form-control" 
                       value="<?php echo htmlspecialchars($section['section_title'] ?? ''); ?>">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Hero Title <span class="text-danger">*</span></label>
                <input type="text" name="data[title]" class="form-control form-control-lg" 
                       value="<?php echo htmlspecialchars($data['title'] ?? ''); ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Subtitle</label>
                <textarea name="data[subtitle]" class="form-control" rows="2"><?php echo htmlspecialchars($data['subtitle'] ?? ''); ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Button Text</label>
                        <input type="text" name="data[btn_text]" class="form-control" 
                               value="<?php echo htmlspecialchars($data['btn_text'] ?? ''); ?>" placeholder="e.g., Learn More">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Button Link</label>
                        <input type="text" name="data[btn_link]" class="form-control" 
                               value="<?php echo htmlspecialchars($data['btn_link'] ?? ''); ?>" placeholder="e.g., #about or /contact">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Button Style</label>
                <select name="data[btn_style]" class="form-select">
                    <option value="primary" <?php echo ($data['btn_style'] ?? '') == 'primary' ? 'selected' : ''; ?>>Primary (Blue)</option>
                    <option value="secondary" <?php echo ($data['btn_style'] ?? '') == 'secondary' ? 'selected' : ''; ?>>Secondary (Gray)</option>
                    <option value="success" <?php echo ($data['btn_style'] ?? '') == 'success' ? 'selected' : ''; ?>>Success (Green)</option>
                    <option value="danger" <?php echo ($data['btn_style'] ?? '') == 'danger' ? 'selected' : ''; ?>>Danger (Red)</option>
                    <option value="warning" <?php echo ($data['btn_style'] ?? '') == 'warning' ? 'selected' : ''; ?>>Warning (Yellow)</option>
                    <option value="light" <?php echo ($data['btn_style'] ?? '') == 'light' ? 'selected' : ''; ?>>Light</option>
                    <option value="dark" <?php echo ($data['btn_style'] ?? '') == 'dark' ? 'selected' : ''; ?>>Dark</option>
                    <option value="outline-light" <?php echo ($data['btn_style'] ?? '') == 'outline-light' ? 'selected' : ''; ?>>Outline Light</option>
                    <option value="outline-dark" <?php echo ($data['btn_style'] ?? '') == 'outline-dark' ? 'selected' : ''; ?>>Outline Dark</option>
                </select>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Background Image</label>
                <?php if (!empty($media)): ?>
                <select name="data[bg_image]" class="form-select">
                    <option value="">-- No Image --</option>
                    <?php foreach ($media as $item): ?>
                    <option value="<?php echo htmlspecialchars($item['file_path']); ?>" 
                            <?php echo ($data['bg_image'] ?? '') == $item['file_path'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($item['file_name']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <?php else: ?>
                <input type="text" name="data[bg_image]" class="form-control" 
                       value="<?php echo htmlspecialchars($data['bg_image'] ?? ''); ?>" placeholder="Image URL">
                <?php endif; ?>
            </div>
            
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label class="form-label">Background Color</label>
                        <input type="color" name="data[bg_color]" class="form-control form-control-color w-100" 
                               value="<?php echo htmlspecialchars($data['bg_color'] ?? '#4A90A4'); ?>">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label class="form-label">Text Color</label>
                        <input type="color" name="data[text_color]" class="form-control form-control-color w-100" 
                               value="<?php echo htmlspecialchars($data['text_color'] ?? '#ffffff'); ?>">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Overlay Opacity (0-100)</label>
                <input type="range" name="data[overlay_opacity]" class="form-range" min="0" max="100" 
                       value="<?php echo htmlspecialchars($data['overlay_opacity'] ?? '50'); ?>">
                <small class="text-muted">Darker overlay on background image</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Section Height</label>
                <select name="data[height]" class="form-select">
                    <option value="auto" <?php echo ($data['height'] ?? '') == 'auto' ? 'selected' : ''; ?>>Auto</option>
                    <option value="50vh" <?php echo ($data['height'] ?? '') == '50vh' ? 'selected' : ''; ?>>Half Screen (50vh)</option>
                    <option value="75vh" <?php echo ($data['height'] ?? '') == '75vh' ? 'selected' : ''; ?>>Three Quarter (75vh)</option>
                    <option value="100vh" <?php echo ($data['height'] ?? '') == '100vh' ? 'selected' : ''; ?>>Full Screen (100vh)</option>
                </select>
            </div>
        </div>
    </div>
</form>
