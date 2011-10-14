<?php

Class Router {

    private $registry;
    private $path;
    private $controller;
    private $action;
    private $args = array();

    public function __construct($registry) {

	$this->registry = $registry;
    }

    public function setPath($path) {

	$path = trim($path, '/\\');
	$path .= '/';

	if (is_dir($path) == false) {

	    throw new Exception('Invalid controller path: `' . $path . '`');
	}

	$this->path = $path;
    }
    
    private function getRouter(&$file, &$controller, &$action, &$args) {

	$route = (empty($_GET['route'])) ? 'index' : $_GET['route'];

	$route = trim($route, '/\\');
	$parts = explode('/', $route);
	$cmd_path = $this->path;

	foreach ($parts as $part) {
	    $fullpath = $cmd_path . $part;

	    if (is_dir($fullpath)) {
		$cmd_path .= $part . '/';
		array_shift($parts);
		continue;
	    }

	    if (is_file($fullpath . '.php')) {
		$controller = $part;
		array_shift($parts);
		break;
	    }
	}

	if (empty($controller)) {
	    $controller = 'index';
	};
	
	$this->controller = $controller;

	$action = array_shift($parts);

	if (empty($action)) {
	    $action = 'index';
	}
	$this->action = $action;

	$file = $cmd_path . $controller . '.php';
	$this->args = $this->setRequest($parts);
    }

    public function run() {

	$this->getRouter($file, $controller, $action, $args);

	if (is_readable($file) == false) {
	    die('404 Not Found');
	}

	include ($file);

	$class = 'Controller_' . $controller;
	$controller = new $class($this->registry);

	if (is_callable(array($controller, $action)) == false) {
	    die('404 Not Found');
	}

	$controller->$action();
    }
    
    private function setRequest($args) {
	$data = $keys = $vars = array();
	    
	foreach ($args as $key => $val) {
	    if ($key%2==0) $keys[] = $val;
	    if ($key%2==1) $vars[] = $val;
	}
	foreach ($keys as $key => $val) {
	    $data[$val] = $vars[$key];
	}
	return $data;
    }
    
    public function getRequest($var) {
	if (array_key_exists($var, $this->args)) {
	    return $this->args[$var];
	} else {
	    return false;
	}
    }
    
    public function getController() {
	return $this->controller;
    }
    
    public function getAction() {
	return $this->action;
    }

}
