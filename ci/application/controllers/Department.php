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
		$this->load->view('dash/add_department');
	}

	public function view_department()
	{
		$this->load->view('dash/department_list');
	}

	public function add_department()
	{
		if ( $this->input->post('add_department') ) 
		{
			$d_name = $this->input->post('d_name');

			$department_data = array(
				'd_name'	=>	$d_name
			);

			$this->Department_jobs->add_department($department_data);

			redirect('department/view_department','refresh');

		}
	}

	public function update_department( $d_id )
	{
		$this->load->view('dash/update_department', $d_id);
	}

	public function update_process_department( $d_id )
	{
		if ( $this->input->post('update_department') ) 
		{
			$d_name = $this->input->post('d_name');
			$department_details = array( 
				'd_name'	=> $d_name
			);
			$this->db->where('d_id', $d_id);
			$this->db->update('department', $department_details);
			redirect('department/view_department','refresh');
		}
	}

	public function delete_department( $d_id )
	{
		$this->db->where('d_id', $d_id);
		$this->db->delete('department');
		redirect('department/view_department','refresh');
	}

}

/* End of file department.php */
/* Location: ./application/controllers/department.php */