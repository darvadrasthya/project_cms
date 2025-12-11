<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PermissionModel extends CI_Model
{
	private $table = 'PERMISSIONS';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get permission by ID
	 */
	public function get_by_id($permission_id)
	{
		return $this->db->get_where($this->table, ['permission_id' => $permission_id])->row_array();
	}

	/**
	 * Get permission by key
	 */
	public function get_by_key($permission_key)
	{
		return $this->db->get_where($this->table, ['permission_key' => $permission_key])->row_array();
	}

	/**
	 * Get all permissions
	 */
	public function get_all()
	{
		$this->db->order_by('permission_key', 'ASC');
		return $this->db->get($this->table)->result_array();
	}

	/**
	 * Get permissions grouped
	 */
	public function get_grouped()
	{
		$permissions = $this->get_all();
		$grouped = [];

		foreach ($permissions as $permission) {
			$parts = explode('.', $permission['permission_key']);
			$module = $parts[0];

			if (!isset($grouped[$module])) {
				$grouped[$module] = [];
			}

			$grouped[$module][] = $permission;
		}

		return $grouped;
	}

	/**
	 * Create new permission
	 */
	public function create($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	/**
	 * Update permission
	 */
	public function update($permission_id, $data)
	{
		$this->db->where('permission_id', $permission_id);
		return $this->db->update($this->table, $data);
	}

	/**
	 * Delete permission
	 */
	public function delete($permission_id)
	{
		return $this->db->delete($this->table, ['permission_id' => $permission_id]);
	}

	/**
	 * Get user permissions
	 */
	public function get_user_permissions($user_id)
	{
		$this->db->select('PERMISSIONS.*');
		$this->db->from($this->table);
		$this->db->join('ROLE_PERMISSIONS', 'PERMISSIONS.permission_id = ROLE_PERMISSIONS.permission_id');
		$this->db->join('USER_ROLES', 'ROLE_PERMISSIONS.role_id = USER_ROLES.role_id');
		$this->db->where('USER_ROLES.user_id', $user_id);
		$this->db->group_by('PERMISSIONS.permission_id');
		return $this->db->get()->result_array();
	}

	/**
	 * Check if user has permission
	 */
	public function user_has_permission($user_id, $permission_key)
	{
		$this->db->select('PERMISSIONS.permission_id');
		$this->db->from($this->table);
		$this->db->join('ROLE_PERMISSIONS', 'PERMISSIONS.permission_id = ROLE_PERMISSIONS.permission_id');
		$this->db->join('USER_ROLES', 'ROLE_PERMISSIONS.role_id = USER_ROLES.role_id');
		$this->db->where('USER_ROLES.user_id', $user_id);
		$this->db->where('PERMISSIONS.permission_key', $permission_key);
		return $this->db->get()->num_rows() > 0;
	}

	/**
	 * Get user permission keys
	 */
	public function get_user_permission_keys($user_id)
	{
		$permissions = $this->get_user_permissions($user_id);
		return array_column($permissions, 'permission_key');
	}
}
