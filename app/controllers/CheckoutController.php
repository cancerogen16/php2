<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Cart;
use app\models\Product;

class CheckoutController extends Controller
{
    public function cartAction()
    {
        $vars = [
            'title' => 'Корзина',
        ];

        $vars['header'] = $this->getChild('CommonHeader', '');

        $vars['description'] = ob_get_clean();

        $template = 'checkout/cart.html.twig';

        $this->view->display($template, $vars);
    }

    public function cartAddAction()
    {
        $json = [];
        
        $product_id = (int)filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);

        $productModel = new Product;

        $product_info = $productModel->getProduct($product_id);

        if ($product_info) {
            $quantity = (int)filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_SPECIAL_CHARS);

            $user_id = $this->user->getUserId();

            $cartModel = new Cart;

            $result = $cartModel->add($product_id, $quantity, $user_id);

            $cart = $cartModel->getCart($user_id);

            $json = [
                'success' => '1',
                'products' => $cart['products'],
                'count' => $cart['count'],
                'total' => $cart['total'],
            ];
        }

        exit(json_encode($json));
    }
}
