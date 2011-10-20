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

    public function findByFields($fields=array(), $throw_exception = false) {
	$select = 'SELECT * from "' . $this->getTableName() . '"';
	if (count($fields))
	    $select .= ' where ' . $this->whereToStr($fields);
	else
	     throw new Exception('The fieldss for SELECT is not set');
	$smtp = sqlsrv_query($this->db, $select);
	$result = sqlsrv_fetch_array($smtp, SQLSRV_FETCH_ASSOC);
	if (count($result)==0) {
	    if (!$throw_exception)
		return;
	    throw new Exception($this->_model_object_name . ' record with the given parameters it is not found');
	}
	return $result;
    }
    
    protected function update($set=array(), $where=array()) {
	if (!count($set))
	     throw new Exception('The parameters for UPDATE is not set');
	$sql = 'update "' . $this->getTableName() . '" set ' . $this->setToStr($set);
	if (count($where))
	    $sql .= ' where ' . $this->whereToStr($where) ;
	return sqlsrv_query($this->db, $sql);
    }
    
    private function setToStr($set) {
	$str = '';
	foreach ($set as $key => $value) {
	    $str .= '"'.$key.'"=' . "'$value', ";
	}
	return trim($str, ', ');
    }
    
    private function whereToStr($where) {
	$str = '';
	foreach ($where as $key => $value) {
	    $str .= '"'.$key.'"=' . "'$value' and ";
	}
	return trim($str, ' and ');
    }
} 
