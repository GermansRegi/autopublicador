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
			<form  id='herramfb' action='<?php echo base_url()?>panel/herramientas/limpiador_twitter' method='post'>
			   <div class="message"></div>
			   <div class="col-lg-12">
			   <section class=" panel bg-info">
                      <div class="text-center panel-heading bg-info bg-info-dark-info-message">
                      Con esta herramienta podrás limpiar hasta 3200 tweets de una cuenta de Twitter.
                      </div>
                    </section>
			   	
			   </div>
			   <div class="col-lg-12">
							
					 <label class="control-label ">Cuentas a limpiar:</label>
			  
						<section >
						<?php
							foreach($users as $page)
							{
								
								echo " <input type='checkbox' name='user[]' value='".$page->user_id."' /> <span >".$page->username."</span><br>";
							}
							?>
						</section>
							
		
			   </div>
			   <div class="col-1g-12">  
			   <input type="hidden" name="sendpost">
			   		<input  type="submit" data-active="active..." data-loading="loading..." data-complete="completed..." name="Enviar" value="Guardar" class="btn btn-primary"/>
			   	</div>



		</form>
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>
