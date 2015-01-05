<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller {
	 function __construct()
    {
        parent::__construct();
        $this->load->helper('url');

	}
	function index()
	{
		$data['titlepage']="Bienvenido al Autopublicador Social";
		$this->load->view('inicio',$data);

	}
}