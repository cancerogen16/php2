<?php

namespace App;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/config.php';

$app = new App;

var_dump($app);