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


<div class="page-head">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2>Recuperación de contraseña</h2>
        <h4>something goes here</h4>
      </div>
    </div>
  </div>


</div>

<div class="content">
  <div class="container">
    <div class="row">
    <div class="col-md-6">
                  <div class="formy well">
                    <!-- Title -->
                     <h4 class="title">Introduzca su correo electrónico</h4>
                      <p>&nbsp;</p>
                                  <div class="form">

                                      <!-- Login form (not working)-->
                                      <?php if (! empty($message)) { ?>
										<div id="infoMessage">
											<?php echo $message; ?>
										</div>
									<?php } ?>
                                     <?php echo form_open("panel/forgotten_password",array('class'=>'form-horizontal','role'=>'form'));?>

                                         <div class="form-group">
 											<label for="identity" class="col-lg-4 control-label">Correo electrónico</label>
                                           <div class="col-lg-6	">

                                            <input type="text" id="identity" name="forgot_password_identity" value="" class="form-control"
									title="Por favor introduzca el correo electrónico con el que se registró."
								/>
        									<?php //echo form_input($email);?>
                                           </div>
                                         </div>
                                         <div class="form-group">
                                           <div class="col-lg-offset-2 col-lg-10">

                                             	<input type="submit" name="send_forgotten_password" id="submit" value="Enviar" class="btn btn-default"/>
                                             <button type="reset" class="btn btn-default">Borrar</button>
                                           </div>
                                         </div>
                                       </form>
                                      </div>
                                      </div>


    </div>
  </div>
</div>
	<!-- Main Content --
	<div class="content_wrap main_content_bg">
		<div class="content clearfix">
			<div class="col100">
				<h2>Forgotten Password</h2>

			<?php if (! empty($message)) { ?>
				<div id="message">
					<?php echo $message; ?>
				</div>
			<?php } ?>

				<?php echo form_open(current_url());	?>
					<div class="w100 frame">
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
					</div>
				<?php echo form_close();?>
			</div>
		</div>
	</div>

<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>

</body>
</html>