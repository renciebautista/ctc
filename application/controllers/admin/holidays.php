<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Holidays extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('admin/Holidays_model');
		$this->load->library('form_validation');
	}

	public function index(){
		if(!$this->allow_role(3)){
			$this->_not_authorized();
		}else{
			$search  = $this->input->get('s');
			$data['title'] = 'Holiday';
			$data['view'] ='home';
			$data['search'] = $search;
			$data['holidays'] = $this->Holidays_model->getAll();
			$this->load->view('admin/template',$data);
		}
	}
//-----------------------------------------------------------------------
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
		$data['title'] = 'Holiday | Add';
		$data['view'] = 'add';
		$this->load->view('admin/template',$data);
	}

	private function _post_add(){
		$config = array(
			array('field'=>'desc','label'=>'Holiday Description','rules'=>'required'),
			array('field' =>'date','label' =>'Date','rules' =>'required'));
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
		$this->form_validation->set_message('required', '%s field is required.');
		$this->form_validation->set_message('is_natural', '%s field is required.');
		if($this->form_validation->run() == FALSE){
			$this->_get_add();
		}else{
			if($this->Holidays_model->add()){
				$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Holiday is succesfully added.</strong></div>');
				redirect('admin/holidays');
			}else{
				$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>Holiday date already exist.</strong></div>');
				redirect('admin/holidays/add/');
			}

		}
	}
//-----------------------------------------------------------------------
	public function edit($id=0){
		if(!$this->allow_role(3)){
			$this->_not_authorized();
		}else{
			if((!is_numeric($id)) || ($id == 0) || (!$this->Holidays_model->id_exist($id))){
				$this->_not_found();
			}else{
				if(!$_POST){
					$this->_get_edit($id);
				}else{
					$this->_post_edit($id);
				}
			}
		}
	}

	private function _get_edit($id){
		$data['title'] = 'Holiday | Edit';
		$data['view'] = 'edit';
		$data['holiday'] =  $this->Holidays_model->get_by_id($id);
		$this->load->view('admin/template',$data);
	}

	private function _post_edit($id){
		$config = array(
			array('field'=>'desc','label'=>'Holiday Description','rules'=>'required'),
			array('field' =>'date','label' =>'Date','rules' =>'required'));
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
		$this->form_validation->set_message('required', '%s field is required.');
		$this->form_validation->set_message('is_natural', '%s field is required.');
		if($this->form_validation->run() == FALSE){
			$this->_get_edit($id);
		}else{
			$hid = $this->input->post('hid');
			if($this->Holidays_model->update($hid)){
				$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Holiday is succesfully updated.</strong></div>');
				redirect('admin/holidays');
			}else{
				$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>Holiday date already exist.</strong></div>');
				redirect('admin/holidays/edit/'.$id);
			}
			
		}
	}
//-----------------------------------------------------------------------
	function delete($id = 0){
		if(!$this->allow_role(3)){
			$this->_not_authorized();
		}else{
			if((!is_numeric($id)) || ($id == 0) || (!$this->Holidays_model->id_exist($id))){
				$this->_not_found();
			}else{
				if(!$_POST){
					$this->_get_delete($id);
				}else{
					$hid = $this->input->post('hid');
					if($this->Holidays_model->delete($hid)){
						$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Record is succesfully deleted.</strong></div>');
					}else{
						$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>An error occured while deleting the record.</strong></div>');
					}
					redirect('admin/holidays');
				}
			}
		}
	}

	private function _get_delete($id){
		$data['title'] = 'Holiday | Delete';
		$data['view'] = 'delete';
		$data['holiday'] =  $this->Holidays_model->get_by_id($id);
		$this->load->view('admin/template',$data);
	}
}
