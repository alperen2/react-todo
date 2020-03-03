<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
define('PAGE_ROOT', 'pages/');

$db_conf = [
	'host' => '127.0.0.1',
	'db' => 'todo',
	'user' => 'root',
	'password' => 'root',
];

try {
	$db = new PDO("mysql:host={$db_conf['host']};dbname={$db_conf['db']}", $db_conf['user'], $db_conf['password']);
} catch (PDOException $e) {
	throw $e;
}
