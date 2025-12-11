<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PageController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('MY_Auth', null, 'auth');
		$this->load->library('MY_Authorization', null, 'authorization');
		$this->auth->require_login();

		$this->load->model('PageModel');
		$this->load->model('MediaModel');
		$this->load->model('CrudLogModel');
		$this->load->helper('form');
		$this->load->library('form_validation');
	}

	/**
	 * List all pages
	 */
	public function index()
	{
		$this->authorization->require_permission('page.read');

		// Get filter
		$status = $this->input->get('status');

		// Pagination
		$this->load->library('pagination');

		$config['base_url'] = site_url('pages');
		$config['total_rows'] = $this->PageModel->count_all($status);
		$config['per_page'] = 20;
		$config['uri_segment'] = 2;

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

		// Get pages
		$pages = $this->PageModel->get_all($status, $config['per_page'], $page);

		$data = [
			'title' => 'Pages',
			'subtitle' => 'Manage Content Pages',
			'pages' => $pages,
			'pagination' => $this->pagination->create_links(),
			'current_status' => $status
		];

		$this->load->view('pages/index', $data);
	}

	/**
	 * View page
	 */
	public function view($page_id)
	{
		$this->authorization->require_permission('page.read');

		$page = $this->PageModel->get_by_id($page_id);

		if (!$page) {
			show_404();
		}

		$data = [
			'title' => 'View Page',
			'subtitle' => $page['title'],
			'page' => $page
		];

		$this->load->view('pages/view', $data);
	}

	/**
	 * Create page
	 */
	public function create()
	{
		$this->authorization->require_permission('page.create');

		if ($this->input->method() == 'post') {
			$this->form_validation->set_rules('title', 'Title', 'required|trim');
			$this->form_validation->set_rules('content', 'Content', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required|in_list[draft,published]');

			if ($this->form_validation->run()) {
				// Generate slug
				$slug = $this->PageModel->generate_slug($this->input->post('title'));

				$data = [
					'title' => $this->input->post('title'),
					'slug' => $slug,
					'content' => $this->input->post('content'),
					'featured_image' => $this->input->post('featured_image') ?: null,
					'status' => $this->input->post('status'),
					'created_by' => $this->auth->user_id(),
					'created_at' => date('Y-m-d H:i:s')
				];

				$page_id = $this->PageModel->create($data);

				if ($page_id) {
					// Log activity
					$this->CrudLogModel->log('PAGES', 'create', $page_id, null, $data, 'Page created', $this->auth->user_id());

					$this->session->set_flashdata('success', 'Page created successfully.');
					redirect('pages');
				}
			}
		}

		// Get media for featured image
		$media = $this->MediaModel->get_images(50);

		$data = [
			'title' => 'Create Page',
			'subtitle' => 'Add New Page',
			'media' => $media
		];

		$this->load->view('pages/create', $data);
	}

	/**
	 * Edit page
	 */
	public function edit($page_id)
	{
		$this->authorization->require_permission('page.update');

		$page = $this->PageModel->get_by_id($page_id);

		if (!$page) {
			show_404();
		}

		if ($this->input->method() == 'post') {
			$this->form_validation->set_rules('title', 'Title', 'required|trim');
			$this->form_validation->set_rules('content', 'Content', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required|in_list[draft,published]');

			if ($this->form_validation->run()) {
				$old_data = $page;

				// Check if slug needs update
				$slug = $page['slug'];
				if ($this->input->post('title') != $page['title']) {
					$slug = $this->PageModel->generate_slug($this->input->post('title'), $page_id);
				}

				$data = [
					'title' => $this->input->post('title'),
					'slug' => $slug,
					'content' => $this->input->post('content'),
					'featured_image' => $this->input->post('featured_image') ?: null,
					'status' => $this->input->post('status'),
					'updated_by' => $this->auth->user_id(),
					'updated_at' => date('Y-m-d H:i:s')
				];

				if ($this->PageModel->update($page_id, $data)) {
					// Log activity
					$this->CrudLogModel->log('PAGES', 'update', $page_id, $old_data, $data, 'Page updated', $this->auth->user_id());

					$this->session->set_flashdata('success', 'Page updated successfully.');
					redirect('pages');
				}
			}
		}

		// Get media for featured image
		$media = $this->MediaModel->get_images(50);

		$data = [
			'title' => 'Edit Page',
			'subtitle' => 'Update Page Content',
			'page' => $page,
			'media' => $media
		];

		$this->load->view('pages/edit', $data);
	}

	/**
	 * Delete page
	 */
	public function delete($page_id)
	{
		$this->authorization->require_permission('page.delete');

		$page = $this->PageModel->get_by_id($page_id);

		if (!$page) {
			$this->output_json(['success' => false, 'message' => 'Page not found.']);
			return;
		}

		if ($this->PageModel->delete($page_id)) {
			// Log activity
			$this->CrudLogModel->log('PAGES', 'delete', $page_id, $page, null, 'Page deleted', $this->auth->user_id());

			$this->output_json(['success' => true, 'message' => 'Page deleted successfully.']);
		} else {
			$this->output_json(['success' => false, 'message' => 'Failed to delete page.']);
		}
	}

	/**
	 * Publish page
	 */
	public function publish($page_id)
	{
		$this->authorization->require_permission('page.publish');

		if ($this->PageModel->publish($page_id, $this->auth->user_id())) {
			$this->output_json(['success' => true, 'message' => 'Page published successfully.']);
		} else {
			$this->output_json(['success' => false, 'message' => 'Failed to publish page.']);
		}
	}

	/**
	 * Unpublish page
	 */
	public function unpublish($page_id)
	{
		$this->authorization->require_permission('page.update');

		if ($this->PageModel->unpublish($page_id, $this->auth->user_id())) {
			$this->output_json(['success' => true, 'message' => 'Page unpublished successfully.']);
		} else {
			$this->output_json(['success' => false, 'message' => 'Failed to unpublish page.']);
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
