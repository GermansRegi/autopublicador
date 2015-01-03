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
            
            <div class="page-head">
              <div class="container">
                <div class="row">
                  <div class="col-md-12">
                
                    <h2>Editar base de datos: <?php echo $anuncio->name; ?></h2>

                  </div>
                </div>
              </div>


			</div>
			<div class="content">
				<div class="container">
					

					<div class='namebd'>
						<p>Inserte frases en: <span class="bold"> <?php echo $anuncio->name."</span> <span class='right'> Tiene  ".$total." frases creadas. El máximo de frases son ".$this->config->item('max-no-images').".</span>";?></p>
					</div>

				<div>
				<form id='addcontent' method='post' action='<?php echo base_url(); ?>admin/anuncios/editar/<?php echo $anuncio->id; ?>'>
					<div id='message'>      


					</div>
					<div class="form-group">
						<textarea placeholder="Frase" class="form-control" name='frase'></textarea>
					</div>
					<div class="form-group">

						<input value='<?php echo $anuncio->id; ?>' name='anuncio_alta' type='hidden'/>
						<input type='submit' value='guardar' class="btn btn-primary" name='Submit'/>
					</div>
				</form>
			</div>
			
			<div class="row">
				<div class="col-sm-12 text-right">
	                	
	                	<input type="button" class="btn btn-danger deletemulti" value="Borrar">
	              </div>
			</div>
			<div class "row" id="contenido">
				<?php if(count($elements)>0){
					?>
				<div class='namebd'>
				<p>Elimine frases de: <span class='bold'><?php echo $anuncio->name;?></span></p>    
				</div>

				
				  <table class="table table-striped" >
				    <tr>
				     <th></th>   <th>Frase</th><th></th>
				        
				    </tr>
				    <?php
				    foreach ($elements as $element)
				    {
				        echo "<tr>";
				            echo "<td>".$element->sentence."</td><td><input type='checkbox' value='".$element->id."' name='hk_group_bf[]'></td><td><a data-id='".$element->id."' class='btn btn-danger deletecontent'><i class='fa fa-trash-o'></i></a> </td>";
				        echo "</tr>";
				    }
				    ?>
				</table>
				<div class="row">
					<?php echo $link_pager; ?>
				</div>
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
			</div>
			
			</div>
			</div>
<script type="text/javascript">
	var deletecontent_url='<?php echo base_url()?>admin/anuncios/deletecontent/<?php echo $anuncio->id; ?>';
	var current_url='<?php echo base_url().$this->uri->uri_string();?>';
</script>
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>