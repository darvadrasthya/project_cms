<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CrudLogModel extends CI_Model
{
	private $table = 'CRUD_LOGS';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Create CRUD log
	 */
	public function create($data)
	{
		$default = [
			'ip_address' => $this->input->ip_address(),
			'user_agent' => $this->input->user_agent(),
			'created_at' => date('Y-m-d H:i:s')
		];

		$data = array_merge($default, $data);

		// Convert arrays to JSON
		if (isset($data['old_data']) && is_array($data['old_data'])) {
			$data['old_data'] = json_encode($data['old_data']);
		}

		if (isset($data['new_data']) && is_array($data['new_data'])) {
			$data['new_data'] = json_encode($data['new_data']);
		}

		return $this->db->insert($this->table, $data);
	}

	/**
	 * Log CRUD operation
	 */
	public function log($table_name, $action, $record_id = null, $old_data = null, $new_data = null, $description = null, $user_id = null)
	{
		$data = [
			'user_id' => $user_id,
			'table_name' => $table_name,
			'record_id' => $record_id,
			'action' => $action,
			'old_data' => $old_data,
			'new_data' => $new_data,
			'description' => $description
		];

		return $this->create($data);
	}

	/**
	 * Get all logs
	 */
	public function get_all($limit = null, $offset = null)
	{
		$this->db->select('CRUD_LOGS.*, USERS.username, USERS.email');
		$this->db->from($this->table);
		$this->db->join('USERS', 'CRUD_LOGS.user_id = USERS.user_id', 'left');
		$this->db->order_by('CRUD_LOGS.created_at', 'DESC');

		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		return $this->db->get()->result_array();
	}

	/**
	 * Get logs by table
	 */
	public function get_by_table($table_name, $limit = null, $offset = null)
	{
		$this->db->select('CRUD_LOGS.*, USERS.username, USERS.email');
		$this->db->from($this->table);
		$this->db->join('USERS', 'CRUD_LOGS.user_id = USERS.user_id', 'left');
		$this->db->where('CRUD_LOGS.table_name', $table_name);
		$this->db->order_by('CRUD_LOGS.created_at', 'DESC');

		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		return $this->db->get()->result_array();
	}

	/**
	 * Get logs by record
	 */
	public function get_by_record($table_name, $record_id, $limit = null, $offset = null)
	{
		$this->db->select('CRUD_LOGS.*, USERS.username, USERS.email');
		$this->db->from($this->table);
		$this->db->join('USERS', 'CRUD_LOGS.user_id = USERS.user_id', 'left');
		$this->db->where('CRUD_LOGS.table_name', $table_name);
		$this->db->where('CRUD_LOGS.record_id', $record_id);
		$this->db->order_by('CRUD_LOGS.created_at', 'DESC');

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
		$this->db->select('CRUD_LOGS.*, USERS.username, USERS.email');
		$this->db->from($this->table);
		$this->db->join('USERS', 'CRUD_LOGS.user_id = USERS.user_id', 'left');
		$this->db->where('CRUD_LOGS.action', $action);
		$this->db->order_by('CRUD_LOGS.created_at', 'DESC');

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
