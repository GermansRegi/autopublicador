<!DOCTYPE html>
<head>

    <title>Autopublicador Social</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8" />

  <?php echo $this->load->view('includes2/head');?>


</head>

<body>
    <?php echo $this->load->view('includes2/header');

?>



<section class="content">
  <section class="container">
    <section class="row">
      <section class="col-md-6">
        <!-- Some content -->
                  <h3 class="title">Regístrese Hoy <span class="color">!!!</span></h3>
                  <h4>Morbi tincidunt posuere turpis eu laoreet</h4>
                  <p>Nullam in est urna. In vitae adipiscing enim. Curabitur rhoncus condimentum lorem, non convallis dolor faucibus eget. In vitae adipiscing enim. Curabitur rhoncus condimentum lorem, non convallis dolor faucibus eget. In ut nulla est. </p>
                  <h5>Maecenas hendrerit neque id</h5>
                  <ul>
                    <li>Etiam adipiscing posuere justo, nec iaculis justo dictum non</li>
                    <li>Cras tincidunt mi non arcu hendrerit eleifend</li>
                    <li>Aenean ullamcorper justo tincidunt justo aliquet et lobortis diam faucibus</li>
                    <li>Maecenas hendrerit neque id ante dictum mattis</li>
                    <li>Vivamus non neque lacus, et cursus tortor</li>
                  </ul>

                  <p>Nullam in est urna. In vitae adipiscing enim. In ut nulla est. Nullam in est urna. In vitae adipiscing enim. Curabitur rhoncus condimentum lorem, non convallis dolor faucibus eget. In ut nulla est. </p>

                </section>

                <!-- Form -->
                <section class="col-md-6">
                  <section class="form well">
                    <!-- Title -->
                     <h4 class="title">Crear una nueva cuenta</h4>
            <p>&nbsp;</p>
                                  <section class="form">
                          	<?php if (! empty($message)) { ?>
									<section id="infoMessage">
								<?php echo $message; ?>
								</section>
						<?php } ?>                   <!-- Register form (not working)-->
                      <?php echo form_open("panel/register_account",array('class'=>'form-horizontal','role'=>'form'));?>
                       <section class="form-group">
                            <label for="first_name" class="col-lg-4 control-label">Nombre</label>
                         <section class="col-lg-6">
                         <input type="text" id="first_name" name="register_first_name" class="form-control" placeholder="Nombre" value="<?php echo set_value('register_first_name');?>"/>
                        <!--  <?php echo form_input($first_name,'','');?> -->

                         </section>
                       </section>
                       <section class="form-group">
                          <label for="password" class="col-lg-4 control-label">Apellidos</label>
                         <section class="col-lg-6">

                        	<input type="text" id="last_name" name="register_last_name" class="form-control" placeholder="Apellidos" value="<?php echo set_value('register_last_name');?>"/>
                         </section>
                       </section>
                       <section class="form-group">
                        <label for="first_name" class="col-lg-4 control-label">Correo Electronico</label>
                       <!--  <?php echo lang('create_user_email_label', 'email');?> -->
                         <section class="col-lg-6">
                         <input type="text" id="email_address" class="form-control" placeholder="Correo electrónico" name="register_email_address" value="<?php echo set_value('register_email_address');?>" class="tooltip_trigger"
									title="This demo requires that upon registration, you will need to activate your account via clicking a link that is sent to your email address."
								/>
                    <!--      <?php echo form_input($email,'','class="form-control" placeholder="Correo electrónico"');?> -->
                         </section>
                       </section>
                       <section class="form-group">
							  <label for="first_name" class="col-lg-4 control-label">Contraseña</label>
                  <!--   <?php echo lang('create_user_password_label', 'password');?> -->
                         <section class="col-lg-6">
                         	<input type="password" id="password" class="form-control" placeholder="Contraseña" name="register_password" value="<?php echo set_value('register_password');?>"/>
                   <!--  <?php echo form_input($password,'','class="form-control" placeholder="Contraseña"');?> -->
                         </section>
                       </section>
                       <section class="form-group">

                <!--      <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> -->
                	  <label for="first_name" class="col-lg-4 control-label">Confirmación contraseña</label>
                         <section class="col-lg-6 aligninput">
                         <input class="form-control" placeholder="Confirmación contraseña" type="password" id="confirm_password" name="register_confirm_password" value="<?php echo set_value('register_confirm_password');?>"/>
                   <!--   <?php echo form_input($password_confirm,'','class="form-control" placeholder="Confirmar contraseña"');?> -->
                         </section>
                       </section>

                       <section class="form-group">
                         <section class="col-lg-offset-2 col-lg-6">
                         <section class="checkbox">
                           <label>
                           <input name="register_terms_and_conditions" type="checkbox"> Acepto los Términos &amp; Condiciones
                           </label>
                         </section>
                         </section>
                       </section>
                       <section class="form-group">
                         <section class="col-lg-offset-2 col-lg-8">
                      <!--    <button type="submit" class="btn btn-default">Registrarse</button>
 -->                         <input type="submit" name="register_user" id="submit" value="Registrarse" class="btn btn-default"/>
                         <button type="reset" class="btn btn-default">Borrar</button>
                         </section>
                       </section>
                       </form>
                       <hr>

                                             Ya tiene una cuenta? <a href="<?php echo base_url()?>login">Acceder</a>
                                    </section>
                                  </section>

                </section>
    </section>
  </section>
</section>

	<!-- Demo Navigation -
	<?php $this->load->view('includes/demo_header'); ?>

	<!-- Intro Content -
	<section class="content_wrap intro_bg">
		<section class="content clearfix">
			<section class="col100">
				<h2>Register Account</h2>
				<p>User registation is a core requirement for any site that is to allow anonymous users to register for an account within the site.</p>
				<p>The data collected and saved during this process will always vary from site to site, but typically comes down to two primary types, data that is essential for user authentication and then user profile data.</p>
				<p>The essential user authentication data consists of information like a users email address and password that are required by users to securely log into their account. In addition to this, the flexi auth library can also automatically save and manage user data like IP addresses, last login dates etc.</p>
				<p>As for the user profile data, flexi auth allows you to save and relate whatever data you require to the users account, whether that data is all stored in the same table, or via multiple tables. The design of the database schema is up to you.</p>
			</section>
		</section>
	</section>

	<!-- Main Content -
	<section class="content_wrap main_content_bg">
		<section class="content clearfix">
			<section class="col100">
				<h2>Register Account</h2>

			<?php if (! empty($message)) { ?>
				<section class="message">
					<?php echo $message; ?>
				</section>
			<?php } ?>

				<?php echo form_open(current_url()); ?>
					<fieldset>
						<legend>Personal Details</legend>
						<ul>
							<li class="info_req">
								<label for="first_name">First Name:</label>
								<input type="text" id="first_name" name="register_first_name" value="<?php echo set_value('register_first_name');?>"/>
							</li>
							<li class="info_req">
								<label for="last_name">Last Name:</label>
								<input type="text" id="last_name" name="register_last_name" value="<?php echo set_value('register_last_name');?>"/>
							</li>
						</ul>
					</fieldset>

					<fieldset>
						<legend>Contact Details</legend>
						<ul>
							<li class="info_req">
								<label for="phone_number">Phone Number:</label>
								<input type="text" id="phone_number" name="register_phone_number" value="<?php echo set_value('register_phone_number');?>"/>
							</li>
							<li>
								<label for="newsletter">Subscribe to Newsletter:</label>
								<input type="checkbox" id="newsletter" name="register_newsletter" value="1" <?php echo set_checkbox('register_newsletter',1);?>/>
							</li>
						</ul>
					</fieldset>

					<fieldset>
						<legend>Login Details</legend>
						<ul>
							<li class="info_req">
								<label for="email_address">Email Address:</label>
								<input type="text" id="email_address" name="register_email_address" value="<?php echo set_value('register_email_address');?>" class="tooltip_trigger"
									title="This demo requires that upon registration, you will need to activate your account via clicking a link that is sent to your email address."
								/>
							</li>
							<li class="info_req">
								<label for="username">Username:</label>
								<input type="text" id="username" name="register_username" value="<?php echo set_value('register_username');?>" class="tooltip_trigger"
									title="Set a username that can be used to login with."
								/>
							</li>
							<li>
								<small>
									<strong>For this demo, the following validation settings have been defined:</strong><br/>
									Password length must be more than <?php echo $this->flexi_auth->min_password_length(); ?> characters in length.<br/>Only alpha-numeric, dashes, underscores, periods and comma characters are allowed.
								</small>
							</li>
							<li class="info_req">
								<label for="password">Password:</label>
								<input type="password" id="password" name="register_password" value="<?php echo set_value('register_password');?>"/>
							</li>
							<li class="info_req">
								<label for="confirm_password">Confirm Password:</label>
								<input type="password" id="confirm_password" name="register_confirm_password" value="<?php echo set_value('register_confirm_password');?>"/>
							</li>
						</ul>
					</fieldset>

					<fieldset>
						<legend>Register</legend>

						<ul>
							<li>
								<h6>Important Note</h6>
								<small>The data saved via this demo is available for anyone else using the demo to see, therefore, you may wish to only test this registration page via your local development environment. All data that is saved via this demo, is completely wiped every few hours.</small>
							</li>
							<li>
								<hr/>
								<label for="submit">Register:</label>
								<input type="submit" name="register_user" id="submit" value="Submit" class="link_button large"/>
							</li>
						</ul>
					</fieldset>
				<?php echo form_close();?>
			</section>
		</section>
	</section>

	<!-- Footer -->
	<?php $this->load->view('includes2/footer'); ?>
</section>

<!-- Scripts -->
<?php $this->load->view('includes2/scripts'); ?>

</body>
</html>