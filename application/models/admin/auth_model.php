<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model{

    function __construct(){
        parent::__construct();

		if(!isset($_SESSION['user'])){
			session_start();
		}
    }

    function doLogin(){
        $data = array(
            'username LIKE' => $this->input->post('user'),
            'pass' => md5($this->input->post('pass'))
        );
        //check db for valid user/pass pair
        $row = $this->db->get_where('users',$data)->first_row();

        if(count($row)< 1)
			return "Invalid username or password.";

		if($row->active != 'ON')
			return "Your account has been suspended. </br>Please <a href='/contact'><u>contact us</u></a> for more info.";

        //set session variables
		/*$this->session->set_userdata('user', $row->username);
		$this->session->set_userdata('displayname', $row->display_name);
  		$this->session->set_userdata('role', $row->role_id);
		*/
		$_SESSION['user_id'] = $row->id;
		$_SESSION['user'] = $row->username;
		$_SESSION['displayname'] = $row->display_name;
		$_SESSION['role'] = $row->role_id;

		//update last login time
  		$this->db->update('users',
  			array('last_log_in'=>date('YmdHis')),
  			array('username LIKE'=>$row->username)
  		);

        return TRUE;
    }
	function doLogout(){
		//$this->session->sess_destroy();
		session_destroy();
	}

	function loggedIn(){
		/*$user = $this->session->userdata('user');
		if($user == null || $user == '')
			return FALSE;

		define('USER', $user);
		define('DISPLAYNAME', $this->session->userdata('displayname'));
		*/
		if(!isset($_SESSION['user']) ||$_SESSION['user'] ='' )
			return FALSE;
		define('USER_ID', $_SESSION['user_id']);
		define('USER', $_SESSION['user']);
		define('DISPLAYNAME', $_SESSION['displayname']);
		define('ROLE_ID', $_SESSION['role']);

		return TRUE;
	}
}
