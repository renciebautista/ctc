<h3 class="legend">Delete Product Category</h3>
<?php 
	$att = array('class' => 'form-horizontal');
	echo form_open_multipart('',$att);
	echo form_hidden('cat_id', $productcategory['id']);?>
	<div class="control-group">
		<label class="control-label" for="description">Product Category</label>
		<div class="controls">
			<input class="input-xxlarge" type="text" name="category" value="<?php echo set_value('category',$productcategory['productcategory']); ?>">
			<?php echo form_error('category'); ?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="description">Description</label>
		<div class="controls">
			<textarea  class="input-xxlarge" rows="6" name="desc"><?php echo set_value('desc',$productcategory['content']); ?></textarea>
			<?php echo form_error('desc'); ?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="description">Existing Photo</label>
		<div class="controls">
			<img src="<? echo base_url($productcategory['image']);?>" class="img-polaroid">
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button onclick="return confirm('Do you really want to delete this category?');" type="submit" class="btn btn-small btn-danger"><i class="icon-remove-sign icon-white"></i> Delete</button>
			<a class="btn btn-small" href="<?php echo base_url('admin/product_category'); ?>"><i class="icon-home"></i> Cancel</a>
		</div>
	</div>
<?php echo form_close(); ?>