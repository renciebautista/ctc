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
													<p><b>Greetings from Chase Technologies Corporation!</b></p><br>

<p>This is to confirm the receipt of your <?php echo $info_type ; ?> with a <b>Request # <?php echo str_pad($request_id,10,'0',STR_PAD_LEFT);?></b>. Rest assured that this request will be forwarded to the proper concerning department. Meanwhile, please do expect a call from one of our technical representatives to further discuss your reported concern's on <b>
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
													<p>Chase Technologies Corporation
<br>
													<p>This is a system generated email, do not reply to this email id.</p>
												</td>
											</tr>

											<tr>
												<td>&nbsp;</td>
											</tr>

											<tr>
												<td bgcolor="#E3E3E3" class="header">Request Information</td>
											</tr>

											<tr>
												<td class="header">Date Created</td>
											</tr>

											<tr>
												<td class="info"><?php echo $date_created;?></td>
											</tr>

											<tr>
												<td class="header">Client Name</td>
											</tr>

											<tr>
												<td class="info"><?php echo $client;?></td>
											</tr>

											<tr>
												<td class="header">Sales Order # </td>
											</tr>

											<tr>
												<td class="info"><?php echo $salesorder; ?></td>
											</tr>

											<tr>
												<td class="header">Requested By</td>
											</tr>

											<tr>
												<td class="info"><?php echo $requestor; ?></td>
											</tr>

											

											<tr>
												<td class="header">Email Address</td>
											</tr>

											<tr>
												<td class="info"><?php echo $email; ?></td>
											</tr>

											<tr>
												<td bgcolor="#E3E3E3" class="header">Item List</td>
											</tr>

												<td>
													<table>
														<tbody>
															<tr>
																<th style="text-align:center; width:100px;">Barcode</th>
																<th style="text-align:center; width:300px;">Description</th>
																<th style="text-align:right; width:100px;">Qty</th>
																<th style="text-align:center; width:300px;">Remarks</th>
															</tr>
															<?php for($x = 0; $x < count($barcode); $x++): ?>
															<tr>
																<td><?php echo $barcode[$x]; ?></td>
																<td><?php echo $desc[$x]; ?></td>
																<td style="text-align:right; width:100px;"><?php echo $qty[$x]; ?></td>
																<td><?php echo $remarks[$x]; ?></td>
															</tr>
															<?php endfor; ?>
														</tbody>
													</table>
												</td>


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
