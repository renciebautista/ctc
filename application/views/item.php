<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
    <?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<?php echo anchor("ctc/product","Products",array('class' => 'sitemap'));?>&nbsp;\&nbsp;<?php echo anchor("ctc/category/" . $product['productcategory'],$categoryname['productcategory'],array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b><? echo $product['products'];?></b>
</div>
<div id="leftContainer">
    <div id="industryContainer">
        <div class="title"><? echo $product['products'];?></div>
        <div id="body">
            <table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
						<img src='<? echo base_url(). $product['image'];?>' width="100" height="107" />
						<p><? echo $product['itemcontent'];?></p>
					</td>
				</tr>
            </table>
            <br style="margin-bottom:10px;" />
            <table id="contents" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="list">
                        <div id="background">
                            <p id="containerTitle">Benefits</p>
                            <ul>
                                <?php
                                    $benefits = explode('|',$product['benefits']);
									$ben = count($benefits);
									$cnt= 0;
									sort($benefits);
									while($cnt< $ben){
										if($cnt > 0){
											echo '<li>'.$benefits[$cnt] .'</li>';
											}
										$cnt++;
									}
                                ?>
                            </ul>
                            <p id="containerFooter">&nbsp;</p>
                        </div>
                    </td>
                    <td rowspan="3" class="spacer">&nbsp;</td>
                    <td class="idealfor" rowspan="3">
                        <div class="border">
                            <div class="title">Ideal for</div>
                            <ul>
							<?php
								foreach($idealfor as $row)
								{
									echo '<li>';
									echo anchor('ctc/solution/' . $row['id'],$row['industry']);
									echo '</li>';
								}
							?>
							</ul>
                        </div>
                    </td>
                </tr>
				<tr>
					<td class="spacer">&nbsp;</td>
				</tr>
				<?php
				if($product['features'] != ''){?>
				<tr>
					<td class="list">
						<div id="background">
						<p id="containerTitle">Features</p>
							<ul><?
							$features = explode('|',$product['features']);
							$fet = count($features);
							$cnt1= 0;
							sort($features);
							while($cnt1< $fet){
								if($cnt1 > 0){
									echo '<li>'.$features[$cnt1] .'</li>';
								}
								$cnt1++;
							}
							?>
							</ul>
							<p id="containerFooter">&nbsp;</p>
						</div>
					</td>
				</tr>
				<?}
				?>
				<tr>
					<td class="spacer">&nbsp;</td>
				</tr>
            </table>
        </div>
    </div>
</div>
							