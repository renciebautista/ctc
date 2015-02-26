<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Software_m extends CI_Model {


	/**
     * Get files attached to job order
     * @param int $jo_id
     */

	
	/**
     * Get all active software
     */
	public function getAll(){
		$this->db->where('enable',1);
		$this->db->order_by('name');
		return $this->db->get('software')->result_array();
	}

	/**
     * Get files attached to job order
     * @param int $jo_id
     */
	public function getById($id){
		$this->db->where('id',$id);
		$this->db->where('enable',1);
		return $this->db->get('software')->row_array();
	}
}

/* End of file software_m.php */
/* Location: ./application/models/software_m.php */