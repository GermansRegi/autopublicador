<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Twitter extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('bases_datos_model');

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
			else if( uri_string()=='twitter')
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
		else
		{

			redirect('panel');
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
		$users=$this->social_users->getUserappUsers(array('user_app'=>$this->flexi_auth->get_user_id(),'social_network'=>'tw'));
		$this->load->model('folders');
		$this->data['folders']=$this->folders->get_many_by(array('user_app'=>$this->flexi_auth->get_user_id(),'social_network'=>"tw"));
		$arraydata=array('folders'=>array(),'nofolder'=>array());

		foreach ($this->data['folders'] as $key) {
			
			$arraydata['folders'][]=array('data'=>$key,'rows'=>array());
			
			
		}
		foreach ($users as $user) {
			if(is_null($user->folder_id))
			{
				$arraydata['nofolder'][]=$user;
			}
			else
			{
				if(count($arraydata['folders'])!=0)
					for($m=0;$m<count($arraydata['folders']);$m++)
					{
						//var_dump($arraydata[$key->type_account]['folders'][1]);
						if($arraydata['folders'][$m]['data']->id==$user->folder_id)
						$arraydata['folders'][$m]['rows'][]=$key;				
					}
			}
		}
		$this->data['titlepage']="Cuentas de twitter";

		
		$this->data['arraydata']=$arraydata;


			
		
		$this->load->view('twitter/index',$this->data);
	}
	public function connectar_twitter()
	{
		$this->load->library("twitterlib",'','twtlib');
			//$this->twtlib->reset_session();
		$res=$this->twtlib->auth(base_url('panel/twitter/callback'));
			
		
	}
	public function callback()
	{
		$this->load->library("twitterlib",'','twtlib');
		$res=$this->twtlib->checkresponse();
		if(is_array($res))
		{
			$this->twtlib->setAccessToken($res);
			$datauser=$this->twtlib->getUserdata();

			if($this->social_users->notExists($datauser->id,'tw')==true)
			{
				echo $this->social_users->insertNew(array(
				'user_id'=>$datauser->id,
				'username'=>$datauser->name,
				'social_network'=>'tw',
				'img_profile'=>$datauser->profile_image_url,
				'access_token'=>json_encode($res),
				'user_app'=>$this->flexi_auth->get_user_id(),
				'disabled'=>0));
			}
			else{
				$this->social_users->update_by(
				array(
					'img_profile'=>$datauser->profile_image_url,
					'access_token'=>json_encode($res),
					'username'=>$datauser->name),
				array('user_app'=>$this->flexi_auth->get_user_id(),
					'user_id'=>$datauser->id));
			}
			
			$this->data['titlepage']="Añadir cuentas";
			$this->data['message']="success";
			$this->load->view("twitter/anadir_cuentas",$this->data);

		}
		else
		{
			$this->data['titlepage']="Añadir cuentas";
			$this->data['message']="eror";
			$this->load->view("twitter/anadir_cuentas",$this->data);
		}
		
	}
	public function createFolder()
	{
		
		if($this->input->post())
		{
			$this->form_validation->set_rules('name', 'Nombre', 'required');
			
			if($this->form_validation->run()==FALSE)
			{
				$errors = $this->form_validation->error_array();
		                     echo json_encode(array('msg_errors'=>$errors));
		           
			}
			else
			{
				$this->load->model("folders");
				$arr=array(
				"name"=>$this->input->post("name"),
				"type"=>'user',
				'user_app'=>$this->flexi_auth->get_user_id(),
				"social_network"=>"tw"
				);
				if($this->folders->insert($arr)){
					echo json_encode(array('msg_success'=>'Datos guardados con éxito'));
				}	
			}
		
		}
		
	}
	

}

/* End of file twitter.php */
/* Location: ./application/modules/panel/controllers/twitter.php */