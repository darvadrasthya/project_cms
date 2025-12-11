<?php
/**
 * Contact Form Section Form
 * Fields: title, subtitle, fields, submit_text, success_message
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
                <label class="form-label">Form Title</label>
                <input type="text" name="data[title]" class="form-control" 
                       value="<?php echo htmlspecialchars($data['title'] ?? ''); ?>" placeholder="Contact Us">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Subtitle</label>
                <input type="text" name="data[subtitle]" class="form-control" 
                       value="<?php echo htmlspecialchars($data['subtitle'] ?? ''); ?>" placeholder="We'd love to hear from you">
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Submit Button Text</label>
                <input type="text" name="data[submit_text]" class="form-control" 
                       value="<?php echo htmlspecialchars($data['submit_text'] ?? 'Send Message'); ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Success Message</label>
                <input type="text" name="data[success_message]" class="form-control" 
                       value="<?php echo htmlspecialchars($data['success_message'] ?? 'Thank you! Your message has been sent.'); ?>">
            </div>
        </div>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Form Fields</label>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="data[fields][]" value="name" id="field_name"
                   <?php echo in_array('name', $data['fields'] ?? ['name', 'email', 'message']) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="field_name">Name</label>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="data[fields][]" value="email" id="field_email"
                   <?php echo in_array('email', $data['fields'] ?? ['name', 'email', 'message']) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="field_email">Email</label>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="data[fields][]" value="phone" id="field_phone"
                   <?php echo in_array('phone', $data['fields'] ?? []) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="field_phone">Phone</label>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="data[fields][]" value="subject" id="field_subject"
                   <?php echo in_array('subject', $data['fields'] ?? []) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="field_subject">Subject</label>
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="data[fields][]" value="message" id="field_message"
                   <?php echo in_array('message', $data['fields'] ?? ['name', 'email', 'message']) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="field_message">Message</label>
        </div>
    </div>
</form>
