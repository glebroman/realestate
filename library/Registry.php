<?php


class Registry {
    
    private static $_instance;

    private $vars = array();
    
    private function __construct() {
	//
    }
    
    public static function getInstance() {
	if (self::$_instance === null) {
	    //First and only construction.
	    self::$_instance = new self();
	}
	return self::$_instance;
    }

    public function __set($key, $val) {
	
        if (empty($this->vars[$key]) == false) {
            return false;
        }
	
        $this->vars[$key] = $val;
        return true;
    }
    
    public function __get($key) {

	if (empty($this->vars[$key]) == true) {
	    return null;
	}
	
	return $this->vars[$key];
    }
    
    private function __clone() {
	//
    }
}