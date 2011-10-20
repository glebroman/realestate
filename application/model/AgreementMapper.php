<?php

/**
 * 
 *
 * @author Breeze
 */
class Model_AgreementMapper extends AbstractMapper {
    
    protected $_model_object_name = 'agreement';
    
    protected $table_name = 'Customer Agreement';
    
    public function getAgreements() {
	$select = 'select * from "' . $this->getTableName() . '" where ("Customer No_"=' . "'{$_SESSION['user_data']['id']}'";
	$select .= ' or "Customer 2 No_"=' . "'{$_SESSION['user_data']['id']}'";
	$select .= ' or "Customer 3 No_"=' . "'{$_SESSION['user_data']['id']}') and (";
	$select .= '"Agreement Type"=1 or "Agreement Type"=2)';
	$stmt = sqlsrv_query($this->db, $select);
	$data = array();
	while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
	    $payments = new Model_PaymentsMapper();
	    $row['payed'] = $payments->getPayed($row['No_']);
	    $data[] = new Model_Agreement($row);	    
	}
	return $data;
    }
    

}
