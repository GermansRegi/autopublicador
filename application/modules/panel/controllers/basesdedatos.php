<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Basesdedatos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('bases_datos_model');
		
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

			if ($this->flexi_auth->is_privileged('acces user free'))
			{
				
				$this->load->vars('privilege_user_app','free');
			}
			else if ($this->flexi_auth->is_privileged('acces user prem'))
			{
				$this->load->vars('privilege_user_app','prem');
			}
		}

		// Note: This is only included to create base urls for purposes of this demo only and are not necessarily considered as 'Best practice'.
		//$this->load->vars('base_url', base_url(). 'auth/');
		//$this->load->vars('includes_dir', 'http://localhost:8888/flexi_auth/includes/');
		//$this->load->vars('current_url', $this->uri->uri_to_assoc(1));

		// Define a global variable to store data that is then used by the end view page.
		$this->data = null;
	
	}
	public function index()
	{
		$res=$this->bases_datos_model->getAll(array('user_app'=>$this->flexi_auth->get_user_id()));
		$data['arbbdd']=$res;
		$this->load->view('panel/basesdedatos/index',$data);

		

	
		
	}

	public function crear()
	{
		


		if($this->input->post())		
		{
		
			
			$rules_validate=array(
				array('field' => 'basededatos_create_name', 'label' => 'Nombre', 'rules' => 'required|trim'),
				array('field' => 'content', 'label' => 'Tipo', 'rules' => 'required'),
				array('field' => 'basededatos_create_social', 'label' => 'Red social', 'rules' => 'required')
				);



				$this->form_validation->set_rules($rules_validate);

				if($this->form_validation->run()==TRUE)
				{

					
					
					$idcreated=$this->bases_datos_model->insertNew(array(
						'socialnetwork'=>$this->input->post('basededatos_create_social'),
						'content'=>$this->input->post('content'),
						'name'=>$this->input->post('basededatos_create_name'),
						'user_app'=>$this->flexi_auth->get_user_id(),
						'is_admin'=>1));
					echo json_encode(array('msg_success'=>'Datos guardados con éxito','idcreated'=>$idcreated));
				}
				else
				{

					$this->data['message'] = $this->form_validation->error_array();	
					echo json_encode(array('msg_errors'=>$this->data['message']));

				}
				
		
			exit;	
		}
		
			$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
			$this->load->view('panel/basesdedatos/crear',$this->data);
			
	}

}

/* End of file basesdedatos.php */
/* Location: ./application/modules/panel/controllers/basesdedatos.php */