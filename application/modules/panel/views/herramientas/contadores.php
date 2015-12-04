<!DOCTYPE html>
<html>
	<head>
	    <title>Socialsuites</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta charset="UTF-8" />
	    <?php echo $this->load->view('includes2/head');?>
	</head>

	<body>
	    <?php echo $this->load->view('includes2/header'); ?>
			   	<table class="table table-condensed">
			   	<thead>
			   		<tr>
			   			<th>Cuenta</th>
			   			<th>Número de seguidores</th>
			   			<th>Número de tweets</th>
			   		</tr>
			   	</thead>
			   	<tbody>
			   		<?php
			   		foreach($users as $user)
			   		{
			   			?>
			   			<tr>
							<td><?php echo $user->username; ?></td>
							<td><?php echo $user->numfollowers; ?></td>
							<td><?php echo $user->numtweets; ?></td>
							</tr>
			   			<?php
			   		}
			   		?>
			   	</tbody>
			   	</table>

			   		<a class="btn btn-default" id='cancel_crear_bbdd' href="<?php echo base_url()?>panel/herramientas" >Volver</a>
			   	



		
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>
