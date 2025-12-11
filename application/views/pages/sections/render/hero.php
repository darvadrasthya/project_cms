<?php
/**
 * Hero Section Render
 */
$data = $section['section_data'] ?? [];
$height = $data['height'] ?? 'auto';
$bgColor = $data['bg_color'] ?? '#4A90A4';
$textColor = $data['text_color'] ?? '#ffffff';
$bgImage = $data['bg_image'] ?? '';
$overlayOpacity = ($data['overlay_opacity'] ?? 50) / 100;

$style = "background-color: {$bgColor}; color: {$textColor};";
if ($height != 'auto') {
    $style .= " min-height: {$height};";
}
if ($bgImage) {
    $style .= " background-image: url('" . base_url($bgImage) . "'); background-size: cover; background-position: center;";
}
?>
<section class="hero-section position-relative d-flex align-items-center" style="<?php echo $style; ?>">
    <?php if ($bgImage && $overlayOpacity > 0): ?>
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0,0,0,<?php echo $overlayOpacity; ?>);"></div>
    <?php endif; ?>
    
    <div class="container position-relative py-5">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <?php if (!empty($data['title'])): ?>
                <h1 class="display-4 fw-bold mb-4"><?php echo htmlspecialchars($data['title']); ?></h1>
                <?php endif; ?>
                
                <?php if (!empty($data['subtitle'])): ?>
                <p class="lead mb-4"><?php echo htmlspecialchars($data['subtitle']); ?></p>
                <?php endif; ?>
                
                <?php if (!empty($data['btn_text'])): ?>
                <a href="<?php echo htmlspecialchars($data['btn_link'] ?? '#'); ?>" 
                   class="btn btn-<?php echo htmlspecialchars($data['btn_style'] ?? 'light'); ?> btn-lg px-5">
                    <?php echo htmlspecialchars($data['btn_text']); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
