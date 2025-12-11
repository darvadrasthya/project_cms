<?php
/**
 * Contact Form Section Render
 */
$data = $section['section_data'] ?? [];
$fields = $data['fields'] ?? ['name', 'email', 'message'];
$formId = 'contact_form_' . $section['section_id'];
?>
<section class="contact-form-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <?php if (!empty($data['title']) || !empty($data['subtitle'])): ?>
                <div class="text-center mb-5">
                    <?php if (!empty($data['title'])): ?>
                    <h2 class="fw-bold"><?php echo htmlspecialchars($data['title']); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($data['subtitle'])): ?>
                    <p class="text-muted"><?php echo htmlspecialchars($data['subtitle']); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <form id="<?php echo $formId; ?>" onsubmit="submitContactForm(event, '<?php echo $formId; ?>')">
                            <div class="row g-3">
                                <?php if (in_array('name', $fields)): ?>
                                <div class="col-md-6">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (in_array('email', $fields)): ?>
                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (in_array('phone', $fields)): ?>
                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="tel" name="phone" class="form-control">
                                </div>
                                <?php endif; ?>
                                
                                <?php if (in_array('subject', $fields)): ?>
                                <div class="col-md-6">
                                    <label class="form-label">Subject</label>
                                    <input type="text" name="subject" class="form-control">
                                </div>
                                <?php endif; ?>
                                
                                <?php if (in_array('message', $fields)): ?>
                                <div class="col-12">
                                    <label class="form-label">Message <span class="text-danger">*</span></label>
                                    <textarea name="message" class="form-control" rows="5" required></textarea>
                                </div>
                                <?php endif; ?>
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-send me-2"></i><?php echo htmlspecialchars($data['submit_text'] ?? 'Send Message'); ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                        <div id="<?php echo $formId; ?>_success" class="alert alert-success mt-4" style="display: none;">
                            <i class="bi bi-check-circle me-2"></i>
                            <?php echo htmlspecialchars($data['success_message'] ?? 'Thank you! Your message has been sent.'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function submitContactForm(e, formId) {
    e.preventDefault();
    const form = document.getElementById(formId);
    const successMsg = document.getElementById(formId + '_success');
    
    // Simple simulation - in real implementation, you would send to server
    form.style.display = 'none';
    successMsg.style.display = 'block';
}
</script>
