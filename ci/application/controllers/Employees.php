<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Employees_list');
		$this->load->model('Employee_Jobs');
		$this->load->model('Department_jobs');
	}

	public function index()
	{
		$this->load->view('dash/employees_list');
	}

	public function single_employee( $e_id )
	{
		$this->load->view('dash/single_employee');
	}

	public function add_employee()
	{
		// Get all available jobs with department for dropdown
		$data['jobs'] = $this->Employee_Jobs->get_all_jobs_with_department();
		
		$this->load->view('dash/add_employee', $data);
	}

	public function update_employee( $e_id )
	{
		// Get all available jobs with department for dropdown
		$data['jobs'] = $this->Employee_Jobs->get_all_jobs_with_department();
		$data['e_id'] = $e_id;
		
		$this->load->view('dash/update_employee', $data);
	}

	public function update_employee_process( $e_id )
	{
		$e_name = $this->input->post('e_name');
		$e_email = $this->input->post('e_email');
		$e_phone = $this->input->post('e_phone');
		$e_job = $this->input->post('e_job');
		$e_department = $this->input->post('e_department');

		$employee_details = array(
			'e_name'	=>	$e_name,
			'e_email'	=>	$e_email,
			'e_phone'	=>	$e_phone,
			'e_job'	=>	$e_job,
			'e_department'	=>	$e_department
		);

		$this->db->where('e_id', $e_id);
		$this->db->update('employees', $employee_details);
		redirect('employees','refresh');
	}

	public function add_employee_process()
	{
		if ( $this->input->post('add_employee') ) 
		{
			$e_name = $this->input->post('e_name');
			$e_email = $this->input->post('e_email');
			$e_phone = $this->input->post('e_phone');
			$e_job = $this->input->post('e_job');
			$e_department = $this->input->post('e_department');

			$employee_details = array(
				'e_name'	=>	$e_name,
				'e_email'	=>	$e_email,
				'e_phone'	=>	$e_phone,
				'e_job'	=>	$e_job,
				'e_department'	=>	$e_department
			);

			$this->Employees_list->insert_employee( $employee_details );
			redirect('employees','refresh');
		}
	}

	public function delete_employee( $e_id )
	{
		$this->db->where('e_id', $e_id);
		$this->db->delete('employees');
		redirect('employees','refresh');
	}

}

/* End of file Employees.php */
/* Location: ./application/controllers/Employees.php */