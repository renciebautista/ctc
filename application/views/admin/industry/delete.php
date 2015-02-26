<h3 class="legend">Delete Industry</h3>
<?php
	$att = array('class' => 'form-horizontal');
echo form_open_multipart('',$att);
echo form_hidden('industry_id', $industry['id']);?>
<div class="control-group">
	<label class="control-label" for="description">Industry Category</label>
	<div class="controls">
		<select name="category">
			<option value="0">Select Category</option>
			<?php foreach ($category as $row): ?>
			<option <?php echo (($industry['industrycategory'] == $row['id'])? 'selected="selected"':''); ?> value="<?php echo $row['id']; ?>"><?php echo $row['industrycategory']; ?></option>
			<?php endforeach; ?>
		</select>
		<?php echo form_error('category'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Industry</label>
	<div class="controls">
		<input class="input-xxlarge" type="text" name="industry" value="<?php echo set_value('industry',$industry['industry']); ?>">
		<?php echo form_error('industry'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Description</label>
	<div class="controls">
		<textarea  class="input-xxlarge" rows="6" name="desc"><?php echo set_value('desc',$industry['icontent']); ?></textarea>
		<?php echo form_error('desc'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Summary</label>
	<div class="controls">
		<textarea  class="input-xxlarge" rows="6" name="summary"><?php echo set_value('summary',$industry['content']); ?></textarea>
		<?php echo form_error('summary'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Benefits</label>
	<span class="noti">add | on the begining of every benefit</span>
	<div class="controls">
		<textarea  class="input-xxlarge" rows="6" name="benefits"><?php echo set_value('benefits',$industry['benefits']); ?></textarea>
		<?php echo form_error('benefits'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Existing Photo</label>
	<div class="controls">
		<img src="<? echo base_url($industry['image']);?>" class="img-polaroid">
	</div>
</div>
<div class="control-group">
	<div class="controls">
		<button onclick="return confirm('Do you really want to delete this industry?');" type="submit" class="btn btn-small btn-danger"><i class="icon-remove-sign icon-white"></i> Delete</button>
		<a class="btn btn-small" href="<?php echo base_url('admin/industry'); ?>"><i class="icon-home"></i> Cancel</a>
	</div>
</div>
<?php echo form_close(); ?>