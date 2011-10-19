<?php

function __autoload($class_name) {
    $paths = array();
    $paths[] = APPLICATION_PATH . strtolower( str_replace('_', '/', $class_name) ) . '.php';
    $paths[] = APPLICATION_PATH . '/../library/' . strtolower($class_name) . '.php';
    foreach ($paths as $path) {
	 if (file_exists($path) == false)
	     continue;
	 include ($path);
    }
}

$registry = Registry::getInstance();
$config = new Ini('application.ini');

$menu = array(
    'index'	=>array('index'=>'Главная'),
    'messages'	=>array('input'=>'Входящие'),
    'login'	=>array('logout'=>'Выход')
    );

$registry->url = 'http://' . $_SERVER['SERVER_NAME'];
$registry->menu = $menu;
$registry->config = $config;
$registry->template = new Template($registry);


