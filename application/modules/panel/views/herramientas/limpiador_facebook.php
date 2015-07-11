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
	 
			<form  id='herramfb' action='<?php echo base_url()?>panel/herramientas/limpiador_facebook' method='post'>
			   <div class="message"></div>
			   <div class="col-lg-12">
			   			   	
			   	   	<section class=" panel bg-info">
                      <div class="text-center panel-heading bg-info bg-info-dark-info-message">
                      	Con esta herramienta podrás limpiar una cuenta de Facebook.
                      </div>
                    </section>
			   </div>
			   <div class="col-lg-6">
			       <div class="form-group">
			       	<label class="control-label">Selecciona tipo de limpieza</label>
			       	<select class="form-control" name="type">
			       		<option value="1">Limpiar fotos</option>
			       		<option value="2">Limpiar spam</option>
			       		<option value="3">Limpiar todo</option>
			       	</select>
			       </div>
			   </div>
			   <div class="col-lg-6">	       
			       
				<div class="form-group col-lg-12">
					 <label class="control-label ">Cuentas a limpiar:</label>

									<?PHP 
									$accordion['input']="ck_group_ap";
									ECHO $this->load->view('facebook/accordion_accounts',$accordion);?>  
					
				</section>
				
				<section class="col-lg-12">
						<input data-active="active..." data-loading="loading..." data-complete="completed..." type='submit' name='publicar' class="btn btn-primary" value='Limpiar'/>
						<a class="btn btn-default" id='cancel_crear_bbdd' href="<?php echo base_url()?>panel/herramientas" >Volver</a>
				</section>
				
			</div>
			</div>
		</form>
      
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>
