<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel extends CI_Controller {

    function __construct()
    {
        parent::__construct();

		// To load the CI benchmark and memory usage profiler - set 1==1.
		if (1==2)
		{
			$sections = array(
				'benchmarks' => TRUE, 'memory_usage' => TRUE,
				'config' => FALSE, 'controller_info' => FALSE, 'get' => FALSE, 'post' => FALSE, 'queries' => FALSE,
				'uri_string' => FALSE, 'http_headers' => FALSE, 'session_data' => FALSE
			);
			$this->output->set_profiler_sections($sections);
			$this->output->enable_profiler(TRUE);
		}

		// Load required CI libraries and helpers.
		$this->load->database();
		$this->load->library('session');
 		$this->load->helper('url');
 		$this->load->helper('form');
 		$this->load->helper('language');

  		// IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded!
 		// It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
		$this->auth = new stdClass;

		// Load 'standard' flexi auth library by default.
		$this->load->library('flexi_auth');
		$this->data=null;
     	// Redirect users logged in via password (However, not 'Remember me' users, as they may wish to login properly).
		if ($this->flexi_auth->is_logged_in_via_password() && uri_string() != 'panel/logout')
		{
			// Preserve any flashdata messages so they are passed to the redirect page.
			if ($this->session->flashdata('message')) { $this->session->keep_flashdata('message'); }

			// Redirect logged in admins (For security, admin users should always sign in via Password rather than 'Remember me'.
			if ($this->flexi_auth->is_admin())
			{
				redirect(base_url().'admin');
			}
			else if( uri_string()=='panel')
			{

				redirect(base_url().'panel/index');

			}
			
			$this->load->vars('section_app','panel');
			$guest=$this->flexi_auth->get_user_by_id_query($this->flexi_auth->get_user_id(),array("guestPremium","uacc_group_fk"))->result();	

			if ($this->flexi_auth->is_privileged('acces user free'))
			{
				if($guest[0]->guestPremium=="1")
				$this->load->vars('privilege_user_app','prem');
				else
				$this->load->vars('privilege_user_app','free');
			}
			else if ($this->flexi_auth->is_privileged('acces user prem') ) 
			{
				$this->load->vars('privilege_user_app','prem');
			}
			$this->data['username']=$this->flexi_auth->get_user_by_id_query($this->flexi_auth->get_user_id(),array("upro_first_name"))->result();	
		}
		
		// Note: This is only included to create base urls for purposes of this demo only and are not necessarily considered as 'Best practice'.
		//$this->load->vars('base_url', base_url(). 'auth/');
		//$this->load->vars('includes_dir', 'http://localhost:8888/flexi_auth/includes/');
		//$this->load->vars('current_url', $this->uri->uri_to_assoc(1));

		// Define a global variable to store data that is then used by the end view page.
		
		//$this->data['username']=$this->flexi_auth->get_user_by_id_query($this->flexi_auth->get_user_id(),array("upro_first_name"))->result();	

	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	// flexi auth demo
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * Many of the functions within this controller load a custom model called 'demo_auth_model' that has been created for the purposes of this demo.
	 * The 'demo_auth_model' file is not part of the flexi auth library, it is included to demonstrate how some of the functions of flexi auth can be used.
	 *
	 * These demos show working examples of how to implement some (most) of the functions available from the flexi auth library.
	 * This particular calculhmac(clent, data)ontroller 'auth', is used as the main login page, user registration, and for forgotten password requests.
	 *
	 * All demos are to be used as exactly that, a demonstation of what the library can do.
	 * In a few cases, some of the examples may not be considered as 'Best practice' at implementing some features in a live environment.
	*/

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	// Login / Registration
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * index
	 * Forwards to 'login'.
	 */
	function principal()
    {
    		//$this->load->view('index_view');
    

    	
		
	}
	function index()
	{
		if($this->flexi_auth->is_logged_in())
		{
			$guest=$this->flexi_auth->get_user_by_id_query($this->flexi_auth->get_user_id(),array("guestPremium","uacc_date_added"))->result();	
			

			if ($this->flexi_auth->is_privileged('acces user free'))
			{
				if($guest[0]->guestPremium=="1")
				{
					$datestart=new DateTime($guest[0]->uacc_date_added);
					$datestart->modify("-7 day");
					$datend=new DateTime('now');
					$interval	=$datestart->diff($datend);
						
					$this->data['texto']="Esta usando la versión completa en periodo de prueba. Le quedan ".$interval->days." días de versión premium gratuita";	
				}								
				
				else
				{
					$this->data['texto']="Esta usando la version gratuita, actualize a la version completa haciendo click <a href='".base_url().'panel/perfil/planes'."'> aquí.</a>";	
				}
				
			}
			else if ($this->flexi_auth->is_privileged('acces user prem') ) 
			{
				$this->load->model("payments");
				$pays=$this->payments->getLastPayment(array("user_app"=>$this->flexi_auth->get_user_id(),"finished"=>0));
				var_dump($pays);
				$datestart=new DateTime($pays[0]->last);
				$arrayName = array('mensual' =>30 ,"trimestral"=>90,"anual"=>365 );
				$datestart->modify('+'.$arrayName[$pays[0]->type_prempay]." day");

				$datend=new DateTime('now');
				$interval	=$datestart->diff($datend);
				$this->data['texto']="Gracias por usar la versión completa, le quedan  ".$interval->days." días. Renuévelo   <a href='".base_url().'panel/perfil/planes'."'> aquí.</a>";
			}

			$this->data['titlepage']="Bienvenido a su panel de usuario";

			echo $this->load->view('index',$this->data);
		}
		else
		$this->login();
	}

	/**
	 * login
	 * Login page used by all user types to log into their account.
	 * This demo includes 3 example accounts that can be logged into via using either their email address or username. The login details are provided within the view page.
	 * Users without an account can register for a new account.
	 * Note: This page is only accessible to users who are not currently logged in, else they will be redirected.
	 */
    function login()
    {


		// If 'Login' form has been submited, attempt to log the user in.
		if ($this->input->post('login_user'))
		{

			$this->load->model('demo_auth_model');
			$this->demo_auth_model->login();
		}

		// CAPTCHA Example
		// Check whether there are any existing failed login attempts from the users ip address and whether those attempts have exceeded the defined threshold limit.
		// If the user has exceeded the limit, generate a 'CAPTCHA' that the user must additionally complete when next attempting to login.
		if ($this->flexi_auth->ip_login_attempts_exceeded())
		{
			/**
			 * reCAPTCHA
			 * http://www.google.com/recaptcha
			 * To activate reCAPTCHA, ensure the 'recaptcha()' function below is uncommented and then comment out the 'math_captcha()' function further below.
			 *
			 * A boolean variable can be passed to 'recaptcha()' to set whether to use SSL or not.
			 * When displaying the captcha in a view, if the reCAPTCHA theme has been set to one of the template skins (See https://developers.google.com/recaptcha/docs/customization),
			 *  then the 'recaptcha()' function generates all the html required.
			 * If using a 'custom' reCAPTCHA theme, then the custom html must be PREPENDED to the code returned by the 'recaptcha()' function.
			 * Again see https://developers.google.com/recaptcha/docs/customization for a template 'custom' html theme.
			 *
			 * Note: To use this example, you will also need to enable the recaptcha examples in 'models/demo_auth_model.php', and 'views/demo/login_view.php'.
			*/
			#$this->data['captcha'] = $this->flexi_auth->recaptcha(FALSE);

			/**
			 * flexi auths math CAPTCHA
			 * Math CAPTCHA is a basic CAPTCHA style feature that asks users a basic maths based question to validate they are indeed not a bot.
			 * For flexibility on CAPTCHA presentation, the 'math_captcha()' function only generates a string of the equation, see the example below.
			 *
			 * To activate math_captcha, ensure the 'math_captcha()' function below is uncommented and then comment out the 'recaptcha()' function above.
			 *
			 * Note: To use this example, you will also need to enable the math_captcha examples in 'models/demo_auth_model.php', and 'views/demo/login_view.php'.
			*/
			# $this->data['captcha'] = $this->flexi_auth->math_captcha(FALSE);
		}

		// Get any status message that may have been set.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		$this->data['titlepage']="Acceda a su cuenta";
		$this->load->view('demo/login_view', $this->data);
    }

	/**
	 * login_via_ajax
	 * A simplified version of the above 'login' method that instead uses ajax to submit a users credentials.
	 * This demo includes 3 example accounts that can be logged into via using either their email address or username. The login details are provided within the view page.
	 * Note: This page is only accessible to users who are not currently logged in, else they will be redirected.
	 */
    function login_via_ajax()
    {
		if ($this->input->is_ajax_request())
		{
			$this->load->model('demo_auth_model');

			$this->demo_auth_model->login_via_ajax();

			die($this->flexi_auth->is_logged_in());
		}
		else
		{
			$this->load->view('demo/login_via_ajax_view', $this->data);
		}
    }

	/**
	 * register_account
	 * User registration page used by all new users wishing to create an account.
	 * Note: This page is only accessible to users who are not currently logged in, else they will be redirected.
	 */
	function register_account()
	{
		// Redirect user away from registration page if already logged in.
		if ($this->flexi_auth->is_logged_in())
		{
			redirect('panel');
		}
		// If 'Registration' form has been submitted, attempt to register their details as a new account.
		else if ($this->input->post('register_user'))
		{
			$this->load->model('demo_auth_model');
			$this->demo_auth_model->register_account();
		}

		// Get any status message that may have been set.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		$this->data['titlepage']="Regístrese";
		$this->load->view('demo/public_examples/register_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	// Account Activation
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * activate_account
	 * User account activation via email.
	 * The default setup of this demo requires that new account registrations must be authenticated via email before the account is activated.
	 * In this demo, this page is accessed via an activation link in the 'views/includes/email/activate_account.tpl.php' email template.
	 */
	function activate_account($user_id, $token = FALSE)
	{
		// The 3rd activate_user() parameter verifies whether to check '$token' matches the stored database value.
		// This should always be set to TRUE for users verifying their account via email.
		// Only set this variable to FALSE in an admin environment to allow activation of accounts without requiring the activation token.
		$this->flexi_auth->activate_user($user_id, $token, TRUE);

		// Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
		$this->session->set_flashdata('message', $this->flexi_auth->get_messages());

		redirect('panel');
	}

	/**
	 * resend_activation_token
	 * Resend user an activation token via email.
	 * If a user has not received/lost their account activation email, they can request a new activation email to be sent to them.
	 * In this demo, this page is accessed via a link on the login page.
	 */
	function resend_activation_token()
	{
		// If the 'Resend Activation Token' form has been submitted, resend the user an account activation email.
		if ($this->input->post('send_activation_token'))
		{
			$this->load->model('demo_auth_model');
			$this->demo_auth_model->resend_activation_token();
		}

		// Get any status message that may have been set.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

		$this->load->view('demo/public_examples/resend_activation_token_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	// Forgotten Password
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * forgotten_password
	 * Send user an email to verify their identity. Via a unique link in this email, the user is redirected to the site so they can then reset their password.
	 * In this demo, this page is accessed via a link on the login page.
	 *
	 * Note: This is step 1 of an example of allowing users to reset a forgotten password manually.
	 * See the auto_reset_forgotten_password() function below for an example of directly emailing the user a new randomised password.
	 */
	function forgotten_password()
	{
		// If the 'Forgotten Password' form has been submitted, then email the user a link to reset their password.
		if ($this->input->post('send_forgotten_password'))
		{
			$this->load->model('demo_auth_model');
			$this->demo_auth_model->forgotten_password();
		}

		// Get any status message that may have been set.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		$this->data['titlepage']="Recuperación de contraseña";
		$this->load->view('demo/public_examples/forgot_password_view', $this->data);
	}

	/**
	 * manual_reset_forgotten_password
	 * This is step 2 (The last step) of an example of allowing users to reset a forgotten password manually.
	 * See the auto_reset_forgotten_password() function below for an example of directly emailing the user a new randomised password.
	 * In this demo, this page is accessed via a link in the 'views/includes/email/forgot_password.tpl.php' email template, which must be set to 'auth/manual_reset_forgotten_password/...'.
	 */
	function manual_reset_forgotten_password($user_id = FALSE, $token = FALSE)
	{
		// If the 'Change Forgotten Password' form has been submitted, then update the users password.
		if ($this->input->post('change_forgotten_password'))
		{
			$this->load->model('demo_auth_model');
			$this->demo_auth_model->manual_reset_forgotten_password($user_id, $token);
		}

		// Get any status message that may have been set.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

		$this->load->view('demo/public_examples/forgot_password_update_view', $this->data);
	}

	/**
	 * auto_reset_forgotten_password
	 * This is an example of automatically reseting a users password as a randomised string that is then emailed to the user.
	 * See the manual_reset_forgotten_password() function above for the manual method of changing a forgotten password.
	 * In this demo, this page is accessed via a link in the 'views/includes/email/forgot_password.tpl.php' email template, which must be set to 'auth/auto_reset_forgotten_password/...'.
	 */
	function auto_reset_forgotten_password($user_id = FALSE, $token = FALSE)
	{
		// forgotten_password_complete() will validate the token exists and reset the password.
		// To ensure the new password is emailed to the user, set the 4th argument of forgotten_password_complete() to 'TRUE' (The 3rd arg manually sets a new password so set as 'FALSE').
		// If successful, the password will be reset and emailed to the user.
		$this->flexi_auth->forgotten_password_complete($user_id, $token, FALSE, TRUE);

		// Set a message to the CI flashdata so that it is available after the page redirect.
		$this->session->set_flashdata('message', $this->flexi_auth->get_messages());

		redirect('panel');
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	// Logout
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * logout
	 * This example logs the user out of all sessions on all computers they may be logged into.
	 * In this demo, this page is accessed via a link on the demo header once a user is logged in.
	 */
	function logout()
	{
		// By setting the logout functions argument as 'TRUE', all browser sessions are logged out.
		$this->flexi_auth->logout(TRUE);

		// Set a message to the CI flashdata so that it is available after the page redirect.
		$this->session->set_flashdata('message', $this->flexi_auth->get_messages());

		redirect('panel');
    }

	/**
	 * logout_session
	 * This example logs the user only out of their CURRENT browser session (e.g. Internet Cafe), but no other logged in sessions (e.g. Home and Work).
	 * In this demo, this controller method is actually not linked to. It is included here as an example of logging a user out of only their current session.
	 */
	function logout_session()
	{
		// By setting the logout functions argument as 'FALSE', only the current browser session is logged out.
		$this->flexi_auth->logout(FALSE);

		// Set a message to the CI flashdata so that it is available after the page redirect.
		$this->session->set_flashdata('message', $this->flexi_auth->get_messages());

		redirect('panel');
    }
    function IPNlistener()
    {

    		$raw_post_data = file_get_contents('php://input');
		$raw_post_array = explode('&', $raw_post_data);
		$myPost = array();
		foreach ($raw_post_array as $keyval) {
		  $keyval = explode ('=', $keyval);
		  if (count($keyval) == 2)
		     $myPost[$keyval[0]] = urldecode($keyval[1]);
		}
		// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
		$req = 'cmd=_notify-validate';
		if(function_exists('get_magic_quotes_gpc')) {
		   $get_magic_quotes_exists = true;
		} 
		foreach ($myPost as $key => $value) {        
		   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
		        $value = urlencode(stripslashes($value)); 
		   } else {
		        $value = urlencode($value);
		   }
		   $req .= "&$key=$value";
		}

		 
		// Step 2: POST IPN data back to PayPal to validate

		$ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

		// In wamp-like environments that do not come bundled with root authority certificates,
		// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set 
		// the directory path of the certificate as shown below:
		// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
		if( !($res = curl_exec($ch)) ) {
		    // error_log("Got " . curl_error($ch) . " when processing IPN data");
		    curl_close($ch);
		    exit;
		}
		curl_close($ch);
		// inspect IPN validation result and act accordingly
		log_message('error','ipn paypal res: '.$res);
		if (strcmp ($res, "VERIFIED") == 0) {
		    // The IPN is verified, process it:
		    // check whether the payment_status is Completed
		    // check that txn_id has not been previously processed
		    // check that receiver_email is your Primary PayPal email
		    // check that payment_amount/payment_currency are correct
		    // process the notification
			
		    $item_name = $_POST['item_name'];
		    $item_number = $_POST['item_number'];
		    $payment_status = $_POST['payment_status'];
		    $payment_amount = $_POST['mc_gross'];
		    $payment_currency = $_POST['mc_currency'];
		    $txn_id = $_POST['txn_id'];
		    $receiver_email = $_POST['receiver_email'];
		    $payer_email = $_POST['payer_email'];
						$tipo_venta_aux = explode('-',$_POST['custom']);
						//var_dump($tipo_venta);
                            $tipo_venta = $tipo_venta_aux[0];
                            $user_id = $tipo_venta_aux[1];
                            log_message('error','paylapcoolpppp'.$_POST['payment_status'].':'.($_POST['payment_status']==="Completed"));
		    // assign posted variables to local variables
			if($_POST['payment_status']==="Completed")
			{
				$this->load->model('payments');
				
				$exist=$this->payments->notExist(array('txn_id'=>$txn_id,'user_app'=>$user_id));
				log_message('error','exist idnxt: '.$exist);
				if($this->payments->notExist(array('txn_id'=>$txn_id,'user_app'=>$user_id)))
				{
					   $pago_valido = false;

                            // Verificamos en base de datos
                            
 	                      $user=$this->flexi_auth->get_user_by_id_query($user_id)->result();
 	                       
 	                      if($user[0]->uacc_group_fk==2)
 	                      {
 	               			$lastPayemnt=$this->payments->getLastPayment(array('user_app'=>$user[0]->user_app));
 	               			$timezones=$this->config->item('timezones');
 	               			$datenow=new Datetime('now');
 	               			$datepayment=Datetime::createFromFormat('Y-m-d',$lastPayemnt[0]->last);

 	               			

 	               			$datediff=$datenow->diff($datepayment);
 	               			log_message('error','datefidd'.$datepayment->format('Y-m-d')." ". $datediff->days);
							$datenow2=new Datetime('now');
							$datenow2->modify("+".abs($datediff->days)." day");
	 	                      $res2=$this->payments->insert(array(	
	 	                      	'user_app'=>$user_id,
	 	                      	'date_pay'=>$datenow2->format('Y-m-d'),
	 	                      	'amount'=>$payment_amount,
	 	                      	'type_prempay'=>$tipo_venta,
	 	                      	'txn_id'=>(string)$txn_id,
	 	                      	'account_email'=>$payer_email,'finished'=>0));

 	                      	 	
 	                      }	
 	                      else
 	                      {
 	                      	  $res2=$this->payments->insert(array(
	 	                      	'user_app'=>$user_id,
	 	                      	'date_pay'=>date('Y-m-d'),
	 	                      	'amount'=>$payment_amount,
	 	                      	'type_prempay'=>$tipo_venta,
	 	                      	'txn_id'=>(string)$txn_id,
	 	                      	'account_email'=>$payer_email,'finished'=>0));


 	                      }
 	                      

 	                      $res=$this->db->query('update user_accounts set uacc_group_fk=2 where user_app='.$user_id);
 	                      	



 	                      log_message('error','query result'.$res."res insert payments:".$res2);



				}

			}
		       

                         


		    
		} else if (strcmp ($res, "INVALID") == 0) {
		    // IPN invalid, log for manual investigation
		    echo "The response from IPN was: <b>" .$res ."</b>";
		}
    }
    
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */