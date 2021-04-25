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

        $cartModel = new Cart;

        $cart = $cartModel->getCart($user_id);

        $image_product_width = 50;
        $image_product_height = 50;

        require_once DIR_HELPERS . 'tools.php';

        $productModel = new Product;

        $count = 0;
        $total = 0;

        $vars['products'] = [];

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

        $productModel = new Product;

        $count = 0;
        $total = 0;

        $product_info = $productModel->getProduct($product_id);

        if ($product_info) {
            $quantity = (int)filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_SPECIAL_CHARS);

            $user_id = $this->user->getUserId();

            $cartModel = new Cart;

            $result = $cartModel->add($product_id, $quantity, $user_id);

            $cart = $cartModel->getCart($user_id);

            foreach ($cart['products'] as $product_id => $quantity) {
                $product = $productModel->getProduct($product_id);

                $total += $quantity * $product['price'];

                $product['quantity'] = $quantity;
                $product['total'] = priceFormat((float)$product['price'] * $quantity);
                $product['price'] = priceFormat($product['price']);

                $count++;
            }

            $json = [
                'success' => '1',
                'products' => $cart['products'],
                'count' => $count,
                'total' => $total,
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

        $cartModel = new Cart;

        $result = $cartModel->removeFromCart($product_id, $user_id);

        $cart = $cartModel->getCart($user_id);

        $productModel = new Product;

        $count = 0;
        $total = 0;

        foreach ($cart['products'] as $product_id => $quantity) {
            $product = $productModel->getProduct($product_id);

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
