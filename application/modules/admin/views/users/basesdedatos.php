  <!DOCTYPE html>
  <html>
  <head>

  	<title>Socialsuites</title>

  	<meta name="viewport" content="width=device-width, initial-scale=1.0">

  	<meta charset="UTF-8" />
  	<?php echo $this->load->view('includes2/head');?>




  </head>

  <body>

  	<?php echo $this->load->view('includes2/header');

 $socialNamesAr=array('face'=>"Facebook","twt"=>"Twitter");$tradArray=array('sentence'=>"Texto",'image'=>'Imágenes','link'=>'Enlaces');
?>

  	

  	<h3>Bases de datos</h3>
  	<table class="table-condensed table">
  		<?php
  		echo "<tr><th>Nombre </th><th>Red Social</th><th>Contenido</th></tr> ";
  		foreach($bbdd as $bd)
  		{

  			echo "<tr>";
  			echo "<td>".$bd->name. "</td><td> ". $socialNamesAr[$bd->socialnetwork]."</td>";
  			echo "<td>".$tradArray[$bd->content]."</td>";
  			echo "</tr>";
  		}

  		?>
  	</table>
  	<h3>Bases de datos de anuncios</h3>
  	<table class="table-condensed table">
  		<?php
  		echo "<tr><th>Nombre </th><th>Red social</th><th>Contenido</th></tr> ";
  		foreach($anuncios as $bd)
  		{

  			echo "<tr>";
  			echo "<td>".$bd->name. "</td><td> ". $socialNamesAr[$bd->socialnetwork]."</td>";
  			echo "<td>".$tradArray[$bd->content]."</td>";
  			echo "</tr>";
  		}

  		?>
  	</table>
  </div>
  <?php
  echo $this->load->view('includes2/footer');
  ?>
  <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>