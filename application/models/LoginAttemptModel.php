<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoginAttemptModel extends CI_Model
{
	private $table = 'LOGIN_ATTEMPTS';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Create login attempt
	 */
	public function create($data)
	{
		$default = [
			'ip_address' => $this->input->ip_address(),
			'user_agent' => $this->input->user_agent(),
			'attempted_at' => date('Y-m-d H:i:s')
		];

		$data = array_merge($default, $data);

		return $this->db->insert($this->table, $data);
	}

	/**
	 * Log login attempt
	 */
	public function log($user_id = null, $success = false)
	{
		$data = [
			'user_id' => $user_id,
			'success' => $success ? 1 : 0
		];

		return $this->create($data);
	}

	/**
	 * Get failed attempts by IP
	 */
	public function get_failed_attempts_by_ip($ip_address, $minutes = 30)
	{
		$time = date('Y-m-d H:i:s', strtotime("-{$minutes} minutes"));

		$this->db->where('ip_address', $ip_address);
		$this->db->where('success', 0);
		$this->db->where('attempted_at >=', $time);

		return $this->db->count_all_results($this->table);
	}

	/**
	 * Get failed attempts by user
	 */
	public function get_failed_attempts_by_user($user_id, $minutes = 30)
	{
		$time = date('Y-m-d H:i:s', strtotime("-{$minutes} minutes"));

		$this->db->where('user_id', $user_id);
		$this->db->where('success', 0);
		$this->db->where('attempted_at >=', $time);

		return $this->db->count_all_results($this->table);
	}

	/**
	 * Clear attempts by IP
	 */
	public function clear_attempts_by_ip($ip_address)
	{
		return $this->db->delete($this->table, ['ip_address' => $ip_address]);
	}

	/**
	 * Clear attempts by user
	 */
	public function clear_attempts_by_user($user_id)
	{
		return $this->db->delete($this->table, ['user_id' => $user_id]);
	}

	/**
	 * Get all attempts
	 */
	public function get_all($limit = null, $offset = null)
	{
		$this->db->select('LOGIN_ATTEMPTS.*, USERS.username, USERS.email');
		$this->db->from($this->table);
		$this->db->join('USERS', 'LOGIN_ATTEMPTS.user_id = USERS.user_id', 'left');
		$this->db->order_by('LOGIN_ATTEMPTS.attempted_at', 'DESC');

		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		return $this->db->get()->result_array();
	}

	/**
	 * Delete old attempts
	 */
	public function delete_old_attempts($days = 30)
	{
		$date = date('Y-m-d H:i:s', strtotime("-{$days} days"));
		$this->db->where('attempted_at <', $date);
		return $this->db->delete($this->table);
	}
}
