<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load base API controller
require_once APPPATH . 'controllers/api/API_Base.php';

/**
 * Department API Controller
 * 
 * Handle CRUD operations untuk departments
 */
class Api_department extends API_Base {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Department_list');
    }
    
    // GET /api/department_api/departments
    public function departments() {
        if (!$this->validate_method(['GET'])) {
            return;
        }
        
        try {
            // Get pagination parameters
            $pagination = $this->get_pagination_params();
            
            // Search parameter
            $search = $this->input->get('search');
            
            // Get departments
            $departments = $this->Department_list->get_departments_api(
                $pagination['limit'], 
                $pagination['offset'], 
                $search
            );
            
            // Get total count
            $total = $this->Department_list->count_departments($search);
            
            // Build response with pagination metadata
            $meta = $this->build_pagination_meta($total, $pagination['page'], $pagination['limit']);
            
            $this->success_response($departments, 'Departments retrieved successfully', $meta);
            
        } catch (Exception $e) {
            $this->error_response('Failed to fetch departments: ' . $e->getMessage(), 500);
        }
    }

    // GET /api/department_api/department/1
    public function department($id = null) {
        if ($this->request_method !== 'GET') {
            $this->error_response('Method not allowed', 405);
            return;
        }
        
        if (!$id) {
            $this->error_response('Department ID required', 400);
            return;
        }
        
        try {
            $department = $this->Department_list->get_department_by_id($id);

            if (!$department) {
                $this->error_response('Department not found', 404);
                return;
            }
            
            $this->success_response($department);
            
        } catch (Exception $e) {
            $this->error_response('Failed to fetch department: ' . $e->getMessage(), 500);
        }
    }
    
    // POST /api/department_api/create
    public function create() {
        if ($this->request_method !== 'POST') {
            $this->error_response('Method not allowed', 405);
            return;
        }
        
        // Get JSON input or POST data
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            $input = $_POST;
        }
        
        // Basic validation
        if (empty($input['name'])) {
            $this->error_response('Name field is required', 400);
            return;
        }
        
        if (strlen($input['name']) < 2) {
            $this->error_response('Name must be at least 2 characters', 400);
            return;
        }
        
        try {
            $data = [
                'name' => trim($input['name'])
            ];

            $result = $this->Department_list->create_department($data);

            if ($result) {
                // Get the created department
                $created_department = $this->Department_list->get_department_by_id($result);
                
                $this->success_response('Department created successfully', $created_department, 201);
            } else {
                $this->error_response('Failed to create department', 500);
            }
        } catch (Exception $e) {
            $this->error_response('Failed to create department: ' . $e->getMessage(), 500);
        }
    }
}