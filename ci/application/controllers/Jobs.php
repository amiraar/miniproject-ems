<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Employee_Jobs');
		$this->load->model('Department_jobs');
	}

	public function index()
	{
		// Default to listing jobs
		return $this->view_jobs();
	}

	public function view_jobs()
	{
		$data['jobs'] = $this->Employee_Jobs->get_all_jobs_with_department();
		$this->load->view('dash/job_list', $data);
	}

	public function add_job()
	{
		// Render form on GET
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			$data['departments'] = $this->Department_jobs->get_all_departments();
			return $this->load->view('dash/add_job', $data);
		}

		if ( $this->input->post('add_job') ) 
		{
			$j_name = $this->input->post('j_name');
			$d_id = $this->input->post('d_id');

			$job_data = array(
				'j_name'	=>	$j_name,
				'd_id'		=>	$d_id
			);

			$this->Employee_Jobs->add_job($job_data);

			// Go back to list (index now shows list)
			redirect('jobs','refresh');

		}
	}

	public function update_job( $j_id )
	{
		$data['job'] = $this->Employee_Jobs->get_job($j_id);
		$data['departments'] = $this->Department_jobs->get_departments();

		$this->load->view('dash/update_job', $data);
	}

	public function update_process_jobs( $j_id )
	{
		if ( $this->input->post('update_job') ) 
		{
			$j_name = $this->input->post('j_name');
			$d_id = $this->input->post('d_id');

			$job_data = array(
				'j_name'	=>	$j_name,
				'd_id'		=>	$d_id
			);

			$this->Employee_Jobs->update_job($j_id, $job_data);
			redirect('jobs','refresh');
		}
	}

	public function delete_job( $j_id )
	{
		$this->db->where('j_id', $j_id);
		$this->db->delete('jobs');
		redirect('jobs','refresh');
	}

}

/* End of file Jobs.php */
/* Location: ./application/controllers/Jobs.php */