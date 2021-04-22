<?php
require_once 'app/config/config.php';
require 'app/lib/Dev.php';

require_once DIR_VENDOR . 'autoload.php';

use app\core\Router;

session_start();

$router = new Router;
$router->run();