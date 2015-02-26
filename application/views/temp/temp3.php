<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
    <title>Sales Inquiry Form</title>
    <meta http-equiv="Content-Type" content="text/html; charset=us-ascii"><!-- CREATE TEXT STYLES USED IN THIS HTML FILE, START -->

    <style type="text/css">
<!--
    .header {font-family: Verdana; font-size: 12px; font-weight: bold; color: #333333; }
    .footer {font-family: Verdana; font-size: 10px; font-weight: none; color: #666666; text-decoration: none; }
    .info {font-family: Verdana; font-size: 11px; font-weight: none; color: #333333;}
    -->
    </style><!-- CREATE TEXT STYLES USED IN THIS HTML FILE, END -->
</head>

<body>
    <table width="70%" border="0" cellspacing="0" cellpadding="5">
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td bgcolor="#333333">
                            <table width="100%" border="0" cellspacing="1" cellpadding="0">
                                <tr>
                                    <td bgcolor="#FFFFFF"><!-- EMAIL HEADER, START -->
                                    <!-- EMAIL HEADER, END --></td>
                                </tr>

                                <tr>
                                    <td bgcolor="#FFFFFF">
                                        <!-- BODY CONTENT, START -->

                                        <table width="100%" border="0" cellpadding="3" cellspacing="0">
                                            <tr>
                                                <td class="info">
                                                    <p><b>Greetings from Chase Technologies Corporation!</b></p><br>

                                                    <p>We would like to acknowledge the receipt of your inquiry through our website,www.chasetech.com.Rest assured that someone from our Sales Team will get in touch with you to facilitate your query on
<b>
<?php
	if(isset($response_time)){
		echo date_format(date_create($response_time),'l, F j, Y') . ' from 09:00 to 12:00 in 3 working hours.</p>';
	}

	if(isset($response_time2)){
		echo date_format(date_create($response_time2),'l, F j, Y') . ' from 09:00 to 12:00 in 3 working hours.</p>';
	}

	if((isset($holidays) && (count($holidays)>0))){
		echo '<p><b>Note this following days are holidays or no working days:</b></p>';
		echo '<ul>';
		foreach($holidays as $row){
			echo '<li>'.$row.'</li>';
		}
		echo '</ul>';
	}

	if(isset($today)){
		$temp = explode(':',$start_time);
		if($temp[0] > 12){
			echo  $today.' from '.$start_time.' to '.$end_time.' in 3 working hours.</p>';
		}
		else{
			echo  $today.' from '.$start_time.' to '.$end_time.' in 3 working hours except lunch break (12:00 to 01:00).</p>';
		}
	}

	if(isset($saturday)){
		echo date_format(date_create($saturday),'l, F j, Y') . ' from 09:00 to 12:00 in 3 working hours.</p>';
	}
	if(isset($saturday_today)){
			echo $saturday_today.' in 3 working hours.</p>';
		}

	?></b>                                                    
                                                    </p><br>

                                                    <p>Thank you so much and have a great day ahead!</p><br>

                                                    <p>Sincerely yours,<br><br>
                                                    Chase Technologies Corporation</p><br>

                                                    <p>webmaster@chasetech.com</p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td bgcolor="#E3E3E3" class="header">Company Information</td>
                                            </tr>

                                            <tr>
                                                <td class="header">Company Name</td>
                                            </tr>

                                            <tr>
                                                <td class="info">?cname</td>
                                            </tr>

                                            <tr>
                                                <td class="header">Address</td>
                                            </tr>

                                            <tr>
                                                <td class="info">?address</td>
                                            </tr>

                                            <tr>
                                                <td class="header">Industry</td>
                                            </tr>

                                            <tr>
                                                <td class="info">?type</td>
                                            </tr>

                                            <tr>
                                                <td class="header">Others (Pls. Specify)</td>
                                            </tr>

                                            <tr>
                                                <td class="info">?others</td>
                                            </tr>

                                            <tr>
                                                <td bgcolor="#E3E3E3" class="header">Contact Information</td>
                                            </tr>

                                            <tr>
                                                <td class="header">Name</td>
                                            </tr>

                                            <tr>
                                                <td class="info">?name</td>
                                            </tr>

                                            <tr>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td class="header">Cell phone No.</td>
                                            </tr>

                                            <tr>
                                                <td class="info">?mobile</td>
                                            </tr>

                                            <tr>
                                                <td class="header">Landline</td>
                                            </tr>

                                            <tr>
                                                <td class="info">?line</td>
                                            </tr>

                                            <tr>
                                                <td class="header">Email Address</td>
                                            </tr>

                                            <tr>
                                                <td class="info">?email</td>
                                            </tr>

                                            <tr>
                                                <td bgcolor="#E3E3E3" class="header">Product Of Interest</td>
                                            </tr>

                                            <tr>
                                                <td class="info">
                                                    <p>?product</p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="header">&nbsp;</td>
                                            </tr>

                                             <tr>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td class="footer">www.chasetech.com | webmaster@chasetech.com</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h3 style="text-align: center;color: #333333;">THIS IS A SYSTEM GENERATED EMAIL DO NOT REPLY TO THIS EMAIL</h3>
                                                </td>
                                            </tr>
                                        </table><!-- BODY CONTENT, END -->
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
