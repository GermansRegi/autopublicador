<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Basesdedatos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('bases_datos_model');
		
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
		$this->data['username']=$this->flexi_auth->get_user_by_id_query($this->flexi_auth->get_user_id(),array("upro_first_name"))->result();	
	}
	public function index()
	{

		$res=$this->bases_datos_model->get_many_by(array('user_app'=>$this->flexi_auth->get_user_id()));
		$this->data['arbbdd']=$res;
		$this->data['titlepage']="Bases de datos"; 
		$this->load->view('panel/basesdedatos/index',$this->data);

		

	
		
	}
	public function editar($idbd)
	{
		if(!empty($idbd))
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
			
			
				$basededatos=$this->bases_datos_model->getById($idbd);
				
				
                $config["base_url"] = base_url() . "panel/basesdedatos/editar/".$idbd."/";
                $page = (($this->uri->segment(5)===False) ? 0: $this->uri->segment(5));
                
               if($basededatos[0]->content=='image')
			{	
				$config["per_page"] = 20;
				$elements=$this->bases_datos_model->getElements($basededatos[0]->content,array('bbdd_id'=>$idbd),$config['per_page'],$page);   

			}
                
               $elements=$this->bases_datos_model->getElements($basededatos[0]->content,array('bbdd_id'=>$idbd),$config['per_page'],$page);   
               $numElementsTotal=$this->bases_datos_model->countAllElements($basededatos[0]->content,array('bbdd_id'=>$idbd));
               $config['total_rows']=$numElementsTotal;
               $config['uri_segment']=5;
         		$this->pagination->initialize($config);
			
			
			//var_dump($basededatos);
         		$this->data['total']=$numElementsTotal;
			$this->data['bbdd']=$basededatos[0];
			$this->data['elements']=$elements;
			$this->data['link_pager']=$this->pagination->create_links();
			
			if($basededatos[0]->content=='image')
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
	                                $this->bases_datos_model->insertElement('image',array(
	                                	'user_app' => $this->flexi_auth->get_user_id(),
	                                	'bbdd_id' => $idbd,
	                                  	'path' => $file['full_path'], 
	                                  	'filename' => $file['file_name']));
	                                echo json_encode(array('msg_success'=>'Datos guardados con éxito'));
	                        }
	                                            
         				exit;

				}

					$view='panel/basesdedatos/edit_images_basedatos';
			}
			else if($basededatos[0]->content=='sentence')
			{
				if($this->input->post('bbdd_alta'))
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
		                	
			            //    	$records = preg_split('/[\r\n]+/', $this->input->post('frase'), -1, PREG_SPLIT_NO_EMPTY);
			              //  	foreach ($records as $frase) {
			                		
			                	$this->bases_datos_model->insertElement('sentence',array(
								'sentence'=>$this->input->post('frase'),
								'bbdd_id'=>$idbd,
								'user_app'=>$this->flexi_auth->get_user_id()));
			                
			                //	}
			                	echo json_encode(array('msg_success'=>'Datos guardados con éxito'));
		                	}

		                
		                }
					exit;
				}
				
				if($basededatos[0]->socialnetwork=='twt')
				{
					$this->data['maxlenght']=140;	
				}

				$view='panel/basesdedatos/edit_sentences_basedatos';
			}
			else
			{
				if($this->input->post('bbdd_alta'))
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
		                	
		                	$this->bases_datos_model->insertElement('link',array(
							'text'=>$this->input->post('text'),
							'link'=>$this->input->post('link'),
							'bbdd_id'=>$idbd,
							'user_app'=>$this->flexi_auth->get_user_id()));
		                		echo json_encode(array('msg_success'=>'Datos guardados con éxito'));
		                	}
		                
		                }
					exit;
				}
			
				$view='panel/basesdedatos/edit_links_basedatos';
			}
			
				$this->data['titlepage']="Bases de datos - Editar base de datos: ".$basededatos[0]->name; 
			$this->load->view($view,$this->data);		
		}
		else 
		{
			
			redirect(base_url().'panel/basesdedatos');
		}
	}
	public function ismaxElementsImages($id)
	{
		if(!empty($id))
		{
			$res=$this->bases_datos_model->countAllElements('image',array('bbdd_id'=>$id));
			
			
			if($res>$this->config->item('max-images'))
			{
				echo json_encode(array('msg_errors'=>array('0'=>'No puedes añadir más imágenes en esta base de datos')));
			     
			
	   		}  
          }
	
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

					
					
					$idcreated=$this->bases_datos_model->insertNew(array(
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
			$this->data['titlepage']='Bases de datos - Crear base de datos';
			$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
			$this->load->view('panel/basesdedatos/crear',$this->data);
			
	}
	public function deleteContent($idbd,$id=null)
	{
		if($this->input->post('delco'))
		{
			$basededatos=$this->bases_datos_model->getById($idbd);

			foreach($this->input->post('delco') as $id)
			{

				if($basededatos[0]->content=='image')
				{
					$this->bases_datos_model->deleteElementImage($id['value']);	
				}
				else
				{
					$this->bases_datos_model->deleteElement($basededatos[0]->content,array('id'=>$id['value']));
				}
			}
			echo json_encode(array('msg_success'=>'Datos borrados con éxito'));
		}
		else
		{
			if(!empty($id) && !empty($idbd))
			{
				$basededatos=$this->bases_datos_model->getById($idbd);
				if($basededatos[0]->content=='image')
				{
					$this->bases_datos_model->deleteElementImage($id);	
				}
				else
				{
					$this->bases_datos_model->deleteElement($basededatos[0]->content,array('id'=>$id));
				}
				echo json_encode(array('msg_success'=>'Datos borrados con éxito'));
			}
		}
	}
	public function delete($bdid)
	{
		
		if(!empty($bdid))
		{
			$this->bases_datos_model->deleteOne($bdid);
			echo json_encode(array('msg_success'=>'Datos borrados con éxito'));
		}
		
	}
	public function updateElement($bbddid)
	{
		if($this->input->post())
		{
			if($this->input->post('content')=='link')
			{
				$data=array('link'=>$this->input->post('text'));
				$this->form_validation->set_rules('text','Enlace','prep_url|valid_url|trim');
				if($this->form_validation->run()==FALSE)
				{
			        $errors = $this->form_validation->error_array();
                   echo json_encode(array('msg_errors'=>$errors));
		           
		           exit;
				}
				$content=$this->input->post('content');
			}
			else if($this->input->post('content')=='sentence')
			{
				$data=array('sentence'=>$this->input->post('text'));
				$content=$this->input->post('content');
			}
			else
			{
				$data=array('text'=>$this->input->post('text'));
				$content='link';
			}
			
				
			
				//$data=array('sentence'=>$this->input->post('text'));
				$this->bases_datos_model->updateElement($content,$data,
				array(
					'bbdd_id'=>$bbddid,
					'id'=>$this->input->post('idelem'),
					'user_app'=>$this->flexi_auth->get_user_id()
					));
				echo json_encode(array('msg_success'=>'Datos actualizados con éxito'));		
		}
	}
}

/* End of file basesdedatos.php */
/* Location: ./application/modules/panel/controllers/basesdedatos.php */