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
<div class="col-lg-3">
	<a href='<?php echo base_url()?>panel/herramientas/limpiador_facebook'>Limpiador de facebook</a>
</div>
<div class="col-lg-3">
    <a href='<?php echo base_url()?>panel/herramientas/unfollow_twitter'>Unfollow de twitter</a>
</div>

	             
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>


