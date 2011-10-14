<?php

error_reporting (E_ALL);

define( 'APPLICATION_PATH', realpath(dirname(__FILE__)) . '/application/' );

include_once 'config.php';

// Соединяемся с базой
try {
    $db = new PDO("mysql:host={$config->sets['db']['host']};dbname={$config->sets['db']['dbname']}", $config->sets['db']['username'], $config->sets['db']['password']);
    $db->query('SET NAMES UTF8');
    // Выводим ошибки
//    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
	    
$registry->db = $db;

$router = new Router($registry);
$registry->router = $router;
$router->setPath ( APPLICATION_PATH . 'controllers' );
$router->run();