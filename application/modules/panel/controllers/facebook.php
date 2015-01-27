<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebook extends CI_Controller {
	private $user_fb;
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
	function date_valid($date){
	    $p=strtotime($_POST['date'].$_POST['time']);
	    if($p)
	    {
		    	if($p<=time())
		    	{
		    		$this->form_validation->set_message('date_valid', 'Debe seleccionar una fecha y hora posterior a la actual');
	    			return false;	
		    	}
		    	else
		    	{
		    		return true;
		    	}
	    	
	    }
	    else
	    {
	    		$this->form_validation->set_message('date_valid', 'Debe seleccionar una fecha y hora');
	    		return false;
	    }
	}
	public function ver_programacion($idprog=0)
	{
		if($idprog)
		{
			$this->load->model('programations');
			$this->data['prog']=$this->programations->getById($idprog);

			$this->load->view('facebook/ver_programacion',$this->data);
		}
	}
	public function programar_facebook(){
		$this->load->model('programations');
		$this->form_validation->set_rules('ck_group_ap','Páginas','callback_checkSelected');
         	$this->form_validation->set_rules('link','Enlace','prep_url|valid_url');
         	$this->form_validation->set_rules('time', 'Hora', 'required');
     	$this->form_validation->set_rules('date', 'Fecha y hora', 'required|callback_date_valid');
		if($this->input->post())
		{
			
         		if($this->form_validation->run()==false)
         		{
    			    $errors = $this->form_validation->error_array();
                   echo json_encode(array('msg_errors'=>$errors));      

         		}
         		else
         		{
         			if($this->input->post('ck_group_ap'))
         			{
         				//var_dump($_FILES);
         					//var_dump(($this->input->post('texto_facebook')=='' && $this->input->post('link')=='' && $this->input->post('anuncis')=='' && $this->input->post('bbdd')=='' && count($_FILES)==0));	//si  no ha introduit cap dada
					if($this->input->post('texto_facebook')=='' && $this->input->post('link')=='' && $this->input->post('anuncis')=='' && $this->input->post('bbdd')=='' && $_FILES['imagen']['name']=='')
					{
						echo json_encode(array('msg_errors'=>array('aa'=>'Debe introducir un texto, imagen , enlace o seleccionar un elemento de una base de datos o anuncio para publicar')));      
						exit;
					}
					else
					{

						$this->load->library('form_validation_global');
						$response=$this->form_validation_global->ErrorsPublicar($this->input->post());
						if(isset($response['msg_errors']))
						{
							echo json_encode($response);
							exit;
						}
						
						else if(isset($response['table']))
						{
							if($response['table']=="basesdedatos")
							{
								$row=$this->bases_datos_model->getElements($response['content'],array("id"=>$response['idelement']));
							}	
							else
							{	
								$row=$this->anuncios_model->getElements($response['content'],array("id"=>$response['idelement']));
							}
							if($response['content']=='image')
							{
								
								$data['path']=$row[0]->path;
							}
							elseif($response['content']=='link')
							{
								$data['link']=$row[0]->link;
							}
							else
							{
								$data['text']=$row[0]->sentence;
							}

						}
						if(!$response)
						{
							if(isset($_FILES['imagen']['name']) && $_FILES['imagen']['name']!="")
                                    {
                                        
                                       $array=array('image/jpg','image/jpeg','image/png','image/x-png','image/gif');
                                       if(in_array($_FILES['imagen']['type'],$array))
                                       {
	                                       	if(!file_exists('upload/temporal'))
		                                    {
		                                        mkdir('upload/temporal');
		                                    }
		                                   $email=substr($this->flexi_auth->get_user_identity(),0,strpos($this->flexi_auth->get_user_identity(),'.'));
		                                 //la pujo en una carpeta temporal ja que es publicara un cop i no cal guardarla
		                                    $config['file_name']=$email.uniqid("Image_");
		                                    $config['upload_path'] = 'upload/temporal/';
		                                           
		                                    $config['allowed_types'] = 'gif|jpg|png';
		                                    $config['max_size'] = 8000; //in KB
		                                    $config['is_image']=true;
		   					     //la pujo al servidor
		                                    $this->load->library('upload', $config);
		                                    if (! $this->upload->do_upload('imagen'))
		                                    {
		                                      //  $upload_error['upload_error'] = array('error' => $this->upload->display_errors()); 

		                                        echo json_encode(array('results'=>true,'error'=>$this->upload->display_errors_array()));        
		                                       
		                                    }
		                                    else 
		                                    {
		                                        $file=$this->upload->data();
		                                        $data['path']=$file['full_path'];
		                                        $data['message']=$this->input->post('texto_facebook');
		                                    }
                                       }
                                   
                                   
                                    }
                                    else
                                    {
                                    	$data['text']=$this->input->post('texto_facebook');
                                    	$data['link']=$this->input->post('link');
                                    }

			
						}
						$data['fecha']=strtotime($this->input->post('date').$this->input->post('time'));
						if($this->input->post('fechaBorrado'))
						{
							if((int)$this->input->post('fechaBorrado')<1)
							{
								$segSum=$this->input->post('fechaBorrado')*100*60;
								$data['fechaBorrado']=(int)$data['fecha']+$segSum;	
							}
							else 
							{
								$segSum=$this->input->post('fechaBorrado')*3600;
								$data['fechaBorrado']=(int)$data['fecha']+$segSum;
							}
						}	
						$data['state']='process';
						
						$group_ap=$this->input->post('ck_group_ap');
						if(isset($group_ap['user']) )
						foreach ($group_ap['user'] as $accountid) 
						{
							
							$data['socialaccount']=$accountid;
							$data['user_app']=$this->flexi_auth->get_user_id();
							$data['type_socialaccount']='user';
							$data['social_network']="fb";

							$this->programations->insertNew($data);
							

						}
						if(isset($group_ap['account']))
						foreach ($group_ap['account'] as $accountid) 
						{
							$data['socialaccount']=$accountid;
							$data['user_app']=$this->flexi_auth->get_user_id();
							$data['type_socialaccount']='account';
							$data['social_network']="fb";

							$this->programations->insertNew($data);

						}
						 echo json_encode(array('msg_success'=>'La programación se ha realizado correctemente'));
						
					}
				}
			}
			exit;
		}
		$this->load->model('social_user_accounts');
		$this->load->model('social_users');
			$pages=$this->social_user_accounts->getUserAppAccounts(array('type_account'=>'page','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['data']['event']=$this->social_user_accounts->getUserAppAccounts(array('type_account'=>'event','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['data']['group']=$this->social_user_accounts->getUserAppAccounts(array('type_account'=>'group','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['data']['page']=$pages;
			$this->data['data']['user']=$this->social_users->getUserAppUsers(array('social_network'=>'fb','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['basesdedatos']=$this->bases_datos_model->getAllWithAdmin(array('socialnetwork'=>'face','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['anuncios']=$this->anuncios_model->getAllWithAdmin(array('socialnetwork'=>'face','user_app'=>$this->flexi_auth->get_user_id()));
			$programaciones=$this->programations->getAll(array('social_network'=>'fb','user_app'=>$this->flexi_auth->get_user_id()));
			foreach ($programaciones as $prog) {
				if($prog->type_socialaccount=='account')
				{
					$acc=$this->social_user_accounts->getUserAppAccounts(array('idaccount'=>$prog->socialaccount),1);
					$prog->name=$acc[0]->name;
				}
				else
				{
					$user=$this->social_users->getUserAppUsers(array('idaccount'=>$prog->socialaccount),1);	
					$prog->name=$user[0]->username;
				}
			
			}
			$this->data['programaciones']=$programaciones;
			

		$this->data['titlepage']="Programar Facebook ";
		$this->load->view("panel/facebook/programar_facebook",$this->data);
	}
	// llista les comptes de facebook  que te afegides l'usuarii de aplicacio
	public function index()
	{

		$this->load->model("social_user_accounts");
		$this->load->model("folders");
		$this->data['user_accounts']=$this->social_user_accounts->getUserAppAccounts(array('user_app'=>$this->flexi_auth->get_user_id()));
		$this->data['user_accounts']=array_merge($this->data['user_accounts'],$this->social_users->getUserAppUsers(array('user_app'=>$this->flexi_auth->get_user_id())));
		$this->data['folders']=$this->folders->get_many_by(array('user_app'=>$this->flexi_auth->get_user_id(),'social_network'=>"fb"));
		$this->data['user_accounts_view']=null;
		$arraydata=array('page'=>array('folders'=>array(),'nofolder'=>array()),
					'group'=>array('folders'=>array(),'nofolder'=>array()),
					'event'=>array('folders'=>array(),'nofolder'=>array()),
					'user'=>array('folders'=>array(),'nofolder'=>array())
			);
		$n=0;
		
//		primer jhhas de recorrere array de tipusaccount
//		recorrer array carpetes amb comptess i si no hi ha carpeta al comptes
	
	//	$arrayfolder=array('data'=>'','rows'=>array());
		foreach ($this->data['folders'] as $key) {
			
			$arraydata[$key->type]['folders'][]=array('data'=>$key,'rows'=>array());
			
			
		}

		foreach ($this->data['user_accounts'] as $key) {
			
			if(is_null($key->folder_id))
			{
				if(!isset($key->type_account))
					$arraydata['user']['nofolder'][]=$key;
				else
					$arraydata[$key->type_account]['nofolder'][]=$key;				
			}
			else
			{	
				if(!isset($key->type_account)){
					if(count($arraydata['user']['folders'])!=0)
					for($m=0;$m<count($arraydata['user']['folders']);$m++)
					{
						//var_dump($arraydata['user']['folders'][1]);
						if($arraydata['user']['folders'][$m]['data']->id==$key->folder_id)
						$arraydata['user']['folders'][$m]['rows'][]=$key;				
					}
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
		}
		
		$this->data['titlepage']="Cuentas de facebook";

		
		$this->data['arraydata']=$arraydata;
		$this->load->view('panel/facebook/index',$this->data);

	}
	//llista les comptes de facebook de uusuari de facebook 
	public function connectar_facebook()
	{
		

		$this->load->library('Facebooklib','','fblib');
		if($this->fblib->getSession()==null)
		{
			redirect($this->fblib->login_url());

		}
		else
		{
			
			$user=$this->user_fb=$this->fblib->api('/me');
			
			$this->user_fb=$this->fblib->api('/me');
			//sino existeix l'usuari de facebook l'inserim
			if($this->social_users->notExists($this->user_fb['id'],'fb')==true)
			{
				$this->social_users->insertNew(array(
				'user_id'=>$this->user_fb['id'],
				'username'=>$this->user_fb['name'],
				'social_network'=>'fb',
				'access_token'=>$this->fblib->getSession()->getToken(),
				'user_app'=>$this->flexi_auth->get_user_id(),
				'disabled'=>0));
			}			
			$this->load->model("social_user_accounts");

			$pages=array();

			$pagesFace=$this->fblib->api('/me/accounts');
			if(isset($pagesFace['data']) && count($pagesFace['data'])>0)
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
			if(isset($groupsFace['data']) &&  count($groupsFace['data'])>0)
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
			
			if(isset($eventsFace['data']) && count($eventsFace['data'])>0)
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
	// funcio callback de x connectar a facebook
	public function registrar_facebook()
	{
		$this->load->library('Facebooklib','','fblib');
		if($this->fblib->getSession()!=null)
		{

			$this->user_fb=$this->fblib->api('/me');
			//sino existeix l'usuari de facebook l'inserim
			if($this->social_users->notExists($this->user_fb['id'],'fb')==true)
			{
				$this->social_users->insertNew(array(
				'user_id'=>$this->user_fb['id'],
				'username'=>$this->user_fb['name'],
				'social_network'=>'fb',
				'access_token'=>$this->fblib->getSession()->getToken(),
				'user_app'=>$this->flexi_auth->get_user_id(),
				'disabled'=>0));
			}
			redirect('panel/facebook/connectar_facebook');

		}
	}	
	//afegeix les comptes seleccionades per usuari
	public function anadir_paginas()
	{
		if($this->input->post())
		{
			$this->load->library('Facebooklib','','fblib');
			$arrayTypes=array("page","group","event");
			$this->user_fb=$this->fblib->api('/me');
			foreach($arrayTypes as $type)
			{
				$arrayPages=$this->input->post($type);
				$i=0;
				if(isset($arrayPages) AND !EMPTY($arrayPages)){			
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
			$this->data['message']='success';
		}
		else
		{
			$this->data['message']='error';
		}
		$this->data['titlepage']="";
		$this->load->view("panel/facebook/anadir_paginas",$this->data);
		
	}
	public function checkSelected($str)
	{

		if (!isset($str['user']) && !isset($str['account']))

		{
			$this->form_validation->set_message('checkSelected', 'Debe seleccionar las cuentas donde publicar');
			return FALSE;
		}
		else 
		{
			return TRUE;
		}
	}
	
	// permet publicar a facebook
	public function publicar()
	{
		$this->load->model('social_user_accounts');
		$this->load->model('social_users');
		$this->form_validation->set_rules('ck_group_ap','Páginas','callback_checkSelected');
         	$this->form_validation->set_rules('link','Enlace','prep_url|valid_url');
         		
		if($this->input->post())
		{
			
         		

         		if($this->form_validation->run()==false)
         		{
    			    $errors = $this->form_validation->error_array();
                   echo json_encode(array('msg_errors'=>$errors));      

         		}
         		else
         		{
         			if($this->input->post('ck_group_ap'))
         			{
         				//var_dump($_FILES);
         					//var_dump(($this->input->post('texto_facebook')=='' && $this->input->post('link')=='' && $this->input->post('anuncis')=='' && $this->input->post('bbdd')=='' && count($_FILES)==0));	//si  no ha introduit cap dada
					if($this->input->post('texto_facebook')=='' && $this->input->post('link')=='' && $this->input->post('anuncis')=='' && $this->input->post('bbdd')=='' && $_FILES['imagen']['name']=='')
					{
						echo json_encode(array('msg_errors'=>array('aa'=>'Debe introducir un texto, imagen , enlace o seleccionar un elemento de una base de datos o anuncio para publicar')));      
						exit;
					}
					else
					{

						$this->load->library('form_validation_global');
						$response=$this->form_validation_global->ErrorsPublicar($this->input->post());
						$row=null;
						$urlfb="/feed";
						if(isset($response['msg_errors']))
						{
							echo json_encode($response);
							exit;
						}
						
						else if(isset($response['table']))
						{
							if($response['table']=="basesdedatos")
							{
								$row=$this->bases_datos_model->getElements($response['content'],array("id"=>$response['idelement']));
							}	
							else
							{	
								$row=$this->anuncios_model->getElements($response['content'],array("id"=>$response['idelement']));
							}
							if($response['content']=='image')
							{
								$urlfb="/photos";
								$params['source']="@".$row[0]->path;
							}
							elseif($response['content']=='link')
							{
								$params['link']=$row[0]->link;
							}
							else
							{
								$params['message']=$row[0]->sentence;
							}

						}
						if(!$response)
						{
							if(isset($_FILES['imagen']['name']) && $_FILES['imagen']['name']!="")
                                    {
                                        
                                       $array=array('image/jpg','image/jpeg','image/png','image/x-png','image/gif');
                                       if(in_array($_FILES['imagen']['type'],$array))
                                       {
                                       	$params['source']='@'.$_FILES['imagen']['tmp_name'];
                                       	$params['message']=$this->input->post('texto_facebook');
                                       }
                                        $urlfb="/photos";    
                                   
                                    }
                                    else
                                    {
                                    	$params['message']=$this->input->post('texto_facebook');
                                    	$params['link']=$this->input->post('link');
                                    }
						}
						//var_dump($params);
						 $this->load->library('Facebooklib','','fblib');
						$group_ap=$this->input->post('ck_group_ap');
						if(isset($group_ap['user']) )
						foreach ($group_ap['user'] as $accountid) 
						{
							$user=$this->social_users->getUserAppUsers(array('user_id'=>$accountid),1);
							$this->fblib->setSessionFromToken($user[0]->access_token);
							$this->fblib->api_post('/'.$accountid.$urlfb,$params);

						}
						if(isset($group_ap['account']))
						foreach ($group_ap['account'] as $accountid) 
						{
							$acc=$this->social_user_accounts->getUserAppAccounts(array('idaccount'=>$accountid),1);
							$this->fblib->setSessionFromToken($acc[0]->access_token);
							$this->fblib->api_post('/'.$accountid.$urlfb,$params);
							

						}
						 echo json_encode(array('msg_success'=>'La publicación se ha realizado correctemente'));
					}

         			}
         		}
         		exit;
		}

		
		
		$pages=$this->social_user_accounts->getUserAppAccounts(array('type_account'=>'page','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['data']['event']=$this->social_user_accounts->getUserAppAccounts(array('type_account'=>'event','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['data']['group']=$this->social_user_accounts->getUserAppAccounts(array('type_account'=>'group','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['data']['page']=$pages;
			$this->data['data']['user']=$this->social_users->getUserAppUsers(array('social_network'=>'fb','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['basesdedatos']=$this->bases_datos_model->getAllWithAdmin(array('socialnetwork'=>'face','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['anuncios']=$this->anuncios_model->getAllWithAdmin(array('socialnetwork'=>'face','user_app'=>$this->flexi_auth->get_user_id()));

			$this->data['titlepage']="Cuentas de facebook";
			

		$this->load->view('panel/facebook/publicar',$this->data);
	}
	// elimina un compte de facebook
	public function deletecontent()
	{
		$this->load->model('social_user_accounts');
		$this->load->model('social_users');
		
		if($this->input->get("is_folder")=="true"){
			//var_dump($this->input->get("is_user"));
			if($this->input->get("is_user")=="true")
				$numaccount=$this->social_users->count_by(array("folder_id"=>$this->input->get("id"),'user_app'=>$this->flexi_auth->get_user_id()));
			else	
				$numaccount=$this->social_user_accounts->count_by(array("folder_id"=>$this->input->get("id"),'user_app'=>$this->flexi_auth->get_user_id()));
			if($numaccount>0)
			{
				
				echo json_encode(array("result"=>"delAccountsInFolder","idFolder"=>$this->input->get("id"),'user_app'=>$this->flexi_auth->get_user_id()));
			}
			else
			{
				$this->load->model("folders");
				$this->folders->delete_by(array("id"=>$this->input->get("id"),'user_app'=>$this->flexi_auth->get_user_id()));
				echo json_encode(array("result"=>"ok","msg_success"=>'Carpeta eliminada correctamente '));
			}

		}
		else
		{	
			if($this->input->get("is_user")=="true")
				$this->social_users->delete_by(array("id"=>$this->input->get("id"),'user_app'=>$this->flexi_auth->get_user_id()));
			else	
				$this->social_user_accounts->delete_by(array("id"=>$this->input->get("id"),'user_app'=>$this->flexi_auth->get_user_id()));
		echo json_encode(array("result"=>"ok","msg_success"=>'Cuenta eliminada correctamente '));
		}
	}
	// elimina una carpeta i el seu contingut si en te 
	public function deleteQuitFolderContent()
	{
		$this->load->model('social_user_accounts');
		$this->load->model("social_users");
		if($this->input->get("is_user")=="true")
			$rows=$this->social_users->get_many_by(array("folder_id"=>$this->input->get("id"),'user_app'=>$this->flexi_auth->get_user_id()));
		else
		$rows=$this->social_user_accounts->get_many_by(array("folder_id"=>$this->input->get("id"),'user_app'=>$this->flexi_auth->get_user_id()));
	//var_dump($rows);
		if($this->input->get("type")=="quit")
		{		
			foreach ($rows as  $value) {
			//	echo $value->id.$this->input->get("is_user");
				if($this->input->get("is_user")=="true")
			
					 $this->social_users->update_by(array("folder_id"=>null),array("id"=>$value->id,'user_app'=>$this->flexi_auth->get_user_id()));
					//$this->social_users->getLasQuery();
			
				else
					$this->social_user_accounts->update_by(array("folder_id"=>null),array("id"=>$value->id,'user_app'=>$this->flexi_auth->get_user_id()));
			}
		}
		else
		{
			foreach ($rows as  $value) {
				if($this->input->get("is_user")=="true")
					$this->social_users->delete_by(array("id"=>$value->id,'user_app'=>$this->flexi_auth->get_user_id()));
				else	
					$this->social_user_accounts->delete_by(array("id"=>$value->id,'user_app'=>$this->flexi_auth->get_user_id()));
			}
		}
		$this->load->model("folders");
		$this->folders->delete_by(array("id"=>$this->input->get("id"),'user_app'=>$this->flexi_auth->get_user_id()));
		echo json_encode(array("result"=>"ok","msg_success"=>'Cambios aplicados correctamente '));
	}
	// crea una carpeta de facebook
	public function createFolder()
	{
		
		if($this->input->post())
		{
			$this->form_validation->set_rules('name', 'Nombre', 'required');
			$this->form_validation->set_rules('type', 'Carpeta para', 'required');
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
				"type"=>$this->input->post("type"),
				'user_app'=>$this->flexi_auth->get_user_id(),
				"social_network"=>"fb"
				);
				if($this->folders->insert($arr)){
					echo json_encode(array('msg_success'=>'Datos guardados con éxito'));
				}	
			}
		
		}
		
	}
	// agafa els elements duna base de dades i els mostra
	public function get_bbddElements($page=0)
	{
		if($this->input->post())
		{
			$config=$this->load->config("pagination");
			$config["base_url"] = base_url() . "panel/facebook/get_bbddElements";
			$this->load->library('pagination');
			$page=($page!=0)?$page:0;
			
			
			$config['per_page']=5;	
			//$this->data['pager']=$this->pagination->create_links();
		//	$config['page_query_strings']=true;
			$idBBDD=$this->input->post("id");
			$bbdd=$this->bases_datos_model->getById($idBBDD);
			$email="";
			if($bbdd[0]->is_admin==0)
			{
				$email=$this->flexi_auth->get_user_identity();
			}
			
			$type=$bbdd[0]->content;
			$bbddType=$this->bases_datos_model->getElements($type,array("bbdd_id"=>$idBBDD),$config['per_page'],$page);
			//var_dump($bbddType);
			$config['total_rows']=$this->bases_datos_model->countAllElements($type,array("bbdd_id"=>$idBBDD));
			$config['page']=$page;
			$config['uri_segment']=4;
			//echo $this->uri->segment(4);
			//el problema s k no ilumina el current page pk 
			$this->pagination->initialize($config);
			
			$pager=$this->pagination->create_links();
			//var_dump($pager);
			echo json_encode(array('pager'=>$pager,"data"=>$bbddType,'content'=>$type,'folder'=>$email));
						//$this->flexi_auth->get_user_id()
		}		
	}
	// agafa els elements d'una base de dades anuncis
	public function get_anuncisElements($page=0)
	{
		if($this->input->post())
		{
			$config=$this->load->config("pagination");
			$config["base_url"] = base_url() . "panel/facebook/publicar";
			$this->load->library('pagination');
			$page=($page!=0)?$page:0;
			
			
			$config['per_page']=5;	
		
			$idBBDD=$this->input->post("id");
			$bbdd=$this->anuncios_model->getById($idBBDD);
			$email="";
			if($bbdd[0]->is_admin==0)
			{
				$email=$this->flexi_auth->get_user_identity();
			}

			$type=$bbdd[0]->content;
			$bbddType=$this->anuncios_model->getElements($type,array("bbdd_id"=>$idBBDD),$config['per_page'],$page);
			//var_dump($bbddType);
			$config['total_rows']=$this->anuncios_model->countAllElements($type,array("bbdd_id"=>$idBBDD));
			
			$config['page']=$page;
			$config['uri_segment']=4;
			$this->pagination->initialize($config);
			
			$pager=$this->pagination->create_links();
	//		$pager=$this->pagination->create_links();
			//var_dump($pager);
			echo json_encode(array('pager'=>$pager,"data"=>$bbddType,'content'=>$type,'folder'=>$email));
						//$this->flexi_auth->get_user_id()
		}		
	}
	// canviar carpeta de compte de facebook
	public function changeAccountFolder()
	{
		if($this->input->post())
		{
			$idpage=$this->input->post('page');
			$idfolder=$this->input->post('folder');
			
			if($idfolder=='null')
			{
					$idfolder=NULL;
			}
			$this->load->model('social_user_accounts');
			if($this->input->post('isuser')=='true')
			{
				$this->social_users->update_by(array('folder_id'=>$idfolder),array('id'=>$idpage,'user_app'=>$this->flexi_auth->get_user_id()));
			}	
			else
			{

				$this->social_user_accounts->update_by(array('folder_id'=>$idfolder),array('id'=>$idpage,'user_app'=>$this->flexi_auth->get_user_id()));
			}
		}
	}
}

/* End of file facebook.php */
/* Location: ./application/modules/panel/controllers/facebook.php */