<?php
/**
 * Gallery Section Form
 * Fields: images (array), columns, gap, lightbox
 */
$data = $section['section_data'] ?? [];
$images = $data['images'] ?? [];
?>
<form id="section-edit-form">
    <div class="mb-3">
        <label class="form-label">Section Title (Internal)</label>
        <input type="text" name="section_title" class="form-control" 
               value="<?php echo htmlspecialchars($section['section_title'] ?? ''); ?>">
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Columns</label>
                <select name="data[columns]" class="form-select">
                    <option value="2" <?php echo ($data['columns'] ?? '') == '2' ? 'selected' : ''; ?>>2 Columns</option>
                    <option value="3" <?php echo ($data['columns'] ?? '3') == '3' ? 'selected' : ''; ?>>3 Columns</option>
                    <option value="4" <?php echo ($data['columns'] ?? '') == '4' ? 'selected' : ''; ?>>4 Columns</option>
                    <option value="6" <?php echo ($data['columns'] ?? '') == '6' ? 'selected' : ''; ?>>6 Columns</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Gap Size</label>
                <select name="data[gap]" class="form-select">
                    <option value="0" <?php echo ($data['gap'] ?? '') == '0' ? 'selected' : ''; ?>>No Gap</option>
                    <option value="1" <?php echo ($data['gap'] ?? '') == '1' ? 'selected' : ''; ?>>Small</option>
                    <option value="2" <?php echo ($data['gap'] ?? '2') == '2' ? 'selected' : ''; ?>>Medium</option>
                    <option value="3" <?php echo ($data['gap'] ?? '') == '3' ? 'selected' : ''; ?>>Large</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Lightbox</label>
                <select name="data[lightbox]" class="form-select">
                    <option value="1" <?php echo ($data['lightbox'] ?? '1') == '1' ? 'selected' : ''; ?>>Enabled</option>
                    <option value="0" <?php echo ($data['lightbox'] ?? '') == '0' ? 'selected' : ''; ?>>Disabled</option>
                </select>
            </div>
        </div>
    </div>
    
    <hr>
    <h6 class="mb-3"><i class="bi bi-images me-2"></i>Gallery Images</h6>
    
    <?php if (!empty($media)): ?>
    <div class="mb-3">
        <label class="form-label">Select Images from Media Library</label>
        <div class="row g-2" style="max-height: 300px; overflow-y: auto;">
            <?php foreach ($media as $item): ?>
            <div class="col-md-2 col-sm-3 col-4">
                <div class="form-check gallery-check">
                    <input type="checkbox" class="form-check-input" 
                           name="data[images][]" value="<?php echo htmlspecialchars($item['file_path']); ?>"
                           id="img_<?php echo $item['media_id']; ?>"
                           <?php echo in_array($item['file_path'], $images) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="img_<?php echo $item['media_id']; ?>">
                        <img src="<?php echo base_url($item['file_path']); ?>" class="img-thumbnail" style="width:100%; height: 80px; object-fit: cover;">
                    </label>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>No images in media library. Please upload images first.
    </div>
    <?php endif; ?>
</form>

<style>
.gallery-check {
    position: relative;
}
.gallery-check .form-check-input {
    position: absolute;
    top: 5px;
    left: 5px;
    z-index: 1;
}
.gallery-check .form-check-label {
    cursor: pointer;
}
.gallery-check .form-check-input:checked + .form-check-label img {
    border-color: #0d6efd;
    box-shadow: 0 0 0 3px rgba(13,110,253,0.25);
}
</style>
