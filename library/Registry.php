<?php


class Registry {

    private $vars = array();
    
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
}