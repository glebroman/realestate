<?php

abstract class AbstractModel {

    public function __construct(array $options = array()) {

	$this->setOptions($options);
    }

    public function __call($method, $parameters) {
	if (strlen($method) < 4)
	    throw new Exception('Method does not exist');

	$property = '_' . strtolower(preg_replace('~([a-z])([A-Z]{1})~', '$1_$2', substr($method, 3)));
	if (0 === strpos($method, 'set')) {
	    if (property_exists($this, $property)) {
		$this->$property = $parameters[0];
		return $this;
	    }
	} elseif (0 === strpos($method, 'get')) {
	    if (property_exists($this, $property))
		return $this->$property;
	}
	throw new Exception('Invalid method [' . $method . '] in ' . get_class($this));
    }
    
    public function __set($key, $val) {
	$var = '_' . strtolower($key);
	$this->$var = $val;
	return;
    }

    public function __get($key) {
	if (!isset($this->$key)) {
	    throw new Exception('Invalid getter for [' . $key . '] property in [' . get_class($this) . ']');
	}
	return $this->$key();
    }

    public function setOptions(array $options) {
	foreach ($options as $key => $value) {
	    try {
		$key = str_replace(' ', '_' , $key);
		$method = 'set' . ucfirst($key);
		$this->$method($value);
	    } catch (Exception $e) {
		continue;
	    }
	}
	return $this;
    }

    public function toArray() {
	$res = array();
	foreach (get_object_vars($this) as $prop_name => $prop_val) {
	    if (stripos($prop_name, '_') === 0) {
		$property = substr($prop_name, 1);
		$res[$property] = $prop_val;
	    }
	}
	return $res;
    }
}

?>
