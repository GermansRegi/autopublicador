<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rss extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('rss_model');
		$this->load->model('social_users');		
		$this->load->model('social_user_accounts');

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
/*		$this->auth = new stdClass;

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

			$guest=$this->flexi_auth->get_user_by_id_query($this->flexi_auth->get_user_id(),array("guestPremium","uacc_group_fk"))->result();	
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

			// Define a global variable to store data that is then used by the end view page.
		$this->data = null;
		$this->data['username']=$this->flexi_auth->get_user_by_id_query($this->flexi_auth->get_user_id(),array("upro_first_name"))->result();	*/
	}
	public function index()
	{

		$this->data['rssrows']=$this->rss_model->get_many_by(array('user_app'=>$this->flexi_auth->get_user_id()));
		$this->data['titlepage']="RSS";
		$this->load->view('rss/index',$this->data);
	}
	public function checkSelectedrss($str)
	{

		if (!isset($str['fb']) && !isset($str['tw']))
		{
			
			$this->form_validation->set_message('checkSelectedrss', 'Debe seleccionar las cuentas donde publicar');
			return FALSE;
		}
		else 
		{
			return TRUE;
		}
	}
	public function crear()
	{
		$this->form_validation->set_rules('rss_url', 'Url', 'trim|valid_url|required');
		$this->form_validation->set_rules('rss_perm_sentences', 'Frases Permanentes', 'trim');
		$this->form_validation->set_rules('ck_group_ap', 'Cuentas', 'callback_checkSelectedrss');

		if($this->input->post())
		{
			if($this->form_validation->run()==TRUE)
			{
				$dades=$this->input->post('ck_group_ap');
				$this->rss_model->insert(array(
					'ids_fb'=>(isset($dades['fb'])?json_encode($dades['fb']):"[]"),
					'ids_twt'=>(isset($dades['tw'])?json_encode($dades['tw']):"[]"),
					'url_rss'=>$this->input->post('rss_url'),
					'perm_sentences'=>$this->input->post('rss_perm_sentences'),
					'user_app'=>$this->flexi_auth->get_user_id()));
				echo json_encode(array('msg_success'=>'Fuente creada correctamente'));      
			}
			else
			{
				$errors = $this->form_validation->error_array();
                   echo json_encode(array('msg_errors'=>$errors));      
			}	
			exit;

		}
		$this->data['titlepage']="RSS - Crear fuente";
		$this->load->library('form_validation_global');
		$this->data['accordionfb']['arraydata']=$this->form_validation_global->getAccountsByFolderFB();
		$this->data['accordiontw']['arraydata']=$this->form_validation_global->getAccountsByFolderTwt();
			$this->data['userstw']=$this->social_users->getUserAppUsers(array('social_network'=>'tw','user_app'=>$this->flexi_auth->get_user_id()));
		$this->load->view('rss/crear',$this->data);
	}
	
	public function editar($id)
	{
		$this->form_validation->set_rules('rss_url', 'Url', 'trim|required');
		$this->form_validation->set_rules('rss_perm_sentences', 'Frases Permanentes', 'trim');
		$this->form_validation->set_rules('ck_group_ap', 'Cuentas', 'callback_checkSelectedrss');

		if($this->input->post())
		{
			if($this->form_validation->run()==TRUE)
			{
				$dades=$this->input->post('ck_group_ap');
				$this->rss_model->update_by(array(
					'ids_fb'=>(isset($dades['fb'])?json_encode($dades['fb']):"[]"),
					'ids_twt'=>(isset($dades['tw'])?json_encode($dades['tw']):"[]"),
					'url_rss'=>$this->input->post('rss_url'),
					'perm_sentences'=>$this->input->post('rss_perm_sentences')),
				array('id'=>$id,
					'user_app'=>$this->flexi_auth->get_user_id()));
				echo json_encode(array('msg_success'=>'Fuente modificada correctamente'));      
			}
			else
			{
				$errors = $this->form_validation->error_array();
                   echo json_encode(array('msg_errors'=>$errors));      
			}	
			exit;

		}
		$rss_edit=$this->rss_model->get_by_id($id);
		$this->data['titlepage']="Editar fuente RSS";
		$this->load->library('form_validation_global');
		$this->data['accordionfb']['arraydata']=$this->form_validation_global->getAccountsByFolderFB();
		$this->data['accordiontw']['arraydata']=$this->form_validation_global->getAccountsByFolderTwt();
			$this->data['rssedit']=$rss_edit[0];

			$this->data['userstw']=$this->social_users->getUserAppUsers(array('social_network'=>'tw','user_app'=>$this->flexi_auth->get_user_id()));
		$this->load->view('rss/editar',$this->data);	
	}
	public function delete()
	{
		if($this->input->post('id'))
		{
			$this->rss_model->delete_by(array('id'=>$this->input->post('id')));

		}
	}

}

/* End of file rss.php */
/* Location: ./application/modules/panel/controllers/rss.php */