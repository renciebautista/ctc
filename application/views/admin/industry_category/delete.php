<h3 class="legend">Delete Industry Category</h3>
<?php 
	$att = array('class' => 'form-horizontal');
	echo form_open_multipart('',$att);
	echo form_hidden('industrycat_id', $industrycategory['id']);?>
	<div class="control-group">
		<label class="control-label" for="description">Industry Category</label>
		<div class="controls">
			<input class="input-xxlarge" type="text" name="category" value="<?php echo set_value('category',$industrycategory['industrycategory']); ?>">
			<?php echo form_error('category'); ?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="description">Description</label>
		<div class="controls">
			<textarea  class="input-xxlarge" rows="6" name="desc"><?php echo set_value('desc',$industrycategory['content']); ?></textarea>
			<?php echo form_error('desc'); ?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="description">Summary</label>
		<div class="controls">
			<textarea  class="input-xxlarge" rows="6" name="summary"><?php echo set_value('summary',$industrycategory['contentheader']); ?></textarea>
			<?php echo form_error('summary'); ?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="description">Existing Photo</label>
		<div class="controls">
			<img src="<? echo base_url($industrycategory['image']);?>" class="img-polaroid">
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button onclick="return confirm('Do you really want to delete this category?');" type="submit" class="btn btn-small btn-danger"><i class="icon-remove-sign icon-white"></i> Delete</button>
			<a class="btn btn-small" href="<?php echo base_url('admin/industry_category'); ?>"><i class="icon-home"></i> Cancel</a>
		</div>
	</div>
<?php echo form_close(); ?>
