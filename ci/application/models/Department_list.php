<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_list extends CI_Model {

	public function insert_department( $department_details )
	{
		$this->db->insert('department', $department_details);
	}

}

/* End of file Department_list.php */
/* Location: ./application/models/Department_list.php */