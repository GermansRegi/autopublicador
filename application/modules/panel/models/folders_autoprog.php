<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Folders_autoprog extends MY_Model {

	public function __construct()
		{
			parent::__construct();
			$this->setTable("folders_autoprog");
		}	

}

/* End of file folders.php */
/* Location: ./application/modules/panel/models/folders.php */