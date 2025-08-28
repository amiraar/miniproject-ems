<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load base API controller
require_once APPPATH . 'controllers/api/API_Base.php';

/**
 * Authentication API Controller
 * 
 * Handle authentication endpoints seperti login, logout, register
 */
class Auth_api extends API_Base {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Users');
        $this->load->library('session');
    }
    
    /**
     * User login endpoint
     * POST /api/auth_api/login
     */
    public function login_post() {
        if (!$this->validate_method(['POST'])) {
            return;
        }
        
        // Validasi required parameters
        if (!$this->validate_required_params(['username', 'password'])) {
            return;
        }
        
        $username = $this->sanitize_input($this->input->post('username'));
        $password = $this->input->post('password');
        
        try {
            // Validasi user credentials
            $user = $this->Users->validate_user($username, $password);
            
            if ($user) {
                // Set session
                $session_data = [
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'logged_in' => TRUE
                ];
                $this->session->set_userdata($session_data);
                
                // Return user data (tanpa password)
                unset($user['password']);
                
                $this->success_response($user, 'Login successful');
            } else {
                $this->error_response('Invalid username or password', 401);
            }
            
        } catch (Exception $e) {
            $this->error_response('Login failed: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * User logout endpoint
     * POST /api/auth_api/logout
     */
    public function logout_post() {
        if (!$this->validate_method(['POST'])) {
            return;
        }
        
        try {
            $this->session->sess_destroy();
            $this->success_response(null, 'Logout successful');
        } catch (Exception $e) {
            $this->error_response('Logout failed: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * Check authentication status
     * GET /api/auth_api/status
     */
    public function status_get() {
        if (!$this->validate_method(['GET'])) {
            return;
        }
        
        $is_logged_in = $this->session->userdata('logged_in');
        
        if ($is_logged_in) {
            $user_data = [
                'user_id' => $this->session->userdata('user_id'),
                'username' => $this->session->userdata('username'),
                'logged_in' => true
            ];
            $this->success_response($user_data, 'User is authenticated');
        } else {
            $this->error_response('User not authenticated', 401);
        }
    }
}