<?php

namespace app;

trait SingletonTrait {
    private static $instance;

    public static function getInstance() {
        if (empty(self::$instance)) self::$instance = new static();

        return self::$instance;
    }

    private function __construct() {
    }
    private function __clone() {
    }
    private function __wakeup() {
    }
}