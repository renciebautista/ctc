<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
    <?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b>Products</b>
</div>
<div id="leftContainer">
    <div id="product">
        <?php
            if(count($prodCategory))
            {
                $cnt = 0;
                $ul=0;
                foreach($prodCategory as $row)
                {
                    if($ul==0)
                    {
                        echo '<ul>';
                        $ul = 1;
                    }?>
                    <li class="list">
                        <table id="industryImageContainer" style="height:122px;">
                            <tbody>
                                <tr>
                                    <td class="picture" rowspan="3">
                                        
                                        <a href="<?php echo base_url("ctc/category/" . $row['id']);?>.html">
                                        <img width="100" height="107" src="<? echo base_url($row['image']);?>">
                                        </a>
                                    </td>
                                    <td class="title"><? echo $row['productcategory'];?></td>
                                </tr>
                                <tr>
                                    <td class="content"><? echo $row['content'];?></td>
                                </tr>
                                <tr>
                                    <td class="clickHere">
                                        <?php echo anchor("ctc/category/" .$row['id'],"More..");?>
                                    </td>               
                                </tr>
                            </tbody>
                        </table>
                    </li>
                    <?php
                    if($cnt < 1)
                    {
                        echo '<li class="list_spacers">&nbsp;</li>';
                    }
                    $cnt++;
                    if($cnt == 2)
                    {
                        $cnt = 0;
					    $ul = 0;
                        echo '</ul><div style="float: left;width:100%; height:6px;"></div>';
                    }
                }
                if($cnt > 0)
                {
                    echo '</ul><div style="float: left;width:100%; height:6px;"></div>';
                }
            }
        ?>
                    </ul>
    </div>  
</div>