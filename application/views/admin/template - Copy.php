<?php
$class = strtolower($this->uri->segment(2));
//$site_name = substr(base_url(),7,-1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
		<title>Control Panel</title>
		<link rel="stylesheet" type="text/css"  href="<?php echo base_url('css/admin.css');?>" />
		<link rel="stylesheet" type="text/css"  href="<?php echo base_url('css/redmond/jquery-ui-1.8.22.custom.css');?>" />
		<script type="text/javascript" src="<?php echo base_url('jquery/jquery-1.8.3.min.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('jquery/jquery-ui-1.8.22.custom.min.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('jquery/jquery.maskedinput-1.2.2.js');?>"></script>
	</head>
	<body>
		<div class="wrapper">
			<p class="txt_right">Logged in as <strong><?php echo DISPLAYNAME;?></strong>  <span class="v_line"> | </span> <a href="<?php echo base_url('admin/auth/logout');?>"> Logout</a></p>
			<!-- Navigation -->
			<div class="navigation">
				<ul>
					<li><a href="<?php echo base_url('admin/dashboard');?>" <?php echo 'class="'. (($this->uri->segment(2) == 'dashboard')? 'active':'') .'"'?>>HOME</a></li>
					<li><a href="<?php echo base_url('admin/product_category');?>" <?php echo 'class="'. (($this->uri->segment(2) == 'product_category')? 'active':'') .'"'?>>PRODUCT CATEGORY</a></li>
					<li><a href="<?php echo base_url('admin/product');?>" <?php echo 'class="'. (($this->uri->segment(2) == 'product')? 'active':'') .'"'?>>PRODUCTS</a></li>
					<li><a href="<?php echo base_url('admin/industry_category');?>" <?php echo 'class="'. (($this->uri->segment(2) == 'industry_category')? 'active':'') .'"'?>>INDUSTRY CATEGORY</a></li>
					<li><a href="<?php echo base_url('admin/industry');?>" <?php echo 'class="'. (($this->uri->segment(2) == 'industry')? 'active':'') .'"'?>>INDUSTRIES</a></li>
					<li><a href="<?php echo base_url('admin/whatwedo');?>" <?php echo 'class="'. (($this->uri->segment(2) == 'whatwedo')? 'active':'') .'"'?>>WHAT WE DO</a></li>
					<li><a href="<?php echo base_url('admin/careers');?>" <?php echo 'class="'. (($this->uri->segment(2) == 'careers')? 'active':'') .'"'?>>CAREERS</a></li>
					<li><a href="<?php echo base_url('admin/holidays');?>" <?php echo 'class="'. (($this->uri->segment(2) == 'holidays')? 'active':'') .'"'?>>HOLIDAYS</a></li>
					<li><a href="<?php echo base_url('admin/users');?>" <?php echo 'class="'. (($this->uri->segment(2) == 'users')? 'active':'') .'"'?>>USERS</a></li>
					<li><a href="<?php echo base_url('admin/settings');?>" <?php echo 'class="'. (($this->uri->segment(2) == 'settings')? 'active':'') .'"'?>>SETTINGS</a></li>
					
				</ul>
			</div>
			<div class="clear"></div>
			<div class="content">
				<?php
					if(stristr($view, '/') === FALSE)
					{
						//'/' not found in string, load usual view
						$this->load->view("admin/$class/$view");
					}
					else
					{
						//'/' FOUND in string, load view w/o class name (used for categories)
						$this->load->view("admin/$view");
					}
				?>
			</div>
		</div>
	</body>
</html>