<?php echo $this->session->flashdata('message');?>
<h3 class="legend">Delete Contact Group</h3>
<?php 
	$att = array('class' => 'form-horizontal');
	echo form_open_multipart('',$att);
	echo form_hidden('group_id', $group['id']);?>
	<div class="control-group">
		<label class="control-label" for="description">Group Name</label>
		<div class="controls">
			<input class="input-xxlarge" type="text" name="group" value="<?php echo set_value('group',$group['group']); ?>">
			<?php echo form_error('group'); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button onclick="return confirm('Do you really want to delete this group?');" type="submit" class="btn btn-small btn-danger"><i class="icon-remove-sign icon-white"></i> Delete</button>
			<a class="btn btn-small" href="<?php echo base_url('admin/group'); ?>"><i class="icon-home"></i> Cancel</a>
		</div>
	</div>
<?php echo form_close(); ?>
