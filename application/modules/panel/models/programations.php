<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Programations extends MY_Model {

	
	public function __construct()
	{
		parent::__construct();
		$this->setTable('programations');

	}
	public function insertNew($data=array())
	{
		$this->insert($data);
	}
	public function getAll($array=array())
	{
		return $this->get_many_by($array);
	}
	public function getById($id)
	{
		return $this->get_by_id($id);
	}
	public function getProgramations($array)
	{

		

        //return  $this->get_many_by($array);
		return  $this->get_many_by($array);
    
	}
	
}

/* End of file programations.php */
/* Location: ./application/modules/panel/models/programations.php */