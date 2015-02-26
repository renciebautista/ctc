<?php echo $this->session->flashdata('message');?>
<h3 class="legend">Pending Filters</h3>
<div class="input-append">
	<?php $attribute['method'] = 'get';
			 echo form_open('',$attribute);?>
    <input class="span4" id="s" name="s" value="<?php echo $search;?>" type="text" placeholder="Search">
    <button class="btn " type="submit"><i class="icon-search"></i> Search</button>
    <?php echo form_close(); ?>
</div>

<div class="left">
	<a class="btn btn-success"href="<?php echo base_url('admin/pending/add'); ?>"><i class="icon-plus icon-white"></i> New Filter</a>
</div>

<table class="table ">
	<thead>
		<tr>
			<th style="width:20%;">Contact No.</th>
			<th>Notes</th>
			<th style="width:5%;text-align:center;">Retries</th>
			<th style="width:15%;text-align:center;">Date Created</th>
			<th style="width:18%; text-align:center;">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php if (count($pendings)>0): ?>
		<?php foreach ($pendings as $row):?>
		<tr>
			<td style="width:20%;"><?php echo $row['contact_no'];?></td>
			<td><?php echo $row['notes'];?></td>
			<td style="width:5%; text-align:center;"><?php echo $row['retry'];?></td>
			<td style="width:15%; text-align:center;"><?php echo date_format(date_create($row['date_created']),'m/d/Y');?></td>
			<td style="width:18%; text-align:center;">
				<a class="btn btn-small btn-info"href="<?php echo base_url('admin/pending/edit/'.$row['filter_id']);?>"><i class="icon-edit icon-white"></i> Edit</a>
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