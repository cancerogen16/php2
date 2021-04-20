<?php

namespace app\controllers;

use app\core\Controller;

class ProductController extends Controller
{
    public function catalogAction()
    {
        $vars = [];

        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$page) {
            $page = 1;
        }

        $limit = filter_input(INPUT_GET, 'limit', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$limit) {
            $limit = 25;
        }

        $start = ($page - 1) * $limit;

        $data = [
            'start' => $start,
            'limit' => $limit,
        ];

        $products = [];

        $image_product_width = 150;
        $image_product_height = 150;

        require_once DIR_HELPERS . 'tools.php';

        $totalProducts = (int)$this->model->getTotalProducts();

        $results = $this->model->getProducts($data);

        if (!empty($results)) {
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = resize($result['image'], $image_product_width, $image_product_height);
                } else {
                    $image = resize('noimage.jpg', $image_product_width, $image_product_height);
                }

                $href = "/product/product?product_id={$result['product_id']}";

                $products[] = [
                    'product_id' => $result['product_id'],
                    'thumb' => $image,
                    'name' => $result['name'],
                    'quantity' => (int)$result['quantity'],
                    'price' => priceFormat($result['price']),
                    'price_number' => round($result['price']),
                    'href' => $href
                ];
            }
        }

        $title = 'Каталог товаров';

        $vars['products'] = $products;
        $vars['page'] = $page;
        $vars['totalProducts'] = $products;
        $vars['restProducts'] = $products;

        $this->view->render($title, $vars);
    }

    public function categoryAction()
    {
        $vars = [];

        $this->view->render('category', $vars);
    }

    public function productAction()
    {
        $vars = [];

        $product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);

        $product_info = $this->model->getProduct($product_id);

        $image_product_width = 500;
        $image_product_height = 500;

        require_once DIR_HELPERS . 'tools.php';

        if ($product_info['image']) {
            $image = resize($product_info['image'], $image_product_width, $image_product_height);
        } else {
            $image = resize('noimage.jpg', $image_product_width, $image_product_height);
        }

        $product_info['thumb'] = $image;
        $product_info['price'] = priceFormat($product_info['price']);

        $title = $product_info['name'];

        $vars['product_info'] = $product_info;

        $this->view->render($title, $vars);
    }
}