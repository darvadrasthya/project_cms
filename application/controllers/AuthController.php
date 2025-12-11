<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('MY_Auth', null, 'auth');
        $this->load->library('form_validation');
        $this->load->model('UserModel');
        $this->load->model('AuditLogModel');
    }

    /**
     * Login page
     */
    public function login()
    {
        // If already logged in, redirect to dashboard
        if ($this->auth->is_logged_in()) {
            redirect('dashboard');
        }

        $data = [
            'title' => 'Login',
            'subtitle' => 'Sign in to your account'
        ];

        $this->load->view('auth/login', $data);
    }

    /**
     * Process login
     */
    public function do_login()
    {
        $this->form_validation->set_rules('login', 'Email/Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/login');
        }

        $login = $this->input->post('login');
        $password = $this->input->post('password');
        $remember = $this->input->post('remember') ? true : false;

        $result = $this->auth->login($login, $password, $remember);

        if ($result['success']) {
            $this->session->set_flashdata('success', $result['message']);
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', $result['message']);
            redirect('auth/login');
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        $this->auth->logout();
        $this->session->set_flashdata('success', 'You have been logged out successfully.');
        redirect('auth/login');
    }

    /**
     * Register page
     */
    public function register()
    {
        // If already logged in, redirect to dashboard
        if ($this->auth->is_logged_in()) {
            redirect('dashboard');
        }

        $data = [
            'title' => 'Register',
            'subtitle' => 'Create a new account'
        ];

        $this->load->view('auth/register', $data);
    }

    /**
     * Process registration
     */
    public function do_register()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[4]|max_length[50]|is_unique[USERS.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[USERS.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/register');
        }

        $data = [
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'),
            'is_active' => 0 // Needs admin approval
        ];

        $result = $this->auth->register($data);

        if ($result['success']) {
            $this->session->set_flashdata('success', 'Registration successful. Please wait for admin approval.');
            redirect('auth/login');
        } else {
            $this->session->set_flashdata('error', $result['message']);
            redirect('auth/register');
        }
    }

    /**
     * Forgot password page
     */
    public function forgot_password()
    {
        $data = [
            'title' => 'Forgot Password',
            'subtitle' => 'Reset your password'
        ];

        $this->load->view('auth/forgot_password', $data);
    }

    /**
     * Change password page
     */
    public function change_password()
    {
        $this->auth->require_login();

        $data = [
            'title' => 'Change Password',
            'subtitle' => 'Update your password'
        ];

        $this->load->view('auth/change_password', $data);
    }

    /**
     * Process change password
     */
    public function do_change_password()
    {
        $this->auth->require_login();

        $this->form_validation->set_rules('old_password', 'Current Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/change-password');
        }

        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');

        $result = $this->auth->change_password($this->auth->user_id(), $old_password, $new_password);

        if ($result['success']) {
            $this->session->set_flashdata('success', $result['message']);
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', $result['message']);
            redirect('auth/change-password');
        }
    }
}
