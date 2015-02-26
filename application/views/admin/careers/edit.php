<h3 class="legend">Edit Career</h3>
<?php
	$att = array('class' => 'form-horizontal');
	echo form_open_multipart('',$att);
echo form_hidden('career_id', $career['id']);?>
<div class="control-group">
	<label class="control-label" for="description">Job Title</label>
	<div class="controls">
		<input class="input-xxlarge" type="text" name="title" value="<?php echo set_value('title',$career['title']); ?>">
		<?php echo form_error('title'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Job Summary</label>
	<div class="controls">
		<textarea  class="input-xxlarge" rows="6" name="summary"><?php echo set_value('summary',$career['content']); ?></textarea>
		<?php echo form_error('summary'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Job Responsibilities</label>
	<span class="noti">add - on the begining of every responsibility</span>
	<div class="controls">
		<textarea  class="input-xxlarge" rows="6" name="responsibilities"><?php echo set_value('responsibilities',$career['responsibilities']); ?></textarea>
		<?php echo form_error('responsibilities'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Job Qualifications</label>
	<span class="noti">add - on the begining of every qualification</span>
	<div class="controls">
		<textarea  class="input-xxlarge" rows="6" name="qualification"><?php echo set_value('qualification',$career['requirements']); ?></textarea>
		<?php echo form_error('qualification'); ?>
	</div>
</div>
<div class="control-group">
	<div class="controls">
		<button type="submit" class="btn btn-small btn-success"><i class=" icon-ok icon-white"></i> Submit</button>
		<a class="btn btn-small" href="<?php echo base_url('admin/careers'); ?>"><i class="icon-home"></i> Cancel</a>
	</div>
</div>
<?php echo form_close(); ?>