<?php
/**
 * Team Members Section Form
 * Fields: title, subtitle, items (array), columns
 */
$data = $section['section_data'] ?? [];
$items = $data['items'] ?? [
    ['name' => 'John Doe', 'role' => 'CEO', 'image' => '', 'bio' => '', 'social' => []],
];
?>
<form id="section-edit-form">
    <div class="mb-3">
        <label class="form-label">Section Title (Internal)</label>
        <input type="text" name="section_title" class="form-control" 
               value="<?php echo htmlspecialchars($section['section_title'] ?? ''); ?>">
    </div>
    
    <div class="row">
        <div class="col-md-5">
            <div class="mb-3">
                <label class="form-label">Section Heading</label>
                <input type="text" name="data[title]" class="form-control" 
                       value="<?php echo htmlspecialchars($data['title'] ?? ''); ?>" placeholder="Our Team">
            </div>
        </div>
        <div class="col-md-5">
            <div class="mb-3">
                <label class="form-label">Subtitle</label>
                <input type="text" name="data[subtitle]" class="form-control" 
                       value="<?php echo htmlspecialchars($data['subtitle'] ?? ''); ?>" placeholder="Meet the experts">
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-3">
                <label class="form-label">Columns</label>
                <select name="data[columns]" class="form-select">
                    <option value="3" <?php echo ($data['columns'] ?? '3') == '3' ? 'selected' : ''; ?>>3</option>
                    <option value="4" <?php echo ($data['columns'] ?? '') == '4' ? 'selected' : ''; ?>>4</option>
                </select>
            </div>
        </div>
    </div>
    
    <hr>
    <h6 class="mb-3"><i class="bi bi-people me-2"></i>Team Members</h6>
    
    <div id="team-container">
        <?php foreach ($items as $index => $item): ?>
        <div class="team-item card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-2">
                            <input type="text" name="data[items][<?php echo $index; ?>][name]" class="form-control form-control-sm" 
                                   value="<?php echo htmlspecialchars($item['name'] ?? ''); ?>" placeholder="Name">
                        </div>
                        <div class="mb-2">
                            <input type="text" name="data[items][<?php echo $index; ?>][role]" class="form-control form-control-sm" 
                                   value="<?php echo htmlspecialchars($item['role'] ?? ''); ?>" placeholder="Role">
                        </div>
                        <div class="mb-2">
                            <input type="text" name="data[items][<?php echo $index; ?>][image]" class="form-control form-control-sm" 
                                   value="<?php echo htmlspecialchars($item['image'] ?? ''); ?>" placeholder="Image URL">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <textarea name="data[items][<?php echo $index; ?>][bio]" class="form-control form-control-sm" rows="4" 
                                  placeholder="Short bio"><?php echo htmlspecialchars($item['bio'] ?? ''); ?></textarea>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="data[items][<?php echo $index; ?>][social_linkedin]" class="form-control form-control-sm mb-2" 
                               value="<?php echo htmlspecialchars($item['social_linkedin'] ?? ''); ?>" placeholder="LinkedIn URL">
                        <input type="text" name="data[items][<?php echo $index; ?>][social_twitter]" class="form-control form-control-sm mb-2" 
                               value="<?php echo htmlspecialchars($item['social_twitter'] ?? ''); ?>" placeholder="Twitter URL">
                        <input type="text" name="data[items][<?php echo $index; ?>][social_email]" class="form-control form-control-sm" 
                               value="<?php echo htmlspecialchars($item['social_email'] ?? ''); ?>" placeholder="Email">
                    </div>
                </div>
                <div class="mt-2">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-team">
                        <i class="bi bi-trash me-1"></i>Remove
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-team">
        <i class="bi bi-plus me-1"></i>Add Team Member
    </button>
</form>

<script>
let teamIndex = <?php echo count($items); ?>;

document.getElementById('btn-add-team')?.addEventListener('click', function() {
    const container = document.getElementById('team-container');
    const html = `
        <div class="team-item card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-2">
                            <input type="text" name="data[items][${teamIndex}][name]" class="form-control form-control-sm" placeholder="Name">
                        </div>
                        <div class="mb-2">
                            <input type="text" name="data[items][${teamIndex}][role]" class="form-control form-control-sm" placeholder="Role">
                        </div>
                        <div class="mb-2">
                            <input type="text" name="data[items][${teamIndex}][image]" class="form-control form-control-sm" placeholder="Image URL">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <textarea name="data[items][${teamIndex}][bio]" class="form-control form-control-sm" rows="4" placeholder="Short bio"></textarea>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="data[items][${teamIndex}][social_linkedin]" class="form-control form-control-sm mb-2" placeholder="LinkedIn URL">
                        <input type="text" name="data[items][${teamIndex}][social_twitter]" class="form-control form-control-sm mb-2" placeholder="Twitter URL">
                        <input type="text" name="data[items][${teamIndex}][social_email]" class="form-control form-control-sm" placeholder="Email">
                    </div>
                </div>
                <div class="mt-2">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-team">
                        <i class="bi bi-trash me-1"></i>Remove
                    </button>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    teamIndex++;
    bindRemoveTeamButtons();
});

function bindRemoveTeamButtons() {
    document.querySelectorAll('.btn-remove-team').forEach(btn => {
        btn.onclick = function() {
            this.closest('.team-item').remove();
        };
    });
}
bindRemoveTeamButtons();
</script>
