<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Public Footer Template
 * Variables: $site_name, $footer_menu
 */
?>
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <!-- Brand & Description -->
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="footer-brand">
                        <?php if(!empty($site_logo)): ?>
                            <img src="<?php echo base_url('upload/' . $site_logo); ?>" alt="<?php echo htmlspecialchars($site_name ?? 'Logo'); ?>" style="max-height: 40px;" class="me-2">
                        <?php endif; ?>
                        <?php echo htmlspecialchars($site_name ?? 'Website'); ?>
                    </div>
                    <p class="mb-3">
                        <?php echo htmlspecialchars($site_description ?? 'Content Management System dengan fitur lengkap untuk mengelola website Anda.'); ?>
                    </p>
                    <div class="social-links">
                        <?php if(!empty($social_facebook)): ?>
                        <a href="<?php echo htmlspecialchars($social_facebook); ?>" target="_blank" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <?php endif; ?>
                        <?php if(!empty($social_twitter)): ?>
                        <a href="<?php echo htmlspecialchars($social_twitter); ?>" target="_blank" title="Twitter">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                        <?php endif; ?>
                        <?php if(!empty($social_instagram)): ?>
                        <a href="<?php echo htmlspecialchars($social_instagram); ?>" target="_blank" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <?php endif; ?>
                        <?php if(!empty($social_youtube)): ?>
                        <a href="<?php echo htmlspecialchars($social_youtube); ?>" target="_blank" title="YouTube">
                            <i class="bi bi-youtube"></i>
                        </a>
                        <?php endif; ?>
                        <?php if(empty($social_facebook) && empty($social_twitter) && empty($social_instagram) && empty($social_youtube)): ?>
                        <a href="#" title="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" title="Twitter"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Footer Menu -->
                <?php if(!empty($footer_menu)): ?>
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <h5 class="text-white mb-3">Quick Links</h5>
                    <ul class="footer-links">
                        <?php foreach($footer_menu as $item): ?>
                            <?php 
                            $item_title = $item['title'] ?? $item['label'] ?? '';
                            $item_url = $item['url'] ?? '#';
                            $item_target = $item['target'] ?? '_self';
                            ?>
                            <li>
                                <a href="<?php echo htmlspecialchars($item_url); ?>" target="<?php echo htmlspecialchars($item_target); ?>">
                                    <i class="bi bi-chevron-right me-1"></i>
                                    <?php echo htmlspecialchars($item_title); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                
                <!-- Contact Info -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-white mb-3">Contact Us</h5>
                    <ul class="footer-links">
                        <?php if(!empty($contact_address)): ?>
                        <li>
                            <i class="bi bi-geo-alt me-2"></i>
                            <?php echo htmlspecialchars($contact_address); ?>
                        </li>
                        <?php endif; ?>
                        <?php if(!empty($contact_email)): ?>
                        <li>
                            <a href="mailto:<?php echo htmlspecialchars($contact_email); ?>">
                                <i class="bi bi-envelope me-2"></i>
                                <?php echo htmlspecialchars($contact_email); ?>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(!empty($contact_phone)): ?>
                        <li>
                            <a href="tel:<?php echo htmlspecialchars($contact_phone); ?>">
                                <i class="bi bi-telephone me-2"></i>
                                <?php echo htmlspecialchars($contact_phone); ?>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(empty($contact_address) && empty($contact_email) && empty($contact_phone)): ?>
                        <li><i class="bi bi-geo-alt me-2"></i> Jakarta, Indonesia</li>
                        <li><a href="mailto:info@example.com"><i class="bi bi-envelope me-2"></i> info@example.com</a></li>
                        <li><a href="tel:+6281234567890"><i class="bi bi-telephone me-2"></i> +62 812-3456-7890</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="footer-bottom text-center">
                <p class="mb-0">
                    &copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($site_name ?? 'Website'); ?>. All rights reserved.
                    <?php if(!empty($footer_credit)): ?>
                    | <?php echo $footer_credit; ?>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </footer>
    
    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop" title="Back to top">
        <i class="bi bi-arrow-up"></i>
    </button>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Scroll to top functionality
        const scrollBtn = document.getElementById('scrollToTop');
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollBtn.classList.add('visible');
            } else {
                scrollBtn.classList.remove('visible');
            }
            
            // Navbar scroll effect
            const navbar = document.querySelector('.navbar');
            if (window.pageYOffset > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        scrollBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
    
    <?php if(isset($extra_js)): ?>
    <?php echo $extra_js; ?>
    <?php endif; ?>
</body>
</html>
