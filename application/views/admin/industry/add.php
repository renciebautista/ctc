<h3 class="legend">New Industry</h3>
<?php
	$att = array('class' => 'form-horizontal');
echo form_open_multipart('',$att);?>
<div class="control-group">
	<label class="control-label" for="description">Industry Category</label>
	<div class="controls">
		<select name="category">
			<option value="0">Select Category</option>
			<?php foreach ($category as $row): ?>
			<option <?php echo set_select('category', $row['id']); ?>  value="<?php echo $row['id']; ?>"><?php echo $row['industrycategory']; ?></option>
			<?php endforeach; ?>
		</select>
		<?php echo form_error('category'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Industry</label>
	<div class="controls">
		<input class="input-xxlarge" type="text" name="industry" value="<?php echo set_value('industry'); ?>">
		<?php echo form_error('industry'); ?>
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
	<label class="control-label" for="description">Summary</label>
	<div class="controls">
		<textarea  class="input-xxlarge" rows="6" name="summary"><?php echo set_value('summary'); ?></textarea>
		<?php echo form_error('summary'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Benefits</label>
	<span class="noti">add | on the begining of every benefit</span>
	<div class="controls">
		<textarea  class="input-xxlarge" rows="6" name="benefits"><?php echo set_value('benefits'); ?></textarea>
		<?php echo form_error('benefits'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Industry Photo</label>
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
		<a class="btn btn-small" href="<?php echo base_url('admin/industry'); ?>"><i class="icon-home"></i> Cancel</a>
	</div>
</div>
<?php echo form_close(); ?>