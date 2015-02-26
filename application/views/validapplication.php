<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
	<?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<?php echo anchor("ctc/agreement","Supports",array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b>BIR Application</b>
</div>
<?php //print_r($this->_ci_cached_vars);?>
<div id="leftContainer">
   <?php echo $this->session->flashdata('msg');?>
    <div id="contentInfo1">
		<p>To file a request for BIR permit application, please complete the following fields.</p>
		<br/>
		<?php $attributes = array('id' => 'form');
          echo form_open_multipart('', $attributes); ?>
		<hr>
		<div class="detail">
			<div class="lbl">
                Company Name
            </div>
            <div>
                <b><?php echo $details['company_name'];?></b>
            </div>
        </div>

        <div class="detail">
			<div class="lbl">
                Store Name
            </div>
            <div>
                <b><?php echo $details['store_name'];?></b>
            </div>
        </div>
         <div>
			<h2>Taxpayer-User Information</h2>
		</div>
		<hr>
		<div style="margin-left:10px; margin-bottom:5px;">
			   <em style="color:#DD4B39;">Following information can be found in your Certificate of Registration (COR) or BIR Form No. 2303.</em>
			</div>
        <div class="field">
			<label class="large" for="serial">Taxpayer-User TIN (9 digits)</label>
			<input maxlength="9" class="input" id="serial" name="serial" type="text" value="<?php echo set_value('serial');?>"/>
			<?php echo form_error('serial'); ?>
		</div>
		<div class="field">
			<label class="large" for="serial">Branch Code (3 digits)</label>
			<input maxlength="3" class="input" id="serial" name="serial" type="text" value="<?php echo set_value('serial');?>"/>
			<?php echo form_error('serial'); ?>
		</div>
		<div class="field">
			<label class="large" for="serial">Taxpayer-User Name</label>
			<textarea style="width: 300px;"  rows="3" cols="40" maxlength="1000" id="remarks" name="remarks"><?php echo set_value('remarks');?></textarea>
			<?php echo form_error('remarks'); ?>
		</div>
		<div class="field">
			<label class="large" for="serial">Trade/ Business Name</label>
			<textarea style="width: 300px;"  rows="3" cols="40" maxlength="1000" id="remarks" name="remarks"><?php echo set_value('remarks');?></textarea>
			<?php echo form_error('remarks'); ?>
		</div>
		<div class="field">
			<label class="large" for="serial">Registered Address</label>
			<textarea style="width: 300px;"  rows="6" cols="40" maxlength="1000" id="remarks" name="remarks"><?php echo set_value('remarks');?></textarea>
			<?php echo form_error('remarks'); ?>
		</div>
		<div class="field">
			<label class="large" for="serial">RDO No. (3 digits)</label>
			<input maxlength="3" class="input" id="serial" name="serial" type="text" value="<?php echo set_value('serial');?>"/>
			<?php echo form_error('serial'); ?>
		</div>
		 <div>
			<h2>Machine/Software Information</h2>
		</div>
		<hr>
        <div class="detail">
			<div class="lbl">
                Sofware Name
            </div>
            <div>
                <b><?php echo $details['software'];?></b>
            </div>
        </div>

         <div class="detail">
			<div class="lbl">
                Sofware Version
            </div>
            <div>
                <b><?php echo $details['version'];?></b>
            </div>
        </div>

        <?php if ($details['type'] == ''){?>
		<div class="field">
			<label class="large" for="type">Machine/Software Type</label>
			<input class="input" id="type" name="type" type="text" value="<?php echo set_value('type');?>"/>
			<?php echo form_error('type'); ?>
		</div>
        <?}else{?>    
        <div class="detail">
			<div class="lbl">
                Machine/Software Type
            </div>
            <div>
                <b><?php echo $details['type'];?></b>
            </div>
        </div>
        <?}?>

        <?php if ($details['brand'] == ''){?>
        <div class="field">
			<label class="large" for="brand">Machine/Software Brand</label>
			<input class="input" id="brand" name="brand" type="text" value="<?php echo set_value('brand');?>"/>
			<?php echo form_error('brand'); ?>
		</div>
        <?}else{?>
        <div class="detail">
			<div class="lbl">
                Machine/Software Brand
            </div>
            <div>
                <b><?php echo $details['brand'];?></b>
            </div>
        </div>
        <?}?>

        <?php if ($details['model'] == ''){?>
        <div class="field">
			<label class="large" for="software">Machine/Software Model</label>
			<input class="input" id="software" name="software" type="text" value="<?php echo set_value('software');?>"/>
			<?php echo form_error('software'); ?>
		</div>
        <?}else{?>
        <div class="detail">
			<div class="lbl">
                Machine/Software Model
            </div>
            <div>
                <b><?php echo $details['model'];?></b>
            </div>
        </div>
        <?}?>

        <?php if ($details['serial'] == ''){?>
       	<div class="field">
			<label class="large" for="serial">Machine/Software Serial No</label>
			<input maxlength="35" class="input" id="serial" name="serial" type="text" value="<?php echo set_value('serial');?>"/>
			<?php echo form_error('serial'); ?>
		</div>
        <?}else{?>
        <div class="detail">
			<div class="lbl">
               Machine/Software Serial No
            </div>
            <div>
                <b><?php echo $details['serial'];?></b>
            </div>
        </div>
        <?}?>
        
        <hr>
		<div class="field">
			<label class="large" for="captcha">Enter Security Code</label>
			<input style="width:100px; float:left;" maxlength="35" class="captcha" id="captcha" name="captcha" type="text"/>
			<?php echo $captcha;?>
			<?php echo form_error('captcha'); ?>
		</div>
		 
		<div class="field">
			<input class="ok" type="submit" name="submit" class="submit" value="Update">
		</div>	
		</form>
		
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	// $("#form").validate({
	// 	errorElement: "span", 
	// 	//set the rules for the fild names
	// 	rules: { fullname: { required: true },
 //                company: { required: true },
 //                store: { required: true },
 //                email: { required: true, email:true },
 //                sname: { required: true, is_natural:true },
 //                remarks: { required: true}
	// 		},
	// 	messages: {
 //        email: "Invalid email address."
        
 //    	},
	// 	errorPlacement: function(error, element) {               
	// 				error.appendTo(element.parent());     
	// 				// error.appendTo('#error-' + element.attr('id'));
	// 		}
	// });

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
		var availableSoftware = [
		"AHEAD FoodPOS Terminal",
		"AHEAD WinPOS Terminal",
		"Clone PC",
		"All In One POS",
		"All In One TouchPOS"
		];
		$( "#software" ).autocomplete({
		source: availableSoftware
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
							