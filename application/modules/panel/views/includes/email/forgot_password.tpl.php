        

	<h4> Restablecimiento de contraseña para <?php echo  $identity;?></h4>
	<p> Por favor acceda a este enlace para <?php echo anchor(base_url().'panel/auto_reset_forgotten_password/'.$user_id.'/'.$forgotten_password_token, 'Restablecer su contraseña')	;?></p>
        <p>
            Saludos,<br/>
            Equipo de <span class="il">Autopublicador Social</span>.
        </p>
