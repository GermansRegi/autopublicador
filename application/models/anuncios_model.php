<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anuncios_model extends MY_Model {
	

	
	public function __construct()
	{
		parent::__construct();
		$this->setTable('anuncios');

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

	public function getAll($where=array())
	{
		if(count($where)>0)
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
	public function deleteElementImage($id)
	{
		$image=$this->getElementById('image',$id);
		if(file_exists($image[0]->path))
		{
			unlink($image[0]->path);
		}
		$this->deleteElement('image',array('id'=>$id));
	}
	public function getElementById($type,$id)
	{
		$this->setContentTable($type);
		$result= $this->limit(1)->get_by_id($id);
		$this->setTable('anuncios');		
		return $result;
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
		$this->setTable('anuncios');		
		return $result;
	}
	public function countAllElements($type,$where=array())
	{
		$this->setContentTable($type);
		$result=$this->count_by($where);
		$this->setTable('anuncios');		
		return $result;
	}
	public function insertElement($type,$data)
	{
		$this->setContentTable($type);
		$this->insert($data);
		$this->setTable('anuncios');	
	}

	public function deleteElement($type,$data)
	{
		$this->setContentTable($type);
		$this->delete_by($data);
		$this->setTable('anuncios');		
	}
	public function deleteOne($bdid)
	{
		$basededatos=$this->getById($bdid);
		$elements=$this->getElements($basededatos[0]->content,array('bbdd_id'=>$bdid));
		
		foreach($elements as $elem)
		{
			if($basededatos[0]->content=='image')
			{
				if(file_exists($elem->path))
				{
					unlink($elem->path);
				}
			}
			$this->deleteElement($basededatos[0]->content,array('id'=>$elem->id));
		}
		$this->delete_by(array('id'=>$bdid));
		
	}


	

}

/* End of file anuncios_model.php */
/* Location: ./application/models/anuncios_model.php */