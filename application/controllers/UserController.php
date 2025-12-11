<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('MY_Auth', null, 'auth');
		$this->load->library('MY_Authorization', null, 'authorization');
		$this->auth->require_login();

		$this->load->model('UserModel');
		$this->load->model('RoleModel');
		$this->load->model('CrudLogModel');
		$this->load->helper('form');
		$this->load->library('form_validation');
	}

	/**
	 * List all users
	 */
	public function index()
	{
		$this->authorization->require_permission('user.read');

		// Pagination
		$this->load->library('pagination');

		$config['base_url'] = site_url('users');
		$config['total_rows'] = $this->UserModel->count_all();
		$config['per_page'] = 20;
		$config['uri_segment'] = 2;

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

		// Get users
		$users = $this->UserModel->get_users_with_roles($config['per_page'], $page);

		$data = [
			'title' => 'Users',
			'subtitle' => 'Manage System Users',
			'users' => $users,
			'pagination' => $this->pagination->create_links()
		];

		$this->load->view('users/index', $data);
	}

	/**
	 * View user details
	 */
	public function view($user_id)
	{
		$this->authorization->require_permission('user.read');

		$user = $this->UserModel->get_by_id($user_id);

		if (!$user) {
			show_404();
		}

		// Get user roles
		$roles = $this->RoleModel->get_user_roles($user_id);

		// Get user permissions
		$this->load->model('PermissionModel');
		$permissions = $this->PermissionModel->get_user_permissions($user_id);

		$data = [
			'title' => 'User Details',
			'subtitle' => $user['username'],
			'user' => $user,
			'roles' => $roles,
			'permissions' => $permissions
		];

		$this->load->view('users/view', $data);
	}

	/**
	 * Create new user
	 */
	public function create()
	{
		$this->authorization->require_permission('user.create');

		if ($this->input->method() == 'post') {
			$this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[4]|is_unique[USERS.username]');
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[USERS.email]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
			$this->form_validation->set_rules('is_active', 'Status', 'required|in_list[0,1]');

			if ($this->form_validation->run()) {
				// Hash password
				$hashed = $this->auth->hash_password($this->input->post('password'));

				$data = [
					'username' => $this->input->post('username'),
					'email' => $this->input->post('email'),
					'password_hash' => $hashed['hash'],
					'password_salt' => $hashed['salt'],
					'is_active' => $this->input->post('is_active'),
					'created_at' => date('Y-m-d H:i:s')
				];

				$user_id = $this->UserModel->create($data);

				if ($user_id) {
					// Assign roles
					$role_ids = $this->input->post('roles');
					if ($role_ids) {
						$this->RoleModel->sync_user_roles($user_id, $role_ids);
					}

					// Log activity
					$this->CrudLogModel->log('USERS', 'create', $user_id, null, $data, 'User created', $this->auth->user_id());

					$this->session->set_flashdata('success', 'User created successfully.');
					redirect('users');
				}
			}
		}

		// Get all roles
		$roles = $this->RoleModel->get_all();

		$data = [
			'title' => 'Create User',
			'subtitle' => 'Add New User',
			'roles' => $roles
		];

		$this->load->view('users/create', $data);
	}

	/**
	 * Edit user
	 */
	public function edit($user_id)
	{
		$this->authorization->require_permission('user.update');

		$user = $this->UserModel->get_by_id($user_id);

		if (!$user) {
			show_404();
		}

		if ($this->input->method() == 'post') {
			$this->form_validation->set_rules('username', 'Username', "required|trim|callback_username_check[$user_id]");
			$this->form_validation->set_rules('email', 'Email', "required|trim|valid_email|callback_email_check[$user_id]");
			$this->form_validation->set_rules('is_active', 'Status', 'required|in_list[0,1]');

			if ($this->form_validation->run()) {
				$old_data = $user;

				$data = [
					'username' => $this->input->post('username'),
					'email' => $this->input->post('email'),
					'is_active' => $this->input->post('is_active'),
					'updated_at' => date('Y-m-d H:i:s')
				];

				// Update password if provided
				$new_password = $this->input->post('password');
				if (!empty($new_password)) {
					$hashed = $this->auth->hash_password($new_password);
					$data['password_hash'] = $hashed['hash'];
					$data['password_salt'] = $hashed['salt'];
				}

				if ($this->UserModel->update($user_id, $data)) {
					// Update roles
					$role_ids = $this->input->post('roles');
					$this->RoleModel->sync_user_roles($user_id, $role_ids ? $role_ids : []);

					// Log activity
					$this->CrudLogModel->log('USERS', 'update', $user_id, $old_data, $data, 'User updated', $this->auth->user_id());

					$this->session->set_flashdata('success', 'User updated successfully.');
					redirect('users');
				}
			}
		}

		// Get all roles
		$roles = $this->RoleModel->get_all();

		// Get user roles
		$user_roles = $this->RoleModel->get_user_roles($user_id);
		$user_role_ids = array_column($user_roles, 'role_id');

		$data = [
			'title' => 'Edit User',
			'subtitle' => 'Update User Information',
			'user' => $user,
			'roles' => $roles,
			'user_role_ids' => $user_role_ids
		];

		$this->load->view('users/edit', $data);
	}

	/**
	 * Delete user
	 */
	public function delete($user_id)
	{
		$this->authorization->require_permission('user.delete');

		$user = $this->UserModel->get_by_id($user_id);

		if (!$user) {
			$this->output_json(['success' => false, 'message' => 'User not found.']);
			return;
		}

		// Cannot delete own account
		if ($user_id == $this->auth->user_id()) {
			$this->output_json(['success' => false, 'message' => 'You cannot delete your own account.']);
			return;
		}

		if ($this->UserModel->delete($user_id)) {
			// Log activity
			$this->CrudLogModel->log('USERS', 'delete', $user_id, $user, null, 'User deleted', $this->auth->user_id());

			$this->output_json(['success' => true, 'message' => 'User deleted successfully.']);
		} else {
			$this->output_json(['success' => false, 'message' => 'Failed to delete user.']);
		}
	}

	/**
	 * Lock/Unlock user
	 */
	public function toggle_lock($user_id)
	{
		$this->authorization->require_permission('user.update');

		$user = $this->UserModel->get_by_id($user_id);

		if (!$user) {
			$this->output_json(['success' => false, 'message' => 'User not found.']);
			return;
		}

		$new_status = $user['is_locked'] == 1 ? 0 : 1;

		if ($new_status == 1) {
			$this->UserModel->lock_account($user_id);
			$message = 'User locked successfully.';
		} else {
			$this->UserModel->unlock_account($user_id);
			$message = 'User unlocked successfully.';
		}

		$this->output_json(['success' => true, 'message' => $message]);
	}

	/**
	 * Custom validation callback
	 */
	public function username_check($username, $user_id)
	{
		if ($this->UserModel->username_exists($username, $user_id)) {
			$this->form_validation->set_message('username_check', 'Username already exists.');
			return false;
		}
		return true;
	}

	/**
	 * Custom validation callback
	 */
	public function email_check($email, $user_id)
	{
		if ($this->UserModel->email_exists($email, $user_id)) {
			$this->form_validation->set_message('email_check', 'Email already exists.');
			return false;
		}
		return true;
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
