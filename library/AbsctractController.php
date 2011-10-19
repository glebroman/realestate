<?php

Abstract Class AbsctractController {

    protected $registry;

    function __construct() {
	
	$this->registry = Registry::getInstance();
	session_start();
    }

    abstract function index();

}