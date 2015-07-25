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

	?>
	<table class="table table-condensed"> 
	<thead>
		<tr>
			<th>Nombre y apellidos</th><th>Correo electrónico</th><th>Plan de usuario</th><th>Cambiar plan</th><th>Fecha de suscripción</th><th>Último login</th><th>Fecha de registro</th><th></th><th></th>
		</tr>
	</thead>
	<tbody>
		
	
		<?php foreach ($users as $user) {
			# code...
			echo "<tr>";
				echo "<td>".$user->upro_first_name." ".$user->upro_last_name."</td>";
				echo "<td>".$user->uacc_email."</td>";
				      $gropu=$this->flexi_auth->get_users_group_query('ugrp_name, ugrp_id',array('user_app'=>$user->user_app))->result();
            	
       
				echo "<td>".$gropu[0]->ugrp_name."</td>";
				echo "<td>";
				$array=array(1 =>'Public' ,2=>"Premium",3=>"Master Admin" );
				unset($array[$user->ugrp_id]);
				foreach ($array as $key => $value) {
									echo "<a href='".base_url()."admin/usuarios/cambiarplan/".$user->user_app."/".$key."' class='btn btn-default btn-xs'>Cambiar a ".$value."</a>";				
				}
	
				echo "</td>";
				echo "<td></td>";

				echo "<td>".date('d-m-Y H:i:s',strtotime($user->uacc_date_last_login))."</td>";
				

				echo "<td>".date('d-m-Y H:i:s',strtotime($user->uacc_date_added))."</td>";
				echo "<td><a href='".base_url().'admin/usuarios/basesdedatos/'.$user->user_app."' > Ver bases de datos del usuario</a></td>";
				echo "<td><a href='".base_url().'admin/usuarios/cuentas/'.$user->user_app."' > Ver cuentas del usuario</a></td>";

			echo "</tr>";
		}
	  ?>
	  </tbody>
	  </table>
  <?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>