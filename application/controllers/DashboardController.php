<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('MY_Auth', null, 'auth');
        $this->load->library('MY_Authorization', null, 'authorization');
        $this->auth->require_login();

        $this->load->model('UserModel');
        $this->load->model('PageModel');
        $this->load->model('MediaModel');
        $this->load->model('TrafficLogModel');
        $this->load->model('AuditLogModel');
    }

    /**
     * Dashboard index
     */
    public function index()
    {
        // Get statistics
        $stats = [
            'total_users' => $this->UserModel->count_all(),
            'total_pages' => $this->PageModel->count_all(),
            'total_media' => $this->MediaModel->count_all(),
            'total_visits' => 0
        ];

        // Get traffic statistics (last 30 days)
        try {
            $traffic_stats = $this->TrafficLogModel->get_statistics();
            $stats['total_visits'] = $traffic_stats['total_visits'] ?? 0;
        } catch (Exception $e) {
            $traffic_stats = [];
        }

        // Get recent users
        $recent_users = $this->UserModel->get_all(5);

        // Get recent activities
        $recent_logs = $this->AuditLogModel->get_all(10);

        // Get recent pages
        $recent_pages = $this->PageModel->get_all(null, 5);

        $data = [
            'title' => 'Dashboard',
            'subtitle' => 'Welcome back!',
            'stats' => $stats,
            'traffic_stats' => $traffic_stats,
            'recent_users' => $recent_users,
            'recent_logs' => $recent_logs,
            'recent_pages' => $recent_pages
        ];

        $this->load->view('dashboard/main', $data);
    }

    /**
     * Analytics page
     */
    public function analytics()
    {
        $this->authorization->require_permission('traffic.view');

        // Get date range from query
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        if (!$start_date) {
            $start_date = date('Y-m-d', strtotime('-30 days'));
        }
        if (!$end_date) {
            $end_date = date('Y-m-d');
        }

        // Get statistics
        $stats = $this->TrafficLogModel->get_statistics($start_date . ' 00:00:00', $end_date . ' 23:59:59');

        // Get device stats
        $device_stats = $this->TrafficLogModel->get_device_stats($start_date . ' 00:00:00', $end_date . ' 23:59:59');

        // Get browser stats
        $browser_stats = $this->TrafficLogModel->get_browser_stats($start_date . ' 00:00:00', $end_date . ' 23:59:59');

        // Get daily summaries
        $summaries = $this->TrafficLogModel->get_summaries(30);

        $data = [
            'title' => 'Analytics',
            'subtitle' => 'Traffic & Visitor Statistics',
            'stats' => $stats,
            'device_stats' => $device_stats,
            'browser_stats' => $browser_stats,
            'summaries' => $summaries,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];

        $this->load->view('dashboard/analytics', $data);
    }

    /**
     * System info
     */
    public function system_info()
    {
        $this->authorization->require_role('Super Admin');

        $data = [
            'title' => 'System Information',
            'subtitle' => 'Server & Environment Details',
            'php_version' => phpversion(),
            'ci_version' => CI_VERSION,
            'server_software' => $_SERVER['SERVER_SOFTWARE'],
            'database' => $this->db->database,
            'db_version' => $this->db->version()
        ];

        $this->load->view('dashboard/system_info', $data);
    }
}
