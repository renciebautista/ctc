<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
    <?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b>What We Do</b>
</div>
<div id="leftContainer">
    <?php
        foreach($whatwedo  as $row){
            ?>
            <div id="whatwedoContainer">
                <a name='<? echo $row['id'];?>'></a>
                <table>
                    <tr>
						<td><img class="wedo" style="width:100px; height:100px;" src='<? echo base_url($row['image']);?>' /></td>
						<td>
							<div class="title"><? echo $row['whatwedo'];?></div>
							<div class="content"><? echo $row['content'];?></div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<ul>
								<?
									$features = explode('|',$row['feature']);
									$fet = count($features);
									$cnt = 0;
									sort($features);
									while($cnt< $fet)
									{
										if($cnt > 0)
										{
											echo '<li>'.$features[$cnt] .'</li>';
										}
										$cnt++;
									}
									
								?>
							</ul>
						</td>
					</tr>
                </table>
            </div>
            <div style="height:5px;"><br /></div>
            <?
        }
    ?>
</div>