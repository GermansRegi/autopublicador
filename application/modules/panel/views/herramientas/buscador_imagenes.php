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
	    <?php if(count($data['page'])==0 && count($data['user'])==0 && count($data['event'])==0  && count($data[''])==0)
		{
    		?>
			<div class="redbox">
    				<p>
				Para poder publicar debe añadir como mínimo una página de facebook. Desde la opción <?php  echo '<a href="'.base_url().'social_connect/fb_connect">Conectar con Facebook</a>';?>
    				</p>
			</div>
		<?php
		}
		else
		{
		?>
			<form  id='herramfbimages' action='<?php echo base_url()?>panel/herramientas/buscador_de_imagenes' method='post'>
			   <div class="message"></div>
			   <div class="col-lg-12">

			   </div>
			  <div class="col-lg-6">
			   		<label class="control-label">Nombre de la página de facebook</label>
			   		<input type="text" class="form-control" name="namefanpage" />
			   </div>
			   <div id="findpageresp" class="hidden">
				   <div class="col-lg-6">
				   		<div id="albums">
				   		</div>
						
				   </div>
				   <div class="col-lg-6">
				   			<label class="control-label">Selecciona las bases de datos </label>
				   			<select name="asociard" class="form-control">
				   						<?php foreach ($basesdedatos as $bd)
										{

											echo "<option value='".$bd->id."'>".$bd->name."</option>";



										}
										?>
									
							
				   			</select>
				   </div>
			   </div>




		</form>
    <?php }?>       
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>
