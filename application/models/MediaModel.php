<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MediaModel extends CI_Model
{
	private $table = 'MEDIA';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get media by ID
	 */
	public function get_by_id($media_id)
	{
		$this->db->select('MEDIA.*, USERS.username as uploaded_by_name');
		$this->db->from($this->table);
		$this->db->join('USERS', 'MEDIA.uploaded_by = USERS.user_id', 'left');
		$this->db->where('MEDIA.media_id', $media_id);
		return $this->db->get()->row_array();
	}

	/**
	 * Get all media
	 */
	public function get_all($file_type = null, $limit = null, $offset = null)
	{
		$this->db->select('MEDIA.*, USERS.username as uploaded_by_name');
		$this->db->from($this->table);
		$this->db->join('USERS', 'MEDIA.uploaded_by = USERS.user_id', 'left');

		if ($file_type) {
			$this->db->where('MEDIA.file_type', $file_type);
		}

		$this->db->order_by('MEDIA.created_at', 'DESC');

		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		return $this->db->get()->result_array();
	}

	/**
	 * Get media by type
	 */
	public function get_by_type($file_type, $limit = null, $offset = null)
	{
		return $this->get_all($file_type, $limit, $offset);
	}

	/**
	 * Get images only
	 */
	public function get_images($limit = null, $offset = null)
	{
		$this->db->select('MEDIA.*, USERS.username as uploaded_by_name');
		$this->db->from($this->table);
		$this->db->join('USERS', 'MEDIA.uploaded_by = USERS.user_id', 'left');
		$this->db->where_in('MEDIA.file_type', ['image/jpeg', 'image/jpg', 'image/png', 'image/gif']);
		$this->db->order_by('MEDIA.created_at', 'DESC');

		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		return $this->db->get()->result_array();
	}

	/**
	 * Create new media
	 */
	public function create($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	/**
	 * Update media
	 */
	public function update($media_id, $data)
	{
		$this->db->where('media_id', $media_id);
		return $this->db->update($this->table, $data);
	}

	/**
	 * Delete media
	 */
	public function delete($media_id)
	{
		return $this->db->delete($this->table, ['media_id' => $media_id]);
	}

	/**
	 * Count all media
	 */
	public function count_all($file_type = null)
	{
		if ($file_type) {
			$this->db->where('file_type', $file_type);
		}
		return $this->db->count_all_results($this->table);
	}

	/**
	 * Get total storage used
	 */
	public function get_total_storage()
	{
		$this->db->select_sum('file_size');
		$result = $this->db->get($this->table)->row_array();
		return $result['file_size'] ? $result['file_size'] : 0;
	}

	/**
	 * Search media
	 */
	public function search($keyword, $limit = null, $offset = null)
	{
		$this->db->select('MEDIA.*, USERS.username as uploaded_by_name');
		$this->db->from($this->table);
		$this->db->join('USERS', 'MEDIA.uploaded_by = USERS.user_id', 'left');
		$this->db->like('MEDIA.file_name', $keyword);
		$this->db->order_by('MEDIA.created_at', 'DESC');

		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		return $this->db->get()->result_array();
	}

	/**
	 * Get media by user
	 */
	public function get_by_user($user_id, $limit = null, $offset = null)
	{
		$this->db->where('uploaded_by', $user_id);
		$this->db->order_by('created_at', 'DESC');

		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		return $this->db->get($this->table)->result_array();
	}
}
