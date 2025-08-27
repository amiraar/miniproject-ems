<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_Jobs extends CI_Model {

	public function add_job( $job_details )
	{
		$this->db->insert('jobs', $job_details);
	}

	public function get_all_jobs()
	{
		return $this->db->get('jobs')->result();
	}

	public function get_all_jobs_with_department()
	{
		$this->db->select('jobs.*, department.d_name');
		$this->db->from('jobs');
		$this->db->join('department', 'jobs.d_id = department.d_id', 'left');
		return $this->db->get()->result();
	}

	public function get_job($j_id)
	{
		return $this->db->get_where('jobs', array('j_id' => $j_id))->row();
	}

	public function update_job($j_id, $job_data)
	{
		$this->db->where('j_id', $j_id);
		return $this->db->update('jobs', $job_data);
	}

}

/* End of file Jobs.php */
/* Location: ./application/models/Jobs.php */