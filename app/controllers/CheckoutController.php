<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Order;

class CheckoutController extends Controller
{
    public function checkoutAction()
    {
        $vars = [
            'title' => 'Оформление заказа',
        ];

        $user_id = $this->user->getUserId();

        $vars['count'] = 0;
        $vars['totalSum'] = 0;
        $vars['total'] = '';
        $vars['cart_products'] = [];

        if ($cart = $this->loadModel('cart')->getCart($user_id)) {
            if (!empty($cart['products'])) {
                $cartData = $this->loadModel('product')->getCartData($cart['products'], 70, 70);

                $vars['count'] = $cartData['count'];
                $vars['totalSum'] = $cartData['count'];
                $vars['total'] = $cartData['count'];
                $vars['cart_products'] = $cartData['products'];
            }
        }

        $vars['username'] = $this->user->username;
        $vars['phone'] = $vars['address'] = "";
        $vars['username_err'] = $vars['phone_err'] = $vars['address_err'] = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty(trim($_POST["username"]))) {
                $vars['username_err'] = "Введите ваше имя";
            } else {
                $vars['username'] = trim($_POST["username"]);
            }

            if (empty(trim($_POST["phone"]))) {
                $vars['phone_err'] = "Введите ваш телефон";
            } else {
                $vars['phone'] = trim($_POST["phone"]);
            }

            if (empty(trim($_POST["address"]))) {
                $vars['address_err'] = "Введите ваш адрес";
            } else {
                $vars['address'] = trim($_POST["address"]);
            }

            if (empty($vars['username_err']) && empty($vars['phone_err']) && empty($vars['address_err'])) {
                $vars['order_status_id'] = '2'; // В обработке

                $orderModel = new Order;

                $order_id = $orderModel->addOrder($vars);

                if ($order_id) {
                    $this->loadModel('cart')->delete($cart['cart_id']);

                    $this->redirect('/');
                }
            }
        }

        $vars['header'] = $this->getChild('CommonHeader', '');

        $template = 'checkout/checkout.html.twig';

        $this->view->display($template, $vars);
    }

    public function changeQuantityAction()
    {
        $vars = [
            'title' => 'Оформление заказа',
        ];

        $product_id = (int)filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $quantity = (int)filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_SPECIAL_CHARS);

        $user_id = $this->user->getUserId();

        $result = $this->loadModel('cart')->changeQuantity($product_id, $quantity, $user_id);

        $vars['count'] = 0;
        $vars['totalSum'] = 0;
        $vars['total'] = '';
        $vars['cart_products'] = [];

        if ($cart = $this->loadModel('cart')->getCart($user_id)) {
            if (!empty($cart['products'])) {
                $cartData = $this->loadModel('product')->getCartData($cart['products'], 70, 70);

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
        }

        $template = 'checkout/checkout.html.twig';

        $json['pageCart'] = $this->view->render($template, $vars);

        exit(json_encode($json));
    }

    public function removeFromCartAction()
    {
        $vars = [
            'title' => 'Удаление товара',
        ];

        $product_id = (int)filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);

        $user_id = $this->user->getUserId();

        $result = $this->loadModel('cart')->removeFromCart($product_id, $user_id);

        $vars['count'] = 0;
        $vars['totalSum'] = 0;
        $vars['total'] = '';
        $vars['cart_products'] = [];

        if ($cart = $this->loadModel('cart')->getCart($user_id)) {
            if (!empty($cart['products'])) {
                $cartData = $this->loadModel('product')->getCartData($cart['products'], 70, 70);

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
        }

        $template = 'checkout/checkout.html.twig';

        $json['pageCart'] = $this->view->render($template, $vars);

        exit(json_encode($json));
    }
}
