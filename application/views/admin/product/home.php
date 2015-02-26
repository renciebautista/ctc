<?php echo $this->session->flashdata('message');?>
<h3 class="legend">Products</h3>
<div class="input-append">
	<?php $attribute['method'] = 'get';
			 echo form_open('',$attribute);?>
	<div class="input-prepend space">
		  <span class="add-on">Filter By</span>
		<select class="selection" name="category">
			<option value="0">All Category</option>
		<?php foreach ($category as $row): ?>
			<option value="<?php echo $row['id'] ?>" <?php echo (($row['id'] == $id)? 'selected="selected"':''); ?>><?php echo $row['productcategory']; ?></option>
		<?php endforeach; ?>
		</select>
	</div>
    <input class="span4" id="s" name="s" value="<?php echo $search;?>" type="text" placeholder="Search">
    <button class="btn " type="submit"><i class="icon-search"></i> Search</button>
    <?php echo form_close(); ?>
</div>

<div class="left">
	<a class="btn btn-success"href="<?php echo base_url('admin/product/add'); ?>"><i class="icon-plus icon-white"></i> New Product</a>
</div>

<table class="table ">
	<thead>
		<tr>
			<th style="width:25%;">Product</th>
			<th style="width:20%;">Product Category</th>
			<th>Description</th>
			<th style="width:18%; text-align:center;">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php if (count($product)>0): ?>
		<?php foreach ($product as $row):?>
		<tr>
			<td style="width:25%;"><?php echo $row['products'];?></td>
			<td style="width:20%;"><?php echo $row['productcategory'];?></td>
			<td><?php echo substr( $row['_content'],0,45);?>...</td>
			<td style="width:18%; text-align:center;">
				<a class="btn btn-small btn-info"href="<?php echo base_url('admin/product/edit/'.$row['in_id']);?>"><i class="icon-edit icon-white"></i> Edit</a>
				<a class="btn btn-small btn-danger"href="<?php echo base_url('admin/product/delete/'.$row['in_id']); ?>"><i class="icon-remove-sign icon-white"></i> Delete</a>
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

