<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Cart;
use app\models\Product;

class CartController extends Controller
{
    public function cartAction()
    {
        require_once DIR_HELPERS . 'tools.php';
        
        $vars = [
            'title' => 'Корзина',
        ];

        $user_id = $this->user->getUserId();

        $cart = $this->model->getCart($user_id);

        $image_product_width = 50;
        $image_product_height = 50;

        require_once DIR_HELPERS . 'tools.php';

        $count = 0;
        $total = 0;

        $vars['products'] = [];

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
            $product['total'] = priceFormat((float)$product['price'] * $quantity);
            $product['price'] = priceFormat($product['price']);

            $vars['products'][] = $product;

            $count++;
        }

        $vars['count'] = $count;
        $vars['total'] = priceFormat($total);

        $vars['header'] = $this->getChild('CommonHeader', '');

        $template = 'checkout/cart.html.twig';

        $this->view->display($template, $vars);
    }

    public function cartAddAction()
    {
        $json = [];
        
        $product_id = (int)filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);

        $count = 0;
        $total = 0;

        $product_info = $this->loadModel('product')->getProduct($product_id);

        if ($product_info) {
            require_once DIR_HELPERS . 'tools.php';

            $quantity = (int)filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_SPECIAL_CHARS);

            $user_id = $this->user->getUserId();

            $result = $this->model->add($product_id, $quantity, $user_id);

            $products = [];

            $cart = $this->model->getCart($user_id);

            if (!empty($cart['products'])) {
                $image_product_width = 40;
                $image_product_height = 40;

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

                    $products[] = $product;

                    $count++;
                }
            }

            $json = [
                'success' => '1',
                'products' => $products,
                'count' => $count,
                'total' => priceFormat($total),
            ];
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

        $count = 0;
        $total = 0;

        foreach ($cart['products'] as $product_id => $quantity) {
            $product = $this->loadModel('product')->getProduct($product_id);

            $total += $quantity * $product['price'];

            $product['quantity'] = $quantity;
            $product['total'] = priceFormat((float)$product['price'] * $quantity);
            $product['price'] = priceFormat($product['price']);

            $count++;
        }

        $vars['products'] = $cart['products'];
        $vars['count'] = $count;
        $vars['total'] = $total;

        $template = 'checkout/cart.html.twig';

        $pageCart = $this->view->render($template, $vars);

        $json = [
            'success' => '1',
            'products' => $cart['products'],
            'count' => $count,
            'total' => $total,
            'pageCart' => $pageCart,
        ];

        exit(json_encode($json));
    }
}
