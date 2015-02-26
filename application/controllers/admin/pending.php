<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pending extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('admin/Filters_model');
	}

	public function index(){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			$search  = $this->input->get('s');
			$data['title'] = 'Pending Filters';
			$data['view'] ='pending_list';
			$data['search'] = $search;
			$data['pendings'] = $this->Filters_model->search($search);
			$this->load->view('admin/template',$data);
		}
	}

	public function add(){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			$this->load->library('form_validation');

			$config = array(
				array('field'=>'contact','label'=>'Contact No.','rules'=>'trim|required'),
				array('field'=>'notes','label'=>'Notes','rules'=>'trim|required'),
				array('field'=>'retry','label'=>'No of tries','rules'=>'trim|required'));
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
			$this->form_validation->set_message('required', '%s field is required.');
			if($this->form_validation->run() == FALSE){
				$data['title'] = 'Pending Filters | Add';
				$data['view'] ='pending_add';
				$this->load->view('admin/template',$data);
			}else{
				$data['contact_no'] = $this->input->post('contact');
				$data['notes'] = $this->input->post('notes');
				$data['retry'] = $this->input->post('retry');
				$data['created_by'] = USER_ID;

				if($this->Filters_model->add($data)){
					$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Filters is  succesfully updated.</strong></div>');
					redirect('admin/pending');
				}else{
					$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>Error occured while processing record.</strong></div>');
					redirect('admin/pending/add');
				}
			}
		}
	}

	public function edit($filter_id = null){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			if((!is_numeric($filter_id)) || ($filter_id == null) ||
			 (!$this->Filters_model->id_exist($filter_id))){
				$this->_not_found();
			}else{
				$this->load->library('form_validation');
				$config = array(
					array('field'=>'contact','label'=>'Contact No.','rules'=>'trim|required'),
					array('field'=>'notes','label'=>'Notes','rules'=>'trim|required'),
					array('field'=>'retry','label'=>'No of tries','rules'=>'trim|required'));
				$this->form_validation->set_rules($config);
				$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
				$this->form_validation->set_message('required', '%s field is required.');
				if($this->form_validation->run() == FALSE){
					$data['title'] = 'Pending Filters | Add';
					$data['view'] ='pending_edit';
					$data['filter'] = $this->Filters_model->get_by_id($filter_id);
		 			$this->load->view('admin/template',$data);
				}else{
					$f_id = $this->input->post('filter_id');
					$data['contact_no'] = $this->input->post('contact');
					$data['notes'] = $this->input->post('notes');
					$data['retry'] = $this->input->post('retry');
					$data['created_by'] = USER_ID;

					if($this->Filters_model->update($f_id,$data)){
						$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Filters is  succesfully updated.</strong></div>');
						redirect('admin/pending');
					}else{
						$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>Error occured while processing record.</strong></div>');
						redirect('admin/pending/add');
					}
				}
			}
		}
	}

}

/* End of file pending_request.php */
/* Location: ./application/controllers/admin/pending_request.php */