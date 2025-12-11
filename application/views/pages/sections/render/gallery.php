<?php
/**
 * Gallery Section Render
 */
$data = $section['section_data'] ?? [];
$images = $data['images'] ?? [];
$columns = $data['columns'] ?? 3;
$gap = $data['gap'] ?? 2;
$lightbox = $data['lightbox'] ?? 1;

$colClass = 'col-md-4';
if ($columns == 2) $colClass = 'col-md-6';
if ($columns == 4) $colClass = 'col-md-3';
if ($columns == 6) $colClass = 'col-md-2';

$galleryId = 'gallery_' . $section['section_id'];
?>
<section class="gallery-section py-5">
    <div class="container">
        <div class="row g-<?php echo $gap; ?>" id="<?php echo $galleryId; ?>">
            <?php foreach ($images as $index => $image): ?>
            <div class="<?php echo $colClass; ?> col-6">
                <?php if ($lightbox): ?>
                <a href="<?php echo base_url($image); ?>" data-bs-toggle="modal" data-bs-target="#lightbox_<?php echo $galleryId; ?>" 
                   onclick="showLightbox('<?php echo base_url($image); ?>')">
                    <img src="<?php echo base_url($image); ?>" alt="Gallery image <?php echo $index + 1; ?>" 
                         class="img-fluid rounded" style="width: 100%; height: 200px; object-fit: cover; cursor: pointer;">
                </a>
                <?php else: ?>
                <img src="<?php echo base_url($image); ?>" alt="Gallery image <?php echo $index + 1; ?>" 
                     class="img-fluid rounded" style="width: 100%; height: 200px; object-fit: cover;">
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if ($lightbox && !empty($images)): ?>
<!-- Lightbox Modal -->
<div class="modal fade" id="lightbox_<?php echo $galleryId; ?>" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 text-center">
                <img src="" id="lightbox_img_<?php echo $galleryId; ?>" class="img-fluid" alt="">
            </div>
        </div>
    </div>
</div>
<script>
function showLightbox(src) {
    document.getElementById('lightbox_img_<?php echo $galleryId; ?>').src = src;
}
</script>
<?php endif; ?>
