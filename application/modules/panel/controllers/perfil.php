<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perfil extends CI_Controller {

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
 		$this->load->library('form_validation_global');
 		$this->form_validation_global->validarSession();

/*
  		// IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded!
 		// It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
		$this->auth = new stdClass;

		// Load 'standard' flexi auth library by default.
		$this->load->library('flexi_auth');

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
			if(uri_string()=='panel/perfil/pagocorrecto')
			{
				
			}
			$guest=$this->flexi_auth->get_user_by_id_query($this->flexi_auth->get_user_id(),array("guestPremium","uacc_group_fk",'upro_timezone_offset'))->result();	
		
		
		

			if ($this->flexi_auth->is_privileged('acces user free'))
			{
				
				if($guest[0]->guestPremium=="1")
				$this->load->vars('privilege_user_app','prem');
				else 
				$this->load->vars('privilege_user_app','free');
			
			}
			else if ($this->flexi_auth->is_privileged('acces user prem'))
			{
				$this->load->vars('privilege_user_app','prem');
			}
		}
		else
		{
			if($this->input->is_ajax_request())
			{
				echo json_encode(array('req_auth'=>1));
				//redirect_js(base_url().'panel');
				exit;
			}
			else
			redirect(base_url().'panel');
		}
		
		// Note: This is only included to create base urls for purposes of this demo only and are not necessarily considered as 'Best practice'.
		//$this->load->vars('base_url', base_url(). 'auth/');
		//$this->load->vars('includes_dir', 'http://localhost:8888/flexi_auth/includes/');
		//$this->load->vars('current_url', $this->uri->uri_to_assoc(1));

		// Define a global variable to store data that is then used by the end view page.
		$this->data = null;
		$this->data['username']=$this->flexi_auth->get_user_by_id_query($this->flexi_auth->get_user_id(),array("upro_first_name"))->result();	
		*/
	}
	public function planes()
	{
		$this->data['titlepage']="Perfil - Nuestros planes";
		$this->load->view('perfil/planes',$this->data);
	}
	public function change_password()
	{
		// If 'Update Password' form has been submitted, validate and then update the users password.
		
				$this->data['user'] = $this->flexi_auth->get_user_by_id_query();

		// Set any returned status/error messages.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

		$this->load->view('demo/public_examples/account_update_view', $this->data);
	}
	function index()
	{

		// If 'Update Account' form has been submitted, update the user account details.
		if ($this->input->post('update_account'))
		{
			$this->load->model('demo_auth_model');
			$this->demo_auth_model->update_account();

		}
		elseif ($this->input->post('change_password'))
		{
			$this->load->model('demo_auth_model');
			$this->demo_auth_model->change_password();
		}
		else
			$this->session->set_flashdata('message','');
		$user=$this->flexi_auth->get_user_by_id_query($this->flexi_auth->get_user_by_id())->result();

		// Get users current data.
		// This example does so via 'get_user_by_identity()', however, 'get_users()' using any other unqiue identifying column and value could also be used.
		$this->data['user'] = $this->flexi_auth->get_user_by_id_query()->result();
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		$this->data['titlepage']="Perfil - Editar datos";
		$this->load->view('demo/public_examples/account_update_view', $this->data);
	}
	function pagos()
	{
		$this->data['user'] = $this->flexi_auth->get_user_by_identity_row_array();
		$this->load->model("payments");
		$this->data["pays"]=$this->payments->getAllFromUser($this->flexi_auth->get_user_id());

		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		$this->data['titlepage']="Perfil - Registro de pagos realizados";
		$this->load->view('perfil/pagos', $this->data);	
	}
	public function pagocorrecto()
	{
		$user=$this->flexi_auth->get_user_by_id_query($this->flexi_auth->get_user_by_id())->result();
		
		$this->flexi_auth_model->set_login_sessions($user[0], TRUE);
		$this->data['titlepage']="Perfil - Pagos";
		$this->load->view('perfil/pagocorrecto',$this->data);
	}
	public function errordepago()
	{
		$this->data['titlepage']="Perfil - Pagos";
		$this->load->view('perfil/errordepago',$this->data);	
	}
}

/* End of file perfil.php */
/* Location: ./application/modules/panel/controllers/perfil.php */