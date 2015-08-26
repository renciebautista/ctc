<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Request extends CI_Model{
    
    protected $table = 'requests';

    public function newRequest($data){
        $this->db->set('requesttype_id',$data['requesttype_id']);
        $this->db->set('contact_no',$data['contact_no']);
        $this->db->set('contact_person',$data['contact_person']);
        $this->db->set('email',$data['email']);
        $this->db->set('company_name',$data['company_name']);
        $this->db->set('branch',$data['branch']);
        $this->db->set('address',$data['address']);
        $this->db->set('created_at',date('YmdHis'));
        $this->db->set('updated_at',date('YmdHis'));
        $this->db->insert('requests');
        
        return $this->db->insert_id();
    }

    public function get_by_id($id){
        $this->db->select('requests.id,status_desc,sub_group,company_name,branch,
            created_at,updated_at,address,contact_person,contact_no,email,details');
        $this->db->where('requests.id',$id);
        $this->db->join('sub_groups','sub_groups.id = requests.requesttype_id','left');
        $this->db->join('request_status','request_status.id = requests.status_id','left');
        return $this->db->get($this->table)->row_array();
    }

    public function update($id,$status_id){
        $this->db->set('status_id',$status_id);
        $this->db->set('updated_at',date('YmdHis'));
        $this->db->where('id',$id);
        $this->db->update('requests');
    }

     public function updateDetails($id,$details){
        $this->db->set('details',$details);
        $this->db->where('id',$id);
        $this->db->set('updated_at',date('YmdHis'));
        $this->db->update('requests');
    }

    public function search($status,$type,$search,$from,$to,$filters){
        if(count($filters) > 0){
            $filters_array = implode(",", $filters);
            $strstatus='';
            if($status > 0){
                $strstatus .= ' AND requests.status_id = '.$status;
            }
            if($type > 0){
                $strstatus .= ' AND requests.requesttype_id = '.$type;
            }
            $query = sprintf("SELECT requests.id,status_desc,sub_group,company_name,branch,created_at
                FROM (requests) 
                JOIN sub_groups ON sub_groups.id = requests.requesttype_id
                JOIN request_status ON request_status.id = requests.status_id
                WHERE requests.requesttype_id IN (%s)
                AND (company_name LIKE '%%%s%%' OR branch LIKE '%%%s%%' OR requests.id LIKE '%%%s%%')
                AND date(created_at) >= '%s'
                AND date(created_at) <= '%s'
                %s ORDER BY updated_at DESC", 
                $filters_array,
                mysql_real_escape_string($search),
                mysql_real_escape_string($search),
                mysql_real_escape_string($search),
                date("Y-m-d", strtotime($from)),
                date("Y-m-d", strtotime($to)),
                $strstatus);
            return $this->db->query($query)->result_array();
        }else{
             return array();
        }
        

        // $this->db->select('requests.id,status_desc,sub_group,company_name,branch,updated_at');
        // $this->db->join('sub_groups','sub_groups.id = requests.requesttype_id','left');
        // $this->db->join('request_status','request_status.id = requests.status_id','left');
        // if($status > 0){
        //     $this->db->where('requests.status_id',$status);
        // }
        // if($type > 0){
        //     $this->db->where('requests.requesttype_id',$type);
        // }
        // return $this->db->get($this->table)->result_array();
    }
}