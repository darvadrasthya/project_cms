<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Security Helper Functions
 * Additional security functions for the CMS
 */

if (!function_exists('sanitize_input')) {
	/**
	 * Sanitize input data
	 */
	function sanitize_input($data)
	{
		if (is_array($data)) {
			return array_map('sanitize_input', $data);
		}

		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

		return $data;
	}
}

if (!function_exists('check_permission')) {
	/**
	 * Check if current user has permission
	 */
	function check_permission($permission_key)
	{
		$CI = &get_instance();
		$CI->load->library('MY_Authorization', null, 'authorization');
		return $CI->authorization->has_permission($permission_key);
	}
}

if (!function_exists('check_role')) {
	/**
	 * Check if current user has role
	 */
	function check_role($role_name)
	{
		$CI = &get_instance();
		$CI->load->library('MY_Authorization', null, 'authorization');
		return $CI->authorization->has_role($role_name);
	}
}

if (!function_exists('is_logged_in')) {
	/**
	 * Check if user is logged in
	 */
	function is_logged_in()
	{
		$CI = &get_instance();
		$CI->load->library('MY_Auth', null, 'auth');
		return $CI->auth->is_logged_in();
	}
}

if (!function_exists('current_user')) {
	/**
	 * Get current logged in user
	 */
	function current_user()
	{
		$CI = &get_instance();
		$CI->load->library('MY_Auth', null, 'auth');
		return $CI->auth->user();
	}
}

if (!function_exists('current_user_id')) {
	/**
	 * Get current user ID
	 */
	function current_user_id()
	{
		$CI = &get_instance();
		$CI->load->library('MY_Auth', null, 'auth');
		return $CI->auth->user_id();
	}
}

if (!function_exists('generate_csrf_token')) {
	/**
	 * Generate CSRF token
	 */
	function generate_csrf_token()
	{
		$CI = &get_instance();

		if (!$CI->session->userdata('csrf_token')) {
			$token = bin2hex(random_bytes(32));
			$CI->session->set_userdata('csrf_token', $token);
		}

		return $CI->session->userdata('csrf_token');
	}
}

if (!function_exists('verify_csrf_token')) {
	/**
	 * Verify CSRF token
	 */
	function verify_csrf_token($token)
	{
		$CI = &get_instance();
		$session_token = $CI->session->userdata('csrf_token');

		return hash_equals($session_token, $token);
	}
}

if (!function_exists('encrypt_data')) {
	/**
	 * Encrypt data
	 */
	function encrypt_data($data)
	{
		$CI = &get_instance();
		$CI->load->library('encryption');
		return $CI->encryption->encrypt($data);
	}
}

if (!function_exists('decrypt_data')) {
	/**
	 * Decrypt data
	 */
	function decrypt_data($encrypted_data)
	{
		$CI = &get_instance();
		$CI->load->library('encryption');
		return $CI->encryption->decrypt($encrypted_data);
	}
}

if (!function_exists('log_activity')) {
	/**
	 * Log user activity
	 */
	function log_activity($action, $details = null, $user_id = null)
	{
		$CI = &get_instance();
		$CI->load->model('AuditLogModel');

		if (!$user_id) {
			$user_id = current_user_id();
		}

		return $CI->AuditLogModel->log($action, $details, $user_id);
	}
}

if (!function_exists('log_crud')) {
	/**
	 * Log CRUD operation
	 */
	function log_crud($table_name, $action, $record_id = null, $old_data = null, $new_data = null, $description = null)
	{
		$CI = &get_instance();
		$CI->load->model('CrudLogModel');

		$user_id = current_user_id();

		return $CI->CrudLogModel->log($table_name, $action, $record_id, $old_data, $new_data, $description, $user_id);
	}
}

if (!function_exists('format_bytes')) {
	/**
	 * Format bytes to human readable
	 */
	function format_bytes($bytes, $precision = 2)
	{
		$units = ['B', 'KB', 'MB', 'GB', 'TB'];

		$bytes = max($bytes, 0);
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);

		$bytes /= pow(1024, $pow);

		return round($bytes, $precision) . ' ' . $units[$pow];
	}
}

if (!function_exists('time_ago')) {
	/**
	 * Convert timestamp to time ago format
	 */
	function time_ago($datetime)
	{
		$timestamp = strtotime($datetime);
		$difference = time() - $timestamp;

		$periods = [
			'second' => 1,
			'minute' => 60,
			'hour' => 3600,
			'day' => 86400,
			'week' => 604800,
			'month' => 2629440,
			'year' => 31553280
		];

		foreach ($periods as $key => $value) {
			if ($difference < $value) {
				break;
			}
			$time = $key;
			$time_count = floor($difference / $value);
		}

		if (!isset($time_count)) {
			$time_count = 0;
			$time = 'second';
		}

		if ($time_count != 1) {
			$time .= 's';
		}

		return $time_count . ' ' . $time . ' ago';
	}
}

if (!function_exists('get_config_value')) {
	/**
	 * Get configuration value
	 */
	function get_config_value($key, $default = null)
	{
		$CI = &get_instance();
		$CI->load->model('ConfigurationModel');
		return $CI->ConfigurationModel->get_value($key, $default);
	}
}

if (!function_exists('set_config_value')) {
	/**
	 * Set configuration value
	 */
	function set_config_value($key, $value, $group = null, $description = null)
	{
		$CI = &get_instance();
		$CI->load->model('ConfigurationModel');
		$user_id = current_user_id();
		return $CI->ConfigurationModel->set($key, $value, $group, $description, $user_id);
	}
}

if (!function_exists('json_response')) {
	/**
	 * Send JSON response
	 */
	function json_response($data, $status_code = 200)
	{
		$CI = &get_instance();
		$CI->output
			->set_status_header($status_code)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
			->_display();
		exit;
	}
}

if (!function_exists('success_response')) {
	/**
	 * Send success JSON response
	 */
	function success_response($message, $data = null)
	{
		$response = [
			'success' => true,
			'message' => $message
		];

		if ($data !== null) {
			$response['data'] = $data;
		}

		json_response($response);
	}
}

if (!function_exists('error_response')) {
	/**
	 * Send error JSON response
	 */
	function error_response($message, $code = 400, $errors = null)
	{
		$response = [
			'success' => false,
			'message' => $message
		];

		if ($errors !== null) {
			$response['errors'] = $errors;
		}

		json_response($response, $code);
	}
}
