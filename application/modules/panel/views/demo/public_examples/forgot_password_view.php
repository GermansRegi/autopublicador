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
                  <section class="formy well">
                    <!-- Title -->
                     <h4 class="title">Introduzca su correo electrónico</h4>
                                  <section class="form">

                                      <!-- Login form (not working)-->
                                      <?php if (! empty($message)) { ?>
										<section id="infoMessage">
											<?php echo $message; ?>
										</section>
									<?php } ?>
                                     <?php echo form_open("panel/forgotten_password",array('class'=>'form-horizontal','role'=>'form'));?>

                                         <section class="form-group">
 											<label for="identity" class="col-lg-5 control-label">Correo electrónico</label>
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


<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>

</body>
</html>