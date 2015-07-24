<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>Chase Technologies Corporation </title>
	<meta name="keywords" content="pos software,retail pos,retail software,windows pos software,inventory control,point of sale,cash register software,retail systems,pos distributor,point of purchase,touch screens,point-of-sale,pos systems,cash register,pos terminals,kiosk,parking,barcode,printer barcode printer, scanner, barcode scanner,pdt,chase,winpos,foodpos" />
    <meta name="description" content="Provider of point-of-sale (POS) software, cash register software, and retail solutions. CTC products and services are excellent choice to put you AHEAD in the race of technology." />
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="<?php echo base_url();?>images/favicon.ico" />
	<link rel="stylesheet" href="<?php echo base_url("css/inquiry.css");?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url("css/main.css");?>" type="text/css" />
<?php
if(count($styles))
{
	foreach($styles as $css)
	{?>
	<link rel="stylesheet" href="<?php echo base_url();?>css/<?php echo $css;?>.css" type="text/css" />
	<?}
}

if(count($script))
{
	foreach($script as $js)
	{?>
	<script type="text/javascript" src="<?php echo base_url();?>jquery/<?php echo $js;?>.js"></script>	
	<?}
}
?>
<script type="text/javascript" src="<?php echo base_url('jquery/ctc.js');?>"></script>	

<body class="mainbackground">
	<div id="container">
		<div id="Wrapper">
			<div id="header">
				<img src="<?php echo base_url();?>images/site/banner.png" />	
			</div>
			
			<div id="navigation">
				<?php $this->load->view('navigation');?>
				<script type="text/javascript">cssdropdown.startchrome("chromemenu")</script>
			</div>
			
			<div id="leftPanel">
				<?php $this->load->view($childpage);?>
			</div>
			
			<div id="rightPanel">
				<div>
					<h2 class="c_con"><a href="<?php echo base_url('contact'); ?>">Contact Us</a></h2>
				</div>
				<div id="basket" >
					<h2><b>Inquiry List</b></h2>
					<ul></ul>
				</div>
				<div id="reset">
					<div style="width:50%; float:left;">
						<a class="clear" href="#" onClick="javascript:return false;">Clear Cart</a>
					</div>
					<div style="width:50%;float:left;">
						<a class="send" href="<?php echo base_url('ctc/salesinquiry');?>">Inquiry Cart</a>
					</div>
				</div>
				<div>
				<object
					classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
					codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,42,0"
					id="movie"
					width="235" height="383"
					wmode="transparent"
				  >
					<param name="wmode" value="transparent">
					<param name="movie" value="movie.swf">
					<param name="bgcolor" value="#FFFFFF">
					<param name="quality" value="high">
					<param name="seamlesstabbing" value="false">
					<param name="allowscriptaccess" value="www.chasetech.com">
					<embed
					  type="application/x-shockwave-flash"
					  pluginspage="http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"
					  name="Movie1"
					  width="235" height="380"
					  src="<?php echo base_url('images/movie.swf');?>"
					  bgcolor="#FFFFFF"
					  quality="high"
					  seamlesstabbing="false"
					  allowscriptaccess="www.chasetech.com"
					  
					>
					  <noembed>
					  </noembed>
					</embed>
				  </object>
				</div>
			</div>
			<div id="footer">
				<?php $this->load->view('footer');?>
			</div>
		</div>
	</div>
</body>
</html>

