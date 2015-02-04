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
        <section>
        	
        

	<h4> Restablecimiento de contraseña para <?php echo  $identity;?></h4>
	<p> Por favor acceda a este enlace para <?php echo anchor(base_url().'panel/auto_reset_forgotten_password/'.$user_id.'/'.$forgotten_password_token, 'Restablecer su contraseña')	;?></p>
        <p>
            Saludos,<br/>
            Equipo de <span class="il">Autopublicador Social</span>.
        </p>
		</section>

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