<?php
/**
 * CTA Section Render
 */
$data = $section['section_data'] ?? [];
$bgColor = $data['bg_color'] ?? '#0d6efd';
$textColor = $data['text_color'] ?? '#ffffff';
?>
<section class="cta-section py-5" style="background-color: <?php echo $bgColor; ?>; color: <?php echo $textColor; ?>;">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <?php if (!empty($data['title'])): ?>
                <h2 class="fw-bold mb-3"><?php echo htmlspecialchars($data['title']); ?></h2>
                <?php endif; ?>
                
                <?php if (!empty($data['subtitle'])): ?>
                <p class="lead mb-4"><?php echo htmlspecialchars($data['subtitle']); ?></p>
                <?php endif; ?>
                
                <?php if (!empty($data['btn_text'])): ?>
                <a href="<?php echo htmlspecialchars($data['btn_link'] ?? '#'); ?>" class="btn btn-light btn-lg px-5">
                    <?php echo htmlspecialchars($data['btn_text']); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
