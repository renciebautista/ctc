<div id="contents">
<div id="example_1_container" class="easy_slides_container"></div>
<div id="whatwedo">
<p>WHAT WE DO?</p>
<table id="whatwedo" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <?php
                if(count($whatwedo))
                {
                    $num_rows =count($whatwedo);
					$mod = $num_rows % 2;
					$cnt = ceil($num_rows / 2);
					$lpcnt = 0;
					$sp = 0;
                    foreach ($whatwedo as $row)
                    {
                        if($sp == 0)
						{
							echo '<td class="spacer">&nbsp;</td>
                                <td style="width:288px;">
                                <ul>';
							$sp = 1;
						}
                        echo '<li>';

                        //echo anchor("whatwedo/" .$row['id'],$row['whatwedo']);
						?>
						  <a href="<?php echo base_url('ctc/whatwedo/');?>/#<?php echo $row['id'];?>"><?php echo $row['whatwedo'];?></a>
						<?
                        echo '</li>';
                        $lpcnt++;
                        if($lpcnt == $cnt )
                        {
                            echo '</ul></td>';
							$lpcnt = 0;
							$sp = 0;
                        }
                    }
                }
            ?>
        </tr>
    </tbody>
</table>
</div>
<span class="spacer">spacer</span>
</div>
