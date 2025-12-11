<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LogController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('MY_Auth', null, 'auth');
        $this->load->library('MY_Authorization', null, 'authorization');
        $this->load->model('AuditLogModel');
        $this->load->model('CrudLogModel');
        $this->load->model('TrafficLogModel');

        // Require login
        $this->auth->require_login();
        
        // Require permission - only Super Admin can view logs
        $this->authorization->require_permission('audit.view');
    }

    public function index()
    {
        $type = $this->input->get('type') ?? 'audit';

        switch ($type) {
            case 'crud':
                $logs = $this->CrudLogModel->get_all(100);
                break;
            case 'traffic':
                $logs = $this->TrafficLogModel->get_all(100);
                break;
            default:
                $logs = $this->AuditLogModel->get_all(100);
                break;
        }

        $data = [
            'title' => 'Activity Logs',
            'logs' => $logs,
            'type' => $type
        ];

        $this->load->view('logs/index', $data);
    }
}
