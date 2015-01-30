<!DOCTYPE <html></html>
<head>

    <title>Autopublicador Social</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8" />
    <?php echo $this->load->view('includes2/head');?>




</head>

<body>
    <?php echo $this->load->view('includes2/header');

?>
            
   
					

					<div class='namebd'>
						<p>Inserte frases en: <span class="bold"> <?php echo $bbdd->name."</span> <span class='right'> Tiene  ".$total." frases creadas. El máximo de frases son ".$this->config->item('max-no-images').".</span>";?></p>
					</div>

				<div>
				<form id='addcontent' method='post' action='<?php echo base_url(); ?>panel/basesdedatos/editar/<?php echo $bbdd->id; ?>'>
					<div class="col-sm-12">
					<div class='message'>      


					</div>

					<div class="form-group">
						<textarea placeholder="Frase" <?php  echo (isset($maxlenght)?"maxlenght='$maxlenght' id='tweet_txt'":''); ?> class="form-control" name='frase'></textarea>
						<?php  echo (isset($maxlenght)?"<p id='contadorTaComentario'></p>":'')?>
					</div>
					<div class="form-group">

						<input value='<?php echo $bbdd->id; ?>' name='bbdd_alta' type='hidden'/>
						<input type='submit' value='guardar' class="btn btn-primary" name='Submit'/>
					</div>
					</div>
				</form>
			</div>
			
			<div class="row">
			<div class='namebd col-sm-6'>
				<p>Elimine frases de: <span class='bold'><?php echo $bbdd->name;?></span></p>    
				</div>
				<div class="col-sm-6 text-right">
<input type="button" id="toggle" value="Marcar todo" class="btn btn-primary" >	                	
	                	<input type="button" class="btn btn-danger deletemulti" value="Borrar">
	              </div>
			</div>
			
			<div  id="contenido" class="col-sm-12">
				<?php if(count($elements)>0){
					?>
				

				
				  <table class="table table-striped" >
				  <thead>
				  	<tr>
				  		<th></th>   <th>Frase</th><th></th>
				  	</tr>
				  </thead>
				    <tbody>
				    	<?php
				    foreach ($elements as $element)
				    {
				        echo "<tr>";
				            echo "<td><input type='checkbox' value='".$element->id."' name='hk_group_bf[]'></td><td>".$element->sentence."</td><td><a data-id='".$element->id."' class='btn btn-danger deletecontent'><i class='fa fa-trash-o'></i></a> </td>";
				        echo "</tr>";
				    }
				    ?>
				    </tbody>
				    
				</table>
				<div class="row">
					<?php echo $link_pager; ?>
				</div>
				<?php }
				else {
					?>
					  <table class="table table-striped" >
				  <thead>
				  	<tr>
				  		<th></th>   <th>Frase</th><th></th>
				  	</tr>
				  </thead>
				    <tbody>
				    <tr >
				    		<td colspan="3">No hay ningún elemento en esta base de datos</td>
				    </tr>
				    </tbody>
				</table>

				 	<?php
				 } ?>
			</div>
			
	
<script type="text/javascript">
	var deletecontent_url='<?php echo base_url()?>panel/basesdedatos/deletecontent/<?php echo $bbdd->id; ?>';
	var current_url='<?php echo base_url().$this->uri->uri_string();?>';
</script>
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>