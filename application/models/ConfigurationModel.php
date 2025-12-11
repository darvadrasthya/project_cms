<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ConfigurationModel extends CI_Model
{
	private $table = 'CONFIGURATIONS';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get config by key
	 */
	public function get_by_key($config_key)
	{
		return $this->db->get_where($this->table, ['config_key' => $config_key])->row_array();
	}

	/**
	 * Get config value
	 */
	public function get_value($config_key, $default = null)
	{
		$config = $this->get_by_key($config_key);
		return $config ? $config['config_value'] : $default;
	}

	/**
	 * Get all configs
	 */
	public function get_all()
	{
		$this->db->order_by('group_name', 'ASC');
		$this->db->order_by('config_key', 'ASC');
		return $this->db->get($this->table)->result_array();
	}

	/**
	 * Get configs by group
	 */
	public function get_by_group($group_name)
	{
		$this->db->where('group_name', $group_name);
		$this->db->order_by('config_key', 'ASC');
		return $this->db->get($this->table)->result_array();
	}

	/**
	 * Get grouped configs
	 */
	public function get_grouped()
	{
		$configs = $this->get_all();
		$grouped = [];

		foreach ($configs as $config) {
			$group = $config['group_name'] ? $config['group_name'] : 'general';

			if (!isset($grouped[$group])) {
				$grouped[$group] = [];
			}

			$grouped[$group][] = $config;
		}

		return $grouped;
	}

	/**
	 * Get configs as array (key => value)
	 */
	public function get_as_array()
	{
		$configs = $this->get_all();
		$array = [];

		foreach ($configs as $config) {
			$array[$config['config_key']] = $config['config_value'];
		}

		return $array;
	}

	/**
	 * Create new config
	 */
	public function create($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	/**
	 * Update config
	 */
	public function update($config_id, $data)
	{
		$this->db->where('config_id', $config_id);
		return $this->db->update($this->table, $data);
	}

	/**
	 * Update by key
	 */
	public function update_by_key($config_key, $config_value, $updated_by = null)
	{
		$data = [
			'config_value' => $config_value,
			'updated_at' => date('Y-m-d H:i:s')
		];

		if ($updated_by) {
			$data['updated_by'] = $updated_by;
		}

		$this->db->where('config_key', $config_key);
		return $this->db->update($this->table, $data);
	}

	/**
	 * Set config (create or update)
	 */
	public function set($config_key, $config_value, $group_name = null, $description = null, $updated_by = null)
	{
		$existing = $this->get_by_key($config_key);

		if ($existing) {
			return $this->update_by_key($config_key, $config_value, $updated_by);
		} else {
			$data = [
				'config_key' => $config_key,
				'config_value' => $config_value,
				'group_name' => $group_name,
				'description' => $description,
				'updated_by' => $updated_by,
				'updated_at' => date('Y-m-d H:i:s')
			];
			return $this->create($data);
		}
	}

	/**
	 * Delete config
	 */
	public function delete($config_id)
	{
		return $this->db->delete($this->table, ['config_id' => $config_id]);
	}

	/**
	 * Delete by key
	 */
	public function delete_by_key($config_key)
	{
		return $this->db->delete($this->table, ['config_key' => $config_key]);
	}

	/**
	 * Batch update
	 */
	public function batch_update($configs, $updated_by = null)
	{
		foreach ($configs as $key => $value) {
			$this->update_by_key($key, $value, $updated_by);
		}
		return true;
	}
}
