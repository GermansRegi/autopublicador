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
 		$this->load->library('form_validation_global');
 		$this->form_validation_global->validarSession();
  		// IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded!
 		// It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
	}
	public function index()
	{

		$res=$this->anuncios_model->getAll(array('user_app'=>$this->flexi_auth->get_user_id()));
		$this->data['arbbdd']=$res;
		$this->data['titlepage']="Anuncios"; 
		$this->load->view('panel/anuncios/index',$this->data);

	

	
		
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
					    if(!file_exists('upload/'.$this->flexi_auth->get_user_identity()))
	                    {
	                        mkdir('upload/'.$this->flexi_auth->get_user_identity());
	                    }
	                    $config['file_name']=uniqid("WatermarkImage_");
	                    $config['upload_path'] = 'upload/'.$this->flexi_auth->get_user_identity();
	                    $config['allowed_types'] = 'jpg|png';               
	                    $config['max_size'] = '800'; //in KB

	                    $this->load->library('upload', $config);
	                    //sino sha pujat be
	                    if (! $this->upload->do_upload('imagen'))
	                    {
	                        //$upload_error['upload_error'] = array('error' => $this->upload->display_errors()); 
	                        echo json_encode(array('msg_error'=>$this->upload->display_errors()));        

	                    }
	                    else 
	                    {
	                    
					
						            $file=$this->upload->data();
						$idcreated=$this->anuncios_model->insertNew(array(
							'socialnetwork'=>$this->input->post('basededatos_create_social'),
							'content'=>$this->input->post('content'),
							'watermark_image'=>$file['full_path'], 
							'name'=>$this->input->post('basededatos_create_name'),
							'user_app'=>$this->flexi_auth->get_user_id(),
							'is_admin'=>0));
					echo json_encode(array('msg_success'=>'Datos guardados con éxito','idcreated'=>$idcreated));
					}
				}
				else
				{

					$this->data['message'] = $this->form_validation->error_array();	
					echo json_encode(array('msg_errors'=>$this->data['message']));

				}
				
		
			exit;	
		}
			$this->data['titlepage']="Anuncios - Crear base de datos";
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
	                        	$this->load->library('image_lib');
	                            $file=$this->upload->data();
	                            $config = array();
								$config['source_image'] = $file['full_path'];
								$config['image_library'] = 'gd2';
								$config['wm_type'] = 'overlay';
								$config['wm_overlay_path'] = $anuncio[0]->watermark_image;
								$config['wm_vrt_alignment'] = 'middle';
								$config['wm_hor_alignment'] = 'center';
								$this->image_lib->initialize($config);
								$this->image_lib->watermark();
								$this->image_lib->clear();
								
	                                $this->anuncios_model->insertElement('image',array(
	                                	'user_app' => $this->flexi_auth->get_user_id(),
	                                	'bbdd_id' => $idbd,
	                                  	'path' => $file['full_path'], 
	                                  	'filename' => $file['file_name']));
	                                	echo json_encode(array('msg_success'=>'Datos guardados con éxito'));
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
		                		 echo json_encode(array('msg_errors'=>array('errors'=>'no se permites mas ffrases')));
		                	}
		                	else
		                	{
		           //     	$records = preg_split('/[\r\n]+/', $this->input->post('frase'), -1, PREG_SPLIT_NO_EMPTY);
			        //        	foreach ($records as $frase) {
			                	
				                	$this->anuncios_model->insertElement('sentence',array(
									'sentence'=>$this->input->post('frase'),
									'bbdd_id'=>$idbd,
									'user_app'=>$this->flexi_auth->get_user_id()));
				                
			          //      	}

			                	echo json_encode(array('msg_success'=>'Datos guardados con éxito'));
			                }
			                
		                }
					exit;
				}
				if($anuncio[0]->socialnetwork=='twt')
				{
					$this->data['maxlength']=140;	
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
		                		 echo json_encode(array('msg_errors'=>array('errors'=>'no se permites mas ffrases')));
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
			$this->data['titlepage']="Anuncios - Editar base de datos : ".$anuncio[0]->name;
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
				echo json_encode(array('msg_errors'=>array('errors'=>'No puedes añadir más imágenes en esta base de datos')));
			     
			
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
				

				$this->anuncios_model->updateElement($content,$data,
				array(
					'bbdd_id'=>$bbddid,
					'id'=>$this->input->post('idelem'),
					'user_app'=>$this->flexi_auth->get_user_id()
					));
				echo json_encode(array('msg_success'=>'Datos actualizados con éxito'));		
		}
	}
}

/* End of file anuncios.php */
/* Location: ./application/modules/panel/controllers/anuncios.php */