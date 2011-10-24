<?php

class Func {
    
    static function countNewMessages() {
	$select = 'select * from "' . Registry::getInstance()->config->sets['db']['prefix'] . '$' . 'Customer Notification" where "Customer Code"=' . "'{$_SESSION['user_data']['id']}'" . ' and "New"=0';
	$db = Registry::getInstance()->db;
	$stmt = sqlsrv_query( $db, $select , array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
	return sqlsrv_num_rows( $stmt );
    }
}
