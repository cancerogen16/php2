<?php

namespace app\controllers\Admin;

use app\core\Controller;
use app\models\Cart;
use app\models\Product;

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

        $template = 'admin/common/header.tmpl';

        return $this->view->render($template, $vars);
    }
}