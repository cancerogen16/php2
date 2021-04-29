<?php

namespace app\controllers;

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

        $count = 0;
        $total = 0;

        $vars['cart_products'] = [];

        if ($cart = $this->loadModel('cart')->getCart($user_id)) {
            if (!empty($cart['products'])) {
                require_once DIR_HELPERS . 'tools.php';

                foreach ($cart['products'] as $product_id => $quantity) {
                    $product = $this->loadModel('product')->getProduct($product_id);

                    $total += $quantity * $product['price'];

                    $product['thumb'] = getThumb($product['image'], 50, 50);

                    $product['quantity'] = $quantity;
                    $product['total'] = priceFormat((float)$product['price'] * $quantity);
                    $product['price'] = priceFormat($product['price']);

                    $vars['cart_products'][] = $product;

                    $count++;
                }
            }
        }

        $vars['count'] = $count;
        $vars['total'] = priceFormat($total);

        $template = 'common/header.tmpl';

        return $this->view->render($template, $vars);
    }
}