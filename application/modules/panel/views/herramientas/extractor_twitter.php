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
	 
			<form  id='herramfb' action='<?php echo base_url()?>panel/herramientas/extractor_tweets' method='post'>
			   <div class="message"></div>
			   	<div class="col-lg-12">
				<section class=" panel bg-info">
                      <div class="text-center panel-heading bg-info bg-info-dark-info-message">
                      Con esta herramienta podrás agregar a una base de datos los tweets (de la última semana) de una cuenta de twitter.
                      </div>
                    </section>
				</div>
			
			  <div class="col-lg-3">
			   		<label class="control-label">Nombre de la cuenta de twitter</label>
			   		<input type="text" class="form-control" name="nameacount" />

			   </div>
			   
				   <div class="col-lg-3">
				   		<label class="control-label">Cantidad de tweets</label>
						<select name="qt"class="form-control">
							<option value="100">100</option>
							<option value="200">200</option>
							<option value="400">400</option>
							<option value="800">800</option>
							<option value="1000">1000</option>

						</select>
				   </div>
				   <div class="col-lg-3">
				   <label class="control-label">Filtro</label>
				   		<select name="inclrt" class="form-control">
							<option value="1">Tweets enviados</option>
							<option value="0">Tweets con hashtag</option>

						</select>
				   </div>
				   <div class="col-lg-3">
				   			<label class="control-label">Selecciona las bases de datos de tipo texto</label>
				   			<select name="asociard" class="form-control">
				   			<option value="">Selecciona una base de datos</option>
				   						<?php foreach ($basesdedatos as $bd)
										{

											echo "<option value='".$bd->id."'>".$bd->name."</option>";



										}
										?>
									
							
				   			</select>
				   </div>
				   <div class="col-lg-12">
				   	<input type="submit" data-active="active..." data-loading="loading..." data-complete="completed..." class="btn btn-primary" name="enviar" value="Guardar"/>
				   	<a class="btn btn-default" id='cancel_crear_bbdd' href="<?php echo base_url()?>panel/herramientas" >Volver</a>
				   </div>
			  




		</form>
<?php    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>

