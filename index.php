<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (is_file('config.php')) {
    require_once('config.php');
}

$dbObject = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
$dbObject->exec('SET CHARACTER SET utf8');

// Загружаем router
$router = new Engine\Router();
// задаем путь до папки контроллеров.
$router->setPath(SITE_PATH . 'controller');
// запускаем маршрутизатор
$router->start();