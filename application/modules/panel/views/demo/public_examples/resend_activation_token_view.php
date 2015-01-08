<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Resend Account Activation Demo | flexi auth | A User Authentication Library for CodeIgniter</title>
	<meta name="description" content="flexi auth, the user authentication library designed for developers."/> 
	<meta name="keywords" content="demo, flexi auth, user authentication, codeigniter"/>
	<?php $this->load->view('includes/head'); ?> 
</head>

<body id="resend_activation_token">

<section id="body_wrap">
	<!-- Header -->  
	<?php $this->load->view('includes/header'); ?> 

	<!-- Demo Navigation -->
	<?php $this->load->view('includes/demo_header'); ?> 
	
	<!-- Intro Content -->
	<section class="content_wrap intro_bg">
		<section class="content clearfix">
			<section class="col100">
				<h2>Resend Activation Token</h2>
				<p>This demo is setup to require that users that register for a new account must activate their account via clicking a link that is emailed to them immediately upon registration.</p>
				<p>Since the user can not gain access to their account until it is activated, it is important to allow users to request for the activation email to be resent to them incase they have not received the initial activation email.</p>
			</section>		
		</section>
	</section>
	
	<!-- Main Content -->
	<section class="content_wrap main_content_bg">
		<section class="content clearfix">
			<section class="col100">
				<h2>Resend Activation Token</h2>

			<?php if (! empty($message)) { ?>
				<section class="message">
					<?php echo $message; ?>
				</section>
			<?php } ?>
				
				<?php echo form_open(current_url());?>  	
					<section class="w100 frame">
						<ul>
							<li class="info_req">
								<label for="identity">Email or Username:</label>
								<input type="text" id="identity" name="activation_token_identity" value="" class="tooltip_trigger"
									title="Please enter either your email address or username defined during registration."
								/>
							</li>
							<li>
								<label for="submit">Send Email:</label>
								<input type="submit" name="send_activation_token" id="submit" value="Submit" class="link_button large"/>
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