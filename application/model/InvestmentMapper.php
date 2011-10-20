<?php

/**
 * 
 *
 * @author Breeze
 */
class Model_InvestmentMapper extends AbstractMapper {
    
    protected $_model_object_name = 'investment';
    
    protected $table_name = 'Investment Agreement LIne';
    
    public function getPayments() {
	$subselect = 'select "No_" from "' . Registry::getInstance()->config->sets['db']['prefix'] . '$Customer Agreement" where ("Customer No_"=' . "'{$_SESSION['user_data']['id']}'";
	$subselect .= ' or "Customer 2 No_"=' . "'{$_SESSION['user_data']['id']}'";
	$subselect .= ' or "Customer 3 No_"=' . "'{$_SESSION['user_data']['id']}') and (";
	$subselect .= '"Agreement Type"=1 or "Agreement Type"=2)';
	$select = 'select * from "' . $this->getTableName() . '" where "Customer No_"=' . "'{$_SESSION['user_data']['id']}'";
	$select .= ' and "Agreement No_" in (' . $subselect . ') order by "Agreement No_","Date"';
	$stmt = sqlsrv_query($this->db, $select);
	$data = array();
	while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
	    $payments = new Model_PaymentsMapper();
	    $row['payed'] = $payments->getPayedByStage($row['Agreement No_'], $row['Stage']);
	    $data[] = new Model_Investment($row);	    
	}
	return $data;
    }
    

}
