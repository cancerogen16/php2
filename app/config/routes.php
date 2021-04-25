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
        'controller' => 'cart',
        'action' => 'cart',
    ],

    'checkout/cartAdd' => [
        'controller' => 'cart',
        'action' => 'cartAdd',
    ],

    'checkout' => [
        'controller' => 'checkout',
        'action' => 'checkout',
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