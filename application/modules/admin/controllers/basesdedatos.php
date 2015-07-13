<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Basesdedatos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('bases_datos_model');
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
	public function index()
	{
			
		$res=$this->bases_datos_model->getAll();
		$data['titlepage']="Bases de datos";
		$data['arbbdd']=$res;
		$this->load->view('admin/basesdedatos/index',$data);

		
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
			$this->data['titlepage']="Crear base de datos";
			$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
			$this->load->view('admin/basesdedatos/crear',$this->data);
			
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
				
				
                $config["base_url"] = base_url() . "admin/basesdedatos/editar/".$idbd."/";
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

					$view='admin/basesdedatos/edit_images_basedatos';
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
		           //     	$records = preg_split('/[\r\n]+/', $this->input->post('frase'), -1, PREG_SPLIT_NO_EMPTY);
		             //   	foreach ($records as $frase) {
		                	
			                	$this->bases_datos_model->insertElement('sentence',array(
								'sentence'=>$this->input->post('frase'),
								'bbdd_id'=>$idbd,
								'user_app'=>$this->flexi_auth->get_user_id()));
			                		
			          //      	}
			                	echo json_encode(array('msg_success'=>'Datos guardados con éxito'));
			                }
		                
		                }
					exit;
				}
				if($basededatos[0]->socialnetwork=='twt')
				{
					$this->data['maxlenght']=140;	
				}
				$view='admin/basesdedatos/edit_sentences_basedatos';
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
					
				$view='admin/basesdedatos/edit_links_basedatos';
			}
			$this->data['titlepage']="Editar base de datos: ".$basededatos[0]->name;
			$this->load->view($view,$this->data);		
		}
		else 
		{
			
			redirect(base_url().'admin/basesdedatos');
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

}

/* End of file basesdedatos.php */
/* Location: ./application/modules/panel/controllers/basesdedatos.php */