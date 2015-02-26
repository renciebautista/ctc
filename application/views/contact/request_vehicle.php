<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
	<?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<?php echo anchor("contact","Contact Us",array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b>Vehicle Request Form</b>
</div>
<div id="leftContainer">
	<?php echo $this->session->flashdata('msg');?>
	<div id="contentInfo1">
		<p>To file a vehicle request, please complete the following fields and submit the form.</p>
		<br/>
		<?php $attributes = array('id' => 'form');
		echo form_open_multipart('', $attributes); ?>
		
		<div>
			<h2>Information Details</h2>
		</div>
		<hr>
		<br/>

		<div class="field" style="padding-bottom:5px;">
			<b><label size="10px" for="product"><font size="2" color="7A7777">Delivery Details</font></label></b>
			<br/>
		</div><br/>

		<div class="field">
			<label class="meduim" for="c_number">Contact Number</label>
			<input class="input" id="c_number" name="c_number" type="text" value="<?php echo set_value('c_number');?>"/>
			<?php echo form_error('c_number'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="c_person">Contact Person</label>
			<input class="input" id="c_person" name="c_person" type="text" value="<?php echo set_value('c_person');?>"/>
			<?php echo form_error('c_person'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="email">Email Address</label>
			<input class="input" id="email" name="email" type="text" value="<?php echo set_value('email');?>"/>
			<?php echo form_error('email'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="company">Company Name</label>
			<input maxlength="35" class="input" id="company" name="company" type="text" value="<?php echo set_value('company');?>"/>
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
			<label class="meduim" for="sono">SO Number</label>
			<input class="input" id="sono" name="sono" type="text" value="<?php echo set_value('sono');?>"/>
			<?php echo form_error('sono'); ?>
		</div> 
		<div class="field">
			<label class="meduim" for="mpdr">MP/DR Number</label>
			<input class="input" id="mpdr" name="mpdr" type="text" value="<?php echo set_value('mpdr');?>"/>
			<?php echo form_error('mpdr'); ?>
		</div> 
		<div class="field">
			<label class="meduim" for="sino">SI Number</label>
			<input class="input" id="sino" name="sino" type="text" value="<?php echo set_value('sino');?>"/>
			<?php echo form_error('sino'); ?>
		</div> 

		<div class="field" style="padding-bottom:5px;">
			<b><label size="10px" for="product"><font size="2" color="7A7777">Travel Pass Details</font></label></b>
			<br/>
		</div><br/>

		<div class="field">
			<label class="meduim" for="name">Full Name</label>
			<input class="input" id="name" name="name" type="text" value="<?php echo set_value('name');?>"/>
			<?php echo form_error('name'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="dept">Department</label>
			<input class="input" id="dept" name="dept" type="text" value="<?php echo set_value('dept');?>"/>
			<?php echo form_error('dept'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="purpose">Purpose</label>
			<input class="input" id="purpose" name="purpose" type="text" value="<?php echo set_value('purpose');?>"/>
			<?php echo form_error('purpose'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="ddate">Date</label>
			<input class="input" id="ddate" name="ddate" type="text" value="<?php echo set_value('ddate');?>"/>
			<?php echo form_error('ddate'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="dtime">Time</label>
			<input class="input" id="dtime" name="dtime" type="text" value="<?php echo set_value('dtime');?>"/>
			<?php echo form_error('dtime'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="destination">Destination</label>
			<input class="input" id="destination" name="destination" type="text" value="<?php echo set_value('destination');?>"/>
			<?php echo form_error('destination'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="plateno">Plate No.</label>
			<input class="input" id="plateno" name="plateno" type="text" value="<?php echo set_value('plateno');?>"/>
			<?php echo form_error('plateno'); ?>
		</div>
		<div class="field">
			<label class="meduim" for="driver">Driver</label>
			<input class="input" id="driver" name="driver" type="text" value="<?php echo set_value('driver');?>"/>
			<?php echo form_error('driver'); ?>
		</div>
		<br/>
		<div style="margin-left:120px;">
			<input type="checkbox" name="option2" value="Butter"> I hereby agree to take full reponsibility for the use and care of this vehicle.
		</div>
		<br/> 

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
			sono: { required: true },
			mpdr: { required: true },
			sino: { required: true },

			name: { required: true },
			dept: { required: true },
			purpose: { required: true },
			ddate: { required: true },
			dtime: { required: true },
			destination: { required: true },
			plateno: { required: true },
			driver: { required: true },
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
	$("#sono").numericonly();
	$("#mpdr").numericonly();
	$("#sino").numericonly();
});
</script>