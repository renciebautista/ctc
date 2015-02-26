<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Ninja Admin</title>
<link rel="stylesheet" type="text/css"  href="<?php echo base_url('css/admin.css');?>" />
</head>

<body>

	<div class="wrapper">
	
		<h1 class="logo">NINJA ADMIN</h1>
		<p class="txt_right">Logged in as <strong>Ninja Admin </strong>  <span class="v_line"> | </span> <a href="#"> Logout</a></p>
	
	<!-- Navigation -->
	
		<div class="navigation">
				<ul>
					<li><a href="#">WRITE</a></li>
					<li><a href="#" class="active">MANAGE</a></li>
					<li><a href="#l">SETTINGS</a></li>
					<li><a href="#">USERS</a></li>
				</ul>
			
				<div id="searchform">
					<form method="get" action="">
					<input type="text" value="find something good..." class="search_box" name="search" onclick="this.value='';"  />
					<input type="submit" class="search_btn" value="SEARCH" />
					</form>
				</div>
			
		</div>
		
		<div class="clear"></div>
	
	
		<div class="content">
		
	<!-- Intro -->
		
				<div class="in author">
					<h2>Lets Enter The Dragon</h2>
					<p>Author <a href="#">Bruce Lee</a> | created 10-14-08</p>
				</div>
			
				<div class="line"></div>
				
	<!-- Checks -->
	
			<div class="check_main">
					
				<div class="check">
					<div class="good"><img src="images/check.gif" alt="check" class="icon" />Nice work <strong>Ninja Admin!</strong></div>
				</div>
				<div class="check">
					<div class="bad"><img src="images/x.gif" alt="check" class="icon" />You need more training, please <a href="#">try again</a>.</div>
				</div>
				
			</div>
			
	<!-- Form -->
			
				<div class="in forms">
					<form id="form1" name="form1" method="post" action="">
	
      				<p><strong>TITLE</strong><br />
					<input type="text" name="name" class="box" /></p>
					 
	  				<p><strong>AUTHOR</strong><br />
							<select name="date_end" class="box2" >
        					<option selected="selected"> Bruce Lee</option>
							<option>Jackie Chan</option>
        					<option>John Claude Van Damme</option>
        					<option>Ben Johnson</option>
					  </select></p>
					
	  				<p><strong>STORY</strong><br />
					<textarea name="mes" rows="5" cols="30" class="box" ></textarea></p> 

					<p><input name="submit" type="submit" id="submit"  tabindex="5" class="com_btn" value="UPDATE" /></p>
					</form>
			
				</div>
				
				
				
	
	
	<div class="in">			
		<table width="850" border="0" cellspacing="0" cellpadding="10" class="table_main" >
		  <tr style="background-color:#d9d8d8; font-size:14px;">
			<td width="179"><strong>USER</strong></td>
			<td width="184"><strong>EMAIL</strong></td>
			<td width="273"><strong>SOMETHING</strong></td>
			<td width="132"><strong>DO IT</strong></td>
		  </tr>
		  <tr class="gray">
			<td>Bruce Lee </td>
			<td><a href="#">bruce@kungfu.com</a></td>
			<td>Loriem ipsum dolor sit amet </td>
			<td><a href="#">EDIT  </a><span class="v_line">| </span> <a href="#" class="delete">DELETE </a></td>
		  </tr>
		  <tr>
			<td>Jackie Chan</td>
			<td><a href="#">thechan@yahoo.com</a></td>
			<td>Loriem ipsum dolor sit amet </td>
			<td><a href="#">EDIT  </a><span class="v_line">| </span> <a href="#" class="delete">DELETE </a></td>
		  </tr>
		  <tr class="gray">
			<td>John Claude Van Damme</td>
			<td><a href="#">vandamme@gmail.com</a></td>
			<td>Loriem ipsum dolor sit amet </td>
			<td><a href="#">EDIT  </a><span class="v_line">| </span> <a href="#" class="delete">DELETE </a></td>
		  </tr>
		   <tr>
			<td>Ben Johnson </td>
			<td><a href="#">ben@kungu.com</a></td>
			<td>Loriem ipsum dolor sit amet </td>
			<td><a href="#">EDIT  </a><span class="v_line">| </span> <a href="#" class="delete">DELETE </a></td>
		  </tr>
		</table>
						
	</div>
		
		</div>
		
		
		<p class="footer"><a href="#">ADVANCED  SEARCH</a> <span class="v_line"> |</span> <a href="#">LOGOUT</a></p>
		
		
	</div>
</body>
</html>
