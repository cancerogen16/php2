<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Cart;

class CommonHeaderController extends Controller
{
    public function index()
    {
        $logged = false;

        $username = '';
        $user_id = 0;

        $vars['cart'] = [];
        $vars['cart_products'] = [];

        if (!empty($_SESSION["username"])) {
            $logged = true;
            $username = htmlspecialchars($_SESSION["username"]);
            $user_id = (int)$_SESSION["user_id"];
        }

        $vars = [
            'logged' => $logged,
            'username' => $username,
            'user_id' => $user_id,
        ];

        $cartModel = new Cart;

        if ($cart = $cartModel->getCart($user_id)) {
            $vars['cart'] = $cart;
            $vars['cart_products'] = $cart['products'];
        }

        $template = 'common/header.tmpl';

        return $this->view->render($template, $vars);
    }
}