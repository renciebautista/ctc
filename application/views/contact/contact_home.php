
<div id="example_1_container" class="easy_slides_container"></div>

<div id="PanelTitle" class="smallTitle">
    <?php echo anchor("","Home", array('class' => 'sitemap'));?>&nbsp;\&nbsp;<b>Contact Us</b>
</div>

<div id="leftContainer">
    <div id='contact_us'  class="block">
        <?php 
            $class = array('green','red','blue','violet', 'yellow');
            $i=0;
         ?>
        <?php foreach ($groups as $group) :?>
            <div class="group <?php echo $class[$i]; ?>">
                <div class="title <?php echo $class[$i]; ?>"><h2><?php echo strtoupper($group['group']) ?></h2></div>
                <?php if(count($group['sub_group']) > 0): ?>
                <ul>
                <?php foreach ($group['sub_group'] as $sub_group): ?>
                    <li><a href="<?php echo base_url('contact/'. $sub_group['slug']); ?>"><?php echo $sub_group['sub_group']; ?></a></li>
                <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
            <?php $i++; ?>
        <?php endforeach; ?>  
    </div>
    
<!--     <div class="clear_both">
        <a  class="title" href="<?php //echo base_url('contact/customer_assistance'); ?>">CUSTOMER ASSISTANCE</a>
    </div> -->
    <div class="clear_both_2">
        <a class="title" href="<?php echo base_url('contact/employee'); ?>">EMPLOYEE VERIFICATION</a>
    </div>
</div>

