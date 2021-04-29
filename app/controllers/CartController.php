<?php

namespace app\controllers;

use app\core\Controller;

class CartController extends Controller
{
    public function cartAction()
    {
        $vars = [
            'title' => 'Корзина',
        ];

        $user_id = $this->user->getUserId();

        $cart = $this->model->getCart($user_id);

        $vars['count'] = 0;
        $vars['totalSum'] = 0;
        $vars['total'] = '';
        $vars['cart_products'] = [];

        if (!empty($cart['products'])) {
            $cartData = $this->loadModel('product')->getCartData($cart['products'], 50, 50);

            $vars['count'] = $cartData['count'];
            $vars['totalSum'] = $cartData['totalSum'];
            $vars['total'] = $cartData['total'];
            $vars['cart_products'] = $cartData['products'];
        }

        $vars['header'] = $this->getChild('CommonHeader', '');

        $template = 'checkout/cart.html.twig';

        $this->view->display($template, $vars);
    }

    public function cartAddAction()
    {
        $json = [];
        
        $product_id = (int)filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);

        $product_info = $this->loadModel('product')->getProduct($product_id);

        if ($product_info) {
            $quantity = (int)filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_SPECIAL_CHARS);

            $user_id = $this->user->getUserId();

            $result = $this->model->add($product_id, $quantity, $user_id);

            $cart = $this->model->getCart($user_id);

            if (!empty($cart['products'])) {
                $cartData = $this->loadModel('product')->getCartData($cart['products'], 40, 40);

                $json = [
                    'success' => '1',
                    'products' => $cartData['products'],
                    'count' => $cartData['count'],
                    'totalSum' => $cartData['totalSum'],
                    'total' => $cartData['total'],
                ];
            }
        }

        exit(json_encode($json));
    }

    public function removeFromCartAction()
    {
        $vars = [
            'title' => 'Удаление товара',
        ];

        $product_id = (int)filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);

        $user_id = $this->user->getUserId();

        $result = $this->model->removeFromCart($product_id, $user_id);

        $cart = $this->model->getCart($user_id);

        $vars['count'] = 0;
        $vars['totalSum'] = 0;
        $vars['total'] = '';
        $vars['cart_products'] = [];

        if (!empty($cart['products'])) {
            $cartData = $this->loadModel('product')->getCartData($cart['products'], 40, 40);

            $json = [
                'success' => '1',
                'products' => $cartData['products'],
                'count' => $cartData['count'],
                'totalSum' => $cartData['totalSum'],
                'total' => $cartData['total'],
            ];

            $vars['cart_products'] = $cartData['products'];
            $vars['count'] = $cartData['count'];
            $vars['totalSum'] = $cartData['totalSum'];
            $vars['total'] = $cartData['total'];
        }

        $template = 'checkout/cart.html.twig';

        $json['pageCart'] = $this->view->render($template, $vars);

        exit(json_encode($json));
    }
}
