<?php echo $this->session->flashdata('message');?>
<h3 class="legend">Edit Sub Group</h3>
<?php
	$att = array('class' => 'form-horizontal');
echo form_open_multipart('',$att);
echo form_hidden('sub_group_id', $subgroup['id']);?>
<div class="control-group">
	<label class="control-label" for="description">Group Name</label>
	<div class="controls">
		<select name="group">
			<option value="0">Select Group</option>
			<?php foreach ($group as $row): ?>
			<option <?php echo (($subgroup['group_id'] == $row['id'])? 'selected="selected"':''); ?>  value="<?php echo $row['id']; ?>"><?php echo $row['group']; ?></option>
			<?php endforeach; ?>
		</select>
		<?php echo form_error('group'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Sub Group Name</label>
	<div class="controls">
		<input class="input-xxlarge" type="text" name="subgroup" value="<?php echo set_value('subgroup',$subgroup['sub_group']); ?>">
		<?php echo form_error('subgroup'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="link">Link</label>
	<div class="controls">
		<input class="input-xxlarge" type="text" name="link" value="<?php echo set_value('link',$subgroup['slug']); ?>">
		<?php echo form_error('link'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Send To</label>
	<div class="controls">
		<input class="input-xxlarge" type="text" name="sendto" value="<?php echo set_value('sendto',$subgroup['send_to']); ?>">
		<?php echo form_error('sendto'); ?>
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="description">Cc To:</label>
	<div class="controls">
		<input class="input-xxlarge" type="text" name="Cc" style="height: 25px;" value="<?php echo set_value('Cc',$subgroup['cc']); ?>">
		<?php echo form_error('Cc'); ?>
	</div>
</div>
<div class="control-group">
	<div class="controls">
		<button type="submit" class="btn btn-small btn-success"><i class=" icon-ok icon-white"></i> Submit</button>
		<a class="btn btn-small" href="<?php echo base_url('admin/subgroup'); ?>"><i class="icon-home"></i> Cancel</a>
	</div>
</div>
<?php echo form_close(); ?>
