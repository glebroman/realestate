<?php

Abstract Class AbsctractController {

    protected $registry;

    function __construct($registry) {
	
	$this->registry = $registry;
	session_start();
    }

    abstract function index();

}