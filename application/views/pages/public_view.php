<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Public Page Detail Template
 * Variables: $page, $site_name, $site_logo, $header_menu, $footer_menu
 */

// Load header
$this->load->view('public/header');
?>

<!-- Page Header -->
<header class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0" style="background: transparent;">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>" class="text-white-50">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?php echo htmlspecialchars($page['title']); ?></li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold"><?php echo htmlspecialchars($page['title']); ?></h1>
        <p class="lead mb-0 mt-3">
            <span class="me-4">
                <i class="bi bi-calendar3 me-2"></i>
                <?php echo date('d F Y', strtotime($page['created_at'])); ?>
            </span>
            <?php if(!empty($page['created_by_name'])): ?>
            <span>
                <i class="bi bi-person me-2"></i>
                <?php echo htmlspecialchars($page['created_by_name']); ?>
            </span>
            <?php endif; ?>
        </p>
    </div>
</header>

<!-- Page Content -->
<main class="content-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php if(!empty($page['featured_image_path'])): ?>
                    <img src="<?php echo base_url('upload/' . $page['featured_image_path']); ?>" 
                         alt="<?php echo htmlspecialchars($page['title']); ?>" 
                         class="featured-image">
                <?php endif; ?>
                
                <div class="page-content">
                    <?php echo $page['content']; ?>
                </div>
                
                <!-- Share Buttons -->
                <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                    <a href="<?php echo base_url(); ?>" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Home
                    </a>
                    
                    <div class="share-buttons">
                        <span class="text-muted me-2">Share:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(current_url()); ?>" 
                           target="_blank" class="btn btn-sm btn-outline-secondary me-1" title="Share on Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(current_url()); ?>&text=<?php echo urlencode($page['title']); ?>" 
                           target="_blank" class="btn btn-sm btn-outline-secondary me-1" title="Share on Twitter">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                        <a href="https://wa.me/?text=<?php echo urlencode($page['title'] . ' - ' . current_url()); ?>" 
                           target="_blank" class="btn btn-sm btn-outline-secondary me-1" title="Share on WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <a href="mailto:?subject=<?php echo urlencode($page['title']); ?>&body=<?php echo urlencode('Check this out: ' . current_url()); ?>" 
                           class="btn btn-sm btn-outline-secondary" title="Share via Email">
                            <i class="bi bi-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Related Pages (if available) -->
<?php if(!empty($related_pages)): ?>
<section class="content-section bg-light">
    <div class="container">
        <h3 class="fw-bold mb-4">Related Pages</h3>
        <div class="row g-4">
            <?php foreach($related_pages as $rp): ?>
            <div class="col-md-4">
                <div class="card h-100">
                    <?php if(!empty($rp['featured_image_path'])): ?>
                    <img src="<?php echo base_url('upload/' . $rp['featured_image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($rp['title']); ?>" style="height: 150px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($rp['title']); ?></h5>
                        <a href="<?php echo base_url('page/' . $rp['slug']); ?>" class="btn btn-sm btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
// Load footer
$this->load->view('public/footer');
?>
