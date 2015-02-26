<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Product_category_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
    }
    
    function get_product_category($search){
        $this->db->like('productcategory',$search);
        $this->db->order_by('productcategory');
        return $this->db->get('productcategory')->result_array();
    }
    
    function add(){
        $category = $this->input->post('category');
        $desc = $this->input->post('desc');
        $image ='images/productcategory/'. $this->upload->file_name;
        $this->db->set('productcategory',$category );
        $this->db->set('content',$desc);
        $this->db->set('image',$image);
        $this->db->insert('productcategory');
        return $this->db->insert_id();
    }
    
    function tagged($id){
        $count = $this->db->get_where('products',array('productcategory' => $id))->row_array();
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
    
    function get_category($id){
        return $this->db->get_where('productcategory',array('id'=>$id))->row_array();
    }
    
    function _delete($id){
        
        $file = $this->get_category($id);
        if(count($file) > 0)
        {
            unlink($file['image']);
            $this->db->where('id',$id);
            $this->db->delete('productcategory');
            return TRUE;
        }
        return FALSE;
        
    }
    
    function update($id,$value){
        if($value)
        {
            $file = $this->get_category($id);
        }
        
        
        $category = $this->input->post('category');
        $content = $this->input->post('desc');
        $image ='images/productcategory/'. $this->upload->file_name;
        
        $this->db->set('productcategory',$category );
        $this->db->set('content',$content);
        
        if($value)
        {
            $this->db->set('image',$image);
            unlink($file['image']);
        }
        
        $this->db->where('id',$id);
        $this->db->update('productcategory');
        
        
    }
    

    /**
     * check if product category exist
     * @param int
     * @return boolean
     */
    public function id_exist($id){
        $this->db->where('id',$id);
        $row = $this->db->get('productcategory')->row_array();
        if($row){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
}