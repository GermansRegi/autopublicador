
<!DOCTYPE html>
<head>

	<title>Autopublicador Social</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta charset="UTF-8" />
	<?php echo $this->load->view('includes2/head');?>




</head>

<body>
	<?php $socialNamesAr=array('face'=>"Facebook","twt"=>"Twitter");$tradArray=array('sentence'=>"Texto",'image'=>'Imágenes','link'=>'Enlaces');
	?>
	<?php echo $this->load->view('includes2/header');

	?>


	<p> Tiene     <?php echo count($arbbdd)?> bases de datos creadas.<a href="<?php echo base_url();?>panel/anuncios/crear">Crear nueva base de datos</a>
	</p>
	<section class="message"></section>

	<section class="col-sm-12" >
		<?php

		if(count($arbbdd)==0)
		{
			?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Nombre</th><th>Red social</th><th>Contenido</th><th></th><th></th>
					</tr>
				</thead>
			</tbody>
			<tr>
				<td colspan="6"> No tiene ninguna base de datos</td>	
			</tr>

		</tbody>
	</table>
	<?php

	}
	else {

		?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Nombre</th><th>Red social</th><th>Contenido</th><th></th><th></th>
				</tr>
			</thead>
		</tbody>
		<?php

		foreach($arbbdd as $bbdd)
		{
			echo "<tr id='line".$bbdd->id."''>";
			echo "<td>".$bbdd->name."</td>";
			echo "<td>".$socialNamesAr[$bbdd->socialnetwork]."</td>";
			echo "<td>".$tradArray[$bbdd->content]."</td>";

			echo "<td><a type='button' class='btn btn-default btn-ms' href='".base_url('panel/anuncios/editar/'.$bbdd->id)."' '>Editar</a></td>";
			echo "<td><a type='button' class='btn btn-danger btn-ms delete'  data-id='".$bbdd->id."'>Eliminar</a></td>";
			echo "</tr>";

		}
		?>
	</tbody>
	</table>
	<?php
	}       

	?>
</section>
<script type="text/javascript">
	var delete_url='<?php echo base_url()?>panel/anuncios/delete';
	var current_url='<?php echo base_url().$this->uri->uri_string();?>';
</script>

<?php
echo $this->load->view('includes2/footer');
?>
<?php echo $this->load->view('includes2/scripts');?>
</body>
</html>