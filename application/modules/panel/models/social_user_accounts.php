<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Social_user_accounts extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->setTable('social_user_accounts');

	}
	/**
	 * INSERT NEW
	 *  @ PARAM $DATA ARRAY
	*
		 */
	public function insertNew($data)
	{
		return $this->insert($data);
	}
	
}

/* End of file social_user_accounts.php */
/* Location: ./application/modules/panel/models/social_user_accounts.php */