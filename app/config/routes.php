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

    'cart/cartAdd' => [
        'controller' => 'cart',
        'action' => 'cartAdd',
    ],

    'cart/removeFromCart' => [
        'controller' => 'cart',
        'action' => 'removeFromCart',
    ],

    'checkout' => [
        'controller' => 'checkout',
        'action' => 'checkout',
    ],

    'checkout/changeQuantity' => [
        'controller' => 'checkout',
        'action' => 'changeQuantity',
    ],

    'checkout/removeFromCart' => [
        'controller' => 'checkout',
        'action' => 'removeFromCart',
    ],

    'error/403' => [
        'controller' => 'error',
        'action' => 'error403',
    ],

    'error/404' => [
        'controller' => 'error',
        'action' => 'error404',
    ],


    'admin' => [
        'controller' => 'admin/main',
        'action' => 'index',
    ],

    'admin/catalog' => [
        'controller' => 'admin/catalog',
        'action' => 'index',
    ],

    'admin/product' => [
        'controller' => 'admin/product',
        'action' => 'index',
    ],

    'admin/product/update' => [
        'controller' => 'admin/product',
        'action' => 'update',
    ],

    'admin/orders' => [
        'controller' => 'admin/order',
        'action' => 'index',
    ],

    'admin/order/edit' => [
        'controller' => 'admin/order',
        'action' => 'edit',
    ],

    'admin/order/delete' => [
        'controller' => 'admin/order',
        'action' => 'delete',
    ],

    'admin/order/changeOrderStatus' => [
        'controller' => 'admin/order',
        'action' => 'changeOrderStatus',
    ],
];