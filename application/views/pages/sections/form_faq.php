<?php
/**
 * FAQ Accordion Section Form
 * Fields: title, items (question/answer array)
 */
$data = $section['section_data'] ?? [];
$items = $data['items'] ?? [
    ['question' => 'Question 1?', 'answer' => 'Answer 1'],
    ['question' => 'Question 2?', 'answer' => 'Answer 2']
];
?>
<form id="section-edit-form">
    <div class="mb-3">
        <label class="form-label">Section Title (Internal)</label>
        <input type="text" name="section_title" class="form-control" 
               value="<?php echo htmlspecialchars($section['section_title'] ?? ''); ?>">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Section Heading</label>
        <input type="text" name="data[title]" class="form-control" 
               value="<?php echo htmlspecialchars($data['title'] ?? ''); ?>" placeholder="Frequently Asked Questions">
    </div>
    
    <hr>
    <h6 class="mb-3"><i class="bi bi-question-circle me-2"></i>FAQ Items</h6>
    
    <div id="faq-container">
        <?php foreach ($items as $index => $item): ?>
        <div class="faq-item card mb-2">
            <div class="card-body">
                <div class="mb-2">
                    <input type="text" name="data[items][<?php echo $index; ?>][question]" class="form-control form-control-sm" 
                           value="<?php echo htmlspecialchars($item['question'] ?? ''); ?>" placeholder="Question">
                </div>
                <div class="mb-2">
                    <textarea name="data[items][<?php echo $index; ?>][answer]" class="form-control form-control-sm" rows="2" 
                              placeholder="Answer"><?php echo htmlspecialchars($item['answer'] ?? ''); ?></textarea>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-faq">
                    <i class="bi bi-trash me-1"></i>Remove
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-faq">
        <i class="bi bi-plus me-1"></i>Add FAQ
    </button>
</form>

<script>
let faqIndex = <?php echo count($items); ?>;

document.getElementById('btn-add-faq')?.addEventListener('click', function() {
    const container = document.getElementById('faq-container');
    const html = `
        <div class="faq-item card mb-2">
            <div class="card-body">
                <div class="mb-2">
                    <input type="text" name="data[items][${faqIndex}][question]" class="form-control form-control-sm" placeholder="Question">
                </div>
                <div class="mb-2">
                    <textarea name="data[items][${faqIndex}][answer]" class="form-control form-control-sm" rows="2" placeholder="Answer"></textarea>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-faq">
                    <i class="bi bi-trash me-1"></i>Remove
                </button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    faqIndex++;
    bindRemoveFaqButtons();
});

function bindRemoveFaqButtons() {
    document.querySelectorAll('.btn-remove-faq').forEach(btn => {
        btn.onclick = function() {
            this.closest('.faq-item').remove();
        };
    });
}
bindRemoveFaqButtons();
</script>
