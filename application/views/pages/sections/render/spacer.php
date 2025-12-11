<?php
/**
 * Spacer Section Render
 */
$data = $section['section_data'] ?? [];
$height = $data['height'] ?? 60;
$showDivider = $data['show_divider'] ?? '0';
$dividerStyle = $data['divider_style'] ?? 'solid';
?>
<div class="spacer-section" style="height: <?php echo $height; ?>px;">
    <?php if ($showDivider == '1'): ?>
    <div class="container h-100 d-flex align-items-center">
        <hr class="w-100" style="border-style: <?php echo $dividerStyle; ?>;">
    </div>
    <?php endif; ?>
</div>
