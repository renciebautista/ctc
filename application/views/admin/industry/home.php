<?php echo $this->session->flashdata('message');?>
<h3 class="legend">Industries</h3>
<div class="input-append">
	<?php $attribute['method'] = 'get';
			 echo form_open('',$attribute);?>
	<div class="input-prepend space">
		  <span class="add-on">Filter By</span>
		<select class="selection" name="category">
			<option value="0">All Category</option>
		<?php foreach ($category as $row): ?>
			<option value="<?php echo $row['id']; ?>" <?php echo (($row['id'] == $id)? 'selected="selected"':''); ?>><?php echo $row['industrycategory']; ?></option>
		<?php endforeach; ?>
		</select>
	</div>
    <input class="span4" id="s" name="s" value="<?php echo $search;?>" type="text" placeholder="Search">
    <button class="btn " type="submit"><i class="icon-search"></i> Search</button>
    <?php echo form_close(); ?>
</div>

<div class="left">
	<a class="btn btn-success"href="<?php echo base_url('admin/industry/add'); ?>"><i class="icon-plus icon-white"></i> New Industry</a>
</div>

<table class="table ">
	<thead>
		<tr>
			<th style="width:25%;">Industry</th>
			<th style="width:20%;">Industry Category</th>
			<th>Description</th>
			<th style="width:18%; text-align:center;">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php if (count($industry)>0): ?>
		<?php foreach ($industry as $row):?>
		<tr>
			<td style="width:25%;"><?php echo $row['industry'];?></td>
			<td style="width:20%;"><?php echo $row['industrycategory'];?></td>
			<td><?php echo substr( $row['_content'],0,45);?>...</td>
			<td style="width:18%; text-align:center;">
				<a class="btn btn-small btn-info"href="<?php echo base_url('admin/industry/edit/'.$row['in_id']);?>"><i class="icon-edit icon-white"></i> Edit</a>
				<a class="btn btn-small btn-danger"href="<?php echo base_url('admin/industry/delete/'.$row['in_id']); ?>"><i class="icon-remove-sign icon-white"></i> Delete</a>
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

