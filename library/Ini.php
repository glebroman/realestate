<?php

class Ini {
    
    public $sets = array();
    
    public function __construct($filename) {
        if (empty($filename)) {
            throw new Exception('Filename is not set');
        }
        $this->sets = $this->_loadIniFile($filename);
    }
    
    protected function _loadIniFile($filename) {
	$loaded = parse_ini_file($filename, true);

	$iniArray = array();
	foreach ($loaded as $key => $data) {
	    $iniArray[trim($key)] = $data;
	}
	
	return $iniArray;
    }

}