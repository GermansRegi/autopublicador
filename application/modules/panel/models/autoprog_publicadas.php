<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autoprog_publicadas extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->setTable("autoprog_publicadas");
		
	}
	public function findOne($where=array())
	{
		return $this->get_many_by($where);
		
	}

}

/* End of file autoprog_publicadas.php */
/* Location: ./application/modules/panel/models/autoprog_publicadas.php */