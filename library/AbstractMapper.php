<?php

abstract class AbstractMapper {
    
    protected $db = NULL;
    
    protected $_model_object_name;

    protected $table_name;
    
    public function __construct($db) {
	$this->db = $db;
    }

    public function findById($id, $throw_exception = false) {
	$smtp = sqlsrv_query($this->db, "SELECT * from " . $this->table_name . " where id = $id");
	$result = sqlsrv_fetch_array($smtp, SQLSRV_FETCH_ASSOC);
	if (count($result)==0) {
	    if (!$throw_exception)
		return;
	    throw new Exception($this->_model_object_name . ' record with id [' . $id . '] not found');
	}
	$class = 'Model_' . $this->_model_object_name;
	return new $class($result);
    }

} 
