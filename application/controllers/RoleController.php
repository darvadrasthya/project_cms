<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RoleController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('MY_Auth', null, 'auth');
        $this->load->library('MY_Authorization', null, 'authorization');
        $this->load->model('RoleModel');
        $this->load->model('PermissionModel');

        // Require login
        $this->auth->require_login();
        
        // Require permission - only Super Admin can manage roles
        $this->authorization->require_permission('role.manage');
    }

    public function index()
    {
        $roles = $this->RoleModel->get_all();

        // Get permission and user counts for each role
        foreach ($roles as &$role) {
            $role['permission_count'] = $this->RoleModel->count_permissions($role['role_id']);
            $role['user_count'] = $this->RoleModel->count_users($role['role_id']);
        }

        $data = [
            'title' => 'Roles',
            'roles' => $roles
        ];

        $this->load->view('roles/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create Role'
        ];

        $this->load->view('roles/form', $data);
    }

    public function store()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('role_name', 'Role Name', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
            return;
        }

        $data = [
            'role_name' => $this->input->post('role_name'),
            'description' => $this->input->post('description'),
            'is_system' => 0
        ];

        if ($this->RoleModel->create($data)) {
            $this->session->set_flashdata('success', 'Role created successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to create role');
        }

        redirect('roles');
    }

    public function edit($id)
    {
        $role = $this->RoleModel->get_by_id($id);

        if (!$role) {
            $this->session->set_flashdata('error', 'Role not found');
            redirect('roles');
        }

        $data = [
            'title' => 'Edit Role',
            'role' => $role
        ];

        $this->load->view('roles/form', $data);
    }

    public function update($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('role_name', 'Role Name', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
            return;
        }

        $data = [
            'role_name' => $this->input->post('role_name'),
            'description' => $this->input->post('description')
        ];

        if ($this->RoleModel->update($id, $data)) {
            $this->session->set_flashdata('success', 'Role updated successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to update role');
        }

        redirect('roles');
    }

    public function delete($id)
    {
        $role = $this->RoleModel->get_by_id($id);

        if (!$role) {
            $this->session->set_flashdata('error', 'Role not found');
            redirect('roles');
        }

        // Prevent deletion of system roles
        if (isset($role['is_system']) && $role['is_system']) {
            $this->session->set_flashdata('error', 'Cannot delete system role');
            redirect('roles');
        }

        if ($this->RoleModel->delete($id)) {
            $this->session->set_flashdata('success', 'Role deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete role');
        }

        redirect('roles');
    }

    public function permissions($id)
    {
        $role = $this->RoleModel->get_by_id($id);

        if (!$role) {
            $this->session->set_flashdata('error', 'Role not found');
            redirect('roles');
        }

        $data = [
            'title' => 'Manage Permissions',
            'role' => $role,
            'permissions' => $this->PermissionModel->get_all(),
            'role_permissions' => $this->RoleModel->get_permission_ids($id)
        ];

        $this->load->view('roles/permissions', $data);
    }

    public function update_permissions($id)
    {
        $permissions = $this->input->post('permissions') ?? [];

        // Clear existing permissions
        $this->RoleModel->clear_permissions($id);

        // Add new permissions
        foreach ($permissions as $permission_id) {
            $this->RoleModel->add_permission($id, $permission_id);
        }

        $this->session->set_flashdata('success', 'Permissions updated successfully');
        redirect('roles');
    }
}
