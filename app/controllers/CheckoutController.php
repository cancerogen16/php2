<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Cart;
use app\models\Order;
use app\models\Product;

class CheckoutController extends Controller
{
    public function checkoutAction()
    {
        $vars = [
            'title' => 'Оформление заказа',
        ];

        $user_id = $this->user->getUserId();

        $cart = $this->loadModel('cart')->getCart($user_id);

        $image_product_width = 70;
        $image_product_height = 70;

        require_once DIR_HELPERS . 'tools.php';

        $count = 0;
        $total = 0;

        $vars['cart_products'] = [];

        if (!empty($cart['products'])) {
            foreach ($cart['products'] as $product_id => $quantity) {
                $product = $this->loadModel('product')->getProduct($product_id);

                $total += $quantity * $product['price'];

                if ($product['image']) {
                    $image = resize($product['image'], $image_product_width, $image_product_height);
                } else {
                    $image = resize('noimage.jpg', $image_product_width, $image_product_height);
                }

                $product['thumb'] = $image;

                $product['quantity'] = $quantity;
                $product['totalSum'] = (float)$product['price'] * $quantity;
                $product['total'] = priceFormat((float)$product['price'] * $quantity);
                $product['priceSum'] = $product['price'];
                $product['price'] = priceFormat($product['price']);

                $vars['cart_products'][] = $product;

                $count++;
            }

            $vars['count'] = $count;
            $vars['totalSum'] = $total;
            $vars['total'] = priceFormat($total);
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

        $cart = $this->loadModel('cart')->getCart($user_id);

        $image_product_width = 70;
        $image_product_height = 70;

        require_once DIR_HELPERS . 'tools.php';

        $count = 0;
        $total = 0;

        $vars['products'] = $cart['products'];

        if (!empty($cart['products'])) {
            foreach ($cart['products'] as $product_id => $quantity) {
                $product = $this->loadModel('product')->getProduct($product_id);

                $total += $quantity * $product['price'];

                if ($product['image']) {
                    $image = resize($product['image'], $image_product_width, $image_product_height);
                } else {
                    $image = resize('noimage.jpg', $image_product_width, $image_product_height);
                }

                $product['thumb'] = $image;

                $product['quantity'] = $quantity;
                $product['totalSum'] = (float)$product['price'] * $quantity;
                $product['total'] = priceFormat((float)$product['price'] * $quantity);
                $product['priceSum'] = $product['price'];
                $product['price'] = priceFormat($product['price']);

                $vars['cart_products'][] = $product;

                $count++;
            }

            $vars['count'] = $count;
            $vars['totalSum'] = $total;
            $vars['total'] = priceFormat($total);
        }

        $template = 'checkout/checkout.html.twig';

        $pageCart = $this->view->render($template, $vars);

        $json = [
            'success' => '1',
            'products' => $vars['cart_products'],
            'count' => $vars['count'],
            'total' => $vars['total'],
            'pageCart' => $pageCart,
        ];

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

        $cart = $this->loadModel('cart')->getCart($user_id);

        $image_product_width = 70;
        $image_product_height = 70;

        require_once DIR_HELPERS . 'tools.php';

        $count = 0;
        $total = 0;

        $vars['products'] = $cart['products'];

        if (!empty($cart['products'])) {
            foreach ($cart['products'] as $product_id => $quantity) {
                $product = $this->loadModel('product')->getProduct($product_id);

                $total += $quantity * $product['price'];

                if ($product['image']) {
                    $image = resize($product['image'], $image_product_width, $image_product_height);
                } else {
                    $image = resize('noimage.jpg', $image_product_width, $image_product_height);
                }

                $product['thumb'] = $image;

                $product['quantity'] = $quantity;
                $product['totalSum'] = (float)$product['price'] * $quantity;
                $product['total'] = priceFormat((float)$product['price'] * $quantity);
                $product['priceSum'] = $product['price'];
                $product['price'] = priceFormat($product['price']);

                $vars['cart_products'][] = $product;

                $count++;
            }

            $vars['count'] = $count;
            $vars['totalSum'] = $total;
            $vars['total'] = priceFormat($total);
        }

        $template = 'checkout/checkout.html.twig';

        $pageCart = $this->view->render($template, $vars);

        $json = [
            'success' => '1',
            'products' => $vars['cart_products'],
            'count' => $vars['count'],
            'total' => $vars['total'],
            'pageCart' => $pageCart,
        ];

        exit(json_encode($json));
    }
}
