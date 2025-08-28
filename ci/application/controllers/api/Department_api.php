<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load base API controller
require_once APPPATH . 'controllers/api/API_Base.php';

/**
 * Department API Controller
 * 
 * Handle CRUD operations untuk departments
 */
class Department_api extends API_Base {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Department_list');
    }
    
    // GET /api/department_api/departments
    public function departments_get() {
        if ($this->request_method !== 'GET') {
            $this->error_response('Method not allowed', 405);
            return;
        }
        
        try {
            // Pagination parameters
            $page = $this->input->get('page') ?: 1;
            $limit = $this->input->get('limit') ?: 10;
            $offset = ($page - 1) * $limit;
            
            // Search parameter
            $search = $this->input->get('search');
            
            $departments = $this->Department_list->get_departments_api($limit, $offset, $search);
            $total = $this->Department_list->count_departments($search);
            
            $this->success_response([
                'departments' => $departments,
                'pagination' => [
                    'current_page' => (int)$page,
                    'per_page' => (int)$limit,
                    'total' => (int)$total,
                    'total_pages' => ceil($total / $limit)
                ]
            ]);
            
        } catch (Exception $e) {
            $this->error_response('Failed to fetch departments: ' . $e->getMessage(), 500);
        }
    }

    // GET /api/department_api/department/1
    public function department_get($id = null) {
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
    public function create_post() {
        if ($this->request_method !== 'POST') {
            $this->error_response('Method not allowed', 405);
            return;
        }
        
        // Validation rules
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[2]');

        if ($this->form_validation->run() === FALSE) {
            $this->error_response(validation_errors(), 400);
            return;
        }
        
        try {
            $data = [
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $department_id = $this->Department_list->insert_department($data);

            $this->success_response([
                'department_id' => $department_id
            ], 'Department created successfully');

        } catch (Exception $e) {
            $this->error_response('Failed to create department: ' . $e->getMessage(), 500);
        }
    }
}