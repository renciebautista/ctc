<?php echo $this->session->flashdata('message');?>
<h3 class="legend">User List</h3>
<div class="input-append">
	<?php $attribute['method'] = 'get';
			 echo form_open('',$attribute);?>
    <input class="span4" id="s" name="s" value="<?php echo $search;?>" type="text" placeholder="Search">
    <button class="btn " type="submit"><i class="icon-search"></i> Search</button>
    <?php echo form_close(); ?>
</div>

<div class="left">
	<a class="btn btn-success"href="<?php echo base_url('admin/users/add'); ?>"><i class="icon-plus icon-white"></i> New User</a>
</div>

<table class="table ">
	<thead>
		<tr>
			<th>Username</th>
			<th>Display Name</th>
			<th>Role</th>
			<th>Active</th>
			<th style="width:18%; text-align:center;">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php if (count($users)>0): ?>
		<?php foreach ($users as $row):?>
		<tr>
			<td><?php echo $row['username'];?></td>
			<td><?php echo $row['display_name'];?></td>
			<td><?php echo $row['roles'];?></td>
			<td><?php echo (($row['active'] == 'ON')? 'Active':'Suspended');?></td>
			<td style="width:18%; text-align:center;">
				<a class="btn btn-small btn-info"href="<?php echo base_url('admin/users/edit/'.$row['id']);?>"><i class="icon-edit icon-white"></i> Edit</a>
			</td>
		</tr>
		<?php endforeach; ?>
	<?php else: ?>
		<tr>
			<td colspan="5">No record found!</td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>