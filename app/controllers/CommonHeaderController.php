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

        $count = 0;
        $total = 0;

        $vars['cart_products'] = [];
        $vars['count'] = 0;
        $vars['total'] = '';

        if ($cart = $cartModel->getCart($user_id)) {
            if (!empty($cart['products'])) {
                $image_product_width = 50;
                $image_product_height = 50;

                require_once DIR_HELPERS . 'tools.php';

                $productModel = new Product;

                foreach ($cart['products'] as $product_id => $quantity) {
                    $product = $productModel->getProduct($product_id);

                    $total += $quantity * $product['price'];

                    if ($product['image']) {
                        $image = resize($product['image'], $image_product_width, $image_product_height);
                    } else {
                        $image = resize('noimage.jpg', $image_product_width, $image_product_height);
                    }

                    $product['thumb'] = $image;

                    $product['quantity'] = $quantity;
                    $product['total'] = priceFormat((float)$product['price'] * $quantity);
                    $product['price'] = priceFormat($product['price']);

                    $vars['cart_products'][] = $product;

                    $count++;
                }

                $vars['count'] = $count;
                $vars['total'] = priceFormat($total);
            }
        }

        $template = 'common/header.tmpl';

        return $this->view->render($template, $vars);
    }
}