<html>
	<body>
		<table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td bgcolor="#ececec" align="center">
						<table width="640" cellspacing="0" cellpadding="0" border="0" style="margin:0 10px">
							<tbody>
								<tr>
									<td width="640" bgcolor="#ececec" height="30"></td>
								</tr>
								<tr>
									<td width="640" bgcolor="#4b4c44" height="20"></td>
								</tr>
								<tr>
									<td width="640" bgcolor="#ffffff" height="30"></td>
								</tr>
								<tr>
									<td width="640" bgcolor="#ffffff">
										<table width="640" cellspacing="0" cellpadding="0" border="0">
											<tbody>
												<tr>
													<td width="30"></td>
													<td width="580">
														<table width="580" cellspacing="0" cellpadding="0" border="0">
															<tbody>
																<tr>
																	<td width="580">
																		<section align="justify">
																			<h1>Change of Email Address from <?php echo $current_email;?> to <?php echo $new_email;?></h1>
																			<p>Please click this link to <?php echo anchor('auth_public/update_email/'.$user_id.'/'.$update_email_token, 'confirm changing your email to this address');?>.</p>
																		</section>
																	</td>
																</tr>
																<tr>
																	<td width="580" height="10"></td>
																</tr>
															</tbody>
														</table>
													</td>
													<td width="30"></td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<tr>
									<td width="640" bgcolor="#ffffff" height="15"></td>
								</tr>
								<tr>
									<td width="640" bgcolor="#4b4c44" height="20"></td>
								</tr>
								<tr>
									<td width="640" bgcolor="#ececec" height="30"></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</body>
</html>