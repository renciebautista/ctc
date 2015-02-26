
<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
	<?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<?php echo anchor("contact","Contact Us",array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b>Verify Employee</b>
</div>
<div id="leftContainer" >
	<?php echo $this->session->flashdata('msg');?>
	<div id="contentInfo1" style="min-height:400px;">
		<p>To file verify if valid Chase Technologies Employee, please enter Employee ID.</p>
		<br/>
		<?php $attributes = array('id' => 'form','method' => 'get');
		echo form_open('', $attributes); ?>
		
		
		<div class="field">
			<input class="input" id="id" name="id" type="text" value="<?php echo set_value('id');?>"/>
			<input type="submit" class="submit" value="Verify">
		</div>
	<?php echo form_close(); ?>
	<?php if($api->status == 'ok'): ?>
		<div>
			<div style="border:2px solid #ddd; width:200px; margin: 10px; float:left;">
				<?php if(!empty($api->details->image_file)): ?>
				<img height="200" width="200" src="<?php echo $api->details->image; ?>" alt="Employee Image">
			<?php else: ?>
				<img height="200" width="200" src="<?php echo base_url('images/user.png'); ?>" alt="Employee Image">
				<?php endif ?>
			</div>
			<div style="width:390px; margin: 10px; float:left;margin-top:50px;">
				<h2 style="padding:10px;">Employee Name : <?php echo $api->details->display_name; ?></h2>
				<h2 style="padding:10px;">Employee Number : <?php echo $api->details->emp_id; ?></h2>
				<h2 style="padding:10px;">Is currently employed in us.</h2>
			</div>
		</div>
	<?php elseif($api->status == 'not_found'): ?>
		<div>
			<h2 style="padding:10px;"><?php echo $api->message; ?></h2>
		</div>
	<?php endif; ?>
	</div>
</div>

