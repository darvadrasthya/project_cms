<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuditLogModel extends CI_Model
{
	private $table = 'AUDIT_LOGS';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Create audit log
	 */
	public function create($data)
	{
		$default = [
			'ip_address' => $this->input->ip_address(),
			'user_agent' => $this->input->user_agent(),
			'created_at' => date('Y-m-d H:i:s')
		];

		$data = array_merge($default, $data);

		return $this->db->insert($this->table, $data);
	}

	/**
	 * Log action
	 */
	public function log($action, $details = null, $user_id = null)
	{
		// Validate user_id exists if provided
		if ($user_id !== null) {
			$this->db->select('user_id');
			$user_exists = $this->db->get_where('USERS', ['user_id' => $user_id])->row();
			if (!$user_exists) {
				$user_id = null; // Set to null if user doesn't exist
			}
		}

		$data = [
			'user_id' => $user_id,
			'action' => $action,
			'details' => is_array($details) ? json_encode($details) : $details
		];

		return $this->create($data);
	}

	/**
	 * Get all logs
	 */
	public function get_all($limit = null, $offset = null)
	{
		$this->db->select('AUDIT_LOGS.*, USERS.username, USERS.email');
		$this->db->from($this->table);
		$this->db->join('USERS', 'AUDIT_LOGS.user_id = USERS.user_id', 'left');
		$this->db->order_by('AUDIT_LOGS.created_at', 'DESC');

		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		return $this->db->get()->result_array();
	}

	/**
	 * Get logs by user
	 */
	public function get_by_user($user_id, $limit = null, $offset = null)
	{
		$this->db->where('user_id', $user_id);
		$this->db->order_by('created_at', 'DESC');

		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		return $this->db->get($this->table)->result_array();
	}

	/**
	 * Get logs by action
	 */
	public function get_by_action($action, $limit = null, $offset = null)
	{
		$this->db->select('AUDIT_LOGS.*, USERS.username, USERS.email');
		$this->db->from($this->table);
		$this->db->join('USERS', 'AUDIT_LOGS.user_id = USERS.user_id', 'left');
		$this->db->where('AUDIT_LOGS.action', $action);
		$this->db->order_by('AUDIT_LOGS.created_at', 'DESC');

		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		return $this->db->get()->result_array();
	}

	/**
	 * Get logs by date range
	 */
	public function get_by_date_range($start_date, $end_date, $limit = null, $offset = null)
	{
		$this->db->select('AUDIT_LOGS.*, USERS.username, USERS.email');
		$this->db->from($this->table);
		$this->db->join('USERS', 'AUDIT_LOGS.user_id = USERS.user_id', 'left');
		$this->db->where('AUDIT_LOGS.created_at >=', $start_date);
		$this->db->where('AUDIT_LOGS.created_at <=', $end_date);
		$this->db->order_by('AUDIT_LOGS.created_at', 'DESC');

		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		return $this->db->get()->result_array();
	}

	/**
	 * Count logs
	 */
	public function count_all()
	{
		return $this->db->count_all($this->table);
	}

	/**
	 * Delete old logs
	 */
	public function delete_old_logs($days = 90)
	{
		$date = date('Y-m-d H:i:s', strtotime("-{$days} days"));
		$this->db->where('created_at <', $date);
		return $this->db->delete($this->table);
	}
}
