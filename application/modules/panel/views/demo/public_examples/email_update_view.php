<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Update Email Demo | flexi auth | A User Authentication Library for CodeIgniter</title>
	<meta name="description" content="flexi auth, the user authentication library designed for developers."/> 
	<meta name="keywords" content="demo, flexi auth, user authentication, codeigniter"/>
	<?php $this->load->view('includes/head'); ?> 
</head>

<body id="update_email">

<section id="body_wrap">
	<!-- Header -->  
	<?php $this->load->view('includes/header'); ?> 

	<!-- Demo Navigation -->
	<?php $this->load->view('includes/demo_header'); ?> 
	
	<!-- Intro Content -->
	<section class="content_wrap intro_bg">
		<section class="content clearfix">
			<section class="col100">
				<h2>Public: Change Email via Email Verification</h2>
				<p>Whilst it is possible to instantly update a users email address using the flexi auth library, if a user was to unknowingly mispell their email address, they would be unable to login at a later date, as they wouldn't know how they spelt the email address.</p>
				<p>To counter this problem, when updating the email via email verification, once the user submits their new email address, an email is sent to the user, if they do not click the verification link in that email, their account is not updated.</p>
			</section>		
		</section>
	</section>
	
	<!-- Main Content -->
	<section class="content_wrap main_content_bg">
		<section class="content clearfix">
			<section class="col100">
				<h2>Change Email via Email Verification</h2>
				<a href="<?php echo $base_url;?>auth_public/update_account">Update Account Details</a>

			<?php if (! empty($message)) { ?>
				<section class="message">
					<?php echo $message; ?>
				</section>
			<?php } ?>
				
				<?php echo form_open(current_url());	?>  	
					<section class="w100 frame">
						<ul>
							<li class="info_req">
								<label for="email_address">New Email Address:</label>
								<input type="text" id="email_address" name="email_address" value="<?php echo set_value('email_address');?>"/>
							</li>
							<li>
								<label for="submit">Update Email:</label>
								<input type="submit" name="update_email" id="submit" value="Submit" class="link_button large"/>
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