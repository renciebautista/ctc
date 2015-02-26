<h3 class="legend">Delete What We Do</h3>
<?php
	$att = array('class' => 'form-horizontal');
echo form_open_multipart('',$att);
echo form_hidden('w_id', $whatwedo['id']);?>
<div class="control-group">
	<label class="control-label" for="description">What We Do</label>
	<div class="controls">
		<input class="input-xxlarge" type="text" name="whatwedo" value="<?php echo set_value('whatwedo',$whatwedo['whatwedo']); ?>">
		<?php echo form_error('whatwedo'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Description</label>
	<div class="controls">
		<textarea  class="input-xxlarge" rows="6" name="desc"><?php echo set_value('desc',$whatwedo['content']); ?></textarea>
		<?php echo form_error('desc'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Features</label>
	<span class="noti">add | on the begining of every feature</span>
	<div class="controls">
		<textarea  class="input-xxlarge" rows="6" name="features"><?php echo set_value('features',$whatwedo['feature']); ?></textarea>
		<?php echo form_error('features'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Existing Photo</label>
	<div class="controls">
		<img src="<? echo base_url($whatwedo['image']);?>" class="img-polaroid">
	</div>
</div>
<div class="control-group">
	<div class="controls">
		<button onclick="return confirm('Do you really want to delete this record?');" type="submit" class="btn btn-small btn-danger"><i class="icon-remove-sign icon-white"></i> Delete</button>
		<a class="btn btn-small" href="<?php echo base_url('admin/whatwedo'); ?>"><i class="icon-home"></i> Cancel</a>
	</div>
</div>
