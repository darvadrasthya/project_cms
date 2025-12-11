<?php
/**
 * Pricing Section Render
 */
$data = $section['section_data'] ?? [];
$items = $data['items'] ?? [];
$columns = $data['columns'] ?? 3;

$colClass = 'col-md-4';
if ($columns == 2) $colClass = 'col-md-6';
if ($columns == 4) $colClass = 'col-md-3';
?>
<section class="pricing-section py-5 bg-light">
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
            <?php $highlighted = ($item['highlighted'] ?? '0') == '1'; ?>
            <div class="<?php echo $colClass; ?>">
                <div class="card h-100 <?php echo $highlighted ? 'border-primary shadow-lg' : 'border-0 shadow-sm'; ?>">
                    <?php if ($highlighted): ?>
                    <div class="card-header bg-primary text-white text-center py-2">
                        <small class="fw-bold">MOST POPULAR</small>
                    </div>
                    <?php endif; ?>
                    <div class="card-body p-4 text-center">
                        <h4 class="card-title"><?php echo htmlspecialchars($item['name'] ?? ''); ?></h4>
                        <div class="pricing-value my-4">
                            <span class="display-4 fw-bold">$<?php echo htmlspecialchars($item['price'] ?? '0'); ?></span>
                            <span class="text-muted"><?php echo htmlspecialchars($item['period'] ?? ''); ?></span>
                        </div>
                        
                        <?php if (!empty($item['features'])): ?>
                        <ul class="list-unstyled mb-4">
                            <?php foreach (explode("\n", $item['features']) as $feature): ?>
                            <?php if (trim($feature)): ?>
                            <li class="py-2 border-bottom">
                                <i class="bi bi-check-lg text-success me-2"></i>
                                <?php echo htmlspecialchars(trim($feature)); ?>
                            </li>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                        
                        <?php if (!empty($item['btn_text'])): ?>
                        <a href="<?php echo htmlspecialchars($item['btn_link'] ?? '#'); ?>" 
                           class="btn btn-<?php echo $highlighted ? 'primary' : 'outline-primary'; ?> w-100">
                            <?php echo htmlspecialchars($item['btn_text']); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
