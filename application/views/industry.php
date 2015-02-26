<div id="example_1_container" class="easy_slides_container">                  
</div>
<div id="PanelTitle" class="smallTitle">
<?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<?php echo anchor("ctc/industry","Industry Solutions",array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b><? echo $industryCategory['industrycategory'];?></b>
</div>
<div id="leftContainer">
    <div id="contentInfo">
        <?php
            $strcontent = $industryCategory['contentheader'];
            $header =first_sentence($strcontent);
            $hlen = strlen($header);
            $maxlen = strlen($strcontent);
            $bodymax = substr($strcontent,$hlen,$maxlen);
            $bodymin = firstsecond_sentence($bodymax);
        ?>
        
        <span><? echo $header;?></span>
        <div id="showntext" class="unhidden">
            <p class="indent"><? echo $bodymin;?></p>
            <p class="shiftRight">
            <a href="javascript:unhide('hiddentext'); javascript:unhide('showntext');">More...</a>
            </p>
        </div>
        <div id="hiddentext" class="hidden">
            <p class="indent"><? echo $bodymax;?></p>
            <p class="shiftRight">
            <a href="javascript:unhide('hiddentext'); javascript:unhide('showntext');">Minimize</a>
            </p>
      </div>
    </div>
    <div id="product">
    <?php
        $cnt = 0;
        $ul=0;
        foreach($categorylist as $list){
            if($ul == 0){
                echo '<ul>';
                $ul = 1;
            }?>
            <li class="list">
                <table id="industryImageContainer" style="height:122px;">
                    <tbody>
                        <tr>
                            <td class="picture" rowspan="3">
                                <a href="<?php echo base_url("ctc/solution/" . $list['id']);?>.html">
                                   <img width="100" height="107" src='<? echo base_url($list['image']);?>'>
                                </a>
                            </td>
                            <td class="title"><? echo $list['industry'];?></td>
                        </tr>
                        <tr>
                            <td class="content"><? echo $list['content'];?></td>
                        </tr>
                        <tr>    
                             <td class="clickHere">
                               <?php echo anchor("ctc/solution/" .$list['id'],"More..");?>
                             </td>               
                        </tr>
                    </tbody>
                </table>
            </li>
        <?
            if($cnt < 1){
                echo '<li class="list_spacers">&nbsp;</li>';
            }
            $cnt++;
            if($cnt == 2){
                $cnt = 0;
                $ul = 0;
                echo '</ul><div style="float: left;width:100%; height:6px;"></div>';
            }
        }
        if($cnt > 0){
             echo '</ul><div style="float: left;width:100%; height:6px;"></div>';
        }
    ?>
    </div>
</div>