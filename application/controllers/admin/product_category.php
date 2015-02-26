<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_category extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('admin/Product_category_model');
		$this->load->library('form_validation');
	}
//-----------------------------------------------------	
	public function index(){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
	        $search  = $this->input->get('s');
			$data['title'] = 'Product Category';
			$data['view'] ='home';
			$data['search'] = $search;
			$data['pc'] = $this->Product_category_model->get_product_category($search);
			$this->load->view('admin/template',$data);
		}

	}
//-----------------------------------------------------		
	public function add(){
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
		$data['title'] = 'Product Category | Add';
		$data['view'] ='add';
		$this->load->view('admin/template',$data);
	}

	private function _post_add(){
		$config = array(
			array('field'=>'category','label'=>'Product Category','rules'=>'trin|required'),
			array('field'=>'desc','label'=>'Description','rules'=>'trin|required'),
			array('field'=>'image','label'=>'Category Photo','rules' =>'callback_userfile_check'));
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
		$this->form_validation->set_message('required', '%s field is required.');
		if($this->form_validation->run() == FALSE){
			$this->_get_add();
		}else{
			if($this->_do_upload('./images/productcategory/'))
			$id = $this->Product_category_model->add();
			$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Product Category is succesfully added.</strong></div>');
			redirect('admin/product_category/#'.$id);
		}

	}
	
//-----------------------------------------------------		
	public function edit($id=0){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			if((!is_numeric($id)) || ($id == 0) || (!$this->Product_category_model->id_exist($id))){
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
		$data['title'] = 'Product Category | Edit';
		$data['view'] = 'edit';
		$data['productcategory'] = $this->Product_category_model->get_category($id);
		$this->load->view('admin/template',$data); 
	}

	private function _post_edit($id){
		$config = array(
			array('field'=>'category','label'=>'Product Category','rules' =>'trim|required'),
			array('field'=>'desc','label'=>'Description','rules'=>'trim|required'));
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
			$this->form_validation->set_message('required', '%s field is required.');

		if($this->form_validation->run() == FALSE){
			$this->_get_edit($id);
		}else{
			$product_category_id = $this->input->post('cat_id');
			if($this->_update($product_category_id)){
				$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Record is succesfully updated.</strong></div>');
			}
			else{
				$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>Error in updating record.</strong></div>');
			}
			redirect('admin/product_category');
		}   
	}

	private function _update($id){
		$product_category = $this->Product_category_model->get_category($id);
		if(count($product_category)>0){
			$this->Product_category_model->update($id,$this->_do_upload('./images/productcategory/'));
			return TRUE;
		}else{
			return FALSE;
		}
	}
//-----------------------------------------------------			
	function delete($id = 0){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			if((!is_numeric($id)) || ($id == 0) || (!$this->Product_category_model->id_exist($id))){
				$this->_not_found();
			}
			else{
				if(!$_POST){
					$this->_get_delete($id);
				}else{
					$cat_id = $this->input->post('cat_id');
					if($this->Product_category_model->delete($cat_id)){
						$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Record is succesfully deleted.</strong></div>');
					}
					else{
						$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>An error occured while deleting the record.</strong></div>');
					}
					redirect('admin/product_category');
				}
			}
		}
	}

	private function _get_delete($id){
		$data['title'] = 'Product Category | Delete';
		$data['view'] = 'delete';
		$data['productcategory'] = $this->Product_category_model->get_category($id);
		$this->load->view('admin/template',$data); 
	}
	
//-----------------------------------------------------	
}