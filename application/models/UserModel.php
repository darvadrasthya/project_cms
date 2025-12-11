<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{
	private $table = 'USERS';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get user by ID
	 */
	public function get_by_id($user_id)
	{
		return $this->db->get_where($this->table, ['user_id' => $user_id])->row_array();
	}

	/**
	 * Get user by email
	 */
	public function get_by_email($email)
	{
		return $this->db->get_where($this->table, ['email' => $email])->row_array();
	}

	/**
	 * Get user by username
	 */
	public function get_by_username($username)
	{
		return $this->db->get_where($this->table, ['username' => $username])->row_array();
	}

	/**
	 * Get user by email or username
	 */
	public function get_by_login($login)
	{
		$this->db->where('email', $login);
		$this->db->or_where('username', $login);
		return $this->db->get($this->table)->row_array();
	}

	/**
	 * Get all users
	 */
	public function get_all($limit = null, $offset = null)
	{
		if ($limit) {
			$this->db->limit($limit, $offset);
		}
		$this->db->order_by('created_at', 'DESC');
		return $this->db->get($this->table)->result_array();
	}

	/**
	 * Get users with roles
	 */
	public function get_users_with_roles($limit = null, $offset = null)
	{
		$this->db->select('USERS.*, GROUP_CONCAT(ROLES.role_name) as roles');
		$this->db->from($this->table);
		$this->db->join('USER_ROLES', 'USERS.user_id = USER_ROLES.user_id', 'left');
		$this->db->join('ROLES', 'USER_ROLES.role_id = ROLES.role_id', 'left');
		$this->db->group_by('USERS.user_id');
		$this->db->order_by('USERS.created_at', 'DESC');

		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		return $this->db->get()->result_array();
	}

	/**
	 * Create new user
	 */
	public function create($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	/**
	 * Update user
	 */
	public function update($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		return $this->db->update($this->table, $data);
	}

	/**
	 * Delete user
	 */
	public function delete($user_id)
	{
		return $this->db->delete($this->table, ['user_id' => $user_id]);
	}

	/**
	 * Lock user account
	 */
	public function lock_account($user_id)
	{
		return $this->update($user_id, ['is_locked' => 1]);
	}

	/**
	 * Unlock user account
	 */
	public function unlock_account($user_id)
	{
		return $this->update($user_id, ['is_locked' => 0]);
	}

	/**
	 * Activate user account
	 */
	public function activate($user_id)
	{
		return $this->update($user_id, ['is_active' => 1]);
	}

	/**
	 * Deactivate user account
	 */
	public function deactivate($user_id)
	{
		return $this->update($user_id, ['is_active' => 0]);
	}

	/**
	 * Update last login
	 */
	public function update_last_login($user_id)
	{
		return $this->update($user_id, ['last_login' => date('Y-m-d H:i:s')]);
	}

	/**
	 * Count total users
	 */
	public function count_all()
	{
		return $this->db->count_all($this->table);
	}

	/**
	 * Count active users
	 */
	public function count_active()
	{
		return $this->db->where('is_active', 1)->count_all_results($this->table);
	}

	/**
	 * Search users
	 */
	public function search($keyword, $limit = null, $offset = null)
	{
		$this->db->like('email', $keyword);
		$this->db->or_like('username', $keyword);
		$this->db->order_by('created_at', 'DESC');

		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		return $this->db->get($this->table)->result_array();
	}

	/**
	 * Check if email exists
	 */
	public function email_exists($email, $exclude_user_id = null)
	{
		$this->db->where('email', $email);
		if ($exclude_user_id) {
			$this->db->where('user_id !=', $exclude_user_id);
		}
		return $this->db->count_all_results($this->table) > 0;
	}

	/**
	 * Check if username exists
	 */
	public function username_exists($username, $exclude_user_id = null)
	{
		$this->db->where('username', $username);
		if ($exclude_user_id) {
			$this->db->where('user_id !=', $exclude_user_id);
		}
		return $this->db->count_all_results($this->table) > 0;
	}
}
