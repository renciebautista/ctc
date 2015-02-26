<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Holidays_model extends CI_Model {

	public function getAll(){
		$this->db->where('date >=',date('Y-m-d'));
		$this->db->order_by('date','asc');
		return $this->db->get('holidays')->result_array();
	}

	public function add(){
		$desc = trim($this->input->post('desc',TRUE));
		$date = trim($this->input->post('date',TRUE));

		if($this->date_exist($date)){
			return FALSE;
		}else{			
			$this->db->set('desc',ucwords(strtolower($desc)));
			$this->db->set('date',date("Y-m-d", strtotime($date)));
			$this->db->insert('holidays');
			return TRUE;
		}

	}

	public function update($id){
		$desc = trim($this->input->post('desc',TRUE));
		$date = trim($this->input->post('date',TRUE));

		if($this->date_exist($date,$id)){
			return FALSE;
		}else{
			$this->db->where('id',$id);
			$this->db->set('desc',ucwords(strtolower($desc)));
			$this->db->set('date',date("Y-m-d", strtotime($date)));
			$this->db->update('holidays');
			return TRUE;
		}

	}

	public function delete($id){
        $this->db->where('id',$id);
        $this->db->delete('holidays');

        return TRUE;
    }

	public function isHoliday($date){
		$this->db->where('date',$date);
		$row = $this->db->get('holidays')->row_array();
		if($row){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function getHoliday($date){
		$this->db->select('desc');
		$this->db->where('date',$date);
		return $this->db->get('holidays')->row_array();
	}

	/**
	 * check if id exist
	 * @param int
	 * @return boolean
	 */
	public function id_exist($id){
		$this->db->where('id',$id);
		$row = $this->db->get('holidays')->row_array();
		if($row){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	 * fetch holiday by id
	 * @param int
	 * @return array
	 */
	public function get_by_id($id){
		$this->db->where('id',$id);
		return $this->db->get('holidays')->row_array();
	}

	/**
	 * check if date exist
	 * @param string
	 * @return boolean
	 */
	public function date_exist($date,$id=null){
		if(!is_null($id)){
			$this->db->where('id !=',$id);
		}
		$this->db->where('date',date("Y-m-d", strtotime($date)));
		$row = $this->db->get('holidays')->row_array();
		if($row){
			return TRUE;
		}else{
			return FALSE;
		}
	}

}
