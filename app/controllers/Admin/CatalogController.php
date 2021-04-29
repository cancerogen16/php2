<?php

namespace app\controllers\Admin;

use app\core\Controller;

class CatalogController extends Controller
{
    public function indexAction()
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

        require_once DIR_HELPERS . 'tools.php';

        $totalProducts = (int)$this->model->getTotalProducts();

        $results = $this->model->getProducts($data);

        $restProducts = $totalProducts - count($results);

        if (!empty($results)) {
            foreach ($results as $result) {
                $href = "/product?product_id={$result['product_id']}";

                $products[] = [
                    'product_id' => $result['product_id'],
                    'thumb' => getThumb($result['image'], 150, 150),
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

        $vars['header'] = $this->getChild('Admin/CommonHeader', '');

        $template = 'admin/catalog/catalog.html.twig';

        $this->view->display($template, $vars);
    }

    public function categoryAction()
    {
        // TODO
        $vars = [];

        $this->view->display('category', $vars);
    }
}