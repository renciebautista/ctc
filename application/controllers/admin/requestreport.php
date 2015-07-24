<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Requestreport extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('M_Request');
		$this->load->model('M_Status');
		$this->load->model('M_Filters');
		$this->load->model('M_Remarks');
		$this->load->model('Subgroup_model');
		$this->load->library('form_validation');
	}

	public function index(){
		if(($this->allow_role(4)) || ($this->allow_role(5))) {
			$data['from'] = $this->input->get('from');
			if($this->input->get('to') == ""){
				$data['to'] = date('m/d/Y');
			}else{
				$data['to'] = $this->input->get('to');
			}
			
			$data['st'] = $this->input->get('st');
			$data['ty'] = $this->input->get('ty');
			$data['search'] = $this->input->get('search');

			$data['title'] = 'Request Report';
			$data['view'] ='home';
			$data['status'] = $this->M_Status->getAll();

			$filters = $this->M_Filters->getFilters(USER_ID);
			$data['requesttypes'] = $this->Subgroup_model->get_sub_group_by_filters($filters);

			
			$data['requests'] = $this->M_Request->search($data['st'],$data['ty'],$data['search'],$data['from'],$data['to'],$filters);
			$this->load->view('admin/template',$data);
			
		}else{
			$this->_not_authorized();
		}	
	}

	public function edit($id){
		if(($this->allow_role(4)) || ($this->allow_role(5))) {
			if(!$_POST){
				$this->_get_update($id);
			}else{
				$config = array(
					array('field'=>'remarks','label'=>'Remarks','rules'=>'required'),
					array('field' =>'status','label' =>'Status','rules' =>'required|is_natural_no_zero'));
				$this->form_validation->set_rules($config);
				$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
				$this->form_validation->set_message('required', '%s field is required.');
				$this->form_validation->set_message('is_natural', '%s field is required.');
				if($this->form_validation->run() == FALSE){
					$this->_get_update($id);
				}else{
					$data['user_id'] = USER_ID;
					$data['id'] = $id;
					$data['status_id'] = $this->input->post('status');
					$data['remarks'] = $this->input->post('remarks');
					$this->M_Remarks->add($data);
					$this->M_Request->update($id,$data['status_id']);
					$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Request is succesfully udpated.</strong></div>');
					redirect('admin/requestreport/edit/'.$id);
				}
			}
		}else{
			$this->_not_authorized();
		}
	}

	public function _get_update($id){
		$data['title'] = 'Request Report';
		$data['view'] ='edit';
		$data['status'] = $this->M_Status->getAll();
		$data['request'] = $this->M_Request->get_by_id($id);
		$data['threads'] = $this->M_Remarks->getThread($id);
		$this->load->view('admin/template',$data);
	}


}

/* End of file pending_request.php */
/* Location: ./application/controllers/admin/pending_request.php */