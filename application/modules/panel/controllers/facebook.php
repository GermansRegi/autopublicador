<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebook extends CI_Controller {
	private $user_fb;
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
	}
	// valida que la data passada sigui poserior   ala acutal
	function date_valid($date){
		$fecha2=DateTime::createFromFormat('d-m-Y H:i',$this->input->post('date').$this->input->post('time'),new DateTimeZone($this->session->userdata('timezone')));
		//$fecha2->setTimeZone(new DatetimeZone($this->session->userdata('timezone')));	    

	    if($fecha2)
	    {
	    		$fecha=new DateTime('now',new DatetimeZone($this->session->userdata('timezone')));
	    		
	    		
	    		$diff=(($fecha2->format('U')-$fecha->format('U'))/60);
	    		
		    	if($diff<=1)
		    	{
		    		$this->form_validation->set_message('date_valid', 'Debe seleccionar una fecha y hora posteriores');
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
	/**
	 * [programar_facebook acccio de controlador que mostra el formulari per guardar una programacio puntual a facebook]
	 * @return [type] [description]
	 */
	public function programar_facebook(){
		// agafo l'usuari que hi ha loguejat
		$user=$this->flexi_auth->get_user_by_id_query($this->flexi_auth->get_user_by_id())->result();
		$timezones=$this->config->item('timezones');
		
		$this->load->model('programations');
		// poso les validacions per formulari
		$this->form_validation->set_rules('ck_group_ap','Cuentas','callback_checkSelected');
         	$this->form_validation->set_rules('link','Enlace','prep_url|valid_url');
         	$this->form_validation->set_rules('time', 'Hora', 'required');
     	$this->form_validation->set_rules('date', 'Fecha y hora', 'required|callback_date_valid');
     	// si hi ha peticio post
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
         			//si ha no ha omplrt cap camp dels requits		
					if($this->input->post('texto_facebook')=='' && $this->input->post('link')=='' && $this->input->post('anuncis')=='' && $this->input->post('bbdd')=='' && $_FILES['imagen']['name']=='')
					{
						echo json_encode(array('msg_errors'=>array('aa'=>'Debe introducir un texto, imagen , enlace o seleccionar un elemento de una base de datos o anuncio para publicar')));      
						exit;
					}
					else
					{

						$this->load->library('form_validation_global');
						//valido el formulari per a basesde dades i anuncis
						$response=$this->form_validation_global->ErrorsPublicar($this->input->post(),true);
						if(isset($response['msg_errors']))
						{
							echo json_encode($response);
							exit;
						}
						//si la resposta de la validacio es un elemnent
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
								$link=$row[0]->link;
							}
							else
							{
								$text=$row[0]->sentence;
							}

						}
						//si hi ha un fitxer en la peticio de formulari
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

                                        echo json_encode(
                                        	array(
                                        		'results'=>true,
                                        		'error'=>$this->upload->display_errors_array()));        
                                       
                                    }
                                    else 
                                    {
                                        $file=$this->upload->data();
                                        $data['path']=$file['full_path'];
                                        $data['text']=(isset($text)?$text.$this->input->post('texto_facebook'):$this->input->post('texto_facebook'));
                                    }
                               }
                           
                           
                            }
                            	$data['text']=(isset($text)?$text.$this->input->post('texto_facebook'):$this->input->post('texto_facebook'));
                      		if(isset($link))
                      			$data['link']=$link;
                      		else
                            	$data['link']=$this->input->post('link');

                       	///creo la data i hora de la peticio amb el timezone de usuari
						$fecha=DateTime::createFromFormat('d-m-Y H:i',$this->input->post('date')." ".$this->input->post('time'),new DateTimeZone($this->session->userdata('timezone')));

						//canvio el timezone de la datatime pel guardar la data a bd
						$fecha->setTimezone(new DateTimeZone('Europe/London'));
						//echo $fecha->format('d-m-y H:i');

						$data['fecha']=$fecha->format('U');
						// si ha fechaborrado en la peticio del formulari
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
						// estat de laprogramacio es sempre en process
						$data['state']='process';
						
						$group_ap=$this->input->post('ck_group_ap');
						// per tots els usuari de facebook selecccionades inserto una programacio
						if(isset($group_ap['user']) )
						foreach ($group_ap['user'] as $accountid) 
						{
							
							$data['socialaccount']=$accountid;
							$data['user_app']=$this->flexi_auth->get_user_id();
							$data['type_socialaccount']='user';
							$data['social_network']="fb";

							$this->programations->insertNew($data);
							

						}
						// per totes les comptes de facebook selecccionades inserto una programacio
						if(isset($group_ap['account']))
						foreach ($group_ap['account'] as $accountid) 
						{
							$data['socialaccount']=$accountid;
							$data['user_app']=$this->flexi_auth->get_user_id();
							$data['type_socialaccount']='account';
							$data['social_network']="fb";

							$this->programations->insertNew($data);

						}
						 echo json_encode(array('msg_success'=>'La programación se ha creado correctamente'));
						
					}
				}
			}
			exit;
		}
		
		
		$this->load->model('social_user_accounts');
		$this->load->model('social_users');
			//agafo les pagines d fb que te usuari guardats
			
		$this->load->library('form_validation_global');
		$this->data['accordiondata']['arraydata']=$this->form_validation_global->getAccountsByFolderFB();


			// si es usuari premium o si es guest te acces a les seves bases de dades 
			

			if ($this->flexi_auth->is_privileged('acces user prem') || $this->is_guest==true)
			{
				$this->data['basesdedatos']=$this->bases_datos_model->getAllWithAdmin(array('socialnetwork'=>'face','user_app'=>$this->flexi_auth->get_user_id()),array('is_admin'=>1,'socialnetwork'=>'face'));
				$this->data['anuncios']=$this->anuncios_model->getAllWithAdmin(array('socialnetwork'=>'face','user_app'=>$this->flexi_auth->get_user_id()),array('is_admin'=>1,'socialnetwork'=>'face'));
				
			}
			// sino nomes te acces  a les basesde dades de usuari administrador
			else if($this->flexi_auth->is_privileged('acces user free') && $this->is_guest==false)
			{
				$this->data['basesdedatos']=$this->bases_datos_model->get_many_by(array('is_admin'=>1,'socialnetwork'=>'face'));
				$this->data['anuncios']=$this->anuncios_model->get_many_by(array('is_admin'=>1,'socialnetwork'=>'face'));
			}
			// agafo les programacions de facebook i de usuari 
			/*$programaciones=$this->programations->get_many_by(
				array(
					'social_network'=>"fb",
					'user_app'=>$this->flexi_auth->get_user_id()
					));*/
			//pr cada una incloc el nom de la compte o pagina a la que vva associada
			$this->data['programaciones']=$this->form_validation_global->getProgramationsByFolder('fb');
			

		$this->data['titlepage']="Facebook - Programar publicación";
		$this->load->view("panel/facebook/programar_facebook",$this->data);
	}

	// llista les comptes de facebook  que te afegides l'usuarii de aplicacio
	public function index()
	{

		
		$this->data['titlepage']="Facebook - Cuentas";
		//$this->load->library('Facebooklib','','fblib');	
		$this->session->unset_userdata('fb_token');
		//$this->fblib->setSession();
		
	$this->load->library('form_validation_global');
		$this->data['arraydata']=$this->form_validation_global->getAccountsByFolderFB();

		$this->load->view('panel/facebook/index',$this->data);

	}
	//llista les comptes de facebook de uusuari de facebook 
	public function connectar_facebook()
	{

		$this->load->model("social_user_accounts");
		$numUsers=$this->social_users->count_by(array('user_app'=>$this->flexi_auth->get_user_id()));
		$numAcc=$this->social_user_accounts->count_by(array('user_app'=>$this->flexi_auth->get_user_id()));
			
			
			
		if ($this->flexi_auth->is_privileged('acces user free') && $this->is_guest==false && ($numAcc+$numUsers)>3)
		{
			
			 	$url=base_url().'panel/perfil/planes';
				$this->data['message']='No estas autorizado a realizar esta acción.<br><b> Has alcanzado el límite de cuentas possibles a añadir con el plan gratuito.</b>';
				$this->data['result']='error';
	
				$this->data['titlepage']="Facebook - Añadir cuentas";
				$this->load->view("panel/facebook/anadir_paginas",$this->data);

		}
		else
		{
			
			$this->load->library('Facebooklib','','fblib');
			if($this->fblib->getSession()==null)
			{
				redirect($this->fblib->login_url());
				

			}
			else
			{

				$this->fblib->getSession()->getLongLivedSession();
				//		var_dump($user);
				$user_fb=$this->fblib->api('/me');
				
				///		var_dump($user_fb);
				//sino existeix l'usuari de facebook l'inserim
				$exist=$this->social_users->Exists($user_fb['id'],'fb',$this->flexi_auth->get_user_id());
				if($exist==false)
				{
					$this->social_users->insertNew(array(
					'user_id'=>$user_fb['id'],
					'username'=>$user_fb['name'],
					'social_network'=>'fb',
					'access_token'=>$this->fblib->getSession()->getToken(),
					'user_app'=>$this->flexi_auth->get_user_id(),
					'disabled'=>0));

				}	
				else
				{
				
					$this->social_users->update_by(
					array(
						'username'=>$user_fb['name'],
						'access_token'=>$this->fblib->getSession()->getToken()),
					array(
						'user_app'=>$this->flexi_auth->get_user_id(),
						'user_id'=>$user_fb['id']
						));
				}		
				//$this->load->model("social_user_accounts");

				$pages=array();
				
				$pagesFace=$this->fblib->api('/me/accounts');
			
				//	var_dump($pagesFace);
				if(isset($pagesFace['data']) && count($pagesFace['data'])>0)
				foreach($pagesFace['data'] as $val)
		           {    
					
		             	$exist=$this->social_user_accounts->userAccountExist(
		             		array(
		             			'id_social_user'=>$user_fb['id'],
		             			'type_account'=>'page',
		             			'user_app'=>$this->flexi_auth->get_user_id(),
		             			'idaccount'=>$val->id
		             			)
		             		);
	                    if(in_array('ADMINISTER',$val->perms) && $exist==false)
	                    {
	                    	$pages[]=$val;
	                    }
	                    else
	                    {
	                    	$this->social_user_accounts->update_by(
	                    		array(
	                    			'access_token'=>$val->access_token,
	                    			'name'=>$val->name
	                    			),
	                    		array(
	                    			'user_app'=>$this->flexi_auth->get_user_id(),
	                    			'idaccount'=>$val->id
	                    			)
	                    		);
	                    }
	                    
	               }
	               $groups=array();
	               $groupsFace=$this->fblib->api('/me/groups');
				if(isset($groupsFace['data']) &&  count($groupsFace['data'])>0)
				foreach($groupsFace['data'] as $val)
		           {    
					
		             	$exist=$this->social_user_accounts->userAccountExist(
		             		array(
		             			'id_social_user'=>$user_fb['id'],
		             			'type_account'=>'group',
		             			'user_app'=>$this->flexi_auth->get_user_id(),
		             			'idaccount'=>$val->id));
	                    if($exist==false)
	                    {
	                    	$groups[]=$val;
	                    }
	                    else
	                    {
	                    	$this->social_user_accounts->update_by(array('access_token'=>$this->fblib->getSession()->getToken(),'name'=>$val->name),
	                    		array('user_app'=>$this->flexi_auth->get_user_id(),'idaccount'=>$val->id));
	                    }
	               }
	               $events=array();
	               $eventsFace=$this->fblib->api('/me/events');
				
				if(isset($eventsFace['data']) && count($eventsFace['data'])>0)
				foreach($eventsFace['data'] as $val)
		           {    
					
		             	$exist=$this->social_user_accounts->userAccountExist(array('id_social_user'=>$user_fb['id'],'type_account'=>'event','user_app'=>$this->flexi_auth->get_user_id(),'idaccount'=>$val->id));
	                    if($exist==false)
	                    {
	                    	$events[]=$val;
	                    }
	                    else
	                    {
	                    	$this->social_user_accounts->update_by(array('access_token'=>$this->fblib->getSession()->getToken(),'name'=>$val->name),
	                    		array('user_app'=>$this->flexi_auth->get_user_id(),'idaccount'=>$val->id));
	                    }
	                    
	               }
	               $this->data['pages']=$pages;

				$this->data['events']=$events;
				$this->data['groups']=$groups;
					

				//		var_dump($this->session->all_userdata());
				$this->data['titlepage']="Facebook - Añadir cuentas de: ".$user_fb['name'];
					
				$this->load->view('panel/facebook/accounts_add',$this->data);
			}			
		}




	}
	//afegeix les comptes seleccionades per usuari
	public function anadir_paginas()
	{
		if($this->input->post())
		{
			$this->load->library('Facebooklib','','fblib');
			$arrayTypes=array("page","group","event");
			$user_fb=$this->fblib->api('/me');
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
					$this->load->model('autoprog_anuncios');
					$this->load->model('autoprog_basededatos');
					foreach ($arrayPagesSelected as $page) {
						unset($page['checked']);
						if($type=="group" || $type=="event"){
							$page['access_token']=$this->fblib->getSession()->getToken();
						}
						$page['idaccount']=$page['id'];	
						unset($page['id']);
						$infoadd=array('user_app'=>$this->flexi_auth->get_user_id(),"type_account"=>$type,'id_social_user'=>$user_fb['id']);
			/*			$this->autoprog_basededatos->insertNew(array(
							'accountid'=>$page['idaccount'],
							'user_app'=>$this->flexi_auth->get_user_id(),
							'type'=>'account','socialnetwork'=>'fb',
							'weekdays'=>'[]'));
						$this->autoprog_anuncios->insertNew(array(
							'accountid'=>$page['idaccount'],
							'user_app'=>$this->flexi_auth->get_user_id(),
							'type'=>'account','socialnetwork'=>'fb',
							'weekdays'=>'[]'));*/
							$this->social_user_accounts->insertNew(array_merge($page,$infoadd));
					}
				}
			}
			$this->data['message']="Se han añadido correctamente las cuentas seleccionada";
			$this->data['result']='success';
		}
		else
		{
			$this->data['message']='No se han añadido las cuentas seleccionadas';
			$this->data['result']='error';
		}
		
		$this->data['titlepage']="Facebook - Añadir cuentas";
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
		$this->load->library('form_validation_global');
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

						
						$response=$this->form_validation_global->ErrorsPublicar($this->input->post(),true);
						$row=null;
						$urlfb="/feed";
						if(isset($response['msg_errors']))
						{
							echo json_encode($response);
							exit;
						}
						
						if(isset($response['table']))
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
								if(filter_var($row[0]->path,FILTER_VALIDATE_URL))
									$params['url']=$row[0]->path;
								else
									$params['source']="@".$row[0]->path;
							}
							elseif($response['content']=='link')
							{
								$link=$row[0]->link;

							}
							else
							{
								$text=$row[0]->sentence;
							}

						}
						/*if(!$response)
						{*/
						if(isset($_FILES['imagen']['name']) && $_FILES['imagen']['name']!="")
                               {
                                   
                                  $array=array('image/jpg','image/jpeg','image/png','image/x-png','image/gif');
                                  if(in_array($_FILES['imagen']['type'],$array))
                                  {
                                  	$params['source']='@'.$_FILES['imagen']['tmp_name'];

                                  	$params['message']=$this->input->post('texto_facebook')." ".((isset($text))?$text:'');
                                  }
                                   $urlfb="/photos";    
                              
                               }
                               
                               
                               	$params['message']=$this->input->post('texto_facebook')." ".((isset($text))?$text:'');
                               	if(isset($link))
                               	$params['link']=$link;	
                               else
                               	$params['link']=$this->input->post('link');
                               
						//}
						$res=array();
						//var_dump($params);
						 $this->load->library('Facebooklib','','fblib');
						$group_ap=$this->input->post('ck_group_ap');
						if(isset($group_ap['user']) )

						foreach ($group_ap['user'] as $accountid) 
						{
							$user=$this->social_users->getUserAppUsers(array('user_id'=>$accountid,'user_app'=>$this->flexi_auth->get_user_id()),1);
							//var_dump($user[0]->access_token);
							$this->fblib->setSessionFromToken($user[0]->access_token);
							$res[]=$this->fblib->api_post('/'.$accountid.$urlfb,$params);

						}
						if(isset($group_ap['account']))
						foreach ($group_ap['account'] as $accountid) 
						{
							$acc=$this->social_user_accounts->getUserAppAccounts(array('idaccount'=>$accountid,'user_app'=>$this->flexi_auth->get_user_id()),1);
							$this->fblib->setSessionFromToken($acc[0]->access_token);
							$res[]=$this->fblib->api_post('/'.$accountid.$urlfb,$params);
							
							

						}
						$errorflag=false;
					
						foreach($res as $error)
						{

							
							if(isset($error['error']))
							{
								$errorflag=true;
								break;
							}
							
						}
						if($errorflag==true)
							echo json_encode(array('msg_errors'=>array('pp'=>'No se ha podido publicar correctamente en alguna de las cuentas seleccionadas')));
						else
							echo json_encode(array('msg_success'=>'Se ha publicado correctamente en las cuentas seleccionadas'));
					}

         			}
         		}
         		exit;
		}

			$this->data['accordiondata']['arraydata']=$this->form_validation_global->getAccountsByFolderFB();
		
			
			if ($this->flexi_auth->is_privileged('acces user prem') || $this->is_guest==true)
			{
				$this->data['basesdedatos']=$this->bases_datos_model->getAllWithAdmin(array('socialnetwork'=>'face','user_app'=>$this->flexi_auth->get_user_id()),array('is_admin'=>1,'socialnetwork'=>'face'));
				$this->data['anuncios']=$this->anuncios_model->getAllWithAdmin(array('socialnetwork'=>'face','user_app'=>$this->flexi_auth->get_user_id()),array('is_admin'=>1,'socialnetwork'=>'face'));
				
			}
			else if($this->flexi_auth->is_privileged('acces user free') && $this->is_guest==false)
			{
				$this->data['basesdedatos']=$this->bases_datos_model->get_many_by(array('is_admin'=>1,'socialnetwork'=>'face'));
				$this->data['anuncios']=$this->anuncios_model->get_many_by(array('is_admin'=>1,'socialnetwork'=>'face'));
			}
			$this->data['titlepage']="Facebook - Publicar ahora";
			

		$this->load->view('panel/facebook/publicar',$this->data);
	}
	// elimina un compte de facebook
	
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
	public function checkhours($str)
	{
		
		if($str['hora_inicio']>=$str['hora_fin'])
		{
			$this->form_validation->set_message('checkhours', 'La hora de inicio de ser anterior a la hora final');
			return false;
		}
		else
		{
			return true;
		}
	}
	public function prog_periodicas()
	{
		$this->load->model('autoprog_basededatos');
		$this->load->model('autoprog_anuncios');
		$this->load->model('social_user_accounts');
		if($this->input->post('datos'))
		{
			$datos=$this->input->post('datos');
			/*if($this->checkhours($datos))
			{*/
				$this->form_validation->set_rules('datos[frecuencia]','Frecuencia','required');
				$this->form_validation->set_rules('datos[socialacc]','Cuentas','callback_checkSelected');
				$this->form_validation->set_rules('datos[asociard][]','Bases de datos','required');
				$this->form_validation->set_rules('datos','Horas de publicación','callback_checkhours');
				if($this->form_validation->run()==TRUE)
				{

					if(isset($datos['repetir']))
					{
						$this->load->library('form_validation_global');
						$this->form_validation_global->validateSaveAutoProg($datos['asociard'],'datos',$this->flexi_auth->get_user_id());
					}
					
					if(isset($datos['socialacc']['user']))
					{
						foreach($datos['socialacc']['user'] as $id)
						{
							$this->autoprog_basededatos->insertNew(array(
							'ids'=>(isset($datos['asociard'])?json_encode($datos['asociard']):'[]'),
							'repeat'=>(isset($datos['repetir'])?1:0),
							'frequency'=>$datos['frecuencia'],
							'date'=>time(),
							'socialnetwork'=>'fb',
							'time_start'=>$datos['hora_inicio'],
							'user_app'=>$this->flexi_auth->get_user_id(),
							'time_end'=>$datos['hora_fin'],
							"weekdays"=>(isset($datos['diasp'])?json_encode($datos['diasp']):'[]'),
							'perm_sentences'=>$datos['frases_perm'],'accountid'=>$id,'type'=>'user'));
						}
					}
					if(isset($datos['socialacc']['account']))
					{
						foreach ($datos['socialacc']['account'] as $id) {
							$this->autoprog_basededatos->insertNew(array(
							'ids'=>(isset($datos['asociard'])?json_encode($datos['asociard']):'[]'),
							'repeat'=>(isset($datos['repetir'])?1:0),
							'socialnetwork'=>'fb',
							'date'=>time(),
							'frequency'=>$datos['frecuencia'],
							'time_start'=>$datos['hora_inicio'],
							'user_app'=>$this->flexi_auth->get_user_id(),
							'time_end'=>$datos['hora_fin'],
							"weekdays"=>(isset($datos['diasp'])?json_encode($datos['diasp']):'[]'),
							'perm_sentences'=>$datos['frases_perm'],'accountid'=>$id,'type'=>'account'));
						}
					}
					echo json_encode(array('msg_success'=>'Programaciones periódicas creadas con éxito en las cuentas seleccionadas'));
				}
				else
				{

						$errors = $this->form_validation->error_array();
	                     echo json_encode(array('msg_errors'=>$errors));
				}
			/*}
			else
			{
				echo json_encode(array('msg_errors'=>array('pp'=>'La hora de inicio debe ser anterior a la hora final'))); 
			}*/
			exit;
		}
		elseif($this->input->post('anuncios'))
		{
			$anuncios=$this->input->post('anuncios');
			/*if($this->checkhours($anuncios))
			{*/
				$this->form_validation->set_rules('anuncios[frecuencia]','Frecuencia','required');
				$this->form_validation->set_rules('anuncios[socialacc]','Cuentas','callback_checkSelected');
				$this->form_validation->set_rules('anuncios[asociard]','Bases de datos','required');
				$this->form_validation->set_rules('anuncios','Horas de publicación','callback_checkhours');
				if($this->form_validation->run()==TRUE)
				{
					if(isset($anuncios['repetir']))
					{
						$this->load->library('form_validation_global');
						$this->form_validation_global->validateSaveAutoProg($anuncios['asociard'],'anuncios',$this->flexi_auth->get_user_id());	
					}
					
					if(isset($anuncios['socialacc']['user']))
					{
						foreach($anuncios['socialacc']['user'] as $id)
						{
							$this->autoprog_anuncios->insertNew(array(
							'ids'=>$anuncios['asociard'],
							'frequency'=>$anuncios['frecuencia'],
							'repeat'=>(isset($anuncios['repetir'])?1:0),
							'socialnetwork'=>'fb',
							'date'=>time(),
							'frequency_erase'=>(isset($anuncios['frecuencia_borrado'])?$anuncios['frecuencia_borrado']:0),
							'user_app'=>$this->flexi_auth->get_user_id(),
							'time_start'=>$anuncios['hora_inicio'],
							"weekdays"=>(isset($anuncios['diasp'])?json_encode($anuncios['diasp']):'[]'),
							'time_end'=>$anuncios['hora_fin'],
							'perm_sentences'=>$anuncios['frases_perm'],'accountid'=>$id,'type'=>'user'));
					
						}
					}
					if(isset($anuncios['socialacc']['account']))
					{
						foreach($anuncios['socialacc']['account'] as $id)
						{
							$this->autoprog_anuncios->insertNew(array(
							'ids'=>$anuncios['asociard'],
							'socialnetwork'=>'fb',
							'date'=>time(),
							'frequency'=>$anuncios['frecuencia'],
							'repeat'=>(isset($anuncios['repetir'])?true:0),
							'frequency_erase'=>(isset($anuncios['frecuencia_borrado'])?$anuncios['frecuencia_borrado']:0),
							'time_start'=>$anuncios['hora_inicio'],
							'user_app'=>$this->flexi_auth->get_user_id(),
							"weekdays"=>(isset($anuncios['diasp'])?json_encode($anuncios['diasp']):'[]'),
							'time_end'=>$anuncios['hora_fin'],
							'perm_sentences'=>$anuncios['frases_perm'],'accountid'=>$id,'type'=>'account'));
					
						}
					}
					     echo json_encode(array('msg_success'=>'Programaciones periódicas creadas con éxito en las cuentas seleccionadas'));
				}
				else
				{

						$errors = $this->form_validation->error_array();
	                     echo json_encode(array('msg_errors'=>$errors));
				}
			/*}
			else
			{
			echo json_encode(array('msg_errors'=>array('pp'=>'La hora de inicio debe ser anterior a la hora final'))); 	
			}*/
		
		
					exit;	
		}
		
		$programacionesbbdd=$this->autoprog_basededatos->get_many_by(array('socialnetwork'=>'fb','user_app'=>$this->flexi_auth->get_user_id()));
//		$programacionesanuncios=$this->autoprog_anuncios->get_many_by(array('socialnetwork'=>'fb','user_app'=>$this->flexi_auth->get_user_id()));
		foreach ($programacionesbbdd as $prog) {
			if($prog->type=='account')
			{
				$acc=$this->social_user_accounts->getUserAppAccounts(array('idaccount'=>$prog->accountid,'user_app'=>$this->flexi_auth->get_user_id()),1);
				$prog->name=$acc[0]->name;
			}
			else
			{
				$user=$this->social_users->getUserAppUsers(array('user_id'=>$prog->accountid,'user_app'=>$this->flexi_auth->get_user_id()),1);	
				$prog->name=$user[0]->username;
		
		
			}
		}
/*		foreach ($programacionesanuncios as $prog) {
			if($prog->type=='account')
			{
				$acc=$this->social_user_accounts->getUserAppAccounts(array('idaccount'=>$prog->accountid,'user_app'=>$this->flexi_auth->get_user_id()),1);
				$prog->name=$acc[0]->name;
			}
			else
			{
				$user=$this->social_users->getUserAppUsers(array('user_id'=>$prog->accountid,'user_app'=>$this->flexi_auth->get_user_id()),1);	
				$prog->name=$user[0]->username;
			}
		
		}
*/
		$this->load->library('form_validation_global');
		$this->data['autoprog']['basededatos']=$this->form_validation_global->getAutoProgByFolder('bbdd','fb');
		$this->data['autoprog']['basededatos2']=$programacionesbbdd;
		$this->data['autoprog']['anuncios']=$this->form_validation_global->getAutoProgByFolder('anunci','fb');
		
		$this->data['accordiondata']['arraydata']=$this->form_validation_global->getAccountsByFolderFB();

			


		$this->data['basesdedatos']=$this->bases_datos_model->getAllWithAdmin(array('socialnetwork'	=>'face','user_app'=>$this->flexi_auth->get_user_id()),array('is_admin'=>1,'socialnetwork'=>'face'));
		$this->data['anuncios']=$this->anuncios_model->getAllWithAdmin(array('socialnetwork'=>'face','user_app'=>$this->flexi_auth->get_user_id()),array('is_admin'=>1,'socialnetwork'=>'face'));
		$this->data['titlepage']="Facebook - Programaciones periódicas";
		$this->load->view('facebook/autoprog',$this->data);		
	}
	public function addGroup()	{
		if($this->input->post())
		{
			$this->form_validation->set_rules('name','Identificador de grupo','required');
			$this->form_validation->set_rules('usuario','Usuarios','required');
			if($this->form_validation->run()==true)
			{
				$user=$this->social_users->getUserAppUsers(array('user_id'=>$this->input->post('usuario'),'user_app'=>$this->flexi_auth->get_user_id()),1);	
				$this->load->library('Facebooklib','','fblib');
				$this->fblib->setSessionFromToken($user[0]->access_token);
				
				$res1=$this->fblib->api('/'.$this->input->post('name'));
				
				if(isset($res1['privacy']))
				{
					if($res1['privacy']=="OPEN")	
					{
						$res=$this->fblib->api('/'.$this->input->post('name').'/members');
						$trobat=false;
						foreach ($res['data'] as $key) {

							if(isset($key->id) && $key->id==$user[0]->user_id)
							{
								$trobat=true;
								break;
							}						
						}
						if($trobat)
						{
								$this->load->model('social_user_accounts');
								$exist=$this->social_user_accounts->userAccountExist(
		             		array(
		             			'id_social_user'=>$user[0]->user_id,
		             			'type_account'=>'group',
		             			'user_app'=>$this->flexi_auth->get_user_id(),
		             			'idaccount'=>$this->input->post('name')));
		                    if($exist==false)
		                    {
		                    	$this->social_user_accounts->insertNew(		             		array(
		             			'id_social_user'=>$user[0]->user_id,
		             			'type_account'=>'group',
		             			'user_app'=>$this->flexi_auth->get_user_id(),
		             			'idaccount'=>$this->input->post('name'),
		             			'access_token'=>$user[0]->access_token,
		             			'name'=>$res1['name']));
		                    }
		                    else
		                    {
		                    	$this->social_user_accounts->update_by(array('access_token'=>$user[0]->access_token,'name'=>$res1['name']),
		                    		array('user_app'=>$this->flexi_auth->get_user_id(),'idaccount'=>$this->input->post('name')));
		                    }
		                    echo json_encode(array('msg_success'=>'Grupo añadido o actualizado correctamente'));
						}	
						else
						{
							echo json_encode(array('msg_errors'=>array('pp'=>"El usuario seleccionado no es miembro de este grupo.")));	
						}		
					}
					else
					{
							echo json_encode(array('msg_errors'=>array('pp'=>"El grupo que ha introducido no es público.")));	
					}
				}
				else
				{
							echo json_encode(array('msg_errors'=>array('pp'=>"Ha introducido un identificador que no corresponde a ningún grupo.")));	
				}
			}
			else
			{
				$errors = $this->form_validation->error_array();
                 echo json_encode(array('msg_errors'=>$errors));
			}
			
		}
		exit;

	}
	// agafa els elements d
}

/* End of file facebook.php */
/* Location: ./application/modules/panel/controllers/facebook.php */