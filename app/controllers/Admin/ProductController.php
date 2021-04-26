<?php

namespace app\controllers\Admin;

use app\core\Controller;

class ProductController extends Controller
{
    public function indexAction()
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

        $vars['title'] = 'Редактирование товара ' . $product_info['name'];

        $vars['product'] = $product_info;

        $vars['header'] = $this->getChild('Admin/CommonHeader', '');

        $template = 'admin/catalog/product.html.twig';

        $this->view->display($template, $vars);
    }
}