<?php
require_once dirname(__DIR__) . '/app/config/config.php';
require dirname(__DIR__) . '/app/lib/Dev.php';

require_once DIR_VENDOR . 'autoload.php';

use app\core\Router;

session_start();

$router = new Router;
$router->run();