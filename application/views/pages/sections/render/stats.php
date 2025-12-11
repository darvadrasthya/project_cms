<?php
/**
 * Statistics Section Render
 */
$data = $section['section_data'] ?? [];
$items = $data['items'] ?? [];
$bgColor = $data['bg_color'] ?? '#f8f9fa';
$animate = $data['animate'] ?? 1;
$sectionId = 'stats_' . $section['section_id'];
?>
<section class="stats-section py-5" style="background-color: <?php echo $bgColor; ?>;" id="<?php echo $sectionId; ?>">
    <div class="container">
        <?php if (!empty($data['title'])): ?>
        <div class="text-center mb-5">
            <h2 class="fw-bold"><?php echo htmlspecialchars($data['title']); ?></h2>
        </div>
        <?php endif; ?>
        
        <div class="row text-center g-4">
            <?php foreach ($items as $index => $item): ?>
            <div class="col-md-3 col-6">
                <div class="stat-item">
                    <div class="display-4 fw-bold text-primary">
                        <span class="stat-number" data-target="<?php echo $item['number'] ?? 0; ?>">
                            <?php echo $animate ? '0' : $item['number']; ?>
                        </span><?php echo htmlspecialchars($item['suffix'] ?? ''); ?>
                    </div>
                    <p class="text-muted mb-0"><?php echo htmlspecialchars($item['label'] ?? ''); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if ($animate): ?>
<script>
(function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateNumbers();
                observer.disconnect();
            }
        });
    }, { threshold: 0.5 });
    
    const section = document.getElementById('<?php echo $sectionId; ?>');
    if (section) observer.observe(section);
    
    function animateNumbers() {
        document.querySelectorAll('#<?php echo $sectionId; ?> .stat-number').forEach(el => {
            const target = parseInt(el.dataset.target);
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;
            
            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    el.textContent = target;
                    clearInterval(timer);
                } else {
                    el.textContent = Math.floor(current);
                }
            }, 16);
        });
    }
})();
</script>
<?php endif; ?>
