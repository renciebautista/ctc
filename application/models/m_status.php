<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Status extends CI_Model{
    
    protected $table = 'request_status';

    public function getAll(){
         return $this->db->get($this->table)->result_array();
    }

}