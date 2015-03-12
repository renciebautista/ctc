<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

	private $default = array();

	function __construct(){
		parent::__construct();
		$this->load->model('Group_model');
		$this->load->model('Subgroup_model');
		$this->load->model('Clients_model');
		$this->load->model('admin/Filters_model');
		$this->load->model('admin/Blacklist_model');
		$this->load->model('M_Logs');

		$this->default['styles'] = array('maincontent','products_contents','updates_newsletters','index_content',
								'easySlides.default.min','small', 'jquery-ui-1.10.3.custom.min');
		$this->default['script'] = array('chrome','jquery-1.9.1','jquery.easyslides.min.v1.1','small',
									'jquery.validate','jquery.validate-rules','isnumeric','jquery.MultiFile.pack',
									'jquery.numericonly','admin/jquery.maskedinput.min' ,'jquery-ui-1.10.3.custom.min');
		$this->default['prodCategory'] = $this->M_ProductCat->getAllProductCat();
		$this->default['indCategory'] = $this->M_IndustryCat->getAllIndustryCat();
		$this->default['whatwedo'] = $this->M_Whatwedo->getAllWhatwedo();

	}

	public function index(){
		// $subgroup = $this->Subgroup_model->get_record_by_slug('clarification');
		// $this->M_Logs->save($subgroup['id']);

		$data = $this->default;
		$data['childpage'] = 'contact/contact_home';
		$data['groups'] = $this->Group_model->get_with_sub();
		$this->load->view('masterpage',$data);

	}
//----------------------------------------------------------
	private function _generateCaptcha(){
		$vals = array('img_path' => './captcha/','img_url' =>  base_url(). '/captcha/');
		$cap = create_captcha($vals);
		$data1 = array('captcha_time' => $cap['time'],'ip_address' => $this->input->ip_address(),'word' => $cap['word']);
		$query = $this->db->insert_string('captcha', $data1);
		$this->db->query($query);
		return $cap;
	}

	public function captcha_check($str){
		// First, delete old captchas
		$expiration = time()-7200; // Two hour limit
		$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);

		// Then see if a captcha exists:
		$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
		$binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();
		if ($row->count == 0)
		{
			$this->form_validation->set_message('captcha_check', 'Invalid word');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
//---------------------------------------------------------
	public function clarification(){
		if(!$_POST){
			$this->_get_clarification();
		}else{
			$this->_post_clarification();
		}
	}

	private function _get_clarification(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/clarification';
		$this->load->view('masterpage',$data);
	}

	private function _post_clarification(){
		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'landline','label' =>'Landline No.','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store/Branch Name','rules' =>'trim|required'),
			array('field' =>'dept','label' =>'Department','rules' =>'trim|required'),
			array('field' =>'assigned','label' =>'CTC AE Assigned','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Questions','rules' =>'trim|required'),
			array('field' =>'inquired','label' =>'Products Inquired','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_clarification();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['landline'] = $this->input->post('landline');
			$data['email'] = $this->input->post('email');
			$data['c_person'] = $this->input->post('c_person');
			$data['company'] = $this->input->post('company');
			$data['address'] = $this->input->post('address');
			$data['store'] = $this->input->post('store');
			$data['dept'] = $this->input->post('dept');
			$data['assigned'] = $this->input->post('assigned');
			//$data['info'] = $this->input->post('info');
			$data['inquired'] = $this->input->post('inquired');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');

			$data['form1'] = array(
				'desc' => 'Questions (things to clarify)', 
				'details' => $this->input->post('info')
				);
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Clarification Request";

			//Save contact details
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('clarification');

					if($this->_send_mail('clarification',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('clarification');
					
					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('clarification',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function quotation_followup(){
		if(!$_POST){
			$this->_get_quotation_followup();
		}else{
			$this->_post_quotation_followup();
		}
	}

	private function _get_quotation_followup(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/quotation_followup';
		$this->load->view('masterpage',$data);
	}

	private function _post_quotation_followup(){

		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'landline','label' =>'Landline No.','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store/Branch Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'dept','label' =>'Department','rules' =>'trim|required'),
			array('field' =>'assigned','label' =>'CTC AE Assigned','rules' =>'trim|required'),
			array('field' =>'q_date','label' =>'Quotation Date','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Items Required','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_quotation_followup();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['landline'] = $this->input->post('landline');
			$data['email'] = $this->input->post('email');
			$data['c_person'] = $this->input->post('c_person');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			$data['dept'] = $this->input->post('dept');
			$data['assigned'] = $this->input->post('assigned');
			$data['q_date'] = $this->input->post('q_date');
			//$data['info'] = $this->input->post('info');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Quotation Follow-up Request";

			$data['form1'] = array(
				'desc' => 'Items Required in the Quotation',
				'details' => $this->input->post('info'));

			//Save contact details
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('quotation_followup');

					if($this->_send_mail('quotation_followup',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('quotation_followup');

					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('quotation_followup',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function request_demo(){
		if(!$_POST){
			$this->_get_request_demo();
		}else{
			$this->_post_request_demo();
		}
	}

	private function _get_request_demo(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/demo_request';
		$this->load->view('masterpage',$data);
	}

	private function _post_request_demo(){

		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'landline','label' =>'Landline No.','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'c_person','label' =>'Contact Person','rules' =>'trim|required'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store/Branch Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'dept','label' =>'Department','rules' =>'trim|required'),
			array('field' =>'assigned','label' =>'CTC AE Assigned','rules' =>'trim|required'),
			array('field' =>'demodate','label' =>'Date of Demo','rules' =>'trim|required'),
			array('field' =>'attendees','label' =>'Other Attendees','rules' =>'trim|required'),
			array('field' =>'otherinfo','label' =>'Other Attendees','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Items Required','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_request_demo();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['landline'] = $this->input->post('landline');
			$data['email'] = $this->input->post('email');
			$data['c_person'] = $this->input->post('c_person');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			$data['dept'] = $this->input->post('dept');
			$data['assigned'] = $this->input->post('assigned');
			$data['demodate'] = $this->input->post('demodate');
			$data['attendees'] = $this->input->post('attendees');
			//$data['otherinfo'] = $this->input->post('otherinfo');
			//$data['info'] = $this->input->post('info');

			$data['form1'] = array(
				'desc' => 'Other Departments Who Will Attend the Demo',
				'details' => $this->input->post('otherinfo'),
			 );
			$data['form2'] = array(
				'desc' => 'Items Required in the Demo',
				'details' => $this->input->post('info'),
			 );
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Demo Request";

			//Save contact details
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('request_demo');

					if($this->_send_mail('request_demo',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('request_demo');

					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('request_demo',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function return_call(){
		if(!$_POST){
			$this->_get_return_call();
		}else{
			$this->_post_return_call();
		}
	}

	private function _get_return_call(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/return_call';
		$this->load->view('masterpage',$data);
	}

	private function _post_return_call(){

		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'landline','label' =>'Landline No.','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'c_person','label' =>'Full Name','rules' =>'trim|required'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store/Branch Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'dept','label' =>'Department','rules' =>'trim|required'),
			array('field' =>'assigned','label' =>'CTC AE Assigned','rules' =>'trim|required'),
			array('field' =>'ttime','label' =>'Time of Return Call','rules' =>'trim|required'),
			array('field' =>'personnel','label' =>'Person to Return the Call','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Purpose','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This %s field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_return_call();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['landline'] = $this->input->post('landline');
			$data['email'] = $this->input->post('email');
			$data['c_person'] = $this->input->post('c_person');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			$data['dept'] = $this->input->post('dept');
			$data['assigned'] = $this->input->post('assigned');
			$data['ttime'] = $this->input->post('ttime');
			$data['personnel'] = $this->input->post('personnel');
			//$data['info'] = $this->input->post('info');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Return Call Request";

			$data['form1'] = array(
				'desc' => 'Purpose of the Requested Return Call',
				'details' => $this->input->post('info'));

			//Save contact details
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('return_call');

					if($this->_send_mail('return_call',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('return_call');

					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('return_call',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function sales_inquiry(){
		if(!$_POST){
			$this->_get_sales_inquiry();
		}else{
			$this->_post_sales_inquiry();
		}
	}

	private function _get_sales_inquiry(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/sales_inquiry';
		$this->load->view('masterpage',$data);
	}

	private function _post_sales_inquiry(){

		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'landline','label' =>'Landline No.','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'c_person','label' =>'Contact Person','rules' =>'trim|required'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store/Branch Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'industry','label' =>'Industry','rules' =>'trim|required'),
			array('field' =>'others','label' =>'Others','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Products of Interest','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This /s field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_sales_inquiry();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['landline'] = $this->input->post('landline');
			$data['email'] = $this->input->post('email');
			$data['c_person'] = $this->input->post('c_person');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			$data['dept'] = $this->input->post('dept');
			$data['industry'] = $this->input->post('industry');
			$data['others'] = $this->input->post('others');
			//$data['info'] = $this->input->post('info');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Sales Inquiry";

			$data['form1'] = array(
				'desc' => 'Product of Interest',
				'details' =>  $this->input->post('info'));

			//Save contact details
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('sales_inquiry');

					if($this->_send_mail('sales_inquiry',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('sales_inquiry');

					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('sales_inquiry',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function stock_order_followup(){
		if(!$_POST){
			$this->_get_order_followup();
		}else{
			$this->_post_order_followup();
		}
	}

	private function _get_order_followup(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/order_followup';
		$this->load->view('masterpage',$data);
	}

	private function _post_order_followup(){

		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'landline','label' =>'Landline No.','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'c_person','label' =>'Contact Person','rules' =>'trim|required'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store/Branch Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'dept','label' =>'Department','rules' =>'trim|required'),
			array('field' =>'assigned','label' =>'AE Assigned','rules' =>'trim|required'),
			array('field' =>'refno','label' =>'Ref. Number','rules' =>'trim|required'),
			array('field' =>'delivery','label' =>'Delivery Date','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Reasons','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_order_followup();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['landline'] = $this->input->post('landline');
			$data['email'] = $this->input->post('email');
			$data['c_person'] = $this->input->post('c_person');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			$data['dept'] = $this->input->post('dept');
			$data['assigned'] = $this->input->post('assigned');
			$data['refno'] = $this->input->post('refno');
			$data['delivery'] = $this->input->post('delivery');
			//$data['info'] = $this->input->post('info');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Stock Order Follow-up";

			$data['form1'] = array(
				'desc' => 'Reason for Follow-up',
				'details' => $this->input->post('info'));

			//Save contact details
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('stock_order_followup');
					if($this->_send_mail('stock_order_followup',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('stock_order_followup');
					
					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('stock_order_followup',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function enroll_esa(){
		if(!$_POST){
			$this->_get_enroll_esa();
		}else{
			$this->_post_enroll_esa();
		}
	}

	private function _get_enroll_esa(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/enroll_esa';
		$this->load->view('masterpage',$data);
	}

	private function _post_enroll_esa(){

		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Remarks','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_enroll_esa();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			//$data['info'] = $this->input->post('info');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="ESA Enrollment Request";

			$data['form1'] = array(
				'desc' => 'Remarks',
				'details' => $this->input->post('info')
				);
			//Save information details
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('enroll_esa');

					if($this->_send_mail('enroll_esa',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('enroll_esa');

					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('enroll_esa',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function esa_clarification(){
		if(!$_POST){
			$this->_get_esa_clarification();
		}else{
			$this->_post_esa_clarification();
		}
	}

	private function _get_esa_clarification(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/esa_clarification';
		$this->load->view('masterpage',$data);
	}

	private function _post_esa_clarification(){

		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Remarks','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_esa_clarification();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			//$data['info'] = $this->input->post('info');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="ESA Clarification Request";

			$data['form1'] = array(
				'desc' => 'Remarks',
				'details' => $this->input->post('info')
				);

			//Save information details
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('esa_clarification');

					if($this->_send_mail('esa_clarification',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('esa_clarification');

					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('esa_clarification',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function mall_hookup(){
		if(!$_POST){
			$this->_get_mall_hookup();
		}else{
			$this->_post_mall_hookup();
		}
	}

	private function _get_mall_hookup(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/mall_hookup';
		$this->load->view('masterpage',$data);
	}

	private function _post_mall_hookup(){
		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Remarks','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_mall_hookup();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			//$data['info'] = $this->input->post('info');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Mall Hook-up request";

			$data['form1'] = array(
				'desc' => 'Remarks',
				'details' => $this->input->post('info')
				);

			//Save information details
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('mall_hookup');

					if($this->_send_mail('mall_hookup',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('mall_hookup');

					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('mall_hookup',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function new_system(){
		if(!$_POST){
			$this->_get_new_system();
		}else{
			$this->_post_new_system();
		}
	}

	private function _get_new_system(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/new_system';
		$this->load->view('masterpage',$data);
	}

	private function _post_new_system(){

		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Remarks','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_new_system();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			//$data['info'] = $this->input->post('info');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="New System Request";

			$data['form1'] = array(
				'desc' => 'Remarks',
				'details' => $this->input->post('info')
				);

			//Save information details
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('new_system');

					if($this->_send_mail('new_system',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('new_system');

					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('new_system',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function service_followup(){
		if(!$_POST){
			$this->_get_service_followup();
		}else{
			$this->_post_service_followup();
		}
	}

	private function _get_service_followup(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/service_followup';
		$this->load->view('masterpage',$data);
	}

	private function _post_service_followup(){

		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Remarks','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_service_followup();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			//$data['info'] = $this->input->post('info');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Service Follow-up Request";

			$data['form1'] = array(
				'desc' => 'Remarks',
				'details' => $this->input->post('info')
				);

			//Save information details
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
			$data['company'],$data['store'],$data['address']);

			//check if have pending message
			$pendings = $this->Filters_model->search($data['c_number']);
			if(count($pendings)>0){
				$data['notes'] = $pendings;
				foreach ($pendings as $row) {
					$f_id = $row['filter_id'];
					$data1['tries']  = 0;
					$data1['status'] = 0;
					$data1['tries'] = $row['tries'] + 1;
					if($row['retry'] == $data1['tries']){
						$data1['status'] = 1;
					}
					$this->Filters_model->update_filter($f_id,$data1);
				}
			}
			//end

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('service_followup');

					if($this->_send_mail('service_followup',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('service_followup');

					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('service_followup',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function service_request(){
		if(!$_POST){
			$this->_get_service_request();
		}else{
			$this->_post_service_request();
		}
	}


	private function _get_service_request(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/service_request';
		$this->load->view('masterpage',$data);
	}

	private function _post_service_request(){
		$this->load->library('form_validation');
		$config = array(
			array('field' =>'requested_by','label' =>'Requested By','rules' =>'trim|required'),
			array('field' =>'r_number','label' =>'Requestor Number','rules' =>'trim|required'),
			array('field' =>'remail','label' =>'Requestor Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Remarks','rules' =>'trim|required'),
			array('field' =>'problem','label' =>'Problem Description','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_service_request();
		}
		else
		{
			$data['requested_by'] = $this->input->post('requested_by');
			$data['r_number'] = $this->input->post('r_number');
			$data['remail'] = $this->input->post('remail');

			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			//$data['info'] = $this->input->post('info');
			//$data['problem'] = $this->input->post('problem');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Service Request (Software)";

			$data['form1'] = array(
				'desc' => 'Product Information',
				'details' => $this->input->post('info')
				);

			$data['form2'] = array(
				'desc' => 'Problem Description',
				'details' => $this->input->post('problem')
				);

			//save for autofill-in fields
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
			$data['company'],$data['store'],$data['address']);

			//check if have pending message
			$pendings = $this->Filters_model->search($data['c_number']);
			if(count($pendings)>0){
				$data['notes'] = $pendings;
				foreach ($pendings as $row) {
					$f_id = $row['filter_id'];
					$data1['tries']  = 0;
					$data1['status'] = 0;
					$data1['tries'] = $row['tries'] + 1;
					if($row['retry'] == $data1['tries']){
						$data1['status'] = 1;
					}
					$this->Filters_model->update_filter($f_id,$data1);
				}
			}
			//end

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($reply_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('service_request');

					if($this->_send_mail('service_request',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('service_request');

					$send_to = $chase_mail['send_to'];
					
					$cc = array($chase_mail['cc'], $data['remail']);

					if($this->_send_mail('service_request',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function service_hardware(){
		if(!$_POST){
			$this->_get_service_hardware();
		}else{
			$this->_post_service_hardware();
		}
	}

	private function _get_service_hardware(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/service_hardware';
		$this->load->view('masterpage',$data);
	}

	private function _post_service_hardware(){
		$this->load->library('form_validation');
		$config = array(
			array('field' =>'requested_by','label' =>'Requested By','rules' =>'trim|required'),
			array('field' =>'r_number','label' =>'Requestor Number','rules' =>'trim|required'),
			array('field' =>'remail','label' =>'Requestor Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Remarks','rules' =>'trim|required'),
			array('field' =>'problem','label' =>'Problem Description','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_service_hardware();
		}
		else
		{
			$data['requested_by'] = $this->input->post('requested_by');
			$data['r_number'] = $this->input->post('r_number');
			$data['remail'] = $this->input->post('remail');

			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			//$data['info'] = $this->input->post('info');
			//$data['problem'] = $this->input->post('problem');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Service Request (Hardware)";

			$data['form1'] = array(
				'desc' => 'Product Information',
				'details' => $this->input->post('info')
				);

			$data['form2'] = array(
				'desc' => 'Problem Description',
				'details' => $this->input->post('problem')
				);

			//save for autofill-in fields
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
			$data['company'],$data['store'],$data['address']);

			//check if have pending message
			$pendings = $this->Filters_model->search($data['c_number']);
			if(count($pendings)>0){
				$data['notes'] = $pendings;
				foreach ($pendings as $row) {
					$f_id = $row['filter_id'];
					$data1['tries']  = 0;
					$data1['status'] = 0;
					$data1['tries'] = $row['tries'] + 1;
					if($row['retry'] == $data1['tries']){
						$data1['status'] = 1;
					}
					$this->Filters_model->update_filter($f_id,$data1);
				}
			}
			//end

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($reply_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('service_hardware');

					if($this->_send_mail('service_hardware',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('service_hardware');

					$send_to = $chase_mail['send_to'];
					
					$cc = array($chase_mail['cc'], $data['remail']);

					if($this->_send_mail('service_hardware',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function service_implementation(){
		if(!$_POST){
			$this->_get_service_implementation();
		}else{
			$this->_post_service_implementation();
		}
	}

	private function _get_service_implementation(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/service_implementation';
		$this->load->view('masterpage',$data);
	}

	private function _post_service_implementation(){
		$this->load->library('form_validation');
		$config = array(
			array('field' =>'requested_by','label' =>'Requested By','rules' =>'trim|required'),
			array('field' =>'r_number','label' =>'Requestor Number','rules' =>'trim|required'),
			array('field' =>'remail','label' =>'Requestor Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Remarks','rules' =>'trim|required'),
			array('field' =>'problem','label' =>'Problem Description','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_service_implementation();
		}
		else
		{

			$data['requested_by'] = $this->input->post('requested_by');
			$data['r_number'] = $this->input->post('r_number');
			$data['remail'] = $this->input->post('remail');

			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			//$data['info'] = $this->input->post('info');
			//$data['problem'] = $this->input->post('problem');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Service Request (Implementation)";

			$data['form1'] = array(
				'desc' => 'Product Information',
				'details' => $this->input->post('info')
				);

			$data['form2'] = array(
				'desc' => 'Problem Description',
				'details' => $this->input->post('problem')
				);

			//save for autofill-in fields
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
			$data['company'],$data['store'],$data['address']);

			//check if have pending message
			$pendings = $this->Filters_model->search($data['c_number']);
			if(count($pendings)>0){
				$data['notes'] = $pendings;
				foreach ($pendings as $row) {
					$f_id = $row['filter_id'];
					$data1['tries']  = 0;
					$data1['status'] = 0;
					$data1['tries'] = $row['tries'] + 1;
					if($row['retry'] == $data1['tries']){
						$data1['status'] = 1;
					}
					$this->Filters_model->update_filter($f_id,$data1);
				}
			}
			//end

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($reply_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('service_implementation');

					if($this->_send_mail('service_implementation',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('service_implementation');

					$send_to = $chase_mail['send_to'];
					
					$cc = array($chase_mail['cc'], $data['remail']);

					if($this->_send_mail('service_implementation',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}

//-----------------------------------------------------------
	public function service_network(){
		if(!$_POST){
			$this->_get_service_network();
		}else{
			$this->_post_service_network();
		}
	}

	private function _get_service_network(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/service_network';
		$this->load->view('masterpage',$data);
	}

	private function _post_service_network(){
		$this->load->library('form_validation');
		$config = array(
			array('field' =>'requested_by','label' =>'Requested By','rules' =>'trim|required'),
			array('field' =>'r_number','label' =>'Requestor Number','rules' =>'trim|required'),
			array('field' =>'remail','label' =>'Requestor Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Remarks','rules' =>'trim|required'),
			array('field' =>'problem','label' =>'Problem Description','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_service_network();
		}
		else
		{
			$data['requested_by'] = $this->input->post('requested_by');
			$data['r_number'] = $this->input->post('r_number');
			$data['remail'] = $this->input->post('remail');

			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			//$data['info'] = $this->input->post('info');
			//$data['problem'] = $this->input->post('problem');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Service Request (Network)";

			$data['form1'] = array(
				'desc' => 'Product Information',
				'details' => $this->input->post('info')
				);

			$data['form2'] = array(
				'desc' => 'Problem Description',
				'details' => $this->input->post('problem')
				);

			//save for autofill-in fields
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
			$data['company'],$data['store'],$data['address']);

			//check if have pending message
			$pendings = $this->Filters_model->search($data['c_number']);
			if(count($pendings)>0){
				$data['notes'] = $pendings;
				foreach ($pendings as $row) {
					$f_id = $row['filter_id'];
					$data1['tries']  = 0;
					$data1['status'] = 0;
					$data1['tries'] = $row['tries'] + 1;
					if($row['retry'] == $data1['tries']){
						$data1['status'] = 1;
					}
					$this->Filters_model->update_filter($f_id,$data1);
				}
			}
			//end

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($reply_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('service_network');

					if($this->_send_mail('service_network',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('service_network');

					$send_to = $chase_mail['send_to'];
					
					$cc = array($chase_mail['cc'], $data['remail']);

					if($this->_send_mail('service_network',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}

//-----------------------------------------------------------
	public function service_inhouse(){
		if(!$_POST){
			$this->_get_service_inhouse();
		}else{
			$this->_post_service_inhouse();
		}
	}

	private function _get_service_inhouse(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/service_inhouse';
		$this->load->view('masterpage',$data);
	}

	private function _post_service_inhouse(){
		$this->load->library('form_validation');
		$config = array(
			array('field' =>'requested_by','label' =>'Requested By','rules' =>'trim|required'),
			array('field' =>'r_number','label' =>'Requestor Number','rules' =>'trim|required'),
			array('field' =>'remail','label' =>'Requestor Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Remarks','rules' =>'trim|required'),
			array('field' =>'problem','label' =>'Problem Description','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_service_inhouse();
		}
		else
		{
			$data['requested_by'] = $this->input->post('requested_by');
			$data['r_number'] = $this->input->post('r_number');
			$data['remail'] = $this->input->post('remail');

			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			//$data['info'] = $this->input->post('info');
			//$data['problem'] = $this->input->post('problem');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Service Request (In House)";

			$data['form1'] = array(
				'desc' => 'Product Information',
				'details' => $this->input->post('info')
				);

			$data['form2'] = array(
				'desc' => 'Problem Description',
				'details' => $this->input->post('problem')
				);

			//save for autofill-in fields
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
			$data['company'],$data['store'],$data['address']);

			//check if have pending message
			$pendings = $this->Filters_model->search($data['c_number']);
			if(count($pendings)>0){
				$data['notes'] = $pendings;
				foreach ($pendings as $row) {
					$f_id = $row['filter_id'];
					$data1['tries']  = 0;
					$data1['status'] = 0;
					$data1['tries'] = $row['tries'] + 1;
					if($row['retry'] == $data1['tries']){
						$data1['status'] = 1;
					}
					$this->Filters_model->update_filter($f_id,$data1);
				}
			}
			//end

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($reply_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('service_inhouse');

					if($this->_send_mail('service_inhouse',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('service_inhouse');

					$send_to = $chase_mail['send_to'];
					
					$cc = array($chase_mail['cc'], $data['remail']);

					if($this->_send_mail('service_inhouse',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function software_bug(){
		if(!$_POST){
			$this->_get_software_bug();
		}else{
			$this->_post_software_bug();
		}
	}

	private function _get_software_bug(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/software_bug';
		$this->load->view('masterpage',$data);
	}

	private function _post_software_bug(){

	$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Remarks','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_software_bug();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			//$data['info'] = $this->input->post('info');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Software Bug Report";

			$data['form1'] = array(
				'desc' => 'Remarks',
				'details' => $this->input->post('info')
				);

			//Save information details
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('software_bug');

					if($this->_send_mail('software_bug',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('software_bug');

					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('software_bug',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function software_enhancement(){
		if(!$_POST){
			$this->_get_software_enhancement();
		}else{
			$this->_post_software_enhancement();
		}
	}

	private function _get_software_enhancement(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/software_enhancement';
		$this->load->view('masterpage',$data);
	}

	private function _post_software_enhancement(){

		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Remarks','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_software_enhancement();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			//$data['info'] = $this->input->post('info');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Software Enhancement Request";

			$data['form1'] = array(
				'desc' => 'Remarks',
				'details' => $this->input->post('info')
				);

			//Save information details
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('software_enhancement');

					if($this->_send_mail('software_enhancement',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('software_enhancement');

					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('software_enhancement',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------

	public function test(){
		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Remarks','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$data = $this->default;

			$cap = $this->_generateCaptcha();
			$data['captcha']= $cap['image'];
			$data['word']= $cap['word'];

			$data['childpage'] = 'contact/closed_sales';
			$this->load->view('masterpage',$data);
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			//$data['info'] = $this->input->post('info');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Closed Sales Request";

			$data['form1'] = array(
				'desc' => 'Remarks',
				'details' => $this->input->post('info')
				);

			//Save information details
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			$chase_mail = $this->Subgroup_model->get_record_by_slug('closed_sales');
			//echo realpath('./captcha/');
			
			
			
			debug($_FILES);

			

			// $this->load->library('upload');
   //      	$this->upload->initialize(array(
   //      		"upload_path" => realpath('./captcha/'), // server directory
   //      		"allowed_types" => "pdf|gif|jpg|png|txt|xls|xlsx|doc|docx|jpeg|bmp|csv",
   //      		"xss_clean" => TRUE));

			// if($this->upload->do_multi_upload('userfile')){
			// 	//Code to run upon successful upload.
			// 	$files = $this->upload->get_multi_upload_data();
			// 	debug($files);
	  //       }

	  //       debug($this->upload->display_errors());

		}
	}

	public function closed_sales(){
		if(!$_POST){
			$this->_get_closed_sales();
		}else{
			$this->_post_closed_sales();
		}
	}

	private function _get_closed_sales(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/closed_sales';
		$this->load->view('masterpage',$data);
	}

	private function _post_closed_sales(){

		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Remarks','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_closed_sales();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			//$data['info'] = $this->input->post('info');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Closed Sales Request";

			$data['form1'] = array(
				'desc' => 'Remarks',
				'details' => $this->input->post('info')
				);

			//Save information details
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('closed_sales');

					if($this->_send_mail('closed_sales',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('closed_sales');

					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('closed_sales',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function followup_schedule(){
		if(!$_POST){
			$this->_get_followup_schedule();
		}else{
			$this->_post_followup_schedule();
		}
	}

	private function _get_followup_schedule(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/followup_schedule';
		$this->load->view('masterpage',$data);
	}

	private function _post_followup_schedule(){

		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Remarks','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_followup_schedule();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			//$data['info'] = $this->input->post('info');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Follow-up Schedule Request";

			$data['form1'] = array(
				'desc' => 'Remarks',
				'details' => $this->input->post('info')
				);

			//Save information details
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('followup_schedule');

					if($this->_send_mail('followup_schedule',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('followup_schedule');

					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('followup_schedule',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function request_delivery(){
		if(!$_POST){
			$this->_get_request_delivery();
		}else{
			$this->_post_request_delivery();
		}
	}

	private function _get_request_delivery(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/request_delivery';
		$this->load->view('masterpage',$data);
	}

	private function _post_request_delivery(){
		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Remarks','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_request_delivery();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			//$data['info'] = $this->input->post('info');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Delivery Request";

			$data['form1'] = array(
				'desc' => 'Remarks',
				'details' => $this->input->post('info')
				);

			//Save information details
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('request_delivery');

					if($this->_send_mail('request_delivery',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('request_delivery');

					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('request_delivery',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function vehicle_request(){
		if(!$_POST){
			$this->_get_vehicle_request();
		}else{
			$this->_post_vehicle_request();
		}
	}

	private function _get_vehicle_request(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/request_vehicle';
		$this->load->view('masterpage',$data);
	}

	private function _post_vehicle_request(){

		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'sono','label' =>'SO Number','rules' =>'trim|required'),
			array('field' =>'mpdr','label' =>'MP/DR Number','rules' =>'trim|required'),
			array('field' =>'sino','label' =>'SI Number','rules' =>'trim|required'),
			array('field' =>'name','label' =>'Name','rules' =>'trim|required'),
			array('field' =>'dept','label' =>'Department','rules' =>'trim|required'),
			array('field' =>'purpose','label' =>'Purpose','rules' =>'trim|required'),
			array('field' =>'ddate','label' =>'Date','rules' =>'required'),
			array('field' =>'dtime','label' =>'Time','rules' =>'required'),
			array('field' =>'destination','label' =>'Destination','rules' =>'trim|required'),
			array('field' =>'plateno','label' =>'Plate No.','rules' =>'trim|required'),
			array('field' =>'driver','label' =>'Driver','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_vehicle_request();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			$data['sono'] = $this->input->post('sono');
			$data['mpdr'] = $this->input->post('mpdr');
			$data['sino'] = $this->input->post('sino');

			$data['name'] = $this->input->post('name');
			$data['dept'] = $this->input->post('dept');
			$data['purpose'] = $this->input->post('purpose');
			$data['ddate'] = $this->input->post('ddate');
			$data['dtime'] = $this->input->post('dtime');
			$data['destination'] = $this->input->post('destination');
			$data['plateno'] = $this->input->post('plateno');
			$data['driver'] = $this->input->post('driver');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Vehicle Request";

			//Save information details
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client_delivery',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase_delivery',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('vehicle_request');

					if($this->_send_mail('vehicle_request',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('vehicle_request');

					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('vehicle_request',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function register_pos(){
		if(!$_POST){
			$this->_get_register_pos();
		}else{
			$this->_post_register_pos();
		}
	}

	private function _get_register_pos(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/register_pos';
		$this->load->view('masterpage',$data);
	}

	private function _post_register_pos(){
		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Product Information','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_register_pos();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			//$data['info'] = $this->input->post('info');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="POS Registration Request";

			$data['form1'] = array(
				'desc' => 'Remarks',
				'details' => $this->input->post('info')
				);

			//Save information details
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($reply_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('register_pos');

					if($this->_send_mail('register_pos',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('register_pos');

					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('register_pos',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function request_brochure(){
		if(!$_POST){
			$this->_get_request_brochure();
		}else{
			$this->_post_request_brochure();
		}
	}

	private function _get_request_brochure(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/request_brochure';
		$this->load->view('masterpage',$data);
	}

	private function _post_request_brochure(){
		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Product Information','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_request_brochure();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			//$data['info'] = $this->input->post('info');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Brochure Request";

			$data['form1'] = array(
				'desc' => 'Remarks',
				'details' => $this->input->post('info')
				);

			//Save information details
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($reply_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('request_brochure');

					if($this->_send_mail('request_brochure',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('request_brochure');

					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('request_brochure',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function request_training(){
		if(!$_POST){
			$this->_get_request_training();
		}else{
			$this->_post_request_training();
		}
	}

	private function _get_request_training(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/request_training';
		$this->load->view('masterpage',$data);
	}

	private function _post_request_training(){
		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Product Information','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_request_training();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			//$data['info'] = $this->input->post('info');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Training Request";

			$data['form1'] = array(
				'desc' => 'Remarks',
				'details' => $this->input->post('info')
				);

			//Save information details
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('request_training');

					if($this->_send_mail('request_training',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('request_training');

					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('request_training',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}

//-----------------------------------------------------------
	public function customer_assistance(){
		if(!$_POST){
			$this->_get_customer_assistance();
		}else{
			$this->_post_customer_assistance();
		}
	}

	private function _get_customer_assistance(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/customer_assistance';
		$this->load->view('masterpage',$data);
	}

	private function _post_customer_assistance(){
		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Product Information','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_customer_assistance();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			$data['info'] = $this->input->post('info');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Customer Assistance Request";

			// //Save information details
			// $data['landline'] = "N/A";
			// $this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
			// 	$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			//$chase_mail = $this->Subgroup_model->get_record_by_slug('enroll_esa');

			switch (ENVIRONMENT)
				{
					case 'development':
						print($reply_msg);
						break;
					case 'testing':
						$chase_mail = $this->Subgroup_model->get_record_by_slug('customer_assistance');
						if($this->_send_mail('customer_assistance', $data['info_type'],$send_to,$data['email'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
							$this->M_Logs->save($chase_mail['id']);
							$this->_success();
						}else{
							$this->_fails();
						}
						break;
					case 'production':
						$chase_mail = $this->Subgroup_model->get_record_by_slug('customer_assistance');
						if($this->_send_mail('customer_assistance', $data['info_type'],$send_to,$data['email'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
							$this->M_Logs->save($chase_mail['id']);
							$this->_success();
						}else{
							$this->_fails();
						}
						break;
					default:
						exit('The application environment is not set correctly.');
				}
		}
	}
	//============================================================
	//============================================================
	//============================================================
	public function validate($func_name)
	{
		$this->load->library('form_validation');
		$config = array(
			array('field' =>'company','label' =>'Company Name','rules' =>'required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'required'),
			array('field' =>'branch','label' =>'Branch Location','rules' =>'required'),
			array('field' =>'c_person','label' =>'Contact Person.','rules' =>'required'),
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'required'),
			array('field' =>'info','label' =>'Product Information','rules' =>'required'),
			array('field' =>'problem','label' =>'Problem Description','rules' =>'required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->$func_name;
		}
		else
		{
			$data['compnay'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['branch'] = $this->input->post('branch');
			$data['c_person'] = $this->input->post('c_person');
			$data['c_number'] = $this->input->post('c_number');
			$data['landline'] = $this->input->post('landline');
			$data['email'] = $this->input->post('email');
			$data['info'] = $this->input->post('info');
			$data['problem'] = $this->input->post('problem');
			
		}
	}

	//----------------------check day status ---------------------
	private function _checkDay($template,$information){
		$date = date("Y-m-d");
		$time = time();
		//echo date('H:i:s',$time ).'<br>';
		//echo date_format(date_create($date),'l, F j, Y').'<br>';
		if($time <= strtotime('14:59:00')){
			//echo 'today <br>';
			if($time < strtotime('9:00:00')){
				//echo 'early morning<br>';
				if($this->_isSaturday($date)){
					//echo 'is saturday<br>';
					if($this->Holidays_model->isHoliday($date)){
						//echo 'is holiday<br>'; //check next if holiday/saturday/sunday
						//echo $this->_bestDay($date);
						$holidays = $this->_bestDay($date);
						$data['response_time'] = $holidays['a_date'];
						$data['holidays'] = $holidays['holidays'];
						$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
						//$this->load->view('temp/temp4',$data);
						
						$data = array_merge($information,$data);

						return $this->load->view('temp/'.$template,$data, true);
					}else{
						//echo 'time: 9:00:00 - 12:00:00<br>'; //today service
						$data['saturday'] = $date;
						$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
						//$this->load->view('temp/temp4',$data);
						$data = array_merge($information,$data);
						return $this->load->view('temp/'.$template,$data, true);
					}
				}else{
					if(($this->_isSunday($date)) || ($this->Holidays_model->isHoliday($date))){
						//echo 'is sunday or holiday<br>'; //check next if holiday/saturday/sunday
						//echo $this->_bestDay($date);
						$holidays = $this->_bestDay($date);
						//echo $holidays['a_date'];
						if($this->_isSaturday($holidays['a_date'])){
							$data['response_time2'] = $holidays['a_date'];
						}else{
							$data['response_time'] = $holidays['a_date'];
						}

						$data['holidays'] = $holidays['holidays'];
						$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
						//$this->load->view('temp/temp4',$data);
						$data = array_merge($information,$data);
						return $this->load->view('temp/'.$template,$data, true);
					}else{
						//echo 'time: 9:00:00 - 12:00:00<br>'; //today service
						$data['response_time'] = $date;
						$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
						//$this->load->view('temp/temp4',$data);
						$data = array_merge($information,$data);
						return $this->load->view('temp/'.$template,$data, true);
					}
				}
			}else{
				//echo 'office hour<br>';
				if($this->_isSaturday($date)){
					//echo 'saturday<br>';
					if($this->Holidays_model->isHoliday($date)){
						$holidays = $this->_bestDay($date);
						$data['response_time'] = $holidays['a_date'];
						$data['holidays'] = $holidays['holidays'];
						$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
						//$this->load->view('temp/temp4',$data);
						$data = array_merge($information,$data);
						return $this->load->view('temp/'.$template,$data, true);
					}else{
						if($time <= strtotime('10:01')){
							$start_time = date('H:i',$time );
							$endTime = date("H:i", strtotime("+3 hour"));

							$time = $start_time .' to '. $endTime;
							$data['saturday_today'] = date_format(date_create($date),'l, F j, Y') . ' from '.$time;;
							$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
							//$this->load->view('temp/temp4',$data);
							$data = array_merge($information,$data);
							return $this->load->view('temp/'.$template,$data, true);
						}else{
							$start_time = date('H:i',$time );
							$endTime = date("H:i", strtotime("+3 hour"));
							//echo $start_time .' to '.$endTime;

							$holidays = $this->_bestDay($date);
							//$holidays = $this->_bestDay(date('Y-m-d', strtotime("+ 1 day", strtotime($date))));
							$data['response_time'] = $holidays['a_date'];
							$data['holidays'] = $holidays['holidays'];
							$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
							//$this->load->view('temp/temp4',$data);
							$data = array_merge($information,$data);
							return $this->load->view('temp/'.$template,$data, true);
						}
					}

				}else{
					if(($this->_isSunday($date)) || ($this->Holidays_model->isHoliday($date))){
						//echo $this->_bestDay($date);;
						//echo 'saturday or holiday<br>';
						$holidays = $this->_bestDay($date);
						$data['response_time'] = $holidays['a_date'];
						$data['holidays'] = $holidays['holidays'];
						$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
						//$this->load->view('temp/temp4',$data);
						$data = array_merge($information,$data);
						return $this->load->view('temp/'.$template,$data, true);
					}else{
						//echo 'time: ' .date('H:i:s',$time ) . ' - '.date("H:i:s", strtotime("+3 hour")).'<br>';
						$start_time = date('H:i',$time );
						$endTime = date("H:i", strtotime("+3 hour"));

						//echo $time .'<br>';
						if((strtotime($endTime) > strtotime('12:00')) && (strtotime($endTime) < strtotime('13:00'))){
							//echo 'lunch break<br>';
							//$data['today'] = date_format(date_create($date),'l, F j, Y') . ' from '.$start_time .' to '. date("H:i", strtotime("+4 hour"));
							$endTime =  date("H:i", strtotime("+4 hour"));
						}else{
							//echo 'working hour<br>';
							if((strtotime($start_time) > strtotime('09:00')) && (strtotime($start_time) < strtotime('13:00'))){
								//echo 'plus 1 hour<br>';
								//$data['today'] = date_format(date_create($date),'l, F j, Y') . ' from '.$start_time .' to '. date("H:i", strtotime("+4 hour"));
								$endTime =  date("H:i", strtotime("+4 hour"));
							}else{
								//echo 'regular hour<br>';
								if((strtotime($endTime) > strtotime('12:00')) && (strtotime($endTime) < strtotime('13:00'))){
									$endTime =  date("H:i", strtotime("+4 hour"));
								}
								//$data['today'] = date_format(date_create($date),'l, F j, Y') . ' from '.$start_time .' to '. $endTime;
								//$endTime =  date("H:i", strtotime("+4 hour");
							}
						}

						$time = $start_time .' to '. $endTime;
						$temp = explode(':', $endTime);
						if($temp[1] < 30){
							if($temp[0] == 12){
								$temp[1] = '00';
							}else{
								$temp[1] = '30';
							}

						}else{
							$temp[0] = $temp[0] + 1;
							$temp[1] = '00';
						}
						//echo $time .'<br>';
						$data['today'] = date_format(date_create($date),'l, F j, Y');
						$data['start_time'] = $start_time;
						$data['end_time'] = $temp[0].':'.$temp[1];
						$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
						//$this->load->view('temp/temp4',$data);
						$data = array_merge($information,$data);
						return $this->load->view('temp/'.$template,$data, true);
					}
				}
			}

		}else{
			//echo 'tommorrow<br>';
			if($this->Holidays_model->isHoliday($date)){
				$holidays = $this->_bestDay($date);
				$data['response_time'] = $holidays['a_date'];
				$data['holidays'] = $holidays['holidays'];
				$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
				//$this->load->view('temp/temp4',$data);
				$data = array_merge($information,$data);
				return $this->load->view('temp/'.$template,$data, true);
			}else{
				//echo 'no holiday<br>';
				//$tempdate = date('Y-m-d', strtotime("+1 day", strtotime($date)));
				$holidays = $this->_bestDay(date('Y-m-d', strtotime("+ 1 day", strtotime($date))));
				$data['response_time'] = $holidays['a_date'];
				$data['holidays'] = $holidays['holidays'];
				$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
				//$this->load->view('temp/temp4',$data);
				$data = array_merge($information,$data);
				return $this->load->view('temp/'.$template,$data, true);
			}

		}
	}

	private function _bestDay($date){
		$i = 0;
		$nowork = TRUE;
		$data = array();
		$array = array();
		while($nowork){
			$tempDate = date('Y-m-d', strtotime("+".$i." day", strtotime($date)));
			if($this->_noWork($tempDate)){
				$array[] =  $this->_getDescription($tempDate);
				$i++;
			}else{
				$nowork = FALSE;
			}
		}
		$data['a_date'] = date('Y-m-d', strtotime("+".$i." day", strtotime($date)));
		$data['holidays'] = $array;
		return $data;
	}


	private function _noWork($date){
		if(($this->Holidays_model->isHoliday($date)) || ($this->_isSunday($date))){
			return TRUE;
		}else{
			if($this->_isSaturday($date)){
				if($this->Holidays_model->isHoliday($date)){
					return TRUE;
				}else{
					if($this->_isSaturday(date('ymd'))){
						$endTime = date("H:i", strtotime("+3 hour"));
						if( strtotime($endTime) > strtotime('13:00')){
							return TRUE;
						}else{
							return FALSE;
						}
					}else{
						return FALSE;
					}
				}
			}else{
				return FALSE;
			}
		}
	}

	private function _getDescription($date){
		if($this->_isSunday($date)){
			return date_format(date_create($date),'l, F j, Y').' - Company Day Off';
		}else if($this->_isSaturday($date)){
			if($this->Holidays_model->isHoliday($date)){
				$data = $this->Holidays_model->getHoliday($date);
				return date_format(date_create($date),'l, F j, Y').' - ' .$data['desc'];
			}else{
				return date_format(date_create($date),'l, F j, Y').' - Half Day (09:00 to 13:00)';
			}
		}else{
			$data = $this->Holidays_model->getHoliday($date);
			return date_format(date_create($date),'l, F j, Y').' - ' .$data['desc'];
		}
	}

	private function _isSunday($date){
		$date1 = strtotime($date);
		$date2 = date("l", $date1);
		$date3 = strtolower($date2);
		//echo $date3;
		if($date3 == "sunday"){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	private function _isSaturday($date){
		$date1 = strtotime($date);
		$date2 = date("l", $date1);
		$date3 = strtolower($date2);
		//echo $date3;
		if($date3 == "saturday"){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	private function _send_mail($slug,$request_name,$chase_email,$client_email,$message,$replymsg,$company_name,$contact_no,$cc = null){
		// file upload
		// $uconfig['upload_path'] = realpath('./captcha/'); // server directory
		// $uconfig['allowed_types'] = 'pdf|gif|jpg|png|txt|xls|xlsx|doc|docx|jpeg|bmp|csv'; // by extension, will check for whether it is an image
		// $uconfig['max_size']    = '2048'; // in kb

		// $this->load->library('upload', $uconfig);
		// $this->load->library('Multi_upload');

		// //print_r($_FILES);
		// $files = $this->multi_upload->go_upload();
		// //print_r($files);

		$this->load->library('upload');
		$this->upload->initialize(array(
			"upload_path" => realpath('./captcha/'), // server directory
			"allowed_types" => "pdf|gif|jpg|png|txt|xls|xlsx|doc|docx|jpeg|bmp|csv"));

		if($this->upload->do_multi_upload('userfile')){
			//Code to run upon successful upload.
			$files = $this->upload->get_multi_upload_data();
		}

		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'mail.chasetech.com';
		$config['smtp_port']    = '25';
		$config['smtp_timeout'] = '10';
		$config['smtp_user']    = 'webmail@chasetech.com';
		$config['smtp_pass']    = 'kartero';
		$config['charset']    = 'utf-8';
		$config['newline']    = "\r\n";
		$config['mailtype'] = 'html'; // or html
		$config['validation'] = TRUE; // bool whether to validate email or not


		//$this->email->initialize($config); bug nat sending mail change to nextline 09042012
		$this->load->library('email', $config);

		switch (ENVIRONMENT)
		{
			case 'development':
				$this->email->to('rencie.bautista@yahoo.com');
			break;
			case 'testing':
				$this->email->to('rencie.bautista@yahoo.com');
			break;
			case 'production':
				// $bcc_emails=array($chase_email);
				$this->email->cc($cc);
				$this->email->to($chase_email);
			break;
			default:
				exit('The application environment is not set correctly.');
		}


		$this->email->from('webmaster@chasetech.com',$request_name);

		if($this->Blacklist_model->blacklisted($contact_no)){
			$this->email->subject('Blacklisted Contact - '.$company_name. " - ".$request_name);
		}else{
			$this->email->subject($company_name. " - ".$request_name);
		}
		
		$this->email->message($message);

		if(isset($files)){
			foreach ($files as $item) {
				$this->email->attach($item['full_path']);
			}
		}

		if(!$this->email->send())
		{
			if($files){
				$this->load->helper("file");
				foreach ($files as $item) {
					@unlink($item['full_path']);
				}
			}

			return FALSE;
		}
		else
		{
			if(!$this->Blacklist_model->blacklisted($contact_no)){
				$this->email->clear();
				$this->email->to($client_email);
				$this->email->from('webmaster@chasetech.com',$request_name);
				$this->email->subject($request_name.' Confirmation');
				$this->email->message($replymsg);
				if(!$this->email->send()){
					return FALSE;
				}else{
					return TRUE;
				}
			}
			
			if($files){
				$this->load->helper("file");
				foreach ($files as $item) {
					@unlink($item['file']);
				}
			}

			//log request

			return TRUE;
		}


		//$this->email->print_debugger();
	}

	private function _fails(){
		$data = $this->default;
		$data['childpage'] = 'contact/fail';
		$this->load->view('masterpage',$data);
	}
	private function _success(){
		$data = $this->default;
		$data['childpage'] = 'contact/success';
		$this->load->view('masterpage',$data);
	}
//-----------------------------------------------------------
	public function employee(){
		// $json = file_get_contents('http://helpdesk/api/verify_employee/4107m'); 
		// $data = json_decode($json);
		// debug($data);
		$id = $this->input->get('id');
		$data = $this->default;

		$json = file_get_contents('http://helpdesktwo.chasetech.com/api/verify_employee/'.ltrim(trim($id), '0')); 
		$data['api'] = json_decode($json);
		$data['childpage'] = 'contact/employee';
		$this->load->view('masterpage',$data);
	}
//-----------------------------------------------------------
	public function bir_followup(){
		if(!$_POST){
			$this->_get_bir_followup();
		}else{
			$this->_post_bir_followup();
		}
	}

	private function _get_bir_followup(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/bir_followup';
		$this->load->view('masterpage',$data);
	}

	private function _post_bir_followup(){

		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Remarks','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_followup_schedule();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			$data['salesorder'] = $this->input->post('salesorder');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Follow-up Bir Application";

			$data['form1'] = array(
				'desc' => 'Remarks',
				'details' => $this->input->post('info')
				);

			//Save information details
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('bir_followup');

					if($this->_send_mail('bir_followup',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('bir_followup');

					if($this->_send_mail('bir_followup',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function man_power(){
		if(!$_POST){
			$this->_get_man_power();
		}else{
			$this->_post_man_power();
		}
	}

	private function _get_man_power(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/man_power';
		$this->load->view('masterpage',$data);
	}

	private function _post_man_power(){

		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'project','label' =>'Project / Client Name','rules' =>'trim|required'),
			array('field' =>'no_man','label' =>'No. of Man Power','rules' =>'trim|required'),
			array('field' =>'start_date','label' =>'Start Date','rules' =>'trim|required'),
			array('field' =>'end_date','label' =>'End Date','rules' =>'trim|required'),
			array('field' =>'info','label' =>'Remarks','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_man_power();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Man Power Request";

			$data['form3'] = array(
				'desc' => 'Details',
				'project' => $this->input->post('project'),
				'no_man' => $this->input->post('no_man'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'info' => $this->input->post('info')
				);

			//Save information details
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('man_power');

					if($this->_send_mail('man_power', $data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('man_power');

					if($this->_send_mail('man_power', $data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}

//-----------------------------------------------------------------------------------
	public function purchase_request(){
		if(!$_POST){
			$this->_get_purchase_request();
		}else{
			$this->_post_purchase_request();
		}
	}

	private function _get_purchase_request(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/purchase_request';
		$this->load->view('masterpage',$data);
	}

	private function _post_purchase_request(){

		$this->load->library('form_validation');
		$config = array(
			array('field' =>'client','label' =>'Client Name','rules' =>'trim|required'),
			array('field' =>'salesorder','label' =>'Sales Order','rules' =>'trim|required'),
			array('field' =>'requestor','label' =>'Requested By','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_purchase_request();
		}
		else
		{
			$data['client'] = $this->input->post('client');
			$data['salesorder'] = $this->input->post('salesorder');
			$data['requestor'] = $this->input->post('requestor');
			$data['email'] = $this->input->post('email');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Purchase Request";
			$data['barcode'] = $this->input->post('barcode');
			$data['desc'] = $this->input->post('desc');
			$data['qty'] = $this->input->post('qty');
			$data['remarks'] = $this->input->post('remarks');

			$reply_msg = $this->_checkDay('purchase_tpl_client',$data);
			$chase_msg = $this->_checkDay('purchase_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($reply_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('purchase_request');

					if($this->_send_mail('purchase_request',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['client'],'')){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('purchase_request');

					if($this->_send_mail('purchase_request',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['client'],'')){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}

//-----------------------------------------------------------------------------------
	public function messenger_request(){
		if(!$_POST){
			$this->_get_messenger_request();
		}else{
			$this->_post_messenger_request();
		}
	}

	private function _get_messenger_request(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];

		$data['childpage'] = 'contact/messenger_request';

		$chase_mail = $this->Subgroup_model->get_record_by_slug('messenger_request');

		$data['purpose'] = $this->Subgroup_model->get_by_parent_id($chase_mail['id']);
		$this->load->view('masterpage',$data);
	}

	private function _post_messenger_request(){

		$this->load->library('form_validation');
		$config = array(
			array('field' =>'c_number','label' =>'Contact Number','rules' =>'trim|required'),
			array('field' =>'c_person','label' =>'ContactPerson','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Store Name','rules' =>'trim|required'),
			array('field' =>'address','label' =>'Address','rules' =>'trim|required'),
			array('field' =>'purpose','label' =>'Purpose','rules' =>'trim|required|is_natural_no_zero'),
			array('field' =>'info','label' =>'Remarks','rules' =>'trim|required'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_followup_schedule();
		}
		else
		{
			$data['c_number'] = $this->input->post('c_number');
			$data['c_person'] = $this->input->post('c_person');
			$data['email'] = $this->input->post('email');
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['address'] = $this->input->post('address');
			$purpose = $this->Subgroup_model->get_by_id($this->input->post('purpose'));
			$data['purpose'] = $purpose['sub_group'];
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Request for Messenger";

			$data['form1'] = array(
				'desc' => 'Remarks',
				'details' => $this->input->post('info')
				);

			//Save information details
			$data['landline'] = "N/A";
			$this->Clients_model->add($data['c_number'],$data['landline'],$data['c_person'],$data['email'],
				$data['company'],$data['store'],$data['address']);

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($chase_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('messenger_request');

					if($this->_send_mail('messenger_request',$data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'])){
						$this->M_Logs->save($purpose['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('messenger_request');

					$send_to = $chase_mail['send_to'];
					
					$cc = $chase_mail['cc'];
					
					// $chase_mail = $send_to . ',' . $cc;

					if($this->_send_mail('messenger_request',$data['info_type'],$send_to,$data['email'],$chase_msg,$reply_msg,$data['company'],$data['c_number'],$cc)){
						$this->M_Logs->save($purpose['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}
//-----------------------------------------------------------
	public function billing_request(){
		if(!$_POST){
			$this->_get_billing_request();
		}else{
			$this->_post_billing_request();
		}
	}

	private function _get_billing_request(){
		$data = $this->default;

		$cap = $this->_generateCaptcha();
		$data['captcha']= $cap['image'];
		$data['word']= $cap['word'];
		$data['payment_for'] = array(array('id' => 1, 'desc' => 'Collection'),
			array('id' => 2, 'desc' => 'Services'));
		$data['type'] = array(array('id' => 1, 'desc' => 'Cash'),
			array('id' => 2, 'desc' => 'Check'));

		$data['childpage'] = 'contact/billing_request';
		$this->load->view('masterpage',$data);
	}

	private function _post_billing_request(){

		$this->load->library('form_validation');
		$config = array(
			array('field' =>'company','label' =>'Company Name','rules' =>'trim|required'),
			array('field' =>'store','label' =>'Branch Name','rules' =>'trim|required'),
			array('field' =>'so','label' =>'Sales Order','rules' =>'trim|required'),
			array('field' =>'payment_for','label' =>'Payment for','rules' =>'trim|required|is_natural_no_zero'),
			array('field' =>'type','label' =>'Store Name','rules' =>'trim|required|is_natural_no_zero'),
			array('field' =>'service_by','label' =>'Service By','rules' =>''),
			array('field' =>'expense','label' =>'Expenses','rules' =>'trim|required'),
			array('field' =>'requestor','label' =>'Requested By','rules' =>'trim|required'),
			array('field' =>'email','label' =>'Email Address','rules' =>'trim|required|valid_email'),
			array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('required', 'This field is required.');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		if($this->form_validation->run() == FALSE){
			$this->_get_billing_request();
		}
		else
		{
			$data['company'] = $this->input->post('company');
			$data['store'] = $this->input->post('store');
			$data['so'] = $this->input->post('so');
			$data['payment_for'] = $this->input->post('payment_for');
			$data['type'] = $this->input->post('type');
			$data['service_by'] = $this->input->post('service_by');
			$data['expense'] = $this->input->post('expense');
			$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
			$data['date_inquiry'] = date('l jS \of F Y h:i:s A');
			$data['requestor'] = $this->input->post('requestor');
			$data['email'] = $this->input->post('email');
			$data['ip_address'] = $this->input->ip_address();
			$data['info_type'] ="Billing Request";

			//Save information details
			$this->Clients_model->add('','','',$data['email'],
				$data['company'],$data['store'],'');

			$reply_msg = $this->_checkDay('email_tpl_client',$data);
			$chase_msg = $this->_checkDay('email_tpl_chase',$data);

			switch (ENVIRONMENT)
			{
				case 'development':
					print($reply_msg);
					break;
				case 'testing':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('billing_request');

					if($this->_send_mail('billing_request', $data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],'')){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				case 'production':
					$chase_mail = $this->Subgroup_model->get_record_by_slug('billing_request');

					if($this->_send_mail('billing_request', $data['info_type'],$chase_mail['send_to'],$data['email'],$chase_msg,$reply_msg,$data['company'],'')){
						$this->M_Logs->save($chase_mail['id']);
						$this->_success();
					}else{
						$this->_fails();
					}
					break;
				default:
					exit('The application environment is not set correctly.');
			}
		}
	}


}

/* End of file contact.php */
/* Location: ./application/controllers/contact.php */