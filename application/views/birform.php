<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
	<?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<?php echo anchor("ctc/agreement","Supports",array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b>BIR Application</b>
</div>
<div id="leftContainer">
   <?php echo $this->session->flashdata('msg');?>
    <div id="contentInfo1">
		<p>To file a request for BIR permit application, please complete the following fields.</p>
		<br/>
		<?php $attributes = array('id' => 'form');
          echo form_open_multipart('', $attributes); ?>
         <div>
			<h2>Client Information</h2>
		</div>
		<hr>
		<div class="field">
			<label class="large" for="company">Company Name</label>
			<input maxlength="35" class="input" id="company" name="company" type="text" value="<?php echo set_value('company');?>"/>
			<?php echo form_error('company'); ?>
		</div>
		<div class="field">
			<label class="large" for="store">Store Name</label>
			<input class="input" id="store" name="store" type="text" value="<?php echo set_value('store');?>"/>
			<?php echo form_error('store'); ?>
		</div>
		<div class="field">
			<label class="large" for="email">Email Address</label>
			<input class="input" id="email" name="email" type="text" value="<?php echo set_value('email');?>"/>
			<?php echo form_error('email'); ?>
		</div>
		 <div>
			<h2>Machine/Software Information</h2>
		</div>
		<hr>
        <div class="field">
			<label class="large" for="sname">Software Name</label>
			<select name="sname" id="sname" class="input">
                <option value="0">Select Software Name</option>
				<?php foreach($software as $row){?>
                    <option value="<?php echo $row['id'];?>" <?php echo set_select('sname',$row['id']); ?> ><?php echo $row['name'];?></option>
				<?}?>
            </select>
            <?php echo form_error('sname'); ?>
		</div>
		<div class="field">
			<label class="large" for="type">Machine/Software Type</label>
			<input class="input" id="type" name="type" type="text" value="<?php echo set_value('type');?>"/>
			<?php echo form_error('type'); ?>
		</div>
		<div class="field">
			<label class="large" for="brand">Machine/Software Brand</label>
			<input class="input" id="brand" name="brand" type="text" value="<?php echo set_value('brand');?>"/>
			<?php echo form_error('brand'); ?>
		</div>
		<div class="field">
			<label class="large" for="model">Machine/Software Model</label>
			<input class="input" id="model" name="model" type="text" value="<?php echo set_value('model');?>"/>
			<?php echo form_error('model'); ?>
		</div>

		<div class="field">
			<label class="large" for="serial">Machine/Software Serial No</label>
			<input maxlength="35" class="input" id="serial" name="serial" type="text" value="<?php echo set_value('serial');?>"/>
			<?php echo form_error('serial'); ?>
		</div>
		<div class="field">
			<label class="large" for="remarks">Remarks</label>
			<textarea style="width: 300px;"  rows="6" cols="40" maxlength="1000" id="remarks" name="remarks"><?php echo set_value('remarks');?></textarea>
			<?php echo form_error('remarks'); ?>
		</div>
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
$(document).ready(function(){
	$("#form").validate({
		errorElement: "span", 
		//set the rules for the fild names
		rules: { fullname: { required: true },
                company: { required: true },
                store: { required: true },
                email: { required: true, email:true },
                sname: { required: true, is_natural:true },
                remarks: { required: true},
                captcha: { required: true}
			},
		messages: {
        email: "Invalid email address."
        
    	},
		errorPlacement: function(error, element) {               
					error.appendTo(element.parent());     
					// error.appendTo('#error-' + element.attr('id'));
			}
	});

	$(function(){
		var availableBrand = [
		"AHEAD FoodPOS Terminal",
		"AHEAD WinPOS Terminal",
		"Clone PC",
		"LENOVO",
		"WINCOR NIXDORF",
		"ZONERICH",
		"ACER"
		];
		$( "#brand" ).autocomplete({
		source: availableBrand
		});
	});

	$(function(){
		var availableModel = [
		"AHEAD FoodPOS Terminal",
		"AHEAD WinPOS Terminal",
		"Clone PC",
		"All In One POS",
		"All In One TouchPOS"
		];
		$( "#model" ).autocomplete({
		source: availableModel
		});
	});

	$(function(){
		var availableType = [
		"POS",
		"POS - SERVER",
		"POS - SERVER REPOSITORY",
		"POS - SERVER REPOSITORY ONLY",
		"POS (Roving)"
		];
		$( "#type" ).autocomplete({
		source: availableType
		});
	});
});
</script>
							