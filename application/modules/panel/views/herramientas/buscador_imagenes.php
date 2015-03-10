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
			<form  id='herramfbimages' action='<?php echo base_url()?>panel/herramientas/buscador_de_imagenes' method='post'>
			   <div class="message"></div>
				<div class="col-lg-12">
				<section class=" panel bg-info">
                      <div class="text-center panel-heading bg-info bg-info-dark-info-message">
                      Con esta herramienta podrás agregar a una base de datos todas las imágenes de un album de una página de facebook.
                      </div>
                    </section>
				</div>
							  <div class="col-lg-12 form-group">
			   		<label class="control-label">Nombre de la página de facebook</label>
			   		<input type="text" class="form-control" name="pagename" />
			   </div>
			   <div id="findpageresp" class="hidden col-lg-12 form-group">
				   <div class="col-lg-6">
				   		<label class="control-label">Albumes</label>
				   		<div id="albums">
				   		</div>
						
				   </div>
				   <div class="col-lg-6">
				   			<label class="control-label">Selecciona las bases de datos </label>
				   			<select name="asociard" id="selectbd" class="form-control">
				   			<option value="">Selecciona una opción</option>
				   						<?php/* foreach ($basesdedatos as $bd)
										{

											echo "<option value='".$bd->id."'>".$bd->name."</option>";



										}*/
										?>
									
							
				   			</select>
				   </div>
			   </div>
			   <div class="col-lg-2 form-group">
			   <input type="submit" class=" btn btn-primary" value="Enviar">
			   </div>




		</form>
      
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>
