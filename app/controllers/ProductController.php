<?php

namespace app\controllers;

use app\core\Controller;

class ProductController extends Controller
{
    public function productAction()
    {
        $vars = [];

        $product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);

        $product_info = $this->model->getProduct($product_id);

        $product_info['thumb'] = getThumb($product_info['image'], 500, 500);

        $product_info['price'] = priceFormat($product_info['price']);

        $vars['title'] = $product_info['name'];

        $vars['product'] = $product_info;

        $vars['header'] = $this->getChild('CommonHeader', '');

        $template = 'product/product.html.twig';

        $this->view->display($template, $vars);
    }
}