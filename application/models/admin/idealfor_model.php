<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Idealfor_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
    }
    
    function add($producy_id){
        $industries = $this->input->post('idealfor');
        
        foreach($industries as $row=>$value){
            $this->_add($producy_id,$value);
        }
    }
    
    function _add($producy_id,$industry_id){
        $this->db->set('products',$producy_id);
        $this->db->set('industry',$industry_id);
        $this->db->insert('idealfor');
    }
    
    function delete($id){
        $this->db->where('id',$id);
        $this->db->delete('idealfor');
    }
    
    function deleteall($product_id){
        $this->db->where('products',$product_id);
        $this->db->delete('idealfor');
    }
    
    
    function get($producy_id){
        $this->db->select('industry');
        $this->db->where('products',$producy_id);
        $data =  $this->db->get('idealfor')->result_array();
        
        $sel = array();
        foreach($data as $row){
            $sel[] = $row['industry'];
        }
        
        return $sel;
    }
    
    function update($producy_id){
        $industries = $this->input->post('idealfor');
        
        $this->deleteall($producy_id);
        
        foreach($industries as $row=>$value){
            $this->_add($producy_id,$value);
        }
    }
}