<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RoleModel extends CI_Model
{
	private $table = 'ROLES';
	private $table_permissions = 'ROLE_PERMISSIONS';
	private $table_user_roles = 'USER_ROLES';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get role by ID
	 */
	public function get_by_id($role_id)
	{
		return $this->db->get_where($this->table, ['role_id' => $role_id])->row_array();
	}

	/**
	 * Get all roles
	 */
	public function get_all()
	{
		$this->db->order_by('role_name', 'ASC');
		return $this->db->get($this->table)->result_array();
	}

	/**
	 * Get roles with permission count
	 */
	public function get_roles_with_permissions()
	{
		$this->db->select('ROLES.*, COUNT(ROLE_PERMISSIONS.permission_id) as permission_count');
		$this->db->from($this->table);
		$this->db->join('ROLE_PERMISSIONS', 'ROLES.role_id = ROLE_PERMISSIONS.role_id', 'left');
		$this->db->group_by('ROLES.role_id');
		$this->db->order_by('ROLES.role_name', 'ASC');
		return $this->db->get()->result_array();
	}

	/**
	 * Get role permissions
	 */
	public function get_role_permissions($role_id)
	{
		$this->db->select('PERMISSIONS.*');
		$this->db->from('PERMISSIONS');
		$this->db->join('ROLE_PERMISSIONS', 'PERMISSIONS.permission_id = ROLE_PERMISSIONS.permission_id');
		$this->db->where('ROLE_PERMISSIONS.role_id', $role_id);
		return $this->db->get()->result_array();
	}

	/**
	 * Create new role
	 */
	public function create($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	/**
	 * Update role
	 */
	public function update($role_id, $data)
	{
		$this->db->where('role_id', $role_id);
		return $this->db->update($this->table, $data);
	}

	/**
	 * Delete role
	 */
	public function delete($role_id)
	{
		// Check if it's a system role
		$role = $this->get_by_id($role_id);
		if ($role && $role['is_system'] == 1) {
			return false; // Cannot delete system roles
		}
		return $this->db->delete($this->table, ['role_id' => $role_id]);
	}

	/**
	 * Assign permission to role
	 */
	public function assign_permission($role_id, $permission_id)
	{
		$data = [
			'role_id' => $role_id,
			'permission_id' => $permission_id
		];

		// Check if already exists
		$exists = $this->db->get_where($this->table_permissions, $data)->num_rows() > 0;
		if ($exists) {
			return true;
		}

		return $this->db->insert($this->table_permissions, $data);
	}

	/**
	 * Remove permission from role
	 */
	public function remove_permission($role_id, $permission_id)
	{
		return $this->db->delete($this->table_permissions, [
			'role_id' => $role_id,
			'permission_id' => $permission_id
		]);
	}

	/**
	 * Sync role permissions
	 */
	public function sync_permissions($role_id, $permission_ids = [])
	{
		// Remove all current permissions
		$this->db->delete($this->table_permissions, ['role_id' => $role_id]);

		// Add new permissions
		if (!empty($permission_ids)) {
			$data = [];
			foreach ($permission_ids as $permission_id) {
				$data[] = [
					'role_id' => $role_id,
					'permission_id' => $permission_id
				];
			}
			return $this->db->insert_batch($this->table_permissions, $data);
		}

		return true;
	}

	/**
	 * Assign role to user
	 */
	public function assign_to_user($user_id, $role_id)
	{
		$data = [
			'user_id' => $user_id,
			'role_id' => $role_id,
			'assigned_at' => date('Y-m-d H:i:s')
		];

		// Check if already exists
		$exists = $this->db->get_where($this->table_user_roles, [
			'user_id' => $user_id,
			'role_id' => $role_id
		])->num_rows() > 0;

		if ($exists) {
			return true;
		}

		return $this->db->insert($this->table_user_roles, $data);
	}

	/**
	 * Remove role from user
	 */
	public function remove_from_user($user_id, $role_id)
	{
		return $this->db->delete($this->table_user_roles, [
			'user_id' => $user_id,
			'role_id' => $role_id
		]);
	}

	/**
	 * Get user roles
	 */
	public function get_user_roles($user_id)
	{
		$this->db->select('ROLES.*');
		$this->db->from($this->table);
		$this->db->join('USER_ROLES', 'ROLES.role_id = USER_ROLES.role_id');
		$this->db->where('USER_ROLES.user_id', $user_id);
		return $this->db->get()->result_array();
	}

	/**
	 * Sync user roles
	 */
	public function sync_user_roles($user_id, $role_ids = [])
	{
		// Remove all current roles
		$this->db->delete($this->table_user_roles, ['user_id' => $user_id]);

		// Add new roles
		if (!empty($role_ids)) {
			$data = [];
			foreach ($role_ids as $role_id) {
				$data[] = [
					'user_id' => $user_id,
					'role_id' => $role_id,
					'assigned_at' => date('Y-m-d H:i:s')
				];
			}
			return $this->db->insert_batch($this->table_user_roles, $data);
		}

		return true;
	}

	/**
	 * Check if user has role
	 */
	public function user_has_role($user_id, $role_name)
	{
		$this->db->select('USER_ROLES.id');
		$this->db->from($this->table_user_roles);
		$this->db->join($this->table, 'USER_ROLES.role_id = ROLES.role_id');
		$this->db->where('USER_ROLES.user_id', $user_id);
		$this->db->where('ROLES.role_name', $role_name);
		return $this->db->get()->num_rows() > 0;
	}

	/**
	 * Count permissions for a role
	 */
	public function count_permissions($role_id)
	{
		return $this->db->where('role_id', $role_id)->count_all_results($this->table_permissions);
	}

	/**
	 * Count users with a role
	 */
	public function count_users($role_id)
	{
		return $this->db->where('role_id', $role_id)->count_all_results($this->table_user_roles);
	}

	/**
	 * Get permission IDs for a role
	 */
	public function get_permission_ids($role_id)
	{
		$permissions = $this->db->select('permission_id')
			->where('role_id', $role_id)
			->get($this->table_permissions)
			->result_array();

		return array_column($permissions, 'permission_id');
	}

	/**
	 * Clear all permissions from a role
	 */
	public function clear_permissions($role_id)
	{
		return $this->db->delete($this->table_permissions, ['role_id' => $role_id]);
	}

	/**
	 * Add permission to role
	 */
	public function add_permission($role_id, $permission_id)
	{
		return $this->db->insert($this->table_permissions, [
			'role_id' => $role_id,
			'permission_id' => $permission_id
		]);
	}
}
