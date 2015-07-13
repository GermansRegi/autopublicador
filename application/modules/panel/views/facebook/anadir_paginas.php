<!DOCTYPE html>
<head>

    <title>Socialsuites</title>

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
       
      
		<script>
		
				
				$("#msg_anadirpags").noty({text:'<?php echo $message ?>',type:'<?php echo $result; ?>'})


		
		
		</script>
       	
           
	             <script>
	             $('body').delay(1500).queue(function(nxt){
	             		location.href=base_url+'panel/facebook';

	             })
	             </script>
<?php
    echo $this->load->view('includes2/footer');
?>
 
</body>
</html>