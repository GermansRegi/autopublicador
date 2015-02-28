<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payments extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->setTable('user_payments');

	}
	public function getAllFromUser($id_user)
	{
		return  $this->get_many_by(array("user_app"=>$id_user));
	}
	public function notExist($array=array())
	{	
		return (0==$this->count_by($array));
	}
	public function getLastPayment($array=array())
	{
		$this->_database->select('max(date_pay) as last, type_prempay,  id');
		$this->_database->order_by('last','desc');
		$this->limit(1);
		return $this->get_many_by($array);
	}
	public function getLastPaymentFinish($array=array())
	{
		$this->_database->select('max(date_finish) as last, type_prempay,  id');
		$this->_database->order_by('last','desc');
		$this->limit(1);
		return $this->get_many_by($array);	
	}
	public function getLastQuery()
	{
		return $this->getLastQuery();
	}

}

/* End of file payments.php */
/* Location: ./application/modules/panel/models/payments.php */