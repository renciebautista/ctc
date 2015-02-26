<?php echo $this->session->flashdata('message');?>
<h3 class="legend">Contact Sub Group</h3>
<div class="input-append">
	<?php $attribute['method'] = 'get';
			 echo form_open('',$attribute);?>
	<div class="input-prepend space">
		  <span class="add-on">Filter By</span>
		<select class="selection" name="category">
			<option value="0">All Group</option>
		<?php foreach ($group as $row): ?>
			<option value="<?php echo $row['id'] ?>" <?php echo (($row['id'] == $id)? 'selected="selected"':''); ?>><?php echo $row['group']; ?></option>
		<?php endforeach; ?>
		</select>
	</div>
    <input class="span4" id="s" name="s" value="<?php echo $search;?>" type="text" placeholder="Search">
    <button class="btn " type="submit"><i class="icon-search"></i> Search</button>
    <?php echo form_close(); ?>
</div>

<div class="left">
	<a class="btn btn-success"href="<?php echo base_url('admin/subgroup/add'); ?>"><i class="icon-plus icon-white"></i> New Sub Group</a>
</div>

<table class="table " style="width:100%;">
	<thead>
		<tr>
			<th style="width:35%;">Sub Group</th>
			<th style="width:30%;">Group</th>
			<th style="width:5%;">Send To</th>
			<th style="width:5%;">Cc To</th>
			<th style="text-align:center;">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php if (count($subgroup)>0): ?>
		<?php foreach ($subgroup as $row):?>
		<tr>
			<td style="width:40%; font-size: 12px; font-weight:bold;"><?php echo $row['sub_group'];?></td>
			<td style="width:25%; font-size: 12px; font-weight:bold;"><?php echo $row['group'];?></td>
			<td style="width:5%; font-size: 12px; color: blue;"><?php echo $row['send_to'];?></td>
			<td style="width:5%; font-size: 12px; color: blue;"><?php echo $row['cc'];?></td>
			<td style="width:25%;text-align:center;">
				<a class="btn btn-small btn-info"href="<?php echo base_url('admin/subgroup/edit/'.$row['id']);?>"><i class="icon-edit icon-white"></i></a>
				<a class="btn btn-small btn-danger"href="<?php echo base_url('admin/subgroup/delete/'.$row['id']); ?>"><i class="icon-remove-sign icon-white"></i></a>
			</td>
		</tr>
		<?php endforeach; ?>
	<?php else: ?>
		<tr>
			<td colspan="4">No record found!</td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>

