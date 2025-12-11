<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PageModel extends CI_Model
{
	private $table = 'PAGES';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get page by ID
	 */
	public function get_by_id($page_id)
	{
		$this->db->select('PAGES.*, MEDIA.file_path as featured_image_path, 
                          MEDIA.file_name as featured_image_name,
                          U1.username as created_by_name, U2.username as updated_by_name');
		$this->db->from($this->table);
		$this->db->join('MEDIA', 'PAGES.featured_image = MEDIA.media_id', 'left');
		$this->db->join('USERS U1', 'PAGES.created_by = U1.user_id', 'left');
		$this->db->join('USERS U2', 'PAGES.updated_by = U2.user_id', 'left');
		$this->db->where('PAGES.page_id', $page_id);
		return $this->db->get()->row_array();
	}

	/**
	 * Get page by slug
	 */
	public function get_by_slug($slug)
	{
		$this->db->select('PAGES.*, MEDIA.file_path as featured_image_path, 
                          MEDIA.file_name as featured_image_name,
                          U1.username as created_by_name');
		$this->db->from($this->table);
		$this->db->join('MEDIA', 'PAGES.featured_image = MEDIA.media_id', 'left');
		$this->db->join('USERS U1', 'PAGES.created_by = U1.user_id', 'left');
		$this->db->where('PAGES.slug', $slug);
		return $this->db->get()->row_array();
	}

	/**
	 * Get all pages
	 */
	public function get_all($status = null, $limit = null, $offset = null)
	{
		$this->db->select('PAGES.*, MEDIA.file_path as featured_image_path, 
                          U1.username as created_by_name');
		$this->db->from($this->table);
		$this->db->join('MEDIA', 'PAGES.featured_image = MEDIA.media_id', 'left');
		$this->db->join('USERS U1', 'PAGES.created_by = U1.user_id', 'left');

		if ($status) {
			$this->db->where('PAGES.status', $status);
		}

		$this->db->order_by('PAGES.created_at', 'DESC');

		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		return $this->db->get()->result_array();
	}

	/**
	 * Get published pages
	 */
	public function get_published($limit = null, $offset = null)
	{
		return $this->get_all('published', $limit, $offset);
	}

	/**
	 * Get published pages (alias)
	 */
	public function get_published_pages($limit = null, $offset = null)
	{
		return $this->get_published($limit, $offset);
	}

	/**
	 * Create new page
	 */
	public function create($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	/**
	 * Update page
	 */
	public function update($page_id, $data)
	{
		$this->db->where('page_id', $page_id);
		return $this->db->update($this->table, $data);
	}

	/**
	 * Delete page
	 */
	public function delete($page_id)
	{
		return $this->db->delete($this->table, ['page_id' => $page_id]);
	}

	/**
	 * Publish page
	 */
	public function publish($page_id, $user_id)
	{
		return $this->update($page_id, [
			'status' => 'published',
			'updated_by' => $user_id,
			'updated_at' => date('Y-m-d H:i:s')
		]);
	}

	/**
	 * Unpublish page
	 */
	public function unpublish($page_id, $user_id)
	{
		return $this->update($page_id, [
			'status' => 'draft',
			'updated_by' => $user_id,
			'updated_at' => date('Y-m-d H:i:s')
		]);
	}

	/**
	 * Count pages
	 */
	public function count_all($status = null)
	{
		if ($status) {
			$this->db->where('status', $status);
		}
		return $this->db->count_all_results($this->table);
	}

	/**
	 * Search pages
	 */
	public function search($keyword, $limit = null, $offset = null)
	{
		$this->db->select('PAGES.*, MEDIA.file_path as featured_image_path');
		$this->db->from($this->table);
		$this->db->join('MEDIA', 'PAGES.featured_image = MEDIA.media_id', 'left');
		$this->db->like('PAGES.title', $keyword);
		$this->db->or_like('PAGES.content', $keyword);
		$this->db->order_by('PAGES.created_at', 'DESC');

		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		return $this->db->get()->result_array();
	}

	/**
	 * Generate unique slug
	 */
	public function generate_slug($title, $exclude_page_id = null)
	{
		$slug = url_title($title, 'dash', true);
		$original_slug = $slug;
		$counter = 1;

		while ($this->slug_exists($slug, $exclude_page_id)) {
			$slug = $original_slug . '-' . $counter;
			$counter++;
		}

		return $slug;
	}

	/**
	 * Check if slug exists
	 */
	public function slug_exists($slug, $exclude_page_id = null)
	{
		$this->db->where('slug', $slug);
		if ($exclude_page_id) {
			$this->db->where('page_id !=', $exclude_page_id);
		}
		return $this->db->count_all_results($this->table) > 0;
	}
}
