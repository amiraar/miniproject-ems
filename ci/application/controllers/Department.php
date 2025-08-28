<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Department_jobs');
	}

	public function index()
	{
		// Default to listing departments
		return $this->view_department();
	}

	public function view_department()
	{
		$this->load->view('dash/department_list');
	}

	public function add_department()
	{
		// Render form on GET
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			return $this->load->view('dash/add_department');
		}

		if ( $this->input->post('add_department') ) 
		{
			$d_name = $this->input->post('d_name');

			$department_data = array(
				'd_name'	=>	$d_name
			);

			$this->Department_jobs->add_department($department_data);

			// Go back to list (index now shows list)
			redirect('department','refresh');

		}
	}

	public function update_department( $d_id )
	{
		$data['d_id'] = $d_id;
		$this->load->view('dash/update_department', $data);
	}

	public function update_process_department( $d_id )
	{
		if ( $this->input->post('update_department') ) 
		{
			$d_name = $this->input->post('d_name');
			
			if (empty($d_name)) {
				redirect('department/update_department/'.$d_id,'refresh');
				return;
			}
			
			$department_details = array( 
				'd_name'	=> $d_name
			);
			$this->db->where('d_id', $d_id);
			$this->db->update('department', $department_details);
			redirect('department','refresh');
		} else {
			redirect('department','refresh');
		}
	}

	public function delete_department( $d_id )
	{
		$this->db->where('d_id', $d_id);
		$this->db->delete('department');
		redirect('department','refresh');
	}

}

/* End of file department.php */
/* Location: ./application/controllers/department.php */