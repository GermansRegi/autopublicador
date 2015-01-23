<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anuncios extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('anuncios_model');
		
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
			else if( uri_string()=='panel')
			{

				redirect(base_url().'panel/basesdedatos');

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
		}else
		{
			redirect(base_url().'panel');
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

		$res=$this->anuncios_model->getAll(array('user_app'=>$this->flexi_auth->get_user_id()));
		$data['arbbdd']=$res;
		$data['titlepage']="Anuncios"; 
		$this->load->view('panel/anuncios/index',$data);

		

	
		
	}
	public function crear()
	{
		


		if($this->input->post())		

		{
		
			
			$rules_validate=array(
				array('field' => 'basededatos_create_name', 'label' => 'Nombre', 'rules' => 'required|trim'),
				array('field' => 'content', 'label' => 'Tipo', 'rules' => 'required'),
				array('field' => 'basededatos_create_social', 'label' => 'Red social', 'rules' => 'required')
				);



				$this->form_validation->set_rules($rules_validate);

				if($this->form_validation->run()==TRUE)
				{

					
					
					$idcreated=$this->anuncios_model->insertNew(array(
						'socialnetwork'=>$this->input->post('basededatos_create_social'),
						'content'=>$this->input->post('content'),
						'name'=>$this->input->post('basededatos_create_name'),
						'user_app'=>$this->flexi_auth->get_user_id(),
						'is_admin'=>0));
					echo json_encode(array('msg_success'=>'Datos guardados con éxito','idcreated'=>$idcreated));
				}
				else
				{

					$this->data['message'] = $this->form_validation->error_array();	
					echo json_encode(array('msg_errors'=>$this->data['message']));

				}
				
		
			exit;	
		}
			$this->data['titlepage']="Crear base de datos de anuncios";
			$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
			$this->load->view('panel/anuncios/crear',$this->data);
			
	}
	public function editar($idbd)
	{
		if(isset($idbd) && $idbd!='')
		{

   			$this->load->library("pagination");
                $config = array();
                $config["per_page"] = 5;
                $config['full_tag_open']='<div> <ul class="pagination pagination-small pagination-centered">';
                $config['full_tag_close']="</ul></div>";
                $config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tag_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tag_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tag_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tag_close'] = "</li>";
			   $config['prev_link'] = '&lt; Prev';
		    $config['prev_tag_open'] = '<li>';
		    $config['prev_tag_close'] = '</li>';
		    $config['next_link'] = 'Next &gt;';
		    $config['next_tag_open'] = '<li>';
		    $config['next_tag_close'] = '</li>';
			$config['num_links']=2;
			
			
				$anuncio=$this->anuncios_model->getById($idbd);
				
			
                $config["base_url"] = base_url() . "panel/anuncios/editar/".$idbd."/";
                $page = (($this->uri->segment(5)===False) ? 0: $this->uri->segment(5));
                
               if($anuncio[0]->content=='image')
			{	
				$config["per_page"] = 20;
				$elements=$this->anuncios_model->getElements($anuncio[0]->content,array('bbdd_id'=>$idbd),$config['per_page'],$page);   

			}
                
               $elements=$this->anuncios_model->getElements($anuncio[0]->content,array('bbdd_id'=>$idbd),$config['per_page'],$page);   
               $numElementsTotal=$this->anuncios_model->countAllElements($anuncio[0]->content,array('bbdd_id'=>$idbd));
               $config['total_rows']=$numElementsTotal;
               $config['uri_segment']=5;
         		$this->pagination->initialize($config);
			
			
			//var_dump($anuncio);
         		$this->data['total']=$numElementsTotal;
			$this->data['anuncio']=$anuncio[0];
			$this->data['elements']=$elements;
			$this->data['link_pager']=$this->pagination->create_links();
			
			if($anuncio[0]->content=='image')
			{	
				if($this->input->post('name'))
				{
			           

	                       if(!file_exists('upload/'.$this->flexi_auth->get_user_identity()))
		                    {
		                        mkdir('upload/'.$this->flexi_auth->get_user_identity());
		                    }
	                        $config['file_name']=uniqid("Image_");
	                        $config['upload_path'] = 'upload/'.$this->flexi_auth->get_user_identity();
	                        $config['allowed_types'] = 'jpg|png';               
	                        $config['max_size'] = '800'; //in KB

	                        $this->load->library('upload', $config);
	                        //sino sha pujat be
	                        if (! $this->upload->do_upload('file'))
	                        {
	                            //$upload_error['upload_error'] = array('error' => $this->upload->display_errors()); 
	                            echo json_encode(array('msg_error'=>$this->upload->display_errors()));        

	                        }
	                        else 
	                        {
	                            $file=$this->upload->data();
	                                $this->anuncios_model->insertElement('image',array(
	                                	'user_app' => $this->flexi_auth->get_user_id(),
	                                	'bbdd_id' => $idbd,
	                                  	'path' => $file['full_path'], 
	                                  	'filename' => $file['file_name']));
	                        }
	                                            
         				exit;

				}

					$view='panel/anuncios/edit_images';
			}
			else if($anuncio[0]->content=='sentence')
			{
				if($this->input->post('anuncio_alta'))
				{
					$this->form_validation->set_rules('frase','Frase','required|trim');
                
		                if($this->form_validation->run()==False)
		                {
		                    $errors = $this->form_validation->error_array();
		                     echo json_encode(array('msg_errors'=>$errors));
		           
		                }
		                else 
		                {
		                	//si sha arribat al max delements permesos
		                	
		                	if(count($numElementsTotal)>$this->config->item('max-no-images'))
		                	{
		                		 echo json_encode(array('msg_errors'=>array('0'=>'no se permites mas ffrases')));
		                	}
		                	else
		                	{
		                	
		                	$this->anuncios_model->insertElement('sentence',array(
							'sentence'=>$this->input->post('frase'),
							'bbdd_id'=>$idbd,
							'user_app'=>$this->flexi_auth->get_user_id()));
		                		echo json_encode(array('msg_success'=>'Datos guardados con éxito'));
		                	}
		                
		                }
					exit;
				}
				$view='panel/anuncios/edit_sentences';
			}
			else
			{
				if($this->input->post('anuncio_alta'))
				{
					$this->form_validation->set_rules('text','Texto','required|trim');
					$this->form_validation->set_rules('link','Enlace','required|prep_url|valid_url|trim');
                
		                if($this->form_validation->run()==False)
		                {
		                    $errors = $this->form_validation->error_array();
		                     echo json_encode(array('msg_errors'=>$errors));
		           
		                }
		                else 
		                {
		                	//si sha arribat al max delements permesos
		                	
		                	if(count($numElementsTotal)>$this->config->item('max-no-images'))
		                	{
		                		 echo json_encode(array('msg_errors'=>array('0'=>'no se permites mas ffrases')));
		                	}
		                	else
		                	{
		                	
		                	$this->anuncios_model->insertElement('link',array(
							'text'=>$this->input->post('text'),
							'link'=>$this->input->post('link'),
							'bbdd_id'=>$idbd,
							'user_app'=>$this->flexi_auth->get_user_id()));
		                		echo json_encode(array('msg_success'=>'Datos guardados con éxito'));
		                	}
		                
		                }
					exit;
				}
					
				$view='panel/anuncios/edit_links';
			}
			$this->data['titlepage']="Editar base de datos de anuncios: ".$anuncio[0]->name;
			$this->load->view($view,$this->data);		
		}
		else 
		{
			
			redirect(base_url().'admin/anuncios');
		}
	}
	public function ismaxElementsImages($id)
	{
		if(isset($id) && $id!='')
		{
	
		$res=$this->anuncios_model->countAllElements('image',array('bbdd_id'=>$id));
			if($res>$this->config->item('max-images'))
			{
				echo json_encode(array('msg_errors'=>array('0'=>'No puedes añadir más imágenes en esta base de datos')));
			     
			
	   		}
   		}  
          
	
	}
	
	public function deleteContent($idbd,$id=null)
	{
		if($this->input->post('delco'))
		{
			$anuncio=$this->anuncios_model->getById($idbd);

			foreach($this->input->post('delco') as $id)
			{

				if($anuncio[0]->content=='image')
				{
					$this->anuncios_model->deleteElementImage($id['value']);	
				}
				else
				{
					$this->anuncios_model->deleteElement($anuncio[0]->content,array('id'=>$id['value']));
				}
			}
			echo json_encode(array('msg_success'=>'Datos borrados con éxito'));
		}
		else
		{
			if(isset($id) && isset($idbd) && $id!=''  && $idbd!='')
			{
				$anuncio=$this->anuncios_model->getById($idbd);
				if($anuncio[0]->content=='image')
				{
					$this->anuncios_model->deleteElementImage($id);	
				}
				else
				{
					$this->anuncios_model->deleteElement($anuncio[0]->content,array('id'=>$id));
				}
				echo json_encode(array('msg_success'=>'Datos borrados con éxito'));
			}
		}
	}
	public function delete($bdid)
	{
		
		if(isset($bdid) && $bdid!='')
		{
			$this->anuncios_model->deleteOne($bdid);
			echo json_encode(array('msg_success'=>'Datos borrados con éxito'));
		}
		
	}

}

/* End of file anuncios.php */
/* Location: ./application/modules/panel/controllers/anuncios.php */