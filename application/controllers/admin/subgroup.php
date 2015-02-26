<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subgroup extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Subgroup_model');
		$this->load->model('Group_model');
		$this->load->library('form_validation');
	}

	public function index(){
		if(!$this->allow_role(1)){
			$this->_not_authorized();
		}else{
			$search  = $this->input->get('s');
			$group_id = $this->input->get('category');
			$data['title'] = 'Contact Sub Group';
			$data['view'] ='home';
			$data['search'] = $search;
			$data['id'] = $group_id;
			$data['group'] = $this->Group_model->get_all();
			$data['subgroup'] = $this->Subgroup_model->search($group_id,$search);
			$this->load->view('admin/template',$data);
		}
	}
//----------------------------------------------------------
	public function add(){
		if(!$this->allow_role(1)){
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
		$data['title'] = 'Contact Sub Group | Add';
		$data['view'] ='add';
		$data['group'] = $this->Group_model->get_all();
		$data['psubgroup'] = $this->Subgroup_model->get_for_parent();
		$this->load->view('admin/template',$data);
	}

	private function _post_add(){
		$config = array(
			array('field'=>'group','label'=>' Group Name','rules'=> 'is_natural_no_zero'),
			array('field'=>'subgroup','label'=>'Sub Group Name','rules'=>'trim|required'),
			array('field'=>'psubgroup','label'=>'Parent Sub Group Name','rules'=>''),
			array('field'=>'link','label'=>'Link','rules'=>'trim|required'),
			array('field'=>'sendto','label'=>' Send To','rules'=>'trim|required'),
			array('field'=>'Cc','label'=>' Cc To:','rules'=>'trim|required'));
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
		$this->form_validation->set_message('required', '%s field is required.');
		$this->form_validation->set_message('is_natural_no_zero', '%s field is required.');
		if($this->form_validation->run() == FALSE){
			$this->_get_add();
		}else{
			$group_id = $this->input->post('group');
			$sub_group = $this->input->post('subgroup');
			$sub_group_parent = $this->input->post('psubgroup');
			$link = $this->input->post('link');
			$sendto = $this->input->post('sendto');
			$Cc = $this->input->post('Cc');
			if($this->Subgroup_model->add_subgroup($group_id,$sub_group,$sendto,$link,$Cc,$sub_group_parent)){
				$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Sub Group is succesfully added.</strong></div>');
				redirect('admin/subgroup');
			}else{
				$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>Sub Group name already exist.</strong></div>');
				redirect('admin/subgroup/add');
			}
		}
	}
//----------------------------------------------------------
	public function edit($id = null){
		if(!$this->allow_role(1)){
			$this->_not_authorized();
		}else{
			if((is_null($id)) || (!is_numeric($id)) || (!$this->Subgroup_model->id_exist($id))){
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
		$data['title'] = 'Contact Sub Group | Edit';
		$data['view'] ='edit';
		$data['group'] = $this->Group_model->get_all();
		$data['subgroup'] = $this->Subgroup_model->get_by_id($id);
		$this->load->view('admin/template',$data);
	}

	private function _post_edit($id){
		$config = array(
			array('field'=>'group','label'=>' Group Name','rules'=> 'is_natural_no_zero'),
			array('field'=>'subgroup','label'=>'Sub Group Name','rules'=>'trim|required'),
			array('field'=>'link','label'=>'Link','rules'=>'trim|required'),
			array('field'=>'sendto','label'=>' Send To','rules'=>'trim|required'),
		array('field'=>'Cc','label'=>' Cc To:','rules'=>'trim|required'));
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
		$this->form_validation->set_message('required', '%s field is required.');
		$this->form_validation->set_message('is_natural_no_zero', '%s field is required.');
		if($this->form_validation->run() == FALSE){
			$this->_get_edit($id);
		}else{
			$sub_group_id = $this->input->post('sub_group_id');
			$group_id = $this->input->post('group');
			$sub_group = $this->input->post('subgroup');
			$link = $this->input->post('link');
			$sendto = $this->input->post('sendto');
			$Cc = $this->input->post('Cc');
			if($this->Subgroup_model->update_subgroup($sub_group_id,$group_id,$sub_group,$sendto,$link,$Cc)){
				$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Sub Group is succesfully updated.</strong></div>');
				redirect('admin/subgroup');
			}else{
				$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>Sub Group name already exist.</strong></div>');
				redirect('admin/subgroup/edit/'.$id);
			}
		}
	}
//----------------------------------------------------------
	public function delete($id = null){
		if(!$this->allow_role(1)){
			$this->_not_authorized();
		}else{
			if((is_null($id)) || (!is_numeric($id)) || (!$this->Subgroup_model->id_exist($id))){
				$this->_not_found();
			}else{
				if(!$_POST){
					$this->_get_delete($id);
				}else{
					$sub_group_id = $this->input->post('sub_group_id');
					$this->Subgroup_model->delete($sub_group_id);
					$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Sub Group is succesfully deleted.</strong></div>');
					redirect('admin/subgroup');
				}
			}
		}
	}

	private function _get_delete($id){
		$data['title'] = 'Contact Sub Group | Delete';
		$data['view'] ='delete';
		$data['group'] = $this->Group_model->get_all();
		$data['subgroup'] = $this->Subgroup_model->get_by_id($id);
		$this->load->view('admin/template',$data);
	}
}


/* End of file subgroup.php */
/* Location: ./application/controllers/admin/subgroup.php */