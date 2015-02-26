<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Group_model');
		$this->load->model('Subgroup_model');
		$this->load->library('form_validation');
	}

	public function index(){
		if(!$this->allow_role(1)){
			$this->_not_authorized();
		}else{
			$search  = $this->input->get('s');
			$data['title'] = 'Contact Group';
			$data['view'] ='home';
			$data['search'] = $search;
			$data['group'] = $this->Group_model->search($search);
			$this->load->view('admin/template',$data);
		}
	}
//-------------------------------------------------
	function add(){
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
		$data['title'] = 'Contact Group | Add';
		$data['view'] ='add';
		$this->load->view('admin/template',$data);
	}

	private function _post_add(){
		$config = array(
			array('field'=>'group','label'=>'Group Name','rules'=>'trim|required'));
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
		$this->form_validation->set_message('required', '%s field is required.');
		if($this->form_validation->run() == FALSE){
			$this->_get_add();
		}else{
			$group = $this->input->post('group');
			if($this->Group_model->add_new($group)){
				$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Group name is succesfully added.</strong></div>');
				redirect('admin/group');
			}else{
				$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>Group name already exist.</strong></div>');
				redirect('admin/group/add/');
			}
		}
	}
//-------------------------------------------------
	public function edit($id = null){
		if(!$this->allow_role(1)){
			$this->_not_authorized();
		}else{
			if((!is_numeric($id)) || (is_null($id)) || (!$this->Group_model->id_exist($id))){
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
		$data['title'] = 'Contact Group | Edit';
		$data['view'] ='edit';
		$data['group'] = $this->Group_model->get_by_id($id);
		$this->load->view('admin/template',$data);
	}

	private function _post_edit($id){
		$config = array(
			array('field'=>'group','label'=>'Group Name','rules'=>'trim|required'));
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
		$this->form_validation->set_message('required', '%s field is required.');
		if($this->form_validation->run() == FALSE){
			$this->_get_edit($id);
		}else{
			$group_id = $this->input->post('group_id');
			$group = $this->input->post('group');
			if($this->Group_model->update($group,$group_id)){
				$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Group name is succesfully added.</strong></div>');
				redirect('admin/group');
			}else{
				$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>Group name already exist.</strong></div>');
				redirect('admin/group/edit/'.$id);
			}
		}
	}
//-------------------------------------------------
	public function delete($id = null){
		if(!$this->allow_role(1)){
			$this->_not_authorized();
		}else{
			if((!is_numeric($id)) || (is_null($id)) || (!$this->Group_model->id_exist($id))){
				$this->_not_found();
			}else{
				if(!$_POST){
					$this->_get_delete($id);
				}else{
					$group_id = $this->input->post('group_id');
					if($this->Group_model->delete($group_id)){
						$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Group name is succesfully deleted.</strong></div>');
						redirect('admin/group');
					}else{
						$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>Cannot delete this group.</strong></div>');
						redirect('admin/group/delete/'.$id);
					}
				}
			}
		}
	}

	private function _get_delete($id){
		$data['title'] = 'Contact Group | Delete';
		$data['view'] ='delete';
		$data['group'] = $this->Group_model->get_by_id($id);
		$this->load->view('admin/template',$data);
	}
}

/* End of file group.php */
/* Location: ./application/controllers/admin/group.php */