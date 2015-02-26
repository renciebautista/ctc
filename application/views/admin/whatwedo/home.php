<?php echo $this->session->flashdata('message');?>
<h3 class="legend">What We Do</h3>
<div class="input-append">
	<?php $attribute['method'] = 'get';
			 echo form_open('',$attribute);?>
    <input class="span4" id="s" name="s" value="<?php echo $search;?>" type="text" placeholder="Search">
    <button class="btn " type="submit"><i class="icon-search"></i> Search</button>
    <?php echo form_close(); ?>
</div>

<div class="left">
	<a class="btn btn-success"href="<?php echo base_url('admin/whatwedo/add'); ?>"><i class="icon-plus icon-white"></i> New What We Do</a>
</div>

<table class="table ">
	<thead>
		<tr>
			<th style="width:20%;">What We Do</th>
			<th>Description</th>
			<th style="width:18%; text-align:center;">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php if (count($whatwedo)>0): ?>
		<?php foreach ($whatwedo as $row):?>
		<tr>
			<td style="width:35%;"><?php echo $row['whatwedo'];?></td>
			<td><?php echo substr( $row['content'],0,60);?>...</td>
			<td style="width:18%; text-align:center;">
				<a class="btn btn-small btn-info"href="<?php echo base_url('admin/whatwedo/edit/'.$row['id']); ?>"><i class="icon-edit icon-white"></i> Edit</a>
				<a class="btn btn-small btn-danger"href="<?php echo base_url('admin/whatwedo/delete/'.$row['id']); ?>"><i class="icon-remove-sign icon-white"></i> Delete</a>
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