<?php
/**
 * FAQ Accordion Section Render
 */
$data = $section['section_data'] ?? [];
$items = $data['items'] ?? [];
$accordionId = 'faq_' . $section['section_id'];
?>
<section class="faq-section py-5">
    <div class="container">
        <?php if (!empty($data['title'])): ?>
        <div class="text-center mb-5">
            <h2 class="fw-bold"><?php echo htmlspecialchars($data['title']); ?></h2>
        </div>
        <?php endif; ?>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="<?php echo $accordionId; ?>">
                    <?php foreach ($items as $index => $item): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button <?php echo $index > 0 ? 'collapsed' : ''; ?>" type="button" 
                                    data-bs-toggle="collapse" data-bs-target="#<?php echo $accordionId; ?>_<?php echo $index; ?>">
                                <?php echo htmlspecialchars($item['question'] ?? ''); ?>
                            </button>
                        </h2>
                        <div id="<?php echo $accordionId; ?>_<?php echo $index; ?>" 
                             class="accordion-collapse collapse <?php echo $index == 0 ? 'show' : ''; ?>" 
                             data-bs-parent="#<?php echo $accordionId; ?>">
                            <div class="accordion-body">
                                <?php echo nl2br(htmlspecialchars($item['answer'] ?? '')); ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
