<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Career extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    function getAllCareers(){
        $this->db->order_by('title');
        $query = $this->db->get('career');
        return $query->result_array();
    }
}