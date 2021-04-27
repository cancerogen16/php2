<?php

namespace app\core;

use app\lib\Db;

class Model
{
    public $db;

    public function __construct()
    {
        $config = require dirname(__DIR__) . DS .'config' . DS . 'db.php';

        $hostname = $config['host'];
        $port = '3306';
        $database = $config['name'];
        $username = $config['user'];
        $password = $config['password'];

        $this->db = new Db($hostname, $username, $password, $database, $port);
    }
}