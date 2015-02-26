<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Filters_model extends CI_Model {

	public $table = 'filters';
	public $primary_id = 'filter_id';

	public function add($data){
		$this->db->set('contact_no',trim($data['contact_no']));
		$this->db->set('notes',trim($data['notes']));
		$this->db->set('retry',(int)$data['retry']);
		$this->db->set('created_by',$data['created_by']);
		$this->db->set('date_created',date('YmdHis'));
		$this->db->insert($this->table);

		if($this->db->insert_id()>0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function update($f_id,$data){
		$this->db->where('filter_id',$f_id);
		$this->db->set('contact_no',trim($data['contact_no']));
		$this->db->set('notes',trim($data['notes']));
		$this->db->set('retry',(int)$data['retry']);
		$this->db->set('created_by',$data['created_by']);
		$this->db->set('date_modified',date('YmdHis'));
		$this->db->update($this->table);

		return TRUE;
	}

	public function update_filter($f_id,$data){
		$this->db->where('filter_id',$f_id);
		$this->db->set('tries',(int)$data['tries']);
		$this->db->set('status',(int)$data['status']);
		
		$this->db->set('date_modified',date('YmdHis'));
		$this->db->update($this->table);

		return TRUE;
	}

	public function search($search){
		$this->db->where('contact_no',$search);
		$this->db->where('status',0);
		return $this->db->get($this->table)->result_array();
	}

	public function get_by_id($filter_id){
		$this->db->where('filter_id',$filter_id);
		return $this->db->get($this->table)->row_array();
	}

	public function id_exist($filter_id){
		$this->db->where('filter_id',$filter_id);
		$this->db->where('status',0);
		$row = $this->db->get($this->table)->row_array();
		if($row){
			return TRUE;
		}else{
			return FALSE;
		}
	}

}

/* End of file filters_model.php */
/* Location: ./application/models/admin/filters_model.php */