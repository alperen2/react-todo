<?php
include 'config.php';
$url = $_SERVER['REQUEST_URI'];
$explode = explode('/', trim($url, '/'));



$page = $explode[0] != '' ? $explode[0] : 'task';
$act = isset($explode[1]) ? $explode[1] : 'list';
$param = $explode[2] ?? null;
$page_path = PAGE_ROOT . "$page.php";

if (file_exists($page_path)) require $page_path;
