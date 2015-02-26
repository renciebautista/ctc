<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {
    
    public function get_all(){
        $this->db->join('roles','roles.role_id = users.role_id');
        return $this->db->get('users')->result_array();
    }
    
    public function get_all_role(){
        $this->db->order_by('roles','asc');
        return $this->db->get('roles')->result_array();
    }
    

    public function add($data){
    	$this->db->set('display_name',strtoupper($data['display_name']));
    	$this->db->set('username',$data['username']);
    	$this->db->set('pass',md5($data['password']));
    	$this->db->set('role_id',$data['role_id']);
    	$this->db->set('active','ON');
    	$this->db->insert('users');
    	return TRUE;
    }

    public function get_user($id){
        $this->db->where('id',$id);
        return $this->db->get('users')->row_array();
    }

    public function update($user_id,$data){
        $this->db->where('id',$user_id);
        $this->db->set('display_name',strtoupper($data['display_name']));
        $this->db->set('role_id',$data['role_id']);
        $active = 'OFF';
        if($data['active'] == '1'){
             $active = 'ON';
        }
        $this->db->set('active',$active);
        $this->db->update('users');
        return TRUE;
    }

    public function id_exist($id){
        $this->db->where('id',$id);
        $row = $this->db->get('users')->row_array();
        if($row){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}