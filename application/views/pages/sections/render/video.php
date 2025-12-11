<?php
/**
 * Video Section Render
 */
$data = $section['section_data'] ?? [];
$videoUrl = $data['video_url'] ?? '';
$aspectRatio = $data['aspect_ratio'] ?? '16x9';

// Convert YouTube/Vimeo URL to embed URL
$embedUrl = '';
if (strpos($videoUrl, 'youtube.com') !== false || strpos($videoUrl, 'youtu.be') !== false) {
    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $videoUrl, $matches);
    if (!empty($matches[1])) {
        $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
    }
} elseif (strpos($videoUrl, 'vimeo.com') !== false) {
    preg_match('/vimeo\.com\/(\d+)/', $videoUrl, $matches);
    if (!empty($matches[1])) {
        $embedUrl = 'https://player.vimeo.com/video/' . $matches[1];
    }
}
?>
<section class="video-section py-5">
    <div class="container">
        <?php if (!empty($data['title'])): ?>
        <div class="text-center mb-4">
            <h2 class="fw-bold"><?php echo htmlspecialchars($data['title']); ?></h2>
        </div>
        <?php endif; ?>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php if ($embedUrl): ?>
                <div class="ratio ratio-<?php echo $aspectRatio; ?>">
                    <iframe src="<?php echo $embedUrl; ?>" allowfullscreen class="rounded shadow"></iframe>
                </div>
                <?php else: ?>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>Invalid video URL. Please use a valid YouTube or Vimeo URL.
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
