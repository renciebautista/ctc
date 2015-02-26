<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
   <?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<?php echo anchor("ctc/salesinquiry","Contact Us",array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b>Service Request Form</b>
</div>
<div id="leftContainer">
   <?php echo $this->session->flashdata('msg');?>
    <div id="contentInfo1">
		<p>To file an online service request, please complete the following fields and submit the from.</p>
		<br/>
		<?php $attributes = array('id' => 'form');
          echo form_open_multipart('ctc/servicerequest', $attributes); ?>
		 <div>
			<h2>Client Information</h2>
		</div>
		<hr>
		<div class="field">
			<label class="meduim" for="company">Company Name</label>
			<input maxlength="35" class="input" id="company" name="company" type="text" value="<?php echo set_value('company');?>"/>
			<?php echo form_error('company'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="store">Store Name</label>
			<input class="input" id="store" name="store" type="text" value="<?php echo set_value('store');?>"/>
			<?php echo form_error('store'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="branch">Branch Location</label>
			<input class="input" id="branch" name="branch" type="text" value="<?php echo set_value('branch');?>"/>
			<?php echo form_error('branch'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="c_person">Contact Person</label>
			<input class="input" id="c_person" name="c_person" type="text" value="<?php echo set_value('c_person');?>"/>
			<?php echo form_error('c_person'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="c_number">Contact Number</label>
			<input class="input" id="c_number" name="c_number" type="text" value="<?php echo set_value('c_number');?>"/>
			<?php echo form_error('c_number'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="email">Email Address</label>
			<input class="input" id="email" name="email" type="text" value="<?php echo set_value('email');?>"/>
			<?php echo form_error('email'); ?>
		</div>
		 <div class="field">
			<label class="meduim" for="category">Problem Category</label>
			<select name="category" id="category" class="input">
			   <option value="0" <?php echo set_select('category', '0', TRUE); ?> >Select Problem Category</option>
			   <option value="1" <?php echo set_select('categoryt', '1'); ?> >Hardware</option>
			   <option value="2" <?php echo set_select('category', '2'); ?> >Software</option>
			   <option value="3" <?php echo set_select('category', '3'); ?> >Both Hardware and Software</option>
			</select>
		</div>
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
			<textarea rows="15" cols="40" maxlength="1000" id="problem" name="problem"><?php echo set_value('problem');?></textarea>
			<?php echo form_error('problem'); ?>
		</div>
		<br>
		<div>
			<h2>File Attachment</h2>
		</div>
		 <hr>
		<div class="field">
			<div style="margin-left:10px;">
			   <ul style='color:#DD4B39; list-style:none;font-style:italic;'>
					<li>The maximum file size for uploads 2 MB (or 2048 KB) per file.</li>
					<li>Only image files (pdf|gif|jpg|png|txt|xls|xlsx|doc|docx|jpeg|bmp|csv) are allowed.</li>
				</ul>
			</div>
			
		</div>
		
		
	    </br>
	    <div class="field">
		    <input type="file" name="userfile[]" size="60" class="multi" accept="gif|jpg|png|txt|xls|xlsx|doc|docx|pdf" />
		</div>
		
		
		</br>
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
		rules: { company: { required: true },
				store: { required: true },
				branch: { required: true },
				c_person: { required: true },
				c_number: { required: true },
				email: { required: true,email: true },
				category: { required: true,is_natural: true },
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

							