<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Contact_model');
		$this->load->model('M_Logs');
		$this->load->model('Subgroup_model');
	}
	public function contact_info(){
		$contact_no = $this->input->get('num');
		$contact = $this->Contact_model->get_contact_by_contactno($contact_no);
		echo json_encode($contact);
	}

	public function requestlogs(){

		$datefrom =  $this->input->get('datefrom');
		$dateto = $this->input->get('dateto');

		$date = date('m/d/Y');
		if($datefrom ==''){
			$dateOneWeekMinus = strtotime(date("Y-m-d", strtotime($date)) . "-2 week");
			$data['datefrom'] =  date('m/d/Y', $dateOneWeekMinus);
		}else{
			$data['datefrom'] = $datefrom;
		}

		if($dateto ==''){
			$data['dateto'] =  date('m/d/Y', strtotime($date));
		}else{
			$data['dateto'] = $dateto;
		}

		$logs = $this->M_Logs->getlogs($datefrom,$dateto);
		echo json_encode($logs);
		// echo '<pre>';
		// print_r($logs);
		// echo '</pre>';
	}

}

/* End of file ajax.php */
/* Location: ./application/controllers/ajax.php */