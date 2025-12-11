<?php
/**
 * Team Section Render
 */
$data = $section['section_data'] ?? [];
$items = $data['items'] ?? [];
$columns = $data['columns'] ?? 3;

$colClass = 'col-md-4';
if ($columns == 4) $colClass = 'col-md-3';
?>
<section class="team-section py-5">
    <div class="container">
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
        
        <div class="row g-4 justify-content-center">
            <?php foreach ($items as $item): ?>
            <div class="<?php echo $colClass; ?>">
                <div class="card h-100 border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <?php if (!empty($item['image'])): ?>
                        <img src="<?php echo base_url($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name'] ?? ''); ?>" 
                             class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                        <?php else: ?>
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 120px; height: 120px;">
                            <span class="display-4"><?php echo strtoupper(substr($item['name'] ?? 'U', 0, 1)); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <h5 class="card-title mb-1"><?php echo htmlspecialchars($item['name'] ?? ''); ?></h5>
                        <p class="text-primary mb-3"><?php echo htmlspecialchars($item['role'] ?? ''); ?></p>
                        
                        <?php if (!empty($item['bio'])): ?>
                        <p class="card-text text-muted small"><?php echo htmlspecialchars($item['bio']); ?></p>
                        <?php endif; ?>
                        
                        <div class="social-links mt-3">
                            <?php if (!empty($item['social_linkedin'])): ?>
                            <a href="<?php echo htmlspecialchars($item['social_linkedin']); ?>" class="text-secondary me-2" target="_blank">
                                <i class="bi bi-linkedin fs-5"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (!empty($item['social_twitter'])): ?>
                            <a href="<?php echo htmlspecialchars($item['social_twitter']); ?>" class="text-secondary me-2" target="_blank">
                                <i class="bi bi-twitter-x fs-5"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (!empty($item['social_email'])): ?>
                            <a href="mailto:<?php echo htmlspecialchars($item['social_email']); ?>" class="text-secondary">
                                <i class="bi bi-envelope fs-5"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
