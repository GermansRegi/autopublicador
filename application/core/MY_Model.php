<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {
  	protected $_table;
    /**
     * The database connection object. Will be set to the default
     * connection. This allows individual models to use different DBs
     * without overwriting CI's global $this->db connection.
     */
    public $_database;
    protected $return_type;
    protected $_temporary_return_type;
	function __construct()
	{
		parent::__construct();
		$this->_database=$this->db;
	}
	public function setTable($name)
	{
		$this->_table=$name;
	}
	public function setContentTable($type)
	{
		$this->_table=$this->_table."_".$type;
	}
	public function table()
	{
		return $this->_table;
	}
	public function get_many_by()
    {
        $where = func_get_args();
        
        $this->_database->where($where[0]);
     
        return $this->get_all();
    }
    public function get_all()
    {
        $result = $this->_database->get($this->_table)
                           ->{$this->_return_type(1)}();
        $this->_temporary_return_type = $this->return_type;
       
        return $result;
    }
    public function count_by()
    {
        
        $where = func_get_args();
        $this->_database->where($where[0]);
        return $this->_database->count_all_results($this->_table);
    }

    protected function _return_type($multi = FALSE)
    {
        $method = ($multi) ? 'result' : 'row';
        return $this->_temporary_return_type == 'array' ? $method . '_array' : $method;
    }
      /**
     * Return the next call as an array rather than an object
     */
    public function as_array()
    {
        $this->_temporary_return_type = 'array';
        return $this;
    }
    /**
     * Return the next call as an object rather than an array
     */
    public function as_object()
    {
        $this->_temporary_return_type = 'object';
        return $this;
    }
    public function get_by_id($id)
    {
    		if($id!==FALSE)
    		{
    		
    			 $this->_database->where('id',$id);
    			 return  $this->_database->get($this->_table)
                           ->{$this->_return_type(1)}();
        
    		}
    }
    public function limit($limit, $offset = 0)
    {
        $this->_database->limit($limit, $offset);
        return $this;
    }
    public function insert($data)
    {
        
        if ($data !== FALSE)
        {
            
            $this->_database->insert($this->_table, $data);
            $insert_id = $this->_database->insert_id();
            
            return $insert_id;
        }
        else
        {
            return FALSE;
        }
    }
    public function delete_by()
    {
        $where = func_get_args();
	    
        $this->_database->where($where[0]);
        
       $result = $this->_database->delete($this->_table);
        
        
        return $result;
    }

}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */