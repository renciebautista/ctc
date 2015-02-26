<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_model extends CI_Model {

	private $table = 'contacts';
	/**
	 * fetch contact by contact no
	 * @param string
	 * @return array
	 */
	public function get_contact_by_contactno($contact_no){
		$this->db->where('contact_no',$contact_no);
		return $this->db->get($this->table)->row_array();
	}

}

/* End of file contact_model.php */
/* Location: ./application/models/contact_model.php */