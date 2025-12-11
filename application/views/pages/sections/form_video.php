<?php
/**
 * Video Embed Section Form
 * Fields: title, video_url, aspect_ratio
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
        <label class="form-label">Video Title</label>
        <input type="text" name="data[title]" class="form-control" 
               value="<?php echo htmlspecialchars($data['title'] ?? ''); ?>" placeholder="Watch Our Video">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Video URL <span class="text-danger">*</span></label>
        <input type="url" name="data[video_url]" class="form-control" 
               value="<?php echo htmlspecialchars($data['video_url'] ?? ''); ?>" 
               placeholder="https://www.youtube.com/watch?v=..." required>
        <small class="text-muted">Supports YouTube and Vimeo URLs</small>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Aspect Ratio</label>
        <select name="data[aspect_ratio]" class="form-select">
            <option value="16x9" <?php echo ($data['aspect_ratio'] ?? '16x9') == '16x9' ? 'selected' : ''; ?>>16:9 (Widescreen)</option>
            <option value="4x3" <?php echo ($data['aspect_ratio'] ?? '') == '4x3' ? 'selected' : ''; ?>>4:3 (Standard)</option>
            <option value="1x1" <?php echo ($data['aspect_ratio'] ?? '') == '1x1' ? 'selected' : ''; ?>>1:1 (Square)</option>
            <option value="21x9" <?php echo ($data['aspect_ratio'] ?? '') == '21x9' ? 'selected' : ''; ?>>21:9 (Ultrawide)</option>
        </select>
    </div>
</form>
