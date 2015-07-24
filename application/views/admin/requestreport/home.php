<?php echo $this->session->flashdata('message');?>
<h3 class="legend">Request Report</h3>
<div class="input-append">
	<?php $attribute['method'] = 'get';
			 echo form_open('',$attribute);?>
	<div class="input-prepend space">
		<span class="add-on">From</span>
		<input class="span2 datefilter" type="text" name="from" value="<?php echo $from;?>">
	</div>

	<div class="input-prepend space">
		<span class="add-on">To</span>
		<input class="span2 datefilter" type="text" name="to" value="<?php echo $to;?>">
	</div>

	<div class="input-prepend space">
		<span class="add-on">Filter By</span>
		<select name="st">
			<option value="0">ALL STATUS</option>
			<?php foreach ($status as $row): ?>
			<option value="<?php echo $row['id'] ?>" <?php echo (($row['id'] == $st)? 'selected="selected"':''); ?>><?php echo $row['status_desc']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	
	<div class="input-prepend space">
		<span class="add-on">Filter By</span>
		<select name="ty">
			<option value="0">ALL REQUEST TYPE</option>
			<?php foreach ($requesttypes as $row): ?>
			<option value="<?php echo $row['id'] ?>" <?php echo (($row['id'] == $ty)? 'selected="selected"':''); ?>><?php echo strtoupper($row['sub_group']); ?></option>
			<?php endforeach; ?>
		</select>
	</div>

	<br>
    <input class="span4" id="search" name="search" value="<?php echo $search;?>" type="text" placeholder="Search">
    <button class="btn " type="submit"><i class="icon-search"></i> Search</button>
    <?php echo form_close(); ?>
</div>
<p>Total Records : <?php echo count($requests); ?></p>
<table class="table ">
	<thead>
		<tr>
			<th>Id</th>
			<th>Request Type</th>
			<th>Company Name</th>
			<th>Branch</th>
			<th>Status</th>
			<th>Date Created</th>
			<th style="width:18%; text-align:center;">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php if (count($requests)>0): ?>
		<?php foreach ($requests as $row):?>
		<tr>
			<td><?php echo str_pad($row['id'],10,'0',STR_PAD_LEFT);?></td>
			<td><?php echo $row['sub_group'];?></td>
			<td><?php echo $row['company_name'];?></td>
			<td><?php echo $row['branch'];?></td>
			<td><?php echo $row['status_desc'];?></td>
			<td><?php echo date_format(date_create($row['created_at']),'m/d/Y H:s');?></td>
			<td style="width:18%; text-align:center;">
				<a class="btn btn-small btn-info"href="<?php echo base_url('admin/requestreport/edit/'.$row['id']);?>"><i class="icon-edit icon-white"></i> View</a>
			</td>
		</tr>
		<?php endforeach; ?>
	<?php else: ?>
		<tr>
			<td colspan="7">No record found!</td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>