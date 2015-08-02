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
		
				

			<?php if (! empty($message)) { ?>
			
	     			<section class=" panel bg-info" id="infoMessage">
                      <div class="text-center panel-heading bg-info bg-info-dark-info-message">
                      <?php echo $message; ?>
                      </div>
                    </section>
               
				
			<?php } ?>
				
				<?php echo form_open(current_url());	?>  	
					<section>
						
					
							<div class="form-group">
								<label for="new_password" class="label-form">Nueva contraseña:</label>
								<input type="password" id="new_password" name="new_password" value="" class="form-control"/>
							</div>
							<div class="form-group">
								<label for="confirm_new_password" class="label-form">Repita la nueva contraseña:</label>
								<input type="password" id="confirm_new_password" name="confirm_new_password" value="" class="form-control"/>
							</div>
							<div class="form-group">
								
								<input type="submit" class="btn btn-primary" name="change_forgotten_password" id="submit" value="Cambiar contraseña"/>
							</div>
						
					</section>
		</section>

<?php echo form_close();?>

<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>
	