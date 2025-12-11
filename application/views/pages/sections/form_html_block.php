<?php
/**
 * Custom HTML Section Form
 * Fields: html_content
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
        <label class="form-label">Custom HTML Code</label>
        <textarea name="data[html_content]" class="form-control font-monospace" rows="15" 
                  placeholder="Enter your custom HTML code here..."><?php echo htmlspecialchars($data['html_content'] ?? ''); ?></textarea>
        <small class="text-muted">
            <i class="bi bi-exclamation-triangle text-warning me-1"></i>
            Be careful with custom HTML. Make sure the code is valid and doesn't break the page layout.
        </small>
    </div>
</form>
