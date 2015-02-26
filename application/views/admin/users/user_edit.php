<h3 class="legend">Edit User</h3>
<?php
	$att = array('class' => 'form-horizontal');
	echo form_open('',$att);
	echo form_hidden('user_id', $user['id']);?>
<div class="control-group">
	<label class="control-label" for="description">Username</label>
	<div class="controls">
		<p><?php echo $user['username']; ?></p>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Display Name</label>
	<div class="controls">
		<input class="input-xxlarge" type="text" name="d_name" value="<?php echo set_value('d_name',$user['display_name']); ?>">
		<?php echo form_error('d_name'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Role</label>
	<div class="controls">
		<select name="role">
			<option value="0">Select Role</option>
			<?php foreach ($role as $row): ?>
			<option <?php echo (($user['role_id'] == $row['role_id'])? 'selected="selected"':''); ?> <?php echo set_select('role', $row['role_id']); ?>  value="<?php echo $row['role_id']; ?>"><?php echo $row['roles']; ?></option>
			<?php endforeach; ?>
		</select>
		<?php echo form_error('role'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Active</label>
	<div class="controls">
		<input value ="1" name="active" type="checkbox" <?php echo (($user['active'] == 'ON')? 'checked="checked"':''); ?>>
	</div>
</div>
<div class="control-group">
	<div class="controls">
		<button type="submit" class="btn btn-small btn-success"><i class=" icon-ok icon-white"></i> Submit</button>
		<a class="btn btn-small" href="<?php echo base_url('admin/users'); ?>"><i class="icon-home"></i> Cancel</a>
	</div>
</div>
<?php echo form_close(); ?>