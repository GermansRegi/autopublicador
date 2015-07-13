<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autoprog_anuncios extends MY_Model {

		public function __construct()
		{
			parent::__construct();
			$this->setTable("autoprogramacions_anuncios");
		}	
		public function insertNew($array=array())
		{
			return $this->insert($array);
		}	

}
