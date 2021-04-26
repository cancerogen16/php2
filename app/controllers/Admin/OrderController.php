<?php

namespace app\controllers\Admin;

use app\core\Controller;

class OrderController extends Controller
{
    public function indexAction()
    {
        $this->getList();
    }

    private function getList() {
        $vars = [
            'title' => 'Список заказов',
        ];

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

        $vars['orders'] = $this->model->getOrders($data);

        $vars['header'] = $this->getChild('Admin/CommonHeader', '');

        $template = 'admin/sale/order_list.html.twig';

        $this->view->display($template, $vars);
    }

    private function getForm() {}
}