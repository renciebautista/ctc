<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clients_model extends CI_Model {

	private $table = 'contacts';

	public function add($contact_no,$landline_no,$contact_person,$email,$company,$branch,$address){
		if(!$this->_no_exist($contact_no)){
			$this->db->set('contact_no',$contact_no);
			$this->db->set('landline',$landline_no);
			$this->db->set('contact_person',strtoupper($contact_person));
			$this->db->set('email',$email);
			$this->db->set('company',strtoupper($company));
			$this->db->set('branch',strtoupper($branch));
			$this->db->set('address',strtoupper($address));
			$this->db->set('last_update',date('YmdHis'));
			$this->db->insert($this->table);
		}else{
			$this->db->where('contact_no',$contact_no);
			$this->db->set('landline',$landline_no);
			$this->db->set('contact_person',strtoupper($contact_person));
			$this->db->set('email',$email);
			$this->db->set('company',strtoupper($company));
			$this->db->set('branch',strtoupper($branch));
			$this->db->set('address',strtoupper($address));
			$this->db->set('last_update',date('YmdHis'));
			$this->db->update($this->table);
		}
	}


	private function _no_exist($contact_no){
		$this->db->where('contact_no',$contact_no);
		$row = $this->db->get($this->table)->result_array();
		if(count($row)> 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

}

/* End of file clients_model.php */
/* Location: ./application/models/clients_model.php */