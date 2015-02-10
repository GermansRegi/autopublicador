																		<h1>Bienvenido <?php echo $identity; ?> a <span class="il">Autopublicador Social</span>.</h1>
																		<br>
																		<br>En nuestra web encontrará las mejores herramientas de publicación para sus páginas de facebook y twitter.
																		<br>
																		<br>Active su cuenta pulsando el siguiente enlace:
																		<br>
																		<br>
																		<?php echo anchor(base_url().'panel/activate_account/'. $user_id .'/'. $activation_token, 'Para activar pulse aquí');?>
																		<br>
																		<br>Si no funciona el enlace anterior, copie y pegue en su navegador esta url:
																		<br>
																		<?php
																		$url=anchor(base_url().'panel/activate_account/'. $user_id .'/'. $activation_token);
																		echo  anchor(base_url().'panel/activate_account/'. $user_id .'/'. $activation_token, $url); ?>
																		<br>
																		<br>No olvide que estamos a su dispocisión para cual cualquier consulta que desee, no dude en contactar con nosotros.
																		<br>
																		<br>Saludos.
																		<br>
																		<br>El equipo de <span class="il">Autopublicador Social</span>.
															
	