<?php

namespace app\controllers\Admin;

use app\core\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $vars = [
            'title' => 'Панель администратора',
        ];

        $vars['header'] = $this->getChild('Admin/CommonHeader', '');

        $template = 'admin/common/index.html.twig';

        $this->view->display($template, $vars);
    }
}