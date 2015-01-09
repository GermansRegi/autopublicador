<!DOCTYPE html>
<head>

    <title>Autopublicador Social</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8" />
    <?php echo $this->load->view('includes2/head');?>




</head>

<body>
    <?php echo $this->load->view('includes2/header');

?>
 

          
            
			<section class="container">
			<div class="row">
			<div class="col-sm-12 panel panel-body">
				
				<section class='namebd'>
					<p>Inserte Enlaces en: <span class='bold'> <?php echo $bbdd->name."</span> <span class='right'> Tiene ".$total." enlaces creados. El máximo de enlaces son ".$this->config->item('max-no-images').".</span>";?></p>
				</section>

				<section class="clearfix">
					<form id="addcontent" method='post' action='<?php echo base_url(); ?>panel/basesdedatos/editar/<?php echo $bbdd->id; ?>'>
						<section class='message'>      
						</section>	
						<section class="col-sm-4">
							<section class="form-group">
								<label>Enlace:</label>
								<input type='text' class="form-control" name='link'>
							</section>
							<section class="form-group">
							<label>Texto:</label>
							<input type='text' class="form-control" name='text' >
							</section>
							<section class="form-group">
								<input value='<?php echo $bbdd->id; ?>' name='bbdd_alta' type='hidden'>
								<input type='submit' value='guardar' class="btn btn-primary" name='Submit'>
							</section>
						</section>
					</form>
				</section>
							<section class="row">
				<section class="col-sm-12 text-right">
	                	<input type="button" id="toggle" value="Marcar todos" class="btn btn-primary" >
	                	<input type="button" class="btn btn-danger deletemulti" value="Borrar">
	              </section>
			</section>
			<section class "row" id="contenido">
				<?php if(count($elements)>0){
					?>
				<section class='namebd'>
				<p>Elimine frases de: <span class='bold'><?php echo $bbdd->name;?></span></p>    
				</section>

				
				  <table class="table table-striped" >
				    <tr>
				     <th>Texto</th>   <th>Enlace</th><th></th><th></th>
				        
				    </tr>
				    <?php
				    foreach ($elements as $element)
				    {
				        echo "<tr>";
				            echo "<td>".$element->text."</td><td>".$element->link."</td><td><input type='checkbox' value='".$element->id."' name='hk_group_bf[]'></td><td><a data-id='".$element->id."' class='btn btn-danger deletecontent'><i class='fa fa-trash-o'></i></a> </td>";
				        echo "</tr>";
				    }
				    ?>
				</table>
				<section class="row">
					<?php echo $link_pager; ?>
				</section>
				<?php }
				else {
					?>
					  <table class="table table-striped" >
				    <tr>
				        <th></th>   <th>Frase</th><th>Borrar</th><th></th>
				        
				    </tr>
				    <tr >
				    		<td colspan="4">No hay ningún elemento en esta base de datos</td>
				    </tr>
				</table>

				 	<?php
				 } ?>
			</section>
			</div>

			</div>
		</section>
<script type="text/javascript">
	var deletecontent_url='<?php echo base_url()?>panel/basesdedatos/deletecontent/<?php echo $bbdd->id; ?>'
	var current_url='<?php echo base_url().$this->uri->uri_string();?>';
</script>
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>