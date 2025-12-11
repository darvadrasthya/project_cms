<?php
/**
 * CTA (Call to Action) Section Form
 * Fields: title, subtitle, btn_text, btn_link, bg_color, text_color
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
        <label class="form-label">CTA Title <span class="text-danger">*</span></label>
        <input type="text" name="data[title]" class="form-control form-control-lg" 
               value="<?php echo htmlspecialchars($data['title'] ?? ''); ?>" placeholder="Ready to Get Started?" required>
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
                       value="<?php echo htmlspecialchars($data['btn_text'] ?? ''); ?>" placeholder="Contact Us">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Button Link</label>
                <input type="text" name="data[btn_link]" class="form-control" 
                       value="<?php echo htmlspecialchars($data['btn_link'] ?? ''); ?>" placeholder="/contact">
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Background Color</label>
                <input type="color" name="data[bg_color]" class="form-control form-control-color w-100" 
                       value="<?php echo htmlspecialchars($data['bg_color'] ?? '#0d6efd'); ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Text Color</label>
                <input type="color" name="data[text_color]" class="form-control form-control-color w-100" 
                       value="<?php echo htmlspecialchars($data['text_color'] ?? '#ffffff'); ?>">
            </div>
        </div>
    </div>
</form>
