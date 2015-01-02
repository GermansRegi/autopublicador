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
	<div class="container">
	<div class='row'>
    	<h2>Bases de datos</h2>
        <p> Tienes     <?php echo count($arbbdd)?> bases de datos creadas.<a id='creacionbbd'>Crear nueva base de datos</a>
        </p>
    </div>
	<div>
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
	      echo "<td><a type='button' class='btn btn-default btn-ms edit edit-facebbdd' href='".base_url('admin/basesdedatos/editar/'.$bbdd->id)."' data-bd-id='".$bbdd->id."' '>Editar</a></td>";
	        echo "<td><a type='button' class='btn btn-default btn-ms delete delete-bbdd'  data-bd-id='".$bbdd->id."'>Eliminar</a></td>";
	      echo "</tr>";
	      
	    }
	    ?>
	</table>
	    <?php
	    }       
	    
	       ?>
	    
	    </div>
	</div>
                    </div>
                    </div>
                </div>
            </div>
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>