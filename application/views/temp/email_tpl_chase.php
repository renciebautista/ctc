<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Service Request Form</title>
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
													<p><b>Date of Inquiry : </b><?php echo $date_inquiry; ?></p><br>
													<p>Dear Chase Technologies Corporation,</p><br>

<?php
	$strx = "A "; 
	$itype = strtolower($info_type[0]) ;
	$arr= array('a','e','i','o','u');
	if (in_array($itype,$arr)){$strx = "An ";}
?>
<p><?php echo $strx.$info_type ; ?> was submitted in our site with this following information. Kindly process this request on <b style="color: #A70000;">
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
<br>
													<p>Thank you so much and have a great day ahead!</p>
<br>
 <p>Thank you,</p><br

                                                    <p>webmaster@chasetech.com</p>
<br>
													<p>This is a system generated email, do not reply to this email id.</p>
												</td>
											</tr>

											<tr>
												<td>&nbsp;</td>
											</tr>

											<tr>
												<td bgcolor="#E3E3E3" class="header">Client Information</td>
											</tr>

											<tr>
												<td class="header">Date Created</td>
											</tr>

											<tr>
												<td class="info"><?php echo $date_created;?></td>
											</tr>

											<tr>
												<td class="header">Company Name</td>
											</tr>

											<tr>
												<td class="info"><?php echo $company;?></td>
											</tr>

											<?php if(!empty($store)): ?>
												<tr>
													<td class="header">Store/Branch Name</td>
												</tr>
												<tr>
													<td class="info"><?php echo $store; ?></td>
												</tr>
											<?php else: ?>
											<?php endif; ?>

											<?php if(!empty($address)): ?>
											<tr>
												<td class="header">Address</td>
											</tr>
											<tr>
												<td class="info"><?php echo $address; ?></td>
											</tr>
											<?php else: ?>
											<?php endif; ?>

											<tr>
												<td class="header">Contact Person</td>
											</tr>

											<tr>
												<td class="info"><?php echo $c_person; ?></td>
											</tr>

											<tr>
												<td class="header">Contact Number</td>
											</tr>

											<tr>
												<td class="info"><?php echo $c_number; ?></td>
											</tr>

											<?php if(isset($landline)): ?>

											<tr>
												<td class="header">Landline No. </td>
											</tr>

											<tr>
												<td class="info"><?php echo $landline; ?></td>
											</tr>

											<?php endif; ?>

											<tr>
												<td class="header">Email Address</td>
											</tr>

											<tr>
												<td class="info"><?php echo $email; ?></td>
											</tr>

											<?php if(isset($purpose)): ?>
											<tr>
												<td class="header">Purpose</td>
											</tr>
											<tr>
												<td class="info"><?php echo $purpose; ?></td>
											</tr>
											<?php endif; ?>

											<?php if(isset($salesorder)): ?>

											<tr>
												<td class="header">Sales Order</td>
											</tr>

											<tr>
												<td class="info"><?php echo $salesorder; ?></td>
											</tr>

											<?php endif; ?>

											<?php if(!empty($dept)): ?>
											<tr>
												<td bgcolor="#E3E3E3" class="header">Chase Representative Information</td>
											</tr>
											<?php endif; ?>

											<?php if(!empty($assigned)): ?>
											<tr>
												<td class="header">CTC AE Assigned</td>
											</tr>
											<tr>
												<td class="info"><?php echo $assigned; ?></td>
											</tr>
											<?php endif; ?>

											<?php if(!empty($dept)): ?>
											<tr>
												<td class="header">Department</td>
											</tr>
											<tr>
												<td class="info"><?php echo $dept; ?></td>
											</tr>
											<?php endif; ?>

											<?php if(!empty($inquired)): ?>
											<tr>
												<td class="header">Products Inquired</td>
											</tr>
											<tr>
												<td class="info"><?php echo $inquired; ?></td>
											</tr>
											<?php else: ?>
											<?php endif; ?>

											<?php if(!empty($q_date)): ?>
											<tr>
												<td class="header">Expected Date of Quotation</td>
											</tr>
											<tr>
												<td class="info"><?php echo $q_date; ?></td>
											</tr>
											<?php else: ?>
											<?php endif; ?>

											<?php if(!empty($demodate)): ?>
											<tr>
												<td class="header">Expected Date of Demo</td>
											</tr>
											<tr>
												<td class="info"><?php echo $demodate; ?></td>
											</tr>
											<?php else: ?>
											<?php endif; ?>

											<?php if(!empty($attendees)): ?>
											<tr>
												<td class="header">Expected No. of Attendees</td>
											</tr>
											<tr>
												<td class="info"><?php echo $attendees; ?></td>
											</tr>
											<?php else: ?>
											<?php endif; ?>

											<?php if(!empty($ttime)): ?>
											<tr>
												<td class="header">Best Time to Return Call</td>
											</tr>
											<tr>
												<td class="info"><?php echo $ttime; ?></td>
											</tr>
											<?php else: ?>
											<?php endif; ?>

											<?php if(!empty($personnel)): ?>
											<tr>
												<td class="header">CTC Personnel to Return Call</td>
											</tr>
											<tr>
												<td class="info"><?php echo $personnel; ?></td>
											</tr>
											<?php else: ?>
											<?php endif; ?>

											<?php if(!empty($industry)): ?>
											<tr>
												<td class="header">Industry</td>
											</tr>
											<tr>
												<td class="info"><?php echo $industry; ?></td>
											</tr>
											<?php else: ?>
											<?php endif; ?>

											<?php if(!empty($others)): ?>
											<tr>
												<td class="header">Others</td>
											</tr>
											<tr>
												<td class="info"><?php echo $others; ?></td>
											</tr>
											<?php else: ?>
											<?php endif; ?>

											<?php if(!empty($refno)): ?>
											<tr>
												<td class="header">Reference Number(PO/SO)</td>
											</tr>
											<tr>
												<td class="info"><?php echo $refno; ?></td>
											</tr>
											<?php else: ?>
											<?php endif; ?>

											<?php if(!empty($delivery)): ?>
											<tr>
												<td class="header">Expected Delivery Date</td>
											</tr>
											<tr>
												<td class="info"><?php echo $delivery; ?></td>
											</tr>
											<?php else: ?>
											<?php endif; ?>

											<!-- <tr>
												<td bgcolor="#E3E3E3" class="header">Product Problem Category</td>
											</tr>

											<tr>
												<td class="info">
													<p>?category</p>
												</td>
											</tr> -->
											<?php if(isset($form1)): ?>
											<tr>
												<td bgcolor="#E3E3E3" class="header"><?php echo $form1['desc']; ?></td>
											</tr>

											<tr>
												<td class="info">
													<p><?php echo nl2br($form1['details']) ; ?></p>
												</td>
											</tr>
											<?php endif; ?>

											<?php if(isset($form2)): ?>
											<tr>
												<td bgcolor="#E3E3E3" class="header"><?php echo $form2['desc']; ?></td>
											</tr>

											<tr>
												<td class="info">
													<p><?php echo nl2br($form2['details']); ?></p>
												</td>
											</tr>
											<?php endif; ?>


										<?php if(isset($form3)): ?>
											<tr>
												<td bgcolor="#E3E3E3" class="header"><?php echo $form3['desc']; ?></td>
											</tr>

											<tr>
												<td class="header">Project / Client Name</td>
											</tr>
											<tr>
												<td class="info"><?php echo $form3['project']; ?></td>
											</tr>

											<tr>
												<td class="header">No. of Man Power</td>
											</tr>
											<tr>
												<td class="info"><?php echo number_format($form3['no_man']); ?></td>
											</tr>

											<tr>
												<td class="header">Start Date</td>
											</tr>
											<tr>
												<td class="info"><?php echo $form3['start_date']; ?></td>
											</tr>

											<tr>
												<td class="header">End Date</td>
											</tr>
											<tr>
												<td class="info"><?php echo $form3['end_date']; ?></td>
											</tr>
											<tr>
												<td class="header">Skills Required</td>
											</tr>
											<tr>
												<td class="info">
														<p><?php echo $form3['info']; ?></p>
													</td>
											</tr>

										<?php endif; ?>


											<?php if(isset($problem)): ?>
												<tr>
													<td bgcolor="#E3E3E3" class="header">Problem Description</td>
												</tr>
												<tr>
													<td class="info">
														<p><?php echo $problem; ?></p>
													</td>
												</tr>
											<?php endif; ?>






											<?php if(isset($notes)): ?>
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td bgcolor="#E3E3E3" class="header">Notes</td>
											</tr>
											<?php foreach ($notes as $row): ?>
											<tr>
												<td class="info">
													<p><?php echo nl2br($row['notes']); ?></p>
												</td>
											</tr>
											<?php endforeach; ?>
											<?php endif; ?>
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
                                                <td class="footer">IP Address : <?php echo $ip_address; ?></td>
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
