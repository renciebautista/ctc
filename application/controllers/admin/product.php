<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('admin/Product_model');
		$this->load->model('admin/Product_category_model');
		$this->load->model('admin/Industry_model');
		$this->load->model('admin/Idealfor_model');
	}
//-----------------------------------------------------	
	function index(){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			$search  = $this->input->get('s');
			$id = $this->input->get('category');
			$data['title'] = 'Products';
			$data['view'] ='home';
			$data['search'] = $search;
			$data['id'] = $id;

			$data['category'] = $this->Product_category_model->get_product_category('');
			$data['product'] = $this->Product_model->get($search,$id);
			$this->load->view('admin/template',$data);
		}
	}
//-----------------------------------------------------		
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
		$data['title'] = 'Product | Add';
		$data['view'] = 'add';
		$data['category'] = $this->Product_category_model->get_product_category('');
		$data['idealfor'] = $this->Industry_model->get_all();
		$this->load->view('admin/template',$data);
	}

	private function _post_add(){
		$config = array(
			array('field'=>'category','label'=>'Product Category','rules'=> 'is_natural_no_zero'),
			array('field'=>'product','label'=>'Product','rules'=>'trim|required'),
			array('field'=>'desc','label'=>'Description','rules'=>'trim|required'),
			array('field'=>'summary','label'=>'Summary','rules'=>'trim|required'),
			array('field'=>'benefits','label'=>'Benefits','rules'=>'trim|required'),
			array('field'=>'features','label'=>'Features','rules'=>'trim|required'),
			array('field'=>'image','label'=>'Image','rules'=>'callback_userfile_check'));
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
		$this->form_validation->set_message('required', '%s field is required.');
		$this->form_validation->set_message('is_natural_no_zero', '%s field is required.');
		$this->form_validation->set_rules('image', 'Image', 'callback_userfile_check');
		if($this->form_validation->run() == FALSE){
			$this->_get_add();
		}else{
			if($this->_do_upload('./images/products/')){
				$this->Idealfor_model->add($this->Product_model->add());
				$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Product is  succesfully added.</strong></div>');
			}
			redirect('admin/product');
		}

	}
//-----------------------------------------------------		
	 function edit($id=0){
	 	if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			if((!is_numeric($id)) || ($id == 0) || (!$this->Product_model->id_exist($id))){
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
		$data['title'] ="Product | Edit";
		$data['view'] = "edit";
		$data['product'] = $this->Product_model->get_product($id);
		$data['category'] = $this->Product_category_model->get_product_category('');
		$data['idealfor'] = $this->Industry_model->get_all();
		$data['selected'] = $this->Idealfor_model->get($id);
		$this->load->view('admin/template',$data); 
	}

	private function _post_edit($product_id){
		$id = $this->input->post('product_id');
		$config = array(
			array('field'=>'category','label'=>'Product Category','rules'=>'is_natural_no_zero'),
			array('field'=>'product','label'=>'Product','rules'=>'trim|required'),
			array('field'=>'desc','label'=>'Description','rules'=>'trim|required'),
			array('field'=>'summary','label'=>'Summary','rules' =>'trim|required'),
			array('field'=>'benefits','label'=>'Benefits','rules'=>'trim|required'),
			array('field'=>'features','label'=>'Features','rules'=>'trim|required'));
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
			$this->form_validation->set_message('required', 'field is required.');
			$this->form_validation->set_message('is_natural', 'field is required.');
			if($this->form_validation->run() == FALSE){
				$this->edit($id);
			}else
			{
				if($this->_update($id)){
					$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Record is succesfully updated.</strong></div>');
				}
				else
				{
					$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>Error in updating record.</strong></div>');
				}
				redirect('admin/product');
			}    
	}

	function _update($id){
		$product = $this->Product_model->get_product($id);
		if(count($product)>0){
			$this->Product_model->update($id,$this->_do_upload('./images/products/'));
			$this->Idealfor_model->update($id);
			return TRUE;
		}else{
			return FALSE;
		}

	}
//--------------------------------------------------------	
	function delete($id = 0){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			if((!is_numeric($id)) || ($id == 0) || (!$this->Product_model->id_exist($id))){
				$this->_not_found();
			}
			else
			{
				if(!$_POST){
					$this->_get_delete($id);
				}else{
					$product_id = $this->input->post('product_id');
					if($this->Product_model->delete($product_id)){
						$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Record is succesfully deleted.</strong></div>');
					}else{
						$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>An error occured while deleting the record.</strong></div>');
					}
					redirect('admin/product');
				}
				
			}
		}
	}

	private function _get_delete($id){
		$data['title'] ="Product | Delete";
		$data['view'] = "delete";
		$data['product'] = $this->Product_model->get_product($id);
		$data['category'] = $this->Product_category_model->get_product_category('');
		$data['idealfor'] = $this->Industry_model->get_all();
		$data['selected'] = $this->Idealfor_model->get($id);
		$this->load->view('admin/template',$data); 
	}
	
}