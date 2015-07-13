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
 

          
            
	
				
				<div class='namebd'>
					<p>Inserte Enlaces en: <span class='bold'> <?php echo $bbdd->name."</span> <span class='right'> Tiene ".$total." enlaces creados. El máximo de enlaces son ".$this->config->item('max-no-images').".</span>";?></p>
				</div>

				<div class="clearfix">
					<form id="addcontent" method='post' action='<?php echo base_url(); ?>panel/basesdedatos/editar/<?php echo $bbdd->id; ?>'>
							
						<div class="col-sm-12">
						<div class='message'>      
						</div>
							<div class="form-group">
								<label>Enlace:</label>
								<input type='text' class="form-control" name='link'>
							</div>
							<div class="form-group">
							<label>Texto:</label>
							<input type='text' class="form-control" name='text' >
							</div>
							<div class="form-group">
								<input value='<?php echo $bbdd->id; ?>' name='bbdd_alta' type='hidden'>
								<input type='submit' value='guardar' class="btn btn-primary" name='Submit'>
							</div>
						</div>
					</form>
				</div>
							<div class="row">
							<div class='namebd col-lg-6'>
				<p>Elimine enlaces de: <span class='bold'><?php echo $bbdd->name;?></span></p>    
			</div>
				<div class="col-sm-6 text-right">
	                	<input type="button" id="toggle" value="Marcar todos" class="btn btn-primary" >
	                	<input type="button" class="btn btn-danger deletemulti" value="Borrar">
	              </div>
			</div>
			
			<div id="contenido" class="col-sm-12">
				<?php if(count($elements)>0){
					?>
				

				
				  <table class="table table-striped" >
				  <thead>
				    <tr>
				     <th>Texto</th>   <th>Enlace</th><th></th><th></th>
				        
				    </tr>
				    </thead>
				    <tbody>
				    <?php
				    foreach ($elements as $element)
				    {
				        echo "<tr>";
				            echo "<td data-type='text-link' contenteditable='true'>".$element->text."</td><td data-type='link' contenteditable='true'>".$element->link."</td><td><input type='checkbox' value='".$element->id."' name='hk_group_bf[]'></td><td><a data-id='".$element->id."' class='btn btn-danger deletecontent'><i class='fa fa-trash-o'></i></a> </td>";
				        echo "</tr>";
				    }
				    ?>
				    </tbody>
				</table>
				<div >
					<?php echo $link_pager; ?>
				</div>
				<?php }
				else {
					?>
					  <table class="table table-striped" >
					  <thead>
				    <tr>
				        <th></th>   <th>Frase</th><th>Borrar</th><th></th>
				        
				    </tr>
				    </thead>
				    <tbody>
				    <tr >
				    		<td colspan="4">No hay ningún elemento en esta base de datos</td>
				    </tr>
				    </tbody>
				</table>

				 	<?php
				 } ?>
		
			</div>
	
<script type="text/javascript">
	var deletecontent_url='<?php echo base_url()?>panel/basesdedatos/deletecontent/<?php echo $bbdd->id; ?>'
	var current_url='<?php echo base_url().$this->uri->uri_string();?>';
	var updateElement_url='<?php echo base_url()?>panel/basesdedatos/updateElement/<?php echo $bbdd->id; ?>'
</script>
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>