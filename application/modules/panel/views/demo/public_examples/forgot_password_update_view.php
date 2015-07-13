<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Update Forgotten Password Demo | flexi auth | A User Authentication Library for CodeIgniter</title>
	<meta name="description" content="flexi auth, the user authentication library designed for developers."/> 
	<meta name="keywords" content="demo, flexi auth, user authentication, codeigniter"/>
	<?php $this->load->view('includes/head'); ?> 
</head>

<body id="change_forgot_password">

<section id="body_wrap">
	<!-- Header -->  
	<?php $this->load->view('includes/header'); ?> 

	<!-- Demo Navigation -->
	<?php $this->load->view('includes/demo_header'); ?> 
	
	<!-- Intro Content -->
	<section class="content_wrap intro_bg">
		<section class="content clearfix">
			<section class="col100">
				<h2>Change Forgotten Password</h2>
				<p>This page is accessed via clicking on a link within a 'forgotten password' email.</p>
				<p>Whereas a typical 'updated password' page would require the user to verify their identity via entering their current password, in the situation when the user has forgotten their password, this obviously isn't possible.</p>
				<p>Therefore, by clicking the link in their 'forgotten password' email, they have verified they have access to that email account, the link then contains a validation token that is verified to match a token generated in the users account when they requested they had forgotten their password, provided the token is valid, the user can then manually set their new password.</p>
			</section>		
		</section>
	</section>
	
	<!-- Main Content -->
	<section class="content_wrap main_content_bg">
		<section class="content clearfix">
			<section class="col100">
				<h2>Change Forgotten Password</h2>

			<?php if (! empty($message)) { ?>
				<section class="message">
					<?php echo $message; ?>
				</section>
			<?php } ?>
				
				<?php echo form_open(current_url());	?>  	
					<section class="w100 frame">
						<ul>
							<li>
								<small>
									<strong>For this demo, the following validation settings have been defined:</strong><br/>
									Password length must be more than <?php echo $this->flexi_auth->min_password_length(); ?> characters in length.<br/>Only alpha-numeric, dashes, underscores, periods and comma characters are allowed.
								</small>
							</li>
							<li class="info_req">
								<label for="new_password">New Password:</label>
								<input type="password" id="new_password" name="new_password" value=""/>
							</li>
							<li class="info_req">
								<label for="confirm_new_password">Confirm New Password:</label>
								<input type="password" id="confirm_new_password" name="confirm_new_password" value=""/>
							</li>
							<li class="info_req">
								<label for="submit">Change Password:</label>
								<input type="submit" name="change_forgotten_password" id="submit" value="Submit" class="link_button large"/>
							</li>
						</ul>
					</section>
				<?php echo form_close();?>
			</section>
		</section>
	</section>	
	
	<!-- Footer -->  
	<?php $this->load->view('includes/footer'); ?> 
</section>

<!-- Scripts -->  
<?php $this->load->view('includes/scripts'); ?> 

</body>
</html>