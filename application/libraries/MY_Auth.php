<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Authentication Library
 * Handle user authentication, login, logout, and password management
 */
class MY_Auth
{
	protected $CI;
	private $user_id;
	private $user_data;

	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('UserModel');
		$this->CI->load->model('LoginAttemptModel');
		$this->CI->load->model('UserSessionModel');
		$this->CI->load->model('AuditLogModel');
		$this->CI->load->library('session');

		// Get user from session
		$this->user_id = $this->CI->session->userdata('user_id');
		if ($this->user_id) {
			$this->user_data = $this->CI->UserModel->get_by_id($this->user_id);
		}
	}

	/**
	 * Login user
	 */
	public function login($login, $password, $remember = false)
	{
		// Check rate limiting
		$ip = $this->CI->input->ip_address();
		$failed_attempts = $this->CI->LoginAttemptModel->get_failed_attempts_by_ip($ip);

		$max_attempts = $this->CI->config->item('max_login_attempts') ?: 5;

		if ($failed_attempts >= $max_attempts) {
			return [
				'success' => false,
				'message' => 'Too many failed login attempts. Please try again later.'
			];
		}

		// Get user
		$user = $this->CI->UserModel->get_by_login($login);

		if (!$user) {
			// Log failed attempt
			$this->CI->LoginAttemptModel->log(null, false);

			return [
				'success' => false,
				'message' => 'Invalid email/username or password.'
			];
		}

		// Verify password
		if (!$this->verify_password($password, $user['password_hash'], $user['password_salt'])) {
			// Log failed attempt
			$this->CI->LoginAttemptModel->log($user['user_id'], false);

			return [
				'success' => false,
				'message' => 'Invalid email/username or password.'
			];
		}

		// Check if user is active
		if ($user['is_active'] != 1) {
			return [
				'success' => false,
				'message' => 'Your account is not active. Please contact administrator.'
			];
		}

		// Check if user is locked
		if ($user['is_locked'] == 1) {
			return [
				'success' => false,
				'message' => 'Your account has been locked. Please contact administrator.'
			];
		}

		// Login successful
		$this->CI->LoginAttemptModel->log($user['user_id'], true);
		$this->CI->LoginAttemptModel->clear_attempts_by_ip($ip);

		// Update last login
		$this->CI->UserModel->update_last_login($user['user_id']);

		// Create session
		$this->create_session($user['user_id'], $remember);

		// Log audit
		$this->CI->AuditLogModel->log('user.login', [
			'user_id' => $user['user_id'],
			'username' => $user['username'],
			'email' => $user['email']
		], $user['user_id']);

		return [
			'success' => true,
			'message' => 'Login successful.',
			'user' => $user
		];
	}

	/**
	 * Logout user
	 */
	public function logout()
	{
		$user_id = $this->user_id;

		// Revoke session
		$session_token = $this->CI->session->userdata('session_token');
		if ($session_token) {
			$this->CI->UserSessionModel->revoke_by_token($session_token);
		}

		// Log audit
		if ($user_id) {
			$this->CI->AuditLogModel->log('user.logout', null, $user_id);
		}

		// Destroy session
		$this->CI->session->sess_destroy();

		return true;
	}

	/**
	 * Create user session
	 */
	private function create_session($user_id, $remember = false)
	{
		// Get user with roles
		$user = $this->CI->UserModel->get_by_id($user_id);

		if (!$user) {
			return false;
		}

		// Get user roles
		$this->CI->load->model('RoleModel');
		$roles = $this->CI->RoleModel->get_user_roles($user_id);

		// Create database session
		$session_data = [
			'user_id' => $user_id
		];

		$db_session = $this->CI->UserSessionModel->create($session_data);

		// Set session data
		$sess_data = [
			'user_id' => $user['user_id'],
			'username' => $user['username'],
			'email' => $user['email'],
			'session_token' => $db_session['session_token'],
			'is_logged_in' => true,
			'roles' => array_column($roles, 'role_name')
		];

		$this->CI->session->set_userdata($sess_data);

		return true;
	}

	/**
	 * Check if user is logged in
	 */
	public function is_logged_in()
	{
		return $this->CI->session->userdata('is_logged_in') === true;
	}

	/**
	 * Get current user
	 */
	public function user()
	{
		return $this->user_data;
	}

	/**
	 * Get current user ID
	 */
	public function user_id()
	{
		return $this->user_id;
	}

	/**
	 * Hash password
	 */
	public function hash_password($password)
	{
		$salt = bin2hex(random_bytes(16));
		$hash = hash('sha256', $password . $salt);

		return [
			'hash' => $hash,
			'salt' => $salt
		];
	}

	/**
	 * Verify password
	 */
	public function verify_password($password, $hash, $salt)
	{
		$verify_hash = hash('sha256', $password . $salt);
		return hash_equals($hash, $verify_hash);
	}

	/**
	 * Change password
	 */
	public function change_password($user_id, $old_password, $new_password)
	{
		$user = $this->CI->UserModel->get_by_id($user_id);

		if (!$user) {
			return [
				'success' => false,
				'message' => 'User not found.'
			];
		}

		// Verify old password
		if (!$this->verify_password($old_password, $user['password_hash'], $user['password_salt'])) {
			return [
				'success' => false,
				'message' => 'Current password is incorrect.'
			];
		}

		// Hash new password
		$hashed = $this->hash_password($new_password);

		// Update password
		$this->CI->UserModel->update($user_id, [
			'password_hash' => $hashed['hash'],
			'password_salt' => $hashed['salt'],
			'updated_at' => date('Y-m-d H:i:s')
		]);

		// Revoke all sessions except current
		$session = $this->CI->UserSessionModel->get_by_token($this->CI->session->userdata('session_token'));
		if ($session) {
			$this->CI->UserSessionModel->revoke_all_user_sessions($user_id, $session['session_id']);
		}

		// Log audit
		$this->CI->AuditLogModel->log('user.password_changed', null, $user_id);

		return [
			'success' => true,
			'message' => 'Password changed successfully.'
		];
	}

	/**
	 * Require login
	 */
	public function require_login($redirect = true)
	{
		if (!$this->is_logged_in()) {
			if ($redirect) {
				redirect('auth/login');
			}
			return false;
		}
		return true;
	}

	/**
	 * Register new user
	 */
	public function register($data)
	{
		// Check if email exists
		if ($this->CI->UserModel->email_exists($data['email'])) {
			return [
				'success' => false,
				'message' => 'Email already exists.'
			];
		}

		// Check if username exists
		if ($this->CI->UserModel->username_exists($data['username'])) {
			return [
				'success' => false,
				'message' => 'Username already exists.'
			];
		}

		// Hash password
		$hashed = $this->hash_password($data['password']);

		// Prepare user data
		$user_data = [
			'email' => $data['email'],
			'username' => $data['username'],
			'password_hash' => $hashed['hash'],
			'password_salt' => $hashed['salt'],
			'is_active' => isset($data['is_active']) ? $data['is_active'] : 0,
			'created_at' => date('Y-m-d H:i:s')
		];

		// Create user
		$user_id = $this->CI->UserModel->create($user_data);

		if ($user_id) {
			// Assign default role
			$this->CI->load->model('RoleModel');
			$this->CI->RoleModel->assign_to_user($user_id, 4); // User role

			// Log audit
			$this->CI->AuditLogModel->log('user.registered', [
				'user_id' => $user_id,
				'username' => $data['username'],
				'email' => $data['email']
			]);

			return [
				'success' => true,
				'message' => 'Registration successful.',
				'user_id' => $user_id
			];
		}

		return [
			'success' => false,
			'message' => 'Registration failed. Please try again.'
		];
	}
}
