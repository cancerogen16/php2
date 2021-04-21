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

        $template = 'common/header.html.twig';

        $vars['header'] = $header->view->render($template, $vars);

        $template = 'common/home.html.twig';

        $this->view->display($template, $vars);
    }
}