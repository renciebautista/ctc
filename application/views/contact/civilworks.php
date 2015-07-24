<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
	<?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<?php echo anchor("contact","Contact Us",array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b>Service Request (Civil Works) Form</b>
</div>
<div id="leftContainer">
	<?php echo $this->session->flashdata('msg');?>
	<div id="contentInfo1">
		<p>To file a service request, please complete the following fields and submit the form.</p>
		<br/>
		<?php $attributes = array('id' => 'form');
		echo form_open_multipart('', $attributes); ?>
		
		<?php $this->load->view('shared/client_info_2'); ?>

		<br>
		<div>
			<h2>Other Details</h2>
		</div>
		<hr>
		 
		<div class="field" style="padding-bottom:5px;">
			<b><label for="tools">Tools/Equipment Requirement</label></b>
			<br/>
		</div>
		<div class="field">
			<div style="margin-left:10px;">
			   <em style="color:#DD4B39;">Example.[Electric Drill,Welding Machine,Ladder,Scaffolding,etc.]</em>
			</div>
			<textarea rows="6" cols="40" maxlength="1000" id="tools" name="tools"><?php echo set_value('tools');?></textarea>
			<?php echo form_error('tools'); ?>
		</div>
		<br>
		
		<div class="field" style="padding-bottom:5px;">
			<b><label for="scope">Job Scope</label></b>
			<br/>
		</div>
		<div class="field">
			<div style="margin-left:10px;">
			   <em style="color:#DD4B39;">Please list the job scope so that we can help you more, thank you.</em>
			</div>
			<textarea rows="6" cols="40" maxlength="1000" id="scope" name="scope"><?php echo set_value('scope');?></textarea>
			<?php echo form_error('scope'); ?>
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
			requested_by: { required: true },
			r_number: { required: true },
			remail: { required: true,email: true },
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

	$("#c_number,#r_number").numericonly();
});
</script>