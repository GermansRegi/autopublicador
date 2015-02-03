<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Twitter extends CI_Controller {
	
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
						$arraydata['folders'][$m]['rows'][]=$user;				
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
	
	// permet publicar a facebook
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
								$params['link']=$row[0]->link;
							}
							else
							{
								$params['status1']=$row[0]->sentence;
							}

						}
						
							if(isset($_FILES['imagen']['name']) && $_FILES['imagen']['name']!="")
                                    {
                                        
                                       $array=array('image/jpg','image/jpeg','image/png','image/x-png','image/gif');
                                       if(in_array($_FILES['imagen']['type'],$array))
                                       {
	                                       	$file=true;
	                                       	$params['media']=$_FILES['imagen']['tmp_name'];
	                                       	$params['status']=$this->input->post('texto_facebook').((isset($params['status1']) && $params['status1']!='')?$params['status1']:'');
                                       }
                                        
                                   
                                    }
                    	      	$params['status']=$this->input->post('texto_facebook').((isset($params['status1']) && $params['status1']!='')?$params['status1']:'');
                          	    	if(!isset($params['link']) || $params['link']=='')
             		            	$params['status']=$this->input->post('link');
	             		            else
	             		            $params['status']=$params['link'];

                              //var_dump($params);
						$this->load->library("twitterlib",'','twtlib');
						$group_ap=$this->input->post('ck_group_ap');
					
						foreach ($group_ap as $accountid) 
						{
							
							$user=$this->social_users->getUserAppUsers(array('user_id'=>$accountid),1);
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
								echo json_encode(array('msg_errors'=>array('pp'=>$res['error'])));
							else
								echo json_encode(array('msg_success'=>'La publicación se ha realizado correctemente'));
							}
						
						 
					}

         			}
         		}
         		exit;
		}

		
		
		
		
		
		
			$this->data['users']=$this->social_users->getUserAppUsers(array('social_network'=>'tw','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['basesdedatos']=$this->bases_datos_model->getAllWithAdmin(array('socialnetwork'=>'face','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['anuncios']=$this->anuncios_model->getAllWithAdmin(array('socialnetwork'=>'face','user_app'=>$this->flexi_auth->get_user_id()));

			$this->data['titlepage']="Publicar ahora en Twitter";
			

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
		                                        $data['text']=$this->input->post('texto_facebook');
		                                    }
                                       }
                                   
                                   
                                    }
                                    else
                                    {
                                    	$data['text']=$this->input->post('texto_facebook');
                                    	$data['link']=$this->input->post('link');
                                    }
						}
						date_default_timezone_set('UTC');
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
										
						foreach ($group_ap as $accountid) 
						{
							
							$data['socialaccount']=$accountid;
							$data['user_app']=$this->flexi_auth->get_user_id();
							$data['type_socialaccount']='user';
							$data['social_network']="tw";

							$this->programations->insertNew($data);
							

						}
						 echo json_encode(array('msg_success'=>'La programación se ha realizado correctemente'));
						
					}
				}
			}
			exit;
		}
		
		
		$this->load->model('social_users');
			$this->data['users']=$this->social_users->getUserAppUsers(array('social_network'=>'tw','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['basesdedatos']=$this->bases_datos_model->getAllWithAdmin(array('socialnetwork'=>'face','user_app'=>$this->flexi_auth->get_user_id()));
			$this->data['anuncios']=$this->anuncios_model->getAllWithAdmin(array('socialnetwork'=>'face','user_app'=>$this->flexi_auth->get_user_id()));
			$programaciones=$this->programations->getAll(array('social_network'=>'tw','user_app'=>$this->flexi_auth->get_user_id()));
			foreach ($programaciones as $prog) {
				
					$user=$this->social_users->getUserAppUsers(array('user_id'=>$prog->socialaccount),1);	
		
					$prog->name=$user[0]->username;
			}
			$this->data['programaciones']=$programaciones;
			

		$this->data['titlepage']="Programar twitter";
		$this->load->view("panel/twitter/programar",$this->data);
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
	


}

/* End of file twitter.php */
/* Location: ./application/modules/panel/controllers/twitter.php */