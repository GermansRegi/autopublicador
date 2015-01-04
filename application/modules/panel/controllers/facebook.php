<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebook extends CI_Controller {


	public function index()
	{
		
	}
	public function connectar_facebook()
	{
		echo APPPATH;
		$this->load->library('Facebooklib','','fblib');
		echo $this->fblib->login_url();
	}
}

/* End of file facebook.php */
/* Location: ./application/modules/panel/controllers/facebook.php */