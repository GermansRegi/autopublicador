<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rss_model extends MY_Model {

		public function __construct()
		{
			parent::__construct();
			$this->setTable("rss");
		}		

}

/* End of file rss.php */
/* Location: ./application/modules/panel/models/rss.php */