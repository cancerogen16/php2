<?php

use Engine\Controller_Base;

class Controller_Product extends Controller_Base
{
    public function index() {
        $product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);

        $select = [
            'where' => "product_id = $product_id",
        ];

        $modelProduct = new Model\Model_Product($select);

        $product_info = $modelProduct->getProduct();

        $image_product_width = 500;
        $image_product_height = 500;
        $modelImage = new Model\Model_Image();

        require_once HELPER_DIR . 'priceFormat.php';

        if ($product_info['image']) {
            $image = $modelImage->resize($product_info['image'], $image_product_width, $image_product_height);
        } else {
            $image = $modelImage->resize('noimage.jpg', $image_product_width, $image_product_height);
        }

        $product_info['thumb'] = $image;
        $product_info['price'] = priceFormat($product_info['price']);

        $this->render('catalog/product.html.twig', [
            'title' => $product_info['name'],
            'product' => $product_info,
        ]);
    }
}