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
 echo $this->load->view('includes2/scripts');?>

       <div class="col-lg-12">
       	<div id="msg_anadirpags"></div>
       </div>
       <?php
       if($message=='success'){

       
       ?>
		<script>
		$(function(){
				
				$("#msg_anadirpags").noty({text:'Las cuentas seleccionadas se han añadido corectamente',type:'success'})


		})
		
		</script>
       	<?php
       }else{

       	?>
       	<script>
       	$(function(){
		$("#msg_anadirpags").noty({text:'No se han añadido las cuentas seleccionadas',type:'error'})
				})
		</script>


       	<?php
       	}  ?>
	             
	             <script>
	             $('body').delay(1000).queue(function(nxt){
	             		location.href=base_url+'panel/twitter';

	             })
	             </script>
<?php
    echo $this->load->view('includes2/footer');
?>
 
</body>
</html>