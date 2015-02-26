<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_Logs extends CI_Model{
    
    protected $table = 'request_logs';

    function __construct(){
        parent::__construct();
    }
    
    public function save($id){
        $this->db->set('request_id',$id);
		$this->db->set('created_at',date('YmdHis'));
		$this->db->insert($this->table);
    }

    public function getlogs($from,$to){
    	$data = array();
    	$query  = sprintf("select sub_groups.id, sub_groups.parent_id, sub_groups.sub_group,logs.created_at,logs.count from sub_groups
			left join (
				select  request_id,sub_group, date(created_at) as created_at, count(date(created_at)) as count from request_logs
				left join sub_groups on request_logs.request_id = sub_groups.id
                 where date(created_at) between '%s' and '%s'
				group by request_id, date(created_at)
               
			) as logs
			on sub_groups.id = logs.request_id
			where active = 1 order by sub_groups.id desc",date_format(date_create($from),'Y-m-d'),date_format(date_create($to),'Y-m-d'));

    	$logs = $this->db->query($query)->result_array();
    	if(count($logs)>0){
            $parent = array();
    		foreach ($logs as $log) {
                $str = '';
                if($log['parent_id'] > 0){
                    $parent[] = $log['parent_id'];
                    $sub_group = $this->Subgroup_model->get_by_id($log['parent_id']);
                    $str =  $sub_group['sub_group']. ' - ';
                } 
                if(!in_array($log['id'], $parent)){
                    $data[$str.$log['sub_group']]['dates'][$log['created_at']] = $log['count'];
                
                    if(!isset($data[$str.$log['sub_group']]['total'])){
                        $data[$str.$log['sub_group']]['total'] = 0;
                    }

                    $data[$str.$log['sub_group']]['total'] += $log['count'];
                }
    			
    			

    		}
    	}
        ksort($data);
		return $data;
    }
}