<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_list extends CI_Model {

    /**
     * Insert new department
     * 
     * @param array $department_details
     * @return int Department ID
     */
    public function insert_department($department_details) {
        $this->db->insert('department', $department_details);
        return $this->db->insert_id();
    }
    
    /**
     * Get departments with pagination for API
     * 
     * @param int $limit
     * @param int $offset
     * @param string $search
     * @return array
     */
    public function get_departments_api($limit = 10, $offset = 0, $search = null) {
        $this->db->select('d_id as id, d_name as name, d_date as created_at');
        $this->db->from('department');
        
        if ($search) {
            $this->db->group_start();
            $this->db->like('d_name', $search);
            $this->db->group_end();
        }
        
        $this->db->limit($limit, $offset);
        $this->db->order_by('d_id', 'DESC');
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Count total departments
     * 
     * @param string $search
     * @return int
     */
    public function count_departments($search = null) {
        $this->db->from('department');
        
        if ($search) {
            $this->db->group_start();
            $this->db->like('d_name', $search);
            $this->db->group_end();
        }
        
        return $this->db->count_all_results();
    }
    
    /**
     * Get department by ID
     * 
     * @param int $id
     * @return array|null
     */
    public function get_department_by_id($id) {
        $this->db->select('d_id as id, d_name as name, d_date as created_at');
        $this->db->where('d_id', $id);
        $query = $this->db->get('department');
        
        return $query->row_array();
    }
    
    /**
     * Update department
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update_department($id, $data) {
        $this->db->where('d_id', $id);
        return $this->db->update('department', $data);
    }
    
    /**
     * Delete department
     * 
     * @param int $id
     * @return bool
     */
    public function delete_department($id) {
        $this->db->where('d_id', $id);
        return $this->db->delete('department');
    }
    
    /**
     * Create new department
     * 
     * @param array $data
     * @return int|false
     */
    public function create_department($data) {
        $insert_data = [
            'd_name' => $data['name'],
            'd_date' => date('Y-m-d H:i:s')
        ];
        
        if ($this->db->insert('department', $insert_data)) {
            return $this->db->insert_id();
        }
        
        return false;
    }
    
    /**
     * Get all departments (simple list)
     * 
     * @return array
     */
    public function get_all_departments() {
        $this->db->select('d_id as id, d_name as name, d_date as created_at');
        $this->db->from('department');
        $this->db->order_by('d_name', 'ASC');
        
        return $this->db->get()->result_array();
    }
}

/* End of file Department_list.php */
/* Location: ./application/models/Department_list.php */