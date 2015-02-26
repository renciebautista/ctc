<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Industry extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('admin/Industry_model');
		$this->load->model('admin/Industry_category_model');
	}
	
	function index(){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			$search  = $this->input->get('s');
			$id = $this->input->get('category');
			$data['title'] = 'Industry';
			$data['view'] ='home';
			$data['search'] = $search;
			$data['id'] = $id;

			$data['category'] = $this->Industry_category_model->get_industry_category('');
			$data['industry'] = $this->Industry_model->get($search,$id);
			$this->load->view('admin/template',$data);
		}
	}
//-----------------------------------------------------------
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
		$data['title'] = 'Industry | Add';
		$data['view'] = 'add';
		$data['category'] = $this->Industry_category_model->get_industry_category('');
		$this->load->view('admin/template',$data);
	}

	private function _post_add(){
		$config = array(
			array('field'=>'category','label'=>'Category','rules'=> 'is_natural_no_zero'),
			array('field'=>'industry','label'=>'Industry','rules'=> 'trim|required'),
			array('field'=>'desc','label'=>'Description','rules'=> 'trim|required'),
			array('field'=>'summary','label'=>'Summary','rules'=> 'trim|required'),
			array('field'=>'benefits','label'=>'Benefits','rules'=> 'trim|required'),
			array('field'=>'image','label'=>'Image','rules'=> 'callback_userfile_check'));
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
		$this->form_validation->set_message('required', '%s field is required.');
		$this->form_validation->set_message('is_natural_no_zero', '%s field is required.');
		$this->form_validation->set_rules('image', 'Image', 'callback_userfile_check');
		if($this->form_validation->run() == FALSE){
			$this->_get_add();
		}else
		{
			if($this->_do_upload('./images/industry/'))
				$this->Industry_model->add();
				$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Industry is succesfully added.</strong></div>');
				redirect('admin/industry');
		}

	}
//-----------------------------------------------------------
	public function edit($id=0){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			if((!is_numeric($id)) || ($id == 0) ||(!$this->Industry_model->id_exist($id))){
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
		$data['title'] = 'Industry | Edit';
		$data['view'] = 'edit';
		$data['industry'] = $this->Industry_model->get_industry($id);
		$data['category'] = $this->Industry_category_model->get_industry_category('');
		$this->load->view('admin/template',$data);
	}

	private function _post_edit($id){
		$config = array(
			array('field'=>'category','label'=>'Industry Category','rules'=> 'is_natural_no_zero'),
			array('field'=>'industry','label'=>'Industry','rules'=> 'trim|required'),
			array('field'=>'desc','label'=>'Description','rules'=> 'trim|required'),
			array('field'=>'summary','label'=>'Summary','rules'=> 'trim|required'),
			array('field'=>'benefits','label'=>'Benefits','rules'=> 'trim|required'));
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
			$this->form_validation->set_message('required', '%s field is required.');
			$this->form_validation->set_message('is_natural_no_zero', '%s field is required.');
			if($this->form_validation->run() == FALSE){
				$this->_get_edit($id);
			}else
			{
				$industry_id = $this->input->post('industry_id');
				if($this->_update($industry_id)){
					$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Record is succesfully updated.</strong></div>');
				}else{
					$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>Error in updating record.</strong></div>');
				}
				redirect('admin/industry');
			}  
	}

	private function _update($id){
		$industry = $this->Industry_model->get_industry($id);
		if(count($industry)>0){
			$this->Industry_model->update($id,$this->_do_upload('./images/industry/'));
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
//-----------------------------------------------------------	
	function delete($id = 0){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			if((!is_numeric($id)) || ($id == 0) ||(!$this->Industry_model->id_exist($id))){
				$this->_not_found();
			}
			else
			{
				if(!$_POST){
					$this->_get_delete($id);
				}else{
					$industry_id = $this->input->post('industry_id');
					if($this->Industry_model->delete($industry_id)){
						$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Record is succesfully deleted.</strong></div>');
					}else{
						$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>An error occured while deleting the record.</strong></div>');
					}
					redirect('admin/industry');
				}
			}
		}
	}

	private function _get_delete($id){
		$data['title'] = 'Industry | Delete';
		$data['view'] = 'delete';
		$data['industry'] = $this->Industry_model->get_industry($id);
		$data['category'] = $this->Industry_category_model->get_industry_category('');
		$this->load->view('admin/template',$data);
	}
}