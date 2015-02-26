<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Industry_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
    }
    
    function get_all(){
        $this->db->order_by('industry');
        return $this->db->get('industry')->result_array();
    }
    
    function get($search,$cat){
        $this->db->select('*,industry.content as _content,industry.industrycategory as cat_id,industry.id as in_id');
        $this->db->join('industrycategory','industrycategory.id = industry.industrycategory');
        $this->db->like('industry',$search);
        
        if($cat > 0)
        $this->db->where('industry.industrycategory',$cat);
        
        $this->db->order_by('industry.industrycategory');
        return $this->db->get('industry')->result_array();
    }
    
    function add(){
        
        $industrycategory = $this->input->post('category');
        $industry = $this->input->post('industry');
        $content = $this->input->post('summary');
        $icontent = $this->input->post('desc');
        $benefits = $this->input->post('benefits');
        $image ='images/industry/'. $this->upload->file_name;
        
        $this->db->set('industrycategory',$industrycategory);
        $this->db->set('industry ',$industry );
        $this->db->set('content ',$content);
        $this->db->set('icontent',$icontent);
        $this->db->set('benefits ',$benefits );
        $this->db->set('image',$image);
        $this->db->insert('industry');
    }
    
    function tagged($id){
        $count = $this->db->get_where('idealfor',array('industry' => $id))->row_array();
        if(count($count)> 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    function delete($id){
        if($this->tagged($id)){
            return FALSE;
        }
        else
        {
            return $this->_delete($id);
        }
    }
    
    function get_industry($id){
        return $this->db->get_where('industry',array('id'=>$id))->row_array();
    }
    
    function _delete($id){
        
        $file = $this->get_industry($id);
        if(count($file) > 0)
        {
            unlink($file['image']);
            $this->db->where('id',$id);
            $this->db->delete('industry');
            return TRUE;
        }
        return FALSE;
        
    }
    
    function update($id,$value){
        if($value)
        {
            $file = $this->get_industry($id);
        }
        
        
        $industrycategory = $this->input->post('category');
        $industry = $this->input->post('industry');
        $content = $this->input->post('summary');
        $icontent = $this->input->post('desc');
        $benefits = $this->input->post('benefits');
        $image ='images/industry/'. $this->upload->file_name;
        
        $this->db->set('industrycategory',$industrycategory);
        $this->db->set('industry ',$industry );
        $this->db->set('content ',$content);
        $this->db->set('icontent',$icontent);
        $this->db->set('benefits ',$benefits );
        
        if($value)
        {
            $this->db->set('image',$image);
            unlink($file['image']);
        }
        
        $this->db->where('id',$id);
        $this->db->update('industry');
    }

    /**
     * check if industry exist
     * @param int
     * @return boolean
     */
    public function id_exist($id){
        $this->db->where('id',$id);
        $row = $this->db->get('industry')->row_array();
        if($row){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}