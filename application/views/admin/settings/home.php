
<div class="in forms">
	<?php echo form_open();?>
		<p><strong>CAREER HEADER </strong><?php echo form_error('career'); ?><br />
		<textarea name="career" rows="5" cols="30" class="box" ><?php echo set_value('career',$settings['career_header']); ?></textarea></p>

		<p>
            <input name="submit" type="submit" id="submit"  tabindex="5" class="com_btn" value="UPDATE" />
        </p>
	<?php echo form_close();?>

</div>