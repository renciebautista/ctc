<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
	<?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<?php echo anchor("ctc/agreement","Supports",array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b>BIR Application</b>
</div>
<div id="leftContainer">
	<!-- <form >
			<input placeholder="Application Number"  name="query" type="text">
	</form> -->
	<div style="margin-top:20px;">
		<?php echo anchor('ctc/birform','Create a new BIR permit application.',array('class' => 'bold'));?>
	</div>
	<div id="app">
		<?php echo form_open('',array('method' => 'get'));?>
		<input placeholder="Request Number"  name="query" type="text" class="_text">
		<input class="submit" type="submit" class="submit" value="Status">
		<?php echo form_close();?>
	</div>


</div>