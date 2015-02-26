<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller{
    
    function __construct(){
        parent::__construct();
		
    }
    
    function index($message=null){
        $data = array(
			'message' => $message
		);
		$this->load->view('admin/auth/login_form', $data);
    }
    
    function login(){
        $login_result = $this->Auth_model->doLogin();
        if($login_result !== TRUE){
            $this->index($login_result);
        }
        else
        {
            redirect('admin/dashboard');	
        }
    }
	function logout(){
		$this->Auth_model->doLogout();
		$this->index('You are now logged out.');
	}
}