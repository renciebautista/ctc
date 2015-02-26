
<div class="in forms">
	<?php echo form_open_multipart('admin/users/add');?>
		<p><strong>USER ROLE </strong><?php echo form_error('category'); ?><br />
		
				<select name="role" class="box2" >
					<option value="0">Select Role</option>
					<?php foreach ($role as $row)
					{
						echo '<option '. set_select('role', $row['id']) .'  value="'.$row['id'].'">'.$row['roles'].'</option>';
					}
					?>
					
				</select></p>
		

		<p><strong>DISPLAY NAME </strong><?php echo form_error('product'); ?><br />
		<input type="text" name="product" class="box" value="<?php echo set_value('product'); ?>" /></p>
		
		<p><strong>USERNAME </strong><?php echo form_error('product'); ?><br />
		<input type="text" name="product" class="box" value="<?php echo set_value('product'); ?>" /></p>
		
			<p><strong>PASSWORD </strong><?php echo form_error('product'); ?><br />
		<input type="password" name="product" class="box" value="<?php echo set_value('product'); ?>" /></p>
		
			<p><strong>RE-ENTER PASSWORD </strong><?php echo form_error('product'); ?><br />
		<input type="password" name="product" class="box" value="<?php echo set_value('product'); ?>" /></p>
		
		
		<div style="clear:both;"></div>
				
		<p><input name="submit" type="submit" id="submit"  tabindex="5" class="com_btn" value="SUBMIT" />
			<a id="_back" class="back"  href="<?php echo base_url('admin/users');?>">CANCEL</a>
        </p>
	<?php echo form_close();?>
			
</div>