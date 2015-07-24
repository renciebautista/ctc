<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Filters extends CI_Model{
    
    protected $table = 'user_filter';

    public function updateFilters($user_id,$list){
        $this->_removeFilters($user_id);
        if(is_array($list)){
            $data = array();
            foreach ($list as $row) {
                $array['user_id'] = $user_id;
                $array['sub_group_id'] = $row;
                $data[] = $array;
            }
            $this->db->insert_batch('user_filter',$data);
            //debug($data);
        }
    }

    private function _removeFilters($user_id){
        $this->db->where('user_id',$user_id);
        $this->db->delete('user_filter');
    }

    public function getFilters($user_id){
        $this->db->select('sub_group_id');
        $this->db->where('user_id',$user_id);
        $query =  $this->db->get('user_filter')->result_array();

        $list = array();
        foreach($query as $rows)
        {
            $list[] = $rows['sub_group_id'];
        }

        return  $list;
    }



}