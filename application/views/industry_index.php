<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
    <?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b>Industry Solutions</b>
</div>
<div id="contents">
    <div id="industry_contents">
    <?php
    foreach($indCategory as $industry){
        $ul = 0;
        $cnt = 0;
        if($ul == 0){
            echo '<ul>';
            $ul = 1;
        }?>
    <li class="list">
         <a href="<?php echo base_url("ctc/industry/" . $industry['id']);?>.html">
         <img src='<? echo base_url($industry['image']);?>' width="157" height="155" /></a>
		<p class="listContent"><? echo $industry['content'];?></p>
		<p class="clickHere"><?php echo anchor("ctc/industry/" .$industry['id'],"More..");?></p>
        
	</li>
    <?php
        $cnt++;
        if($cnt == 4){
            $cnt = 0;
            $ul = 0;
             echo '</ul>';
        }
    }
    if(($cnt > 0) && ($ul > 0)){
        echo '<ul>';
    }
    ?>
    </div>
</div>