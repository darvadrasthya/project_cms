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
		$this->load->model('PageSectionModel');
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

	// =========================================
	// PAGE BUILDER / SECTION MANAGEMENT
	// =========================================

	/**
	 * Page Builder - Edit sections
	 */
	public function builder($page_id)
	{
		$this->authorization->require_permission('page.update');

		$page = $this->PageModel->get_by_id($page_id);
		if (!$page) {
			show_404();
		}

		$sections = $this->PageSectionModel->get_by_page($page_id, false);
		$section_types = PageSectionModel::get_section_types();
		$layout_templates = PageSectionModel::get_layout_templates();
		$media = $this->MediaModel->get_images(100);

		$data = [
			'title' => 'Page Builder',
			'subtitle' => 'Design: ' . $page['title'],
			'page' => $page,
			'sections' => $sections,
			'section_types' => $section_types,
			'layout_templates' => $layout_templates,
			'media' => $media
		];

		$this->load->view('pages/builder', $data);
	}

	/**
	 * Update page layout settings
	 */
	public function update_layout($page_id)
	{
		$this->authorization->require_permission('page.update');

		$page = $this->PageModel->get_by_id($page_id);
		if (!$page) {
			$this->output_json(['success' => false, 'message' => 'Page not found']);
			return;
		}

		$layout_template = $this->input->post('layout_template') ?: 'full_width';
		$use_sections = $this->input->post('use_sections') ? 1 : 0;

		$this->PageModel->update($page_id, [
			'layout_template' => $layout_template,
			'use_sections' => $use_sections,
			'updated_by' => $this->auth->user_id(),
			'updated_at' => date('Y-m-d H:i:s')
		]);

		$this->output_json(['success' => true, 'message' => 'Layout updated']);
	}

	/**
	 * Add new section
	 */
	public function add_section($page_id)
	{
		$this->authorization->require_permission('page.update');

		$page = $this->PageModel->get_by_id($page_id);
		if (!$page) {
			$this->output_json(['success' => false, 'message' => 'Page not found']);
			return;
		}

		$section_type = $this->input->post('section_type');
		$section_types = PageSectionModel::get_section_types();

		if (!isset($section_types[$section_type])) {
			$this->output_json(['success' => false, 'message' => 'Invalid section type']);
			return;
		}

		$data = [
			'page_id' => $page_id,
			'section_type' => $section_type,
			'section_title' => $section_types[$section_type]['name'],
			'section_data' => [],
			'is_active' => 1
		];

		$section_id = $this->PageSectionModel->create($data);

		if ($section_id) {
			$section = $this->PageSectionModel->get_by_id($section_id);
			$this->output_json([
				'success' => true,
				'message' => 'Section added',
				'section' => $section,
				'section_type_info' => $section_types[$section_type]
			]);
		} else {
			$this->output_json(['success' => false, 'message' => 'Failed to add section']);
		}
	}

	/**
	 * Update section
	 */
	public function update_section($section_id)
	{
		$this->authorization->require_permission('page.update');

		$section = $this->PageSectionModel->get_by_id($section_id);
		if (!$section) {
			$this->output_json(['success' => false, 'message' => 'Section not found']);
			return;
		}

		$section_data = $this->input->post('section_data');
		if (is_string($section_data)) {
			$section_data = json_decode($section_data, true);
		}

		$update_data = [
			'section_title' => $this->input->post('section_title') ?: $section['section_title'],
			'section_data' => $section_data ?: []
		];

		if ($this->PageSectionModel->update($section_id, $update_data)) {
			$this->output_json(['success' => true, 'message' => 'Section updated']);
		} else {
			$this->output_json(['success' => false, 'message' => 'Failed to update section']);
		}
	}

	/**
	 * Delete section
	 */
	public function delete_section($section_id)
	{
		$this->authorization->require_permission('page.update');

		$section = $this->PageSectionModel->get_by_id($section_id);
		if (!$section) {
			$this->output_json(['success' => false, 'message' => 'Section not found']);
			return;
		}

		if ($this->PageSectionModel->delete($section_id)) {
			$this->output_json(['success' => true, 'message' => 'Section deleted']);
		} else {
			$this->output_json(['success' => false, 'message' => 'Failed to delete section']);
		}
	}

	/**
	 * Reorder sections
	 */
	public function reorder_sections($page_id)
	{
		$this->authorization->require_permission('page.update');

		$section_ids = $this->input->post('section_ids');
		if (!is_array($section_ids)) {
			$section_ids = json_decode($section_ids, true);
		}

		if ($this->PageSectionModel->reorder($page_id, $section_ids)) {
			$this->output_json(['success' => true, 'message' => 'Sections reordered']);
		} else {
			$this->output_json(['success' => false, 'message' => 'Failed to reorder sections']);
		}
	}

	/**
	 * Toggle section active status
	 */
	public function toggle_section($section_id)
	{
		$this->authorization->require_permission('page.update');

		if ($this->PageSectionModel->toggle_active($section_id)) {
			$section = $this->PageSectionModel->get_by_id($section_id);
			$this->output_json([
				'success' => true,
				'message' => $section['is_active'] ? 'Section enabled' : 'Section disabled',
				'is_active' => $section['is_active']
			]);
		} else {
			$this->output_json(['success' => false, 'message' => 'Failed to toggle section']);
		}
	}

	/**
	 * Duplicate section
	 */
	public function duplicate_section($section_id)
	{
		$this->authorization->require_permission('page.update');

		$new_section_id = $this->PageSectionModel->duplicate($section_id);
		
		if ($new_section_id) {
			$section = $this->PageSectionModel->get_by_id($new_section_id);
			$section_types = PageSectionModel::get_section_types();
			
			$this->output_json([
				'success' => true,
				'message' => 'Section duplicated',
				'section' => $section,
				'section_type_info' => $section_types[$section['section_type']] ?? null
			]);
		} else {
			$this->output_json(['success' => false, 'message' => 'Failed to duplicate section']);
		}
	}

	/**
	 * Move section up
	 */
	public function move_section_up($section_id)
	{
		$this->authorization->require_permission('page.update');

		if ($this->PageSectionModel->move_up($section_id)) {
			$this->output_json(['success' => true, 'message' => 'Section moved up']);
		} else {
			$this->output_json(['success' => false, 'message' => 'Cannot move section up']);
		}
	}

	/**
	 * Move section down
	 */
	public function move_section_down($section_id)
	{
		$this->authorization->require_permission('page.update');

		if ($this->PageSectionModel->move_down($section_id)) {
			$this->output_json(['success' => true, 'message' => 'Section moved down']);
		} else {
			$this->output_json(['success' => false, 'message' => 'Cannot move section down']);
		}
	}

	/**
	 * Get section form (AJAX)
	 */
	public function get_section_form($section_id)
	{
		$section = $this->PageSectionModel->get_by_id($section_id);
		if (!$section) {
			$this->output_json(['success' => false, 'message' => 'Section not found']);
			return;
		}

		$section_types = PageSectionModel::get_section_types();
		$media = $this->MediaModel->get_images(100);

		$data = [
			'section' => $section,
			'section_type_info' => $section_types[$section['section_type']] ?? null,
			'media' => $media
		];

		$html = $this->load->view('pages/sections/form_' . $section['section_type'], $data, true);
		
		$this->output_json([
			'success' => true,
			'html' => $html,
			'section' => $section
		]);
	}

	/**
	 * Preview page with sections
	 */
	public function preview($page_id)
	{
		$page = $this->PageModel->get_by_id($page_id);
		if (!$page) {
			show_404();
		}

		$sections = $this->PageSectionModel->get_by_page($page_id);

		$data = [
			'page' => $page,
			'sections' => $sections,
			'preview_mode' => true
		];

		$this->load->view('pages/preview', $data);
	}
}
