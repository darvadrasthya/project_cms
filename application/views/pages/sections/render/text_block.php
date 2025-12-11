<?php
/**
 * Text Block Section Render
 */
$data = $section['section_data'] ?? [];
$bgColor = $data['bg_color'] ?? '#ffffff';
$textAlign = $data['text_align'] ?? 'left';
$padding = $data['padding'] ?? 'medium';

$paddingClass = 'py-4';
if ($padding == 'small') $paddingClass = 'py-3';
if ($padding == 'large') $paddingClass = 'py-5';
?>
<section class="text-block-section <?php echo $paddingClass; ?>" style="background-color: <?php echo $bgColor; ?>;">
    <div class="container">
        <div class="text-<?php echo $textAlign; ?>">
            <?php echo $data['content'] ?? ''; ?>
        </div>
    </div>
</section>
