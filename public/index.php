<?php

use php2\config\Test;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/config.php';

$app = new Test;

var_dump($app);