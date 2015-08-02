<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name: flexi auth lang - English
*
* Author:
* Rob Hussey
* flexiauth@haseydesign.com
* haseydesign.com/flexi-auth
*
* Released: 13/09/2012
*
* Description:
* English language file for flexi auth
*
* Requirements: PHP5 or above and Codeigniter 2.0+
*/

// Account Creation
$lang['account_creation_successful']				= 'Su cuenta ha sido creada con éxito.';
$lang['account_creation_unsuccessful']				= 'No se puede crear cuenta.';
$lang['account_creation_duplicate_email']			= 'Una cuenta con esta dirección de correo electrónico ya existe.';
$lang['account_creation_duplicate_username']		= 'Una cuenta con este nombre de usuario ya existeUna cuenta con este nombre de usuario ya existe.';
$lang['account_creation_duplicate_identity'] 		= 'Una cuenta con esta identidad ya existe.';
$lang['account_creation_insufficient_data']			= 'Datos insuficientes para crear una cuenta. Asegurate de introducir una identidad y una contraseña válidos.';

// Password
$lang['password_invalid']							= "El campo %s no es válido.";
$lang['password_change_successful'] 	 	 		= 'La contraseña ha sido cambiada con éxito.';
$lang['password_change_unsuccessful'] 	  	 		= 'La contraseña actual que ha introducido no coincide con su contraseña.';
$lang['password_token_invalid']  					= 'El enlace des del que ha accedido a ésta página ya no es válido. Compruebe en su correo electrónico si le ha llegado uno más reciente o vuelva a iniciar la recuperación de su contraseña.';
$lang['email_new_password_successful']				= 'Le hemos enviado la nueva contraseña por correo electrónico.';
$lang['email_forgot_password_successful']	 		= 'Le hemos enviado un correo electrónico para restablecer su contraseña.';
$lang['email_forgot_password_unsuccessful']  		= 'No se ha podido restablecer la contraseña.';

// Activation
$lang['activate_successful']						= 'Su cuenta ha sido activada.';
$lang['activate_unsuccessful']						= 'No se puede activar la cuenta.';
$lang['deactivate_successful']						= 'La cuenta ha sido desactivada.';
$lang['deactivate_unsuccessful']					= 'No puede desactivar la cuenta.';
$lang['activation_email_successful'] 	 			= 'Revise el correo electrónico que le hemos enviado para activar su cuenta.';
$lang['activation_email_unsuccessful']  	 		= 'No se puede enviar correo electrónico de activación.';
$lang['account_requires_activation'] 				= 'Tiene que activar su cuenta a través del correo electrónico que le hemos enviado.';
$lang['account_already_activated'] 					= 'Su cuenta ya ha sido activada.';
$lang['email_activation_email_successful']			= 'Un correo electrónico ha sido enviado para activar su nueva dirección de correo electrónico.';
$lang['email_activation_email_unsuccessful']		= 'No se puede enviar un correo electrónico para activar su nueva dirección de correo electrónico.';

// Login / Logout
$lang['login_successful']							= 'Usted ha sido ingresado con éxito.';
$lang['login_unsuccessful']							= 'Los datos de acceso que ha introducido son incorrectos.';
$lang['logout_successful']							= 'Ha salido con éxito.';
$lang['login_details_invalid'] 						= 'Sus datos de acceso no son válidos.';
$lang['captcha_answer_invalid'] 					= 'La respuesta CAPTCHA es incorrecta.';
$lang['login_attempts_exceeded'] 					= 'Se han superado los intentos máximos de acceso, por favor espere unos momentos antes de volver a intentarlo.';
$lang['login_session_expired']						= 'Su inicio de sesión ha expirado.';
$lang['account_suspended'] 							= 'Su cuenta ha sido suspendida.';

// Account Changes
$lang['update_successful']							= 'Información de la cuenta se ha actualizado correctamente.';
$lang['update_unsuccessful']						= 'No se puede actualizar la información de la cuenta.';
$lang['delete_successful']							= 'Información de la cuenta se ha eliminado correctamente.';
$lang['delete_unsuccessful']						= 'No se puede eliminar la información de la cuenta.';

// Form Validation
$lang['form_validation_duplicate_identity'] 		= "Una cuenta con esta dirección de correo electrónico o nombre de usuario ya existe.";
$lang['form_validation_duplicate_email'] 			= "El correo electrónico del campo% s no está disponible.";
$lang['form_validation_duplicate_username'] 		= "El nombre de usuario del campo% s no está disponible..";
$lang['form_validation_current_password'] 			= "El campo %s no es válido.";