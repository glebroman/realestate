<?php

/**
 * 
 *
 * @author Breeze
 */
class Model_MessagesMapper extends AbstractMapper {
    
    protected $_model_object_name = 'messages';
    
    protected $table_name = 'Customer Notification';
    
    public function toggleBlock(Model_Messages $message) {
	if ( $message->getCustomer_Code()==$_SESSION['user_data']['id'] ) {
	    $line_no = $message->getLine_No_();
	    $status = $message->getNew() ? 0 : 1;
	    $where = array(
		'Customer Code'=>$_SESSION['user_data']['id'],
		'Line No_'=>$line_no
	    );
	    $set = array(
		'New'=>$status
	    );
	    return $this->update($set, $where);
	}
	return false;
    }

}