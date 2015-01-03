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
            <div class="sep"></div>
            <div class="page-head">
              <div class="container">
                <div class="row">
                  <div class="col-md-12">
                    <h2>Bases de datos</h2>

                  </div>
                </div>
              </div>


            </div>
            <div class="content">
			<div class="container">
				<h3>Editar base de datos: <?php echo $bbdd->name; ?></h3>
				<div class='namebd'>
					<p>Inserte Enlaces en: <span class='bold'> <?php echo $bbdd->name."</span> <span class='right'> Tiene ".$total." enlaces creados. El máximo de enlaces son 7000.</span>";?></p>
				</div>

				<div class="clearfix">
					<form id="addcontent" method='post' action='<?php echo base_url(); ?>admin/basesdedatos/editar/<?php echo $bbdd->id; ?>'>
						<div id='message'>      
						</div>	
						<div class="col-sm-4">
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
				<div class="col-sm-12 text-right">
	                	<input type="button" id="toggle" value="Marcar todos" class="btn btn-primary" onclick="do_this()">
	                	<input type="button" class="btn btn-danger deletemulti" value="Borrar">
	              </div>
			</div>
			<div class "row" id="contenido">
				<?php if(count($elements)>0){
					?>
				<div class='namebd'>
				<p>Elimine frases de: <span class='bold'><?php echo $bbdd->name;?></span></p>    
				</div>

				
				  <table class="table table-striped" >
				    <tr>
				     <th>Texto</th>   <th>Enlace</th><th></th><th></th>
				        
				    </tr>
				    <?php
				    foreach ($elements as $element)
				    {
				        echo "<tr>";
				            echo "<td>".$element->text."</td><td>".$element->link."</td><td><input type='checkbox' value='".$element->id."' name='hk_group_bf[]'></td><td><a id='".$element->id."' class='btn btn-danger delete'><i class='fa fa-trash-o'></i></a> </td>";
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

<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>