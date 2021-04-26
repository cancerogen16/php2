<?php

namespace app\controllers\Admin;

use app\core\Controller;

class OrderController extends Controller
{
    private $error = [];

    public function indexAction()
    {
        $this->getList();
    }

    public function editAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $this->model->editOrder($_GET['order_id'], $_POST);

            if (isset($_POST['apply'])) {
                $this->redirect('/admin/order/edit?order_id=' . $_GET['order_id']);
            } else {
                $this->redirect('/admin/orders');
            }
        }

        $this->getForm();
    }

    public function deleteAction()
    {
        $this->model->deleteOrder($_GET['order_id']);

        $this->redirect('/admin/orders');
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

    private function getForm() {
        $order_id = filter_input(INPUT_GET, 'order_id', FILTER_SANITIZE_SPECIAL_CHARS);

        $vars = [
            'title' => 'Редактирование заказа #' . $order_id,
        ];

        $vars['order_id'] = $order_id;

        if (isset($this->error['username'])) {
            $vars['username_err'] = $this->error['username'];
        } else {
            $vars['username_err'] = '';
        }
        if (isset($this->error['phone'])) {
            $vars['phone_err'] = $this->error['phone'];
        } else {
            $vars['phone_err'] = '';
        }
        if (isset($this->error['address'])) {
            $vars['address_err'] = $this->error['address'];
        } else {
            $vars['address_err'] = '';
        }

        if ($order_id) {
            $vars['action'] = '/admin/order/edit?order_id=' . $order_id;
        } else {
            $vars['action'] = '/admin/orders';
        }

        if ($order_id && ($_SERVER['REQUEST_METHOD'] != 'POST')) {
            $order_info = $this->model->getOrder($order_id);
        }

        $vars['statuses'] = $this->model->getOrderStatuses();

        if (isset($_POST['username'])) {
            $vars['username'] = $_POST['username'];
        } elseif (!empty($order_info)) {
            $vars['username'] = $order_info['username'];
        } else {
            $vars['username'] = '';
        }
        if (isset($_POST['phone'])) {
            $vars['phone'] = $_POST['phone'];
        } elseif (!empty($order_info)) {
            $vars['phone'] = $order_info['phone'];
        } else {
            $vars['phone'] = '';
        }
        if (isset($_POST['address'])) {
            $vars['address'] = $_POST['address'];
        } elseif (!empty($order_info)) {
            $vars['address'] = $order_info['address'];
        } else {
            $vars['address'] = '';
        }

        if (isset($_POST['order_status_id'])) {
            $vars['order_status_id'] = $_POST['order_status_id'];
        } elseif (!empty($order_info)) {
            $vars['order_status_id'] = $order_info['order_status_id'];
        } else {
            $vars['order_status_id'] = '';
        }

        $vars['order_products'] = [];

        $products = $this->model->getOrderProducts($order_id);

        foreach ($products as $product) {
            $vars['order_products'][] = array(
                'product_id' => $product['product_id'],
                'name'       => $product['name'],
                'quantity'   => $product['quantity'],
                'price'      => $product['price'],
                'total'      => $product['total'],
                'order_id'   => $product['order_id']
            );
        }

        $vars['header'] = $this->getChild('Admin/CommonHeader', '');

        $template = 'admin/sale/order_form.html.twig';

        $this->view->display($template, $vars);
    }

    private function validateForm() {
        if (trim($_POST['username']) == '') {
            $this->error['username'] = 'Имя покупателя обязательно!';
        }
        if (trim($_POST['phone']) == '') {
            $this->error['phone'] = 'Телефон покупателя обязателен!';
        }
        if (trim($_POST['address']) == '') {
            $this->error['address'] = 'Адрес покупателя обязателен!';
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}