<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MenuController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('MY_Auth', null, 'auth');
        $this->load->library('MY_Authorization', null, 'authorization');
        $this->load->model('MenuModel');

        // Require login
        $this->auth->require_login();
        
        // Require permission - only Super Admin can manage menus
        $this->authorization->require_permission('menu.manage');
    }

    public function index()
    {
        $data = [
            'title' => 'Menus',
            'menus' => $this->MenuModel->get_all()
        ];

        $this->load->view('menus/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create Menu'
        ];

        $this->load->view('menus/form', $data);
    }

    public function store()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('menu_name', 'Menu Name', 'required|trim');
        $this->form_validation->set_rules('menu_location', 'Menu Location', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
            return;
        }

        $data = [
            'menu_name' => $this->input->post('menu_name'),
            'menu_location' => $this->input->post('menu_location'),
            'description' => $this->input->post('description'),
			'created_by' => $this->auth->user_id(),
			'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->MenuModel->create($data)) {
            $this->session->set_flashdata('success', 'Menu created successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to create menu');
        }

        redirect('menus');
    }

    public function edit($id)
    {
        $menu = $this->MenuModel->get_by_id($id);

        if (!$menu) {
            $this->session->set_flashdata('error', 'Menu not found');
            redirect('menus');
        }

        $data = [
            'title' => 'Edit Menu',
            'menu' => $menu
        ];

        $this->load->view('menus/form', $data);
    }

    public function update($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('menu_name', 'Menu Name', 'required|trim');
        $this->form_validation->set_rules('menu_location', 'Menu Location', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
            return;
        }

        $data = [
            'menu_name' => $this->input->post('menu_name'),
            'menu_location' => $this->input->post('menu_location'),
            'description' => $this->input->post('description'),
			'updated_by' => $this->auth->user_id(),
			'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->MenuModel->update($id, $data)) {
            $this->session->set_flashdata('success', 'Menu updated successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to update menu');
        }

        redirect('menus');
    }

    public function delete($id)
    {
        if ($this->MenuModel->delete($id)) {
            $this->session->set_flashdata('success', 'Menu deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete menu');
        }

        redirect('menus');
    }

    public function items($menu_id)
    {
        $menu = $this->MenuModel->get_by_id($menu_id);

        if (!$menu) {
            $this->session->set_flashdata('error', 'Menu not found');
            redirect('menus');
        }

        $data = [
            'title' => 'Menu Items: ' . $menu['menu_name'],
            'menu' => $menu,
            'items' => $this->MenuModel->get_items($menu_id)
        ];

        $this->load->view('menus/items', $data);
    }

    public function add_item($menu_id)
    {
        $menu = $this->MenuModel->get_by_id($menu_id);

        if (!$menu) {
            $this->session->set_flashdata('error', 'Menu not found');
            redirect('menus');
        }

        $data = [
            'title' => 'Add Menu Item',
            'menu' => $menu,
            'parent_items' => $this->MenuModel->get_items($menu_id)
        ];

        $this->load->view('menus/item_form', $data);
    }

    public function store_item($menu_id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('url', 'URL', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->add_item($menu_id);
            return;
        }

        $data = [
            'menu_id' => $menu_id,
            'parent_id' => $this->input->post('parent_id') ?: null,
            'title' => $this->input->post('title'),
            'url' => $this->input->post('url'),
            'target' => $this->input->post('target') ?: '_self',
            'icon' => $this->input->post('icon'),
            'sort_order' => $this->input->post('sort_order') ?: 0,
            'is_active' => $this->input->post('is_active') ? 1 : 0
        ];

        if ($this->MenuModel->create_item($data)) {
            $this->session->set_flashdata('success', 'Menu item added successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to add menu item');
        }

        redirect('menus/items/' . $menu_id);
    }

    public function delete_item($menu_id, $item_id)
    {
        if ($this->MenuModel->delete_item($item_id)) {
            $this->session->set_flashdata('success', 'Menu item deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete menu item');
        }

        redirect('menus/items/' . $menu_id);
    }

    /**
     * Preview menu
     */
    public function preview($menu_id)
    {
        $menu = $this->MenuModel->get_by_id($menu_id);

        if (!$menu) {
            show_404();
            return;
        }

        $data = [
            'title' => 'Preview: ' . $menu['menu_name'],
            'menu' => $menu,
            'menu_tree' => $this->MenuModel->get_menu_tree($menu_id)
        ];

        $this->load->view('menus/preview', $data);
    }
}
