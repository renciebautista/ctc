<h3 class="legend">Edit Product Category</h3>
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
		<label class="control-label" for="description">Update Photo</label>
		<div class="controls">
			<input type="file" id="file" name="image" >
			<div class="dummyfile">
	      		<input id="filename" type="text" class="input disabled" name="filename" readonly>
	      		<a id="fileselectbutton" class="btn">Choose...</a>
	      		<?php echo form_error('image'); ?>
	      	</div>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-small btn-success"><i class=" icon-ok icon-white"></i> Submit</button>
			<a class="btn btn-small" href="<?php echo base_url('admin/product_category'); ?>"><i class="icon-home"></i> Cancel</a>
		</div>
	</div>
<?php echo form_close(); ?>