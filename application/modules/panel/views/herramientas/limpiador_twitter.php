<!DOCTYPE html>
<html>
	<head>
	    <title>Autopublicador Social</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta charset="UTF-8" />
	    <?php echo $this->load->view('includes2/head');?>
	</head>

	<body>
	    <?php echo $this->load->view('includes2/header'); ?>
			<form  id='herramfb' action='<?php echo base_url()?>panel/herramientas/limpiador_twitter' method='post'>
			   <div class="message"></div>
			   <div class="col-lg-12">
			   	Con esta herramienta podrás limpiar todos los tweets de una cuenta de Twitter.
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
			   		<input  type="submit" name="Enviar" value="Guardar" class="btn btn-primary"/>
			   	</div>



		</form>
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>
