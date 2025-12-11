<?php
/**
 * Image + Text Section Render
 */
$data = $section['section_data'] ?? [];
$imagePosition = $data['image_position'] ?? 'left';
$orderImage = $imagePosition == 'left' ? 'order-1' : 'order-2';
$orderText = $imagePosition == 'left' ? 'order-2' : 'order-1';
?>
<section class="image-text-section py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 <?php echo $orderImage; ?>">
                <?php if (!empty($data['image'])): ?>
                <img src="<?php echo base_url($data['image']); ?>" alt="<?php echo htmlspecialchars($data['title'] ?? ''); ?>" class="img-fluid rounded shadow">
                <?php endif; ?>
            </div>
            <div class="col-lg-6 <?php echo $orderText; ?>">
                <?php if (!empty($data['title'])): ?>
                <h2 class="fw-bold mb-4"><?php echo htmlspecialchars($data['title']); ?></h2>
                <?php endif; ?>
                
                <?php if (!empty($data['content'])): ?>
                <div class="mb-4"><?php echo nl2br(htmlspecialchars($data['content'])); ?></div>
                <?php endif; ?>
                
                <?php if (!empty($data['btn_text'])): ?>
                <a href="<?php echo htmlspecialchars($data['btn_link'] ?? '#'); ?>" class="btn btn-primary">
                    <?php echo htmlspecialchars($data['btn_text']); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
