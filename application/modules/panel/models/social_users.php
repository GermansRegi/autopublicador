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
		
		$exist=$this->count_by(array('user_id'=>$user_id,'social_network'=>$socialnet));
		return (0==$exist);
	}
	public function getUserappUsers($where,$limit=0)
	{
		if($limit!=0)
		{
			return $this->limit(1)->get_many_by($where);	
		}
		return $this->get_many_by($where);
	}
	
	
}

/* End of file social_users.php */
/* Location: ./application/modules/panel/models/social_users.php */