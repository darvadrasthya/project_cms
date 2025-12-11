<?php
/**
 * Image + Text Section Form
 * Fields: image, title, content, image_position, btn_text, btn_link
 */
$data = $section['section_data'] ?? [];
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
                <label class="form-label">Image</label>
                <?php if (!empty($media)): ?>
                <select name="data[image]" class="form-select">
                    <option value="">-- Select Image --</option>
                    <?php foreach ($media as $item): ?>
                    <option value="<?php echo htmlspecialchars($item['file_path']); ?>" 
                            <?php echo ($data['image'] ?? '') == $item['file_path'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($item['file_name']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <?php else: ?>
                <input type="text" name="data[image]" class="form-control" 
                       value="<?php echo htmlspecialchars($data['image'] ?? ''); ?>" placeholder="Image URL">
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Image Position</label>
                <select name="data[image_position]" class="form-select">
                    <option value="left" <?php echo ($data['image_position'] ?? 'left') == 'left' ? 'selected' : ''; ?>>Left</option>
                    <option value="right" <?php echo ($data['image_position'] ?? '') == 'right' ? 'selected' : ''; ?>>Right</option>
                </select>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="data[title]" class="form-control" 
                       value="<?php echo htmlspecialchars($data['title'] ?? ''); ?>">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea name="data[content]" class="form-control" rows="4"><?php echo htmlspecialchars($data['content'] ?? ''); ?></textarea>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Button Text</label>
                <input type="text" name="data[btn_text]" class="form-control" 
                       value="<?php echo htmlspecialchars($data['btn_text'] ?? ''); ?>" placeholder="Optional">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Button Link</label>
                <input type="text" name="data[btn_link]" class="form-control" 
                       value="<?php echo htmlspecialchars($data['btn_link'] ?? ''); ?>" placeholder="Optional">
            </div>
        </div>
    </div>
</form>
