<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anuncios extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('anuncios_model');
				// Load 'standard' flexi auth library by default.
		$this->auth = new stdClass;
		$this->load->library('flexi_auth');
		$this->load->library('form_validation');

     	// Redirect users logged in via password (However, not 'Remember me' users, as they may wish to login properly).
	
		$this->data=array();
		// Check user is logged in as an admin.
		// For security, admin users should always sign in via Password rather than 'Remember me'.
		if (! $this->flexi_auth->is_logged_in_via_password() || ! $this->flexi_auth->is_admin())
		{
			// Set a custom error message.
			$this->flexi_auth->set_error_message('You must login as an admin to access this area.', TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('panel');
		}		
			$this->load->vars('section_app','admin');	

		$this->data=null;
	}
	//llistar totes les basesde dades anuncis DE TOTS ELS USUARIS
	public function index()
	{
			
		$res=$this->anuncios_model->getAll();
		$data['titlepage']="Anuncios";
		$data['arbbdd']=$res;
		$this->load->view('admin/anuncios/index',$data);

		
	}
	//CREAR BASE DE DADES ANUNCIS
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
				//SI EL FORUMUALRI ES CORRRECTE
				if($this->form_validation->run()==TRUE)
				{

					
					//INSERTO L'ANUNCI
					$idcreated=$this->anuncios_model->insertNew(array(
						'socialnetwork'=>$this->input->post('basededatos_create_social'),
						'content'=>$this->input->post('content'),
						'name'=>$this->input->post('basededatos_create_name'),
						'user_app'=>$this->flexi_auth->get_user_id(),
						'is_admin'=>1));
					echo json_encode(array('msg_success'=>'Datos guardados con éxito','idcreated'=>$idcreated));
				}
				else
				{

					$this->data['message'] = $this->form_validation->error_array();	
					echo json_encode(array('msg_errors'=>$this->data['message']));

				}
				
		
			exit;	
		}
			//TITOL DE LA PAGINA
		$this->data['titlepage']="Crear base de datos de anuncios";
			$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
			$this->load->view('admin/anuncios/crear',$this->data);
			
	}
	//EDITAR UN ANUNCI 
	public function editar($idbd)
	{
		//SI MARRIBEN EL PARAMETR
		if(isset($idbd) && $idbd!='')
		{
			//CONFIGURACIO DE PAGINACIO
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
			
				//AGAFO L'ANUNCI A EDITAR
				$anuncio=$this->anuncios_model->getById($idbd);
				
			//CONFIG PAGICACIO
                $config["base_url"] = base_url() . "admin/anuncios/editar/".$idbd."/";
                $page = (($this->uri->segment(5)===False) ? 0: $this->uri->segment(5));
                // SI L'ANUNCI ES DIMATGES LA PAGINACIO ES FA CADA 20 IMATGES
               if($anuncio[0]->content=='image')
			{	
				$config["per_page"] = 20;
				$elements=$this->anuncios_model->getElements($anuncio[0]->content,array('bbdd_id'=>$idbd),$config['per_page'],$page);   

			}
                //AGAFO ELS ANUNCIS
               $elements=$this->anuncios_model->getElements($anuncio[0]->content,array('bbdd_id'=>$idbd),$config['per_page'],$page);   
               //CONTO EL TOTAL D'ANUNCIS
               $numElementsTotal=$this->anuncios_model->countAllElements($anuncio[0]->content,array('bbdd_id'=>$idbd));
               $config['total_rows']=$numElementsTotal;
               $config['uri_segment']=5;
         		$this->pagination->initialize($config);
			
			//OMPLO LES VARIABLES PER LA VISTA
			//var_dump($anuncio);
         		$this->data['total']=$numElementsTotal;
			$this->data['anuncio']=$anuncio[0];
			$this->data['elements']=$elements;
			$this->data['link_pager']=$this->pagination->create_links();
			//SI L'ANUNCI ES DIMATGES
			if($anuncio[0]->content=='image')
			{	//SI MARRIBA UNA PETICIO POST
				if($this->input->post('name'))
				{
			           
						//COFIGURACIO PER A PUJADA DE FITXER
	                        $config['file_name']=uniqid("Image_");
	                        $config['upload_path'] = 'upload/';
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
	                        		//guardo la imatge a bd
	                            $file=$this->upload->data();
	                                $this->anuncios_model->insertElement('image',array(
	                                	'user_app' => $this->flexi_auth->get_user_id(),
	                                	'bbdd_id' => $idbd,
	                                  	'path' => $file['full_path'], 
	                                  	'filename' => $file['file_name']));
	                                echo json_encode(array('msg_success'=>'Datos guardados con éxito'));
	                        }
	                                            
         				exit;

				}
					// poso la vista per edicio d'imatges
					$view='admin/anuncios/edit_images';
			}//si lanunci es de frases
			else if($anuncio[0]->content=='sentence')
			{
				//si marriba una peticio post
				if($this->input->post('anuncio_alta'))
				{

					$this->form_validation->set_rules('frase','Frase','required|trim');
                		//si el formulari no es valid
		                if($this->form_validation->run()==False)
		                {
		                	//n mostro error
		                    $errors = $this->form_validation->error_array();
		                     echo json_encode(array('msg_errors'=>$errors));
		           
		                }
		                else 
		                {
		                	//si sha arribat al max delements permesos
		                	
		                	if(count($numElementsTotal)>$this->config->item('max-no-images'))
		                	{
		                			// mostro error
		                		 echo json_encode(array('msg_errors'=>array('errors'=>'no se permites mas ffrases')));
		                	}
		                	else
		                	{
		                	//inserto la frase a bd
		                	//	$records = preg_split('/[\r\n]+/', $this->input->post('frase'), -1, PREG_SPLIT_NO_EMPTY);
			                //	foreach ($records as $frase) {
			                	
				                	$this->anuncios_model->insertElement('sentence',array(
									'sentence'=>$this->input->post('frase'),
									'bbdd_id'=>$idbd,
									'user_app'=>$this->flexi_auth->get_user_id()));
				                		
			                //	}
			                	echo json_encode(array('msg_success'=>'Datos guardados con éxito'));
		                	}
		                }
					exit;
				}
				if($anuncio[0]->socialnetwork=='twt')
				{
					$this->data['maxlenght']=140;	
				}
			
				// poso la vista per edicio de frases
				$view='admin/anuncios/edit_sentences';
			} 
			else
			{
				// si marriba peticio post
				if($this->input->post('anuncio_alta'))
				{

					$this->form_validation->set_rules('text','Texto','required|trim');
					$this->form_validation->set_rules('link','Enlace','required|prep_url|valid_url|trim');
                		// si la validacio del formulari es incorrecte
		                if($this->form_validation->run()==False)
		                {
		                	//mostro errror
		                    $errors = $this->form_validation->error_array();
		                     echo json_encode(array('msg_errors'=>$errors));
		           
		                }
		                else 
		                {
		                	//si sha arribat al max delements permesos
		                	
		                	if(count($numElementsTotal)>$this->config->item('max-no-images'))
		                	{
		                		// mostro error
		                		 echo json_encode(array('msg_errors'=>array('errors'=>'no se permites mas ffrases')));
		                	}
		                	else
		                	{
		                		//inserto el link a bd
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
				/// poso la vista per edicio de links
				$view='admin/anuncios/edit_links';
			}
			// poso el titol de la pagina 
			$this->data['titlepage']="Editar base de datos de anuncios: ".$anuncio[0]->name;
			// mostro la vista
			$this->load->view($view,$this->data);		
		}
		else 
		{
			
			redirect(base_url().'admin/anuncios');
		}
	}
	// accio per limitar el numero dimatges duna bd 
	public function ismaxElementsImages($id)
	{
		if(isset($id) && $id!='')
		{
	
		$res=$this->anuncios_model->countAllElements('image',array('bbdd_id'=>$id));
			// si el numero dimatges es mes gran que el permes
			if($res>$this->config->item('max-images'))
			{
				// mostro error
				echo json_encode(array('msg_errors'=>array('errors'=>'No puedes añadir más imágenes en esta base de datos')));
			     
			
	   		}
   		}  
          
	
	}
	// accio per eliminar un element de anuncis
	public function deleteContent($idbd,$id=null)
	{
		if(isset($id) && isset($idbd) && $id!=''  && $idbd!='')
		{
			// agafo l'anunci al que pertanyen els elements
			$anuncio=$this->anuncios_model->getById($idbd);
			// si marriva peticio post ( varis elemennts a eliminar)
			if($this->input->post('delco'))
			{
				
	
				// per cada element a eliminar
				foreach($this->input->post('delco') as $id)
				{
					// si lanunci es dimatges 
					if($anuncio[0]->content=='image')
					{
						// esborro la imatge fisica i lelement de lanunci
						$this->anuncios_model->deleteElementImage($id['value']);	
					}
					else
					{
						// esborro l'element de l'anunci
						$this->anuncios_model->deleteElement($anuncio[0]->content,array('id'=>$id['value']));
					}
				}
				echo json_encode(array('msg_success'=>'Datos borrados con éxito'));
			}
			// si marriba una peticio get
			else
			{
				

				// si l'anunci es dimatges 
				if($anuncio[0]->content=='image')
				{
					// esborro la imatge fisica i lelement de lanunci
					$this->anuncios_model->deleteElementImage($id);	
				}
				else
				{
					// esborro l'element de l'anunci
					$this->anuncios_model->deleteElement($anuncio[0]->content,array('id'=>$id));
				}
				echo json_encode(array('msg_success'=>'Datos borrados con éxito'));
			
			}
		}
	}
	// accio que permet esborra una base de dades d'anuncis i els seus elements
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
/* Location: ./application/modules/admin/controllers/anuncios.php */