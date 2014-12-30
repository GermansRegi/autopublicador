<!--<html>
<body>
	<h1>Reset Password for <?php //echo $identity;?></h1>
	<?php
		// Note: This template links to the manual password reset page, where the user can enter their new password themselves.
		// If you wish to automatically generate a new password for them, change the link from 'manual_reset_forgotten_password' to 'auto_reset_forgotten_password'
	?>
	<p>Please click this link to <?php //echo anchor('panel/manual_reset_forgotten_password/'.$user_id.'/'.$forgotten_password_token, 'Reset Your Password');?>.</p>
</body>
</html>-->
<html>
<body>
	<h4> Restablecimiento de contraseña para <?php echo  $identity;?></h4>
	<p> Por favor acceda a este enlace para <?php echo anchor(base_url().'panel/auto_reset_forgotten_password/'.$user_id.'/'.$forgotten_password_token, 'Restablecer su contraseña')	;?></p>
        <p>
            Saludos,<br/>
            Equipo de <span class="il">Autopublicador Social</span>.
        </p>
</body>
</html>