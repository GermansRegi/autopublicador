<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Twitter extends CI_Controller {
	private $is_guest=false;	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('bases_datos_model');
		$this->load->model('anuncios_model');
		$this->load->model('social_users');		

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
			else if( uri_string()=='twitter')
			{

				redirect(base_url().'panel/index');

			}
			
			$this->load->vars('section_app','panel');

			$guest=$this->flexi_auth->get_user_by_id_query($this->flexi_auth->get_user_id(),array("guestPremium","uacc_group_fk",'upro_timezone_offset'))->result();	
			$timezones=$this->config->item('timezones');
			$this->session->set_userdata('timezone',$timezones[$guest[0]->upro_timezone_offset]);

			if ($this->flexi_auth->is_privileged('acces user free'))
			{
				
				if($guest[0]->guestPremium=="1")
				{
					$this->load->vars('privilege_user_app','prem');
					$this->is_guest=true;	
				}
				else
				{
					$this->load->vars('privilege_user_app','free');
					if("panel/twitter/prog_periodicas"==uri_string())
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
	public function index()
	{
		$this->data['titlepage']="Twitter - Cuentas";

	
	
		$this->load->library('form_validation_global');
		//agafo les comptes de twitter de usuari actual
		$this->data['arraydata']=$this->form_validation_global->getAccountsByFolderTwt();


			
		
		$this->load->view('twitter/index',$this->data);
	}
	public function connectar_twitter()
	{
		$this->load->model("social_user_accounts");
		$numUsers=$this->social_users->count_by(array('user_app'=>$this->flexi_auth->get_user_id()));
		$numAcc=$this->social_user_accounts->count_by(array('user_app'=>$this->flexi_auth->get_user_id()));
			
			
			
		if ($this->flexi_auth->is_privileged('acces user free') && $this->is_guest==false && ($numAcc+$numUsers)>3)
		{
			
			 	$url=base_url().'panel/perfil/planes';
				$this->data['message']='No estas autorizado a realizar esta acción.<br><b> Has alcanzado el límite de cuentas possibles a añadir con el plan gratuito.</b>';
				$this->data['result']='error';
	
				$this->data['titlepage']="Twitter - Añadir cuentas";
				$this->load->view("panel/twitter/anadir_cuentas",$this->data);

		}
		else
		{
		
			$this->load->library("twitterlib",'','twtlib');
			$res=$this->twtlib->auth(base_url('panel/twitter/callback'));
				
		}
	}
	//funcio de retorn de la connexio a twitter
	public function callback()
	{
		$this->load->library("twitterlib",'','twtlib');
		//valido la resposta de twitter
		$res=$this->twtlib->checkresponse();
		if(is_array($res))
		{

			$this->twtlib->setAccessToken($res);
			$datauser=$this->twtlib->getUserdata();
			//comporovo si ja existeix l'usuri de twitter 
			$exist=$this->social_users->Exists($datauser->id,'tw',$this->flexi_auth->get_user_id());
			if($exist==false)
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
			
			$this->data['titlepage']="Twitter - Añadir cuentas";
			$this->data['message']="Las cuentas de twitter se han añadido correctamente";
			$this->data['result']='success';
			$this->load->view("twitter/anadir_cuentas",$this->data);

		}
		else
		{
			$this->data['titlepage']="Twitter - Añadir cuentas";
			$this->data['message']="Hubo un fallo al procesar su petición";
			$this->data['result']='error';
			$this->load->view("twitter/anadir_cuentas",$this->data);
		}
		
	}
	public function checkSelected($str)
	{

		if ($str=='')

		{
			$this->form_validation->set_message('checkSelected', 'Debe seleccionar las cuentas donde publicar');
			return FALSE;
		}
		else 
		{
			return TRUE;
		}
	}
	
	// permet publicar a twitter
	public function publicar()
	{
		$this->load->model('social_user_accounts');
		$this->load->model('social_users');
		$this->form_validation->set_rules('ck_group_ap[]','Páginas','callback_checkSelected');
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
         					//var_dump(($this->input->post('texto_facebook')=='' && $this->input->post('link')=='' && $this->input->post('anuncis')=='' && $this->input->post('bbdd')=='' && $_FILES['imagen']['name']==''));
					if($this->input->post('texto_facebook')=='' && $this->input->post('link')=='' && $this->input->post('anuncis')=='' && $this->input->post('bbdd')=='' && $_FILES['imagen']['name']=='')
					{
						echo json_encode(array('msg_errors'=>array('errors'=>'Debe introducir un texto, imagen , enlace o seleccionar un elemento de una base de datos o anuncio para publicar')));      
						exit;
					}
					else
					{

						$this->load->library('form_validation_global');
						$response=$this->form_validation_global->ErrorsPublicar($this->input->post());
						$row=null;
						$file=false;
						$urlfb="statuses/update";
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
								$file=true;
								$params['media']= $row[0]->path;
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
						
							if(isset($_FILES['imagen']['name']) && $_FILES['imagen']['name']!="")
                                    {
                                        
                                       $array=array('image/jpg','image/jpeg','image/png','image/x-png','image/gif');
                                       if(in_array($_FILES['imagen']['type'],$array))
                                       {

	                                       	$file=true;
	                                       	if(isset($_FILES['imagen_overlay']['name']) && $_FILES['imagen_overlay']['name']!="")
		                                  	{
		                                  		$params['media']=$this->form_validation_global->setWatermarkImage($_FILES['imagen']['tmp_name'],$_FILES['imagen_overlay']['tmp_name']);
		                                  	}
		                             		else
		                             		{
                             		
	                                       		$params['media']=$_FILES['imagen']['tmp_name'];
	                                       }
	                                       	
                                       }
                                        
                                   
                                    }
                    	      		
                    	      		if(isset($link))
                    	      		
                    	      			$params['status']=$this->input->post('texto_facebook')." ".(isset($text)?$text:'')." ".(isset($link)?$link:'');
                    	      		else
                    	      			$params['status']=$this->input->post('texto_facebook')." ".(isset($text)?$text:'')." ".$this->input->post('link');
                    	      		

             		            
	             		            
	             		        

                              //var_dump($params);
						$this->load->library("twitterlib",'','twtlib');
						$group_ap=$this->input->post('ck_group_ap');
						$errorflag=false;
						$errors=array();
						foreach ($group_ap as $accountid) 
						{
							
							$user=$this->social_users->getUserAppUsers(array('user_id'=>$accountid,'user_app'=>$this->flexi_auth->get_user_id()),1);
							$this->twtlib->setAccessToken(json_decode($user[0]->access_token));
							if($file)
							{
								$res=$this->twtlib->upload($params);
							}
							else
							{
								$res=$this->twtlib->post($urlfb,$params);
							}	
							if(is_array($res) && isset($res['error']))
							{
								$errorflag=true;
								$errors['user'][$accountid]['error']=$res;
								$errors['user'][$accountid]['name']=$user[0]->username;
							}
							
						}
							if($errorflag===true)
								echo json_encode(array('msg_errors'=>array('errors'=>"No se ha podido publicar correctamente en alguna de las cuentas seleccionadas"),'errors'=>$errors));
							else
								echo json_encode(array('msg_success'=>'La publicación se ha realizado correctamente'));
		
						
						 
					}

         			}
         		}
         		exit;
		}

		
		
		
		
		
		
			//$this->data['users']=$this->social_users->getUserAppUsers(array('social_network'=>'tw','user_app'=>$this->flexi_auth->get_user_id()));

		$this->load->library('form_validation_global');
		$this->data['accordiondata']['arraydata']=$this->form_validation_global->getAccountsByFolderTwt();
			if ($this->flexi_auth->is_privileged('acces user prem') || $this->is_guest==true)
			{
				$this->data['basesdedatos']=$this->bases_datos_model->getAllWithAdmin(array('socialnetwork'=>'twt','user_app'=>$this->flexi_auth->get_user_id()),array('is_admin'=>1,'socialnetwork'=>'twt'));
				$this->data['anuncios']=$this->anuncios_model->getAllWithAdmin(array('socialnetwork'=>'twt','user_app'=>$this->flexi_auth->get_user_id()),array('is_admin'=>1,'socialnetwork'=>'twt'));
				
			}
			else if($this->flexi_auth->is_privileged('acces user free') && $this->is_guest==false)
			{
				$this->data['basesdedatos']=$this->bases_datos_model->get_many_by(array('is_admin'=>1,'socialnetwork'=>'twt'));
				$this->data['anuncios']=$this->anuncios_model->get_many_by(array('is_admin'=>1,'socialnetwork'=>'twt'));
			
			}
			$this->data['titlepage']="Twitter - Publicar ahora";
			

		$this->load->view('panel/twitter/publicar',$this->data);
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
		public function programar_twitter(){
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
						echo json_encode(array('msg_errors'=>array('errors'=>'Debe introducir un texto, imagen , enlace o seleccionar un elemento de una base de datos o anuncio para publicar')));      
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
								$link=$row[0]->link;
							}
							else
							{
								$text=$row[0]->sentence;
							}

						}
						
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
		                                        //si hia ha imatge de marca daigua la afegeixo 
		                                        if(isset($_FILES['imagen_overlay']['name']) && $_FILES['imagen_overlay']['name']!="")
			                                  	{
			                                  		$file=$this->form_validation_global->setWatermarkImage($file,$_FILES['imagen_overlay']['tmp_name']);
			                                  	}
                             	
		                                        $data['path']=$file['full_path'];
		                                        $data['text']=(isset($text)?$text.$this->input->post('texto_facebook'):$this->input->post('texto_facebook'));
		                                        $data['link']=$this->input->post('link');
		                                    }
                                       }
                                   
                                   
                                    }
                                    $data['text']=(isset($text)?$text.$this->input->post('texto_facebook'):$this->input->post('texto_facebook'));
                                    if(isset($link))
                                    	$data['link']=$link;
                                    else
                                    	$data['link']=$this->input->post('link');
                                   
						
										$fecha=DateTime::createFromFormat('d-m-Y H:i',$this->input->post('date')." ".$this->input->post('time'),new DateTimeZone($this->session->userdata('timezone')));
						//echo $fecha->format('d-m-y H:i');

						$fecha->setTimezone(new DateTimeZone('Europe/London'));
						//echo $fecha->format('d-m-y H:i');

						$data['fecha']=$fecha->format('U');

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
										
						foreach ($group_ap as $accountid) 
						{
							
							$data['socialaccount']=$accountid;
							$data['user_app']=$this->flexi_auth->get_user_id();
							$data['type_socialaccount']='user';
							$data['social_network']="tw";

							$this->programations->insertNew($data);
							

						}
						 echo json_encode(array('msg_success'=>'La programación se ha creado correctamente'));
						
					}
				}
			}
			exit;
		}
		
		
		$this->load->library('form_validation_global');
		$this->data['accordiondata']['arraydata']=$this->form_validation_global->getAccountsByFolderTwt();
		

			if ($this->flexi_auth->is_privileged('acces user prem') || $this->is_guest==true)
			{
				$this->data['basesdedatos']=$this->bases_datos_model->getAllWithAdmin(array('socialnetwork'=>'twt','user_app'=>$this->flexi_auth->get_user_id()),array('is_admin'=>1,'socialnetwork'=>'twt'));
				$this->data['anuncios']=$this->anuncios_model->getAllWithAdmin(array('socialnetwork'=>'twt','user_app'=>$this->flexi_auth->get_user_id()),array('is_admin'=>1,'socialnetwork'=>'twt'));
				
			}
			else if($this->flexi_auth->is_privileged('acces user free') && $this->is_guest==false)
			{
				$this->data['basesdedatos']=$this->bases_datos_model->get_many_by(array('is_admin'=>1,'socialnetwork'=>'twt'));
				$this->data['anuncios']=$this->anuncios_model->get_many_by(array('is_admin'=>1,'socialnetwork'=>'twt'));
			
			}
			//$programaciones=$this->programations->get_many_by(array('social_network'=>'tw','user_app'=>$this->flexi_auth->get_user_id()));
			/*foreach ($programaciones as $prog) {
				
					$user=$this->social_users->getUserAppUsers(array('user_id'=>$prog->socialaccount,'user_app'=>$this->flexi_auth->get_user_id()),1);	
		
					$prog->name=$user[0]->username;
			}*/
			$this->data['programaciones']=$this->form_validation_global->getProgramationsByFolder('tw');
			//$this->data['programaciones']=$programaciones;
			

		$this->data['titlepage']="Twitter - Programar publicación";
		$this->load->view("panel/twitter/programar",$this->data);
	}
	function date_valid($date){
	$fecha2=DateTime::createFromFormat('d-m-Y H:i',$this->input->post('date').$this->input->post('time'),new DateTimeZone($this->session->userdata('timezone')));
		//$fecha2->setTimeZone(new DatetimeZone($this->session->userdata('timezone')));	    

	    if($fecha2)
	    {
	    		
	    		$fecha=new DateTime('now',new DatetimeZone($this->session->userdata('timezone')));
	    		$diff=(($fecha2->format('U')-$fecha->format('U'))/60);
		    	if($diff<=1)
		     	{
		    		$this->form_validation->set_message('date_valid', 'Debe seleccionar una fecha y hora posterior');
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


			$this->form_validation->set_rules('datos[frecuencia]','Frecuencia','required');
			$this->form_validation->set_rules('datos[user]','Cuentas','callback_checkSelected');
			$this->form_validation->set_rules('datos[asociard][]','Bases de datos','required');
			$this->form_validation->set_rules('datos','Horas de publicación','callback_checkhours');
			if($this->form_validation->run()==TRUE)
			{

				$datos=$this->input->post('datos');
				if(isset($datos['user']))
				{
					foreach($datos['user'] as $id)
					{
						$this->autoprog_basededatos->insertNew(array(
						'ids'=>(isset($datos['asociard'])?json_encode($datos['asociard']):'[]'),
						'repeat'=>(isset($datos['repeat'])?$datos['repeat']:0),
						'socialnetwork'=>'tw',
						'frequency'=>$datos['frecuencia'],
						'time_start'=>$datos['hora_inicio'],
						'time_end'=>$datos['hora_fin'],
						'user_app'=>$this->flexi_auth->get_user_id(),
						"weekdays"=>(isset($datos['diasp'])?json_encode($datos['diasp']):'[]'),
						'perm_sentences'=>$datos['frases_perm'],'accountid'=>$id,'type'=>'user'));
						
					}
				}
				
			echo json_encode(array('msg_success'=>'Programaciones periódicas creadas con éxito en las cuentas seleccionadas'));

			}

			else
			{

					$errors = $this->form_validation->error_array();
                     echo json_encode(array('msg_errors'=>$errors));
			}
			exit;
		}
		else if($this->input->post('anuncios'))
		{

			$this->form_validation->set_rules('anuncios[frecuencia]','Frecuencia','required');
			$this->form_validation->set_rules('anuncios[user]','Cuentas','callback_checkSelected');
			$this->form_validation->set_rules('anuncios[asociard]','Bases de datos','required');
			$this->form_validation->set_rules('anuncios','Horas de publicación','callback_checkhours');
			if($this->form_validation->run()==TRUE)
			{
				$anuncios=$this->input->post('anuncios');
				if(isset($anuncios['user']))
				{
					foreach($anuncios['user'] as $id)
					{
						$this->autoprog_anuncios->insertNew(array(
						'ids'=>$anuncios['asociard'],
						'frequency'=>$anuncios['frecuencia'],
						'repeat'=>(isset($datos['repeat'])?$datos['repeat']:0),
						'socialnetwork'=>'tw',
						'frequency_erase'=>(isset($anuncios['frecuencia_borrado'])?$anuncios['frecuencia_borrado']:0),
						'time_start'=>$anuncios['hora_inicio'],
						"weekdays"=>(isset($anuncios['diasp'])?json_encode($anuncios['diasp']):'[]'),
						'time_end'=>$anuncios['hora_fin'],
						'user_app'=>$this->flexi_auth->get_user_id(),
						'perm_sentences'=>$anuncios['frases_perm'],'accountid'=>$id,'type'=>'user'));
					}
				}
echo json_encode(array('msg_success'=>'Programaciones periódicas creadas con éxito en las cuentas seleccionadas'));
			}
			else
			{
						$errors = $this->form_validation->error_array();
                     echo json_encode(array('msg_errors'=>$errors));
			}
			exit;	
		}
		
		$programacionesbbdd=$this->autoprog_basededatos->get_many_by(array('socialnetwork'=>'tw','user_app'=>$this->flexi_auth->get_user_id()));
		$programacionesanuncios=$this->autoprog_anuncios->get_many_by(array('socialnetwork'=>'tw','user_app'=>$this->flexi_auth->get_user_id()));
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
		foreach ($programacionesanuncios as $prog) {
			if($prog->type=='account')
			{
				$acc=$this->social_user_accounts->getUserAppAccounts(array('idaccount,'=>$prog->accountid,'user_app'=>$this->flexi_auth->get_user_id()),1);
				$prog->name=$acc[0]->name;
			}
			else
			{
				$user=$this->social_users->getUserAppUsers(array('user_id'=>$prog->accountid,'user_app'=>$this->flexi_auth->get_user_id()),1);	
				$prog->name=$user[0]->username;
			}
		
		}
		$this->load->library('form_validation_global');
		//guardem les programacions a mostrar en la vista
		$this->data['autoprog']['basededatos']=$this->form_validation_global->getAutoProgByFolder('bbdd','tw');
		$this->data['autoprog']['anuncios']=$this->form_validation_global->getAutoProgByFolder('anunci','tw');
		//$this->data['autoprog']['basededatos']=$programacionesbbdd;
		//$this->data['autoprog']['anuncios']=$programacionesanuncios;
		//agafem les comptes de twiitter i les carpetes creades per usuari
		
		$this->data['accordiondata']['arraydata']=$this->form_validation_global->getAccountsByFolderTwt();
	

		//agafem les dades de les anuncis i bases de dades creades per usuari.
		$this->data['basesdedatos']=$this->bases_datos_model->getAllWithAdmin(array('socialnetwork'=>'twt','user_app'=>$this->flexi_auth->get_user_id()),array('is_admin'=>1,'socialnetwork'=>'twt'));
		$this->data['anuncios']=$this->anuncios_model->getAllWithAdmin(array('socialnetwork'=>'twt','user_app'=>$this->flexi_auth->get_user_id()),array('is_admin'=>1,'socialnetwork'=>'twt'));

		$this->data['titlepage']="Twitter - Programaciones periódicas";
		$this->load->view('twitter/autoprog',$this->data);		
	}
	public function listas()
	{

		$this->data['users']=$this->social_users->getUserAppUsers(array('social_network'=>'tw','user_app'=>$this->flexi_auth->get_user_id()));

		$this->data['titlepage']="Twitter - Gestión de listas";
		$this->load->view('twitter/lists',$this->data);		

	}
	public function gestion_listas()
	{
			if($this->input->get('userlist') && is_numeric($this->input->get('userlist')))
			{
					$account=$this->social_users->getUserappUsers(array('user_id'=>$this->input->get('userlist'),'user_app'=>$this->flexi_auth->get_user_id()),1);
					
					$this->load->model('twt_lists');
					$this->data['user_id']=$account[0]->user_id;
					$this->data['lists']=array();	
					$listas=$this->twt_lists->getUserappLists(array('user_app'=>$this->flexi_auth->get_user_id(),'user_id'=>$account[0]->user_id));
					
					if(count($listas)>0)
					{
						$this->load->library('Twitterlib','','twtlib');
						$this->twtlib->setAccessToken(json_decode($account[0]->access_token));
					
						
						foreach ($listas as $key ) {
							$resultdata=$this->twtlib->get('lists/show',array('list_id'=>$key->list_id));
							
							if(is_object($resultdata))
							{

								$this->listsdata[$key->list_id]=$resultdata;
								if(strcmp($key->list_name,$this->listsdata[$key->list_id]->name)!=0)
								{
//var_dump($this->listsdata[$key->list_id]->name);
									$this->twt_lists->update_by(
										array(
											'list_name'=>$resultdata->name
											),
										array(
											'user_app'=>$this->flexi_auth->get_user_id(),
											'list_id'=>$key->list_id,
											'user_id'=>$key->user_id)
										);
									
									$key->list_name=$this->listsdata[$key->list_id]->name;	
								}
								if(strcmp($key->username,$this->listsdata[$key->list_id]->user->name)!=0)
								{
									 $key->username=$this->listsdata[$key->list_id]->user->name;
									$this->twt_lists->update_by(array('username'=>$resultdata->user->name),array('user_app'=>$this->flexi_auth->get_user_id(),'list_id'=>$key->list_id,'user_id'=>$key->user_id));

								}
							}
							else
							{
							///	echo "ss"							}
							}
							

						}
						
						$this->data['lists']=$listas;
					}		

					$this->session->set_userdata('userid',$account);
					$this->session->set_userdata('listsdata',$this->listsdata);
					
					$this->data['titlepage']="Twitter - Gestión de listas de ".$account[0]->username;
					$this->load->view('twitter/user_lists',$this->data);		


			}
			else
			{
				redirect(base_url().'panel/twiitter/listas');
			}

	}
	public function editlist($listid)
	{
		$this->listsdata=$this->session->userdata('listsdata');
		
		$account=$this->session->userdata('userid');
		$this->load->library('Twitterlib','','twtlib');
		$this->twtlib->setAccessToken(json_decode($account[0]->access_token));
		$this->data['members']=$this->twtlib->get('lists/members',array('list_id'=>$listid));
		$this->data['datalist']=$this->listsdata[$listid];

		$this->load->view('twitter/edit_list',$this->data);	
	}
	public function addmemberlist()
	{
		if($this->input->post('screen_name'))
		{
			
			$account=$this->session->userdata('userid');
			$this->load->library('Twitterlib','','twtlib');
			$this->twtlib->setAccessToken(json_decode($account[0]->access_token));
			$res=$this->twtlib->post('lists/members/create',array('list_id'=>$this->input->post('listid'),'screen_name'=>$this->input->post('screen_name')));
			
			
		}
	}
	public function removeMemberlist()
	{
		if($this->input->post('screen_name'))
		{
			$account=$this->session->userdata('userid');
			$this->load->library('Twitterlib','','twtlib');
			$this->twtlib->setAccessToken(json_decode($account[0]->access_token));
			$res=$this->twtlib->post('lists/members/destroy',array('list_id'=>$this->input->post('listid'),'screen_name'=>$this->input->post('screen_name')));
			
		}
	}
	private $listsdata;
	/**
	 * [listsearchusers funcio seveix per fer cerca usuaris   twutter al editar una lllista
	 * @return [type] [description]
	 */
	public function listsearchusers()
	{
		$q=$this->input->get('q');
		$listid=$this->input->get('listid');
		$account=$this->session->userdata('userid');
		$this->load->library('Twitterlib','','twtlib');
		$this->twtlib->setAccessToken(json_decode($account[0]->access_token));
		$res=$this->twtlib->get('users/search',array('q'=>$q));
		$members=$this->twtlib->get('lists/members',array('list_id'=>$listid));
		foreach ($members->users as $key) {
				foreach ($res as $key2) {
					if($key->id==$key2->id)
						$key2->ismember=true;
				}
		}
		echo json_encode($res);

	}
	public function getDataList()
	{

			if($this->input->get('listid'))
			{
				$this->load->library('Twitterlib','','twtlib');
				$res=$this->twtlib->get("lists/statuses",array('list_id'=>$this->input->get('listid'),'since_id'=>(($this->input->get('since_id')==false)?1:$this->input->get('since_id')),'count'=>200,'include_rts'=>1,'include_entities'=>1));
				echo json_encode($res);
			}

	}
	public function quitList($idlist,$id)
	{
		if($idlist)
		{
			$this->load->model('twt_lists');
			$this->twt_lists->delete_by(array('list_id'=>$idlist,'user_app'=>$this->flexi_auth->get_user_id()));

		}
	}
	public function crearlista()
	{

		$this->form_validation->set_rules('name_list','Nombre','required');
		$this->form_validation->set_rules('desc_list','Descripcion','required');
		$this->form_validation->set_rules('privacidad','Pública o Privada','required');
		$account=$this->session->userdata('userid');
		if($this->input->post())
		{
			if($this->form_validation->run()==TRUE)
			{
				$this->load->library("Twitterlib",'','twtlib');
				$this->twtlib->setAccessToken(json_decode($account[0]->access_token));
				$listcreated=$this->twtlib->post('lists/create',array('mode'=>$this->input->post('privacidad'),'name'=>$this->input->post('name_list'),'description'=>$this->input->post('desc_list')));
				$this->load->model('twt_lists');		
				$this->twt_lists->insertNew(array('user_app'=>$this->flexi_auth->get_user_id(),'user_id'=>$account[0]->user_id,'list_id'=>$listcreated->id,'is_subscriberlist'=>0,'list_name'=>$this->input->post('name_list'),'username'=>$account[0]->username));
					echo json_encode(array('msg_success'=>'La lista se ha creado correctamente'));
			}
			else
			{
				    $errors = $this->form_validation->error_array();
                   echo json_encode(array('msg_errors'=>$errors));      

			}

			exit;
		}
		$this->data['usertwtid']=$account[0];
		$this->load->view('twitter/create_list',$this->data);
	}
	public  function getLists($usertwt)
	{
		if($usertwt)
		{
			$this->load->model('twt_lists');
			$account=$this->social_users->getUserappUsers(array('user_id'=>$usertwt,'user_app'=>$this->flexi_auth->get_user_id()),1);
			$this->load->library("Twitterlib",'','twtlib');
			$this->twtlib->setAccessToken(json_decode($account[0]->access_token));
			$listas=$this->twt_lists->getUserappLists(array('user_app'=>$this->flexi_auth->get_user_id(),'user_id'=>$account[0]->user_id));
			$this->data['usertwtid']=$usertwt;
			$subslists=$this->twtlib->get('lists/subscriptions',array('user_id'=>$usertwt));
			
			for ($i=0;$i<count($subslists->lists);$i++) {
				
				$exist=$this->twt_lists->Exists($account[0]->user_id,$subslists->lists[$i]->id,$this->flexi_auth->get_user_id());

				if($exist)
					unset($subslists->lists[$i]);
			}
			$ownlists=$this->twtlib->get('lists/ownerships',array('user_id'=>$usertwt));
			for ($i=0;$i<count($ownlists->lists);$i++) {
				
				$exist=$this->twt_lists->Exists($account[0]->user_id,$ownlists->lists[$i]->id,$this->flexi_auth->get_user_id());

				if($exist)
					unset($ownlists->lists[$i]);
			}
			$this->data['subslists']=$subslists;

			$this->data['ownlists']=$ownlists;
		

			$this->load->view('twitter/get_lists',$this->data);					

		}

	}
	public function addLists()
	{
		if($this->input->post())
		{
			$this->load->model('twt_lists');
			foreach($this->input->post('ownlistsids') as $id)
			{
				$this->twt_lists->insertNew(array('user_app'=>$this->flexi_auth->get_user_id(),'user_id'=>$this->input->post('userid'),'list_id'=>$id,'is_subscriberlist'=>0));
			}
			foreach($this->input->post('subslistsids') as $id)
			{
				$this->twt_lists->insertNew(array('user_app'=>$this->flexi_auth->get_user_id(),'user_id'=>$this->input->post('userid'),'list_id'=>$id,'is_subscriberlist'=>1));
			}
		}
	}
	public function deletelist($listid)
	{
		if($listid)
		{
			$this->load->model('twt_lists');
			$this->twt_lists->delete_by(array('list_id'=>$listid,'user_app'=>$this->flexi_auth->get_user_id()));

			$account=$this->session->userdata('userid');
			$this->load->library('Twitterlib','','twtlib');
			$this->twtlib->setAccessToken(json_decode($account[0]->access_token));
			$res=$this->twtlib->post('lists/destroy',array('list_id'=>$listid));
			redirect(base_url().'panel/twitter/gestion_listas?userlist='.$account[0]->user_id);

		}
	}
	public function editdetailslist($listid)
	{
		$this->listsdata=$this->session->userdata('listsdata');
		$account=$this->session->userdata('userid');
		$this->load->library('Twitterlib','','twtlib');
		$this->twtlib->setAccessToken(json_decode($account[0]->access_token));
		
		if($this->input->post('name_list'))
		{
			$res=$this->twtlib->post('lists/update',array('list_id'=>$listid,'mode'=>$this->input->post('privacidad'),'name'=>$this->input->post('name_list'),'description'=>$this->input->post('desc_list')));	
			var_dump($res);
			exit;
		}
		$this->data['members']=$this->twtlib->get('lists/members',array('list_id'=>$listid));
		$this->data['datalist']=$this->listsdata[$listid];

		$this->load->view("twitter/edit_list_detailed",$this->data);
	}
}

/* End of file twitter.php */
/* Location: ./application/modules/panel/controllers/twitter.php */