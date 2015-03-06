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
                                  <section  class="form">
                          	<?php if (! empty($message)) { ?>
									<section class=" panel bg-dagner" id="infoMessage">
									<div class="text-center panel-heading bg-danger bg-dagner-dark-error-message">
								<?php echo $message; ?>
									</div>
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
                          <label for="register_last_name" class="col-lg-4 control-label">Apellidos</label>
                         <section class="col-lg-6">

                        	<input type="text" id="last_name" name="register_last_name" class="form-control" placeholder="Apellidos" value="<?php echo set_value('register_last_name');?>"/>
                         </section>
                       </section>
                       <section class="form-group">
                        <label for="first_name" class="col-lg-4 control-label">Correo Electrónico</label>
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

                                             Ya tiene una cuenta? <a href="<?php echo base_url()?>panel/login">Acceder</a>
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