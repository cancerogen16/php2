<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Cart;
use app\models\Product;

class CheckoutController extends Controller
{
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
        $vars = [
            'title' => 'Оформление заказа',
        ];

        $product_id = (int)filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $quantity = (int)filter_input(INPUT_GET, 'quantity', FILTER_SANITIZE_SPECIAL_CHARS);

        $user_id = $this->user->getUserId();

        $cartModel = new Cart;

        $result = $cartModel->changeQuantity($product_id, $quantity, $user_id);

        $cart = $cartModel->getCart($user_id);

        $vars['products'] = $cart['products'];
        $vars['count'] = $cart['count'];
        $vars['total'] = $cart['total'];

        $template = 'checkout/checkout.html.twig';

        $this->view->display($template, $vars);
    }
}
