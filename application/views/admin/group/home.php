<?php echo $this->session->flashdata('message');?>
<h3 class="legend">Contact Group</h3>
<div class="input-append">
	<?php $attribute['method'] = 'get';
			 echo form_open('',$attribute);?>
    <input class="span4" id="s" name="s" value="<?php echo $search;?>" type="text" placeholder="Search">
    <button class="btn " type="submit"><i class="icon-search"></i> Search</button>
    <?php echo form_close(); ?>
</div>

<div class="left">
	<a class="btn btn-success"href="<?php echo base_url('admin/group/add'); ?>"><i class="icon-plus icon-white"></i> New Group</a>
</div>

<table class="table ">
	<thead>
		<tr>
			<th>Group</th>
			<th style="width:18%; text-align:center;">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php if (count($group)>0): ?>
		<?php foreach ($group as $row):?>
		<tr>
			<td><?php echo $row['group'];?></td>
			<td style="width:18%; text-align:center;">
				<a class="btn btn-small btn-info"href="<?php echo base_url('admin/group/edit/'.$row['id']);?>"><i class="icon-edit icon-white"></i> Edit</a>
				<a class="btn btn-small btn-danger"href="<?php echo base_url('admin/group/delete/'.$row['id']); ?>"><i class="icon-remove-sign icon-white"></i> Delete</a>
			</td>
		</tr>
		<?php endforeach; ?>
	<?php else: ?>
		<tr>
			<td colspan="3">No record found!</td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>