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

        $image_product_width = 500;
        $image_product_height = 500;

        require_once DIR_HELPERS . 'tools.php';

        if ($product_info['image']) {
            $thumb = resize($product_info['image'], $image_product_width, $image_product_height);
        } else {
            $thumb = resize('noimage.jpg', $image_product_width, $image_product_height);
        }

        $product_info['thumb'] = $thumb;
        $product_info['price'] = priceFormat($product_info['price']);

        $vars['title'] = $product_info['name'];

        $vars['product'] = $product_info;

        $vars['header'] = $this->getChild('CommonHeader', '');

        $template = 'product/product.html.twig';

        $this->view->display($template, $vars);
    }
}