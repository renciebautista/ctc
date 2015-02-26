<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Whatwedo extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('admin/Whatwedo_model');
		$this->load->library('form_validation');
	}
//------------------------------------------------------
	function index(){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			$search  = $this->input->get('s');
			$data['title'] = 'What We Do';
			$data['view'] ='home';
			$data['search'] = $search;
			$data['whatwedo'] = $this->Whatwedo_model->get($search);
			$this->load->view('admin/template',$data);
		}
	}
//------------------------------------------------------	
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
		$data['title'] = 'What We Do | Add';
		$data['view'] ='add';
		$this->load->view('admin/template',$data);
	}

	private function _post_add(){
		$config = array(
			array('field'=>'whatwedo','label'=>'What We Do','rules'=>'trim|required'),
			array('field'=>'desc','label'=>'Description','rules'=>'trim|required'),
			array('field'=>'features','label' =>'Features','rules'=>'trim|required'),
			array('field'=>'image','label'=>'Image','rules'=> 'callback_userfile_check'));
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
		$this->form_validation->set_message('required', '%s field is required.');
		$this->form_validation->set_rules('image', 'Image', 'callback_userfile_check');
		if($this->form_validation->run() == FALSE){
			$this->_get_add();
		}else{
			if($this->_do_upload('./images/whatwedo/',100,107))
				$this->Whatwedo_model->add();
				$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>What We Do is succesfully added.</strong></div>');
				redirect('admin/whatwedo');
		}
	}
//------------------------------------------------------	
	function edit($id=0){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			if((!is_numeric($id)) || ($id == 0) || (!$this->Whatwedo_model->id_exist($id))){
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
		$data['title'] = 'What We Do | Edit';
		$data['view'] ='edit';
		$data['whatwedo'] = $this->Whatwedo_model->get_whatwedo($id);
		$this->load->view('admin/template',$data);
	}

	private function _post_edit($id){
		$config = array(
			array('field'=>'whatwedo','label'=>'What We Do','rules'=>'trim|required'),
			array('field'=>'desc','label'=>'Description','rules'=>'trim|required'),
			array('field'=>'features','label' =>'Features','rules'=>'trim|required'));
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
			$this->form_validation->set_message('required', 'field is required.');
			if($this->form_validation->run() == FALSE){
				$this->_get_edit($id);
			}else
			{
				$whatwedo_id = $this->input->post('w_id');
				if($this->_update($whatwedo_id)){
					$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Record is succesfully updated.</strong></div>');
				}else{
					$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>Error in updating record.</strong></div>');
				}
				redirect('admin/whatwedo');
			}    
	}

	private function _update($id){
		$whatwedo = $this->Whatwedo_model->get_whatwedo($id);
		if(count($whatwedo)>0){
			$this->Whatwedo_model->update($id,$this->_do_upload('./images/whatwedo/',100,107));
			return TRUE;
		}else{
			return FALSE;
		}
	}
//------------------------------------------------------	
	function delete($id = 0){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			if((!is_numeric($id)) || ($id == 0) || (!$this->Whatwedo_model->id_exist($id))){
				$this->_not_found();
			}
			else
			{
				if(!$_POST){
					$this->_get_delete($id);
				}else{
					$w_id = $this->input->post('w_id');
					if($this->Whatwedo_model->delete($w_id)){
						$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Record is succesfully deleted.</strong></div>');
					}else{
						$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>Error in deleting record.</strong></div>');
					}   
					redirect('admin/whatwedo');
				}
	     
			}
		}
	}

	private function _get_delete($id){
		$data['title'] = 'What We Do | Delete';
		$data['view'] ='delete';
		$data['whatwedo'] = $this->Whatwedo_model->get_whatwedo($id);
		$this->load->view('admin/template',$data);
	}
}