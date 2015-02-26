<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Industry_category extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('admin/Industry_category_model');
		$this->load->library('form_validation');
	}
//---------------------------------------------------------------    
	function index(){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			$search  = $this->input->get('s');
			$data['title'] = 'Industry Category';
			$data['view'] ='home';
			$data['search'] = $search;
			$data['ic'] = $this->Industry_category_model->get_industry_category($search);
			$this->load->view('admin/template',$data);
		}
	}
//---------------------------------------------------------------      
	function add(){
		if(!$this->allow_role(2)){
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
		$data['title'] = 'Industry Category | Add';
		$data['view'] ='add';
		$this->load->view('admin/template',$data);
	}

	private function _post_add(){
		$config = array(
			array('field'=>'category','label'=>'Product Category','rules'=>'trim|required'),
			array('field'=>'desc','label'=>'Description','rules'=>'trim|required'),
			array('field'=>'summary','label'=>'Summary','rules'=>'trim|required'),
			array('field'=>'image','label'=>'Image','rules'=>'callback_userfile_check'));
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
		$this->form_validation->set_message('required', '%s field is required.');
		$this->form_validation->set_rules('image', 'Image', 'callback_userfile_check');
		if($this->form_validation->run() == FALSE){
			$this->_get_add();
		}else
		{
			if($this->_do_upload('./images/industrycategory/'))
			$this->Industry_category_model->add();
			$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Industry Category is succesfully added.</strong></div>');
			redirect('admin/industry_category');
		}
	}
//---------------------------------------------------------------       
	function edit($id=0){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			if((!is_numeric($id)) || ($id == 0) || (!$this->Industry_category_model->id_exist($id))){
				$this->_not_found();
			}
			else{
				if(!$_POST){
					$this->_get_edit($id);
				}else{
					$this->_post_update($id);
				}
			}
		}  
	}

	private function _get_edit($id){
		$data['title'] = 'Industry Category | Edit';
		$data['view'] ='edit';
		$data['industrycategory'] = $this->Industry_category_model->get_category($id);
		$this->load->view('admin/template',$data);
	}

	private function _post_update($id){
		$config = array(
			array('field'=>'category','label'=>'Industry Category','rules'=>'trim|required'),
			array('field'=>'desc','label'=>'Description','rules'=>'trim|required'),
			array('field'=>'summary','label'=>'Summary','rules'=>'trim|required'));
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
			$this->form_validation->set_message('required', '%s field is required.');
			if($this->form_validation->run() == FALSE){
				$this->_get_edit($id);
			}else
			{
				$industry_category_id = $this->input->post('industrycat_id');


				if($this->_update($industry_category_id)){
					$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Record is succesfully updated.</strong></div>');
				}else{
					$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>Error in updating record.</strong></div>');
				}
				redirect('admin/industry_category');
			}    
	}

	private function _update($id){
		$industry_category = $this->Industry_category_model->get_category($id);
		if(count($industry_category)>0){
			$this->Industry_category_model->update($id,$this->_do_upload('./images/industrycategory/'));
			return TRUE;
		}else{
			return FALSE;
		}
	}
//---------------------------------------------------------------       	
	function delete($id = 0){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			if((!is_numeric($id)) || ($id == 0) || (!$this->Industry_category_model->id_exist($id))){
				$this->_not_found();
			}
			else
			{
				if(!$_POST){
					$this->_get_delete($id);
				}else{
					$cat_id = $this->input->post('industrycat_id');
					if($this->Industry_category_model->delete($cat_id)){
						$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Record is succesfully deleted.</strong></div>');
					}else{
						$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>An error occured while deleting the record.</strong></div>');
					}
					redirect('admin/industry_category');
				}
			}
		}
	}

	private function _get_delete($id){
		$data['title'] = 'Industry Category | Delete';
		$data['view'] ='delete';
		$data['industrycategory'] = $this->Industry_category_model->get_category($id);
		$this->load->view('admin/template',$data);
	}
	
}