<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Cart;
use app\models\Product;

class CartController extends Controller
{
    public function cartAction()
    {
        $vars = [
            'title' => 'Корзина',
        ];

        $user_id = $this->user->getUserId();

        $cartModel = new Cart;

        $cart = $cartModel->getCart($user_id);

        $vars['products'] = $cart['products'];
        $vars['count'] = $cart['count'];
        $vars['total'] = $cart['total'];

        $vars['header'] = $this->getChild('CommonHeader', '');

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

    public function removeFromCartAction()
    {
        $vars = [
            'title' => 'Оформление заказа',
        ];

        $product_id = (int)filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);

        $user_id = $this->user->getUserId();

        $cartModel = new Cart;

        $result = $cartModel->removeFromCart($product_id, $user_id);

        $cart = $cartModel->getCart($user_id);

        $vars['products'] = $cart['products'];
        $vars['count'] = $cart['count'];
        $vars['total'] = $cart['total'];

        $template = 'checkout/cart.html.twig';

        $pageCart = $this->view->render($template, $vars);

        $json = [
            'success' => '1',
            'products' => $cart['products'],
            'count' => $cart['count'],
            'total' => $cart['total'],
            'pageCart' => $pageCart,
        ];

        exit(json_encode($json));
    }
}
