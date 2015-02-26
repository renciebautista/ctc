<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('admin/Users_model');
	}
	
	public function index(){
		if(!$this->allow_role(1)){
			$this->_not_authorized();
		}else{
			$search  = $this->input->get('s');
			$data['title'] = 'User List';
			$data['view'] ='user_list';
			$data['search'] = $search;
			$data['users'] = $this->Users_model->get_all();
			$this->load->view('admin/template',$data);
		}
	}
	
	public function add(){
		if(!$this->allow_role(1)){
			$this->_not_authorized();
		}else{
			$this->load->library('form_validation');

			$config = array(
				array('field'=>'username','label'=>'Username','rules'=>'trim|required|is_unique[users.username]'),
				array('field'=>'d_name','label'=>'Display Name','rules'=>'trim|required'),
				array('field'=>'password','label'=>'Password','rules'=>'trim|required|matches[c_password]'),
				array('field'=>'c_password','label'=>'Confirm Password','rules'=>'trim|required'),
				array('field'=>'role','label'=>'Roles','rules'=>'is_natural_no_zero')
				);
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
			$this->form_validation->set_message('required', '%s field is required.');
			$this->form_validation->set_message('is_unique', 'Username already exist.');
			$this->form_validation->set_message('matches', 'Password does not match.');
			$this->form_validation->set_message('is_natural_no_zero', '%s field is required.');
			if($this->form_validation->run() == FALSE){
				$data['title'] = 'Add User';
				$data['role'] = $this->Users_model->get_all_role();
				$data['view'] = 'user_add';
				$this->load->view('admin/template',$data);
			}else{
				$data['display_name'] = $this->input->post('d_name');
				$data['username'] = $this->input->post('username');
				$data['password'] = $this->input->post('password');
				$data['role_id'] = $this->input->post('role');
				if($this->Users_model->add($data)){
					$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Users is successfully updated.</strong></div>');
					redirect('admin/users');
				}else{
					$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>An error occured while updating record.</strong></div>');
					redirect('admin/users/add');
				}
			}
		}
	}

	public function edit($id = null){
		if(!$this->allow_role(1)){
			$this->_not_authorized();
		}else{
			if((is_null($id)) || (!$this->Users_model->id_exist($id))){
				$this->_not_found();
			}else{

				$this->load->library('form_validation');

				$config = array(
					array('field'=>'d_name','label'=>'Display Name','rules'=>'trim|required'),
					array('field'=>'role','label'=>'Roles','rules'=>'is_natural_no_zero')
					);
				$this->form_validation->set_rules($config);
				$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
				$this->form_validation->set_message('required', '%s field is required.');
				$this->form_validation->set_message('is_unique', 'Username already exist.');
				$this->form_validation->set_message('matches', 'Password does not match.');
				$this->form_validation->set_message('is_natural_no_zero', '%s field is required.');
				if($this->form_validation->run() == FALSE){
					$data['title'] = 'Add User';
					$data['role'] = $this->Users_model->get_all_role();
					$data['user'] = $this->Users_model->get_user($id);
					$data['view'] = 'user_edit';
					$this->load->view('admin/template',$data);
				}else{
					$uid = $this->input->post('user_id');
					$data['display_name'] = $this->input->post('d_name');
					$data['role_id'] = $this->input->post('role');
					$data['active'] = $this->input->post('active');
					if($this->Users_model->update($uid,$data)){
						$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Users is successfully updated.</strong></div>');
						redirect('admin/users');
					}else{
						$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>An error occured while updating record.</strong></div>');
						redirect('admin/users/edit/'.$uid);
					}
				}
			}
		}
	}
}