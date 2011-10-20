<?php

/**
 * 
 *
 * @author Breeze
 */
class Model_PaymentsMapper extends AbstractMapper {
    
    protected $_model_object_name = 'payments';
    
    protected $table_name = 'Sales Payments Link';
    
    public function getPayed($agreement_code) {
	$select = 'select SUM("Distributions Amount") as summa from "' . $this->getTableName() . '" where "Customer No_"=';
	$select .= "'{$_SESSION['user_data']['id']}'";
	$select .= ' and "Agreement No_"=' . "'" . $agreement_code . "'";
	$stmt = sqlsrv_query($this->db, $select);
	$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
	return $row['summa'];
    }
    
    public function getPayedByStage($agreement_code, $stage) {
	$select = 'select SUM("Distributions Amount") as summa from "' . $this->getTableName() . '" where "Customer No_"=';
	$select .= "'{$_SESSION['user_data']['id']}'";
	$select .= ' and "Agreement No_"=' . "'" . $agreement_code . "'";
	$select .= ' and "Stage"=' . "'" . $stage . "'";
	$stmt = sqlsrv_query($this->db, $select);
	$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
	return $row['summa'];
    }

}

