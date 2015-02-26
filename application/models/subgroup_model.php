<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subgroup_model extends CI_Model {

	protected $table = 'sub_groups';

	/**
	 * get all sub group
	 * @param int
	 * @return array
	 */
	public function get_sub_group_by_id($group_id){
		$this->db->where('group_id',$group_id);
		$this->db->where('active',1);
		$this->db->where('parent_id',0);
		$this->db->order_by('sub_group','asc');
		return $this->db->get($this->table)->result_array();
	}

	/**
	 * check if have parent group
	 * @param int 
	 * @return boolean
	 */
	public function have_parent($group_id){
		$this->db->where('group_id',$group_id);
		$row = $this->db->get($this->table)->row_array();
		if($row){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	 * fetch all sub group
	 * @return array
	 */
	public function search($group_id,$search){
		$this->db->select('sub_groups.sub_group,groups.group,sub_groups.send_to,sub_groups.id,sub_groups.cc');
        $this->db->join('groups','groups.id = sub_groups.group_id');
        $this->db->like('sub_group',$search);
        $this->db->where('parent_id',0);
        if($group_id > 0){
        	$this->db->where('sub_groups.group_id',$group_id);
        }
        
        $this->db->order_by('groups.group');
        return $this->db->get($this->table)->result_array();
	}

	/**
	 * add new subgroup
	 * @param int
	 * @param string
	 * @param string
	 * @return boolean
	 */
	public function add_subgroup($group_id,$sub_group,$sendto,$link,$Cc,$sub_group_parent){
		if($this->_sub_exist($group_id,$sub_group)){
			return FALSE;
		}else{
			$this->db->set('group_id',$group_id);
			$this->db->set('sub_group',$sub_group);
			$this->db->set('parent_id',$sub_group_parent);
			$this->db->set('send_to',$sendto);
			$this->db->set('cc',$Cc);
			$this->db->set('slug',$link);
			$this->db->insert($this->table);
			return TRUE;
		}
	}

	/**
	 * update subgroup
	 * @param int
	 * @param int
	 * @param string
	 * @param string
	 * @return boolean
	 */
	public function update_subgroup($sub_group_id,$group_id,$sub_group,$sendto,$link,$Cc){
		if($this->_sub_exist($group_id,$sub_group,$sub_group_id)){
			return FALSE;
		}else{
			$this->db->where('id',$sub_group_id);
			$this->db->set('group_id',$group_id);
			$this->db->set('sub_group',$sub_group);
			$this->db->set('slug',$link);
			$this->db->set('send_to',$sendto);
			$this->db->set('cc',$Cc);
			$this->db->update($this->table);
			return TRUE;
		}
	}

	/**
	 * check if subgroup already exist in group
	 * @param int
	 * @param string
	 * @return boolean
	 */
	private function _sub_exist($group_id,$subgroup,$sub_group_id = null){
		if(!is_null($sub_group_id)){
			$this->db->where('id !=',$sub_group_id);
		}
		$this->db->where('group_id',$group_id);
		$this->db->where('sub_group',$subgroup);
		$row = $this->db->get($this->table)->row_array();
		if($row){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	 * get subgroup by id
	 * @param int
	 * @return array
	 */
	public function get_by_id($id){
		$this->db->where('id',$id);
		return $this->db->get($this->table)->row_array();
	}

	/**
	 * check if subgroup exist
	 * @param int
	 * @param string
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
	 * delete sub group
	 * @param int
	 */
	public function delete($id){
		$this->db->where('id',$id);
		$this->db->delete($this->table);
	}

	/**
	 * fetch record by slug
	 * @param string
	 * @return array
	 */
	public function get_record_by_slug($slug){
		$this->db->where('slug',$slug);
		return $this->db->get($this->table)->row_array();
	}

	/**
	 * fetch record without parent subgroup
	 * @param string
	 * @return array
	 */
	public function get_for_parent(){
		$this->db->where('parent_id',0);
		return $this->db->get($this->table)->result_array();
	}

	/**
	 * fetch sub group by parent id
	 * @param string
	 * @return array
	 */
	public function get_by_parent_id($id){
		$this->db->where('parent_id',$id);
		return $this->db->get($this->table)->result_array();
	}
}

/* End of file subgroup_model.php */
/* Location: ./application/models/subgroup_model.php */