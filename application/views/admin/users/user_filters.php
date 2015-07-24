<?php echo $this->session->flashdata('message');?>
<h3 class="legend">User Filters</h3>

 <?php echo form_open('');
    echo form_hidden('user_id',$user_id);;?>
    <div class="control-group">
	<div class="controls">
		<button type="submit" class="btn btn-small btn-success"><i class=" icon-ok icon-white"></i> Update</button>
		<a class="btn btn-small" href="<?php echo base_url('admin/users'); ?>"><i class="icon-home"></i> Back</a>
	</div>
</div>
<table class="table ">
	<thead>
		<tr>
			<th style="width:20px;" scope="col"></th>
			<th scope="col">Sub Group</th>
		</tr>
	</thead>
	<tbody>
	<?php if (count($requesttypes)>0): ?>
		<?php foreach ($requesttypes as $row):?>
		<tr>
        	<td style="width:20px; text-align:center;">
				<input type="checkbox" value="<?php echo $row['id'];?>" name="filter[]" <?php echo ((in_array($row['id'],$selected)) ? 'checked="checked"':'');?>/>
			</td>
            <td >
                <?php echo $row['sub_group'];?>
            </td>
		</tr>
		<?php endforeach; ?>
	<?php else: ?>
		<tr>
			<td colspan="2">No record found!</td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>

<?php echo form_close(); ?>