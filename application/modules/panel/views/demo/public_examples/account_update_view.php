<!DOCTYPE html>
<head>

    <title>Autopublicador Social</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8" />
    <?php echo $this->load->view('includes2/head');?>




</head>

<body>
    <?php echo $this->load->view('includes2/header');

?>
            
			<section class="content">
				<section class="container">
					
<section class="row">
<section class="col-md-12">


<section id="infoMessage"><?php echo isset($message)?$message:'';?></section>      
<section class="col-md-6">
	<h3> Datos personales</h3>
	<?php echo form_open(uri_string());?>

      <section class="form-group">    
            <label class="label-form">Correo eletrónico</label>
           <input type="text" disabled class=" form-control" value="<?php echo $user[$this->flexi_auth->db_column('user_acc', 'email')]; ?>"/>
            
      </section>
	
      <section class="form-group">    
            <label>Plan actual</label><br />
            <?php $gropu=$this->flexi_auth->get_users_group_query('ugrp_name')->result();
            	echo $gropu[0]->ugrp_name; ?>
            
      </section>
        <section class="form-group">    
          
            <label class="label-form">Nombre</label>
           <input type="text" class="form-control " name="update_first_name" value="<?php echo $user['upro_first_name']; ?>"/>
            
      </section>
      	<div class="text-center col-sm-12">
			
			<input class="btn btn-primary" type="submit" name="update_account" id="submit" value="Guardar"	/>
		</div>
      </form>
</section>
<section class="col-md-6">
	<h3> Cambiar contraseña</h3>
					<?php echo form_open(uri_string());?>

							<div class="form-group">
								<label class="label-form" for="current_password">Contraseña antigua:</label>
								<input class="form-control" type="password" id="current_password" name="current_password" value="<?php echo set_value('current_password');?>"/>
							</div>
							<div class="form-group">
								<label class="label-form" for="new_password">Nueva contraseña:</label>
								<input class="form-control" type="password" id="new_password" name="new_password" value="<?php echo set_value('new_password');?>"/>
							</div>
							<div class="form-group">
								<label class="label-form" for="confirm_new_password">Repetir nueva contraseña:</label>
								<input class="form-control" type="password" id="confirm_new_password" name="confirm_new_password" value="<?php echo set_value('confirm_new_password');?>"/>
							</div>
							<div class="text-center col-sm-12">
								
								<input class="btn btn-primary" type="submit" name="change_password" id="submit" value="Cambiar"	/>
							</div>
					
					
				
 </section>
      

<?php echo form_close();?>
</section>
</section>
</section>
</section>                  
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>