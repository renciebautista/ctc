<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
	<?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<?php echo anchor("contact","Contact Us",array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b>Service Request (Software) Form</b>
</div>
<div id="leftContainer">
	<?php echo $this->session->flashdata('msg');?>
	<div id="contentInfo1">
		<p>To file a service request, please complete the following fields and submit the form.</p>
		<br/>
		<?php $attributes = array('id' => 'form');
		echo form_open_multipart('', $attributes); ?>
		
		<?php $this->load->view('shared/client_info'); ?>

		<br>
		<div>
			<h2>Other Details</h2>
		</div>
		<hr>
		 
		<div class="field" style="padding-bottom:5px;">
			<b><label for="address">Product Information</label></b>
			<br/>
		</div>
		<div class="field">
			<div style="margin-left:10px;">
			   <em style="color:#DD4B39;">Example. Product Type [Touchpos,KDS,etc.], Software [FoodPos,Winpos,etc.]</em>
			</div>
			<textarea rows="6" cols="40" maxlength="1000" id="info" name="info"><?php echo set_value('info');?></textarea>
			<?php echo form_error('info'); ?>
		</div>
		<br>
		
		<div class="field" style="padding-bottom:5px;">
			<b><label for="address">Problem Description</label></b>
			<br/>
		</div>
		<div class="field">
			<div style="margin-left:10px;">
			   <em style="color:#DD4B39;">Please list the problems so that we can help you more, thank you.</em>
			</div>
			<textarea rows="6" cols="40" maxlength="1000" id="problem" name="problem"><?php echo set_value('problem');?></textarea>
			<?php echo form_error('problem'); ?>
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
			c_person: { required: true },
			email: { required: true,email: true },
			company: { required: true },
			store: { required: true },
			address: { required: true },
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
});
</script>