<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Basesdedatos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('basesdedatos_model');
		
		
	}
	public function index()
	{
		echo "pp";
		

		$res=$this->basesdedatos_model->getAll();
		var_dump($res);
	}

}

/* End of file basesdedatos.php */
/* Location: ./application/modules/panel/controllers/basesdedatos.php */