<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group_model extends CI_Model {

	protected $table = 'groups';

	/**
	 * fetch all group
	 * @return array
	 */
	public function get_all(){
		return $this->db->get($this->table)->result_array();
	}

	/**
	 * fetch group by id
	 * @param int
	 * @return array
	 */
	public function get_by_id($id){
		$this->db->where('id',$id);
		return $this->db->get($this->table)->row_array();
	}

	/**
	 * fetch all group
	 * @return array
	 */
	public function search($string){
		$this->db->like('group',$string);
		return $this->db->get($this->table)->result_array();
	}

	/**
	 * fetch group with sub group
	 * @return array
	 */
	public function get_with_sub(){
		$groups = $this->get_all();
		$data = array();
		if(count($groups)>0){
			foreach ($groups as $group) {
				$array['group'] = $group['group'];
				$array['sub_group'] = $this->Subgroup_model->get_sub_group_by_id($group['id']);
				$data[] = $array;
			}
			return $data;
		}
		return null;
	}

	/**
	 * add new group
	 * @param string
	 * @return boolean
	 */
	public function add_new($group){
		if($this->_group_name_exist($group)){
			return FALSE;
		}else{
			$this->db->set('group',strtoupper($group));
			$this->db->insert($this->table);
			return TRUE;
		}
	}

	/**
	 * update group name
	 * @param string
	 * @return boolean
	 */
	public function update($group,$id){
		if($this->_group_name_exist($group,$id)){
			return FALSE;
		}else{
			$this->db->where('id',$id);
			$this->db->set('group',strtoupper($group));
			$this->db->update($this->table);
			return TRUE;
		}
	}

	/**
	 * check if group name already exist
	 * @param string
	 * @return boolean
	 */
	private function _group_name_exist($group,$id=null){
		if(!is_null($id)){
			$this->db->where('id !=',$id);
		}
		$this->db->where('group',$group);
		$row = $this->db->get($this->table)->row_array();
		if($row){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	 * check if group id exist
	 * @param int
	 * @return boolean
	 */
	public function id_exist($id){
		$this->db->where('id',$id);
		$row = $this->db->get($this->table)->row_array();
		if($row){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	 * delete group
	 * @param int
	 * @return boolean
	 */
	public function delete($id){
		if($this->Subgroup_model->have_parent($id)){
			return FALSE;
		}else{
			$this->db->where('id',$id);
			$this->db->delete($this->table);
			return TRUE;
		}
	}

}

/* End of file group_model.php */
/* Location: ./application/models/group_model.php */