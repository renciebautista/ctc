<?php echo $this->session->flashdata('message');?>
<h3 class="legend">Request Details</h3>
<a class="btn" href="<?php echo base_url('admin/requestreport'); ?>">Back</a>


<div class="row-fluid">
	<div class="span6" style="margin-top:15px;">
		<table class="table table-bordered">
            <colgroup>
              <col class="span1">
              <col class="span7">
            </colgroup>
            <tbody>
              	<tr>
                	<td>Request Id</td>
                	<td><?php echo str_pad($request['id'],10,'0',STR_PAD_LEFT);?></td>
             	</tr>
             	<tr>
                	<td>Status</td>
                	<td><?php echo $request['status_desc'];?></td>
             	</tr>
             	<tr>
                	<td>Date Created</td>
                	<td><?php echo date_format(date_create($request['created_at']),'m/d/Y H:s');?></td>
             	</tr>
             	<tr>
                	<td>Last Update</td>
                	<td><?php echo date_format(date_create($request['updated_at']),'m/d/Y H:s');?></td>
             	</tr>
             	<tr>
                	<td>Request Type</td>
                	<td><?php echo $request['sub_group'];?></td>
             	</tr>
             	<tr>
                	<td>Company Name</td>
                	<td><?php echo $request['company_name'];?></td>
             	</tr>
             	<tr>
                	<td>Branchs Name</td>
                	<td><?php echo $request['branch'];?></td>
             	</tr>
             	<tr>
                	<td>Address</td>
                	<td><?php echo $request['address'];?></td>
             	</tr>
             	<tr>
                	<td>Contact Person</td>
                	<td><?php echo $request['contact_person'];?></td>
             	</tr>
             	<tr>
                	<td>Contact No.</td>
                	<td><?php echo $request['contact_no'];?></td>
             	</tr>
             	<tr>
                	<td>Email Address</td>
                	<td><?php echo $request['email'];?></td>
             	</tr>
            </tbody>
          </table>
           <?php if(ROLE_ID == 4): ?>
          	<?php echo form_open('',['class' => 'bordered']);?>
              	<label>Remarks</label><?php echo form_error('remarks'); ?>
              	<textarea  class="span12" rows="4" name="remarks"><?php echo set_value('remarks'); ?></textarea>
				<label>Status</label><?php echo form_error('status'); ?>
              	<select name="status" class="span12">
					<option value="0">SELECT STATUS</option>
					<?php foreach ($status as $row): ?>
					<option <?php echo set_select('status', $row['id']); ?>  value="<?php echo $row['id'];?>"><?php echo $row['status_desc']; ?></option>
					<?php endforeach; ?>
				</select>
				
				<br>
              	<button class="btn btn-primary" type="submit">Update</button>
              	<a class="btn" href="<?php echo base_url('admin/requestreport'); ?>">Back</a>
          	<?php echo form_close(); ?>
          <?php endif; ?>
        <?php if(count($threads) > 0): ?>
        <div class="bordered_comment">
        	<?php foreach ($threads as $thread): ?>
        	<div class="comment_top">
        		<div>
				  	<div class="comment_time">
			      		<div> <?php echo date_format(date_create($thread['created_at']),'m/d/Y H:s');?> </div>
					</div>
				</div>
				<div class="comment_status">
					<?php 
						$class ="";
						switch ($thread['status_id']) {
							case '1':
								$class ="label label-important";
								break;
							case '2':
								$class ="label label-success";
								break;
							case '3':
								$class ="label ";
								break;
                            case '4':
                                $class ="label label-info";
                                break;
                            case '5':
                                $class ="label label-warning";
                                break;
							default:
								# code...
								break;
						}
					 ?>
				  	<span class="<?php echo $class; ?>"><?php echo nl2br($thread['status_desc']); ?></span>
				</div>
        		<div class="comment">
				    <p><?php echo nl2br($thread['remarks']); ?></p>
					<p><i><?php echo $thread['display_name'];?></i></p>
				  </div>
        	</div>
        	<?php endforeach; ?>
        </div>
    	<?php endif; ?>
	</div>
	<div class="span6">
	  	<div class="bs-docs-example">
			<?php echo str_replace("70%", "100%", $request['details']); ?>
		</div>
	</div>
	
	
</div>

