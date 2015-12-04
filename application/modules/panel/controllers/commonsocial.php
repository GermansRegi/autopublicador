<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CommonSocial extends CI_Controller {
	
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
 		$this->load->library('form_validation_global');
 		$this->form_validation_global->validarSession();

  		// IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded!
 		// It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
		/*
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
			if($this->input->is_ajax_request())
			{
				echo json_encode(array('req_auth'=>1));
				//redirect_js(base_url().'panel');
				exit;
			}
			else
			redirect(base_url().'panel');				
		}
		*/
	}

	
	public function index()
	{
			
	}

	public function Ondeletehaveprog($id,$isuser)
	{
		$this->load->model('programations');
		$this->load->model('autoprog_basededatos');
		$this->load->model('autoprog_anuncios');
		
		if($isuser=='true')
		{
				$acc=$this->social_users->getUserAppUsers(array('id'=>$id));
				$prog=$this->programations->count_by(array('socialaccount'=>$acc[0]->user_id,'state'=>'process','user_app'=>$this->flexi_auth->get_user_id()));
				$prog=$prog+$this->autoprog_basededatos->count_by(array('accountid'=>$acc[0]->user_id,'user_app'=>$this->flexi_auth->get_user_id()));
				$prog=$prog+$this->autoprog_anuncios->count_by(array('accountid'=>$acc[0]->user_id,'user_app'=>$this->flexi_auth->get_user_id()));
				if($prog>0)
				return true;
				else 
				return false;
		}
		else
		{
				$acc=$this->social_user_accounts->getUserappAccounts(array('id'=>$id));
				$prog=$this->programations->count_by(array('socialaccount'=>$acc[0]->idaccount,'state'=>'process','user_app'=>$this->flexi_auth->get_user_id()));
				$prog=$prog+$this->autoprog_basededatos->count_by(array('accountid'=>$acc[0]->idaccount,'user_app'=>$this->flexi_auth->get_user_id()));

				$prog=$prog+$this->autoprog_anuncios->count_by(array('accountid'=>$acc[0]->idaccount,'user_app'=>$this->flexi_auth->get_user_id()));
				if($prog>0)
				return true;
				else 
				return false;

		}
	}
	public function deleteFolderProg()
	{
		$isAutoProg=$this->input->post('isAutoProg');

		if($isAutoProg==='true')
		{
			$this->load->model('folders_autoprog');
			$foldertodelete=$this->folders_autoprog->get_by_id($this->input->post('idFolder'));
			 $array=array('bbdd'=>'basededatos','anunci'=>'anuncios');
			 $model_autoprog_type='autoprog_'.$array[$foldertodelete[0]->type];
		     $this->load->model($model_autoprog_type);
		     $progs=$this->$model_autoprog_type->count_by(array("folder_id"=>$this->input->post('idFolder'),'user_app'=>$this->flexi_auth->get_user_id()));
		     if($progs==0)
		     {
		     	$this->folders_autoprog->delete_by(array('id'=>$this->input->post('idFolder')));
		     	echo json_encode(array("msg_success"=>'Carpeta eliminada correctamente '));
		     }
		     else
		     {
		     			echo json_encode(array("msg_errors"=>array('p'=>'La carpeta contiene programaciones y no se puede eliminar')));	
		     }


		}
		else
		{
			$this->load->model('programations');
			$progs=$this->programations->count_by(array("folder_id"=>$this->input->post('idFolder'),'user_app'=>$this->flexi_auth->get_user_id()));
			if($progs==0)
			{
				$this->load->model('folders_programations');
				$this->folders_programations->delete_by(array('id'=>$this->input->post('idFolder')));
					echo json_encode(array("msg_success"=>'Carpeta eliminada correctamente '));
			}
			else
			{
						echo json_encode(array("msg_errors"=>array('p'=>'La carpeta contiene programaciones y no se puede eliminar')));
			}	
		}
		

	}
	public function deletecontent()
	{
		$this->load->model('social_user_accounts');
		$this->load->model('social_users');
		
		if($this->input->get("is_folder")=="true"){
			//var_dump($this->input->get("is_user"));
				
			if($this->input->get("is_user")=="true")
			{
				$numaccount=$this->social_users->count_by(array("folder_id"=>$this->input->get("id"),'user_app'=>$this->flexi_auth->get_user_id()));

			}
			else	
			{
				$numaccount=$this->social_user_accounts->count_by(array("folder_id"=>$this->input->get("id"),'user_app'=>$this->flexi_auth->get_user_id()));
			}
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
		{	if($this->input->get('askHaveProg'))
			{
				if($this->Ondeletehaveprog($this->input->get('id'),$this->input->get("is_user")))
				{
					echo json_encode(array('haveProg'=>true));
					exit;
				}
			}
			$this->load->model('programations');
			$this->load->model('autoprog_basededatos');
			$this->load->model('autoprog_anuncios');
			if($this->input->get("is_user")=="true")
			{
					$acc=$this->social_users->getUserAppUsers(array('id'=>$this->input->get("id")));
					$this->programations->delete_by(array('socialaccount'=>$acc[0]->user_id,'user_app'=>$this->flexi_auth->get_user_id()));
					$this->autoprog_basededatos->delete_by(array('accountid'=>$acc[0]->user_id,'user_app'=>$this->flexi_auth->get_user_id()));
					$this->autoprog_anuncios->delete_by(array('accountid'=>$acc[0]->user_id,'user_app'=>$this->flexi_auth->get_user_id()));
					
					$this->social_users->delete_by(array("id"=>$this->input->get("id"),'user_app'=>$this->flexi_auth->get_user_id()));
					
					echo json_encode(array("result"=>"ok","msg_success"=>'Datos eliminados correctamente'));
			}
			else
			{		$acc=$this->social_user_accounts->getUserappAccounts(array('id'=>$this->input->get('id')));
					$this->programations->delete_by(array('socialaccount'=>$acc[0]->idaccount,'user_app'=>$this->flexi_auth->get_user_id()));
					$this->autoprog_basededatos->delete_by(array('accountid'=>$acc[0]->idaccount,'user_app'=>$this->flexi_auth->get_user_id()));

					$this->autoprog_anuncios->delete_by(array('accountid'=>$acc[0]->idaccount,'user_app'=>$this->flexi_auth->get_user_id()));
				
					$this->social_user_accounts->delete_by(array("id"=>$this->input->get("id"),'user_app'=>$this->flexi_auth->get_user_id()));	
					echo json_encode(array("result"=>"ok","msg_success"=>'Datos eliminados correctamente '));
			}

		}
	}
	
	public function deleteQuitFolderContent()
	{
		$this->load->model('social_user_accounts');
		$this->load->model("social_users");
		if($this->input->get("is_user")=="true")
			$rows=$this->social_users->get_many_by(array("folder_id"=>$this->input->get("id"),'user_app'=>$this->flexi_auth->get_user_id()));
		else
		$rows=$this->social_user_accounts->get_many_by(array("folder_id"=>$this->input->get("id"),'user_app'=>$this->flexi_auth->get_user_id()));

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
			echo json_encode(array("result"=>"ok","msg_success"=>'Cambios aplicados correctamente '));
		}
		else
		{	
			if($this->input->get('askHaveProg'))
			{
				foreach ($rows as $account) 
				{
					if($this->Ondeletehaveprog($account->id,$this->input->get("is_user")))
					{
						echo json_encode(array('haveProg'=>true));
						exit;
					}
				}	
			}
			$this->load->model('programations');
			$this->load->model('autoprog_basededatos');
			$this->load->model('autoprog_anuncios');

			foreach ($rows as  $value) 
			{
				if($this->input->get("is_user")=="true")
				{	
					$acc=$this->social_users->getUserAppUsers(array('id'=>$value->id),1);
					$this->programations->delete_by(array('socialaccount'=>$acc[0]->user_id,'user_app'=>$this->flexi_auth->get_user_id()));
					$this->autoprog_basededatos->delete_by(array('accountid'=>$acc[0]->user_id,'user_app'=>$this->flexi_auth->get_user_id()));
					$this->autoprog_anuncios->delete_by(array('accountid'=>$acc[0]->user_id,'user_app'=>$this->flexi_auth->get_user_id()));
					$this->social_users->delete_by(array("id"=>$value->id,'user_app'=>$this->flexi_auth->get_user_id()));
				}
				else	
				{
					$acc=$this->social_user_accounts->getUserappAccounts(array('id'=>$value->id),1);
					$this->programations->delete_by(array('socialaccount'=>$acc[0]->idaccount,'user_app'=>$this->flexi_auth->get_user_id()));
					$this->autoprog_basededatos->delete_by(array('accountid'=>$acc[0]->idaccount,'user_app'=>$this->flexi_auth->get_user_id()));
					$this->autoprog_anuncios->delete_by(array('accountid'=>$acc[0]->idaccount,'user_app'=>$this->flexi_auth->get_user_id()));
					$this->social_user_accounts->delete_by(array("id"=>$value->id,'user_app'=>$this->flexi_auth->get_user_id()));
				}
			}
			echo json_encode(array("result"=>"ok","msg_success"=>'Cambios aplicados correctamente '));
		}
		$this->load->model("folders");
		$this->folders->delete_by(array("id"=>$this->input->get("id"),'user_app'=>$this->flexi_auth->get_user_id()));

		
	}
	// agafa els elements duna base de dades i els mostra
	public function get_bbddElements($page=0)
	{
		if($this->input->post('id'))
		{
			$config=$this->load->config("pagination");
			$config["base_url"] = base_url() . "panel/commonsocial/get_bbddElements";
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
		else
		echo json_encode(array('notada'=>1));
	}
	// agafa els elements d'una base de dades anuncis
	public function get_anuncisElements($page=0)
	{
		if($this->input->post('id'))
		{
			$config=$this->load->config("pagination");
			$config["base_url"] = base_url() . "panel/commonsocial/get_anuncisElements";
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
		else
		echo json_encode(array('notada'=>1));
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
	public function changeProgFolder()
	{
		if($this->input->post())
		{
			$prog=$this->input->post('prog');
			$idfolder=$this->input->post('folder');
			$isAutoProg=$this->input->post('isAutoProg');
			if($idfolder=='null')
			{
					$idfolder=NULL;
			}
			if($isAutoProg==='false')
			{
			$this->load->model('programations');

				$this->programations->update_by(array('folder_id'=>$idfolder),array('id'=>$prog,'user_app'=>$this->flexi_auth->get_user_id()));
			}
			else
			{
		      $array=array('bbdd'=>'basededatos','anunci'=>'anuncios');
		      $this->load->model('folders_autoprog');
		      $model_autoprog_type='autoprog_'.$this->input->post('type');
		      $this->load->model($model_autoprog_type);
		      $this->$model_autoprog_type->update_by(array('folder_id'=>$idfolder),array('id'=>$prog,'user_app'=>$this->flexi_auth->get_user_id()));
			}
		}
	}
	public function ver_programacion($idprog=0)
	{
		if($idprog)
		{
			$this->load->model('programations');
			$this->data['prog']=$this->programations->getById($idprog);

			$this->load->view('common/ver_programacion',$this->data);
		}
	}
	public function delete_programation()
	{
		if($this->input->get('id'))
		{
			$this->load->model('programations');
			$this->programations->delete_by(array('id'=>$this->input->get('id')));
			echo json_encode(array("result"=>"ok","msg_success"=>'Programación eliminada correctamente '));
			
		}
	}
	public function checkhours($str)
	{
		if($str['hora_inicio']>=$str['hora_fin'])
		{
			$this->form_validation->set_message('checkhours', 'La hora de inicio debe ser anterior a la hora final');
			return false;
		}
		else
		{
			return true;
		}
	}
	/**
	 * [editar_anuncios editar autoprgramacio d'anuncis associada a id]
	 * @param  [type] $idaccount compte de xarxa social a editar
	 * @param  [type] $type      variable que defineix si el compte dexarxa social es account o user
	 * @param  [type] $id        identificador de  la autoprogramació
	 */
	public function editar_anuncios($idaccount,$type,$id)
	{
		
		$this->load->model('autoprog_anuncios');
		
		$this->load->model('social_users');
		$this->load->model('social_user_accounts');
		$array=array('fb'=>'face',"tw"=>'twt');
			// sagafo el registre del compte de xarxa social
			// si es un usuari
			if($type=='u')
			{
				$acc=$this->social_users->getUserAppUsers(array('user_id'=>$idaccount,'user_app'=>$this->flexi_auth->get_user_id()),1);	
				$acc[0]->type="user";
				
			}
			/// si es una compte
			else
			{ 
				
				$acc=$this->social_user_accounts->getUserAppAccounts(array('idaccount'=>$idaccount,'user_app'=>$this->flexi_auth->get_user_id()),1);
				$acc[0]->type="account";
				// si es un compte de xarxa social segur que es de facebook
				$acc[0]->social_network='fb';
			}	
			//validacions formulari
			$this->form_validation->set_rules('anuncios[frecuencia]','Frecuencia','required');
			$this->form_validation->set_rules('anuncios[socialacc]','Cuentas','callback_checkSelected');
			$this->form_validation->set_rules('anuncios[asociard]','Bases de datos','required');	
			$this->form_validation->set_rules('anuncios', 'Horas de publicación', 'callback_checkhours');

		if($this->input->post())
		{
			//si el formulari es valid
			if($this->form_validation->run()==TRUE)
			{


			$anuncios=$this->input->post("anuncios");
				// si ha omplert el camp per permetre que un element es publiqui repetidament 
				if(isset($anuncios['repetir']))
				{
					
					/// agafo la base de dades seleccionada
					$this->load->library('form_validation_global');
					$this->form_validation_global->validateSaveAutoProg($anuncios['asociard'],'anuncios',$this->flexi_auth->get_user_id());

					
				}
				//si no han omplert el camp pk un element es publiqui repetidament 
				else
				{
					//elimino  lespubllicacions fetes  d'aquella base de ddaes.
						$bbdd=$this->anuncios_model->getById($anuncios['asociard']);
						$this->load->model('autoprog_publicadas');
						$this->autoprog_publicadas->delete_by(array(
							'user_app'=>$this->flexi_auth->get_user_id(),
							'bd_id'=>$bbdd[0]->id,
							'content'=>$bbdd[0]->content,
							'type_bd'=>'anuncios',
							'account_id'=>$idaccount,
							'autoprog_id'=>$id));
							
				}
				// actualitzo les dades de la autoprogramacio
			$this->autoprog_anuncios->update_by(array(
				'ids'=>$anuncios['asociard'],
				'date'=>time(),
				'frequency'=>$anuncios['frecuencia'],
				'repeat'=>(isset($anuncios['repetir'])?1:0),
				'frequency_erase'=>(isset($anuncios['frecuencia_borrado'])?$anuncios['frecuencia_borrado']:0),
				'time_start'=>$anuncios['hora_inicio'],
				"weekdays"=>(isset($anuncios['diasp'])?json_encode($anuncios['diasp']):'[]'),
				'time_end'=>$anuncios['hora_fin'],
				'perm_sentences'=>$anuncios['frases_perm']),array('accountid'=>$idaccount,'type'=>$acc[0]->type,'user_app'=>$this->flexi_auth->get_user_id()));
				echo json_encode(array('msg_success'=>'Datos guardados correctamente'));
			}
			else
			{
				// si el formulari no es valid mostro els errors
    			    $errors = $this->form_validation->error_array();
                   echo json_encode(array('msg_errors'=>$errors)); 
			}
			exit;
		}
		
		$this->data['url']=base_url(uri_string());
		//agafo les bases de dades d'anuncis
		$this->data['anuncios']=$this->anuncios_model->getAllWithAdmin(array('socialnetwork'=>$array[$acc[0]->social_network],'user_app'=>$this->flexi_auth->get_user_id()),array('is_admin'=>1,'socialnetwork'=>$array[$acc[0]->social_network]));
		$this->data['accountedit']=$acc[0];
		// agafo les dades de la programacio a editar
		$autoproganuncis=$this->autoprog_anuncios->get_many_by(array('accountid'=>$idaccount,'type'=>$acc[0]->type,'id'=>$id));
		
		$this->data['conf_anunci']=$autoproganuncis[0];
		$this->load->view('common/editar_account_anuncis',$this->data);
	}
	/**
	 * [editar_basesdedatos editar les dades duna autopgrogramacio de base de dades asociada a id]
	 * @param  [type] $idaccount compte de xarxa social a editar
	 * @param  [type] $type      variable que defineix si el compte dexarxa social es account o user
	 * @param  [type] $id        identificador de  la autoprogramació
	 
	 */
	public function editar_basesdedatos($idaccount,$type,$id)
	{
		
		
		$this->load->model('autoprog_basededatos');
		$this->load->model('social_users');
		$this->load->model('social_user_accounts');
		$array=array('fb'=>'face',"tw"=>'twt');
			if($type=='u')
			{
				$acc=$this->social_users->getUserAppUsers(array('user_id'=>$idaccount,'user_app'=>$this->flexi_auth->get_user_id()),1);	
				$acc[0]->type="user";
				
			}
			else
			{ 
				
				$acc=$this->social_user_accounts->getUserAppAccounts(array('idaccount'=>$idaccount,'user_app'=>$this->flexi_auth->get_user_id()),1);
				$acc[0]->type="account";
				$acc[0]->social_network='fb';
			}	
			// validacions per  formulari
			$this->form_validation->set_rules('datos[frecuencia]','Frecuencia','required');
			$this->form_validation->set_rules('datos[socialacc]','Cuentas','callback_checkSelected');
			$this->form_validation->set_rules('datos[asociard][]','Bases de datos','required');
			$this->form_validation->set_rules('datos', 'Horas de publicación', 'callback_checkhours');
			
			// si arriba peticio post
		if($this->input->post())
		{
			//si el formulari es valid
			if($this->form_validation->run()==TRUE)
			{

				$datos=$this->input->post('datos');
				// si  el checkbox per permetre publicacions repetides repeticons 
				if(isset($datos['repetir']))
				{
					$this->load->library('form_validation_global');
					$this->form_validation_global->validateSaveAutoProg($datos['asociard'],'datos',$this->flexi_auth->get_user_id());
				}
				else
				{
					// sino han omplert el checkbox de publicacions repetides
					// esborro totes les publicacions fetes per  la compte
					foreach ($datos['asociard'] as $value) {
						$bbdd=$this->bases_datos_model->getById($value);
						$this->load->model('autoprog_publicadas');
						$this->autoprog_publicadas->delete_by(array(
							'user_app'=>$this->flexi_auth->get_user_id(),
							'bd_id'=>$bbdd[0]->id,
							'content'=>$bbdd[0]->content,
							'type_bd'=>'datos',
							'account_id'=>$idaccount,
							'autoprog_id'=>$id));
					}
					
				}
			
			// actualitzo les dades de la autoprogramacio
			$this->autoprog_basededatos->update_by(array(
				'ids'=>(isset($datos['asociard'])?json_encode($datos['asociard']):'[]'),
				'repeat'=>(isset($datos['repetir'])?1:0),
				'frequency'=>$datos['frecuencia'],
				'date'=>time(),
				'time_start'=>$datos['hora_inicio'],
				'time_end'=>$datos['hora_fin'],
				"weekdays"=>(isset($datos['diasp'])?json_encode($datos['diasp']):'[]'),
				'perm_sentences'=>$datos['frases_perm']),array('accountid'=>$idaccount,'type'=>$acc[0]->type,'user_app'=>$this->flexi_auth->get_user_id()));
			echo json_encode(array('msg_success'=>'Datos guardados correctamente'));

			}
			else
			{
				//si el formulari no es valid mostro els errors
    			    $errors = $this->form_validation->error_array();
                   echo json_encode(array('msg_errors'=>$errors)); 
			}
			exit;
		}
		
		$this->data['url']=base_url(uri_string());
		// agafo les bases de dades de usuari i de administrador
		$this->data['basesdedatos']=$this->bases_datos_model->getAllWithAdmin(array('socialnetwork'=>$array[$acc[0]->social_network],'user_app'=>$this->flexi_auth->get_user_id()),array('is_admin'=>1,'socialnetwork'=>$array[$acc[0]->social_network]));
		
		$this->data['accountedit']=$acc[0];
		// agafo les dades de la autoprogramacio a editar
		$autoprog=$this->autoprog_basededatos->get_many_by(array('accountid'=>$idaccount,'type'=>$acc[0]->type,'id'=>$id));
		
		$this->data['conf_bbdd']=$autoprog[0];
		
		$this->load->view('common/editar_account_basesdedades',$this->data);
	}
	/**
	 * [deleteAutoProg permet eliminar una autoprogramacio]
	 * @return [type] [description]
	 */
	public function deleteAutoProg() 
	{
		if($this->input->post("type"))
		{
			$type=$this->input->post("type");
			$account=$this->input->post("account");
			$prog=$this->input->post("prog");
			$this->load->model('autoprog_basededatos');
			$this->load->model('autoprog_anuncios');
			$this->load->model('autoprog_publicadas');
			// si es de tipus anunci
			if($type=="anuncios")
			{
				$flag=$this->autoprog_anuncios->delete_by(array('accountid'=>$account,"id"=>$prog));
			}
			//si es de base de dades
			else
			{
				$flag=$this->autoprog_basededatos->delete_by(array('accountid'=>$account,"id"=>$prog));
			}
			// elimino les publicacions fetes per la compte de l'autoprogramacio
			$this->autoprog_publicadas->delete_by(array('user_app'=>$this->flexi_auth->get_user_id(),'account_id'=>$account,'autoprog_id'=>$prog));
			if($flag)
				echo json_encode(array('msg_success'=>'Datos eliminados correctamente'));
			else
				echo json_encode(array('msg_errors'=>array('errors'=>'Error al eliminar los datos')));
		}
	}
	public function createFolderProg($social_network,$isauto,$type=null)
	{
		if($this->input->post())
		{
			$this->form_validation->set_rules('name', 'Nombre', 'required');
			$array=array('fb'=>'facebook',"tw"=>'twitter');
			
			if($this->form_validation->run()==TRUE)
			{
				if($isauto!="auto")
				{	
					$this->load->model("folders_programations");
					$arr=array(
					"name"=>$this->input->post("name"),
					
					'user_app'=>$this->flexi_auth->get_user_id(),
					"social_network"=>$social_network
					);
					if($this->folders_programations->insert($arr)){
						//redirect(base_url().'panel/'.$array[$social_network].'/programar_'.$array[$social_network]);
					}
				}	
				else
				{
					$this->load->model("folders_autoprog");
					$arr=array(
					"name"=>$this->input->post("name"),
					
					'user_app'=>$this->flexi_auth->get_user_id(),
					"social_network"=>$social_network,
					'type'=>$type
					);
					if($this->folders_autoprog->insert($arr)){
						//redirect(base_url().'panel/'.$array[$social_network].'/prog_periodicas');
					}
				}
				echo json_encode(array('msg_success'=>'Datos guardados correctamente'));				
			}
			else
			{
				    $errors = $this->form_validation->error_array();
                   echo json_encode(array('msg_errors'=>$errors)); 

			}
			exit;

		
		}
		else
		{
			$this->data['url']=base_url(uri_string());
			
			$this->load->view('common/createFolderAutoProg',$this->data);
		}

	
	}
	public function publishContentErrors()
	{
		$errors=$this->session->userdata('errors');


		$this->load->view('common/PublishErrors');
	}
}

/* End of file commonactions.php */
/* Location: ./application/modules/panel/controllers/commonactions.php */