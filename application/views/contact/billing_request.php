

<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
	<?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<?php echo anchor("contact","Contact Us",array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b>Billing Request Form</b>
</div>
<div id="leftContainer">
	<?php echo $this->session->flashdata('msg');?>
	<div id="contentInfo1">
		<p>To file a man power request, please complete the following fields and submit the form.</p>
		<br/>
		<?php $attributes = array('id' => 'form');
		echo form_open_multipart('', $attributes); ?>
		
		<div>
			<h2>Information Details</h2>
		</div>
		<hr>
		<div class="field" style="padding-bottom:5px; margin-left:10px;">
			<label for="company">Company Name</label>
			<br/>
		</div>
		<div class="field">
			<input class="input" id="company" name="company" type="text" value="<?php echo set_value('company');?>"/>
			<?php echo form_error('company'); ?>
		</div>	

		<div class="field" style="padding-bottom:5px; margin-left:10px;">
			<label for="store">Branch Name</label>
			<br/>
		</div>
		<div class="field">
			<input class="input" id="store" name="store" type="text" value="<?php echo set_value('store');?>"/>
			<?php echo form_error('store'); ?>
		</div>

		<div class="field" style="padding-bottom:5px; margin-left:10px;">
			<label for="so">SO#</label>
			<br/>
		</div>
		<div class="field">
			<input class="input" id="so" name="so" type="text" value="<?php echo set_value('so');?>"/>
			<?php echo form_error('so'); ?>
		</div>	

		<div class="field" style="padding-bottom:5px; margin-left:10px;">
			<label for="payment_for">Payment for</label>
			<br/>
		</div>
		<div class="field">
			<select name="payment_for">
				<option value="0">Please Select</option>
				<?php foreach ($payment_for as $row): ?>
				<option <?php echo set_select('payment_for', $row['id']); ?>  value="<?php echo $row['id'];?>"><?php echo $row['desc']; ?></option>
				<?php endforeach; ?>
			</select>
			<?php echo form_error('payment_for'); ?>
		</div>	

		<div class="field" style="padding-bottom:5px; margin-left:10px;">
			<label for="type">Type of payment</label>
			<br/>
		</div>
		<div class="field">
			<select name="type">
				<option value="0">Please Select</option>
				<?php foreach ($type as $row): ?>
				<option <?php echo set_select('type', $row['id']); ?>  value="<?php echo $row['id'];?>"><?php echo $row['desc']; ?></option>
				<?php endforeach; ?>
			</select>
			<?php echo form_error('type'); ?>
		</div>	

		<div class="field" style="padding-bottom:5px; margin-left:10px;">
			<label for="service_by">Service by (Technician Name)</label>
			<br/>
		</div>
		<div class="field">
			<input class="input" id="service_by" name="service_by" type="text" value="<?php echo set_value('service_by');?>"/>
			<?php echo form_error('service_by'); ?>
		</div>	

		<div class="field" style="padding-bottom:5px; margin-left:10px;">
			<label for="expense">Transpo/Meal/Lodging to be liquidated onsite?</label>
			<input type="radio" name="expense" value="yes" <?php echo set_radio('expense', 'yes'); ?> /> Yes
			<input type="radio" name="expense" value="no" <?php echo set_radio('expense', 'no', TRUE); ?> /> No
			<br/>
		</div>

		<div class="field" style="padding-bottom:5px; margin-left:10px;">
			<label for="service_by">Requested By</label>
			<br/>
		</div>
		<div class="field">
			<input maxlength="35" class="input" id="requestor" name="requestor" type="text" value="<?php echo set_value('requestor');?>"/>
			<?php echo form_error('requestor'); ?>
		</div>	

		<div class="field" style="padding-bottom:5px; margin-left:10px;">
			<label for="service_by">Email Address</label>
			<br/>
		</div>
		<div class="field">
			<input class="input" id="email" name="email" type="text" value="<?php echo set_value('email');?>"/>
			<?php echo form_error('email'); ?>
		</div>	

		<?php $this->load->view('shared/file_attach'); ?>

		<?php $this->load->view('shared/anti_spam'); ?>

		<div class="field">
			<input type="submit" class="submit" value="Submit">
		</div>
	<?php echo form_close(); ?>
	
	</div>
</div>


<script type="text/javascript">
$(document).ready(function() {
	$("#form").validate({
		errorElement: "span", 
		//set the rules for the field names
		rules: { 
			company: { required: true },
			store: { required: true },
			so: { required: true },
			captcha: { required: true},
			payment_for: {required: true , is_natural: true},
			type: {required: true , is_natural: true},
			requestor: { required: true },
			email: { required: true,email: true },
		},
		messages: {
        captcha: "Security code is required."
        
    	},
		errorPlacement: function(error, element) {               
			error.appendTo(element.parent());     
			// error.appendTo('#error-' + element.attr('id'));
		}
	});

	$("#no_man").numericonly();

	$('#start_date,#end_date').mask("99/99/9999");
	
	$("#start_date").datepicker({
		minDate: new Date(),
		onSelect: function(selected) {
		  $("#end_date").datepicker("option","minDate", selected)
		}
		
	});

	$("#end_date").datepicker({
		minDate: new Date(),
		onSelect: function(selected) {
		   $("#start_date").datepicker("option","maxDate", selected)
		}
		
	});
});
</script>