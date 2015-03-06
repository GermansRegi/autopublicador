<!DOCTYPE html>
<head>

    <title>Socialsuites</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8" />

  <?php echo $this->load->view('includes2/head');?>


</head>

<body>
    <?php echo $this->load->view('includes2/header');

?>
	<!-- Main Content -->




      <section class="col-md-6">
                  <!-- Some content -->
                  <h3 class="title">Regístrese hoy <span class="color">!!!</span></h3>
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

                <!-- Login form -->
                <section class="col-md-6">
                  <section class="formy well">
                    <!-- Title -->
                     <h4 class="title">Acceda a su cuenta</h4>
                      <p>&nbsp;</p>
                                  <section class="form">
							<?php if (! empty($message)) { ?>
										<section class=" panel bg-dagner" id="infoMessage">
											<div class="text-center panel-heading bg-danger bg-dagner-dark-error-message">
											<?php echo $message; ?>
											</div>
										</section>
									<?php } ?>
                                      <form class="form-horizontal" action='<?php echo base_url()?>panel/login' method="post" role="form">
                                         <section class="form-group">
                                           <label for="identity" class="col-lg-4 control-label">Correo electrónico:</label>

                                           <section class="col-lg-6">
<input type="text" id="identity" name="login_identity" class="form-control" placeholder="Correo electrónico" value="<?php echo set_value('login_identity', 'eugeniregidev@gmail.com');?>"	/>


                                           </section>
                                         </section>
                                         <section class="form-group">
                                           <label for="password" class="col-lg-4 control-label">Contraseña:</label>
                                           <section class="col-lg-6">

                                           	<input type="password" id="password" class="form-control" placeholder="Contraseña" name="login_password" value="<?php echo set_value('login_password', 'eugeni88');?>"/>

                                           </section>
                                         </section>
                                         <section class="form-group">
                                           <section class="col-lg-offset-4 col-lg-10">
                                           <input type="submit" name="login_user" id="submit" value="Acceder" class="btn btn-default"/>

                                             <button type="reset" class="btn btn-default">Borrar</button>
                                           </section>
                                         </section>
                                       </form>

                                      <hr>

                                      <p><a href="<?php echo base_url();?>panel/forgotten_password">Olvidó su contraseña?</a></p>
                                      <h5>Crear cuenta</h5>
                                      <!-- Register link -->
                                          No tiene una cuenta? <a href="<?php echo base_url(); ?>panel/register_account">Regístrese</a>
                                    </section>
                                  </section>
                </section>
                </section>
                </section>
                </section>


<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>

</body>
</html>