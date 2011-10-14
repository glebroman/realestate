<?php

/**
 * 
 *
 * @author Breeze
 */
class Model_Customs extends AbstractModel {
    protected $_id;
    protected $_nickname;
    protected $_password;
    protected $_email;
    protected $_family;
    protected $_phone;
    protected $_city;
    protected $_adress;
    protected $_description;
    protected $_category;
    protected $_lockout;
    
    /**
     * проверка на блокировку
     * @return boolean 
     */
    public function isBlocked() {
	return $this->_lockout ? true : false;
    }
    
}
