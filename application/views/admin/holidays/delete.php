<?php echo $this->session->flashdata('message');?>
<h3 class="legend">Delete Holiday</h3>
<?php 
	$att = array('class' => 'form-horizontal');
	echo form_open_multipart('',$att);
	echo form_hidden('hid', $holiday['id']);?>
	<div class="control-group">
		<label class="control-label" for="description">Holiday Description</label>
		<div class="controls">
			<input class="input-xxlarge" type="text" name="desc" value="<?php echo set_value('desc',$holiday['desc']); ?>">
			<?php echo form_error('desc'); ?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="description">Holiday Date</label>
		<div class="controls">
			<input class="span2 datenow" type="text" name="date" value="<?php echo set_value('date',date_format(date_create($holiday['date']),'m/d/Y')); ?>">
			<?php echo form_error('date'); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button onclick="return confirm('Do you really want to delete this holiday?');" type="submit" class="btn btn-small btn-danger"><i class="icon-remove-sign icon-white"></i> Delete</button>
			<a class="btn btn-small" href="<?php echo base_url('admin/holidays'); ?>"><i class="icon-home"></i> Cancel</a>
		</div>
	</div>
<?php echo form_close(); ?>
