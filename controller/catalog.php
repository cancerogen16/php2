<?php

class Controller_Catalog extends Engine\Controller_Base
{
    public function index() {
        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$page) {
            $page = 1;
        }

        $limit = filter_input(INPUT_GET, 'limit', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$limit) {
            $limit = 25;
        }

        $start = ($page - 1) * $limit;

        $select = [
            'order' => 'product_id ASC',
            'limit' => "$start, $limit",
        ];

        $modelProduct = new Model\Model_Product($select);

        $results = $modelProduct->getAllRows();

        $products = [];

        $image_product_width = 150;
        $image_product_height = 150;
        $modelImage = new Model\Model_Image();

        require_once HELPER_DIR . 'priceFormat.php';

        if (!empty($results)) {
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $modelImage->resize($result['image'], $image_product_width, $image_product_height);
                } else {
                    $image = $modelImage->resize('noimage.jpg', $image_product_width, $image_product_height);
                }

                $href = "/index.php?route=product/index?product_id={$result['product_id']}";

                $products[] = [
                    'product_id'  => $result['product_id'],
                    'thumb'       => $image,
                    'name'        => $result['name'],
                    'quantity'    => (int)$result['quantity'],
                    'price'       => priceFormat($result['price']),
                    'price_number' => round($result['price']),
                    'href'        => $href
                ];
            }
        }

        $this->render('catalog/catalog.html.twig', [
            'title' => 'Каталог товаров',
            'products' => $products
        ]);
    }
}