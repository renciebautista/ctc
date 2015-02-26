<div id="example_1_container" class="easy_slides_container"></div>
<div id="PanelTitle" class="smallTitle">
    <?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<?php echo anchor("ctc/product","Products",array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b><? echo $categoryname['productcategory'];?></b>
</div>
<div id="leftContainer">
    <div id="product">
        <?php

            if(count($products))
            {
                $cnt = 0;
                $ul=0;
                foreach($products as $row)
                {
                    if($ul==0)
                    {?>
                        <ul>
                        <?$ul = 1;
                    }?>
                    <li class="list">
                        <table id="industryImageContainer" style="height:122px;">
                            <tbody>
                                <tr>
                                    <td class="picture" rowspan="3">
                                        
                                        <a href="<?php echo base_url("ctc/product/" . $row['id']);?>.html">
                                        <img width="100" height="107" src="<? echo base_url($row['image']);?>">
                                        </a>
                                    </td>
                                    <td class="title"><? echo $row['products'];?></td>
                                </tr>
                                <tr>
                                    <td class="content"><? echo $row['content'];?></td>
                                </tr>
                                <tr>
                                    <td class="clickHere">
										<div style="width:50%;float:left;text-align:left;">
											<?php echo anchor("ctc/product/" .$row['id'],"More Details...");?>
										</div>
										<div  style="width:50%;float:left; text-align:right;">
											<a class="basket" href="<?php echo base_url('ctc/addtoBasket/'.$row['id']);?>" onClick="javascript:return false;" id="<?php echo $row['id'];?>">Add to Inquiry</a>
										</div>
                                        
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