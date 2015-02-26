<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_ProductCat extends CI_Model {
    
    function __construct(){
        //Call the Model constructor
        parent::__construct();
    }
    
    function getAllProductCat() {
        $this->db->order_by('productcategory');
        $query = $this->db->get('productcategory');
        return $query->result_array();
    }
    
    function getCategory($id){
        $this->db->select('productcategory');
        $query = $this->db->get_where('productcategory',array('id' => $id));
        return $query->row_array();
    }
    
    function getProduct($id){
        $query = $this->db->get_where('products',array('id' => $id));
        return $query->row_array();
        
    }
    
    function getProducts($id){
        $this->db->select('products.id,products.products,products.content, products.image,
                          productcategory.productcategory');
        $this->db->from('products');
        $this->db->join('productcategory','productcategory.id = products.productcategory','inner');
        $this->db->where('products.productcategory',$id);
        $this->db->order_by('products');
        $query =  $this->db->get();
        return $query->result_array();
       
    }
    
    function getAllProduct()
    {
        $this->db->select('products.id,products.products,productcategory.productcategory');
        $this->db->from('products');
        $this->db->join('productcategory','productcategory.id = products.productcategory','inner');
        $this->db->order_by('productcategory');
        $query =  $this->db->get();
        return $query->result_array();
    }
    
    function getCount(){
         return $this->db->count_all_results('productcategory');
    }
    
    
}   