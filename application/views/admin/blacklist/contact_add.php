<?php echo $this->session->flashdata('message');?>
<h3 class="legend">New Contact No.</h3>
<?php 
	$att = array('class' => 'form-horizontal');
	echo form_open('',$att);?>
	<div class="control-group">
		<label class="control-label" for="description">Contact No.</label>
		<div class="controls">
			<input class="input-xxlarge" type="text" id="contact" name="contact" value="<?php echo set_value('contact'); ?>">
			<?php echo form_error('contact'); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-small btn-success"><i class=" icon-ok icon-white"></i> Submit</button>
			<a class="btn btn-small" href="<?php echo base_url('admin/blacklist'); ?>"><i class="icon-home"></i> Cancel</a>
		</div>
	</div>
<?php echo form_close(); ?>
