

<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
	<?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<?php echo anchor("contact","Contact Us",array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b>Mam Power Request Form</b>
</div>
<div id="leftContainer">
	<?php echo $this->session->flashdata('msg');?>
	<div id="contentInfo1">
		<p>To file a man power request, please complete the following fields and submit the form.</p>
		<br/>
		<?php $attributes = array('id' => 'form');
		echo form_open_multipart('', $attributes); ?>
		
		<?php $this->load->view('shared/client_info'); ?>

		<br>
		<div>
			<h2>Other Details</h2>
		</div>
		<hr>
		<div class="field">
			<label class="meduim" for="project">Project  / Client Name</label>
			<input class="input" id="project" name="project" type="text" value="<?php echo set_value('project');?>"/>
			<?php echo form_error('project'); ?>
		</div>

		<div class="field">
			<label class="meduim" for="no_man">No. of Man Power</label>
			<input class="input" id="no_man" name="no_man" type="text" value="<?php echo set_value('no_man');?>"/>
			<?php echo form_error('no_man'); ?>
		</div>

		<div class="field">
			<label class="meduim" for="start_date">Start Date</label>
			<input class="input" id="start_date" name="start_date" type="text" value="<?php echo set_value('start_date');?>"/>
			<?php echo form_error('start_date'); ?>
		</div>

		<div class="field">
			<label class="meduim" for="end_date">End Date</label>
			<input class="input" id="end_date" name="end_date" type="text" value="<?php echo set_value('end_date');?>"/>
			<?php echo form_error('end_date'); ?>
		</div>

		<div class="field" style="padding-bottom:5px;">
			<b><label for="product">Skills Required</label></b>
			<br/>
		</div>
		<div class="field">
			<textarea rows="6" cols="40" maxlength="1000" id="info" name="info"><?php echo ((isset($skills)) ? set_value('info',$skills) : set_value('info'));?></textarea>
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
			project: { required: true },
			no_man: { required: true },
			start_date: { required: true },
			end_date: { required: true },
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