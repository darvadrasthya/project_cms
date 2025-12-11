-- =====================================================
-- PAGE BUILDER - Database Migration
-- Run this SQL to add Page Builder functionality
-- =====================================================

-- Add layout_template column to PAGES table
ALTER TABLE PAGES 
ADD COLUMN layout_template VARCHAR(50) DEFAULT 'full_width' AFTER content,
ADD COLUMN use_sections TINYINT(1) DEFAULT 0 AFTER layout_template;

-- Create PAGE_SECTIONS table
CREATE TABLE IF NOT EXISTS PAGE_SECTIONS (
    section_id INT AUTO_INCREMENT PRIMARY KEY,
    page_id INT NOT NULL,
    section_type VARCHAR(50) NOT NULL,
    section_title VARCHAR(255),
    section_data JSON,
    section_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_page_id (page_id),
    INDEX idx_section_order (section_order),
    FOREIGN KEY (page_id) REFERENCES PAGES(page_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- SECTION TYPES Reference:
-- =====================================================
-- hero          : Hero section with title, subtitle, background, CTA button
-- text_block    : Rich text content block
-- image_text    : Image with text (left/right)
-- gallery       : Image gallery grid
-- features      : Feature cards grid (icon, title, description)
-- testimonials  : Testimonial carousel
-- cta           : Call to action section
-- contact_form  : Contact form section
-- faq           : FAQ accordion
-- pricing       : Pricing table
-- team          : Team members grid
-- stats         : Statistics/counter section
-- video         : Video embed section
-- spacer        : Empty space / divider
-- =====================================================

-- Insert sample section for testing (optional)
-- INSERT INTO PAGE_SECTIONS (page_id, section_type, section_title, section_data, section_order) VALUES
-- (1, 'hero', 'Welcome', '{"title":"Welcome to Our Site","subtitle":"We provide the best solutions","bg_color":"#4A90A4","text_color":"#ffffff","btn_text":"Learn More","btn_link":"#about"}', 1);
