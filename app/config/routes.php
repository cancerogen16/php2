<?php

return [

    '' => [
        'controller' => 'main',
        'action' => 'index',
    ],

    'account/login' => [
        'controller' => 'account',
        'action' => 'login',
    ],

    'account/logout' => [
        'controller' => 'account',
        'action' => 'logout',
    ],

    'account/register' => [
        'controller' => 'account',
        'action' => 'register',
    ],

    'catalog' => [
        'controller' => 'product',
        'action' => 'catalog',
    ],

    'category' => [
        'controller' => 'product',
        'action' => 'category',
    ],

    'product' => [
        'controller' => 'product',
        'action' => 'product',
    ],

];