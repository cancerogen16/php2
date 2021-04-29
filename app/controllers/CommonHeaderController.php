<?php

namespace app\controllers;

use app\core\Controller;

class CommonHeaderController extends Controller
{
    public function index()
    {
        $logged = false;

        $username = '';
        $user_id = 0;

        $admin = 0;

        if (!empty($_SESSION["username"])) {
            $logged = true;
            $username = htmlspecialchars($_SESSION["username"]);
            $user_id = (int)$_SESSION["user_id"];

            if ($_SESSION['user_role'] == 'admin') {
                $admin = 1;
            }
        }

        $vars = [
            'logged' => $logged,
            'username' => $username,
            'user_id' => $user_id,
            'admin' => $admin,
        ];

        $vars['count'] = 0;
        $vars['totalSum'] = 0;
        $vars['total'] = '';
        $vars['cart_products'] = [];

        if ($cart = $this->loadModel('cart')->getCart($user_id)) {
            if (!empty($cart['products'])) {
                $cartData = $this->loadModel('product')->getCartData($cart['products'], 50, 50);

                $vars['count'] = $cartData['count'];
                $vars['totalSum'] = $cartData['totalSum'];
                $vars['total'] = $cartData['total'];
                $vars['cart_products'] = $cartData['products'];
            }
        }

        $template = 'common/header.tmpl';

        return $this->view->render($template, $vars);
    }
}