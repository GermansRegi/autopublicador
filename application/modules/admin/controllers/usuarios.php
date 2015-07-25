<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {
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

  		// IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded!
 		// It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
		$this->auth = new stdClass;

		// Load 'standard' flexi auth library by default.
		$this->load->library('flexi_auth');

		// Check user is logged in as an admin.
		// For security, admin users should always sign in via Password rather than 'Remember me'.
		if (! $this->flexi_auth->is_logged_in_via_password() || ! $this->flexi_auth->is_admin())
		{
			// Set a custom error message.
			$this->flexi_auth->set_error_message('You must login as an admin to access this area.', TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('panel');
		}
		$this->load->vars('section_app','admin');

		$this->load->vars('base_url', base_url(). 'auth/');
		$this->load->vars('includes_dir', 'http://localhost:8888/flexi_auth/includes/');
		$this->load->vars('current_url', $this->uri->uri_to_assoc(1));

		// Define a global variable to store data that is then used by the end view page.
		$this->data = null;
	}
	public function index()
	{
		$this->data['users']=$this->flexi_auth->get_users_query()->result();
		$this->data['titlepage']="Usuarios";
		$this->load->view('users/index',$this->data);
	}
	public function basesdedatos($iduser)
	{
		if($iduser)
		{
			$this->load->model('anuncios_model');
			$this->load->model('bases_datos_model');
			$user=$this->flexi_auth->get_user_by_id_query($iduser,array('uacc_email'))->result();
			$this->data['bbdd']=$this->bases_datos_model->get_many_by(array('user_app'=>$iduser));
			$this->data['anuncios']=$this->anuncios_model->getAll(array('user_app'=>$iduser));

			$this->data['titlepage']="Bases de datos del usuario: ".$user[0]->uacc_email;
			$this->load->view('users/basesdedatos',$this->data);	


		}
	}
	public function cuentas($iduser)
	{
		if($iduser)
		{
			$this->load->model('panel/social_user_accounts');
			$this->load->model('panel/social_users');
				$user=$this->flexi_auth->get_user_by_id_query($iduser,array('uacc_email'))->result();
				
			$this->data['accountfb']=$this->social_user_accounts->getUserAppAccounts(array('user_app'=>$iduser));
			$this->data['userfb']=$this->social_users->getUserAppUsers(array('social_network'=>'fb','user_app'=>$iduser));
			$this->data['usertw']=$this->social_users->getUserAppUsers(array('social_network'=>'tw','user_app'=>$iduser));

			$this->data['titlepage']="Bases de datos del usuario: ".$user[0]->uacc_email;
			$this->load->view('users/cuentas',$this->data);	


		}
	}
	public function cambiarplan($user_app,$grup_id)
	{
			$res=$this->db->query('update user_accounts set uacc_group_fk='.$grup_id.' where user_app='.$user_app);
			redirect(base_url()."admin/usuarios");

	}

}

/* End of file usuarios.php */
/* Location: ./application/modules/admin/controllers/usuarios.php */