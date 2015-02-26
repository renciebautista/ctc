<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blacklist extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('admin/Blacklist_model');
	}


	public function index(){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			$search  = $this->input->get('s');
			$data['title'] = 'Blacklisted Contacts';
			$data['view'] ='contact_list';
			$data['search'] = $search;
			$data['pendings'] = $this->Blacklist_model->search($search);
			$this->load->view('admin/template',$data);
		}
	}

	public function add(){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			$this->load->library('form_validation');

			$config = array(
				array('field'=>'contact','label'=>'Contact No.','rules'=>'trim|required|is_unique[blacklist.contact_no]'));
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
			$this->form_validation->set_message('required', '%s field is required.');
			$this->form_validation->set_message('is_unique', 'Contact already exist.');
			if($this->form_validation->run() == FALSE){
				$data['title'] = 'Blacklist Contact | Add';
				$data['view'] ='contact_add';
				$this->load->view('admin/template',$data);
			}else{
				$data['contact_no'] = $this->input->post('contact');
				$data['created_by'] = USER_ID;

				if($this->Blacklist_model->add($data)){
					$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Blacklist is  succesfully updated.</strong></div>');
					redirect('admin/blacklist');
				}else{
					$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>Error occured while processing record.</strong></div>');
					redirect('admin/blacklist/add');
				}
			}
		}
	}

	public function edit($blist_id = null){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			if((!is_numeric($blist_id)) || ($blist_id == null) ||
			 (!$this->Blacklist_model->id_exist($blist_id))){
				$this->_not_found();
			}else{
				$this->load->library('form_validation');
				$config = array(
					array('field'=>'contact','label'=>'Contact No.','rules'=>'trim|required'));
				$this->form_validation->set_rules($config);
				$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
				$this->form_validation->set_message('required', '%s field is required.');
				if($this->form_validation->run() == FALSE){
					$data['title'] = 'Blacklist Contact | Edit';
					$data['view'] ='contact_edit';
					$data['contact'] = $this->Blacklist_model->get_by_id($blist_id);
		 			$this->load->view('admin/template',$data);
				}else{
					$b_id = $this->input->post('blist_id');
					$data['contact_no'] = $this->input->post('contact');
					$data['created_by'] = USER_ID;

					if($this->Blacklist_model->update($b_id,$data)){
						$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Contact is  succesfully updated.</strong></div>');
						redirect('admin/blacklist');
					}else{
						$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>Error occured while processing record.</strong></div>');
						redirect('admin/blacklist/add');
					}
				}
			}
		}
	}

	public function delete($blist_id = null){
		if(!$this->allow_role(2)){
			$this->_not_authorized();
		}else{
			if((!is_numeric($blist_id)) || ($blist_id == null) ||
			 (!$this->Blacklist_model->id_exist($blist_id))){
				$this->_not_found();
			}else{
				$this->load->library('form_validation');
				$config = array(
					array('field'=>'contact','label'=>'Contact No.','rules'=>'trim|required'));
				$this->form_validation->set_rules($config);
				$this->form_validation->set_error_delimiters('<span style="color:#FF0000">', '</span>');
				$this->form_validation->set_message('required', '%s field is required.');
				if($this->form_validation->run() == FALSE){
					$data['title'] = 'Blacklist Contact | Delete';
					$data['view'] ='contact_delete';
					$data['contact'] = $this->Blacklist_model->get_by_id($blist_id);
		 			$this->load->view('admin/template',$data);
				}else{
					$b_id = $this->input->post('blist_id');

					if($this->Blacklist_model->delete($b_id)){
						$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Contact is  succesfully updated.</strong></div>');
						redirect('admin/blacklist');
					}else{
						$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>Error occured while processing record.</strong></div>');
						redirect('admin/blacklist/add');
					}
				}
			}
		}
	}
}

/* End of file blacklist.php */
/* Location: ./application/controllers/admin/blacklist.php */