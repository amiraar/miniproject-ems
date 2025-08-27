<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_jobs extends CI_Model {

	public function add_department( $department_details )
	{
		$this->db->insert('department', $department_details);
	}
	
	public function get_all_departments()
	{
		return $this->db->get('department')->result();
	}

	public function get_departments()
	{
		return $this->db->get('department')->result();
	}

}

/* End of file Department_Jobs.php */
/* Location: ./application/models/Department_Jobs.php */