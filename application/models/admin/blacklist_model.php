<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blacklist_model extends CI_Model {

	public $table = 'blacklist';
	public $primary_id = 'blist_id';

	public function search($search){
		$this->db->like('contact_no',$search);
		return $this->db->get($this->table)->result_array();
	}

	public function add($data){
		$this->db->set('contact_no',trim($data['contact_no']));
		$this->db->set('created_by',$data['created_by']);
		$this->db->set('date_created',date('YmdHis'));
		$this->db->insert($this->table);

		if($this->db->insert_id()>0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function id_exist($blist_id){
		$this->db->where('blist_id',$blist_id);
		$row = $this->db->get($this->table)->row_array();
		if($row){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function get_by_id($blist_id){
		$this->db->where('blist_id',$blist_id);
		return $this->db->get($this->table)->row_array();
	}

	public function update($blist_id,$data){
		$this->db->where('blist_id',$blist_id);
		$this->db->set('contact_no',trim($data['contact_no']));
		$this->db->update($this->table);

		return TRUE;
	}

	public function delete($blist_id){
		$this->db->where('blist_id',$blist_id);
		$this->db->delete($this->table);

		return TRUE;
	}

	public function blacklisted($contact_no){
		$this->db->where('contact_no',$contact_no);
		$row = $this->db->get($this->table)->row_array();
		if($row){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}

/* End of file blacklist_model.php */
/* Location: ./application/models/admin/blacklist_model.php */