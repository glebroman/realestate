<?php

/**
 * 
 *
 * @author Breeze
 */
class Model_Customs extends AbstractModel {
    protected $_no_;
    protected $_name;
    
    public function getName() {
	return iconv("cp1251", "UTF-8", $this->_name);
    }
        
}
