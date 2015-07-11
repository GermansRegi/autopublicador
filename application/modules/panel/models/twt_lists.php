<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Twt_lists extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->setTable('twt_lists');

	}
	public function insertNew($data)
	{
		$this->insert($data);
	}
	public function Exists($user_id,$list_id,$user_app)
	{
		
		$exist=$this->count_by(array('user_id'=>$user_id,'list_id'=>$list_id,'user_app'=>$user_app));
		return (1>=$exist);
	}
	public function getUserappLists($where,$limit=0)
	{
		if($limit!=0)
		{
			return $this->limit(1)->get_many_by($where);	
		}
		return $this->get_many_by($where);
	}
	
	
}
