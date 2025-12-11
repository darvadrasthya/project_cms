<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Public Homepage Template
 * Variables: $site_name, $site_logo, $header_menu, $footer_menu, $pages, $featured_pages
 */

// Load header
$this->load->view('public/header');
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content text-center">
            <h1 class="display-3 fw-bold mb-4">
                <?php echo htmlspecialchars($hero_title ?? 'Welcome to ' . ($site_name ?? 'Our Website')); ?>
            </h1>
            <p class="lead mb-4 mx-auto" style="max-width: 700px;">
                <?php echo htmlspecialchars($hero_subtitle ?? 'Discover amazing content and explore our pages. We provide quality information and services for you.'); ?>
            </p>
            <div class="hero-buttons">
                <?php if(!empty($hero_button_url)): ?>
                <a href="<?php echo htmlspecialchars($hero_button_url); ?>" class="btn btn-light btn-lg me-3">
                    <?php echo htmlspecialchars($hero_button_text ?? 'Get Started'); ?>
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
                <?php endif; ?>
                <?php if(!empty($hero_button2_url)): ?>
                <a href="<?php echo htmlspecialchars($hero_button2_url); ?>" class="btn btn-outline-light btn-lg">
                    <?php echo htmlspecialchars($hero_button2_text ?? 'Learn More'); ?>
                </a>
                <?php endif; ?>
                <?php if(empty($hero_button_url) && empty($hero_button2_url)): ?>
                <a href="#pages" class="btn btn-light btn-lg me-3">
                    Explore Pages
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
                <a href="#contact" class="btn btn-outline-light btn-lg">
                    Contact Us
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Featured Pages Section -->
<?php if(!empty($featured_pages)): ?>
<section class="content-section" id="featured">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Featured Content</h2>
            <p class="text-muted">Discover our most popular pages</p>
        </div>
        
        <div class="row g-4">
            <?php foreach($featured_pages as $fp): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100">
                    <?php if(!empty($fp['featured_image_path'])): ?>
                    <img src="<?php echo base_url('upload/' . $fp['featured_image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($fp['title']); ?>" style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                    <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, #667eea, #764ba2);">
                        <i class="bi bi-file-text text-white" style="font-size: 3rem;"></i>
                    </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($fp['title']); ?></h5>
                        <p class="card-text text-muted">
                            <?php echo htmlspecialchars(substr(strip_tags($fp['content']), 0, 120)); ?>...
                        </p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="<?php echo base_url('page/' . $fp['slug']); ?>" class="btn btn-primary w-100">
                            Read More <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- All Pages Section -->
<?php if(!empty($pages)): ?>
<section class="content-section bg-white" id="pages">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Pages</h2>
            <p class="text-muted">Browse all available pages</p>
        </div>
        
        <div class="row g-4">
            <?php foreach($pages as $pg): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-file-earmark-text text-white fs-4"></i>
                            </div>
                            <h5 class="card-title mb-0"><?php echo htmlspecialchars($pg['title']); ?></h5>
                        </div>
                        <p class="card-text text-muted small">
                            <?php 
                            $excerpt = strip_tags($pg['content']);
                            echo htmlspecialchars(strlen($excerpt) > 100 ? substr($excerpt, 0, 100) . '...' : $excerpt); 
                            ?>
                        </p>
                        <a href="<?php echo base_url('page/' . $pg['slug']); ?>" class="stretched-link"></a>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-muted">
                            <i class="bi bi-calendar me-1"></i>
                            <?php echo date('d M Y', strtotime($pg['created_at'])); ?>
                        </small>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA Section -->
<section class="content-section" id="contact" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 text-white">
                <h2 class="fw-bold mb-3">Ready to Get Started?</h2>
                <p class="lead mb-0">Contact us today and let's discuss how we can help you.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <?php if(!empty($contact_email)): ?>
                <a href="mailto:<?php echo htmlspecialchars($contact_email); ?>" class="btn btn-light btn-lg">
                    <i class="bi bi-envelope me-2"></i> Contact Us
                </a>
                <?php else: ?>
                <a href="mailto:info@example.com" class="btn btn-light btn-lg">
                    <i class="bi bi-envelope me-2"></i> Contact Us
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
// Load footer
$this->load->view('public/footer');
?>
