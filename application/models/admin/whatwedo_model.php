<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Whatwedo_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
    }
    
    function get($search){
        $this->db->like('whatwedo',$search);
        $this->db->order_by('whatwedo');
        return $this->db->get('whatwedo')->result_array();
    }
    
    function add(){
        $whatwedo = $this->input->post('whatwedo');
        $desc = $this->input->post('desc');
        $feature = $this->input->post('features');
        $image ='images/whatwedo/'. $this->upload->file_name;
        $this->db->set('whatwedo',$whatwedo );
        $this->db->set('content',$desc);
        $this->db->set('feature',$feature);
        $this->db->set('image',$image);
        $this->db->insert('whatwedo');
    }
    
    function get_whatwedo($id){
        return $this->db->get_where('whatwedo',array('id' => $id))->row_array();
    }
    
    function delete($id){
        $file = $this->get_whatwedo($id);
        if(count($file) > 0)
        {
            unlink($file['image']);
            $this->db->delete('whatwedo', array('id' => $id)); 
            return TRUE;
        }
        else
        {
            RETURN FALSE;
        }
    }
    
    function update($id,$value){
        if($value)
        {
            $file = $this->get_whatwedo($id);
        }
        
        
        $whatwedo = $this->input->post('whatwedo');
        $desc = $this->input->post('desc');
        $feature = $this->input->post('features');
        $image ='images/whatwedo/'. $this->upload->file_name;
        
        $this->db->set('whatwedo',$whatwedo );
        $this->db->set('content',$desc);
        $this->db->set('feature',$feature);
        
        if($value)
        {
            $this->db->set('image',$image);
            unlink($file['image']);
        }
        
        $this->db->where('id',$id);
        $this->db->update('whatwedo');
    }

    /**
     * check if what we dor exist
     * @param int
     * @param boolean
     */
    public function id_exist($id){
        $this->db->where('id',$id);
        $row = $this->db->get('whatwedo')->row_array();
        if($row){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}