<?php

error_reporting (E_ALL);

define( 'APPLICATION_PATH', realpath(dirname(__FILE__)) . '/application/' );

include_once 'config.php';

// Соединяемся с базой
// SQLSRV: 1-й способ

$connectionInfo = array("UID" => $config->sets['db']['username'], "PWD" => $config->sets['db']['password'], "Database"=>$config->sets['db']['dbname']); //$config->sets['db']['username'],
$connectionOptions = array("Database"=>"proba");
$db = sqlsrv_connect($config->sets['db']['host'], $connectionInfo);
if( $db === false )
    die(var_dump ( sqlsrv_errors() ) );


// MSSQL: 2-й способ
/*
$db = mssql_connect("ROMAN\SQLEXPRESS,1433","glebroman","5t6y7u8i");
if ($db===false)
    die( mssql_get_last_message () );
mssql_select_db("proba", $db);
*/

// PDO: 3-й способ
/*
try {
    $db = new PDO("mssql:host={$config->sets['db']['host']};dbname={$config->sets['db']['dbname']}", $config->sets['db']['username'], $config->sets['db']['password']);
    $db->query('SET NAMES UTF8');
    // Выводим ошибки
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}
*/

$registry->db = $db;

$router = new Router($registry);
$registry->router = $router;
$router->setPath ( APPLICATION_PATH . 'controllers' );
$router->run();