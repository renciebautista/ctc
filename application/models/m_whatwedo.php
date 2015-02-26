<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Whatwedo extends CI_Model {
    
    function __construct(){
        //Call the Model construct
        parent::__construct();
    }
    
    function getAllWhatwedo(){
        $this->db->order_by('whatwedo');
        $query = $this->db->get('whatwedo');
        return $query->result_array();
    }
}