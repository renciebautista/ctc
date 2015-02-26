<?php echo $this->session->flashdata('message');?>
<h3 class="legend">Edit Pending Filter</h3>
<?php 
	$att = array('class' => 'form-horizontal');
	echo form_open('',$att);
	echo form_hidden('filter_id', $filter['filter_id']);;?>
	<div class="control-group">
		<label class="control-label" for="description">Contact No.</label>
		<div class="controls">
			<input class="input-xxlarge" type="text" id="contact" name="contact" value="<?php echo set_value('contact',$filter['contact_no']); ?>">
			<?php echo form_error('contact'); ?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="description">Notes</label>
		<div class="controls">
			<textarea  class="input-xxlarge" rows="10" id="notes" name="notes"><?php echo set_value('notes',$filter['notes']); ?></textarea>
			<?php echo form_error('notes'); ?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="description">Retries</label>
		<div class="controls">
			<input class="span2" type="text" id="retry" name="retry" value="<?php echo set_value('retry',$filter['retry']); ?>">
			<?php echo form_error('retry'); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-small btn-success"><i class=" icon-ok icon-white"></i> Update</button>
			<a class="btn btn-small" href="<?php echo base_url('admin/pending'); ?>"><i class="icon-home"></i> Cancel</a>
		</div>
	</div>
<?php echo form_close(); ?>
