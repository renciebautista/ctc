<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
   <?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<?php echo anchor("ctc/salesinquiry","Contact Us",array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b>Sales Inquiry Form</b>
</div>
<div id="leftContainer">
   <?php echo $this->session->flashdata('msg');?>
    <div id="contentInfo1">
		<p>Thank you for your interest in our products and services. Please fill in the following information and a Chasetech Representative will contact you to answer questions and provide the information you require.</p>
		<br/>
		<?php $attributes = array('id' => 'form');
          echo form_open('ctc/salesinquiry', $attributes); ?>
		 <div>
			<h2>Information Details</h2>
		</div>
		<hr>
		<div class="field">
			<label class="meduim" for="fullname">Full Name</label>
			<input class="input" id="fullname" name="fullname" type="text" value="<?php echo set_value('fullname');?>"/>
			<?php echo form_error('fullname'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="company">Company</label>
			<input maxlength="35"  class="input" id="company" name="company" type="text" value="<?php echo set_value('company');?>"/>
			<?php echo form_error('company'); ?>
		</div>
		<div class="field">
		<label class="meduim" for="industry">Industry</label>
		<?php echo form_dropdown('industry',$industry, $this->input->post('industry'));?>
		</div>
		<div class="field">
			<label class="meduim" for="others">Others: (Pls. Specify)</label>
			<input class="input" id="others" name="others" type="text" value="<?php echo set_value('others');?>"/>
		</div>
		<div class="field">
			<label class="meduim" for="address">Address</label>
			<input class="input" id="address" name="address" type="text" value="<?php echo set_value('address');?>"/>
			<?php echo form_error('address'); ?>
		</div>
		 <div>
			<h2>Contact Details</h2>
		</div>
		<hr>
		<div class="field">
			<label class="meduim" for="cell">Cell phone No.</label>
			<input class="input" id="cell" name="cell" type="text" value="<?php echo set_value('cell');?>"/>
			<?php echo form_error('cell'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="landline">Landline</label>
			<input class="input" id="landline" name="landline" type="text" value="<?php echo set_value('landline');?>"/>
			<?php echo form_error('landline'); ?>
		</div>
		
		<div class="field">
			<label class="meduim" for="email">Email Address</label>
			<input class="input" id="email" name="email" type="text" value="<?php echo set_value('email');?>"/>
			<?php echo form_error('email'); ?>
		</div>

		<div class="field" style="padding-bottom:5px;">
			<b><label for="product">Product of Interest</label></b>
			<br/>
		</div>
		<div class="field">
			<textarea rows="6" cols="40" maxlength="1000" id="product" name="product"><?php echo ((isset($inquiry)) ? set_value('product',$inquiry) : set_value('product'));?></textarea>
			<?php echo form_error('product'); ?>
		</div>		
		<!-- <div style="margin-left:135px;padding:5px;" >
			<?php //echo $captcha;?>
		</div>
		<div class="field">
			<label class="meduim" for="captcha">Text in the image box</label>
			<input class="input" id="captcha" name="captcha" type="text" />
			<?php //echo form_error('captcha'); ?>
		</div> -->
		<hr>
		<div class="field">
			<label class="large" for="captcha">Enter Security Code</label>
			<input style="width:100px; float:left;" maxlength="35" class="captcha" id="captcha" name="captcha" type="text"/>
			<?php echo $captcha;?>
			<?php echo form_error('captcha'); ?>
		</div>
		<div class="field">
			<input class="ok" type="submit" name="submit" class="submit" value="Submit">
		</div>
		
		</form>
	</div>
</div>
				
<script type="text/javascript">
$(document).ready(function() {
	$("#form").validate({
		errorElement: "span", 
		//set the rules for the fild names
		rules: { fullname: { required: true },
				company: { required: true },
				address: { required: true },
				cell: { required: true },
				landline: { required: true },
				email: { required: true,email: true },
				product: { required: true },
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

	$("#cell,#landline").numericonly();
});
</script>			