<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load base API controller
require_once APPPATH . 'controllers/api/API_Base.php';

class Employee_api extends API_Base {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Employees_list');
    }
    
    // GET /api/employee_api/employees
    public function employees_get() {
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
            
            $employees = $this->Employee_model->get_employees_api($limit, $offset, $search);
            $total = $this->Employee_model->count_employees($search);
            
            $this->success_response([
                'employees' => $employees,
                'pagination' => [
                    'current_page' => (int)$page,
                    'per_page' => (int)$limit,
                    'total' => (int)$total,
                    'total_pages' => ceil($total / $limit)
                ]
            ]);
            
        } catch (Exception $e) {
            $this->error_response('Failed to fetch employees: ' . $e->getMessage(), 500);
        }
    }
    
    // GET /api/employee_api/employee/1
    public function employee_get($id = null) {
        if ($this->request_method !== 'GET') {
            $this->error_response('Method not allowed', 405);
            return;
        }
        
        if (!$id) {
            $this->error_response('Employee ID required', 400);
            return;
        }
        
        try {
            $employee = $this->Employee_model->get_employee_by_id($id);
            
            if (!$employee) {
                $this->error_response('Employee not found', 404);
                return;
            }
            
            $this->success_response($employee);
            
        } catch (Exception $e) {
            $this->error_response('Failed to fetch employee: ' . $e->getMessage(), 500);
        }
    }
    
    // POST /api/employee_api/create
    public function create_post() {
        if ($this->request_method !== 'POST') {
            $this->error_response('Method not allowed', 405);
            return;
        }
        
        // Validation rules
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[2]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->error_response(validation_errors(), 400);
            return;
        }
        
        try {
            $data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'department_id' => $this->input->post('department_id'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $employee_id = $this->Employee_model->insert_employee($data);
            
            $this->success_response([
                'employee_id' => $employee_id
            ], 'Employee created successfully');
            
        } catch (Exception $e) {
            $this->error_response('Failed to create employee: ' . $e->getMessage(), 500);
        }
    }
}