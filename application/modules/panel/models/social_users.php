<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Social_users extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->setTable('social_users');

	}
	public function insertNew($data)
	{
		$this->insert($data);
	}
	public function notExists($user_id,$socialnet)
	{
		
		$exist=$this->count_by(array('user_id'=>$user_id,'socialnetwork'=>$socialnet));
		return (0==$exist);
	}
}

/* End of file social_users.php */
/* Location: ./application/modules/panel/models/social_users.php */