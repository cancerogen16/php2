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

    public function checkoutAction()
    {
        $vars = [
            'title' => 'Оформление заказа',
        ];

        $user_id = $this->user->getUserId();

        $cartModel = new Cart;

        $cart = $cartModel->getCart($user_id);

        $vars['products'] = $cart['products'];
        $vars['count'] = $cart['count'];
        $vars['total'] = $cart['total'];

        $vars['username'] = $vars['phone'] = $vars['address'] = "";
        $vars['username_err'] = $vars['phone_err'] = $vars['address_err'] = "";

        $vars['header'] = $this->getChild('CommonHeader', '');

        $template = 'checkout/checkout.html.twig';

        $this->view->display($template, $vars);
    }

    public function changeQuantityAction()
    {
        $json = [];

        $product_id = (int)filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $quantity = (int)filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_SPECIAL_CHARS);

        $user_id = $this->user->getUserId();

        $cartModel = new Cart;

        $result = $cartModel->changeQuantity($product_id, $quantity, $user_id);

        $cart = $cartModel->getCart($user_id);

        $productModel = new Product;

        $product_info = $productModel->getProduct($product_id);

        if ($product_info) {
            $quantity = (int)filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_SPECIAL_CHARS);





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
