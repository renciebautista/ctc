
	<?php echo $this->session->flashdata('message');?>
<div class="in">

	<div id="searchform1">
		<div class="add" style="float: none;">
			<a  href="<?php echo base_url('admin/users/add');?>">ADD USER</a>
		</div>
	</div>
	<div style=" margin-top: 20px;">
	<table width="850" border="0" cellspacing="0" cellpadding="10" class="table_main" >
		<tr style="background-color:#d9d8d8; font-size:14px;">
			<td width="35%"><strong>DISPLAY NAME</strong></td>
			<td width="30%"><strong>ROLE</strong></td>
			<td width="15%" style="text-align:center;"><strong>ACTION</strong></td>
		</tr>
		  <?php
		  $count = 0;
		  if(count($users) > 0){
			$count++;
				foreach($users as $row)
				{?>
					<tr>
						<td><?php echo $row['username'];?></td>
						<td><?php echo $row['roles'];?></td>
						<td style="text-align:center;">
							<a onclick="return confirm('Do you really want to delete?');" href="<?php echo base_url();?>" class="delete">EDIT </a>
							<a onclick="return confirm('Do you really want to delete?');" href="<?php echo base_url();?>" class="delete">DELETE </a>
						</td>
					  </tr>	
				<?}
		  }
		  ?>
		  
		  
	</table>
	</div>
	<?php
		if($count<1)
		echo '<p style>No record found.<br />';
		?>
						
</div>