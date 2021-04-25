<?php

return [

    '' => [
        'controller' => 'main',
        'action' => 'index',
    ],

    'account' => [
        'controller' => 'account',
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
        'controller' => 'catalog',
        'action' => 'catalog',
    ],

    'category' => [
        'controller' => 'category',
        'action' => 'category',
    ],

    'product' => [
        'controller' => 'product',
        'action' => 'product',
    ],

    'cart' => [
        'controller' => 'checkout',
        'action' => 'cart',
    ],

    'checkout' => [
        'controller' => 'checkout',
        'action' => 'checkout',
    ],

    'checkout/cartAdd' => [
        'controller' => 'checkout',
        'action' => 'cartAdd',
    ],

    'checkout/changeQuantity' => [
        'controller' => 'checkout',
        'action' => 'changeQuantity',
    ],

    'error/403' => [
        'controller' => 'error',
        'action' => 'error403',
    ],


    'admin' => [
        'controller' => 'admin',
        'action' => 'index',
    ],
];