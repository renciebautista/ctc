
<div class="chromestyle" id="chromemenu">
  <ul>
    <li><?php echo anchor("","Home");?></li>
    <li><?php echo anchor("ctc/product","Products", array('rel' => 'dropmenu1'));?> </li>
    <li><?php echo anchor("ctc/industry","Industry Solutions",array('rel' => 'dropmenu2'));?> </li>
    <li><?php echo anchor("ctc/whatwedo","What We Do",array('rel' => 'dropmenu3'));?> </li>
    <li><?php echo anchor("ctc/profile","Company Profile");?> </li>
         <li><?php echo anchor("ctc/agreement","Terms and Conditions");?> </li>
    <li><?php echo anchor("ctc/career","Careers");?> </li>

    <li><?php echo anchor("contact","Contact Us");?></li>
  </ul>
</div>

<div id="dropmenu1" class="dropmenudiv" style="padding-left:5px; padding-right:5px;">
  <?php
    if(count($prodCategory))
       {
        foreach ($prodCategory as $row)
        {
          echo anchor("ctc/category/" . $row['id'],$row['productcategory']);
        }
       }
  ?>
</div>

<div id="dropmenu2" class="dropmenudiv" style="padding-left:5px; padding-right:5px;">
  <?php
    if(count($indCategory))
       {
        foreach ($indCategory as $row)
        {
          echo anchor("ctc/industry/" . $row['id'],$row['industrycategory']);
        }
       }
  ?>
</div>

<div id="dropmenu3" class="dropmenudiv" style="padding-left:5px; padding-right:5px;">
  <?php
    if(count($whatwedo))
       {
        foreach ($whatwedo as $row)
        {
          //echo anchor("ctc/whatwedo/" . $row['id'],$row['whatwedo']);
          ?>
          <a href="<?php echo base_url('ctc/whatwedo/');?>/#<?php echo $row['id'];?>"><?php echo $row['whatwedo'];?></a>
          <?
        }
       }
  ?>
</div>

<div id="dropmenu4" class="dropmenudiv" style="padding-left:5px; padding-right:5px;">
  <?php
    echo anchor('ctc/salesinquiry','Sales Inquiry Form');
    echo anchor('ctc/servicerequest','Service Request Form');
  ?>
</div>




