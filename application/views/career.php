<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
    <?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b>Careers</b>
</div>
<div id="leftContainer">
    <div id="industryContainer">
        <div class="title">Careers</div>
        <div id="body">
			<div id="contentInfo">
				<p><?php echo $career_header;?></p>
			</div>
			<?php
				foreach($career as $row){
					echo "<p id='containerTitle'>" . $row['title'] . "</p>";
					echo "<div id='contentInfo'>";
					echo "<p>". $row['content'] . "</p></br>";
					echo "<h2 style='font-weight:bold;'>Responsibilities</h2>";
					echo "<ul style='padding:5px; padding-left: 20px;'>";
					$response = explode("-",$row['responsibilities']);
					$cnt = 0;
					foreach($response as $key=>$value){
						if($cnt > 0){
							echo "<li>$value</li>";
						}
						$cnt++;
					}
					echo "</ul></br>";
					echo "<h2 style='font-weight:bold;'>Requirements</h2>";
					echo "<ul style='padding:5px; padding-left: 20px;'>";
					$response = explode("-",$row['requirements']);
					$cnt = 0;
					foreach($response as $key=>$value){
						if($cnt > 0){
							echo "<li>$value</li>";
						}	
						$cnt++;
					}
					echo "</ul></br>";
					echo "</div>";
				}
			?>
        </div>							
    </div>
	
</div>
							