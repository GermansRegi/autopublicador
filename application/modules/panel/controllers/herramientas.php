<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Herramientas extends CI_Controller {
		public function __construct()
	{
		parent::__construct();
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
	/*	$this->auth = new stdClass;

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
				{
					$this->load->vars('privilege_user_app','free');
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
		$this->data['username']=$this->flexi_auth->get_user_by_id_query($this->flexi_auth->get_user_id(),array("upro_first_name"))->result();	*/
	}
	/**
	 * [index mostra els links a les diferents eines proporcionades]
	 * @return [type] [description]
	 */
	public function index()
	{
		$this->data['titlepage']="Herramientas";		
		$this->load->view('herramientas/index',$this->data);
	}
	/**
	 * [checkSelected funcio per validar si usuari ha seleccionat comptes]
	 * @param  [type] $str [description]
	 * @return [type]      [description]
	 */
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
	/**
	 * [limpiador_facebook accio de formulari que esborra publicacions dun o varis comptes de facebook]
	 * @return [type] [description]
*/
	/*
	public function limpiador_facebook()
	{
			$this->form_validation->set_rules('type',"Tipo de limpieza","required");
			$this->form_validation->set_rules('ck_group_ap','Cuentas','callback_checkSelected');
			if($this->input->post())
			{
				if($this->form_validation->run()==TRUE)
				{
					$type_erase=$this->input->post('type');
					$cuentas=$this->input->post('ck_group_ap');
					$users=(isset($cuentas['user'])?$cuentas['user']:array());
					$this->load->model('req_clean_account');
					if($type_erase==1)
						$clean='photos';
					elseif($type_erase==2)
						$clean='spam';
					else
						$clean='all';
					
					$accounts=(isset($cuentas['account'])?$cuentas['account']:array());
					//per cada compte de tipus usuari
					 foreach ($users as $user) {
						$this->req_clean_account->insert(array('accountid'=>$user,
							'type_socialaccount'=>'user',
							'social_network'=>'fb',
							'user_app'=>$this->flexi_auth->get_user_id(),
							'type_clean'=>$clean));

					 }
					 //per cada compte de tipus conta
					 foreach ($accounts as $account) {
						$this->req_clean_account->insert(array('accountid'=>$account,
							'type_socialaccount'=>'account',
							'social_network'=>'fb',
							'user_app'=>$this->flexi_auth->get_user_id(),
							'type_clean'=>$clean));				 }
					
				echo json_encode(array('msg_success'=>'Operación en proceso, recibirá un correo cuándo se haya completado'));

				}
				else
				{
					  $errors = $this->form_validation->error_array();
                   echo json_encode(array('msg_errors'=>$errors));      

				}
				
				exit;
			}
			$this->load->library('form_validation_global');
			$this->data['accordion']['arraydata']=$this->form_validation_global->getAccountsByFolderFB();

			//carrego les dades dels diferents comptes i usuaris de facebook de laplicacio
			$this->data['titlepage']="Herramientas - Limpiador de facebook";

		$this->load->view('herramientas/limpiador_facebook',$this->data);
	}
	*/
	public function buscador_de_imagenes()
	{
		if($this->input->post('albumid'))
		{
			$this->form_validation->set_rules('albumid','Albumes','required');
			$this->form_validation->set_rules('asociard','Base de datos','required');
			if($this->form_validation->run()==TRUE)
			{
				$this->load->model('bases_datos_model');
				$photos=$this->getAlbumimages($this->input->post('albumid'));
				//var_dump($photos);
				if(isset($photos['data']))
				{
					foreach ($photos['data'] as $photo) {
					
					$this->bases_datos_model->insertElement('image',array('user_app'=>$this->flexi_auth->get_user_id(),'bbdd_id'=>$this->input->post('asociard'),'path'=>$photo->source));

					}		
					echo json_encode(array('msg_success'=>'Operación realizada con éxito'));
				}

				
			}
			else
			{
				$errors = $this->form_validation->error_array();
		             echo json_encode(array('msg_errors'=>$errors));	
			}
			exit;
			
		}
		elseif($this->input->post('pageselected'))
		{
			$this->load->library('Facebooklib','','fblib');
			$this->fblib->setSessionFromToken($this->config->item('api_id', 'facebook')."|".$this->config->item('app_secret', 'facebook'));
			$res=$this->fblib->api("/".$this->input->post('pageselected')."/albums");
			$this->load->model('bases_datos_model');
			$res['accesstoken']=$this->config->item('api_id', 'facebook')."|".$this->config->item('app_secret', 'facebook');
			$res['bd']=$this->data['basesdedatos']=$this->bases_datos_model->get_many_by(array('socialnetwork'=>'face','user_app'=>$this->flexi_auth->get_user_id(),'content'=>'image'));
			echo json_encode($res);
			exit;
		}
		
		elseif($this->input->post('pagename'))
		{

			$res=$this->searchpages($this->input->post('pagename'));
			if($res==0)
			{
				echo json_encode(array('msg_errors'=>array('errors'=>"No se ha encontrado una página con el nombre introducido")));
				exit;
			}
			
			echo json_encode(array('pages'=>$res['data']));
			exit;
		}

		$this->data['titlepage']="Herramientas - Buscador de imagenes de Facebook";
		$this->load->view('herramientas/buscador_imagenes',$this->data);	
	}
	public function getAlbumimages($id)
	{
		$this->load->library('Facebooklib','','fblib');
		$this->fblib->setSessionFromToken($this->config->item('api_id', 'facebook')."|".$this->config->item('app_secret', 'facebook'));
		return $this->fblib->api('/'.$id."/photos");

	}
	public function searchpages($name)
	{
		$this->load->library('Facebooklib','','fblib');
		$this->fblib->setSessionFromToken($this->config->item('api_id', 'facebook')."|".$this->config->item('app_secret', 'facebook'));
		return $this->fblib->api('/search',array('q'=>$name,'type'=>'page'));
		
	}
	public function getImagesPage($name)
	{
		
		if(count($res['data'])==1)
		{
			
				
		}
		else
		{
			return 0;
		}
	}
		/**
	 * [unfollow_twitter accio de formulari que permet deixar de seguir als usuaris de twitter de l'aplicacio]
	 * @return [type] [description]
	 */
	public function getTwitterFollowers($user_id)
	{
		$e = 1;
		$cursor = -1;
		do {

		$follows = $this->twtlib->get("followers/ids",array('cursor'=>$cursor,'user_id'=>$user_id));

		$foll_array = (array)$follows;

		  foreach ($foll_array['ids'] as $key => $val) {

		        $full_friends[$e] = $val;
		        $e++; 
		  }
		       $cursor = $follows->next_cursor;

		  } while ($cursor > 0);
		  return $full_friends;
	
	}
	public function getTwitterFollowing($user_id)
	{
		$e = 1;
		$cursor = -1;
		do {

		$follows = $this->twtlib->get("friends/ids",array('cursor'=>$cursor,'user_id'=>$user_id));

		$foll_array = (array)$follows;

		  foreach ($foll_array['ids'] as $key => $val) {

		        $full_friends[$e] = $val;
		        $e++; 
		  }
		       $cursor = $follows->next_cursor;

		  } while ($cursor > 0);
		  return $full_friends;
	}
	public function UnfollowNotFollowBack($user_id,$token)
	{
		$this->load->library('Twitterlib','','twtlib');
	
		$this->twtlib->setAccessToken(json_decode($token));
	
		$followers = $this->getTwitterFollowers($user_id);
        $following = $this->getTwitterFollowing($user_id);
        var_dump($followers);
        var_dump($following);
        $tounfollow = array();
        foreach ($following as $f) {
            if (!in_array($f, $followers)) {
                $tounfollow[] = $f;
            }
        }
          foreach ($tounfollow as $friend) {

			$follows = $this->twtlib->post("friendships/destroy",array('user_id'=>$friend));		  	
		
		  }
        
	}
	public function unfollow_twitter()
	{
	
		if($this->input->post())
		{
			$this->form_validation->set_rules('user[]','Cuentas','required');
			if($this->form_validation->run()==TRUE)
			{
				

				$users=$this->input->post('user');
				foreach ($users as $userid) {
					$userRow=$this->social_users->getUserAppUsers(array('user_id'=>$userid,'user_app'=>$this->flexi_auth->get_user_id()),1);		 	
					if($this->input->post('type_unfollow')=='1')
						$this->makeUnFollow($userRow[0]->access_token,$userid);
					else
						$this->UnfollowNotFollowBack($userid,$userRow[0]->access_token);

				}
				 echo json_encode(array('msg_success'=>'Operación realizada con éxito'));
			}
			else
			{
				    $errors = $this->form_validation->error_array();
		             echo json_encode(array('msg_errors'=>$errors));
			}
			exit;
		}
		$this->data['titlepage']="Herramientas - Unfollow twitter";
		$this->load->library('form_validation_global');
		$this->data['accordion']['arraydata']=$this->form_validation_global->getAccountsByFolderTwt();

//		$this->data['users']=$this->social_users->getUserAppUsers(array('social_network'=>'tw','user_app'=>$this->flexi_auth->get_user_id()));
		$this->load->view('herramientas/unfollow_twitter',$this->data);		
	}
	public function follow_twitter()
	{
		if($this->input->post('usernames'))
		{
			$this->form_validation->set_rules('user[]','Cuentas','required');
			$this->form_validation->set_rules('usernames[]','Nombre de usuario','required');
			if($this->form_validation->run()==TRUE)
			{
				$users=$this->input->post('user');
				$usernames=$this->input->post('usernames');
				foreach ($users as $userid) {
					
					$userRow=$this->social_users->getUserAppUsers(array('user_id'=>$userid,'user_app'=>$this->flexi_auth->get_user_id()),1);		 	
					foreach($usernames as $name)
					{
						$result=$this->makeFollow($userRow[0]->access_token,$name);	
	//					var_dump($result);
					}
					
					
				}
				 echo json_encode(array('msg_success'=>'Operación realizada con éxito'));
			}
			else
			{
				    $errors = $this->form_validation->error_array();
		             echo json_encode(array('msg_errors'=>$errors));
			}
			exit;
		}
		elseif($this->input->post('search'))
		{
			$this->form_validation->set_rules('user[]','Cuentas','required');
			$this->form_validation->set_rules('search','Temática','required');
			if($this->form_validation->run()==TRUE)
			{
				$this->load->library('Twitterlib','','twtlib');
        		$users=$this->input->post('user');
        			$userRow=$this->social_users->getUserAppUsers(array('user_id'=>$users[0],'user_app'=>$this->flexi_auth->get_user_id()),1);		 	
		
				////agafo el token de laplicacio
				
				// aplico el token de aplicacio 	
    			$this->twtlib->setAccessToken(json_decode($userRow[0]->access_token));
    			$page=1;
    			$result=array();
            	do{
            	$res=$this->twtlib->get('users/search',array('q'=>$this->input->post('search'),'count'=>20,'page'=>$page));	
				$result[$page-1]=$res;
				$page++;
				
				
				
				
				}while($page<7);
				 echo json_encode(array('users'=>$result));
			}
			else
			{
				    $errors = $this->form_validation->error_array();
		             echo json_encode(array('msg_errors'=>$errors));
			}
			exit;
		}
		$this->data['titlepage']="Herramientas - Follow twitter";
		$this->load->library('form_validation_global');
		$this->data['accordion']['arraydata']=$this->form_validation_global->getAccountsByFolderTwt();

//		$this->data['users']=$this->social_users->getUserAppUsers(array('social_network'=>'tw','user_app'=>$this->flexi_auth->get_user_id()));
		$this->load->view('herramientas/follow_twitter',$this->data);		
		
	}
	
	
	public function makeFollow($token,$username)
	{
		$this->load->library('Twitterlib','','twtlib');
	
		$this->twtlib->setAccessToken(json_decode($token));
		
		
		$follows = $this->twtlib->post("friendships/create",array('user_id'=>$username,'follow'=>"true"));		  	
		
		return $follows;

		
		  
	}
	public function makeUnFollow($token,$user_id)
	{
		$this->load->library('Twitterlib','','twtlib');
	
		$this->twtlib->setAccessToken(json_decode($token));
		$e = 1;
		$cursor = -1;
		$full_friends = array();
		do {

		$follows = $this->twtlib->get("friends/ids",array('cursor'=>$cursor,'user_id'=>$user_id));

		$foll_array = (array)$follows;

		  foreach ($foll_array['ids'] as $key => $val) {

		        $full_friends[$e] = $val;
		        $e++; 
		  }
		       $cursor = $follows->next_cursor;

		  } while ($cursor > 0);
		  
		  foreach ($full_friends as $friend) {

			$follows = $this->twtlib->post("friendships/destroy",array('user_id'=>$friend));		  	
		
		  }
	}
	public function limpiador_twitter()
	{


		if($this->input->post())
		{	
			$this->form_validation->set_rules('user[]','Cuentas','required');
			if($this->form_validation->run()==TRUE)
			{
				$this->load->model('req_clean_account');
				$users=$this->input->post('user');
				foreach ($users as $userid) {
						$this->req_clean_account->insert(array('accountid'=>$userid,
							'type_socialaccount'=>'user',
							'social_network'=>'tw',
							'user_app'=>$this->flexi_auth->get_user_id(),
							'type_clean'=>'all'));

					
					
				}
				 echo json_encode(array('msg_success'=>'Operación en proceso, recibirá un correo cuándo se haya completado'));
			}
			else
			{
				    $errors = $this->form_validation->error_array();
		             echo json_encode(array('msg_errors'=>$errors));
			}
			exit;
		}
		$this->data['titlepage']="Herramientas - Limpiador de twitter";
		$this->load->library('form_validation_global');
		$this->data['accordion']['arraydata']=$this->form_validation_global->getAccountsByFolderTwt();

//		$this->data['users']=$this->social_users->getUserAppUsers(array('social_network'=>'tw','user_app'=>$this->flexi_auth->get_user_id()));
		$this->load->view('herramientas/limpiador_twitter',$this->data);		
	
	}
	public function searchTwits($query)
	{
		//var_dump($query);
		return  $this->twtlib->get('search/tweets',$query);
	}
	public function getTwitts($account,$number,$inclrt,$bbdd)
    {

    		///$usertw = $this->social_users->getUserAppUsers(array('user_app'=>$this->flexi_auth->get_user_id()));
    		/////carrego la llibreria de twtitter per fer la peticio  a la api
        	$this->load->library('Twitterlib','','twtlib');
        
		//$this->twtlib->setSessionFromToken(null);	
		//
		////agafo el token de laplicacio
			$aptoken=$this->twtlib->getAppToken();
			// aplico el token de aplicacio 	
            $this->twtlib->setAppToken($aptoken->access_token);
                
                
          			$count=0;  
          $arrayt=array();

          			$query=array('q'=>(($inclrt==1)?"from:":'#').$account,'count'=>50);
                    $results=$this->searchTwits($query);	                   
//                    	var_dump($results);
                    while(count($results->statuses)>0 && $count<$number) {
                    	
                    	$arrayt=array_merge($arrayt,$results->statuses); 
                    	$count=$count+count($results->statuses);

//                    	if(count($results->statuses)>0	)
  //                  	{
                    		$query=array('q'=>(($inclrt==1)?"from:":'#').$account,'count'=>50,'since_id'=>$results->statuses[count($results->statuses)-1]->id);
                    		$results=$this->searchTwits($query); 
                    		
                    		
    //                	}
                    	
          	    	
          	    	
                    	
                    }
		$this->twtlib->setAppToken(null);

var_dump($arrayt);
    		foreach ($arrayt as $twit) {
    			
    			      $this->bases_datos_model->insertElement('sentence',array(
                                'bbdd_id' =>$bbdd ,
                                'sentence' => $twit->text,
                                'user_app' => $this->flexi_auth->get_user_id()));

  			
    		}
    		
    			
    		     
    }
  
	public function extractor_tweets()
	{
		$this->load->model('bases_datos_model');
		if($this->input->post())
		{	
			//si formulari es correcte
			$this->form_validation->set_rules('asociard','Bases de datos', 'required');
			$this->form_validation->set_rules('nameacount','Nombre de la cuenta','required');
			if($this->form_validation->run()===TRUE)
			{
				$this->getTwitts($this->input->post('nameacount'),$this->input->post('qt'),$this->input->post('inclrt'),$this->input->post('asociard'));
				 echo json_encode(array('msg_success'=>'Tweets guardados correctamente'));
			}
			//sino mostro els errors
			else
			{
				    $errors = $this->form_validation->error_array();
		             echo json_encode(array('msg_errors'=>$errors));
		           
			}			
		
			exit;
		}
		$this->data['titlepage']="Herramientas - Extractor de twitter";
		$this->data['basesdedatos']=$this->bases_datos_model->get_many_by(array('socialnetwork'=>'twt','user_app'=>$this->flexi_auth->get_user_id(),'content'=>'sentence'));
		$this->load->view('herramientas/extractor_twitter',$this->data);		
	
	}
	public function contadores()
	{
		$this->load->library('Twitterlib','','twtlib');
		$this->data['users']=$this->social_users->getUserAppUsers(array('social_network'=>'tw','user_app'=>$this->flexi_auth->get_user_id()));
		

		foreach($this->data['users'] as $account)
		{
			
				$this->twtlib->setAccessToken(json_decode($account->access_token));			
				$result=$this->twtlib->get('users/show',array('user_id'=>$account->user_id));
				$account->numfollowers=$result->followers_count;
				$account->numtweets=$result->statuses_count;
				
		}
		$this->data['titlepage']="Herramientas - Contadores";
		$this->load->view('herramientas/contadores',$this->data);			
	}

}

/* End of file herramientas.php */
/* Location: ./application/modules/panel/controllers/herramientas.php */