

<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
	<?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<?php echo anchor("contact","Contact Us",array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b>Follow-Up Bir Application Request Form</b>
</div>
<div id="leftContainer">
	<?php echo $this->session->flashdata('msg');?>
	<div id="contentInfo1">
		<p>To file a follow-up schedule request, please complete the following fields and submit the form.</p>
		<br/>
		<?php $attributes = array('id' => 'form');
		echo form_open_multipart('', $attributes); ?>
		
		<?php $this->load->view('shared/client_info'); ?>
		<div class="field">
			<label class="meduim" for="salesorder">Sales Order</label>
			<input class="input" id="salesorder" name="salesorder" type="text" value="<?php echo set_value('salesorder');?>"/>
			<?php echo form_error('salesorder'); ?>
		</div> 


		<br>
		<div>
			<h2>Other Details</h2>
		</div>
		<hr>
		<div class="field" style="padding-bottom:5px;">
			<b><label for="product">Remarks</label></b>
			<br/>
		</div>
		<div class="field">
			<textarea rows="6" cols="40" maxlength="1000" id="info" name="info"><?php echo ((isset($inquiry)) ? set_value('info',$inquiry) : set_value('info'));?></textarea>
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