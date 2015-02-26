<h3 class="legend">New User</h3>
<?php
	$att = array('class' => 'form-horizontal');
echo form_open('',$att);?>
<div class="control-group">
	<label class="control-label" for="description">Username</label>
	<div class="controls">
		<input class="input-xxlarge" type="text" name="username" value="<?php echo set_value('username'); ?>">
		<?php echo form_error('username'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Display Name</label>
	<div class="controls">
		<input class="input-xxlarge" type="text" name="d_name" value="<?php echo set_value('d_name'); ?>">
		<?php echo form_error('d_name'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Password</label>
	<div class="controls">
		<input class="input-xxlarge" type="password" name="password">
		<?php echo form_error('password'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Confirm Password</label>
	<div class="controls">
		<input class="input-xxlarge" type="password" name="c_password">
		<?php echo form_error('c_password'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Role</label>
	<div class="controls">
		<select name="role">
			<option value="0">Select Role</option>
			<?php foreach ($role as $row): ?>
			<option <?php echo set_select('role', $row['role_id']); ?>  value="<?php echo $row['role_id']; ?>"><?php echo $row['roles']; ?></option>
			<?php endforeach; ?>
		</select>
		<?php echo form_error('role'); ?>
	</div>
</div>
<div class="control-group">
	<div class="controls">
		<button type="submit" class="btn btn-small btn-success"><i class=" icon-ok icon-white"></i> Submit</button>
		<a class="btn btn-small" href="<?php echo base_url('admin/users'); ?>"><i class="icon-home"></i> Cancel</a>
	</div>
</div>
<?php echo form_close(); ?>