<?php

namespace app\controllers;

use app\core\Controller;


class MainController extends Controller
{
    public function indexAction()
    {
        $vars = [
            'title' => 'Главная страница',
        ];

        $header = new CommonController([
            'controller' => 'common',
            'action' => 'header',
        ]);

        $vars['header'] = $header->headerAction();

        $template = 'common/home.html.twig';

        $this->view->display($template, $vars);
    }
}