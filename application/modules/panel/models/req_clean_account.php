

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Req_clean_account extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->setTable("req_clean_account");
		
	}
	public function findOne($where=array())
	{
		return $this->get_many_by($where);
		
	}

}

/* End of file autoprog_publicadas.php */
/* Location: ./application/modules/panel/models/autoprog_publicadas.php */