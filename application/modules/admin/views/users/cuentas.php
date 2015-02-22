
  <!DOCTYPE html>
  <html>
  <head>

  	<title>Autopublicador Social</title>

  	<meta name="viewport" content="width=device-width, initial-scale=1.0">

  	<meta charset="UTF-8" />
  	<?php echo $this->load->view('includes2/head');?>




  </head>

  <body>

  	<?php echo $this->load->view('includes2/header');
	$arraytypes=array("user","Usuario","group"=>"Grupo","page"=>"Página","event"=>"Evento")

?>
	<div>
	<h3> Cuentas de facebook </h3>
	<table class="table table-condensed">
		
		<thead>
			<tr>
				<th>Imagen</th><th>Nombre</th><th>Tipo</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($accountfb as $acc) {
					?>
					<tr>
						<td><img src="http://graph.facebook.com/v2.2/<?php echo $acc->idaccount; ?>/picture?width=50&height=50"></td>
						<td><?php echo $acc->name; ?></td>
						<td><?php echo $arraytypes[$acc->type_account]; ?></td>
					</tr>

					<?php
				}
				foreach ($userfb as $acc) {
					?>
					<tr>
						<td><img src="http://graph.facebook.com/v2.2/<?php echo $acc->user_id; ?>/picture?width=50&height=50"></td>
						<td><?php echo $acc->username; ?></td>
						<td> Usuario</td>
					</tr>

					<?php
				}
			 ?>
		
		</tbody>
	</table>

  	<h3> Cuentas de twitter </h3>
  	<table class="table table-condensed">
  		<thead>
  			<tr>
  				<th>Imagen</th><th>Nombre</th>
  			</tr>
  		</thead>	
  		<tbody>
  		<?php

  				foreach ($usertw as $acc) {
					?>
		
					<tr>
		
						<td><img width="50" src="<?php echo $acc->img_profile ?>"></td>
						<td><?php echo $acc->username; ?></td>
					</tr>

					<?php
				}
			 ?>
  			
  		</tbody>
  	</table>
  </div>
  <?php
  echo $this->load->view('includes2/footer');
  ?>
  <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>