<?php

// 
defined('BASEPATH') or exit('No direct script access allowed');

// App Model
class AppModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Mengambil satu baris data sebagai array asosiatif
    public function getRowArray($conditions = null, $table)
    {
        if ($conditions) {
            $this->db->where($conditions);
        }

        return $this->db->get($table)->row_array();
    }

    // Mengambil beberapa baris data sebagai array asosiatif
    public function getResultArray($conditions = null, $table)
    {
        if ($conditions) {
            $this->db->where($conditions);
        }

        return $this->db->get($table)->result_array();
    }

    // Memperbarui baris dalam tabel
    public function updateRows($table, $data, $conditions)
    {
        $this->db->where($conditions);
        return $this->db->update($table, $data);
    }

    // Menambahkan baris baru ke dalam tabel
    public function insertRow($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    // Method ini digunakan untuk mengambil record data dari tabel
    public function fetchByCondition($where = null, $table, $select = NULL)
    {
        // Sanitize select columns
        if ($select !== null) {
            // Basic validation to prevent SQL injection
            if (!preg_match('/^[a-zA-Z0-9_,\s*]+$/', $select)) {
                throw new InvalidArgumentException('Invalid select parameter');
            }
            $this->db->select($select);
        }

        // Handle where condition
        if ($where !== null) {
            $this->db->where($where);
        }

        return $this->db->get($table);
    }

    // 
    public function get_by_id($where_column_id, $id, $table)
    {
        $this->db->where($where_column_id, $id);
        return $this->db->get($table)->row_array();
    }
}
