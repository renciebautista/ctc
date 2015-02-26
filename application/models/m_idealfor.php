<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Idealfor extends CI_Model{
    
    function __construct(){
        //Call the Model constructor
        parent::__construct();
    }
    
    function idealFor($id){
        $this->db->select('idealfor.id,industry.id,industry.industry ');
        $this->db->from('idealfor');
        $this->db->join('industry','idealfor.industry = industry.id');
        $this->db->where('idealfor.products',$id);
        $this->db->order_by('industry.industry');
        $query =  $this->db->get();
        return $query->result_array();
    }
}