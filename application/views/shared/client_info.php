<div>
	<h2>Information Details</h2>
</div>
<hr>

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

