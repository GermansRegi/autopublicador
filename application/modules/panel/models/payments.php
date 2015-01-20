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

}

/* End of file payments.php */
/* Location: ./application/modules/panel/models/payments.php */