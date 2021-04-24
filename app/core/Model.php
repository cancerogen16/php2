<?php

namespace app\core;

use app\lib\Db;

abstract class Model
{

    public $db;

    public function __construct()
    {
        $config = require 'app/config/db.php';
        $this->db = new Db($config['host'], $config['user'], $config['password'], $config['name']);
    }
}