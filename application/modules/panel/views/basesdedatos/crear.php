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
 			
						<section  id='crearbbdd' class="clearfix">
		 					<section class="col-sm-8 col-sm-offset-2">
			 					<form action="<?php echo base_url(); ?>panel/basesdedatos/crear" method="post" id="addbbdd" > 
			 						<section class="message">


			 						</section>

			 						<section class="form-group col-sm-9">
			 							<label class="col-sm-4 control-label">Nombre</label>
			 							<section class="col-sm-8">
			 								<input type='text' class="form-control col-sm-7"  placeholder="Nombre" name='basededatos_create_name'>
			 							</section>
			 						</section>
			 						<section class="form-group col-sm-9">
			 							<label class="col-sm-4 control-label">Contenido:</label>
			 							<section class="col-sm-8">
			 								<select class="form-control changecontent" name="content">
			 									<option value="">Selecciona una opción</option>
			 									<option value="link">Enlaces</option>
			 									<option value='image'>Imágenes</option>
			 									<option value="sentence">Texto</option>
			 								</select>
			 							</section>
			 						</section>
			 						<section class="form-group col-sm-9 hidden watermark">
						            		<label class="col-sm-4 control-label">Imágen de marca de agua:</label>
						            		<section class="col-sm-8">
						            		        <input class='filestyle' data-buttonText="Escoja una imagen" data-buttonName="btn-default" data-icon="false" class="filestyle" accept="image/x-png,image/png, image/gif, image/jpeg , image/jpg" type='file' id="filetoup"  name='imagen'>
									             <a href="" id="clearFile">Eliminar imagen de marca de agua</a>
									    	
						      				</section>
						      		</section>
						      		
			 						<section class="form-group col-md-9">
			 							<label class="control-label col-sm-4">Red social:</label>
			 							<section class="col-sm-8">
			 								<select class="form-control" name="basededatos_create_social">
			 									<option value="">Selecciona una opción</option>
			 									<option value="face">Facebook</option>
			 									<option value='twt'>Twitter</option>

			 								</select></section>
			 							</section>
			 							<section class="form-group col-md-9">
			 								<section class="col-sm-9 col-sm-offset-4">
			 									<input id="addbbdd-btn" type="submit"  class="btn btn-primary" name='addnew' value='Crear'>
			 									<a class="btn btn-default" id='cancel_crear_bbdd' href="<?php echo base_url()?>panel/basesdedatos">Cancelar</a>
			 								</section>
			 							</section>      
			 						</section>
			 					</form>
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