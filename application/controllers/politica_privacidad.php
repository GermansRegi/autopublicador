<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Politica_privacidad extends CI_Controller {
	 function __construct()
    {
        parent::__construct();
        $this->load->helper('url');

	}
	function index()
	{
		$data['titlepage']="Política de privacidad";
		$this->load->view('politica_privacidad',$data);

	}
}