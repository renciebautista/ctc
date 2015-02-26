<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('admin/Settings_model');
	}
	
	function index(){
		if(!$_POST){
			$this->_get_index();
		}else{
			$this->_update_index();
		}
		
	}
	
	private function _get_index(){
		$data['settings'] = $this->Settings_model->getSettings();
		$data['view'] = 'home';
		$this->load->view('admin/template',$data);
	}
	
	private function _update_index(){
		$this->load->library('form_validation');
		$config = array(
			array(
				'field' =>'career',
				'label' =>'Career header',
				'rules' =>'required'
			)
			);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
		$this->form_validation->set_message('is_natural', 'field is required.');
		if($this->form_validation->run() == FALSE){
			$this->_get_index();
		}else{
			$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Career header is successfully updated.</strong></div>');
			$this->Settings_model->updateSettings();
			redirect('admin/settings');
		}
	}
}