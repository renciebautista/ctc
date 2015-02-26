<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Careers_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
    }
    
    function get_all(){
        return $this->db->get('career')->result_array();
    }

    function search($string){
        $this->db->like('title',$string);
        return $this->db->get('career')->result_array();
    }
    
    function get_career($id){
        return $this->db->get_where('career',array('id' => $id))->row_array();
    }
    
    function add(){
        $title = $this->input->post('title');
        $summary = $this->input->post('summary');
        $responsibilities = $this->input->post('responsibilities');
        $qualification = $this->input->post('qualification');
       
        
        $this->db->set('title',$title);
        $this->db->set('content',$summary);
        $this->db->set('responsibilities',$responsibilities);
        $this->db->set('requirements',$qualification);
        $this->db->set('date_created',date('YmdHis'));
        $this->db->insert('career');
    }
    
    function delete($id){
        if(count($this->get_career($id)) > 0)
        {
            $this->db->delete('career', array('id' => $id)); 
            return TRUE;
        }
        else
        {
            RETURN FALSE;
        }
    }
    
    function update($id){
        $title = $this->input->post('title');
        $summary = $this->input->post('summary');
        $responsibilities = $this->input->post('responsibilities');
        $qualification = $this->input->post('qualification');
       
        
        $this->db->set('title',$title);
        $this->db->set('content',$summary);
        $this->db->set('responsibilities',$responsibilities);
        $this->db->set('requirements',$qualification);
        $this->db->set('date_created',date('YmdHis'));
        $this->db->where('id',$id);
        $this->db->update('career');
    }
    
    /**
     * check if career exist
     * @param int
     * @param boolean
     */
    public function id_exist($id){
        $this->db->where('id',$id);
        $row = $this->db->get('career')->row_array();
        if($row){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}