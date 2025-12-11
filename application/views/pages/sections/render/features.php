<?php
/**
 * Features Grid Section Render
 */
$data = $section['section_data'] ?? [];
$items = $data['items'] ?? [];
$columns = $data['columns'] ?? 3;
$style = $data['style'] ?? 'cards';

$colClass = 'col-md-4';
if ($columns == 2) $colClass = 'col-md-6';
if ($columns == 4) $colClass = 'col-md-3';
?>
<section class="features-section py-5 bg-light">
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
        
        <div class="row g-4">
            <?php foreach ($items as $item): ?>
            <div class="<?php echo $colClass; ?>">
                <?php if ($style == 'cards'): ?>
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <?php if (!empty($item['icon'])): ?>
                        <div class="feature-icon bg-primary bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi <?php echo htmlspecialchars($item['icon']); ?> fs-4"></i>
                        </div>
                        <?php endif; ?>
                        <h5 class="card-title"><?php echo htmlspecialchars($item['title'] ?? ''); ?></h5>
                        <p class="card-text text-muted"><?php echo htmlspecialchars($item['description'] ?? ''); ?></p>
                    </div>
                </div>
                <?php elseif ($style == 'icons'): ?>
                <div class="text-center">
                    <?php if (!empty($item['icon'])): ?>
                    <i class="bi <?php echo htmlspecialchars($item['icon']); ?> display-4 text-primary mb-3"></i>
                    <?php endif; ?>
                    <h5><?php echo htmlspecialchars($item['title'] ?? ''); ?></h5>
                    <p class="text-muted"><?php echo htmlspecialchars($item['description'] ?? ''); ?></p>
                </div>
                <?php else: ?>
                <div class="d-flex">
                    <?php if (!empty($item['icon'])): ?>
                    <div class="flex-shrink-0">
                        <i class="bi <?php echo htmlspecialchars($item['icon']); ?> fs-3 text-primary me-3"></i>
                    </div>
                    <?php endif; ?>
                    <div>
                        <h5><?php echo htmlspecialchars($item['title'] ?? ''); ?></h5>
                        <p class="text-muted"><?php echo htmlspecialchars($item['description'] ?? ''); ?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
