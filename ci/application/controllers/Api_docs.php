<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_docs extends CI_Controller {
    
    public function index() {
        $data['title'] = 'API Documentation - CodeIgniter EMS';
        $this->load->view('api_docs', $data);
    }
}

/* End of file Api_docs.php */
/* Location: ./application/controllers/Api_docs.php */