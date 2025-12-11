<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TrafficLogModel extends CI_Model
{
	private $table = 'TRAFFIC_LOGS';
	private $table_summary = 'TRAFFIC_SUMMARY';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Create traffic log
	 */
	public function create($data)
	{
		$default = [
			'session_id' => session_id(),
			'ip_address' => $this->input->ip_address(),
			'user_agent' => $this->input->user_agent(),
			'created_at' => date('Y-m-d H:i:s')
		];

		$data = array_merge($default, $data);

		return $this->db->insert($this->table, $data);
	}

	/**
	 * Log page visit
	 */
	public function log_visit($user_id = null, $url_path = null, $referrer = null)
	{
		// Parse user agent
		$this->load->library('user_agent');

		$data = [
			'user_id' => $user_id,
			'url_path' => $url_path ? $url_path : uri_string(),
			'referrer' => $referrer ? $referrer : $this->input->server('HTTP_REFERER'),
			'device' => $this->agent->mobile() ? 'mobile' : 'desktop',
			'browser' => $this->agent->browser(),
			'os' => $this->agent->platform(),
			'is_bot' => $this->agent->is_robot() ? 1 : 0
		];

		return $this->create($data);
	}

	/**
	 * Get all logs
	 */
	public function get_all($limit = null, $offset = null)
	{
		$this->db->select('TRAFFIC_LOGS.*, USERS.username');
		$this->db->from($this->table);
		$this->db->join('USERS', 'TRAFFIC_LOGS.user_id = USERS.user_id', 'left');
		$this->db->order_by('TRAFFIC_LOGS.created_at', 'DESC');

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
		$this->db->where('created_at >=', $start_date);
		$this->db->where('created_at <=', $end_date);
		$this->db->order_by('created_at', 'DESC');

		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		return $this->db->get($this->table)->result_array();
	}

	/**
	 * Get statistics
	 */
	public function get_statistics($start_date = null, $end_date = null)
	{
		if (!$start_date) {
			$start_date = date('Y-m-d 00:00:00', strtotime('-30 days'));
		}
		if (!$end_date) {
			$end_date = date('Y-m-d 23:59:59');
		}

		// Total visits
		$this->db->where('created_at >=', $start_date);
		$this->db->where('created_at <=', $end_date);
		$total_visits = $this->db->count_all_results($this->table);

		// Unique visitors - use raw query
		$sql = "SELECT COUNT(DISTINCT ip_address) AS unique_count FROM {$this->table} WHERE created_at >= ? AND created_at <= ?";
		$result = $this->db->query($sql, [$start_date, $end_date])->row();
		$unique_visitors = $result ? $result->unique_count : 0;

		// Top pages
		$this->db->select('url_path, COUNT(*) as count');
		$this->db->from($this->table);
		$this->db->where('created_at >=', $start_date);
		$this->db->where('created_at <=', $end_date);
		$this->db->group_by('url_path');
		$this->db->order_by('count', 'DESC');
		$this->db->limit(10);
		$top_pages = $this->db->get()->result_array();

		return [
			'total_visits' => $total_visits,
			'unique_visitors' => $unique_visitors,
			'top_pages' => $top_pages
		];
	}

	/**
	 * Get device statistics
	 */
	public function get_device_stats($start_date = null, $end_date = null)
	{
		if ($start_date && $end_date) {
			$this->db->where('created_at >=', $start_date);
			$this->db->where('created_at <=', $end_date);
		}

		$this->db->select('device, COUNT(*) as count');
		$this->db->group_by('device');
		return $this->db->get($this->table)->result_array();
	}

	/**
	 * Get browser statistics
	 */
	public function get_browser_stats($start_date = null, $end_date = null)
	{
		if ($start_date && $end_date) {
			$this->db->where('created_at >=', $start_date);
			$this->db->where('created_at <=', $end_date);
		}

		$this->db->select('browser, COUNT(*) as count');
		$this->db->group_by('browser');
		$this->db->order_by('count', 'DESC');
		return $this->db->get($this->table)->result_array();
	}

	/**
	 * Update daily summary
	 */
	public function update_daily_summary($date = null)
	{
		if (!$date) {
			$date = date('Y-m-d');
		}

		$start = $date . ' 00:00:00';
		$end = $date . ' 23:59:59';

		$stats = $this->get_statistics($start, $end);

		$data = [
			'date' => $date,
			'total_visits' => $stats['total_visits'],
			'unique_visitors' => $stats['unique_visitors'],
			'page_views' => $stats['total_visits'],
			'top_page' => !empty($stats['top_pages']) ? $stats['top_pages'][0]['url_path'] : null,
			'created_at' => date('Y-m-d H:i:s')
		];

		// Check if summary exists
		$existing = $this->db->get_where($this->table_summary, ['date' => $date])->row_array();

		if ($existing) {
			$this->db->where('date', $date);
			return $this->db->update($this->table_summary, $data);
		} else {
			return $this->db->insert($this->table_summary, $data);
		}
	}

	/**
	 * Get daily summaries
	 */
	public function get_summaries($limit = 30)
	{
		$this->db->order_by('date', 'DESC');
		$this->db->limit($limit);
		return $this->db->get($this->table_summary)->result_array();
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
