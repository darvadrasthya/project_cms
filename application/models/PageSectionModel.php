<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PageSectionModel extends CI_Model
{
    private $table = 'PAGE_SECTIONS';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all sections for a page
     */
    public function get_by_page($page_id, $active_only = true)
    {
        $this->db->where('page_id', $page_id);
        
        if ($active_only) {
            $this->db->where('is_active', 1);
        }
        
        $this->db->order_by('section_order', 'ASC');
        $result = $this->db->get($this->table)->result_array();
        
        // Decode JSON data
        foreach ($result as &$section) {
            $section['section_data'] = json_decode($section['section_data'], true) ?? [];
        }
        
        return $result;
    }

    /**
     * Get section by ID
     */
    public function get_by_id($section_id)
    {
        $section = $this->db->get_where($this->table, ['section_id' => $section_id])->row_array();
        
        if ($section) {
            $section['section_data'] = json_decode($section['section_data'], true) ?? [];
        }
        
        return $section;
    }

    /**
     * Create new section
     */
    public function create($data)
    {
        // Encode section_data if array
        if (isset($data['section_data']) && is_array($data['section_data'])) {
            $data['section_data'] = json_encode($data['section_data']);
        }
        
        // Get next order number
        if (!isset($data['section_order'])) {
            $data['section_order'] = $this->get_next_order($data['page_id']);
        }
        
        $data['created_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update section
     */
    public function update($section_id, $data)
    {
        // Encode section_data if array
        if (isset($data['section_data']) && is_array($data['section_data'])) {
            $data['section_data'] = json_encode($data['section_data']);
        }
        
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('section_id', $section_id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete section
     */
    public function delete($section_id)
    {
        return $this->db->delete($this->table, ['section_id' => $section_id]);
    }

    /**
     * Delete all sections for a page
     */
    public function delete_by_page($page_id)
    {
        return $this->db->delete($this->table, ['page_id' => $page_id]);
    }

    /**
     * Update section order
     */
    public function update_order($section_id, $new_order)
    {
        $this->db->where('section_id', $section_id);
        return $this->db->update($this->table, ['section_order' => $new_order]);
    }

    /**
     * Reorder sections (bulk update)
     */
    public function reorder($page_id, $section_ids)
    {
        $this->db->trans_start();
        
        foreach ($section_ids as $order => $section_id) {
            $this->db->where('section_id', $section_id);
            $this->db->where('page_id', $page_id);
            $this->db->update($this->table, ['section_order' => $order + 1]);
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Toggle section active status
     */
    public function toggle_active($section_id)
    {
        $section = $this->get_by_id($section_id);
        if (!$section) return false;
        
        $new_status = $section['is_active'] ? 0 : 1;
        
        $this->db->where('section_id', $section_id);
        return $this->db->update($this->table, ['is_active' => $new_status]);
    }

    /**
     * Duplicate a section
     */
    public function duplicate($section_id)
    {
        $section = $this->get_by_id($section_id);
        if (!$section) return false;
        
        unset($section['section_id']);
        $section['section_title'] = $section['section_title'] . ' (Copy)';
        $section['section_order'] = $this->get_next_order($section['page_id']);
        
        return $this->create($section);
    }

    /**
     * Get next order number for page
     */
    private function get_next_order($page_id)
    {
        $this->db->select_max('section_order');
        $this->db->where('page_id', $page_id);
        $result = $this->db->get($this->table)->row();
        
        return ($result->section_order ?? 0) + 1;
    }

    /**
     * Move section up
     */
    public function move_up($section_id)
    {
        $section = $this->get_by_id($section_id);
        if (!$section || $section['section_order'] <= 1) return false;
        
        // Get section above
        $this->db->where('page_id', $section['page_id']);
        $this->db->where('section_order <', $section['section_order']);
        $this->db->order_by('section_order', 'DESC');
        $this->db->limit(1);
        $above = $this->db->get($this->table)->row_array();
        
        if ($above) {
            $this->db->trans_start();
            $this->update_order($section_id, $above['section_order']);
            $this->update_order($above['section_id'], $section['section_order']);
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
        
        return false;
    }

    /**
     * Move section down
     */
    public function move_down($section_id)
    {
        $section = $this->get_by_id($section_id);
        if (!$section) return false;
        
        // Get section below
        $this->db->where('page_id', $section['page_id']);
        $this->db->where('section_order >', $section['section_order']);
        $this->db->order_by('section_order', 'ASC');
        $this->db->limit(1);
        $below = $this->db->get($this->table)->row_array();
        
        if ($below) {
            $this->db->trans_start();
            $this->update_order($section_id, $below['section_order']);
            $this->update_order($below['section_id'], $section['section_order']);
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
        
        return false;
    }

    /**
     * Get available section types
     */
    public static function get_section_types()
    {
        return [
            'hero' => [
                'name' => 'Hero Section',
                'icon' => 'bi-card-heading',
                'description' => 'Large banner with title, subtitle, and call-to-action button',
                'fields' => ['title', 'subtitle', 'bg_image', 'bg_color', 'text_color', 'btn_text', 'btn_link', 'btn_style', 'overlay_opacity', 'height']
            ],
            'text_block' => [
                'name' => 'Text Block',
                'icon' => 'bi-text-paragraph',
                'description' => 'Rich text content with formatting',
                'fields' => ['content', 'bg_color', 'text_align', 'padding']
            ],
            'image_text' => [
                'name' => 'Image + Text',
                'icon' => 'bi-layout-split',
                'description' => 'Image with text content side by side',
                'fields' => ['image', 'title', 'content', 'image_position', 'btn_text', 'btn_link']
            ],
            'gallery' => [
                'name' => 'Image Gallery',
                'icon' => 'bi-images',
                'description' => 'Grid of images with lightbox',
                'fields' => ['images', 'columns', 'gap', 'lightbox']
            ],
            'features' => [
                'name' => 'Features Grid',
                'icon' => 'bi-grid-3x3-gap',
                'description' => 'Feature cards with icons',
                'fields' => ['title', 'subtitle', 'items', 'columns', 'style']
            ],
            'testimonials' => [
                'name' => 'Testimonials',
                'icon' => 'bi-chat-quote',
                'description' => 'Customer testimonials carousel',
                'fields' => ['title', 'items', 'style', 'autoplay']
            ],
            'cta' => [
                'name' => 'Call to Action',
                'icon' => 'bi-megaphone',
                'description' => 'Prominent call-to-action section',
                'fields' => ['title', 'subtitle', 'btn_text', 'btn_link', 'bg_color', 'text_color']
            ],
            'faq' => [
                'name' => 'FAQ Accordion',
                'icon' => 'bi-question-circle',
                'description' => 'Frequently asked questions accordion',
                'fields' => ['title', 'items']
            ],
            'team' => [
                'name' => 'Team Members',
                'icon' => 'bi-people',
                'description' => 'Team member cards grid',
                'fields' => ['title', 'subtitle', 'items', 'columns']
            ],
            'stats' => [
                'name' => 'Statistics',
                'icon' => 'bi-graph-up',
                'description' => 'Counter/statistics section',
                'fields' => ['title', 'items', 'bg_color', 'animate']
            ],
            'video' => [
                'name' => 'Video Embed',
                'icon' => 'bi-play-circle',
                'description' => 'YouTube or Vimeo video embed',
                'fields' => ['title', 'video_url', 'aspect_ratio']
            ],
            'contact_form' => [
                'name' => 'Contact Form',
                'icon' => 'bi-envelope',
                'description' => 'Contact form with customizable fields',
                'fields' => ['title', 'subtitle', 'fields', 'submit_text', 'success_message']
            ],
            'pricing' => [
                'name' => 'Pricing Table',
                'icon' => 'bi-currency-dollar',
                'description' => 'Pricing plans comparison',
                'fields' => ['title', 'subtitle', 'items', 'columns']
            ],
            'spacer' => [
                'name' => 'Spacer / Divider',
                'icon' => 'bi-distribute-vertical',
                'description' => 'Empty space or divider line',
                'fields' => ['height', 'show_divider', 'divider_style']
            ],
            'html_block' => [
                'name' => 'Custom HTML',
                'icon' => 'bi-code-slash',
                'description' => 'Custom HTML code block',
                'fields' => ['html_content']
            ]
        ];
    }

    /**
     * Get layout templates
     */
    public static function get_layout_templates()
    {
        return [
            'full_width' => [
                'name' => 'Full Width',
                'icon' => 'bi-square',
                'description' => 'Content spans full width'
            ],
            'boxed' => [
                'name' => 'Boxed',
                'icon' => 'bi-bounding-box',
                'description' => 'Content in centered container'
            ],
            'sidebar_left' => [
                'name' => 'Sidebar Left',
                'icon' => 'bi-layout-sidebar',
                'description' => 'Content with left sidebar'
            ],
            'sidebar_right' => [
                'name' => 'Sidebar Right',
                'icon' => 'bi-layout-sidebar-reverse',
                'description' => 'Content with right sidebar'
            ],
            'landing' => [
                'name' => 'Landing Page',
                'icon' => 'bi-window',
                'description' => 'Full width sections, no header margin'
            ]
        ];
    }
}
