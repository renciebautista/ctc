<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model {
    
    public function getSettings(){
        $this->db->where('id',1);
        return $this->db->get('settings')->row_array();
    }
    
    public function updateSettings(){
        $career_header = trim($this->input->post('career'),TRUE);
        
        $this->db->where('id',1);
        $this->db->set('career_header',$career_header);
        $this->db->update('settings');
    }
}