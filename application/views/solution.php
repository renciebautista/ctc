<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
 <?php echo anchor("","Home", array('class' => 'sitemap'));?>
&nbsp;\&nbsp;<?php echo anchor("ctc/industry","Industry Solutions",array('class' => 'sitemap'));?>
&nbsp;\&nbsp;<?php echo anchor("ctc/industry/" . $category['id'],$category['industrycategory'],array('class' => 'sitemap'));?>
&nbsp;\&nbsp;<b><? echo $solution['industry'];?></b></div>
<div id="leftContainer">
    <div id="industryContainer">
        <div class="title"><? echo $solution['industry'];?></div>
        <div class="padding">
            <img src='<? echo base_url($solution['image']);?>' width="100" height="107" />
			<p class="content"><? echo $solution['icontent'];?></p>
        </div>
        <div id="benefitsContainer">
            <div id="background">
                <p id="benefitsTitle">Features</p>
                <ul>
                    <?php
                        $benefits = explode('|',$solution['benefits']);
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
            </div>
        </div>
    </div>
</div>