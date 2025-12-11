<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PermissionController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('MY_Auth', null, 'auth');
        $this->load->library('MY_Authorization', null, 'authorization');
        $this->load->model('PermissionModel');

        // Require login
        $this->auth->require_login();
        
        // Require permission - only Super Admin can manage permissions
        $this->authorization->require_permission('role.manage');
    }

    public function index()
    {
        $data = [
            'title' => 'Permissions',
            'permissions' => $this->PermissionModel->get_all()
        ];

        $this->load->view('permissions/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create Permission'
        ];

        $this->load->view('permissions/form', $data);
    }

    public function store()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('permission_desc', 'Permission Name', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
            return;
        }

        $data = [
            'permission_desc' => $this->input->post('permission_desc'),
            'description' => $this->input->post('description')
        ];

        if ($this->PermissionModel->create($data)) {
            $this->session->set_flashdata('success', 'Permission created successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to create permission');
        }

        redirect('permissions');
    }

    public function edit($id)
    {
        $permission = $this->PermissionModel->get_by_id($id);

        if (!$permission) {
            $this->session->set_flashdata('error', 'Permission not found');
            redirect('permissions');
        }

        $data = [
            'title' => 'Edit Permission',
            'permission' => $permission
        ];

        $this->load->view('permissions/form', $data);
    }

    public function update($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('permission_desc', 'Permission Name', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
            return;
        }

        $data = [
            'permission_desc' => $this->input->post('permission_desc'),
            'description' => $this->input->post('description')
        ];

        if ($this->PermissionModel->update($id, $data)) {
            $this->session->set_flashdata('success', 'Permission updated successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to update permission');
        }

        redirect('permissions');
    }

    public function delete($id)
    {
        if ($this->PermissionModel->delete($id)) {
            $this->session->set_flashdata('success', 'Permission deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete permission');
        }

        redirect('permissions');
    }
}
