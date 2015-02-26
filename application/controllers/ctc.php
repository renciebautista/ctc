<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ctc extends CI_Controller {


	private $cart = array();
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function __construct(){
		parent::__construct();
		$this->load->model('admin/Settings_model');
	}

	public function page_notfound(){
		$data['styles'] = array('maincontent','index_content','styles','easySlides.default.min');
		$data['script'] = array('chrome','jquery-1.9.1','jquery.easyslides.min.v1.1','example_1');
		$data['prodCategory'] = $this->M_ProductCat->getAllProductCat();
		$data['indCategory'] = $this->M_IndustryCat->getAllIndustryCat();
		$data['whatwedo'] = $this->M_Whatwedo->getAllWhatwedo();
		$data['childpage'] = 'page_notfound';
		$data['image'] = 'false';
		$this->load->view('masterpage',$data);
	}

	public function index(){
		$data['styles'] = array('maincontent','index_content','styles','easySlides.default.min');
		$data['script'] = array('chrome','jquery-1.9.1','jquery.easyslides.min.v1.1','example_1');
		$data['prodCategory'] = $this->M_ProductCat->getAllProductCat();
		$data['indCategory'] = $this->M_IndustryCat->getAllIndustryCat();
		$data['whatwedo'] = $this->M_Whatwedo->getAllWhatwedo();
		$data['childpage'] = 'home';
		$data['image'] = 'false';
		$this->load->view('masterpage',$data);
	}

	public function product($id=null){
		$data['styles'] = array('maincontent','products_contents','industry_main','index_content','easySlides.default.min','small');
		$data['script'] = array('chrome','jquery-1.9.1','jquery.easyslides.min.v1.1','small');
        $data['prodCategory'] = $this->M_ProductCat->getAllProductCat();
		$data['indCategory'] = $this->M_IndustryCat->getAllIndustryCat();
		$data['whatwedo'] = $this->M_Whatwedo->getAllWhatwedo();
		if($id == null)
		{
			$data['childpage'] = 'product_index';
		}
		else{
			$data['product'] = $this->M_ProductCat->getProduct($id);
			if(!count($data['product'])){
				redirect('ctc/product','refresh');
			}
			$catid = $data['product']['productcategory'];
			$data['categoryname'] = $this->M_ProductCat->getCategory($catid);
			$data['idealfor'] = $this->M_Idealfor->idealFor($id);
			$data['childpage'] = 'item';
		}
		$this->load->view('masterpage',$data);
    }

	public function category($id){
		$data['styles'] = array('maincontent','industry_main','index_content','easySlides.default.min','small');
		$data['script'] = array('chrome','jquery-1.9.1','jquery.easyslides.min.v1.1','small');
		$data['prodCategory'] = $this->M_ProductCat->getAllProductCat();
		$data['indCategory'] = $this->M_IndustryCat->getAllIndustryCat();
		$data['whatwedo'] = $this->M_Whatwedo->getAllWhatwedo();
		$data['categoryname'] = $this->M_ProductCat->getCategory($id);
		if(!count($data['categoryname'])){
			redirect('ctc/product','refresh');
		}
		$data['products'] = $this->M_ProductCat->getProducts($id);
		$data['childpage'] = 'product';
		$this->load->view('masterpage',$data);
	}

	public function industry($id = null){
		$data['styles'] = array('maincontent','industry_main','index_content','easySlides.default.min','small');
		$data['script'] = array('chrome','jquery-1.9.1','jquery.easyslides.min.v1.1','small','hideunhide');
		$data['prodCategory'] = $this->M_ProductCat->getAllProductCat();
		$data['indCategory'] = $this->M_IndustryCat->getAllIndustryCat();
		$data['whatwedo'] = $this->M_Whatwedo->getAllWhatwedo();
		if($id == null){
			$data['childpage'] = 'industry_index';
		}
		else
		{
			$data['industryCategory'] = $this->M_IndustryCat->getIndustryCategory($id);
			if(!count($data['industryCategory'])){
				redirect('ctc/industry','refresh');
			}
			$data['categorylist'] = $this->M_IndustryCat->getIndustryByCategory($id);
			$data['childpage'] = 'industry';
		}
		$this->load->view('masterpage',$data);
	}

	public function solution($id = null){
		$data['styles'] = array('maincontent','industry_setup','index_content','easySlides.default.min','small');
		$data['script'] = array('chrome','jquery-1.9.1','jquery.easyslides.min.v1.1','small');
		$data['prodCategory'] = $this->M_ProductCat->getAllProductCat();
		$data['indCategory'] = $this->M_IndustryCat->getAllIndustryCat();
		$data['whatwedo'] = $this->M_Whatwedo->getAllWhatwedo();
		$data['solution'] = $this->M_IndustryCat->getSolution($id);
		if(!count($data['solution'])){
			redirect('ctc/industry','refresh');
		}
		$data['category'] = $this->M_IndustryCat->getIndustryCategory($data['solution']['industrycategory']);
		$data['childpage'] = 'solution';
		$this->load->view('masterpage',$data);
	}

	public function whatwedo(){
		$data['styles'] = array('maincontent','whatwedo','index_content','easySlides.default.min','small');
		$data['script'] = array('chrome','jquery-1.9.1','jquery.easyslides.min.v1.1','small');
		$data['prodCategory'] = $this->M_ProductCat->getAllProductCat();
		$data['indCategory'] = $this->M_IndustryCat->getAllIndustryCat();
		$data['whatwedo'] = $this->M_Whatwedo->getAllWhatwedo();
		$data['childpage'] = 'whatwedo';
		$this->load->view('masterpage',$data);
	}

	public function profile(){
		$data['styles'] = array('maincontent','products_contents','updates_newsletters','index_content','easySlides.default.min','small');
		$data['script'] = array('chrome','jquery-1.9.1','jquery.easyslides.min.v1.1','small');
		$data['prodCategory'] = $this->M_ProductCat->getAllProductCat();
		$data['indCategory'] = $this->M_IndustryCat->getAllIndustryCat();
		$data['whatwedo'] = $this->M_Whatwedo->getAllWhatwedo();
		$data['childpage'] = 'profile';
		$this->load->view('masterpage',$data);
	}
	public function career(){
		$data['styles'] = array('maincontent','products_contents','industry_main','index_content','easySlides.default.min','small');
		$data['script'] = array('chrome','jquery-1.9.1','jquery.easyslides.min.v1.1','small');
		$data['prodCategory'] = $this->M_ProductCat->getAllProductCat();
		$data['indCategory'] = $this->M_IndustryCat->getAllIndustryCat();
		$data['whatwedo'] = $this->M_Whatwedo->getAllWhatwedo();
		$data['career'] = $this->M_Career->getAllCareers();
		$data['childpage'] = 'career';
		$settings = $this->Settings_model->getSettings();
		$data['career_header'] = $settings['career_header'];
		$this->load->view('masterpage',$data);
	}


	// public function salesinquiry(){
	// 	$data['styles'] = array('maincontent','industry_main','index_content','easySlides.default.min','small');
	// 	$data['script'] = array('chrome','jquery-1.9.1','jquery.easyslides.min.v1.1','small',
	// 								'jquery.validate','jquery.validate-rules','isnumeric','jquery.MultiFile.min',
	// 								'jquery.numericonly');
		
	// 	$data['prodCategory'] = $this->M_ProductCat->getAllProductCat();
	// 	$data['indCategory'] = $this->M_IndustryCat->getAllIndustryCat();
	// 	$data['whatwedo'] = $this->M_Whatwedo->getAllWhatwedo();
	// 	$data['career'] = $this->M_Career->getAllCareers();
	// 	$data['industry'] = $this->M_IndustryCat->getAllIndustry();


	// 	//load validation rules
	// 	$this->load->library('form_validation');
	// 	$config = array(
	// 		array(
	// 			'field' =>'fullname',
	// 			'label' =>'Full Name',
	// 			'rules' =>'required'
	// 		),
	// 		array(
	// 			'field' =>'company',
	// 			'label' =>'Company',
	// 			'rules' =>'required'
	// 		),
	// 		array(
	// 			'field' =>'address',
	// 			'label' =>'Address',
	// 			'rules' =>'required'
	// 		),
	// 		array(
	// 			'field' =>'cell',
	// 			'label' =>'Cell phone No.',
	// 			'rules' =>'required'
	// 		),
	// 		array(
	// 			'field' =>'landline',
	// 			'label' =>'Landline',
	// 			'rules' =>'required'
	// 		),
	// 		array(
	// 			'field' =>'email',
	// 			'label' =>'Email Address',
	// 			'rules' =>'required'
	// 		),
	// 		array(
	// 			'field' =>'product',
	// 			'label' =>'Product of Interest',
	// 			'rules' =>'required'
	// 		),
	// 		array(
	// 			'field' =>'captcha',
	// 			'label' =>'Security',
	// 			'rules' =>'required|callback_captcha_check'
	// 		)
	// 	);
	// 	$this->form_validation->set_rules($config);
	// 	$this->form_validation->set_message('required', 'This field is required.');
	// 	$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
	// 	if($this->form_validation->run() == FALSE){
			
	// 		$cap = $this->_generateCaptcha();
	// 		$data['captcha']= $cap['image'];
	// 		$data['word']= $cap['word'];

	// 		$data['childpage'] = 'salesinquiry';
	// 		if(isset($_SESSION['cart'])){
	// 			$data['inquiry'] = "I'm interested on the following products:\n";
	// 			$cart = array();
	// 			$cart = $_SESSION['cart'];
	// 			foreach($cart as $row){
	// 				$data['inquiry'] = $data['inquiry'] . $row['desc'] . "\n";
	// 			}
	// 		}
	// 		$this->load->view('masterpage',$data);
	// 	}
	// 	else
	// 	{
	// 		$data['fullname'] = $this->input->post('fullname');
	// 		$data['compnay'] = $this->input->post('company');
	// 		$data['industry'] = $this->input->post('industry');
	// 		$data['others'] = $this->input->post('others');
	// 		$data['address'] = $this->input->post('address');
	// 		$data['cell'] = $this->input->post('cell');
	// 		$data['landline'] = $this->input->post('landline');
	// 		$data['email'] = $this->input->post('email');
	// 		$data['product'] = $this->input->post('product');
	// 		$data['industry'] = $this->input->post('industry');

	// 		//$template = $this->load->view('temp/temp1', '', true);
	// 		$template = $this->_checkDay('temp1');
	// 		//$reply = $this->load->view('temp/temp3', '', true);
	// 		$reply = $this->_checkDay('temp3');
	// 		$ip_addr = $this->input->ip_address();
	// 		//$template = file_get_contents(base_url() . 'template/temp1.html');
	// 		//$reply = file_get_contents(base_url() . 'template/temp3.html');
	// 		$message = str_replace(
	// 				array('?cname',
	// 					  '?address',
	// 					  '?type',
	// 					  '?others',
	// 					  '?name',
	// 					  '?mobile',
	// 					  '?line',
	// 					  '?email',
	// 					  '?product',
	// 					  '?date',
	// 					  '?ipadd'),
	// 				array($data['compnay'],
	// 					  $data['address'],
	// 					  $data['industry'],
	// 					  $data['others'],
	// 					  $data['fullname'],
	// 					  $data['cell'],
	// 					  $data['landline'],
	// 					  $data['email'],
	// 					  $data['product'],
	// 					  date('l jS \of F Y h:i:s A'),
	// 					  $ip_addr),$template
	// 				);

	// 		$reply = $this->load->view('temp/temp3', '', true);
	// 		//$template = file_get_contents(base_url() . 'template/temp1.html');
	// 		//$reply = file_get_contents(base_url() . 'template/temp3.html');
	// 		$replymsg = str_replace(
	// 				array('?cname',
	// 					  '?address',
	// 					  '?type',
	// 					  '?others',
	// 					  '?name',
	// 					  '?mobile',
	// 					  '?line',
	// 					  '?email',
	// 					  '?product',
	// 					  '?date'),
	// 				array($data['compnay'],
	// 					  $data['address'],
	// 					  $data['industry'],
	// 					  $data['others'],
	// 					  $data['fullname'],
	// 					  $data['cell'],
	// 					  $data['landline'],
	// 					  $data['email'],
	// 					  $data['product'],
	// 					  date('l jS \of F Y h:i:s A')),$reply
	// 				);


	// 		$config['protocol']    = 'smtp';
	// 		$config['smtp_host']    = 'mail.chasetech.com';
	// 		$config['smtp_port']    = '25';
	// 		$config['smtp_timeout'] = '10';
	// 		$config['smtp_user']    = 'webmail@chasetech.com';
	// 		$config['smtp_pass']    = 'kartero';
	// 		$config['charset']    = 'utf-8';
	// 		$config['newline']    = "\r\n";
	// 		$config['mailtype'] = 'html'; // or html
	// 		$config['validation'] = TRUE; // bool whether to validate email or not

	// 		//$this->email->initialize($config); bug nat sending mail change to nextline 09042012
	// 		$this->load->library('email', $config);

	// 		switch (ENVIRONMENT)
	// 		{
	// 			case 'development':
	// 				$this->email->to('salesinquiry@chasetech.com');
	// 			break;
	// 			case 'testing':
	// 				$this->email->to('ibautista@chasetech.com');
	// 			break;
	// 			case 'production':
	// 				$this->email->to('salesinquiry@chasetech.com');
	// 			break;
	// 			default:
	// 				exit('The application environment is not set correctly.');
	// 		}

	// 		$this->email->from('salesinquiry@chasetech.com','Sales Inquiry');
	// 		$this->email->subject($data['compnay']. " - Sales Inquiry Form");
	// 		$this->email->message($message);
	// 		if(!$this->email->send())
	// 		{
	// 			$this->session->set_flashdata('msg','<span class="notification n-error">Mail sending error occured will submitting the sales request form, please try again.</span>');
	// 			redirect('ctc/salesinquiry');
	// 		}
	// 		else
	// 		{
	// 			$this->email->clear();
	// 			$this->email->to($data['email']);
	// 			$this->email->from('salesinquiry@chasetech.com','Chasetech Sales Inquiry');
	// 			$this->email->subject('Sales Inquiry Form Confirmation');
	// 			$this->email->message($replymsg);
	// 			$this->email->send();

	// 			$this->session->set_flashdata('msg','<span class="notification n-success">Thank you, '.
	// 										  $data['fullname'].' . Your sales request form was submitted successfully!</span>');
	// 			redirect('ctc/salesinquiry');
	// 		}
	// 		//$this->email->print_debugger();
	// 		unset($_SESSION['cart']);
	// 	}
	// }

	// public function servicerequest(){
	// 	$data['styles'] = array('maincontent','industry_main','index_content','easySlides.default.min','small');
	// 	$data['script'] = array('chrome','jquery-1.9.1','jquery.easyslides.min.v1.1','small',
	// 								'jquery.validate','jquery.validate-rules','isnumeric','jquery.MultiFile.min',
	// 								'jquery.numericonly');
	// 	$data['prodCategory'] = $this->M_ProductCat->getAllProductCat();
	// 	$data['indCategory'] = $this->M_IndustryCat->getAllIndustryCat();
	// 	$data['whatwedo'] = $this->M_Whatwedo->getAllWhatwedo();
	// 	$data['career'] = $this->M_Career->getAllCareers();
	// 	$data['industry'] = $this->M_IndustryCat->getAllIndustry();

	// 	//load validation rules
	// 	$this->load->library('form_validation');
	// 	$config = array(
	// 		array('field' =>'company','label' =>'Company Name','rules' =>'required'),
	// 		array('field' =>'store','label' =>'Store Name','rules' =>'required'),
	// 		array('field' =>'branch','label' =>'Branch Location','rules' =>'required'),
	// 		array('field' =>'c_person','label' =>'Contact Person.','rules' =>'required'),
	// 		array('field' =>'c_number','label' =>'Contact Number','rules' =>'required'),
	// 		array('field' =>'email','label' =>'Email Address','rules' =>'required'),
	// 		array('field' =>'info','label' =>'Product Information','rules' =>'required'),
	// 		array('field' =>'problem','label' =>'Problem Description','rules' =>'required'),
	// 		array('field' =>'captcha','label' =>'Security','rules' =>'required|callback_captcha_check')
	// 	);
	// 	$this->form_validation->set_rules($config);
	// 	$this->form_validation->set_message('required', 'This field is required.');
	// 	$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
	// 	if($this->form_validation->run() == FALSE){

	// 		$cap = $this->_generateCaptcha();
	// 		$data['captcha']= $cap['image'];
	// 		$data['word']= $cap['word'];

	// 		$data['childpage'] = 'servicerequest';
	// 		$this->load->view('masterpage',$data);
	// 	}
	// 	else
	// 	{
	// 		$data['compnay'] = $this->input->post('company');
	// 		$data['store'] = $this->input->post('store');
	// 		$data['branch'] = $this->input->post('branch');
	// 		$data['c_person'] = $this->input->post('c_person');
	// 		$data['c_number'] = $this->input->post('c_number');
	// 		$data['email'] = $this->input->post('email');
	// 		$data['info'] = $this->input->post('info');
	// 		$data['problem'] = $this->input->post('problem');
			
	// 		$category  = $this->input->post('category');
	// 		$cat = '';
	// 		switch($category){
	// 			case '1':
	// 				$cat  = 'Hardware';
	// 			break;
	// 			case '2':
	// 				$cat  = 'Software';
	// 			break;
	// 			case '3':
	// 				$cat  = 'Both Hardware and Software';
	// 			break;
	// 		}

	// 		//$template = file_get_contents(base_url() . 'template/temp2.html');
	// 		//$reply = file_get_contents(base_url() . 'template/temp3.html');
	// 		$ip_addr = $this->input->ip_address();
	// 		//$template = $this->load->view('temp/temp2', '', true);
			
	// 		$template = $this->_checkDay('temp2');

	// 		$message = str_replace(
	// 				array('?cname',
	// 					  '?store',
	// 					  '?branch',
	// 					  '?cperson',
	// 					  '?cnumber',
	// 					  '?email',
	// 					  '?info',
	// 					  '?problem',
	// 					  '?date',
	// 					  '?ipadd',
	// 					  '?category'),
	// 			array($data['compnay'],
	// 				  $data['store'],
	// 				  $data['branch'],
	// 				  $data['c_person'],
	// 				  $data['c_number'],
	// 				  $data['email'],
	// 				  nl2br($data['info']),
	// 				  nl2br($data['problem']),
	// 				  date('l jS \of F Y h:i:s A'),
	// 				  $ip_addr,
	// 				  $cat),$template
	// 			);

	// 		$reply = $this->_checkDay('temp4');
	// 		$replymsg = str_replace(
	// 				array('?cname',
	// 					  '?store',
	// 					  '?branch',
	// 					  '?cperson',
	// 					  '?cnumber',
	// 					  '?email',
	// 					  '?info',
	// 					  '?problem',
	// 					  '?date',
	// 					  '?category'),
	// 			array($data['compnay'],
	// 				  $data['store'],
	// 				  $data['branch'],
	// 				  $data['c_person'],
	// 				  $data['c_number'],
	// 				  $data['email'],
	// 				  nl2br($data['info']),
	// 				  nl2br($data['problem']),
	// 				  date('l jS \of F Y h:i:s A'),
	// 				  $cat),$reply
	// 			);

	// 		// file upload
	// 		$uconfig['upload_path'] = realpath('./captcha/'); // server directory
	// 		$uconfig['allowed_types'] = 'pdf|gif|jpg|png|txt|xls|xlsx|doc|docx|jpeg|bmp|csv'; // by extension, will check for whether it is an image
	// 		$uconfig['max_size']    = '2048'; // in kb

	// 		$this->load->library('upload', $uconfig);
	// 		$this->load->library('Multi_upload');

	// 		//print_r($_FILES);
	// 		$files = $this->multi_upload->go_upload();
	// 		//print_r($files);


	// 		$config['protocol']    = 'smtp';
	// 		$config['smtp_host']    = 'mail.chasetech.com';
	// 		$config['smtp_port']    = '25';
	// 		$config['smtp_timeout'] = '10';
	// 		$config['smtp_user']    = 'webmail@chasetech.com';
	// 		$config['smtp_pass']    = 'kartero';
	// 		$config['charset']    = 'utf-8';
	// 		$config['newline']    = "\r\n";
	// 		$config['mailtype'] = 'html'; // or html
	// 		$config['validation'] = TRUE; // bool whether to validate email or not


	// 		//$this->email->initialize($config); bug nat sending mail change to nextline 09042012
	// 		$this->load->library('email', $config);

	// 		switch (ENVIRONMENT)
	// 		{
	// 			case 'development':
	// 				$this->email->to('rencie.bautista@yahoo.com');
	// 			break;
	// 			case 'testing':
	// 				$this->email->to('ibautista@chasetech.com');
	// 			break;
	// 			case 'production':
	// 				$this->email->to('servicerequest@chasetech.com');
	// 			break;
	// 			default:
	// 				exit('The application environment is not set correctly.');
	// 		}

	// 		$this->email->from('servicerequest@chasetech.com','Service Request');
	// 		$this->email->subject($data['compnay']. " - Service Request Form");
	// 		$this->email->message($message);

	// 		if($files){
	// 			foreach ($files as $item) {
	// 				$this->email->attach($item['file']);
	// 			}
	// 		}

	// 		if(!$this->email->send())
	// 		{
	// 			$this->session->set_flashdata('msg','<span class="notification n-error">Mail sending error occured will submitting the service request form, please try again.</span>');
	// 			redirect('ctc/servicerequest');
	// 		}
	// 		else
	// 		{
	// 			$this->email->clear();
	// 			$this->email->to($data['email']);
	// 			$this->email->from('servicerequest@chasetech.com','Chasetech Service Request');
	// 			$this->email->subject('Service Request Form Confirmation');
	// 			$this->email->message($replymsg);
	// 			$this->email->send();
				
	// 			if($files){
	// 				$this->load->helper("file");
	// 				foreach ($files as $item) {
	// 					@unlink($item['file']);
	// 				}
	// 			}
				
	// 			$this->session->set_flashdata('msg','<span class="notification n-success">Thank you, '.
	// 										  $data['c_person'].' . Your service request form was submitted successfully!</span>');
	// 			redirect('ctc/servicerequest');
	// 		}
	// 		$this->email->print_debugger();
	// 	}
	// }

	public function salesinquiry(){
		redirect('contact/sales_inquiry');
	}
	
	public function servicerequest(){
		redirect('contact/service_request');
	}




	/* add to basket */
	public function addtoBasket($id = 0){
		if(!isset($_POST['productID'])){
			if(isset($_SESSION['cart'])){
				$cart = $_SESSION['cart'];
				$_SESSION['cart'] = $cart;
				if(count($cart)>0){
					foreach($cart as $row){
						echo '<li><a onclick="return false;" href="'.base_url('ctc/remove/'.$row['id']).'">
							<img id="'.$row['id'].'" src="'.base_url('images/delete.png').'">
							</a>'.$row['desc'].'</li>';
					}
				}else{
					echo '<li style="text-align: center;">No item in inquiry list.</li>';
				}
			}else{
				echo '<li style="text-align: center;">No item in inquiry list.</li>';

			}
		}else{
			$id = $this->input->post('productID');
			$item = array();
			$cart = array();
			$product = $this->M_ProductCat->getProduct($id);
			if(count($product)>0){
				$desc = $product['products'];

				if(isset($_SESSION['cart'])){
					$cart = $_SESSION['cart'];
				}

				$item['id'] = $id;
				$item['desc'] = $desc;

				if(count($cart)>0){
					if(!in_array($item,$cart)){
						$cart[] = $item;
					}
				}else{
					$cart[] = $item;
				}


			}else{
				$cart = $_SESSION['cart'];
			}
			$_SESSION['cart'] = $cart;
			if(count($cart)>0){
					foreach($cart as $row){
						echo '<li><a onclick="return false;" href="'.base_url('ctc/remove/'.$row['id']).'">
							<img id="'.$row['id'].'" src="'.base_url('images/delete.png').'">
							</a>'.$row['desc'].'</li>';
					}
				}else{
					echo '<li style="text-align: center;">No item in inquiry list.</li>';
				}
		}


	}

	public function remove(){
		if(isset($_POST['productID'])){
			$id = $this->input->post('productID');
			if(isset($_SESSION['cart'])){
				$cart = $_SESSION['cart'];

				//echo print_r($cart);

				foreach($cart as $subKey => $subArray){
					if($subArray['id'] == $id){
						unset($cart[$subKey]);
				   }
				}
				//echo print_r($cart);
				$_SESSION['cart'] = $cart;
				if(count($cart)>0){
					foreach($cart as $row){
						echo '<li><a onclick="return false;" href="'.base_url('ctc/remove/'.$row['id']).'">
							<img id="'.$row['id'].'" src="'.base_url('images/delete.png').'">
							</a>'.$row['desc'].'</li>';
					}
				}else{
					echo '<li style="text-align: center;">No item in inquiry list.</li>';
				}

			}
		}else{
			redirect();
		}

	}

	public function reset(){
		unset($_SESSION['cart']);
		echo '<li style="text-align: center;">No item in inquiry list.</li>';
	}

	// public function ip(){
	// 	echo $_SERVER['REMOTE_ADDR'];
	// 	echo GetHostByName($_SERVER['REMOTE_ADDR']);
	// 	echo $HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'];
	// }

	public function contact_us(){
		$data['styles'] = array('maincontent','products_contents','updates_newsletters','index_content','easySlides.default.min','small');
		$data['script'] = array('chrome','jquery-1.9.1','jquery.easyslides.min.v1.1','small');
		$data['prodCategory'] = $this->M_ProductCat->getAllProductCat();
		$data['indCategory'] = $this->M_IndustryCat->getAllIndustryCat();
		$data['whatwedo'] = $this->M_Whatwedo->getAllWhatwedo();
		$data['childpage'] = 'contactus';
		$this->load->view('masterpage',$data);
	}
	
	public function checkday(){
		print($this->_checkDay('temp4'));
	}

	private function _checkDay($template){
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
						
						return $this->load->view('temp/'.$template,$data, true);
					}else{
						//echo 'time: 9:00:00 - 12:00:00<br>'; //today service
						$data['saturday'] = $date;
						$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
						//$this->load->view('temp/temp4',$data);
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
						return $this->load->view('temp/'.$template,$data, true);
					}else{
						//echo 'time: 9:00:00 - 12:00:00<br>'; //today service
						$data['response_time'] = $date;
						$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
						//$this->load->view('temp/temp4',$data);
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
						return $this->load->view('temp/'.$template,$data, true);
					}else{
						if($time <= strtotime('10:01')){
							$start_time = date('H:i',$time );
							$endTime = date("H:i", strtotime("+3 hour"));

							$time = $start_time .' to '. $endTime;
							$data['saturday_today'] = date_format(date_create($date),'l, F j, Y') . ' from '.$time;;
							$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
							//$this->load->view('temp/temp4',$data);
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
				return $this->load->view('temp/'.$template,$data, true);
			}else{
				//echo 'no holiday<br>';
				//$tempdate = date('Y-m-d', strtotime("+1 day", strtotime($date)));
				$holidays = $this->_bestDay(date('Y-m-d', strtotime("+ 1 day", strtotime($date))));
				$data['response_time'] = $holidays['a_date'];
				$data['holidays'] = $holidays['holidays'];
				$data['date_created'] = date_format(date_create(date("Y-m-d His")),'l, F j, Y H:i:s a');
				//$this->load->view('temp/temp4',$data);
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
	
	public function agreement(){
		$data['styles'] = array('maincontent','products_contents','updates_newsletters','index_content','easySlides.default.min','small');
		$data['script'] = array('chrome','jquery-1.9.1','jquery.easyslides.min.v1.1','small');
		$data['prodCategory'] = $this->M_ProductCat->getAllProductCat();
		$data['indCategory'] = $this->M_IndustryCat->getAllIndustryCat();
		$data['whatwedo'] = $this->M_Whatwedo->getAllWhatwedo();
		$data['childpage'] = 'agreement';
		$this->load->view('masterpage',$data);
	}

	// /**
	//  * generate captcha
	//  */
	// private function _generateCaptcha(){
	// 	$vals = array('img_path' => './captcha/','img_url' =>  base_url(). '/captcha/');
	// 	$cap = create_captcha($vals);
	// 	$data1 = array('captcha_time' => $cap['time'],'ip_address' => $this->input->ip_address(),'word' => $cap['word']);
	// 	$query = $this->db->insert_string('captcha', $data1);
	// 	$this->db->query($query);
	// 	return $cap;
	// }

	// /**
	//  * check captcha
	//  */
	// public function captcha_check($str)
	// {
	// 	// First, delete old captchas
	// 	$expiration = time()-7200; // Two hour limit
	// 	$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);

	// 	// Then see if a captcha exists:
	// 	$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
	// 	$binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
	// 	$query = $this->db->query($sql, $binds);
	// 	$row = $query->row();
	// 	if ($row->count == 0)
	// 	{
	// 		$this->form_validation->set_message('captcha_check', 'Invalid word');
	// 		return FALSE;
	// 	}
	// 	else
	// 	{
	// 		return TRUE;
	// 	}
	// }

}
