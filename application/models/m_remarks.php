<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Remarks extends CI_Model{
    
    protected $table = 'request_remarks';

    public function add($data){        
        $this->db->set('request_id',$data['id']);
       	$this->db->set('created_by',$data['user_id']);
       	$this->db->set('remarks',$data['remarks']);
       	$this->db->set('status_id',$data['status_id']);
       	$this->db->set('created_at',date('YmdHis'));
        $this->db->insert('request_remarks');
    }

    public function getThread($id){        
        $this->db->where('request_id',$id);
        $this->db->join('request_status','request_status.id = request_remarks.status_id','left');
        $this->db->join('users','users.id = request_remarks.created_by','left');
        $this->db->order_by('created_at','desc');
        return $this->db->get($this->table)->result_array();
    }
}