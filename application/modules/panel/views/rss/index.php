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
       

	
	<div>
    
        <p> Tiene    <?php echo count($rssrows)?> fuentes de rss creadas.<a href="<?php echo base_url();?>panel/rss/crear">Crear nueva fuente rss</a>
        </p>
        <div class="message"></div>
    </div>
	<div class="col-sm-12">
	    <?php
	    if(count($rssrows)==0)
	    {
	        ?>
	<table class="table table-striped">
	   <thead>
	    	 <th>Url</th><th>Cuentas facebook</th><th>Cuentas twitter</th><th></th><th></th>
	    </thead>
	    <tbody>
	    	<tr>
	    		<td colspan="6">No tiene ninguna fuente rss</td>
	    	</tr>
	    </tbody>
	</table>
	    <?php
	    
	    }
	 else {
	        
	    ?>
	<table class="table table-striped">
	    <thead>
	    	 <th>Url</th><th>Cuentas facebook</th><th>Cuentas twitter</th><th></th><th></th>
	    </thead>
	    <tbody>	    <?php
	            
	    foreach($rssrows as $rss)
	    {
	      echo "<tr id='line".$rss->id."'>";
	      echo "<td>".$rss->url_rss."</td>";
	      $rrayfb=json_decode($rss->ids_fb);

	      
	      $num=(isset($rrayfb->user)?count($rrayfb->user):0);
	      $num=$num+(isset($rrayfb->account)?count($rrayfb->account):0);
	      echo "<td>".$num."</td>";
	      echo "<td>".count(json_decode($rss->ids_twt))."</td>";
	      
	      
	      echo "<td><a type='button' class='btn btn-default btn-ms' href='".base_url('panel/rss/editar/'.$rss->id)."' '>Editar</a></td>";
	        echo "<td><a type='button' class='btn btn-danger btn-ms deleterss'  data-id='".$rss->id."'>Eliminar</a></td>";
	      echo "</tr>";
	      
	    }
	    ?>
	    </tbody>
	</table>
	    <?php
	    }       
	    
	       ?>
	    
	    </div>
	</div>
       <script type="text/javascript">
	var delete_url='<?php echo base_url()?>panel/basesdedatos/delete';
	var current_url='<?php echo base_url().$this->uri->uri_string();?>';
</script>
                     
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>