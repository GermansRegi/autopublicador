    <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bases_datos_model extends MY_Model {

	
	public function __construct()
	{
		parent::__construct();
		$this->setTable('basesdedatos');

	}
	
/*     public function getOne($user_app,$where)
	{
		return $this->get_by($where)->limit(1);

	}

	public function getById($id,$user_app=null)
	{	
		return $this->get_by_id($id)->limit(1);
	}*/

	public function getAll($user_app=null)
	{
		if($user_app)
			return $this->get_many_by(array('user_app'=>$user_app->id));
		else
			return $this->get_all();

	}
	public function insertNew($data)
	{
		return $this->insert($data);
	}
/*
*	public function delete($where)
	{

	}
	public function update($data,$where)
	{
	}/
	///selecciona els elements d'uun tipus
	public function getElements($type,$where=null,$limit=false,$offset=false)
	{
		/*$this->change_table('basesdedatos_'.$type);
		echo $this->_table;
		$this->update_by(array('socialnetwork'=>'face'),array('oo'=>2));
		echo $this->_table;/
	}
	*public function deleteElement(type,$where)
	{

	}
	public function getElement($type,$id)
	{

	}
	public function countElements($type,$where)
	{

	}
*/




}

/* End of file basesdedatos.php */
/* Location: ./application/models/basesdedatos.php */