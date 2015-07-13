<!DOCTYPE html>
<head>

    <title>Socialsuites</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8" />
    <?php echo $this->load->view('includes2/head');?>




</head>

<body>
    <?php echo $this->load->view('includes2/header');

?>
          
<?php if(isset($texto)){
?>
	  <div class="panel panel-success">
    	<header class="panel-heading text-center"> Días Premium</header>
    	<div class="text-center">
    		<p>
    		<strong>
			<?php echo $texto; ?>    			
    		</strong>
    		</p>
    	</div>
    </div>

<?php
}

?>
  

    
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>