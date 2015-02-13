<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autoprog_basededatos extends MY_Model {

		public function __construct()
		{
			parent::__construct();
			$this->setTable("autoprogramacions_bbdd");
		}		
		public function insertNew($array=array())
		{
			return $this->insert($array);
		}

}

/* End of file autoprog_basededatos.php */
/* Location: ./application/modules/panel/models/autoprog_basededatos.php */