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

			if ($this->flexi_auth->is_privileged('acces user free'))
			{
				$this->load->vars('privilege_user_app','free');
			}
			else if ($this->flexi_auth->is_privileged('acces user prem'))
			{
				$this->load->vars('privilege_user_pp','prem');
			}
		

		
	}
	public function index()
	{
			
		$res=$this->bases_datos_model->getAll();
		$data['arbbdd']=$res;
		$this->load->view('admin/basesdedatos/index',$data);

		
	}
	public function crear()
	{
		


		if($this->input->post())		

		{
		
			
			$rules_validate=array(
				array('field' => 'basededatos_create_name', 'label' => 'Nombre', 'rules' => 'required'),
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
		
			$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
			$this->load->view('admin/basesdedatos/crear',$this->data);
			
	}
	public function editar($idbd)
	{
		if(isset($idbd))
		{

			//$basededatos=$this->bases_datos_model->getById($idbd);
			//var_dump($basededatos);

		}
		else 
		{
			
			redirect(base_url().'admin/basesdedatos');
		}
	}

}

/* End of file basesdedatos.php */
/* Location: ./application/modules/panel/controllers/basesdedatos.php */