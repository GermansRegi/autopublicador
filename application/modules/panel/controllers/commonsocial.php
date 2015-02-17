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

	
	public function index()
	{
			
	}
	public function cronPublishProgramations()
	{
		
	}

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
		
			$this->load->model('autoprog_basededatos');
			$this->load->model('autoprog_anuncios');	
			if($this->input->get("is_user")=="true")
			{	
				$acc=$this->social_users->getUserAppUsers(array('id'=>$this->input->get("id")),1);
				$this->autoprog_basededatos->delete_by(array('accountid'=>$acc[0]->user_id));
				$this->autoprog_anuncios->delete_by(array('accountid'=>$acc[0]->user_id));
				$this->social_users->delete_by(array("id"=>$this->input->get("id"),'user_app'=>$this->flexi_auth->get_user_id()));
			}
			else	
			{
					$acc=$this->social_user_accounts->getUserappAccounts(array('id'=>$this->input->get("id")),1);
					$this->autoprog_basededatos->delete_by(array('accountid'=>$acc[0]->idaccount));
					$this->autoprog_anuncios->delete_by(array('accountid'=>$acc[0]->idaccount));
				$this->social_user_accounts->delete_by(array("id"=>$this->input->get("id"),'user_app'=>$this->flexi_auth->get_user_id()));
			}
		echo json_encode(array("result"=>"ok","msg_success"=>'Cuenta eliminada correctamente '));
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
			$this->load->model('autoprog_basededatos');
			$this->load->model('autoprog_anuncios');
			foreach ($rows as  $value) {
				if($this->input->get("is_user")=="true")
				{	
					$acc=$this->social_users->getUserAppUsers(array('id'=>$value->id),1);
					$this->autoprog_basededatos->delete_by(array('accountid'=>$acc[0]->user_id));
					$this->autoprog_anuncios->delete_by(array('accountid'=>$acc[0]->user_id));
					$this->social_users->delete_by(array("id"=>$value->id,'user_app'=>$this->flexi_auth->get_user_id()));
				}
				else	
				{
					$acc=$this->social_user_accounts->getUserappAccounts(array('id'=>$value->id),1);
				
					$this->social_user_accounts->delete_by(array("id"=>$value->id,'user_app'=>$this->flexi_auth->get_user_id()));
				}
			}
		}
		$this->load->model("folders");
		$this->folders->delete_by(array("id"=>$this->input->get("id"),'user_app'=>$this->flexi_auth->get_user_id()));
		echo json_encode(array("result"=>"ok","msg_success"=>'Cambios aplicados correctamente '));
	}
	// agafa els elements duna base de dades i els mostra
	public function get_bbddElements($page=0)
	{
		if($this->input->post('id'))
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
		else
		echo json_encode(array('notada'=>1));
	}
	// agafa els elements d'una base de dades anuncis
	public function get_anuncisElements($page=0)
	{
		if($this->input->post('id'))
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
	public function editar_anuncios($idaccount,$type,$id)
	{
		
		$this->load->model('autoprog_anuncios');
		
		$this->load->model('social_users');
		$this->load->model('social_user_accounts');
		$array=array('fb'=>'face',"tw"=>'twt');
			if($type=='u')
			{
				$acc=$this->social_users->getUserAppUsers(array('user_id'=>$idaccount),1);	
				$acc[0]->type="user";
				
			}
			else
			{ 
				
				$acc=$this->social_user_accounts->getUserAppAccounts(array('idaccount'=>$idaccount),1);
				$acc[0]->type="account";
				$acc[0]->social_network='fb';
			}	
			
			$this->form_validation->set_rules('anuncios', 'Horas de publicación', 'callback_checkhours');

		if($this->input->post())
		{
			if($this->form_validation->run()==TRUE)
			{


			$anuncios=$this->input->post("anuncios");
			$this->autoprog_anuncios->update_by(array(
				'ids'=>$anuncios['asociard'],
				'frequency'=>$anuncios['frecuencia'],
				'repeat'=>(isset($datos['repeat'])?$datos['repeat']:0),
				'frequency_erase'=>$anuncios['frecuencia_borrado'],
				'time_start'=>$anuncios['hora_inicio'],
				"weekdays"=>(isset($anuncios['diasp'])?json_encode($anuncios['diasp']):'[]'),
				'time_end'=>$anuncios['hora_fin'],
				'perm_sentences'=>$anuncios['frases_perm']),array('accountid'=>$idaccount,'type'=>$acc[0]->type,'user_app'=>$this->flexi_auth->get_user_id()));
				echo json_encode(array('msg_success'=>'Datos guardados correctamente'));
			}
			else
			{

    			    $errors = $this->form_validation->error_array();
                   echo json_encode(array('msg_errors'=>$errors)); 
			}
			exit;
		}
		
		$this->data['url']=base_url(uri_string());
		
		$this->data['anuncios']=$this->anuncios_model->getAllWithAdmin(array('socialnetwork'=>$array[$acc[0]->social_network],'user_app'=>$this->flexi_auth->get_user_id()));
		$this->data['accountedit']=$acc[0];
		
		$autoproganuncis=$this->autoprog_anuncios->get_many_by(array('accountid'=>$idaccount,'type'=>$acc[0]->type,'id'=>$id));
		
		$this->data['conf_anunci']=$autoproganuncis[0];
		$this->load->view('common/editar_account_anuncis',$this->data);
	}
	public function editar_basesdedatos($idaccount,$type,$id)
	{
		
		
		$this->load->model('autoprog_basededatos');
		$this->load->model('social_users');
		$this->load->model('social_user_accounts');
		$array=array('fb'=>'face',"tw"=>'twt');
			if($type=='u')
			{
				$acc=$this->social_users->getUserAppUsers(array('user_id'=>$idaccount),1);	
				$acc[0]->type="user";
				
			}
			else
			{ 
				
				$acc=$this->social_user_accounts->getUserAppAccounts(array('idaccount'=>$idaccount),1);
				$acc[0]->type="account";
				$acc[0]->social_network='fb';
			}	
			$this->form_validation->set_rules('datos', 'Horas de publicación', 'callback_checkhours');
			

		if($this->input->post())
		{
			if($this->form_validation->run()==TRUE)
			{



			$datos=$this->input->post('datos');
			
			$this->autoprog_basededatos->update_by(array(
				'ids'=>(isset($datos['asociard'])?json_encode($datos['asociard']):'[]'),
				'repeat'=>(isset($datos['repeat'])?$datos['repeat']:0),
				'frequency'=>$datos['frecuencia'],
				'time_start'=>$datos['hora_inicio'],
				'time_end'=>$datos['hora_fin'],
				"weekdays"=>(isset($datos['diasp'])?json_encode($datos['diasp']):'[]'),
				'perm_sentences'=>$datos['frases_perm']),array('accountid'=>$idaccount,'type'=>$acc[0]->type,'user_app'=>$this->flexi_auth->get_user_id()));
			echo json_encode(array('msg_success'=>'Datos guardados correctamente'));

			}
			else
			{

    			    $errors = $this->form_validation->error_array();
                   echo json_encode(array('msg_errors'=>$errors)); 
			}
			exit;
		}
		
		$this->data['url']=base_url(uri_string());
		$this->data['basesdedatos']=$this->bases_datos_model->getAllWithAdmin(array('socialnetwork'=>$array[$acc[0]->social_network],'user_app'=>$this->flexi_auth->get_user_id()));
		
		$this->data['accountedit']=$acc[0];
		$autoprog=$this->autoprog_basededatos->get_many_by(array('accountid'=>$idaccount,'type'=>$acc[0]->type,'id'=>$id));
		
		$this->data['conf_bbdd']=$autoprog[0];
		
		$this->load->view('common/editar_account_basesdedades',$this->data);
	}
	public function deleteAutoProg() 
	{
		if($this->input->post("type"))
		{
			$type=$this->input->post("type");
			$account=$this->input->post("account");
			$prog=$this->input->post("prog");
			$this->load->model('autoprog_basededatos');
			$this->load->model('autoprog_anuncios');
			if($type=="anuncios")
				$flag=$this->autoprog_anuncios->delete_by(array('accountid'=>$account,"id"=>$prog));
			else
				$flag=$this->autoprog_basededatos->delete_by(array('accountid'=>$account,"id"=>$prog));
			if($flag)
			echo json_encode(array('msg_success'=>'Datos eliminados correctamente'));
			else
				echo json_encode(array('msg_errors'=>array('pp'=>'Error al eliminar los datos')));
		}
	}
}

/* End of file commonactions.php */
/* Location: ./application/modules/panel/controllers/commonactions.php */