<?php
/**
 * Custom HTML Block Section Render
 */
$data = $section['section_data'] ?? [];
?>
<section class="html-block-section">
    <?php echo $data['html_content'] ?? ''; ?>
</section>
