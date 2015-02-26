<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		//check for login
		
		if(isset($_SESSION['started'])){
			if((mktime() - $_SESSION['started'] - 60*30) > 0){
				//logout, destroy session etc
				session_destroy();
				redirect('admin');
			}
			$_SESSION['started'] = mktime();
		}else{
			$_SESSION['started'] = mktime();
		}
		
		if(!$this->Auth_model->loggedIn()){
			//$this->session->set_userdata('referrer', current_url());
			redirect('admin');		
		}
		
	}

	public function userfile_check(){
		if(isset($_FILES['image'])):
			$ff = $_FILES['image'];
			if(!$ff['name']):
				$this->form_validation->set_message('userfile_check', '%s field is required');
				return FALSE;
			endif;
			$extension= end(explode(".", $ff['name']));
			$ext = array('jpg','png');
			if(!in_array($extension,$ext)):
				$this->form_validation->set_message('userfile_check', '%s  is not valid');
				return FALSE;
			endif;
		else:
			$this->form_validation->set_message('userfile_check', '%s field is required');
		endif;
	} 

	public function _not_found(){
		$data['title'] = 'Page not found';
		$data['view'] = 'error';
		$this->load->view('admin/template',$data);
	}

	public function _not_authorized(){
		$data['title'] = 'Not Authorized';
		$data['view'] = 'shared/not_authorized';
		$this->load->view('admin/template',$data);
	}

	function _do_upload($path,$width = 200,$height = 200)
	{
		if($_FILES['image']['error'] == 0)
		{
			//upload and update the file
			$config['upload_path'] = $path;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['overwrite'] = false;
			$config['remove_spaces'] = true;
			//$config['max_size']	= '100';// in KB
			
			$this->load->library('upload', $config);
		
			if ( ! $this->upload->do_upload('image'))
			{
				$this->session->set_flashdata('message', $this->upload->display_errors('<div class="alert alert-error">', '</div>'));
				//redirect('profile');
				//redirect('admin/product_category');
				return FALSE;
			}	
			else
			{
				//Image Resizing
				$config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
				$config['maintain_ratio'] = FALSE;
				$config['width'] = $width;
				$config['height'] = $height;
		
				$this->load->library('image_lib', $config);
		
				if ( ! $this->image_lib->resize()){
					$this->session->set_flashdata('message', $this->image_lib->display_errors('<div class="alert alert-error">', '</div>'));				
				}
				
				//$this->MUser->updateProfile($this->input->post('user_id'));
				//Need to update the session information if email was changed
				//$this->session->set_userdata('email', $this->input->xss_clean($this->input->post('user_email')));
				$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>New Product Category is added!</strong></div>');
				//redirect('profile');
				//redirect('admin/product_category');
				return TRUE;
			}
		}
		else
		{
			$this->session->set_flashdata('message', '<div class="alert alert-error"><strong>No image attahced.</strong></div>');
				//redirect('profile');
				//redirect('admin/product_category');
				return FALSE;
		}
	}

	public function allow_role($role_id){
		if($role_id == ROLE_ID){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}