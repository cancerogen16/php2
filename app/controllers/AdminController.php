<?php

namespace app\controllers;

use app\core\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        $vars = [
            'title' => 'Панель администратора',
        ];

        $header = new CommonController([
            'controller' => 'common',
            'action' => 'header',
        ]);

        $vars['header'] = $header->headerAction();

        $template = 'admin/common/index.html.twig';

        $this->view->display($template, $vars);
    }
}