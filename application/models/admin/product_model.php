<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
        $this->load->model('admin/Idealfor_model');
    }
    
    function get($search,$cat){
        $this->db->select('*,products.content as _content,products.productcategory as cat_id,products.id as in_id');
        $this->db->join('productcategory','productcategory.id = products.productcategory');
        $this->db->like('products',$search);
        
        if($cat > 0)
        $this->db->where('products.productcategory',$cat);
        
        $this->db->order_by('products.productcategory');
        return $this->db->get('products')->result_array();
    }
    
    function add(){
        
        $productcategory = $this->input->post('category');
        $products = $this->input->post('product');
        $content = $this->input->post('summary');
        $icontent = $this->input->post('desc');
        $benefits = $this->input->post('benefits');
        $features = $this->input->post('features');
        $image ='images/products/'. $this->upload->file_name;
        
        $this->db->set('productcategory',$productcategory);
        $this->db->set('products',$products);
        $this->db->set('content',$content);
        $this->db->set('itemcontent',$icontent);
        $this->db->set('benefits',$benefits );
        $this->db->set('features',$features);
        $this->db->set('image',$image);
        $this->db->insert('products');
        
        return $this->db->insert_id();
    }
    
    function tagged($id){
        $count = $this->db->get_where('idealfor',array('products' => $id))->row_array();
        if(count($count)> 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    function delete($id){
        //if($this->tagged($id)){
            //return FALSE;
        //}
       // else
       // {
            return $this->_delete($id);
        //}
    }
    
    function get_product($id){
        return $this->db->get_where('products',array('id'=>$id))->row_array();
    }
    
    function _delete($id){
        
        $file = $this->get_product($id);
        if(count($file) > 0)
        {
            unlink($file['image']);
            $this->db->where('id',$id);
            $this->db->delete('products');
            
            $this->Idealfor_model->deleteall($id);
            return TRUE;
        }
        return FALSE;
        
    }
    
    function update($id,$value){
        if($value)
        {
            $file = $this->get_product($id);
        }
        
        
        $productcategory = $this->input->post('category');
        $products = $this->input->post('product');
        $content = $this->input->post('summary');
        $icontent = $this->input->post('desc');
        $benefits = $this->input->post('benefits');
        $features = $this->input->post('features');
        $image ='images/products/'. $this->upload->file_name;
        
        $this->db->set('productcategory',$productcategory);
        $this->db->set('products',$products);
        $this->db->set('content',$content);
        $this->db->set('itemcontent',$icontent);
        $this->db->set('benefits',$benefits );
        $this->db->set('features',$features);

        
        if($value)
        {
            $this->db->set('image',$image);
            unlink($file['image']);
        }
        
        $this->db->where('id',$id);
        $this->db->update('products');
        
        
    }

    /**
     * check if product exist
     * @param int
     * @return boolean
     */
    public function id_exist($id){
        $this->db->where('id',$id);
        $row = $this->db->get('products')->row_array();
        if($row){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}