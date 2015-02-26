<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Industry_category_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
    }
    
    function get_industry_category($search){
        $this->db->like('industrycategory',$search);
        $this->db->order_by('industrycategory');
        return $this->db->get('industrycategory')->result_array();
    }
    
    function add(){
        
        $category = $this->input->post('category');
        $desc = $this->input->post('desc');
        $contentheader = $this->input->post('summary');
        
        $image ='images/industrycategory/'. $this->upload->file_name;
        $this->db->set('industrycategory',$category );
        $this->db->set('content',$desc);
        $this->db->set('contentheader',$contentheader);
        $this->db->set('image',$image);
        $this->db->insert('industrycategory');
    }
    
    function tagged($id){
        $count = $this->db->get_where('industry',array('industrycategory' => $id))->row_array();
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
    
    function _delete($id){
        
        $file = $this->get_category($id);
        if(count($file) > 0)
        {
            unlink($file['image']);
            $this->db->where('id',$id);
            $this->db->delete('industrycategory');
            return TRUE;
        }
        return FALSE;
        
    }
    
    function get_category($id){
        return $this->db->get_where('industrycategory',array('id'=>$id))->row_array();
    }
    
    function update($id,$value){
        if($value)
        {
            $file = $this->get_category($id);
        }
        
        
        $category = $this->input->post('category');
        $content = $this->input->post('desc');
        $contentheader = $this->input->post('summary');
        $image ='images/industrycategory/'. $this->upload->file_name;
        
        $this->db->set('industrycategory',$category );
        $this->db->set('content',$content);
        $this->db->set('contentheader',$contentheader);
        
        if($value)
        {
            $this->db->set('image',$image);
            unlink($file['image']);
        }
        
        $this->db->where('id',$id);
        $this->db->update('industrycategory');
        
        
    }

    /**
     * check if id exist
     * @param int
     * @return boolean
     */
    public function id_exist($id){
        $this->db->where('id',$id);
        $row = $this->db->get('industrycategory')->row_array();
        if($row){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}