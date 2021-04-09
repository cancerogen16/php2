<?php

require __DIR__ . '/vendor/autoload.php';

spl_autoload_register(function ($class) {
    $file = __DIR__ . '\\' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $file;
    }
});