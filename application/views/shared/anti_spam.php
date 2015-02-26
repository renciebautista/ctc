<hr>
<div class="field">
	<label class="large" for="captcha">Enter Security Code</label>
	<input style="width:100px; float:left;" maxlength="35" class="captcha" id="captcha" name="captcha" type="text"/>
	<?php echo $captcha;?>
	<?php echo form_error('captcha'); ?>
</div>