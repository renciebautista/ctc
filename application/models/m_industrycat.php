<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_IndustryCat extends CI_Model {
    
    function __construct(){
        //Call the Model constructor
        parent::__construct();
    }
    
    function getAllIndustryCat(){
        $this->db->order_by('industrycategory');
        $query = $this->db->get('industrycategory');
        return $query->result_array();
    }
    function getAllIndustry(){
        $data = array();
        $this->db->select('industrycategory');
        $this->db->order_by('industrycategory');
        $query = $this->db->get('industrycategory');
        foreach( $query->result_array() as $row)
        {
            $data[$row['industrycategory']] = $row['industrycategory'];
        }
        return $data;   
    }
    
    function getIndustryCategory($id){
        $query = $this->db->get_where('industrycategory',array('id' => $id));
        return $query->row_array();
                             
    }
    
    function getIndustryByCategory($indId){
        $this->db->select('industry.id,industry.industry,industry.content,
                          industry.image,industrycategory.industrycategory');
        $this->db->from('industry');
        $this->db->join('industrycategory','industrycategory.id = industry.industrycategory');
        $this->db->where('industry.industrycategory',$indId);
        $this->db->order_by('industry');
        $query =  $this->db->get();
        return $query->result_array();
        
    }
    
    function getSolution($id)
    {
        $query = $this->db->get_where('industry',array('id' => $id));
        return $query->row_array();
    }
    
}