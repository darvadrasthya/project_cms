<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Authorization Library
 * Handle user authorization and permissions
 */
class MY_Authorization
{
	protected $CI;
	private $user_id;
	private $user_roles = [];
	private $user_permissions = [];

	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('RoleModel');
		$this->CI->load->model('PermissionModel');
		$this->CI->load->library('session');

		// Get user from session
		$this->user_id = $this->CI->session->userdata('user_id');

		if ($this->user_id) {
			$this->load_user_permissions();
		}
	}

	/**
	 * Load user permissions
	 */
	private function load_user_permissions()
	{
		// Get user roles
		$roles = $this->CI->RoleModel->get_user_roles($this->user_id);
		$this->user_roles = array_column($roles, 'role_name');

		// Get user permissions
		$permissions = $this->CI->PermissionModel->get_user_permissions($this->user_id);
		$this->user_permissions = array_column($permissions, 'permission_key');
	}

	/**
	 * Check if user has role
	 */
	public function has_role($role_name)
	{
		if (!$this->user_id) {
			return false;
		}

		if (is_array($role_name)) {
			return !empty(array_intersect($role_name, $this->user_roles));
		}

		return in_array($role_name, $this->user_roles);
	}

	/**
	 * Check if user has permission
	 * Super Admin bypasses all permission checks
	 */
	public function has_permission($permission_key)
	{
		if (!$this->user_id) {
			return false;
		}

		// Super Admin has all permissions
		if (in_array('Super Admin', $this->user_roles)) {
			return true;
		}

		if (is_array($permission_key)) {
			return !empty(array_intersect($permission_key, $this->user_permissions));
		}

		return in_array($permission_key, $this->user_permissions);
	}

	/**
	 * Check if user has any permission
	 */
	public function has_any_permission($permissions)
	{
		if (!$this->user_id) {
			return false;
		}

		if (!is_array($permissions)) {
			$permissions = [$permissions];
		}

		return !empty(array_intersect($permissions, $this->user_permissions));
	}

	/**
	 * Check if user has all permissions
	 */
	public function has_all_permissions($permissions)
	{
		if (!$this->user_id) {
			return false;
		}

		if (!is_array($permissions)) {
			$permissions = [$permissions];
		}

		return count(array_intersect($permissions, $this->user_permissions)) === count($permissions);
	}

	/**
	 * Require role
	 */
	public function require_role($role_name, $redirect = true)
	{
		if (!$this->has_role($role_name)) {
			if ($redirect) {
				show_error('Access Denied: You do not have the required role.', 403, 'Access Denied');
			}
			return false;
		}
		return true;
	}

	/**
	 * Require permission
	 */
	public function require_permission($permission_key, $redirect = true)
	{
		if (!$this->has_permission($permission_key)) {
			if ($redirect) {
				show_error('Access Denied: You do not have the required permission.', 403, 'Access Denied');
			}
			return false;
		}
		return true;
	}

	/**
	 * Check if user is super admin
	 */
	public function is_super_admin()
	{
		return $this->has_role('Super Admin');
	}

	/**
	 * Check if user is admin
	 */
	public function is_admin()
	{
		return $this->has_role(['Super Admin', 'Admin']);
	}

	/**
	 * Get user roles
	 */
	public function get_roles()
	{
		return $this->user_roles;
	}

	/**
	 * Get user permissions
	 */
	public function get_permissions()
	{
		return $this->user_permissions;
	}

	/**
	 * Can create
	 */
	public function can_create($resource)
	{
		return $this->has_permission($resource . '.create');
	}

	/**
	 * Can read
	 */
	public function can_read($resource)
	{
		return $this->has_permission($resource . '.read');
	}

	/**
	 * Can update
	 */
	public function can_update($resource)
	{
		return $this->has_permission($resource . '.update');
	}

	/**
	 * Can delete
	 */
	public function can_delete($resource)
	{
		return $this->has_permission($resource . '.delete');
	}

	/**
	 * Can manage (all CRUD)
	 */
	public function can_manage($resource)
	{
		return $this->has_all_permissions([
			$resource . '.create',
			$resource . '.read',
			$resource . '.update',
			$resource . '.delete'
		]);
	}

	/**
	 * Authorization middleware
	 */
	public function authorize($permission_key, $message = null)
	{
		if (!$this->has_permission($permission_key)) {
			if (!$message) {
				$message = 'You do not have permission to perform this action.';
			}

			$this->CI->session->set_flashdata('error', $message);

			if ($this->CI->input->is_ajax_request()) {
				header('Content-Type: application/json');
				echo json_encode([
					'success' => false,
					'message' => $message
				]);
				exit;
			} else {
				redirect('dashboard');
			}
		}
	}
}
