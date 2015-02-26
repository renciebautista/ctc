
<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
	<?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<?php echo anchor("contact","Contact Us",array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b>Stock Order Follow-Up Request Form</b>
</div>
<div id="leftContainer">
	<?php echo $this->session->flashdata('msg');?>
	<div id="contentInfo1">
		<p>To file a stock order follow-up request, please complete the following fields and submit the form.</p>
		<br/>
		<?php $attributes = array('id' => 'form');
		echo form_open_multipart('', $attributes); ?>
		
		<div>
			<h2>Information Details</h2>
		</div>
		<hr>

		<div class="field">
			<label class="meduim" for="c_number">Cellphone No.</label>
			<input class="input" id="c_number" name="c_number" type="text" value="<?php echo set_value('c_number');?>"/>
			<?php echo form_error('c_number'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="landline">Landline No.</label>
			<input class="input" id="landline" name="landline" type="text" value="<?php echo set_value('landline');?>"/>
			<?php echo form_error('landline'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="email">Email Address</label>
			<input class="input" id="email" name="email" type="text" value="<?php echo set_value('email');?>"/>
			<?php echo form_error('email'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="c_person">Full Name</label>
			<input class="input" id="c_person" name="c_person" type="text" value="<?php echo set_value('c_person');?>"/>
			<?php echo form_error('c_person'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="company">Company</label>
			<input class="input" id="company" name="company" type="text" value="<?php echo set_value('company');?>"/>
			<?php echo form_error('company'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="store">Store/Branch Name</label>
			<input class="input" id="store" name="store" type="text" value="<?php echo set_value('store');?>"/>
			<?php echo form_error('store'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="address">Address</label>
			<input class="input" id="address" name="address" type="text" value="<?php echo set_value('address');?>"/>
			<?php echo form_error('address'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="dept">Department</label>
			<input maxlength="35" class="input" id="dept" name="dept" type="text" value="<?php echo set_value('dept');?>"/>
			<?php echo form_error('dept'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="assigned">CTC AE Assigned</label>
			<input maxlength="35" class="input" id="assigned" name="assigned" type="text" value="<?php echo set_value('assigned');?>"/>
			<?php echo form_error('assigned'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="refno">Ref. No. (PO/SO)</label>
			<input maxlength="35" class="input" id="refno" name="refno" type="text" value="<?php echo set_value('refno');?>"/>
			<?php echo form_error('refno'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="delivery">Exp. Delivery Date</label>
			<input maxlength="35" class="input" id="delivery" name="delivery" type="text" value="<?php echo set_value('delivery');?>"/>
			<?php echo form_error('delivery'); ?>
		</div>

		<br/>
		<div>
			<h2>Other Details</h2>
		</div>
		<hr>

		<div class="field" style="padding-bottom:5px;">
			<b><label for="product">Reason for Follow-up</label></b>
			<br/>
		</div>
		<div class="field">
			<textarea rows="6" cols="40" maxlength="1000" id="info" name="info"><?php echo ((isset($inquiry)) ? set_value('product',$inquiry) : set_value('product'));?></textarea>
			<?php echo form_error('info'); ?>
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
			c_number: { required: true },
			landline: { required: true },
			c_person: { required: true },
			email: { required: true,email: true },
			company: { required: true },
			store: { required: true },
			address: { required: true },
			dept: { required: true },
			assigned: { required: true },
			refno: { required: true },
			delivery: { required: true },
			info: { required: true },
			problem: { required: true },
			captcha: { required: true}
		},
		messages: {
        captcha: "Security code is required."
        
    	},
		errorPlacement: function(error, element) {               
			error.appendTo(element.parent());     
			// error.appendTo('#error-' + element.attr('id'));
		}
	});

	$("#c_number").numericonly();
	$("#landline").numericonly();
});
</script>