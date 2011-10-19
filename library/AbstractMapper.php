<?php

abstract class AbstractMapper {
    
    protected $db = NULL;
    
    protected $_model_object_name;

    protected $table_name;
    
    public function __construct() {
	$this->db = Registry::getInstance()->db;
    }

    protected function getTableName() {
	return Registry::getInstance()->config->sets['db']['prefix'] . '$' . $this->table_name;
    }

    public function findByField($field, $value, $throw_exception = false) {
	$smtp = sqlsrv_query($this->db, 'SELECT * from "' . $this->getTableName() . '" where "' . $field . '"=' . "'$value'");
	$result = sqlsrv_fetch_array($smtp, SQLSRV_FETCH_ASSOC);
	if (count($result)==0) {
	    if (!$throw_exception)
		return;
	    throw new Exception($this->_model_object_name . ' record with value [' . $value . '] not found');
	}
	$class = 'Model_' . $this->_model_object_name;
	return new $class($result);
    }
    
} 
