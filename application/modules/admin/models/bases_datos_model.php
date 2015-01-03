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
*/
	public function getById($id,$user_app=null)
	{	
		return $this->limit(1)->get_by_id($id);
	}

	public function getAll($where)
	{
		if($user_app)
			return $this->get_many_by($where);
		else
			return $this->get_all();

	}
	public function insertNew($data)
	{
		return $this->insert($data);
	}

	public function delete($where)
	{

	}
	public function update($data,$where)
	{
	}
	///selecciona els elements d'uun tipus
	public function getElements($type,$where=array(),$limit=false,$offset=false)
	{
		$this->setContentTable($type);
		if($limit)
		{
			$result=$this->limit($limit,$offset)->get_many_by($where);
		}
		else
			$result=$this->get_many_by($where);
		$this->setTable('basesdedatos');		
		return $result;
	}
	public function countAllElements($type,$where=array())
	{
		$this->setContentTable($type);
		$result=$this->count_by($where);
		$this->setTable('basesdedatos');		
		return $result;
	}
	public function insertElement($type,$data)
	{
		$this->setContentTable($type);
		$this->insert($data);
		$this->setTable('basesdedatos');	
	}
	/*
	/*public function deleteElement(type,$where)
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