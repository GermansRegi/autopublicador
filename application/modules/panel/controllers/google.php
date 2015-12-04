<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Google extends CI_Controller {

	private $is_guest=false;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('bases_datos_model');
		$this->load->model('anuncios_model');
		$this->load->model('social_users');		

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
 		$this->load->library('form_validation');
 		$this->load->library('form_validation_global');
 		$this->form_validation_global->validarSession();

  		// IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded!
 		// It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
		/*$this->auth = new stdClass;

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
			else if( uri_string()=='facebook')
			{

				redirect(base_url().'panel/index');

			}
			
			$this->load->vars('section_app','panel');

			$guest=$this->flexi_auth->get_user_by_id_query($this->flexi_auth->get_user_id(),array("guestPremium","uacc_group_fk",'upro_timezone_offset'))->result();	
			$timezones=$this->config->item('timezones');
			$this->session->set_userdata('timezone',$timezones[$guest[0]->upro_timezone_offset]);
			//date_default_timezone_set($timezones[$guest[0]->upro_timezone_offset]);
			//si es usuari amb la gratuit
			if ($this->flexi_auth->is_privileged('acces user free'))
			{
				// si es usuari amb pla gratuit pero es estat de guest(convidat)
				if($guest[0]->guestPremium=="1")
				{
					$this->load->vars('privilege_user_app','prem');
					$this->is_guest=true;
				}
				else
				{

					$this->load->vars('privilege_user_app','free');
					//si no es guest i te pla gratuit no te access a prog_periodicas
					if("panel/facebook/prog_periodicas"==uri_string())
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
				}
			
			}
			//si es usuari premium
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
	public function connectar()
	{
		$this->load->model("social_user_accounts");
		$numUsers=$this->social_users->count_by(array('user_app'=>$this->flexi_auth->get_user_id()));
		$numAcc=$this->social_user_accounts->count_by(array('user_app'=>$this->flexi_auth->get_user_id()));
			
			
			
		if ($this->flexi_auth->is_privileged('acces user free') && $this->is_guest==false && ($numAcc+$numUsers)>3)
		{
			
			 	$url=base_url().'panel/perfil/planes';
				$this->data['message']='No estas autorizado a realizar esta acción.<br><b> Has alcanzado el límite de cuentas possibles a añadir con el plan gratuito.</b>';
				$this->data['result']='error';
	
				$this->data['titlepage']="Google+ - Añadir cuentas";
				$this->load->view("panel/google/anadir_paginas",$this->data);

		}
		else
		{
			$this->load->library('GooglePlusLib','','googlelib');
			if($this->googlelib->getSession()==null)
			{
			
					redirect($this->googlelib->getLoginUrl());
				
			}
			else
			{
				var_dump($this->googlelib->getSession());

			}
		}
	}
	
}