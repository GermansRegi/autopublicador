<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebook extends CI_Controller {
	private $user_fb;
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
 		$this->load->library('Facebooklib','','fblib');
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
			else if( uri_string()=='facebook')
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
	public function programar_facebook(){
	$this->load->model("social_user_accounts");
		$this->data['user_accounts']=$this->social_user_accounts->getUserAppAccounts(array('user_app'=>$this->flexi_auth->get_user_id()));
$this->data['titlepage']="Programar Facebook ";
		$this->load->view("panel/facebook/programar_facebook",$this->data);
	}

	public function index()
	{

		$this->load->model("social_user_accounts");
		$this->load->model("folders");
		$this->data['user_accounts']=$this->social_user_accounts->getUserAppAccounts(array('user_app'=>$this->flexi_auth->get_user_id()));
		$this->data['folders']=$this->folders->get_many_by(array('user_app'=>$this->flexi_auth->get_user_id(),'social_network'=>"fb"));
		$this->data['user_accounts_view']=null;
		$arraydata=array('page'=>array('folders'=>array(),'nofolder'=>array()),
			'group'=>array('folders'=>array(),'nofolder'=>array()),
			'event'=>array('folders'=>array(),'nofolder'=>array())
			);
		$n=0;
		
//		primer jhhas de recorrere array de tipusaccount
//		recorrer array carpetes amb comptess i si no hi ha carpeta al comptes
	
	//	$arrayfolder=array('data'=>'','rows'=>array());
		foreach ($this->data['folders'] as $key) {
			
			$arraydata[$key->type]['folders'][]=array('data'=>$key,'rows'=>array());
			
			
		}

		foreach ($this->data['user_accounts'] as $key) {
			
			if((int)$key->folder_id==0)
			{
				$arraydata[$key->type_account]['nofolder'][]=$key;				
			}
			else
			{
				if(count($arraydata[$key->type_account]['folders'])!=0)
				for($m=0;$m<count($arraydata[$key->type_account]['folders']);$m++)
				{
					//var_dump($arraydata[$key->type_account]['folders'][1]);
					if($arraydata[$key->type_account]['folders'][$m]['data']->id==$key->folder_id)
					$arraydata[$key->type_account]['folders'][$m]['rows'][]=$key;				
				}
				
			}
		}
		
		$this->data['titlepage']="Cuentas de facebook";

		
		$this->data['arraydata']=$arraydata;
		$this->load->view('panel/facebook/index',$this->data);

	}
	public function connectar_facebook()
	{
		


		if($this->fblib->getSession()==null)
		{
			redirect($this->fblib->login_url());

		}
		else
		{
			
			$user=$this->user_fb=$this->fblib->api('/me');
			
			$this->load->model("social_user_accounts");

			$pages=array();

			$pagesFace=$this->fblib->api('/me/accounts');
			
			foreach($pagesFace['data'] as $val)
	           {    
				
	             	$exist=$this->social_user_accounts->userAccountExist(array('id_social_user'=>$user['id'],'type_account'=>'page','user_app'=>$this->flexi_auth->get_user_id(),'idaccount'=>$val->id));
                    if(in_array('ADMINISTER',$val->perms) && $exist==false)
                    {
                    	$pages[]=$val;
                    }
                    
               }
               $groups=array();
               $groupsFace=$this->fblib->api('/me/groups');
			
			foreach($groupsFace['data'] as $val)
	           {    
				
	             	$exist=$this->social_user_accounts->userAccountExist(array('id_social_user'=>$user['id'],'type_account'=>'group','user_app'=>$this->flexi_auth->get_user_id(),'idaccount'=>$val->id));
                    if($exist==false)
                    {
                    	$groups[]=$val;
                    }
                    
               }
               $events=array();
               $eventsFace=$this->fblib->api('/me/events');
			
			foreach($eventsFace['data'] as $val)
	           {    
				
	             	$exist=$this->social_user_accounts->userAccountExist(array('id_social_user'=>$user['id'],'type_account'=>'event','user_app'=>$this->flexi_auth->get_user_id(),'idaccount'=>$val->id));
                    if($exist==false)
                    {
                    	$events[]=$val;
                    }
                    
               }
               $this->data['pages']=$pages;

			$this->data['events']=$events;
			$this->data['groups']=$groups;
				

			
			$this->data['titlepage']="Añadir cuentas de facebook";
			
			$this->load->view('panel/facebook/accounts_add',$this->data);
		}

	}
	public function registrar_facebook()
	{
		$this->load->library('Facebooklib','','fblib');
		if($this->fblib->getSession()!=null)
		{

			$this->user_fb=$this->fblib->api('/me');
			//sino existeix l'usuari de facebook l'inserim
			if($this->social_users->notExists($this->user_fb['id'],'face')==true)
			{
				$this->social_users->insertNew(array(
				'user_id'=>$this->user_fb['id'],
				'username'=>$this->user_fb['name'],
				'socialnetwork'=>'face',
				'access_token'=>$this->fblib->getSession()->getToken(),
				'user_app'=>$this->flexi_auth->get_user_id(),
				'disabled'=>0));
			}
			redirect('panel/facebook/connectar_facebook');

		}
	}	
	public function anadir_paginas()
	{
		$this->load->library('Facebooklib','','fblib');
		$arrayTypes=array("page","group","event");
		$this->user_fb=$this->fblib->api('/me');
		foreach($arrayTypes as $type)
		{
			$arrayPages=$this->input->post($type);
			$i=0;
			if(is11set($arrayPages) AND !EMPTY($arrayPages)){			
				$arrayPagesSelected=array();
				foreach($arrayPages as $page){
				
						if(isset($page['checked'])){
							$arrayPagesSelected[$i]=$page;
							$i++;
						}
				}
				$this->load->model("social_user_accounts");
				foreach ($arrayPagesSelected as $page) {
					unset($page['checked']);
					if($type=="group" || $type=="event"){
						$page['access_token']=$this->fblib->getSession()->getToken();
					}
					$page['idaccount']=$page['id'];	
					unset($page['id']);
					$infoadd=array('user_app'=>$this->flexi_auth->get_user_id(),"type_account"=>$type,'id_social_user'=>$this->user_fb['id']);
					$this->social_user_accounts->insertNew(array_merge($page,$infoadd));
				}
			}
		}
	}
	public function publicar()
	{
		$this->load->model('social_user_accounts');
		$pages=$this->social_user_accounts->getUserAppAccounts(array('type_account'=>'page','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['events']=$this->social_user_accounts->getUserAppAccounts(array('type_account'=>'event','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['groups']=$this->social_user_accounts->getUserAppAccounts(array('type_account'=>'group','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['pages']=$pages;
			$this->data['titlepage']="Cuentas de facebook";
			

		$this->load->view('panel/facebook/publicar',$this->data);
	}
	public function deletecontent($is_folder,$id)
	{
		$this->load->model('social_user_accounts');
		if($is_folder){
			$numaccount=$this->social_user_accounts->count_by(array("folder_id"=>$folder_id));
			if($numaccount>0)
			{
				
				echo json_encode(array("result"=>"delAccountsInFolder","idFolder"=>$id));
			}
			else
			{
				$this->load->model("folders");
				$this->folders->delete_by(array("id"=>$id));
				echo json_encode(array("result"=>"ok"));
			}

		}
		else{	
		$this->social_user_accounts->delete_by(array("id"=>$id));
		echo json_encode(array("result"=>"ok"));
		}
	}
	public function deleteFolderContent()
	{

	}
}

/* End of file facebook.php */
/* Location: ./application/modules/panel/controllers/facebook.php */