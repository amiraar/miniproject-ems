<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load base API controller
require_once APPPATH . 'controllers/api/API_Base.php';

/**
 * Simple API Test Controller
 */
class Api_test extends API_Base {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->success_response([
            'message' => 'API is working!',
            'time' => date('Y-m-d H:i:s'),
            'method' => $this->request_method
        ], 'API Test successful');
    }
    
    public function departments() {
        $this->load->model('Department_list');
        
        try {
            $departments = $this->Department_list->get_all_departments();
            
            $this->success_response($departments, 'Departments retrieved successfully');
            
        } catch (Exception $e) {
            $this->error_response('Failed to fetch departments: ' . $e->getMessage(), 500);
        }
    }
}