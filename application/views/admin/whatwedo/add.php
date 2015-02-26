<h3 class="legend">New What We Do</h3>
<?php 
	$att = array('class' => 'form-horizontal');
	echo form_open_multipart('',$att);?>
	<div class="control-group">
		<label class="control-label" for="description">What We Do</label>
		<div class="controls">
			<input class="input-xxlarge" type="text" name="whatwedo" value="<?php echo set_value('whatwedo'); ?>">
			<?php echo form_error('whatwedo'); ?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="description">Description</label>
		<div class="controls">
			<textarea  class="input-xxlarge" rows="6" name="desc"><?php echo set_value('desc'); ?></textarea>
			<?php echo form_error('desc'); ?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="description">Features</label>
		<span class="noti">add | on the begining of every feature</span>
		<div class="controls">
			<textarea  class="input-xxlarge" rows="6" name="features"><?php echo set_value('features'); ?></textarea>
			<?php echo form_error('features'); ?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="description">What We Do Photo</label>
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
			<a class="btn btn-small" href="<?php echo base_url('admin/whatwedo'); ?>"><i class="icon-home"></i> Cancel</a>
		</div>
	</div>
<?php echo form_close(); ?>

