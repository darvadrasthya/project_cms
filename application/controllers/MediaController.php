<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MediaController extends CI_Controller
{
	private $upload_path = './upload/media/';
	private $allowed_types = 'gif|jpg|jpeg|png|pdf|doc|docx|xls|xlsx|zip';
	private $max_size = 5120; // 5MB

	public function __construct()
	{
		parent::__construct();
		$this->load->library('MY_Auth', null, 'auth');
		$this->load->library('MY_Authorization', null, 'authorization');
		$this->auth->require_login();

		$this->load->model('MediaModel');
		$this->load->model('CrudLogModel');
		$this->load->helper('form');

		// Create upload directory if not exists
		if (!is_dir($this->upload_path)) {
			mkdir($this->upload_path, 0755, true);
		}
	}

	/**
	 * Media library
	 */
	public function index()
	{
		$this->authorization->require_permission('media.upload');

		// Get filter
		$file_type = $this->input->get('type');

		// Pagination
		$this->load->library('pagination');

		$config['base_url'] = site_url('media');
		$config['total_rows'] = $this->MediaModel->count_all($file_type);
		$config['per_page'] = 24;
		$config['uri_segment'] = 2;

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

		// Get media
		if ($file_type == 'image') {
			$media = $this->MediaModel->get_images($config['per_page'], $page);
		} else {
			$media = $this->MediaModel->get_all($file_type, $config['per_page'], $page);
		}

		$data = [
			'title' => 'Media Library',
			'subtitle' => 'Manage Media Files',
			'media' => $media,
			'pagination' => $this->pagination->create_links(),
			'current_type' => $file_type
		];

		$this->load->view('media/index', $data);
	}

	/**
	 * Upload media
	 */
	public function upload()
	{
		$this->authorization->require_permission('media.upload');

		$this->load->library('upload');

		$config['upload_path'] = $this->upload_path;
		$config['allowed_types'] = $this->allowed_types;
		$config['max_size'] = $this->max_size;
		$config['encrypt_name'] = true;

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file')) {
			$this->output_json([
				'success' => false,
				'message' => $this->upload->display_errors('', '')
			]);
			return;
		}

		$upload_data = $this->upload->data();

		// Save to database
		$data = [
			'file_name' => $upload_data['orig_name'],
			'file_path' => $this->upload_path . $upload_data['file_name'],
			'file_type' => $upload_data['file_type'],
			'file_size' => $upload_data['file_size'],
			'uploaded_by' => $this->auth->user_id(),
			'created_at' => date('Y-m-d H:i:s')
		];

		$media_id = $this->MediaModel->create($data);

		if ($media_id) {
			// Log activity
			$this->CrudLogModel->log('MEDIA', 'create', $media_id, null, $data, 'Media uploaded', $this->auth->user_id());

			$this->output_json([
				'success' => true,
				'message' => 'File uploaded successfully.',
				'media_id' => $media_id,
				'file' => array_merge($data, ['media_id' => $media_id])
			]);
		} else {
			// Delete uploaded file
			unlink($upload_data['full_path']);

			$this->output_json([
				'success' => false,
				'message' => 'Failed to save file information.'
			]);
		}
	}

	/**
	 * Delete media
	 */
	public function delete($media_id)
	{
		$this->authorization->require_permission('media.delete');

		$media = $this->MediaModel->get_by_id($media_id);

		if (!$media) {
			$this->output_json(['success' => false, 'message' => 'Media not found.']);
			return;
		}

		// Delete file
		if (file_exists($media['file_path'])) {
			unlink($media['file_path']);
		}

		// Delete from database
		if ($this->MediaModel->delete($media_id)) {
			// Log activity
			$this->CrudLogModel->log('MEDIA', 'delete', $media_id, $media, null, 'Media deleted', $this->auth->user_id());

			$this->output_json(['success' => true, 'message' => 'Media deleted successfully.']);
		} else {
			$this->output_json(['success' => false, 'message' => 'Failed to delete media.']);
		}
	}

	/**
	 * Get media by ID (AJAX)
	 */
	public function get($media_id)
	{
		$media = $this->MediaModel->get_by_id($media_id);

		if ($media) {
			$this->output_json(['success' => true, 'media' => $media]);
		} else {
			$this->output_json(['success' => false, 'message' => 'Media not found.']);
		}
	}

	/**
	 * Output JSON
	 */
	private function output_json($data)
	{
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}
}
