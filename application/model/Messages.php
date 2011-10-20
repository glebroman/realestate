<?php

/**
 * 
 *
 * @author Breeze
 */
class Model_Messages extends AbstractModel {
    protected $_customer_code;
    protected $_line_no_;
    protected $_date;
    protected $_text_1;
    protected $_text_2;
    protected $_text_3;
    protected $_text_4;
    protected $_new;
    
    public function getText() {
	return $this->_text_1 . $this->_text_2 . $this->_text_3 . $this->_text_4; 
    }
    
    public function isNew() {
	return $this->_new!=1;
    }
}
