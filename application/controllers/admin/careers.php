<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Careers extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('admin/Careers_model');
		$this->load->library('form_validation');
	}
	
	function index(){
		if(!$this->allow_role(3)){
			$this->_not_authorized();
		}else{
			$search  = $this->input->get('s');
			$data['title'] = 'Careers';
			$data['view'] ='home';
			$data['search'] = $search;
			$data['career'] = $this->Careers_model->search($search);
			$this->load->view('admin/template',$data);
		}
	}
//--------------------------------------------------------------
	public function add(){
		if(!$this->allow_role(3)){
			$this->_not_authorized();
		}else{
			if(!$_POST){
				$this->_get_add();
			}else{
				$this->_post_add();
			}
		}
	}

	private function _get_add(){
		$data['title'] = 'Careers | Add';
		$data['view'] ='add';
		$this->load->view('admin/template',$data);
	}

	private function _post_add(){
		$config = array(
			array('field'=>'title','label'=>'Job Tiltle','rules'=>'trim|required'),
			array('field'=>'summary','label'=> 'Job Summary','rules'=> 'trim|required'),
			array('field'=>'responsibilities','label'=>'Job Responsibilities','rules'=> 'required'),
			array('field'=>'qualification','label'=>'Job Qualification','rules'=>'required'));
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
		$this->form_validation->set_message('required', '%s field is required.');
		if($this->form_validation->run() == FALSE){
			$this->_get_add();
		}else
		{
			$this->Careers_model->add();
			$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>New career record is added.</strong></div>');
			redirect('admin/careers');
		}
	}
//--------------------------------------------------------------
	function edit($id=0){
		if(!$this->allow_role(3)){
			$this->_not_authorized();
		}else{
			if((!is_numeric($id)) || ($id == 0) || (!$this->Careers_model->id_exist($id))){
				$this->_not_found();
			}
			else{
				if(!$_POST){
					$this->_get_edit($id);
				}else{
					$this->_post_edit($id);
				}
			}
		}
	}
	private function _get_edit($id){
		$data['title'] = 'Careers | Edit';
		$data['view'] ='edit';
		$data['career'] = $this->Careers_model->get_career($id);
		$this->load->view('admin/template',$data);
	}

	private function _post_edit($id){
		$config = array(
			array('field'=>'title','label'=>'Job Tiltle','rules'=>'trim|required'),
			array('field'=>'summary','label'=> 'Job Summary','rules'=> 'trim|required'),
			array('field'=>'responsibilities','label'=>'Job Responsibilities','rules'=> 'required'),
			array('field'=>'qualification','label'=>'Job Qualification','rules'=>'required'));
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
		$this->form_validation->set_message('required', '%s field is required.');
		if($this->form_validation->run() == FALSE){
			$this->_get_edit($id);
		}else
		{
			$career_id  = $this->input->post('career_id');
			if($this->_update($career_id)){
				$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Record is succesfully updated.</strong></div>');
			}else{
				$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>Error updating record.</strong></div>');
			}
			redirect('admin/careers');
		}
	}

	private function _update($id){
		$career = $this->Careers_model->get_career($id);
		if(count($career)>0){
			$this->Careers_model->update($id);
			return TRUE;
		}else{
			return FALSE;
		}

	}
//--------------------------------------------------------------	
	function delete($id = 0){
		if(!$this->allow_role(3)){
			$this->_not_authorized();
		}else{
			if((!is_numeric($id)) || ($id == 0) || (!$this->Careers_model->id_exist($id))){
				$this->_not_found();
			}else{
				if(!$_POST){
					$this->_get_delete($id);
				}else{
					$career_id = $this->input->post('career_id');
					if($this->Careers_model->delete($career_id)){
						$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Record is succesfully deleted.</strong></div>');
					}else{
						$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>An error occured while deleting the record.</strong></div>');
					}  
					redirect('admin/careers');
				}      
			}
		}
	}

	private function _get_delete($id){
		$data['title'] = 'Careers | Delete';
		$data['view'] ='delete';
		$data['career'] = $this->Careers_model->get_career($id);
		$this->load->view('admin/template',$data);
	}
}