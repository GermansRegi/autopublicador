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


<section class="page-head">
  <section class="container">
    <section class="row">
      <section class="col-md-12">
        <h2>Recuperación de contraseña</h2>
        <h4>something goes here</h4>
      </section>
    </section>
  </section>


</section>

<section class="content">
  <section class="container">
    <section class="row">
    <section class="col-md-6">
                  <section class="formy well">
                    <!-- Title -->
                     <h4 class="title">Introduzca su correo electrónico</h4>
                      <p>&nbsp;</p>
                                  <section class="form">

                                      <!-- Login form (not working)-->
                                      <?php if (! empty($message)) { ?>
										<section id="infoMessage">
											<?php echo $message; ?>
										</section>
									<?php } ?>
                                     <?php echo form_open("panel/forgotten_password",array('class'=>'form-horizontal','role'=>'form'));?>

                                         <section class="form-group">
 											<label for="identity" class="col-lg-4 control-label">Correo electrónico</label>
                                           <section class="col-lg-6	">

                                            <input type="text" id="identity" name="forgot_password_identity" value="" class="form-control"
									title="Por favor introduzca el correo electrónico con el que se registró."
								/>
        									<?php //echo form_input($email);?>
                                           </section>
                                         </section>
                                         <section class="form-group">
                                           <section class="col-lg-offset-2 col-lg-10">

                                             	<input type="submit" name="send_forgotten_password" id="submit" value="Enviar" class="btn btn-default"/>
                                             <button type="reset" class="btn btn-default">Borrar</button>
                                           </section>
                                         </section>
                                       </form>
                                      </section>
                                      </section>


    </section>
  </section>
</section>
	<!-- Main Content --
	<section class="content_wrap main_content_bg">
		<section class="content clearfix">
			<section class="col100">
				<h2>Forgotten Password</h2>

			<?php if (! empty($message)) { ?>
				<section class="message">
					<?php echo $message; ?>
				</section>
			<?php } ?>

				<?php echo form_open(current_url());	?>
					<section class="w100 frame">
						<ul>
							<li class="info_req">
								<label for="identity">Email or Username:</label>
								<input type="text" id="identity" name="forgot_password_identity" value="" class="tooltip_trigger"
									title="Please enter either your email address or username defined during registration."
								/>
							</li>
							<li>
								<label for="submit">Send Email:</label>
								<input type="submit" name="send_forgotten_password" id="submit" value="Submit" class="link_button large"/>
								<small>Note: By default, this demo is set so that the password must be reset within 15 minutes of the 'forgotten password' email being sent.</small>
							</li>
						</ul>
					</section>
				<?php echo form_close();?>
			</section>
		</section>
	</section>

<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>

</body>
</html>