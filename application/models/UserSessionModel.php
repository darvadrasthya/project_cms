<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserSessionModel extends CI_Model
{
    private $table = 'USER_SESSIONS';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create session
     */
    public function create($data)
    {
        $default = [
            'session_token' => bin2hex(random_bytes(32)),
            'ip_address' => $this->input->ip_address(),
            'device_info' => $this->input->user_agent(),
            'created_at' => date('Y-m-d H:i:s'),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+1 day'))
        ];

        $data = array_merge($default, $data);

        // Detect if mobile
        $this->load->library('user_agent');
        $data['is_mobile'] = $this->agent->is_mobile() ? 1 : 0;

        $this->db->insert($this->table, $data);
        $session_id = $this->db->insert_id();

        return $this->get_by_id($session_id);
    }

    /**
     * Get session by ID
     */
    public function get_by_id($session_id)
    {
        return $this->db->get_where($this->table, ['session_id' => $session_id])->row_array();
    }

    /**
     * Get session by token
     */
    public function get_by_token($session_token)
    {
        return $this->db->get_where($this->table, ['session_token' => $session_token])->row_array();
    }

    /**
     * Get user sessions
     */
    public function get_user_sessions($user_id, $include_expired = false)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('revoked', 0);

        if (!$include_expired) {
            $this->db->where('expires_at >', date('Y-m-d H:i:s'));
        }

        $this->db->order_by('created_at', 'DESC');
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Get active sessions
     */
    public function get_active_sessions($user_id = null)
    {
        $this->db->where('revoked', 0);
        $this->db->where('expires_at >', date('Y-m-d H:i:s'));

        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }

        $this->db->order_by('created_at', 'DESC');
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Revoke session
     */
    public function revoke($session_id)
    {
        $this->db->where('session_id', $session_id);
        return $this->db->update($this->table, ['revoked' => 1]);
    }

    /**
     * Revoke by token
     */
    public function revoke_by_token($session_token)
    {
        $this->db->where('session_token', $session_token);
        return $this->db->update($this->table, ['revoked' => 1]);
    }

    /**
     * Revoke all user sessions
     */
    public function revoke_all_user_sessions($user_id, $except_session_id = null)
    {
        $this->db->where('user_id', $user_id);

        if ($except_session_id) {
            $this->db->where('session_id !=', $except_session_id);
        }

        return $this->db->update($this->table, ['revoked' => 1]);
    }

    /**
     * Validate session
     */
    public function validate($session_token)
    {
        $session = $this->get_by_token($session_token);

        if (!$session) {
            return false;
        }

        if ($session['revoked'] == 1) {
            return false;
        }

        if (strtotime($session['expires_at']) < time()) {
            return false;
        }

        return $session;
    }

    /**
     * Extend session
     */
    public function extend($session_id, $hours = 24)
    {
        $expires_at = date('Y-m-d H:i:s', strtotime("+{$hours} hours"));

        $this->db->where('session_id', $session_id);
        return $this->db->update($this->table, ['expires_at' => $expires_at]);
    }

    /**
     * Delete expired sessions
     */
    public function delete_expired()
    {
        $this->db->where('expires_at <', date('Y-m-d H:i:s'));
        return $this->db->delete($this->table);
    }

    /**
     * Count active sessions
     */
    public function count_active()
    {
        $this->db->where('revoked', 0);
        $this->db->where('expires_at >', date('Y-m-d H:i:s'));
        return $this->db->count_all_results($this->table);
    }
}
