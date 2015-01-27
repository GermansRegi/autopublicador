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
	public function userAccountExist($where)
	{
		$res=$this->count_by($where);
		return (1==$res);
	}
	public function getUserappAccounts($where,$limit=0)
	{
		if($limit!=0)
		{
			return $this->limit(1)->get_many_by($where);	
		}
		return $this->get_many_by($where);
	}
}

/* End of file social_user_accounts.php */
/* Locat
ion: ./application/modules/panel/models/social_user_accounts.php */