<!-- <html>
<body>
	<h1>Activate account for <?php //echo $identity;?></h1>
	<p>Please click this link to <?php// echo anchor('auth/activate_account/'. $user_id .'/'. $activation_token, 'Activate Your Account');?>.</p>
</body>
</html> -->
<html>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">

	<tbody>

	<tr>

	<td bgcolor="#ececec" align="center">

	<table width="640" cellspacing="0" cellpadding="0" border="0" style="margin:0 10px">

	<tbody>

	<tr>

	<td width="640" bgcolor="#ececec" height="30"></td>

	</tr>

	<tr>

	<td width="640" bgcolor="#4b4c44" height="20"></td>

	</tr>

	<tr>

	<td width="640" bgcolor="#ffffff" height="30"></td>

	</tr>

	<tr>

	<td width="640" bgcolor="#ffffff">

	<table width="640" cellspacing="0" cellpadding="0" border="0">

	<tbody>

	<tr>

	<td width="30"></td>

	<td width="580">

	<table width="580" cellspacing="0" cellpadding="0" border="0">

	<tbody>

        <tr>

        <td width="580">

	<div align="justify">

        <br>Bienvenido <?php echo $identity; ?> a <span class="il">Autopublicador Social</span>.

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

	</div>

	</td>

	</tr>

	<tr>

	<td width="580" height="10"></td>

	</tr>

	</tbody>

	</table>

	</td>

	<td width="30"></td>

	</tr>

	</tbody>

	</table>

	</td>

	</tr>

	<tr>

	<td width="640" bgcolor="#ffffff" height="15"></td>

	</tr>

	<tr>

	<td width="640" bgcolor="#4b4c44" height="20"></td>

	</tr>

	<tr>

	<td width="640" bgcolor="#ececec" height="30"></td>

	</tr>

	</tbody>

	</table>

	</td>

	</tr>

	</tbody>

	</table>


</body>
</html>