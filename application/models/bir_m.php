<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bir_m extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	/**
	 * insert a new bir application
	 * @param $data array
	 */
	public function insert($data){

		$software = $this->Software_m->getById($data['sname']);

		$code = $this->_generateCode();

		$this->db->set('u_id',$code);

		$this->db->set('company_name',$data['company']);
		$this->db->set('store_name',$data['store']);
		$this->db->set('client_email',$data['email']);

		$this->db->set('software',$software['name']);
		$this->db->set('version',$software['version']);

		$this->db->set('date_created',date('YmdHis'));

		$this->db->set('brand',$data['brand']);
		$this->db->set('model',$data['model']);
		$this->db->set('type',$data['type']);
		$this->db->set('serial',$data['serial']);
		$this->db->set('chase_remarks',$data['remarks']);

		$this->db->set('last_update',date('YmdHis'));
		$this->db->set('date_created',date('YmdHis'));

		$this->db->insert('birapplication');
	}

	/**
	 * Generate unique code for client 
	 */
	protected function _generateCode(){
		$code = random_string('alnum',10);
		if($this->codeExist($code)){
			$this->_generateCode();
		}else{
			return strtolower($code);
		}
		
	}

	/**
	 * Check if code already exist
	 * @param $code
	 */
	public function codeExist($code){
		$this->db->where('u_id',$code);
		$row = $this->db->get('birapplication')->row_array();
		if($row){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	 * Get valid application
	 * @param $code
	 */
	public function getByCode($code){
		$this->db->where('u_id',$code);
		return $this->db->get('birapplication')->row_array();
	}

}

/* End of file bir_m.php */
/* Location: ./application/models/bir_m.php */