<!DOCTYPE html>
<html>
	<head>
	    <title>Socialsuites</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta charset="UTF-8" />
	    <?php echo $this->load->view('includes2/head');?>
	</head>

	<body>
	    <?php echo $this->load->view('includes2/header'); ?>
			<form  id='herramtw' action='<?php echo base_url()?>panel/herramientas/follow_twitter' method='post'>
			   <div class="message"></div>
			   <div class="col-lg-12">
					<section class=" panel bg-info">
                      <div class="text-center panel-heading bg-info bg-info-dark-info-message">
                      Con esta herramienta podrás seguir a usuarios de twitter.
                      </div>
                    </section>
					
			   </div>
			   <div class="col-lg-12">
					<div class="form-group"		>
						<label class="control-label">
							Temática:
						</label>
						<input type="text"name="search">
					</div>
					
					<div id="resultsearch" class="hidden">
						<label class="control-label">
							Usuarios:
						</label>
						<div class="users">

						</div>	
					</div>
					 <label class="control-label ">Cuentas:</label>
			  
						
						<?php
							$accordion['input']="user";
							ECHO $this->load->view('twitter/accordion_accounts',$accordion);
							?>
						
							
		
			   </div>
			   <div class="col-1g-12">  
			   <input type="hidden" name="sendpost">
			   		<input data-active="active..." data-loading="loading..." data-complete="completed..." type="submit" name="Enviar" value="Guardar" class="btn btn-primary"/>
			   		<a class="btn btn-default" id='cancel_crear_bbdd' href="<?php echo base_url()?>panel/herramientas" >Volver</a>
			   	</div>



		</form>
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>
