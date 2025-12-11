<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SettingModel extends CI_Model
{
    private $table = 'configurations';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get setting value by key
     */
    public function get_value($key, $default = null)
    {
        $result = $this->db->select('config_value')
            ->where('config_key', $key)
            ->get($this->table)
            ->row_array();

        return $result ? $result['config_value'] : $default;
    }

    /**
     * Get setting by key
     */
    public function get_by_key($key)
    {
        return $this->db->get_where($this->table, ['config_key' => $key])->row_array();
    }

    /**
     * Get all settings
     */
    public function get_all()
    {
        return $this->db->order_by('config_key', 'ASC')
            ->get($this->table)
            ->result_array();
    }

    /**
     * Get settings as key-value pair
     */
    public function get_all_as_array()
    {
        $settings = [];
        $results = $this->get_all();
        
        foreach ($results as $row) {
            $settings[$row['config_key']] = $row['config_value'];
        }
        
        return $settings;
    }

    /**
     * Set/update setting value
     */
    public function set_value($key, $value, $user_id = null)
    {
        $existing = $this->get_by_key($key);
        
        if ($existing) {
            // Update existing setting
            $data = [
                'config_value' => $value,
                'updated_by' => $user_id,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $this->db->where('config_key', $key);
            return $this->db->update($this->table, $data);
        } else {
            // Create new setting
            $data = [
                'config_key' => $key,
                'config_value' => $value,
                'created_by' => $user_id,
                'created_at' => date('Y-m-d H:i:s')
            ];
            return $this->db->insert($this->table, $data);
        }
    }

    /**
     * Delete setting
     */
    public function delete($key)
    {
        return $this->db->delete($this->table, ['config_key' => $key]);
    }

    /**
     * Get settings by group/prefix
     */
    public function get_by_prefix($prefix)
    {
        return $this->db->like('config_key', $prefix, 'after')
            ->order_by('config_key', 'ASC')
            ->get($this->table)
            ->result_array();
    }
}
