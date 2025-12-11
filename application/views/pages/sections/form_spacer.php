<?php
/**
 * Spacer / Divider Section Form
 * Fields: height, show_divider, divider_style
 */
$data = $section['section_data'] ?? [];
?>
<form id="section-edit-form">
    <div class="mb-3">
        <label class="form-label">Section Title (Internal)</label>
        <input type="text" name="section_title" class="form-control" 
               value="<?php echo htmlspecialchars($section['section_title'] ?? ''); ?>">
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Height</label>
                <select name="data[height]" class="form-select">
                    <option value="20" <?php echo ($data['height'] ?? '') == '20' ? 'selected' : ''; ?>>20px (XS)</option>
                    <option value="40" <?php echo ($data['height'] ?? '') == '40' ? 'selected' : ''; ?>>40px (Small)</option>
                    <option value="60" <?php echo ($data['height'] ?? '60') == '60' ? 'selected' : ''; ?>>60px (Medium)</option>
                    <option value="80" <?php echo ($data['height'] ?? '') == '80' ? 'selected' : ''; ?>>80px (Large)</option>
                    <option value="100" <?php echo ($data['height'] ?? '') == '100' ? 'selected' : ''; ?>>100px (XL)</option>
                    <option value="150" <?php echo ($data['height'] ?? '') == '150' ? 'selected' : ''; ?>>150px (XXL)</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Show Divider</label>
                <select name="data[show_divider]" class="form-select">
                    <option value="0" <?php echo ($data['show_divider'] ?? '0') == '0' ? 'selected' : ''; ?>>No</option>
                    <option value="1" <?php echo ($data['show_divider'] ?? '') == '1' ? 'selected' : ''; ?>>Yes</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Divider Style</label>
                <select name="data[divider_style]" class="form-select">
                    <option value="solid" <?php echo ($data['divider_style'] ?? 'solid') == 'solid' ? 'selected' : ''; ?>>Solid Line</option>
                    <option value="dashed" <?php echo ($data['divider_style'] ?? '') == 'dashed' ? 'selected' : ''; ?>>Dashed Line</option>
                    <option value="dotted" <?php echo ($data['divider_style'] ?? '') == 'dotted' ? 'selected' : ''; ?>>Dotted Line</option>
                    <option value="double" <?php echo ($data['divider_style'] ?? '') == 'double' ? 'selected' : ''; ?>>Double Line</option>
                </select>
            </div>
        </div>
    </div>
</form>
