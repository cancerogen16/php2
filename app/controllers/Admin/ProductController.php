<?php

namespace app\controllers\Admin;

use app\core\Controller;
use app\lib\UploadImage;

class ProductController extends Controller
{
    private $error = [];
    
    public function indexAction()
    {
        $this->getForm();
    }

    public function addAction() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $this->model->addProduct($_POST);

            $this->redirect('/admin/catalog');
        }

        $this->getForm();
    }

    public function deleteAction() {}

    public function updateAction() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['load_image'])) {
                $vars['message'] = UploadImage::uploadImage();
            } else {
                if ($this->validateForm()) {
                    $this->model->editProduct($_GET['product_id'], $_POST);

                    if (isset($_POST['apply'])) {
                        $this->redirect('/admin/product?product_id=' . $_GET['product_id']);
                    } else {
                        $this->redirect('/admin/catalog');
                    }
                }
            }
        }

        $this->getForm();
    }

    private function getForm() {
        require_once DIR_HELPERS . 'tools.php';
        
        $vars['title'] = 'Редактирование товара';

        if (isset($_GET['product_id'])) {
            $vars['action'] = '/admin/product/update?product_id=' . $_GET['product_id'];
            $vars['product_id'] = $_GET['product_id'];
        } else {
            $vars['action'] = '/admin/product/add';
            $vars['product_id'] = 0;
        }

        if (isset($_GET['product_id']) && ($_SERVER['REQUEST_METHOD'] != 'POST')) {
            $product_info = $this->model->getProduct($_GET['product_id']);
        }

        if (isset($_POST['name'])) {
            $vars['name'] = $_POST['name'];
        } elseif (!empty($product_info)) {
            $vars['name'] = $product_info['name'];
        } else {
            $vars['name'] = '';
        }
        if (isset($_POST['quantity'])) {
            $vars['quantity'] = $_POST['quantity'];
        } elseif (!empty($product_info)) {
            $vars['quantity'] = $product_info['quantity'];
        } else {
            $vars['quantity'] = 0;
        }
        if (isset($_POST['price'])) {
            $vars['price'] = $_POST['price'];
        } elseif (!empty($product_info)) {
            $vars['price'] = (int)$product_info['price'];
        } else {
            $vars['price'] = 0;
        }
        if (isset($_POST['image'])) {
            $vars['image'] = $_POST['image'];
        } elseif (!empty($product_info)) {
            $vars['image'] = $product_info['image'];
        } else {
            $vars['image'] = '';
        }

        if (isset($_POST['image']) && is_file(DIR_IMAGE . $_POST['image'])) {
            $vars['thumb'] = resize($_POST['image'], 100, 100);
        } elseif (!empty($product_info) && is_file(DIR_IMAGE . $product_info['image'])) {
            $vars['thumb'] = resize($product_info['image'], 100, 100);
        } else {
            $vars['thumb'] = resize('no_image.png', 100, 100);
        }

        if (isset($errors['name'])) {
            $vars['name_err'] = $errors['name'];
        } else {
            $vars['name_err'] = '';
        }

        $vars['header'] = $this->getChild('Admin/CommonHeader', '');

        $template = 'admin/catalog/product.html.twig';

        $this->view->display($template, $vars);
    }

    public function uploadImage() {
        if (trim($_POST['name']) == '') {
            $this->error['model'] = 'Название товара обязательно!';
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    private function validateForm() {
        if (trim($_POST['name']) == '') {
            $this->error['name'] = 'Название товара обязательно!';
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}