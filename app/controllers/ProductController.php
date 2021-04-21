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

        $restProducts = $totalProducts - count($results);

        if (!empty($results)) {
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = resize($result['image'], $image_product_width, $image_product_height);
                } else {
                    $image = resize('noimage.jpg', $image_product_width, $image_product_height);
                }

                $href = "/product?product_id={$result['product_id']}";

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

        $vars['title'] = 'Каталог товаров';
        $vars['products'] = $products;
        $vars['page'] = $page + 1;
        $vars['totalProducts'] = $totalProducts;
        $vars['restProducts'] = $restProducts;

        $header = new CommonController([
            'controller' => 'common',
            'action' => 'header',
        ]);

        $vars['header'] = $header->headerAction();

        $template = 'product/catalog.html.twig';

        $this->view->display($template, $vars);
    }

    public function categoryAction()
    {
        $vars = [];

        $this->view->display('category', $vars);
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

        $vars['title'] = $product_info['name'];

        $vars['product'] = $product_info;

        $template = 'product/product.html.twig';

        $this->view->display($template, $vars);
    }
}