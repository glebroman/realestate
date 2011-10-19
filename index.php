<?php

error_reporting (E_ALL);

define( 'APPLICATION_PATH', realpath(dirname(__FILE__)) . '/application/' );

include_once 'config.php';

// Соединяемся с базой
// SQLSRV: 1-й способ

$connectionInfo = array("UID" => $config->sets['db']['username'], "PWD" => $config->sets['db']['password'], "Database"=>$config->sets['db']['dbname']);
$db = sqlsrv_connect($config->sets['db']['host'], $connectionInfo);
if( $db === false )
    die(var_dump ( sqlsrv_errors() ) );

$registry->db = $db;

$router = new Router();
$registry->router = $router;
$router->setPath ( APPLICATION_PATH . 'controllers' );
$router->run();