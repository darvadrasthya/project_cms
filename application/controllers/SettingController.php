<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SettingController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('MY_Auth', null, 'auth');
        $this->load->library('MY_Authorization', null, 'authorization');
        $this->load->model('ConfigurationModel');

        // Require login
        $this->auth->require_login();
        
        // Require permission - only Super Admin can manage settings
        $this->authorization->require_permission('config.manage');
    }

    public function index()
    {
        // Get all settings as key-value pairs
        $all_configs = $this->ConfigurationModel->get_all();
        $settings = [];
        foreach ($all_configs as $config) {
            $settings[$config['config_key']] = $config['config_value'];
        }

        $data = [
            'title' => 'Settings',
            'settings' => $settings
        ];

        $this->load->view('settings/index', $data);
    }

    public function update()
    {
        $settings = [
            'site_name' => $this->input->post('site_name'),
            'site_description' => $this->input->post('site_description'),
            'admin_email' => $this->input->post('admin_email'),
            'max_login_attempts' => $this->input->post('max_login_attempts'),
            'lockout_duration' => $this->input->post('lockout_duration'),
            'session_lifetime' => $this->input->post('session_lifetime'),
            'max_upload_size' => $this->input->post('max_upload_size'),
            'allowed_file_types' => $this->input->post('allowed_file_types'),
            'maintenance_mode' => $this->input->post('maintenance_mode') ? 1 : 0,
            'maintenance_message' => $this->input->post('maintenance_message')
        ];

        foreach ($settings as $key => $value) {
            $this->ConfigurationModel->set($key, $value);
        }

        $this->session->set_flashdata('success', 'Settings saved successfully');
        redirect('settings');
    }
}
