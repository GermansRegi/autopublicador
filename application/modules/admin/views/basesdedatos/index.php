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
       
  <div class="page-head">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2>Bases de datos</h2>

        </div>
      </div>
         </div>
</div>
	<div class="container">
	<div class='row'>
    
        <p> Tienes     <?php echo count($arbbdd)?> bases de datos creadas.<a href="<?php echo base_url();?>admin/basesdedatos/crear">Crear nueva base de datos</a>
        </p>
        <div id="message"></div>
    </div>
	<div class="row">
	    <?php
	    if(count($arbbdd)==0)
	    {
	        echo "No tienes ninguna base de datos";
	    }
	 else {
	        
	    ?>
	<table class="table table-condensed">
	    <tr>
	        <th>Nombre</th><th>Red social</th><th>Contenido</th><th>Creador</th><th></th><th></th>
	    </tr>
	    
	    <?php
	            
	    foreach($arbbdd as $bbdd)
	    {
	      echo "<tr>";
	      echo "<td>".$bbdd->name."</td>";
	      echo "<td>".$socialNamesAr[$bbdd->socialnetwork]."</td>";
	      echo "<td>".$tradArray[$bbdd->content]."</td>";
	      echo "<td>".($bbdd->is_admin==1?'administrador':'usuario')."</td>";
	      echo "<td><a type='button' class='btn btn-default btn-ms' href='".base_url('admin/basesdedatos/editar/'.$bbdd->id)."' '>Editar</a></td>";
	        echo "<td><a type='button' class='btn btn-danger btn-ms delete'  data-id='".$bbdd->id."'>Eliminar</a></td>";
	      echo "</tr>";
	      
	    }
	    ?>
	</table>
	    <?php
	    }       
	    
	       ?>
	    
	    </div>
	</div>
       <script type="text/javascript">
	var delete_url='<?php echo base_url()?>admin/basesdedatos/delete/<?php echo $bbdd->id; ?>';
	var current_url='<?php echo base_url().$this->uri->uri_string();?>';
</script>
                     
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>