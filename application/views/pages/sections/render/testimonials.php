<?php
/**
 * Testimonials Section Render
 */
$data = $section['section_data'] ?? [];
$items = $data['items'] ?? [];
$style = $data['style'] ?? 'cards';
$carouselId = 'testimonials_' . $section['section_id'];
?>
<section class="testimonials-section py-5 bg-light">
    <div class="container">
        <?php if (!empty($data['title'])): ?>
        <div class="text-center mb-5">
            <h2 class="fw-bold"><?php echo htmlspecialchars($data['title']); ?></h2>
        </div>
        <?php endif; ?>
        
        <?php if ($style == 'carousel'): ?>
        <div id="<?php echo $carouselId; ?>" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($items as $index => $item): ?>
                <div class="carousel-item <?php echo $index == 0 ? 'active' : ''; ?>">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 text-center">
                            <div class="mb-4">
                                <i class="bi bi-quote display-4 text-primary"></i>
                            </div>
                            <p class="lead mb-4"><?php echo htmlspecialchars($item['content'] ?? ''); ?></p>
                            <?php if (!empty($item['image'])): ?>
                            <img src="<?php echo base_url($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name'] ?? ''); ?>" 
                                 class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;">
                            <?php endif; ?>
                            <h5 class="mb-1"><?php echo htmlspecialchars($item['name'] ?? ''); ?></h5>
                            <p class="text-muted"><?php echo htmlspecialchars($item['role'] ?? ''); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php if (count($items) > 1): ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-primary rounded-circle p-3"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-primary rounded-circle p-3"></span>
            </button>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <div class="row g-4">
            <?php foreach ($items as $item): ?>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="card-text mb-4"><?php echo htmlspecialchars($item['content'] ?? ''); ?></p>
                        <div class="d-flex align-items-center">
                            <?php if (!empty($item['image'])): ?>
                            <img src="<?php echo base_url($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name'] ?? ''); ?>" 
                                 class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <?php else: ?>
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <span class="fw-bold"><?php echo strtoupper(substr($item['name'] ?? 'U', 0, 1)); ?></span>
                            </div>
                            <?php endif; ?>
                            <div>
                                <h6 class="mb-0"><?php echo htmlspecialchars($item['name'] ?? ''); ?></h6>
                                <small class="text-muted"><?php echo htmlspecialchars($item['role'] ?? ''); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
