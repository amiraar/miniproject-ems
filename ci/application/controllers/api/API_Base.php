<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base API Controller
 * 
 * Controller dasar untuk semua API endpoints
 * Menyediakan fungsi umum untuk response format, CORS, dan validasi
 */
class API_Base extends CI_Controller {
    
    protected $request_method;
    protected $allowed_methods = ['GET', 'POST', 'PUT', 'DELETE'];
    
    public function __construct() {
        parent::__construct();
        
        // Set JSON response header
        $this->output->set_content_type('application/json');
        
        // Get request method
        $this->request_method = $this->input->server('REQUEST_METHOD');
        
        // Load helpers and libraries
        $this->load->helper('url');
        $this->load->library('form_validation');
        
        // CORS headers untuk mendukung cross-origin requests
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        $this->output->set_header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        
        // Handle preflight OPTIONS request
        if ($this->request_method === 'OPTIONS') {
            $this->output->set_status_header(200);
            $this->output->set_output('');
            return;
        }
    }
    
    /**
     * Send JSON response dengan format standar
     * 
     * @param array $data Data yang akan dikirim
     * @param int $status HTTP status code
     */
    protected function response($data, $status = 200) {
        $this->output->set_status_header($status);
        $this->output->set_output(json_encode($data, JSON_PRETTY_PRINT));
    }
    
    /**
     * Send error response
     * 
     * @param string $message Error message
     * @param int $status HTTP status code
     * @param array $errors Detail errors (optional)
     */
    protected function error_response($message, $status = 400, $errors = null) {
        $response = [
            'status' => 'error',
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s'),
            'path' => $this->uri->uri_string()
        ];
        
        if ($errors !== null) {
            $response['errors'] = $errors;
        }
        
        // Log error untuk debugging
        log_message('error', "[API ERROR] {$status}: {$message} - Path: " . $this->uri->uri_string());
        
        $this->response($response, $status);
    }
    
    /**
     * Send success response
     * 
     * @param mixed $data Data yang akan dikirim (optional)
     * @param string $message Success message
     * @param array $meta Metadata tambahan (pagination, etc)
     */
    protected function success_response($data = null, $message = 'Success', $meta = null) {
        $response = [
            'status' => 'success',
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        if ($data !== null) {
            $response['data'] = $data;
        }
        
        if ($meta !== null) {
            $response['meta'] = $meta;
        }
        
        $this->response($response, 200);
    }
    
    /**
     * Validasi method HTTP yang diizinkan
     * 
     * @param array $allowed_methods Array method yang diizinkan
     * @return bool
     */
    protected function validate_method($allowed_methods = []) {
        if (empty($allowed_methods)) {
            return true;
        }
        
        if (!in_array($this->request_method, $allowed_methods)) {
            $this->error_response(
                'Method not allowed. Allowed methods: ' . implode(', ', $allowed_methods), 
                405
            );
            return false;
        }
        
        return true;
    }
    
    /**
     * Validasi required parameters
     * 
     * @param array $required_params Array parameter yang wajib ada
     * @param string $source Source data ('get', 'post', 'input')
     * @return bool
     */
    protected function validate_required_params($required_params, $source = 'post') {
        $missing_params = [];
        
        foreach ($required_params as $param) {
            $value = null;
            
            switch ($source) {
                case 'get':
                    $value = $this->input->get($param);
                    break;
                case 'post':
                    $value = $this->input->post($param);
                    break;
                case 'input':
                    $value = $this->input->input_stream($param);
                    break;
            }
            
            if ($value === null || $value === '') {
                $missing_params[] = $param;
            }
        }
        
        if (!empty($missing_params)) {
            $this->error_response(
                'Missing required parameters',
                400,
                ['missing_parameters' => $missing_params]
            );
            return false;
        }
        
        return true;
    }
    
    /**
     * Sanitize input data untuk mencegah XSS
     * 
     * @param mixed $data Data yang akan di-sanitize
     * @return mixed
     */
    protected function sanitize_input($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->sanitize_input($value);
            }
        } else {
            // XSS cleaning
            $data = $this->security->xss_clean($data);
            // Trim whitespace
            $data = trim($data);
        }
        
        return $data;
    }
    
    /**
     * Get pagination parameters from request
     * 
     * @return array
     */
    protected function get_pagination_params() {
        $page = (int) $this->input->get('page') ?: 1;
        $limit = (int) $this->input->get('limit') ?: 10;
        
        // Validasi limit maksimal untuk mencegah overload
        $max_limit = 100;
        if ($limit > $max_limit) {
            $limit = $max_limit;
        }
        
        $offset = ($page - 1) * $limit;
        
        return [
            'page' => $page,
            'limit' => $limit,
            'offset' => $offset
        ];
    }
    
    /**
     * Build pagination metadata
     * 
     * @param int $total Total records
     * @param int $page Current page
     * @param int $limit Records per page
     * @return array
     */
    protected function build_pagination_meta($total, $page, $limit) {
        $total_pages = ceil($total / $limit);
        
        return [
            'pagination' => [
                'current_page' => $page,
                'per_page' => $limit,
                'total' => $total,
                'total_pages' => $total_pages,
                'has_next' => $page < $total_pages,
                'has_prev' => $page > 1
            ]
        ];
    }
}