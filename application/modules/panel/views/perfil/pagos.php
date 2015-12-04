<!DOCTYPE html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Socialsuites</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    <?php echo $this->load->view('includes2/head');?>




</head>

<body>
    <?php echo $this->load->view('includes2/header');
?>
				<div class="col-lg-12 clearfix">
					<a class="btn btn-primary pull-right" href="<?php echo base_url() ?>panel/perfil/planes">Renovar</a>
				</div>
						<table class="table">
			<thead>
				<tr>
					<th>Email</th>
					<th>Id Transacción</th>
					<th>Fecha</th>
					<th>Fecha de expiración</th>
					<th>Cantidad</th>
					<th>Tipo</th>
				</tr>
			</thead>
			<tbody>
			<?php for($i=0;$i<count($pays);$i++){?>
				<tr>
				
					<td><?php  echo $pays[$i]->account_email;//$pays[$i] ?></td>
					<td><?php  echo $pays[$i]->txn_id;//$pays[$i] ?></td>
					<td><?php  echo date('d-m-Y H:i:s',strtotime($pays[$i]->date_pay));//$pays[$i] ?></td>
					<td><?php  echo date('d-m-Y H:i:s',strtotime($pays[$i]->date_finish));//$pays[$i] ?></td>
					<td><?php  echo $pays[$i]->amount;//$pays[$i] ?></td>
					<td><?php  echo $pays[$i]->type_prempay;//$pays[$i] ?></td>
				</tr>
				
				<?php } ?>
				
			</tbody>
			
		</table>
				
	
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>