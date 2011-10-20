<?php

/**
 * 
 *
 * @author Breeze
 */
class Model_Investment extends AbstractModel {
    protected $_agreement_no_;
    protected $_customer_no_;
    protected $_type;
    protected $_date;
    protected $_description;
    protected $_plan__amount;
    protected $_payed;
    protected $_remainder;
    
    public function getType() {
	switch ($this->_type) {
	    case 0:
		return "Платеж";
	    case 1:
		return "Штраф";
	}
    }
    
    public function getDescription() {
	return iconv("cp1251", "UTF-8", $this->_description);
    }
        
    public function getRemainder() {
	return $this->_plan__amount - $this->_payed;
    }
}
