<?php

/**
 * 
 *
 * @author Breeze
 */
class Model_CustomsMapper extends AbstractMapper {
    
    protected $_model_object_name = 'customs';
    
    protected $table_name = 'Customer';
        
    public function findByWebLogin($login) {
	$select = 'select * from "' . $this->getTableName() . '" where "Web Login"=' . "'$login'";
	$smtp = sqlsrv_query($this->db, $select);
	return sqlsrv_fetch_array( $smtp, SQLSRV_FETCH_ASSOC);
    }
    
}
