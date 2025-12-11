<?php
/**
 * Testimonials Section Form
 * Fields: title, items (array), style, autoplay
 */
$data = $section['section_data'] ?? [];
$items = $data['items'] ?? [
    ['name' => 'John Doe', 'role' => 'CEO', 'content' => 'Great service!', 'image' => ''],
];
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
                <label class="form-label">Section Heading</label>
                <input type="text" name="data[title]" class="form-control" 
                       value="<?php echo htmlspecialchars($data['title'] ?? ''); ?>" placeholder="What Our Clients Say">
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label class="form-label">Style</label>
                <select name="data[style]" class="form-select">
                    <option value="cards" <?php echo ($data['style'] ?? 'cards') == 'cards' ? 'selected' : ''; ?>>Cards</option>
                    <option value="carousel" <?php echo ($data['style'] ?? '') == 'carousel' ? 'selected' : ''; ?>>Carousel</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label class="form-label">Autoplay</label>
                <select name="data[autoplay]" class="form-select">
                    <option value="1" <?php echo ($data['autoplay'] ?? '1') == '1' ? 'selected' : ''; ?>>Yes</option>
                    <option value="0" <?php echo ($data['autoplay'] ?? '') == '0' ? 'selected' : ''; ?>>No</option>
                </select>
            </div>
        </div>
    </div>
    
    <hr>
    <h6 class="mb-3"><i class="bi bi-chat-quote me-2"></i>Testimonials</h6>
    
    <div id="testimonials-container">
        <?php foreach ($items as $index => $item): ?>
        <div class="testimonial-item card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-2">
                            <input type="text" name="data[items][<?php echo $index; ?>][name]" class="form-control form-control-sm" 
                                   value="<?php echo htmlspecialchars($item['name'] ?? ''); ?>" placeholder="Name">
                        </div>
                        <div class="mb-2">
                            <input type="text" name="data[items][<?php echo $index; ?>][role]" class="form-control form-control-sm" 
                                   value="<?php echo htmlspecialchars($item['role'] ?? ''); ?>" placeholder="Role / Company">
                        </div>
                        <div class="mb-2">
                            <input type="text" name="data[items][<?php echo $index; ?>][image]" class="form-control form-control-sm" 
                                   value="<?php echo htmlspecialchars($item['image'] ?? ''); ?>" placeholder="Image URL (optional)">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <textarea name="data[items][<?php echo $index; ?>][content]" class="form-control form-control-sm" rows="3" 
                                  placeholder="Testimonial content"><?php echo htmlspecialchars($item['content'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="mt-2">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-testimonial">
                        <i class="bi bi-trash me-1"></i>Remove
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-testimonial">
        <i class="bi bi-plus me-1"></i>Add Testimonial
    </button>
</form>

<script>
let testimonialIndex = <?php echo count($items); ?>;

document.getElementById('btn-add-testimonial')?.addEventListener('click', function() {
    const container = document.getElementById('testimonials-container');
    const html = `
        <div class="testimonial-item card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-2">
                            <input type="text" name="data[items][${testimonialIndex}][name]" class="form-control form-control-sm" placeholder="Name">
                        </div>
                        <div class="mb-2">
                            <input type="text" name="data[items][${testimonialIndex}][role]" class="form-control form-control-sm" placeholder="Role / Company">
                        </div>
                        <div class="mb-2">
                            <input type="text" name="data[items][${testimonialIndex}][image]" class="form-control form-control-sm" placeholder="Image URL (optional)">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <textarea name="data[items][${testimonialIndex}][content]" class="form-control form-control-sm" rows="3" placeholder="Testimonial content"></textarea>
                    </div>
                </div>
                <div class="mt-2">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-testimonial">
                        <i class="bi bi-trash me-1"></i>Remove
                    </button>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    testimonialIndex++;
    bindRemoveTestimonialButtons();
});

function bindRemoveTestimonialButtons() {
    document.querySelectorAll('.btn-remove-testimonial').forEach(btn => {
        btn.onclick = function() {
            this.closest('.testimonial-item').remove();
        };
    });
}
bindRemoveTestimonialButtons();
</script>
